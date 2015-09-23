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
            $total += $line_item->getTotal();
        }

        return $total;
    }

    public function getGrossTotal()
    {
        return $this->getNetTotal() * 1.2;
    }

    public function addItem(
        $name,
        $amount,
        $discount
    ) {
        $lineItem = new LineItem([
            'name' => $name,
            'amount' => $amount,
            'discount' => $discount
        ]);

        $lineItem->invoice_id = $this->id;
        $this->line_items->add($lineItem);

        $errors = new MessageBag();

        if ($this->line_items->count() > 5) {
            $errors->add('invoice', 'You may not add more than 5 Line Items to an invoices.');
        }

        if ($errors->count()) {
            throw new InvalidModelException($errors);
        }

        return $this;
    }
}
