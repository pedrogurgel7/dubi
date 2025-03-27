<x-app-layout>
    <x-container>

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Questions') }}
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


            <hr class="border-gray-700 border my-4">


            <div>
                <h2 class="text-2xl font-bold">List of Questions</h2>
            </div>

            @foreach($questions as $question)
                <div>
                    <x-question :question="$question"/>
                </div>
            @endforeach
        </div>

    </x-container>
</x-app-layout>
