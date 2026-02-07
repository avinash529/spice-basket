<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'weight',
        'image',
        'is_featured',
        'stock_status',
        'category_id',
        'farmer_id',
        'unit',
        'stock_qty',
        'origin',
        'image_url',
        'is_active',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(FarmerPurchase::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class)->latest();
    }

    /**
     * @return list<string>
     */
    public function weightOptions(): array
    {
        if (! is_string($this->weight) || trim($this->weight) === '') {
            return [];
        }

        return array_keys($this->parsedWeightPricing());
    }

    /**
     * @return array<string, float>
     */
    public function weightPriceMap(): array
    {
        $map = [];

        foreach ($this->parsedWeightPricing() as $weight => $price) {
            if (is_numeric($price)) {
                $map[$weight] = (float) $price;
            }
        }

        return $map;
    }

    /**
     * @return list<array{label: string, price: float|null}>
     */
    public function weightOptionPairs(): array
    {
        $pairs = [];

        foreach ($this->parsedWeightPricing() as $weight => $price) {
            $pairs[] = [
                'label' => $weight,
                'price' => $price,
            ];
        }

        return $pairs;
    }

    public function priceForWeight(string $weight): float
    {
        $map = $this->weightPriceMap();

        return $map[$weight] ?? (float) $this->price;
    }

    /**
     * @return array<string, float|null>
     */
    private function parsedWeightPricing(): array
    {
        $raw = trim((string) $this->weight);
        if ($raw === '') {
            return [];
        }

        if (str_starts_with($raw, '{')) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $parsed = [];
                foreach ($decoded as $weight => $price) {
                    $label = trim((string) $weight);
                    if ($label === '') {
                        continue;
                    }
                    $parsed[$label] = is_numeric($price) ? (float) $price : null;
                }

                return $parsed;
            }
        }

        if (str_starts_with($raw, '[')) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $parsed = [];
                foreach ($decoded as $value) {
                    if (! is_scalar($value)) {
                        continue;
                    }
                    $label = trim((string) $value);
                    if ($label !== '') {
                        $parsed[$label] = null;
                    }
                }

                return $parsed;
            }
        }

        $segments = preg_split('/[\r\n,]+/', $raw) ?: [];
        $parsed = [];

        foreach ($segments as $segment) {
            $token = trim($segment);
            if ($token === '') {
                continue;
            }

            if (preg_match('/^(.+?)\s*(?:=|:|\|)\s*([0-9]+(?:\.[0-9]{1,2})?)$/', $token, $matches)) {
                $label = trim($matches[1]);
                $price = (float) $matches[2];
                if ($label !== '') {
                    $parsed[$label] = $price;
                }

                continue;
            }

            $parsed[$token] = null;
        }

        return $parsed;
    }
}
