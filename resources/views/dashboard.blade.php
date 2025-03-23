<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-form post :action="route('question.store')">
                <x-text-area name="question" label="question"></x-text-area>
                <x-btn.green type="submit">Save</x-btn.green>
                <x-btn.default type="reset">Reset</x-btn.default>

            </x-form>


            @error('question')
            <div class="text-red-500 mt-2 text-sm">
               <span>{{ $message }}</span>
            </div>
            @enderror
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
