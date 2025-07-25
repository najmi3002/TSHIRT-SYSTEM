@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-pastel-green']) }}>
        {{ $status }}
    </div>
@endif
