<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {

	public function up(): void
	{
		Schema::create('recruiters', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('email')->unique();
			$table->string('password');
			$table->string('linkedin_profile');
			$table->unsignedSmallInteger('new_password_account_requests');
			$table->timestamp('created_at')->useCurrent();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('recruiters');
	}
};
