<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
    <a href="/redirect" class="bg-green-500 text-black py-2 px-7 rounded">Login as Passport</a>
    </div>
</x-dynamic-component>
