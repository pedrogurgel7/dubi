@props([
    'action',
    'post'=>null,
    'put'=>null,
    'patch' => null,
    'delete'=>null
])
<form action="{{ $action }}" method="post">
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
