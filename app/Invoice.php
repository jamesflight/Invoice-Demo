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

    public function getNetTotal()
    {
        $total = 0;

        foreach ($this->line_items as $line_item) {
            $total += $line_item->getTotal();
        }

        return $total;
    }

    public function getGrossTotal()
    {
        return $this->getNetTotal() * 1.2;
    }

    public function addItem()
    {
        if (count($invoice->line_items) >= 5) {

            return response()->json(['errors' => true, 'messages' => 'You cannot add more than 5 line items'], 400);

        } else {

            $lineItem = LineItem::create([
                'name' => $input['name'],
                'amount' => $input['amount'] * 100,
                'discount' => $input['discount']
            ]);

            $invoice->line_items()->save($lineItem);
    }
}
