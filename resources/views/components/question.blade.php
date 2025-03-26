@props(
[
    'question'
]
)

<div class="rounded bg-white shadow shadow-blue-500/50  p-4 mb-4 flex justify-between items-center">
    <span>
        {{ $question->question }}

    </span>
    <div  class="flex items-center space-x-2">
            <x-form post action="{{ route('question.like', $question) }}" class="flex items-center space-x-2">

                <button class="flex items-start space-x-1 text-green-500" type="submit">
                    <x-icons.thumbs-up class="w-5 h-5  hover:text-green-300 cursor-pointer"/>
                    <span>{{ $question->votes_sum_like ?: 0}}</span>
                </button>


            </x-form>

        <x-form :action="route('question.unlike', $question)">
            <button class="flex items-start space-x-1 text-red-500">
                <x-icons.thumbs-down class="w-5 h-5 hover:text-red-300 cursor-pointer"/>
                <span>{{$question->votes_sum_unlike ?: 0}}</span>
            </button>
        </x-form>


    </div>

</div>
