<?php
namespace App;

use DateTime;
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

    public function getIssueDateAttribute()
    {
        return new DateTime($this->attributes['issue_date']);
    }

    public function getDueDateAttribute()
    {
        return new DateTime($this->attributes['due_date']);
    }
}
 