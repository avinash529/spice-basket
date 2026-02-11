<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Catalog</p>
                <h2 class="font-semibold text-2xl text-stone-900 leading-tight">Add product</h2>
            </div>
            <a class="text-sm text-emerald-700" href="{{ route('admin.products.index') }}">Back to products</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('status'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 text-emerald-700">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50/70 p-4 text-sm text-rose-700">
                    Please fix the highlighted fields and submit again.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="rounded-3xl border border-stone-100 bg-white/90 p-6 shadow-lg space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700">Name</label>
                    <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="name" value="{{ old('name') }}" required />
                    @error('name')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Description</label>
                    <textarea class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Price</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required />
                        @error('price')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Unit</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="unit" value="{{ old('unit', '100g') }}" required />
                        @error('unit')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                @include('admin.products.partials.weight-options')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Stock quantity</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="number" min="0" name="stock_qty" value="{{ old('stock_qty', 0) }}" required />
                        @error('stock_qty')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Origin</label>
                        <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="origin" value="{{ old('origin') }}" />
                        @error('origin')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Image URL</label>
                    <input class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" type="text" name="image_url" value="{{ old('image_url') }}" />
                    @error('image_url')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700">Image Upload</label>
                    <input class="mt-2 w-full rounded-xl border-stone-200 bg-white px-3 py-2 text-sm" type="file" name="image_file" accept="image/*" />
                    @error('image_file')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    <p class="mt-2 text-xs text-stone-500">Upload a JPG/PNG (max 2MB). Upload overrides the URL.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Category</label>
                        <select class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="category_id" required>
                            <option value="">Select</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $selectedCategoryId ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700">Farmer</label>
                        <select class="mt-2 w-full rounded-xl border-stone-200 focus:border-emerald-400 focus:ring-emerald-200" name="farmer_id">
                            <option value="">Select</option>
                            @foreach($farmers as $farmer)
                                <option value="{{ $farmer->id }}" {{ old('farmer_id') == $farmer->id ? 'selected' : '' }}>{{ $farmer->name }}</option>
                            @endforeach
                        </select>
                        @error('farmer_id')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} />
                        Active
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} />
                        Featured
                    </label>
                </div>
                <div class="flex items-center gap-4">
                    <button class="rounded-full bg-emerald-600 px-6 py-2 text-white shadow-sm hover:bg-emerald-500" type="submit">Save</button>
                    <a class="text-sm text-stone-600" href="{{ route('admin.products.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
