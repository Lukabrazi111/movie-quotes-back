[comment]: <> (<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>)

[comment]: <> (<p align="center">)

[comment]: <> (<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>)

[comment]: <> (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>)

[comment]: <> (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>)

[comment]: <> (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>)

[comment]: <> (</p>)

## About Movie Quote App

This is an app for movies and their quotes that you can edit, delete and add if you are an admin. The page has multi language functionality, these languages are:

- English
- Georgian

### Built with
- [Laravel](https://laravel.com/)
- [Tailwind](https://tailwindcss.com/)

## Getting Started
1. clone Movie quote repository from github:
```
git clone https://github.com/RedberryInternship/lukabrazi-movie-quotes
```
2. Next step requires you to run **composer install** in order to install all dependencies:
```
composer install
```
3. After you have to install all the JS dependencies:
```
npm install
```
4. Now we need to set our **.env** file. Go to the root of your project and execute this command:
```
cp .env.example .env
```
This command should provide **.env** file all the necessary environment variables.

## Mysql

Now we need to provide **.env** file all necessary environment variables.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

After setting up **.env** file, execute:
```
php artisan key:generate
```
Which generates auth key.

### Seed database migration
Make SQLITE or MYSQL database user and connect to this project, then you can execute the command:
```
php artisan migrate:fresh --seed
```

## Database Diagram
- **[Diagram](https://drawsql.app/redberry-15/diagrams/movie-quote)**

## Security Vulnerabilities

If you discover a security vulnerability within Movie App, please send an e-mail to Luka Khangoshvili via [lukabrazi@redberry.ge](mailto:lukabrazi@redberry.ge). All security vulnerabilities will be promptly addressed.

## License

The Movie App is open-sourced web app.
