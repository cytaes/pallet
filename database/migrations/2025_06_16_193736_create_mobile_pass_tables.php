<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_passes', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('builder_name');
            $table->json('content');
            $table->json('images');
            $table->nullableMorphs('model');
            $table->timestamps();
        });

        Schema::create('mobile_pass_devices', function (Blueprint $table): void {
            $table->string('id')->primary();

            $table->string('push_token');

            $table->timestamps();
        });

        Schema::create('mobile_pass_registrations', function (Blueprint $table): void {
            $table->uuid('id')->primary();

            $table->string('device_id');
            $table->foreign('device_id')->references('id')->on('mobile_pass_devices');

            $table->string('pass_type_id');
            $table->uuid('pass_serial');
            $table->foreign('pass_serial')->references('id')->on('mobile_passes');

            $table->timestamps();

            $table->index(['device_id', 'pass_serial']);
            $table->index(['device_id', 'pass_type_id']);
        });
    }
};
