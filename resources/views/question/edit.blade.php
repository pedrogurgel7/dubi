<x-app-layout>
    <x-container>

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Questions') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <x-form put :action="route('question.update', $question)">
                    <x-text-area name="question" label="question">
                        {{$question->question}}
                    </x-text-area>
                    <x-btn.green type="submit">Save</x-btn.green>
                    <x-btn.default type="reset">Reset</x-btn.default>

                </x-form>


                @error('question')
                <div class="text-red-500 mt-2 text-sm">
                    <span>{{ $message }}</span>
                </div>
                @enderror
            </div>









        </div>
        </x-container>
</x-app-layout>
