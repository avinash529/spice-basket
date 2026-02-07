@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-emerald-100 bg-emerald-50/70 px-4 py-3 text-sm font-medium text-emerald-700']) }}>
        {{ $status }}
    </div>
@endif
