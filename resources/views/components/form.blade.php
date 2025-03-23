@props([
    'action',
    'post'=>null,
    'put'=>null,
    'patch' => null,
    'delete'=>null
])
<form method="post" action="{{route('question.store')}}">
    @csrf

    @if($put)
        @method('PUT')
    @endif

    @if($put)
        @method('PATCH')
    @endif

    @if($delete)
        @method('DELETE')
    @endif

    {{$slot}}
</form>
