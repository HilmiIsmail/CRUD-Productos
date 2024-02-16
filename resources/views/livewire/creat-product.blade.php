<div>
    <x-button wire:click="$set('openCrear',true)">
        <i class="fas fa-add mr-1">NUEVO</i>
    </x-button>
    {{-- MODAL PARA CREAR --}}
    <x-dialog-modal wire:model='openCrear'>
        <x-slot name="title">
            Crear product
        </x-slot>
        <x-slot name="content">
            {{-- !NOMBRE --}}
            <x-label for="nombre">Nombre:</x-label>
            <x-input id="nombre" placeholder="Nombre del producto..." class="w-full" wire:model="nombre" />
            <x-input-error for="nombre" />

            {{-- !DESCRIPCION --}}
            <x-label for="descripcion" class="mt-4">Descripción:</x-label>
            <textarea id="descripcion" placeholder="Descripción del producto..." class="w-full rounded "
                wire:model="descripcion"></textarea>
            <x-input-error for="descripcion" />

            {{-- !STOCK --}}
            <x-label for="stock" class="mt-4">Ptock:</x-label>
            <x-input type="number" id="stock" placeholder="Stock del producto..." class="w-full" min="0"
                wire:model="stock" />

            <x-input-error for="stock" />

            {{-- !PRECIO --}}
            <x-label for="pvp" class="mt-4">Precio €:</x-label>
            <x-input type="number" id="pvp" placeholder="Precio del producto..." class="w-full" step='0.01' min='0'
                max='9999.99' wire:model="pvp" />
            <x-input-error for="pvp" />

            {{-- !TAGS --}}
            <x-label for="tags" class="mt-4">Tags:</x-label>
            <div class="flex flex-wrap">
                @foreach ($misTags as $tag)
                <div class="flex items-center me-4">
                    <input id="{{ $tag->id }}" type="checkbox" value="{{ $tag->id }}" wire:model="tags"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="{{ $tag->id }}"
                        class="ms-2 p-1 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-300"
                        style="background-color: {{ $tag->color }}">{{ $tag->nombre }}</label>
                </div>
                @endforeach
            </div>
            <x-input-error for="tags" />

            {{-- !IMAGEN --}}
            <x-label for="imagenC" class="mt-4">Imagen:</x-label>
            <div class="relative w-full h-72 bg-gray-200 ">
                <input type="file" hidden wire:model='imagen' accept="image/>" id="imagenC" />
                <label for="imagenC"
                    class="absolute bottom-2 end-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i>SUBIR
                </label>
                @if ($imagen)
                <img src="{{ $imagen->temporaryUrl() }}"
                    class="p-1 rounded w-full h-full bg-no-repeat bg-cover bg-center">
                @endif
            </div>
            <x-input-error for="imagen" />
        </x-slot>


        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button wire:click="store" wire:loading.attr="disabled"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> GUARDAR
                </button>

                <button wire:click="cancelarCrear"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>