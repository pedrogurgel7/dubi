
@props(
[
    'title'=>"Titulo Padrão"
    ])

<div>
    <div class="text-black font-bold uppercase p-2">
        {{$title}}
    </div>
    <div class="text-lg mt-1 text-red-500 font-bold p-20 bg-white shadow-xl border-gray-100">
        {{$slot}}
    </div>

</div>
