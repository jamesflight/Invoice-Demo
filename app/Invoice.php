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
        $netTotal = $this->getNetTotal();
        return $netTotal + ($netTotal * ($this->vat_percentage / 100));
    }

    public function getTotalDiscount()
    {
        $total = 0;
        foreach ($this->line_items as $line_item) {
            $total += $line_item->getDiscountAmount();
        }
        return $total;
    }

    public function getTotalWithoutDiscount()
    {
        $total = 0;
        foreach ($this->line_items as $line_item) {
            $total += $line_item->getAmount();
        }
        return $total;
    }

    public function addLineItem($name, $amount, $discount)
    {
        // Stage changes
        $lineItem = LineItem::create([
            'name' => $name,
            'amount' => $amount,
            'discount' => $discount
        ]);

        $lineItem->invoice_id = $this->id;
        $this->line_items->add($lineItem);

        // Validate entity
        $errors = new MessageBag();

        // Check invoice will have no more than 5 line items
        if ($this->line_items()->count() > 4) {
            $errors->add('invoice', 'An Invoice can\'t have more than 5 line items.');
        }

        // Check invoice total discount percentage will not exceed 20%
        if ($this->getTotalDiscount() / $this->getTotalWithoutDiscount() > 0.2) {
            $errors->add('invoice', 'The total discounted amount cannot be more that 20% of the invoice total.');
        }

        if ($errors->count()) {
            throw new InvalidModelException($errors);
        }

        return $this;
    }
}
 