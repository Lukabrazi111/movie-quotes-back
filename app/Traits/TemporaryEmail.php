<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

trait TemporaryEmail
{
    public function sendEmailWithUrl(string $routeName, object $user, $class): void
    {
        $tempUrl = $this->createTempUrl($routeName, $user);

        Mail::to($user)->send(new $class($user->username, $tempUrl));
    }

    public function createTempUrl(string $routeName, object $user): string
    {
        $tempUrl = URL::temporarySignedRoute($routeName, now()->addMinutes(15), ['user' => $user->id]);

        /**
         * TODO: update readme.md file with this info
         * so that user will add this info to .env file
         */
        $backUrl = config('app.url') . '/api';
        $frontUrl = config('app.frontend_url');

        return str_replace($backUrl, $frontUrl, $tempUrl);
    }

    /**
     * Get credential field with type
     * @param string $field
     * @return string
     */
    private function getCredentialFieldType(string $field): string
    {
        return filter_var($field, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Get user by specific field type
     * @param string $field
     * @param string $value
     * @return User|false
     */
    private function getUserByType(string $field, string $value): User|false
    {
        $user = User::where($field, $value)->first();

        if (!is_null($user)) {
            return $user;
        }

        return false;
    }
}
