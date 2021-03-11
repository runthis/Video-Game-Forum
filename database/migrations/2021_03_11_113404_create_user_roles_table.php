<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserRole;

class CreateUserRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_roles', function (Blueprint $table) {
			$table->id();
			$table->string('name', 255);
			$table->timestamps();
		});

		UserRole::create(['name' => 'user']);
		UserRole::create(['name' => 'staff']);
		UserRole::create(['name' => 'admin']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_roles');
	}
}
