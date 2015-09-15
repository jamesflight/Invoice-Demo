<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Invoice;
use App\LineItem;
use League\FactoryMuffin\Facade as FactoryMuffin;

class Invoices extends \Codeception\Module
{
    public function __construct()
    {
        FactoryMuffin::define(Invoice::class, array(
            'issue_date'    => 'date',
            'due_date'   => 'date',
            'vat_percentage'  => 'numberBetween|10;20'
        ));

        FactoryMuffin::define(LineItem::class, array(
            'name'    => 'text|25',
            'amount'   => 'numberBetween|1;10',
            'discount'  => 'numberBetween|5;20'
        ));
    }

    public function createInvoice()
    {
        return FactoryMuffin::create(Invoice::class);
    }

    public function createInvoiceWithLineItems($number_of_line_items)
    {
        $invoice = FactoryMuffin::create(Invoice::class);

        for ($i = 1; $i <= $number_of_line_items; $i++) {
            $lineItem = FactoryMuffin::create(LineItem::class);
            $invoice->line_items()->save($lineItem);
        }

        return $invoice;
    }
}
