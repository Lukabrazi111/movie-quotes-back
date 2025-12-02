# Movie Quotes API

A Laravel-based REST API backend for managing movies, quotes, comments, and user interactions.

## Features

- **User Authentication**: Registration, login, logout with Laravel Sanctum
- **Email Verification**: User email verification system
- **Password Reset**: Forgot password and reset functionality
- **Movies Management**: CRUD operations for movies with genres
- **Quotes Management**: Create and manage quotes for movies
- **Comments**: Add comments to quotes
- **Likes**: Like/unlike quotes
- **Media Handling**: Image uploads for movies and quotes using Spatie Media Library
- **Query Filtering**: Advanced filtering using Spatie Query Builder

## Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Authentication**: Laravel Sanctum
- **Database**: MySQL
- **Media Library**: Spatie Laravel Media Library
- **Query Builder**: Spatie Laravel Query Builder
- **Testing**: Pest PHP
- **Containerization**: Docker & Laravel Sail

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Docker & Docker Compose (optional, for Sail)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd mq-back
```

2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your `.env` file with database credentials and other settings.

6. Run migrations:
```bash
php artisan migrate
```

7. (Optional) Seed the database:
```bash
php artisan db:seed
```

## Using Docker (Laravel Sail)

1. Start the containers:
```bash
./vendor/bin/sail up -d
```

2. Install dependencies:
```bash
./vendor/bin/sail composer install
```

3. Generate application key:
```bash
./vendor/bin/sail artisan key:generate
```

4. Run migrations:
```bash
./vendor/bin/sail artisan migrate
```

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user (requires authentication)
- `GET /api/verify` - Verify user email
- `POST /api/resend-link/{id}` - Resend verification email
- `POST /api/forgot-password` - Request password reset
- `POST /api/reset-password/{token}` - Reset password

### Movies (requires authentication)
- `GET /api/movies` - Get all movies
- `GET /api/movies/{movie}` - Get a specific movie
- `POST /api/movies` - Create a new movie
- `PUT /api/movies/{movie}` - Update a movie
- `DELETE /api/movies/{movie}` - Delete a movie

### Quotes (requires authentication)
- `GET /api/quotes` - Get all quotes
- `GET /api/quotes/{quote}` - Get a specific quote
- `POST /api/movies/{movie}/quotes` - Create a quote for a movie
- `PUT /api/quotes/{quote}` - Update a quote
- `DELETE /api/quotes/{quote}` - Delete a quote

### Comments (requires authentication)
- `GET /api/quotes/{quote}/comments` - Get comments for a quote
- `POST /api/quotes/{quote}/comments` - Add a comment to a quote
- `DELETE /api/comments/{comment}` - Delete a comment

### Likes (requires authentication)
- `POST /api/quotes/{quote}/likes` - Like/unlike a quote

### Genres (requires authentication)
- `GET /api/genres` - Get all genres

### User Profile (requires authentication)
- `GET /api/user` - Get authenticated user
- `PUT /api/profile` - Update user profile

## Development

Run the development server:
```bash
php artisan serve
```

Or with Sail:
```bash
./vendor/bin/sail up
```

Run tests:
```bash
php artisan test
```

Or with Sail:
```bash
./vendor/bin/sail artisan test
```

## License

The Movie-Quotes is open-sourced project.
