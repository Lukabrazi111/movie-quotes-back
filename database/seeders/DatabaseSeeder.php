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
		Movie::factory()->create([
			'name' => ['en' => 'This is mine', 'ka' => 'ეს ჩემია'],
		]);

		Movie::factory()->create([
			'name' => ['en' => 'Georgia', 'ka' => 'საქართველო'],
		]);

		Movie::factory()->create([
			'name' => ['en' => 'Get out', 'ka' => 'გადი'],
		]);

		Quote::factory()->create([
			'quote' => ['en' => 'There are so many chicken', 'ka' => 'აქ ძალიან ბევრი ქათამია'],
		]);

		Quote::factory()->create([
			'quote' => ['en' => 'Italy', 'ka' => 'იტალია'],
		]);

		Quote::factory()->create([
			'quote' => ['en' => 'Come here', 'ka' => 'მოდი აქ'],
		]);

		Quote::factory()->create([
			'quote' => ['en' => 'There is no chickens', 'ka' => 'აქ არ არიან ქათმები'],
		]);

		Quote::factory()->create([
			'quote' => ['en' => 'Paris', 'ka' => 'პარიზი'],
		]);

		Quote::factory()->create([
			'quote' => ['en' => 'Now go away', 'ka' => 'ეხლა წადი აქედან'],
		]);

		User::factory()->create([
			'name'     => 'luka',
			'email'    => 'luka@gmail.com',
			'password' => bcrypt('luka123'),
		]);
	}
}
