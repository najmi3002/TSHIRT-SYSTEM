@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-pastel-purple focus:border-pastel-blue focus:ring-pastel-blue rounded-md shadow-sm']) }}>
