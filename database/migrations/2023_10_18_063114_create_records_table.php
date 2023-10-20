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
		Schema::create('records', function (Blueprint $table) {
			$table->id();
			$table->date('date');
			$table->string('type');
			$table->string('description');
			$table->integer('debit')->default('0');
			$table->integer('credit')->default('0');
			$table->boolean('status')->default('0');
			$table->string('modify_by');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('records');
	}
};
