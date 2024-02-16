<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Tag;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatProduct extends Component
{
    use WithFileUploads;

    public bool $openCrear = false;

    #[Validate(['nullable', 'image', 'max:2048'])]
    public $imagen;

    #[Validate(['required', 'string', 'min:3', 'unique:products,nombre'])]
    public string $nombre = "";

    #[Validate(['required', 'string', 'min:10'])]
    public string $descripcion = "";

    #[Validate(['required', 'integer', 'min:0'])]
    public int $stock;

    #[Validate(['required', 'decimal:0,2', 'min:0', 'max:9999.99'])]
    public float $pvp;

    #[Validate(['required', 'array', 'min:1', 'exists:tags,id'])]
    public array $tags = [];


    public function render()
    {
        $misTags = Tag::select('id', 'nombre', 'color')->orderBy('nombre')->get();
        return view('livewire.creat-product', compact('misTags'));
    }

    public function store()
    {
        $this->validate();
        $producto = Product::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'stock' => $this->stock,
            'pvp' => $this->pvp,
            'imagen' => ($this->imagen) ? $this->imagen->store('productos') : 'noimagen.png',
            'disponible' => ($this->stock > 0) ? "SI" : "NO",
            'user_id' => auth()->user()->id,
        ]);
        $producto->tags()->attach($this->tags);
        $this->dispatch('producto-creado')->to(ShowProducts::class);
        $this->dispatch('mensaje', 'Se guardó el producto con éxito');
        $this->cancelarCrear();
    }

    public function cancelarCrear()
    {
        $this->reset('openCrear', 'nombre', 'descripcion', 'stock', 'pvp', 'imagen', 'tags');
    }
}
