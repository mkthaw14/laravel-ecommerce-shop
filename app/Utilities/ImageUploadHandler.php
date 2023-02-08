<?php 

namespace App\Utilities;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageUploadHandler
{
    private $productImageDirectory = "product_images";

    public function saveImage(UploadedFile $file, $id)
    {
        $fullImagePath = null;


        $isRootPath = File::isDirectory($this->productImageDirectory);
        //dd($isMainPath);
        if(!$isRootPath)
        {
            $this->createDirectory($this->productImageDirectory, 0755, false, false);
        }

        $imagePath = $this->productImageDirectory."/".$id;

        $imagePathExists = File::isDirectory($imagePath);

        if($imagePathExists)
        {
            File::deleteDirectory($imagePath); // This is for replacing new directory and image in future
        }


        $this->createDirectory($imagePath, 0755, false, false);

        $fileName = time().".".$file->extension();
        $file->move(public_path($imagePath."/"), $fileName);
        $fullImagePath = $imagePath."/".$fileName;

        return $fullImagePath;
        //dd($directoryCreated);
    }

    public function createDirectory($path, $m, $createParent, $overwriteIfExists)
    {
        $success = File::makeDirectory($path, $mode = $m, $createParent, $overwriteIfExists); // mode 0755 is giving full permission to owner
        // first parameter false is not to create parent directory even is not exist
        // second parameter false is not to overwrite directory if already exists

        return $success;
    }

    public function deleteImage($id)
    {
        return File::deleteDirectory($this->productImageDirectory."/".$id);
    }
}

?>