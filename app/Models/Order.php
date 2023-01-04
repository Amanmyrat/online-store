<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        'user_name',
        'user_email',
        'address',
        'status',
        'total',
        'products',
    ];

    protected $casts = [
        'products' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
