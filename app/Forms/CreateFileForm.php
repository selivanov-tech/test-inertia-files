<?php

namespace App\Forms;

use App\Src\Media\FileExtensionGetter;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\File as SpladeFile;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\SpladeForm;

class CreateFileForm extends AbstractForm
{
    public function configure(SpladeForm $form)
    {
        $form
            ->action(route('files.store'))
            ->method('POST')
            ->fill([
                //
            ]);
    }

    public function fields(): array
    {
        return [
            Input::make('name')
                ->label('File name')
                ->class('mb-4')
                ->rules(['nullable', 'string', 'max:255']),

            SpladeFile::make(FileExtensionGetter::FILE_REQUEST_FIELD)
                ->filepond() // Enables filepond
                ->preview()
                ->maxSize('8Mb')
                ->class('my-4'),

            Submit::make()
                ->label('Create')
                ->class('mt-4'),
        ];
    }
}
