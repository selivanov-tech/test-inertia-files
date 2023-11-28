<?php

namespace App\Src\Media;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Toast;

class FileUploader
{
    public function __construct(
        protected readonly Request             $request,
        protected readonly FileExtensionGetter $extensionGetter
    )
    {
    }

    public function __invoke(): File
    {
        $fileField = $this->extensionGetter::FILE_REQUEST_FIELD;

        $this->request->validate([
            'id' => ['nullable', 'exists:file,id'],
            'name' => ['nullable', 'string', 'max:255'],
            $fileField => ['file', 'required_without:id'],
        ]);

        $callback = function () use ($fileField) {
            $fileModel = File::create($this->request->all());

            $fileModel
                ->addMediaFromRequest($fileField)
                ->toMediaCollection($this->extensionGetter->getMediaCollection());

            Toast::title('Your file was uploaded!');

            return $fileModel;
        };

        return DB::transaction($callback, 2);
    }
}
