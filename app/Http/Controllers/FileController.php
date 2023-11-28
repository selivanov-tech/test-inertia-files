<?php

namespace App\Http\Controllers;

use App\Forms\CreateFileForm;
use App\Models\File;
use App\Src\Media\FileUpdater;
use App\Src\Media\FileUploader;
use App\Tables\FilesTable;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\FileUploads\ExistingFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    public function index()
    {
        return view('pages.files.index', [
            'files' => FilesTable::class
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.files.create', [
            'form' => CreateFileForm::class
        ]);
    }

    public function download(File $file): BinaryFileResponse
    {
        $mediaItem = $file->media->first();

        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    public function store(FileUploader $fileUploader)
    {
        call_user_func($fileUploader);

        return redirect()->route('files.index');
    }

    public function edit(File $file)
    {
        $mediaPath = $file->media->first()->getPathRelativeToRoot();

        return view('pages.files.edit', [
            'file' => $file,
            'name' => $file->name,
            'media' => ExistingFile::fromDisk('public')->get($mediaPath)
        ]);
    }

    public function update(File $file, FileUpdater $fileUpdater)
    {
        return redirect()->route('files.edit', $fileUpdater($file));
    }

    public function destroy(File $file)
    {
        $file->delete();

        Toast::title('File was deleted!');

        return redirect()->route('files.index');
    }
}
