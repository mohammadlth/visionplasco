<?php

namespace App\Traits;

use App\Models\Photo;
use Intervention\Image\Facades\Image;

trait Upload
{

    public function upload($file, $directory = 'image', $id = null, $is_file = true, $deleted = false, $multi = false)
    {
        if ($is_file) {
            $file_sys = 'photos/' . $file->store($directory, 'public');
        } else {
            $file_sys = $file;
        }

        if ($deleted && !$multi) {
            $this->deleteFile($deleted, $directory);
        }

        try {
            if (!is_null($id)) {
                $item = new Photo();
                $item->model_id = $id;
                $item->collection = 'photos/' . $directory;
                $item->path = $file_sys;
                $item->save();
            }

            return [
                'Success' => true,
                'File' => isset($item) ? $item->path : $file_sys
            ];

        } catch (\Exception $e) {


            return [
                'Success' => false,
                'Error' => $e->getMessage()
            ];

        }

    }

    public function deleteFile($id, $directory)
    {

        $item = Photo::where('id', $id)->where('collection', 'photos/' . $directory)->first();

        if ($item)
            $item->delete();
        else
            return true;

    }


}


