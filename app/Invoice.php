<?php
namespace App;

use App\Exceptions\InvalidModelException;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;

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
            $total += $line_item->amount - $line_item->getTotal();
        }
        return $total;
    }

    public function getGrossTotal()
    {
        $netTotal = $this->getNetTotal();
        return $netTotal + ($netTotal * ($this->vat_percentage / 100));
    }

    public function addLineItem($name, $amount, $discount)
    {
        $errors = new MessageBag();

        if ($this->line_items()->count() > 4) {
            $errors->add('invoice', 'An Invoice can\'t have more than 5 line items.');
            throw new InvalidModelException($errors);
        }

        $lineItem = LineItem::create([
            'name' => $name,
            'amount' => $amount,
            'discount' => $discount
        ]);

        $lineItem->invoice_id = $this->id;
        $this->setRelation('line_items', $lineItem);
    }
}
 