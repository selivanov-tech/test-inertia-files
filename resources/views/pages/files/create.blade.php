<x-layout>
    <x-slot name="header">
        <x-test.breadcrumbs :links="[
            'Files' => route('files.index'),
            'Create' => route('files.create'),
        ]" title="File creating"/>
    </x-slot>

    <x-panel>
        <x-splade-form :for="$form"/>
    </x-panel>
</x-layout>
