<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name', 
        'parent_id',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('created_at', "desc");
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->select(['id', 'name']);
    }
}
