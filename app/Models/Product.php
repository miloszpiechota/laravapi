<?php
//Object-Relational Mapper
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    //Product models can be created or
    // updated from the controller using massifs containing the name,
    // description and price keys.
    protected $fillable = [
        'name',
        'description',
        'price'
    ];
    use HasFactory;
}
