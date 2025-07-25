@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-left text-base font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700 focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-700 hover:border-gray-600 focus:outline-none focus:text-gray-200 focus:bg-gray-700 focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
