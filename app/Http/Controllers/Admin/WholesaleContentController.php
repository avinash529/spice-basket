<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WholesaleContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WholesaleContentController extends Controller
{
    public function index(): View
    {
        $contents = WholesaleContent::query()
            ->orderBy('sort_order')
            ->orderByDesc('is_active')
            ->latest()
            ->paginate(10);

        return view('admin.wholesale-content.index', compact('contents'));
    }

    public function create(): View
    {
        return view('admin.wholesale-content.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? '') ?: $data['title']);
        $data['is_active'] = $request->boolean('is_active');

        WholesaleContent::query()->create($data);

        return redirect()->route('admin.wholesale-content.index')->with('status', 'Wholesale content created.');
    }

    public function edit(WholesaleContent $wholesaleContent): View
    {
        return view('admin.wholesale-content.edit', compact('wholesaleContent'));
    }

    public function update(Request $request, WholesaleContent $wholesaleContent): RedirectResponse
    {
        $data = $this->validated($request, $wholesaleContent);
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? '') ?: $data['title'], $wholesaleContent->id);
        $data['is_active'] = $request->boolean('is_active');

        $wholesaleContent->update($data);

        return redirect()->route('admin.wholesale-content.index')->with('status', 'Wholesale content updated.');
    }

    public function destroy(WholesaleContent $wholesaleContent): RedirectResponse
    {
        $wholesaleContent->delete();

        return redirect()->route('admin.wholesale-content.index')->with('status', 'Wholesale content deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?WholesaleContent $wholesaleContent = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('wholesale_contents', 'slug')->ignore($wholesaleContent?->id),
            ],
            'summary' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'cta_label' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'url', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug(trim($value));
        if ($base === '') {
            $base = 'wholesale-content';
        }

        $slug = $base;
        $count = 2;

        while (
            WholesaleContent::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$count;
            $count++;
        }

        return $slug;
    }
}
