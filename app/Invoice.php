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
}
 