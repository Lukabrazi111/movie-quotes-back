<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		Movie::factory(3)->create();
		Quote::factory(3)->create();

		User::factory()->create([
			'name'     => 'luka',
			'email'    => 'luka@gmail.com',
			'password' => bcrypt('luka123'),
		]);
	}
}
