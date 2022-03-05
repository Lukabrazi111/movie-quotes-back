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
			'thumbnail' => 'istockphoto-1124699017-170667a.jpg',
			'quote'     => ['en' => 'There are so many chicken', 'ka' => 'აქ ძალიან ბევრი ქათამია'],
		]);

		Quote::factory()->create([
			'thumbnail' => 'c58c43ZuQHzGnxeYgz3iGA.jpg',
			'quote'     => ['en' => 'Italy', 'ka' => 'იტალია'],
		]);

		Quote::factory()->create([
			'thumbnail' => 'lost-in-random-dicey.jpg',
			'quote'     => ['en' => 'Come here', 'ka' => 'მოდი აქ'],
		]);

		Quote::factory()->create([
			'thumbnail' => 'image.png',
			'quote'     => ['en' => 'There is no chickens', 'ka' => 'აქ არ არიან ქათმები'],
		]);

		Quote::factory()->create([
			'thumbnail' => 'lost-in-random-dicey.jpg',
			'quote'     => ['en' => 'Paris', 'ka' => 'პარიზი'],
		]);

		Quote::factory()->create([
			'thumbnail' => 'c58c43ZuQHzGnxeYgz3iGA.jpg',
			'quote'     => ['en' => 'Now go away', 'ka' => 'ეხლა წადი აქედან'],
		]);

		User::factory()->create([
			'name'     => 'luka',
			'email'    => 'luka@gmail.com',
			'password' => bcrypt('luka123'),
		]);
	}
}
