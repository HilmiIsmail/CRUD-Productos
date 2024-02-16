<x-principal>
    <div class="flex w-full mb-1 items-center">
        <div class="w-3/4">
            <x-input type="search" placeholder="Buscar Producto..." class="w-3/4" wire:model.live="cadena"></x-input>
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div class="">
            @livewire('creat-product')
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    INFO
                </th>
                <th scope="col" class="px-6 py-3">
                    IMAGEN
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                    NOMBRE <i class="fas fa-sort ml-1"></i>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('disponible')">
                    Disponible <i class="fas fa-sort ml-1"></i>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('stock')">
                    STOCK <i class="fas fa-sort ml-1"></i>
                </th>
                <th scope="col" class="px-6 py-3">
                    ACCIONES
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <button wire:click='detalle({{$item->id}})'>
                        <i class="fas fa-info text-lg"></i>
                    </button>
                </td>
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <img class="w-20 h-20 rounded bg-center bg-cover" src="{{ Storage::url($item->imagen) }}" alt="">
                </th>
                <td class="px-6 py-4">
                    {{ $item->nombre }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div @class([ 'h-3.5 w-3.5 rounded-full' , 'bg-green-500 me-2'=> $item->disponible == 'SI',
                            'bg-red-500 me-2' => $item->disponible == 'NO',
                            ])></div> {{ $item->disponible }}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <button wire:click='disminuirStock({{ $item->id }})'
                            class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 1h16" />
                            </svg>
                        </button>
                        <div>
                            <p wire:reload
                                @class([ 'bg-gray-50 w-14 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1'
                                , 'text-red-500'=> $item->stock < 10, 'line-through'=> $item->stock == 0,
                                    'text-green-500' => $item->stock >= 10,
                                    ])>
                                    {{ $item->stock }}
                            </p>
                        </div>
                        <button wire:click='aumentarStock({{ $item->id }})'
                            class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            type="button">
                            <span class="sr-only">Quantity button</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </button>
                    </div>

                </td>
                <td class="px-6 py-4">
                    <button wire:click="edit({{ $item->id }})">
                        <i class="fas fa-edit text-xl text-yellow-500"></i>
                    </button>
                    <button wire:click="confirmarBorrado({{ $item->id }})">
                        <i class="fas fa-trash text-xl text-red-500"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-2">
        {{ $productos->links() }}
    </div>
    {{-- !MODAL UPDATE --}}
    @isset($form->producto)
    <x-dialog-modal wire:model='openEdit'>
        <x-slot name="title">
            Actualizar product
        </x-slot>
        <x-slot name="content">
            {{-- !NOMBRE --}}
            <x-label for="nombre">Nombre:</x-label>
            <x-input id="nombre" placeholder="Nombre del producto..." class="w-full" wire:model="form.nombre" />
            <x-input-error for="form.nombre" />

            {{-- !DESCRIPCION --}}
            <x-label for="descripcion" class="mt-4">Descripción:</x-label>
            <textarea id="descripcion" placeholder="Descripción del producto..." class="w-full rounded "
                wire:model="form.descripcion"></textarea>
            <x-input-error for="form.descripcion" />

            {{-- !STOCK --}}
            <x-label for="stock" class="mt-4">Ptock:</x-label>
            <x-input type="number" id="stock" placeholder="Stock del producto..." class="w-full" min="0"
                wire:model="form.stock" />
            <x-input-error for="form.stock" />

            {{-- !PRECIO --}}
            <x-label for="pvp" class="mt-4">Precio €:</x-label>
            <x-input type="number" id="pvp" placeholder="Precio del producto..." class="w-full" step='0.01' min='0'
                max='9999.99' wire:model="form.pvp" />
            <x-input-error for="form.pvp" />

            {{-- !TAGS --}}
            <x-label for="tags" class="mt-4">Tags:</x-label>
            <div class="flex flex-wrap">
                @foreach ($misTags as $tag)
                <div class="flex items-center me-4">
                    <input id="{{ $tag->id }}" type="checkbox" value="{{ $tag->id }}" wire:model="form.tags"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="{{ $tag->id }}"
                        class="ms-2 p-1 rounded-xl text-sm font-medium text-gray-900 dark:text-gray-300"
                        style="background-color: {{ $tag->color }}">{{ $tag->nombre }}</label>
                </div>
                @endforeach
            </div>
            <x-input-error for="form.tags" />

            {{-- !IMAGEN --}}
            <x-label for="imagenU" class="mt-4">Imagen:</x-label>
            <div class="relative w-full h-80 bg-gray-200 ">
                <input type="file" hidden wire:model='form.imagen' accept="image/>" id="imagenU" />
                <label for="imagenU"
                    class="absolute bottom-2 end-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i>SUBIR
                </label>
                @if ($form->imagen)
                <img src="{{ $form->imagen->temporaryUrl() }}"
                    class="p-1 rounded w-full h-full bg-no-repeat bg-cover bg-center">
                @else
                <img src="{{ Storage::url($form->producto->imagen) }}"
                    class="p-1 rounded w-full h-full bg-no-repeat bg-cover bg-center">
                @endif
            </div>
            <x-input-error for="form.imagen" />
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button wire:click="update" wire:loading.attr="hidden"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit"></i> EDITAR
                </button>

                <button wire:click="cancelarUpdate"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
    @endisset
    {{-- !FIN MODAL UPDATE --}}

    {{-- !MODAL DETALLE --}}
    @isset($producto->imagen)
    <x-dialog-modal wire:model='openShow'>
        <x-slot name="title">
            Detalle del producto
        </x-slot>
        <x-slot name="content">
            <div
                class="w-full mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <img class="rounded bg-cover bg-no-repeat bg-center w-full" src="{{Storage::url($producto->imagen)}}"
                    alt="" />
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-blue-900 dark:text-white">
                        {{$producto->nombre}}
                    </h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{$producto->descripcion}}
                    </p>
                    <div class="flex flex-wrap my-4">
                        @foreach ($producto->tags as $item)
                        <div class="p-1 rounded-lg mr-1" style="background-color: {{$item->color}}">
                            {{$item->nombre}}
                        </div>
                        @endforeach
                    </div>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <b>Precio: </b>{{$producto->pvp}}€
                    </p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <b>Creado: </b>{{($producto->created_at)->diffForHumans()}}
                    </p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <b>Última Actualizacón: </b>{{($producto->updated_at)->diffForHumans()}}
                    </p>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="cerrarDetalle"
                class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-xmark"></i> CANCELAR
            </button>
        </x-slot>
    </x-dialog-modal>
    @endisset

    {{-- !FIN MODAL DETALLE --}}
</x-principal>