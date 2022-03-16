<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'create:user';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This artisan command create user';

	/**
	 * Create a new command instance.
	 *
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$name = $this->ask('Name: ');
		$email = $this->ask('Email: ');
		$password = $this->ask('Password: ');

		User::factory()->create([
			'name'     => $name,
			'email'    => $email,
			'password' => Hash::make($password),
		]);

		$this->info('Admin account created successfully!');
	}
}
