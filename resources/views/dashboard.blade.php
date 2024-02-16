<x-app-layout>
    <x-principal>
        <div class="p-4 rounded-xl w-1/2 mx-auto flex justify-around items-center">
            <a href="{{route('inicio')}}"
                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                IR A HOME
            </a>
            <a href="{{route('productos.index')}}"
                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                IR A MIS POSTS
            </a>
            <a href="{{route('tags.index')}}"
                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                GESTIÓN DE TAGS
            </a>

        </div>

    </x-principal>
</x-app-layout>