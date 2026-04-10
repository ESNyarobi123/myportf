@props([
    'name' => 'apps-24',
])

<img
    src="https://api.iconify.design/fluent-color:{{ $name }}.svg"
    alt=""
    {{ $attributes->class('size-5 shrink-0') }}
    loading="lazy"
    width="20"
    height="20"
/>
