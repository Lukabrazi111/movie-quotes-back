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
         * Extract query parameters (signature, expires, user) from the signed URL.
         * The signature in Laravel is calculated based on the route path and parameters,
         * not the domain. We extract the query params and construct a frontend-friendly URL.
         */
        $parsedUrl = parse_url($tempUrl);

        $queryParams = $parsedUrl['query'] ?? '';
        $routePath = $parsedUrl['path'] ?? '';

        // Remove /api prefix for frontend URL
        $frontendPath = str_replace('/api', '', $routePath);

        $frontUrl = rtrim(config('app.frontend_url'), '/');

        return (string) $frontUrl . $frontendPath . '?' . $queryParams;
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
