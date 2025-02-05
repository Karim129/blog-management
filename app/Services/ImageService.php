<?php

namespace App\Services;

class ImageService
{
    public static function upload($image, $folder): string
    {

        if ($image === null) {
            throw new \InvalidArgumentException('Cannot upload null image.'); // If the image is null, throw an exception.
        }

        // Generate a unique filename based on the current time and a random string.
        $imagePath = time().uniqid().'.'.$image->extension(); // Determine the file's extension based on the file's MIME type...

        // The full path to the target directory.
        $path = public_path("storage/$folder");

        // Move the file to the target directory.
        try {
            $image->move($path, $imagePath, true); // Move the file with overwrite enabled to improve performance.
        } catch (\Throwable $e) {
            throw new \RuntimeException('Unable to upload image.', 0, $e); // If the image cannot be moved, throw an exception.
        }

        // Return the path to the uploaded file.
        return "storage/$folder/$imagePath";
    }

    public static function delete($image)
    {
        if (file_exists($image)) {
            unlink(public_path($image));

            return true;
        }

        return false;
    }
}
