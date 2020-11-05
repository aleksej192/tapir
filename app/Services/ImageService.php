<?php


namespace App\Services;


use App\Models\Announcement;
use App\Models\Image;
use \Illuminate\Support\Collection;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class ImageService
{

    public function create(Announcement $announcement, array $paths): Collection
    {
        $collection = collect();
        foreach ($paths as $path) {
            $image = Image::create([
                'path' => $path,
                'announcement_id' => $announcement->id
            ]);
            $collection->add($image);
        }
        return $collection;
    }

    public function uploadImages(Collection $images)
    {
        $images->map([$this, 'uploadImage']);
    }

    public function uploadImage(Image $image)
    {
        $dir = $this->getDirectory($image);
        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        $filename = $this->getFileName($image);
        Storage::put($filename, file_get_contents($image->path));
        $image->update([
            'path' => $filename,
            'is_uploaded' => 1,
        ]);
    }

    private function getDirectory(Image $image): string
    {
        return 'public/announcements/'.$image->announcement->id;
    }

    private function getFileName(Image $image): string
    {
        return $this->getDirectory($image).'/images/image'.$image->id.'.'.pathinfo($image->path, PATHINFO_EXTENSION);
    }

}
