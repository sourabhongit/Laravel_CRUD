<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('record_logs', function (Blueprint $table) {
			$table->id();
			$table->integer('user_id')->foreign()
				->references('id')->on('users');
			$table->integer('record_id');
			$table->integer('new_status');
			$table->string('remark');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('record_logs');
	}
};
