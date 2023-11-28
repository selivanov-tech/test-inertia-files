@props([
    'primary' => false,
    'danger' => false,
    'secondary' => false,
])

<Link {{ $attributes->class([
        'border rounded-md shadow-sm font-bold py-2 px-4 focus:outline-none focus:ring focus:ring-opacity-50',
        'bg-indigo-500 hover:bg-indigo-700 text-white border-transparent focus:border-indigo-300 focus:ring-indigo-200' => $primary,
        'bg-red-500 hover:bg-red-700 text-white border-transparent focus:border-red-700 focus:ring-red-200' => $danger,
        'bg-white hover:bg-gray-100 text-gray-700 border-gray-300 focus:border-indigo-300 focus:ring-indigo-200' => $secondary,
    ]) }}>
    {{ $slot }}
</Link>
