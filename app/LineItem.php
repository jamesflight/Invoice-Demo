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

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getTotal()
    {
        return $this->amount * ($this->discount / 100);
    }
}
 