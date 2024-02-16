<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'stock', 'pvp', 'imagen', 'user_id', 'disponible'];

    //indicamos la relacion 1:N con user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //indicamos la relacion N:M con Tag
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    //accessores y  mutadores
    public function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => ucfirst($v),
        );
    }
    public function descripcion(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => ucfirst($v),
        );
    }

    public function getTagsId()
    {
        $tags = [];
        foreach ($this->tags as $tag) {
            $tags[] = $tag->id;
        }
        return $tags;
    }
}
