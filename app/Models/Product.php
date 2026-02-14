<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public const OFFER_MODE_NONE = 'none';
    public const OFFER_MODE_NORMAL = 'normal';
    public const OFFER_MODE_VISHU = 'vishu';
    public const OFFER_MODE_ONAM = 'onam';
    public const OFFER_MODE_CHRISTMAS = 'christmas';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'offer_mode',
        'normal_offer_percent',
        'vishu_offer_percent',
        'onam_offer_percent',
        'christmas_offer_percent',
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

    /**
     * @return array<string, string>
     */
    public static function offerModeLabels(): array
    {
        return [
            self::OFFER_MODE_NONE => 'No Offer',
            self::OFFER_MODE_NORMAL => 'Normal Offer',
            self::OFFER_MODE_VISHU => 'Vishu Offer',
            self::OFFER_MODE_ONAM => 'Onam Offer',
            self::OFFER_MODE_CHRISTMAS => 'Christmas Offer',
        ];
    }

    public function scopeWithActiveOffers(Builder $query): Builder
    {
        return $query
            ->where('offer_mode', '!=', self::OFFER_MODE_NONE)
            ->where(function (Builder $builder) {
                $builder
                    ->where(function (Builder $modeQuery) {
                        $modeQuery
                            ->where('offer_mode', self::OFFER_MODE_NORMAL)
                            ->where('normal_offer_percent', '>', 0);
                    })
                    ->orWhere(function (Builder $modeQuery) {
                        $modeQuery
                            ->where('offer_mode', self::OFFER_MODE_VISHU)
                            ->where('vishu_offer_percent', '>', 0);
                    })
                    ->orWhere(function (Builder $modeQuery) {
                        $modeQuery
                            ->where('offer_mode', self::OFFER_MODE_ONAM)
                            ->where('onam_offer_percent', '>', 0);
                    })
                    ->orWhere(function (Builder $modeQuery) {
                        $modeQuery
                            ->where('offer_mode', self::OFFER_MODE_CHRISTMAS)
                            ->where('christmas_offer_percent', '>', 0);
                    });
            });
    }

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
        return $this->discountedPrice($this->basePriceForWeight($weight));
    }

    public function basePriceForWeight(string $weight): float
    {
        $map = $this->weightPriceMap();

        return $map[$weight] ?? (float) $this->price;
    }

    public function displayPrice(): float
    {
        return $this->priceForWeight((string) $this->unit);
    }

    public function activeOfferPercent(): float
    {
        return $this->offerPercentFor((string) $this->offer_mode);
    }

    public function hasActiveOffer(): bool
    {
        return $this->activeOfferPercent() > 0;
    }

    public function activeOfferLabel(): ?string
    {
        if (! $this->hasActiveOffer()) {
            return null;
        }

        return self::offerModeLabels()[(string) $this->offer_mode] ?? null;
    }

    public function offerPercentFor(string $mode): float
    {
        $fieldByMode = [
            self::OFFER_MODE_NORMAL => 'normal_offer_percent',
            self::OFFER_MODE_VISHU => 'vishu_offer_percent',
            self::OFFER_MODE_ONAM => 'onam_offer_percent',
            self::OFFER_MODE_CHRISTMAS => 'christmas_offer_percent',
        ];

        if (! isset($fieldByMode[$mode])) {
            return 0.0;
        }

        $value = $this->{$fieldByMode[$mode]};
        if (! is_numeric($value)) {
            return 0.0;
        }

        return max(0.0, min((float) $value, 100.0));
    }

    public function discountedPrice(float $price): float
    {
        $base = max($price, 0.0);
        $percent = $this->activeOfferPercent();

        if ($percent <= 0) {
            return round($base, 2);
        }

        $discounted = $base - (($base * $percent) / 100);

        return round(max($discounted, 0.0), 2);
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
