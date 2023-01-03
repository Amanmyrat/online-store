<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['category_id','created_at', 'updated_at'];
    
    protected $casts = [
        'properties' => 'array'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->select(['id', 'name']);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('created_at', "desc");
    }
}
