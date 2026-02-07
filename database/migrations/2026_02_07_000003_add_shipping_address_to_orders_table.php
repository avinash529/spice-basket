<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('address_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->string('shipping_full_name')->nullable()->after('total');
            $table->string('shipping_phone', 20)->nullable()->after('shipping_full_name');
            $table->string('shipping_house_street', 500)->nullable()->after('shipping_phone');
            $table->string('shipping_district', 50)->nullable()->after('shipping_house_street');
            $table->string('shipping_pincode', 6)->nullable()->after('shipping_district');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->dropColumn([
                'address_id',
                'shipping_full_name',
                'shipping_phone',
                'shipping_house_street',
                'shipping_district',
                'shipping_pincode',
            ]);
        });
    }
};
