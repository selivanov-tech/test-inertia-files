<?php

namespace App\Src\Media;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File as FileValidation;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FileUploads\HandleSpladeFileUploads;

class FileUpdater
{
    public function __construct(
        protected readonly Request             $request,
        protected readonly FileExtensionGetter $extensionGetter,
    )
    {
    }

    public function __invoke(File $fileModel): File
    {
        $fileField = $this->extensionGetter::FILE_REQUEST_FIELD;

        HandleSpladeFileUploads::forRequest($this->request);

        $this->request->validate([
            'name' => [
                'nullable',
                'string',
                'max:255'
            ],
            $fileField => [
                'exclude_unless:media_existing,null',
                'required',
                FileValidation::default()->max('8mb')
            ],
        ]);

        $callback = function () use ($fileModel, $fileField) {
            $fileModel->name = $this->request->name;

            if (null !== $this->request->media) {
                $fileModel->media->first()->delete();

                $fileModel
                    ->addMediaFromRequest($fileField)
                    ->toMediaCollection($this->extensionGetter->getMediaCollection());
            }

            $fileModel->save();

            Toast::title('File model was updated!');

            return $fileModel;
        };

        return DB::transaction($callback, 2);
    }
}
