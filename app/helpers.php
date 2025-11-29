<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;

if (!function_exists('uploadImage')) {

    /**
     * Upload new image and delete previous one.
     *
     * @param Model $model
     * @param UploadedFile $file
     * @param string $collectionName
     */
    function uploadImage(Model $model, UploadedFile $file, string $collectionName): void
    {
        if ($model instanceof HasMedia && $model->hasMedia($collectionName)) {
            $model->clearMediaCollection($collectionName);
        }

        $model->addMedia($file)->toMediaCollection($collectionName);
    }
}

if (!function_exists('getFrontendUrl')) {
    /**
     * Get frontend URL from backend URL.
     *
     * @param string $url
     * @throws InvalidArgumentException
     * @return string
     */
    function getFrontendUrl(string $url): string
    {
        $parsedUrl = parse_url($url);

        if ($parsedUrl === false) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        $routePath = $parsedUrl['path'] ?? '';
        $queryParams = $parsedUrl['query'] ?? '';
        $frontendPath = preg_replace('#^/api#', '', $routePath);
        $frontUrl = rtrim(config('app.frontend_url'), '/');

        if ($queryParams && $queryParams !== '') {
            return (string) $frontUrl . $frontendPath . '?' . $queryParams;
        }

        return (string) $frontUrl . $frontendPath;
    }
}
