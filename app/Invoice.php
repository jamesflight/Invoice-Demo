<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'issue_date',
        'due_date',
        'vat_percentage'
    ];

    public function line_items()
    {
        return $this->hasMany(LineItem::class);
    }
}
 