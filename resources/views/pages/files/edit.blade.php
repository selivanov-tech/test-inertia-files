<x-layout>
    <x-slot name="header">
        <x-test.breadcrumbs :links="[
            'Files' => route('files.index'),
            'Edit' => route('files.edit', $file),
        ]" title="File edit"/>
    </x-slot>

    <x-panel>
        <x-splade-form :default="['name' => $name, 'media' => $media]" :action="route('files.update', $file)">
            <x-splade-input
                name="name"
                label="User's file name"
                placeholder="Custom file name"
                class="mb-4"
            />

            <x-splade-file
                filepond
                preview
                required
                max-size="8MB"
                name="media"
                class="my-4"
            />

            <x-splade-submit label="Save"/>

            <x-splade-modal name="updateFile" class="text-center">
                <p class="text-lg">You are trying to update file with id: {{$file->id}}</p>

                <p class="mt-4">Are you sure about that?</p>

                <div class="mt-4 flex gap-1.5 justify-center">
                    <x-nav-link
                        class="text-red-400"
                        :href="route('files.update', $file->id)"
                        method="POST"
                    >Yes - update
                    </x-nav-link>

                    <x-nav-link
                        class="text-gray-400"
                        @click="modal.setIsOpen(false)"
                    >No - cancel
                    </x-nav-link>
                </div>
            </x-splade-modal>
        </x-splade-form>
    </x-panel>
</x-layout>
