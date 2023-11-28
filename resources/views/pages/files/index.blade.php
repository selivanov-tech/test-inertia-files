<x-layout>
    <x-slot name="header">
        <x-test.breadcrumbs :links="[
            'Files' => route('files.index'),
        ]" title="Test task"/>
    </x-slot>

    <x-panel>
        <div>
            <x-nav-link
                class="mb-2 text-purple-400"
                :href="route('files.create')"
            >Add file
            </x-nav-link>

            <x-splade-table :for="$files" as="$file">
                <x-slot name="empty-state">
                    <p class="mx-4 my-2">No files uploaded yet</p>
                </x-slot>

                <x-splade-cell computedName>
                    @php(assert($file instanceof \App\Models\File))

                    {{ $file->computedName() }}
                </x-splade-cell>

                <x-splade-cell media_size>
                    {{ $file->media->first()->humanReadableSize }}
                </x-splade-cell>

                <x-splade-cell media_ext>
                    {{ $file->media->first()->extension }}
                </x-splade-cell>

                <x-splade-cell media_preview>
                    @if($file->media->first()->collection_name === 'images')
                        <img
                            class="h-8 w-8"
                            src="{{ asset($file->getFirstMediaUrl('images', 'preview')) }}"
                            alt="{{ $file->computedName() }}"
                        />
                    @else
                        -
                    @endif
                </x-splade-cell>

                <x-splade-cell download_link>
                    <x-nav-link away href="{{ route('files.download', $file) }}">Download</x-nav-link>
                </x-splade-cell>

                <x-splade-cell actions>
                    <div class="grid gap-x-2 gap-y-1">
                        <x-nav-link class="text-orange-400" href="{{ route('files.edit', $file) }}">Edit</x-nav-link>

                        <x-test.delete-file-button :$file/>
                    </div>
                </x-splade-cell>
            </x-splade-table>
        </div>
    </x-panel>
</x-layout>
