<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('offer_mode')->default('none')->after('price');
            $table->decimal('normal_offer_percent', 5, 2)->nullable()->after('offer_mode');
            $table->decimal('vishu_offer_percent', 5, 2)->nullable()->after('normal_offer_percent');
            $table->decimal('onam_offer_percent', 5, 2)->nullable()->after('vishu_offer_percent');
            $table->decimal('christmas_offer_percent', 5, 2)->nullable()->after('onam_offer_percent');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'offer_mode',
                'normal_offer_percent',
                'vishu_offer_percent',
                'onam_offer_percent',
                'christmas_offer_percent',
            ]);
        });
    }
};
