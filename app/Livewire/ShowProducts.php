<?php

namespace App\Livewire;

use App\Livewire\Forms\UpdateProduct;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;
    use WithFileUploads;

    public Product $producto;
    public UpdateProduct $form;

    public bool $openEdit = false;
    public bool $openShow = false;

    public string $campo = "id"; //  Campo por el que se ordenará la lista de productos. Por defecto es id.
    public  string $orden = "desc"; //  Orden en la que se mostrarán los productos (asc o desc). Por defecto es descendente.
    public  string $cadena = ""; //  Cadena a buscar en los campos para filtrar resultados.

    #[On("producto-creado")] //  Evento emitido desde CreateProducto/store cuando un nuevo producto ha sido creado.   
    public function render()
    {
        $productos = Product::where('user_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->cadena . '%')
                    ->orWhere('disponible', 'like', '%' . $this->cadena . '%');
            })
            //->where('nombre', 'like', '%' . $this->cadena . '%')
            //->orWhere('disponible', 'like', '%' . $this->cadena . '%'
            ->orderBy($this->campo, $this->orden)
            ->paginate(5);

        $misTags = Tag::select('id', 'nombre', 'color')->orderBy('nombre')->get();
        return view('livewire.show-products', compact('productos', 'misTags'));
    }
    public function updatingCadena()
    {
        $this->resetpage();
    }
    public function aumentarStock(Product $product)
    {
        //$this->producto = $product;
        $stock = ($product->stock) + 1;
        $product->update([
            'stock' => $stock,
            'disponible' => ($stock > 0) ? "SI" : "NO"
        ]);
    }
    public function disminuirStock(Product $product)
    {
        //$this->producto = $product;
        if ($product->stock == 0) return;
        $stock = ($product->stock) - 1;
        $product->update([
            'stock' => $stock,
            'disponible' => ($stock > 0) ? "SI" : "NO"
        ]);
    }

    public function ordenar(string $campo)
    {
        $this->orden = ($this->orden == 'desc') ? "asc" : "desc";
        $this->campo = $campo;
    }


    /* BORRAR */
    public function confirmarBorrado(Product $producto)
    {
        $this->authorize('delete', $producto);
        $this->dispatch('confirmarBorrar', $producto->id);
    }

    #[On("borrarOk")]
    public function borrar(Product $producto)
    {
        $this->authorize('update', $producto);
        if (basename($producto->imagen) != 'noimagen.png') {
            Storage::delete($producto->imagen);
        }
        $producto->delete();
        $this->dispatch('mensaje', 'Producto Borrado');
    }

    /* ACTUALIZAR */
    public function edit(Product  $product)
    {
        $this->authorize('update', $product);
        $this->form->setProducto($product);
        $this->openEdit = true;
    }

    public function update()
    {
        $this->form->editProducto();
        $this->cancelarUpdate();
        $this->dispatch('mensaje', 'Producto Actualizadoº');
    }
    public function cancelarUpdate()
    {
        $this->openEdit = false;
        $this->form->limpiarCampos();
    }

    /* DETALLE */
    public function detalle(Product $producto)
    {
        $this->producto = $producto;
        $this->openShow = true;
    }

    public function cerrarDetalle()
    {
        $this->reset(['producto', 'openShow']);
    }
}
