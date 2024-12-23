<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {

	public function up(): void
	{
		Schema::create('admins', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('username')->unique();
			$table->string('password');
			$table->string('language');
			$table->timestamp('created_at')->useCurrent();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('admins');
	}
};
