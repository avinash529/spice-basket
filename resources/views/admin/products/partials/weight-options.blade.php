@php
    $initialRows = old('weight_options');

    if (! is_array($initialRows)) {
        $initialRows = [];

        if (isset($product)) {
            foreach ($product->weightOptionPairs() as $pair) {
                $initialRows[] = [
                    'label' => $pair['label'],
                    'price' => $pair['price'] === null ? '' : number_format($pair['price'], 2, '.', ''),
                ];
            }
        }
    }

    if (empty($initialRows)) {
        $initialRows = [
            ['label' => '', 'price' => ''],
        ];
    }
@endphp

<div>
    <div class="flex items-center justify-between">
        <label class="block text-sm font-medium text-stone-700">Weight Options</label>
        <button type="button" id="add-weight-option" class="rounded-full border border-emerald-200 px-4 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
            Add row
        </button>
    </div>
    <p class="mt-1 text-xs text-stone-500">Add one row per weight. Price is optional; if blank, base product price is used.</p>

    <div id="weight-options-container" class="mt-3 space-y-3">
        @foreach($initialRows as $index => $row)
            <div data-weight-row class="grid gap-3 rounded-2xl border border-stone-100 bg-stone-50/70 p-3 sm:grid-cols-[1fr_180px_auto]">
                <div>
                    <label class="block text-xs font-medium text-stone-600" for="weight_label_{{ $index }}">Weight</label>
                    <input
                        id="weight_label_{{ $index }}"
                        type="text"
                        name="weight_options[{{ $index }}][label]"
                        value="{{ $row['label'] ?? '' }}"
                        placeholder="e.g. 100g"
                        class="mt-1 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
                    />
                </div>
                <div>
                    <label class="block text-xs font-medium text-stone-600" for="weight_price_{{ $index }}">Price (INR)</label>
                    <input
                        id="weight_price_{{ $index }}"
                        type="number"
                        step="0.01"
                        min="0"
                        name="weight_options[{{ $index }}][price]"
                        value="{{ $row['price'] ?? '' }}"
                        placeholder="optional"
                        class="mt-1 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
                    />
                </div>
                <div class="flex items-end">
                    <button type="button" data-remove-weight-row class="rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">
                        Remove
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    @error('weight_options')
        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
    @enderror
    @error('weight_options.*.label')
        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
    @enderror
    @error('weight_options.*.price')
        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>

<template id="weight-option-template">
    <div data-weight-row class="grid gap-3 rounded-2xl border border-stone-100 bg-stone-50/70 p-3 sm:grid-cols-[1fr_180px_auto]">
        <div>
            <label class="block text-xs font-medium text-stone-600">Weight</label>
            <input
                type="text"
                name="weight_options[__INDEX__][label]"
                placeholder="e.g. 100g"
                class="mt-1 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
            />
        </div>
        <div>
            <label class="block text-xs font-medium text-stone-600">Price (INR)</label>
            <input
                type="number"
                step="0.01"
                min="0"
                name="weight_options[__INDEX__][price]"
                placeholder="optional"
                class="mt-1 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200"
            />
        </div>
        <div class="flex items-end">
            <button type="button" data-remove-weight-row class="rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">
                Remove
            </button>
        </div>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('weight-options-container');
        var addButton = document.getElementById('add-weight-option');
        var template = document.getElementById('weight-option-template');

        if (!container || !addButton || !template) {
            return;
        }

        var nextIndex = container.querySelectorAll('[data-weight-row]').length;

        addButton.addEventListener('click', function () {
            var html = template.innerHTML.replaceAll('__INDEX__', String(nextIndex));
            container.insertAdjacentHTML('beforeend', html);
            nextIndex += 1;
        });

        container.addEventListener('click', function (event) {
            var target = event.target;
            if (!(target instanceof HTMLElement) || !target.matches('[data-remove-weight-row]')) {
                return;
            }

            var rows = container.querySelectorAll('[data-weight-row]');
            var row = target.closest('[data-weight-row]');
            if (!row) {
                return;
            }

            if (rows.length <= 1) {
                row.querySelectorAll('input').forEach(function (input) {
                    input.value = '';
                });
                return;
            }

            row.remove();
        });
    });
</script>
