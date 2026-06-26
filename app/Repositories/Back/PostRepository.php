<?php

namespace App\Repositories\Back;

use App\{
    Models\Post,
    Helpers\ImageHelper
};
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostRepository
{

    /**
     * Store post.
     *
     * @param  \App\Http\Requests\ImageStoreRequest  $request
     * @return void
     */

    public function store($request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->title);
        if ($request->has('tags')) {
            $input['tags'] = str_replace(["value", "{", "}", "[", "]", ":", "\""], '', $request->tags);
        }
        if ($request->hasFile('photo')) {
            $input['photo'] = json_encode($this->storeImageData($request), true);
        }


        Post::create($input);
    }

    /**
     * Update post.
     *
     * @param  \App\Http\Requests\ImageUpdateRequest  $request
     * @return void
     */

    public function update($post, $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->title);
        if ($request->has('tags')) {
            $input['tags'] = str_replace(["value", "{", "}", "[", "]", ":", "\""], '', $request->tags);
        }
        if ($request->hasFile('photo')) {
            $input['photo'] = json_encode($this->UpdateImageData($request, $post), true);
        }
        $post->update($input);
    }


    public function storeImageData($request)
    {

        if ($photo = $request->file('photo')) {
            return [$this->storeMainImage($photo)];
        }

        return [];
    }

    public function UpdateImageData($request, $post)
    {

        $storeData = json_decode($post->photo, true) ?: [];

        if ($photo = $request->file('photo')) {
            foreach ($storeData as $oldPhoto) {
                Storage::delete("images" . '/' . $oldPhoto);
                File::delete(public_path('storage/images/' . $oldPhoto));
            }

            return [$this->storeMainImage($photo)];
        }

        return $storeData;
    }

    public function syncPublicImages($post)
    {
        $photos = json_decode($post->photo, true) ?: [];

        foreach ($photos as $photo) {
            $this->publishStoredImage($photo);
        }
    }

    private function storeMainImage($photo)
    {
        $fileName = ImageHelper::handleUploadedImage($photo, 'images');
        $this->publishStoredImage($fileName);

        return $fileName;
    }

    private function publishStoredImage($fileName)
    {
        if (!$fileName) {
            return;
        }

        $storedPath = storage_path('app/public/images/' . $fileName);
        $publicPath = public_path('storage/images/' . $fileName);

        if (File::exists($publicPath) || !File::exists($storedPath)) {
            return;
        }

        File::ensureDirectoryExists(dirname($publicPath));
        File::copy($storedPath, $publicPath);
    }


    /**
     * Delete post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($post)
    {
        $images = json_decode($post->photo, true);
        foreach ($images as $image) {
            // if (file_exists(base_path('../').'assets/images/'.$image)) {
            //     unlink(base_path('../').'assets/images/'.$image);
            // }
            Storage::delete("images" . '/' . $image);
        }
        $post->delete();
    }

    /**
     * Delete post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function photoDelete($key, $id)
    {
        $post = Post::findOrFail($id);
        $photos = json_decode($post->photo, true);
        $delete_photo = $photos[$key];

        Storage::delete("images" . '/' . $delete_photo);
       
        unset($photos[$key]);
        $new_photos = json_encode($photos, true);
        $post->update(['photo' => $new_photos]);
    }
}
