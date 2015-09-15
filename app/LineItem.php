<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'discount'
    ];
}
 