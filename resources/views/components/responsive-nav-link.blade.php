@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-emerald-500 bg-emerald-50 py-2 ps-3 pe-4 text-start text-base font-medium text-emerald-700 focus:border-emerald-600 focus:bg-emerald-100 focus:text-emerald-800 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full border-l-4 border-transparent py-2 ps-3 pe-4 text-start text-base font-medium text-stone-600 hover:border-stone-300 hover:bg-stone-50 hover:text-stone-800 focus:border-stone-300 focus:bg-stone-50 focus:text-stone-800 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
