<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

if (!function_exists('uploadImage')) {

    /**
     * @param Model $model
     * @param UploadedFile $file
     * @param string $collectionName
     *
     * Upload new image and delete previous one.
     */
    function uploadImage(Model $model, UploadedFile $file, string $collectionName): void
    {
        if ($model->hasMedia($collectionName)) {
            $model->clearMediaCollection($collectionName);
        }

        $model->addMedia($file)->toMediaCollection($collectionName);
    }
}
