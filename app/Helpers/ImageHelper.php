<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Publish a file from Laravel's public disk into the web-accessible folder.
     *
     * Some legacy installations use a real public/storage directory instead
     * of Laravel's storage symlink, so both copies must be kept in sync.
     */
    public static function syncStorageFileToPublic($relativePath)
    {
        $relativePath = ltrim(str_replace('\\', '/', (string) $relativePath), '/');

        if ($relativePath === '' || !Storage::exists($relativePath)) {
            return false;
        }

        $source = Storage::path($relativePath);
        $destination = public_path('storage/' . $relativePath);
        File::ensureDirectoryExists(dirname($destination));

        if (!File::exists($destination) || realpath($source) !== realpath($destination)) {
            File::copy($source, $destination);
        }

        return true;
    }

    public static function deleteStorageFile($relativePath)
    {
        $relativePath = ltrim(str_replace('\\', '/', (string) $relativePath), '/');
        if ($relativePath === '') {
            return;
        }

        Storage::delete($relativePath);
        File::delete(public_path('storage/' . $relativePath));
    }

    /**
     * Store a settings image in the project's publicly served upload folder.
     *
     * This works whether public/storage is a real directory (legacy installs)
     * or a symlink created by `php artisan storage:link`.
     */
    public static function storePublicSettingImage($file, $path = 'images')
    {
        $directory = public_path('storage/' . trim($path, '/'));
        File::ensureDirectoryExists($directory);

        $extension = strtolower($file->getClientOriginalExtension());
        $name = 'setting_' . time() . '_' . Str::random(12) . '.' . $extension;

        $file->move($directory, $name);

        return $name;
    }

    public static function deletePublicSettingImage($name, $path = 'images')
    {
        if (empty($name)) {
            return;
        }

        $name = basename($name);

        if (in_array($name, ['placeholder.png', 'noimage.png', 'ajax_loader.gif'], true)) {
            return;
        }

        File::delete(public_path('storage/' . trim($path, '/') . '/' . $name));
    }

    public static function handleUploadedImage($file, $path, $delete = null)
    {
        if ($file) {

            if ($delete) {
                self::deleteStorageFile($path . '/' . $delete);
            }

            $name = Str::random(4) . $file->getClientOriginalName();
            Storage::putFileAs($path, $file, $name);
            self::syncStorageFileToPublic($path . '/' . $name);

            return $name;
        }
    }


    public static function uploadSummernoteImage($file, $path)
    {
        if ($file) {

            $name = 'OM_' . time() .  Str::random(8) . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs($path, $file, $name);
            self::syncStorageFileToPublic($path . '/' . $name);

            return $name;
        }
    }



    public static function ItemhandleUploadedImage($file, $path, $delete = null)
    {
        if ($file) {

            if ($delete) {
                self::deleteStorageFile($path . '/' . $delete);
            }

            $photoName = 'OM_' . time() .  Str::random(8) . '.' . $file->getClientOriginalExtension();
            $thumbnailName = 'OM_' . time() .  Str::random(8) . '.' . $file->getClientOriginalExtension();

            Storage::putFileAs($path, $file, $photoName);
            self::syncStorageFileToPublic($path . '/' . $photoName);


            $image = \Image::make($file)->resize(230, 230);


            $thumbnailPath = $path . '/' . $thumbnailName;
            Storage::put($thumbnailPath, (string) $image->encode());
            self::syncStorageFileToPublic($thumbnailPath);


            return [$photoName, $thumbnailName];
        }
    }

    public static function handleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {

        $name = 'OM_' . time() .  Str::random(8) . '.' . $file->getClientOriginalExtension();

        Storage::putFileAs($path, $file, $name);
        self::syncStorageFileToPublic($path . '/' . $name);


        if ($data[$field] != null) {
            self::deleteStorageFile($delete_path . '/' . $data[$field]);
        }

        return $name;
    }


    public static function ItemhandleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {

        $photoName = 'OM_' . time() .  Str::random(8) . '.' . $file->getClientOriginalExtension();
        $thumbnailName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();


        $image = \Image::make($file)->resize(230, 230);


        $thumbnailPath = $path . '/' . $thumbnailName;
        Storage::put($thumbnailPath, (string) $image->encode());
        self::syncStorageFileToPublic($thumbnailPath);


        $photoPath = $path . '/' . $photoName;
        Storage::putFileAs($path, $file, $photoName);
        self::syncStorageFileToPublic($photoPath);

        if (!empty($data['thumbnail'])) {
            self::deleteStorageFile($delete_path . '/' . $data['thumbnail']);
        }

        if (!empty($data[$field])) {
            self::deleteStorageFile($delete_path . '/' . $data[$field]);
        }

        return [$photoName, $thumbnailName];
    }


    public static function handleDeletedImage($data, $field, $delete_path)
    {
        if (!empty($data[$field])) {
            self::deleteStorageFile($delete_path . '/' . $data[$field]);
        }
    }
}
