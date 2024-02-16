<x-app-layout>
    <x-principal>
        <div class="flex flex-row-reverse">
            <a href="" class="mb-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-add text-xl text-white"></i> NUEVO TAG
            </a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            COLOR
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            ACCIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 ">
                            {{$tag->id}}
                        </th>
                        <td class="px-6 py-4">
                            {{$tag->nombre}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="p-5 rounded-full" style="background-color: {{$tag->color}}"></div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="" method="POST">
                                @method('DELETE')
                                <a href=""><i
                                        class="fa-solid fa-pencil text-xl text-blue-800 dark:text-blue-500"></i></a>
                                <button type="submit"><i
                                        class="fa-solid fa-trash text-xl text-red-700 dark:text-red-500"></i></button>
                            </form>

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </x-principal>
</x-app-layout>