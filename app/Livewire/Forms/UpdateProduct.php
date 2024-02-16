<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateProduct extends Form
{
    public ?Product  $producto = null;
    public string $nombre = "";
    public string $descripcion = "";
    public int $stock = 0;
    public float $pvp = 0.0;
    public array $tags = [];
    public $imagen;

    public function setProducto(Product $prod)
    {
        $this->producto = $prod;
        $this->nombre = $prod->nombre;
        $this->descripcion = $prod->descripcion;
        $this->pvp = $prod->pvp;
        $this->stock = $prod->stock;
        $this->tags = $prod->getTagsId();
    }

    public function rules()
    {
        return  [
            'nombre' => ['required', 'string', 'min:3', 'unique:products,nombre,' . $this->producto->id],
            'descripcion' => ['required', 'string', 'min:10'],
            'stock' => ['required', 'integer', 'min:0'],
            'pvp' => ['required', 'decimal:0,2', 'min:0', 'max:9999.99'],
            'imagen' => ['nullable', 'image', 'max:2048'],
            'tags' => ['required', 'array', 'min:1', 'exists:tags,id'],
        ];
    }

    public function editProducto()
    {
        $this->validate();
        $ruta = $this->producto->imagen;
        if ($this->imagen) {
            if (basename($this->producto->imagen) != 'noimagen.png') {
                Storage::delete($this->producto->imagen);
            }
            $ruta = $this->imagen->store('productos');
        }
        //actualizamos el producto
        $this->producto->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'stock' => $this->stock,
            'pvp' => $this->pvp,
            'imagen' => $ruta,
            'disponible' => ($this->stock > 0) ? "SI" : "NO",
            'user_id' => auth()->user()->id,
        ]);
        //actualizamos los tags de producto
        $this->producto->tags()
            ->sync($this->tags);
    }

    public function limpiarCampos()
    {
        $this->reset(["producto", "nombre", "descripcion", "stock", "pvp", "tags", "imagen"]); //resetamos solo los campos que hemos creado arriba
    }
}
