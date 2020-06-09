<?php

use App\Helpers\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->enum('type', Constants::TYPE_ARRAY);
            $table->enum('rent_type', Constants::RENT_TYPE_ARRAY)->default(Constants::RENT_TYPE_ARRAY[0]);
            $table->enum('property', Constants::PROPERTY_ARRAY);

            $table->string('country');
            $table->string('street');
            $table->integer('house_no');
            $table->string('post_code'); // 1100
            $table->string('state'); // favoriten
            $table->string('division'); // oberlaa
            $table->boolean('street_and_house_no_visible')->default(false);

            $table->json('photos')->nullable();

            $table->integer('area')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('build_year')->nullable();
            $table->date('available_from')->nullable();

            $table->integer('price')->nullable();
            $table->integer('rent')->nullable();
            $table->integer('deposit')->default(0);
            $table->integer('compensation')->default(0);

            $table->boolean('bathtub')->nullable();
            $table->boolean('balcony')->nullable();
            $table->boolean('terrace')->nullable();
            $table->boolean('garden')->nullable();
            $table->boolean('furnished')->nullable();
            $table->boolean('equipped_kitchen')->nullable();
            $table->boolean('lift')->nullable();
            $table->boolean('wlan')->nullable();

            $table->boolean('email_visible')->nullable();
            $table->boolean('phone_visible')->nullable();

            $table->foreignId('user_id')->constrained();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
