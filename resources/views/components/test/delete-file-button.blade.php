@props(['file'])

@php(assert($file instanceof \App\Models\File))

<x-nav-link class="text-red-400" :href="'#deleteFile' .$file->id ">Delete</x-nav-link>

<x-splade-modal :name="'deleteFile'. $file->id" class="text-center">
    <p class="text-lg">You are trying to delete file with id: {{$file->id}}</p>

    <p class="mt-4">Are you sure about that?</p>

    <div class="mt-4 flex gap-1.5 justify-center">
        <x-nav-link
            class="text-red-400"
            :href="route('files.destroy', $file->id)"
            method="DELETE"
        >Yes - delete
        </x-nav-link>

        <x-nav-link
            class="text-gray-400"
            @click="modal.setIsOpen(false)"
        >No - cancel
        </x-nav-link>
    </div>
</x-splade-modal>
