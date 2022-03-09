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
			'name' => ['en' => 'The raid', 'ka' => 'დარბევა'],
		]);

		Movie::factory()->create([
			'name' => ['en' => 'The god father', 'ka' => 'ნათლია'],
		]);

		Movie::factory()->create([
			'name' => ['en' => 'The shawshank redemption', 'ka' => 'შაუშენკის გამოსყიდვა'],
		]);

		Quote::factory()->create([
			'movie_id'  => 1,
			'thumbnail' => 'the-raid-2-2.jpg',
			'quote'     => ['en' => 'Let\'s clean this city\'s mess!', 'ka' => 'მოდით გავწმინდოთ ამ ქალაქის არეულობა!'],
		]);

		Quote::factory()->create([
			'movie_id'  => 2,
			'thumbnail' => 'the-god-father.jpg',
			'quote'     => ['en' => 'I\'m gonna make him an offer he can\'t refuse.', 'ka' => 'მე მას შეთავაზებას გავუკეთებ, რომელზეც უარს ვერ იტყვის.'],
		]);

		Quote::factory()->create([
			'movie_id'  => 3,
			'thumbnail' => 'shawshank-2.jpg',
			'quote'     => ['en' => 'It\'s funny.', 'ka' => 'სასაცილოა.'],
		]);

		Quote::factory()->create([
			'movie_id'  => 1,
			'thumbnail' => 'the-raid-2.jpg',
			'quote'     => ['en' => 'This is what I do.', 'ka' => 'ეგ არის რასაც ვაკეთებ.'],
		]);

		Quote::factory()->create([
			'movie_id'  => 2,
			'thumbnail' => 'the-god-father-2.jpg',
			'quote'     => ['en' => 'Revenge is a dish best served cold.', 'ka' => 'შურისძიება არის კერძი, რომელიც საუკეთესოდ მიირთმევს ცივად.'],
		]);

		Quote::factory()->create([
			'movie_id'  => 3,
			'thumbnail' => 'shawshank.jpeg',
			'quote'     => ['en' => 'I think a man working outdoors feels more like a man if he can have a bottle of suds.', 'ka' => 'მე ვფიქრობ, რომ გარეთ მომუშავე მამაკაცი თავს უფრო კაცად გრძნობს, თუ მას აქვს ერთი ბოთლი პივა.'],
		]);

		User::factory()->create([
			'name'     => 'luka',
			'email'    => 'luka@gmail.com',
			'password' => bcrypt('luka123'),
		]);
	}
}
