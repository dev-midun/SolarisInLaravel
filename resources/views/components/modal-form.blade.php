@props([
    "id",
    "title" => null,
    "size" => "lg"
])

<x-modal :id="$id" body:class="p-3 p-lg-4" animation="scale" static center :size="$size">
    <x-slot:header class="border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </x-slot>

    <div class="text-center mb-3">
        <h4 class="mb-2">{{ $title }}</h4>
    </div>

    <div class="p-lg-4 p-2">
        {{ $slot }}
    </div>
</x-modal>