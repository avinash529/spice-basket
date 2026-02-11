<?php

namespace App\Support;

use App\Models\Product;

class CartSynchronizer
{
    /**
     * @param array<mixed> $cart
     * @return array{
     *     cart: array<string, array<string, mixed>>,
     *     changed: bool,
     *     price_changed: bool,
     *     item_removed: bool,
     *     unit_adjusted: bool
     * }
     */
    public function sync(array $cart): array
    {
        $normalized = [];
        $changed = false;
        $priceChanged = false;
        $itemRemoved = false;
        $unitAdjusted = false;

        foreach ($cart as $key => $item) {
            if (!is_array($item) || !isset($item['id'])) {
                $changed = true;
                continue;
            }

            $productId = (int) $item['id'];
            if ($productId <= 0) {
                $changed = true;
                continue;
            }

            $product = Product::find($productId);
            if (! $product || ! $product->is_active) {
                $changed = true;
                $itemRemoved = true;
                continue;
            }

            $quantity = max((int) ($item['quantity'] ?? 1), 1);
            if ((int) ($item['quantity'] ?? 1) !== $quantity) {
                $changed = true;
            }

            $requestedUnit = trim((string) ($item['unit'] ?? $item['selected_unit'] ?? ''));
            $resolvedUnit = $this->resolveUnit($product, $requestedUnit);
            if ($requestedUnit !== '' && $requestedUnit !== $resolvedUnit) {
                $changed = true;
                $unitAdjusted = true;
            }
            if ($requestedUnit === '') {
                $changed = true;
            }

            $resolvedPrice = $product->priceForWeight($resolvedUnit);
            $storedPrice = (float) ($item['price'] ?? 0);
            if (abs($resolvedPrice - $storedPrice) > 0.00001) {
                $changed = true;
                $priceChanged = true;
            }

            $lineKey = $this->lineKey($product->id, $resolvedUnit);
            if (isset($normalized[$lineKey])) {
                $normalized[$lineKey]['quantity'] += $quantity;
                $changed = true;
                continue;
            }

            if (!is_string($key) || $key === '' || $key !== $lineKey) {
                $changed = true;
            }

            $normalized[$lineKey] = [
                'key' => $lineKey,
                'id' => $product->id,
                'name' => $product->name,
                'price' => $resolvedPrice,
                'unit' => $resolvedUnit,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
            ];
        }

        return [
            'cart' => $normalized,
            'changed' => $changed,
            'price_changed' => $priceChanged,
            'item_removed' => $itemRemoved,
            'unit_adjusted' => $unitAdjusted,
        ];
    }

    private function resolveUnit(Product $product, string $requestedUnit): string
    {
        $defaultUnit = trim((string) $product->unit);
        $weightOptions = $product->weightOptions();

        if (empty($weightOptions)) {
            if ($defaultUnit !== '') {
                return $defaultUnit;
            }

            if ($requestedUnit !== '') {
                return $requestedUnit;
            }

            return 'unit';
        }

        if ($requestedUnit !== '' && in_array($requestedUnit, $weightOptions, true)) {
            return $requestedUnit;
        }

        if ($defaultUnit !== '' && in_array($defaultUnit, $weightOptions, true)) {
            return $defaultUnit;
        }

        return $weightOptions[0];
    }

    private function lineKey(int $productId, string $weight): string
    {
        return $productId.'::'.strtolower(trim($weight));
    }
}
