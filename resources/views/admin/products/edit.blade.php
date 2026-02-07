<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Catalog</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Edit product</h2>
            </div>
            <a class="text-sm text-emerald-700" href="{{ route('admin.products.index') }}">Back to products</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-stone-700">Name</label>
                    <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="name" value="{{ old('name', $product->name) }}" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Description</label>
                    <textarea class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Price</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Unit</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="unit" value="{{ old('unit', $product->unit) }}" required />
                    </div>
                </div>
                @include('admin.products.partials.weight-options', ['product' => $product])
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Stock quantity</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="number" name="stock_qty" value="{{ old('stock_qty', $product->stock_qty) }}" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Origin</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="origin" value="{{ old('origin', $product->origin) }}" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Image URL</label>
                    <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="image_url" value="{{ old('image_url', $product->image_url) }}" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Image Upload</label>
                    <input class="mt-2 w-full rounded-xl border-stone-200 bg-white px-3 py-2 text-sm" type="file" name="image_file" accept="image/*" />
                    @error('image_file')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    <p class="mt-2 text-xs text-stone-500">Upload a JPG/PNG (max 2MB). Upload overrides the URL.</p>
                </div>
                @php
                    $preview = $product->image_url;
                    if ($preview) {
                        if (\Illuminate\Support\Str::startsWith($preview, ['http://', 'https://'])) {
                            $preview = $preview;
                        } elseif (\Illuminate\Support\Str::startsWith($preview, ['storage/', 'images/'])) {
                            $preview = asset($preview);
                        } else {
                            $preview = asset('storage/' . $preview);
                        }
                    }
                @endphp
                @if($preview)
                    <div class="rounded-2xl border border-stone-100 bg-stone-50 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Current image</p>
                        <img src="{{ $preview }}" alt="{{ $product->name }}" class="mt-3 h-40 w-full rounded-xl object-cover" />
                    </div>
                @endif
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Category</label>
                        <select class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="category_id" required>
                            <option value="">Select</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Farmer</label>
                        <select class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="farmer_id">
                            <option value="">Select</option>
                            @foreach($farmers as $farmer)
                                <option value="{{ $farmer->id }}" {{ old('farmer_id', $product->farmer_id) == $farmer->id ? 'selected' : '' }}>{{ $farmer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} />
                        Active
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} />
                        Featured
                    </label>
                </div>
                <div class="flex items-center gap-4">
                    <button class="rounded-full bg-emerald-600 px-6 py-2 text-white shadow-sm hover:bg-emerald-500" type="submit">Update</button>
                    <a class="text-sm text-stone-600" href="{{ route('admin.products.index') }}">Cancel</a>
                </div>
            </form>

            <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                <form method="POST" action="{{ route('admin.products.stock', $product) }}" class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg space-y-4">
                    @csrf
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Inventory</p>
                            <h3 class="text-lg font-semibold text-stone-900">Add stock (purchase)</h3>
                        </div>
                        <span class="text-sm text-stone-500">Current: {{ $product->stock_qty }} {{ $product->unit }}</span>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-stone-700">Farmer</label>
                            <select class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="farmer_id" required>
                                <option value="">Select</option>
                                @foreach($farmers as $farmer)
                                    <option value="{{ $farmer->id }}">{{ $farmer->name }}</option>
                                @endforeach
                            </select>
                            @error('farmer_id')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700">Quantity</label>
                            <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required />
                            @error('quantity')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-stone-700">Unit</label>
                            <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="unit" value="{{ old('unit', $product->unit) }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700">Price per unit</label>
                            <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="number" step="0.01" min="0" name="price_per_unit" value="{{ old('price_per_unit') }}" />
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-stone-700">Purchased at</label>
                            <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="date" name="purchased_at" value="{{ old('purchased_at', now()->toDateString()) }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700">Notes</label>
                            <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="notes" value="{{ old('notes') }}" />
                        </div>
                    </div>
                    <button class="rounded-full bg-emerald-600 px-6 py-2 text-white shadow-sm hover:bg-emerald-500" type="submit">Add stock</button>
                </form>

                <div class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Recent purchases</p>
                            <h3 class="text-lg font-semibold text-stone-900">Ledger</h3>
                        </div>
                        <span class="text-sm text-stone-500">{{ $purchases->count() }} entries</span>
                    </div>
                    <div class="mt-4 space-y-3 text-sm">
                        @forelse($purchases as $purchase)
                            <div class="flex items-center justify-between gap-3 border-b border-stone-100 pb-3">
                                <div>
                                    <p class="font-semibold text-stone-800">{{ $purchase->quantity }} {{ $purchase->unit ?? $product->unit }}</p>
                                    <p class="text-stone-500">{{ $purchase->farmer?->name ?? 'Farmer' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-stone-700">{{ optional($purchase->purchased_at)->format('M d, Y') ?? $purchase->created_at->format('M d, Y') }}</p>
                                    @if($purchase->price_per_unit)
                                        <p class="text-stone-500">INR {{ number_format($purchase->price_per_unit, 2) }} / unit</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-stone-500">No purchases recorded yet.</p>
                        @endforelse
                    </div>

                    <div class="border-t border-stone-100 pt-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Inventory</p>
                                <h3 class="text-lg font-semibold text-stone-900">Stock movements</h3>
                            </div>
                            <span class="text-sm text-stone-500">{{ $movements->count() }} entries</span>
                        </div>
                        <div class="mt-4 space-y-3 text-sm">
                            @forelse($movements as $movement)
                                <div class="flex items-center justify-between gap-3 border-b border-stone-100 pb-3">
                                    <div>
                                        <p class="font-semibold text-stone-800">
                                            {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }} {{ $product->unit }}
                                        </p>
                                        <p class="text-stone-500">{{ ucfirst($movement->source_type ?? 'manual') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-stone-700">{{ $movement->created_at->format('M d, Y') }}</p>
                                        @if($movement->note)
                                            <p class="text-stone-500">{{ $movement->note }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-stone-500">No movements yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
