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
                    <x-text-area name="question" label="question">

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


            <hr class="border-gray-700 border my-4">


            <div>
                <h2 class="text-2xl font-bold py-5">Drafts</h2>
            </div>
                    <x-table.table>
                        <x-table.thead>
                                <x-table.th>Question</x-table.th>
                                <x-table.th>Actions</x-table.th>
                        </x-table.thead>
                        <x-table.tbody>
                            @foreach($questions->where('draft',true) as $question)

                                <x-table.tr>
                                    <x-table.th>
                                        {{$question->question}}
                                    </x-table.th>
                                    <x-table.th>
                                        <div class="flex">
                                            <x-form put :action="route('question.publish', $question)" >
                                                <x-btn.default>Publish</x-btn.default>
                                            </x-form>

                                            <x-form delete :action="route('question.destroy', $question)" >
                                                 <x-btn.red>Delete</x-btn.red>
                                            </x-form>

                                            <a href="{{route('question.edit', $question)}}" class="ml-2">
                                                <x-btn.default>Editar</x-btn.default>
                                            </a>
                                        </div>




                                    </x-table.th>
                                </x-table.tr>
                            @endforeach

                        </x-table.tbody>


                    </x-table.table>


            <div>
                <h2 class="text-2xl font-bold py-5">Published Questions</h2>
            </div>
            <x-table.table>
                <x-table.thead>
                    <x-table.th>Question</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.thead>
                <x-table.tbody>
                    @foreach($questions->where('draft',false) as $question)

                        <x-table.tr>
                            <x-table.th>
                                {{$question->question}}
                            </x-table.th>
                            <x-table.th>
                                <div class="flex">
                                    <x-form delete :action="route('question.destroy', $question)" >
                                        <x-btn.red>Delete</x-btn.red>
                                    </x-form>
                                    <x-form patch :action="route('question.archive', $question)" >
                                        <x-btn.red>Archive</x-btn.red>
                                    </x-form>
                                </div>




                            </x-table.th>
                        </x-table.tr>
                    @endforeach

                </x-table.tbody>


            </x-table.table>







        </div>

    </x-container>
</x-app-layout>
