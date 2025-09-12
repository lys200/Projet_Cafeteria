@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-accent']) }}>
    {{ $value ?? $slot }}
</label>
