@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-primary bg-accent/10 focus:bg-light text-accent focus:border-primary focus:border-primary focus:ring-primary rounded-md shadow-sm']) }}>
