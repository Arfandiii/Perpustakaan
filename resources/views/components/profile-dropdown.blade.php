@props(['active' => false])

<a {{ $attributes}}
    class="{{ $active ? 'bg-gray-200 text-gray-900' : 'hover:bg-gray-100 hover:text-gray-900'}} block px-4 py-2 text-sm text-gray-600"
    role="menuitem" tabindex="-1" id="">{{$slot}}</a>