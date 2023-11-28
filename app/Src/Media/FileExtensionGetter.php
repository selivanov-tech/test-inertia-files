<?php

namespace App\Src\Media;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class FileExtensionGetter
{
    public const FILE_REQUEST_FIELD = 'media';

    public function __construct(
        protected readonly Request $request
    )
    {
    }

    public function getMediaCollection(): string
    {
        $firstSlug = explode('/', $this->getFile()->getMimeType())[0] ?? null;

        return match ($firstSlug) {
            'image' => 'images',
            default => 'uploads'
        };
    }

    protected function getFile(): UploadedFile
    {
        $field = static::FILE_REQUEST_FIELD;

        assert(isset($this->request->{$field}) && $this->request->{$field} instanceof UploadedFile);

        return $this->request->{$field};
    }
}
