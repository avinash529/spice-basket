<div class="space-y-4">
    <div>
        <label class="text-sm font-semibold text-stone-800" for="title">Title</label>
        <input id="title" type="text" name="title" value="{{ old('title', $wholesaleContent->title ?? '') }}" class="mt-2 w-full rounded-xl border-stone-200" required />
        @error('title')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-800" for="slug">Slug (optional)</label>
        <input id="slug" type="text" name="slug" value="{{ old('slug', $wholesaleContent->slug ?? '') }}" class="mt-2 w-full rounded-xl border-stone-200" />
        <p class="mt-1 text-xs text-stone-500">If blank, slug will be generated from title.</p>
        @error('slug')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-800" for="summary">Summary</label>
        <input id="summary" type="text" name="summary" value="{{ old('summary', $wholesaleContent->summary ?? '') }}" class="mt-2 w-full rounded-xl border-stone-200" />
        @error('summary')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="text-sm font-semibold text-stone-800" for="content">Content</label>
        <textarea id="content" name="content" rows="6" class="mt-2 w-full rounded-xl border-stone-200">{{ old('content', $wholesaleContent->content ?? '') }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-stone-800" for="cta_label">CTA Label</label>
            <input id="cta_label" type="text" name="cta_label" value="{{ old('cta_label', $wholesaleContent->cta_label ?? '') }}" class="mt-2 w-full rounded-xl border-stone-200" />
            @error('cta_label')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-stone-800" for="cta_url">CTA URL</label>
            <input id="cta_url" type="url" name="cta_url" value="{{ old('cta_url', $wholesaleContent->cta_url ?? '') }}" class="mt-2 w-full rounded-xl border-stone-200" />
            @error('cta_url')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label class="text-sm font-semibold text-stone-800" for="contact_email">Contact Email</label>
            <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $wholesaleContent->contact_email ?? '') }}" class="mt-2 w-full rounded-xl border-stone-200" />
            @error('contact_email')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-stone-800" for="contact_phone">Contact Phone</label>
            <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $wholesaleContent->contact_phone ?? '') }}" class="mt-2 w-full rounded-xl border-stone-200" />
            @error('contact_phone')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-stone-800" for="sort_order">Sort Order</label>
            <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $wholesaleContent->sort_order ?? 0) }}" class="mt-2 w-full rounded-xl border-stone-200" />
            @error('sort_order')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <label class="inline-flex items-center gap-2 text-sm text-stone-700">
        <input type="checkbox" name="is_active" value="1" class="rounded border-stone-300 text-emerald-600 focus:ring-emerald-200"
            @checked(old('is_active', $wholesaleContent->is_active ?? true)) />
        Active
    </label>
</div>
