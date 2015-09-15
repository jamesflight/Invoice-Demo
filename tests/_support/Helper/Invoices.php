<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Invoice;
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
    }

    public function createInvoice()
    {
        return FactoryMuffin::create(Invoice::class);
    }
}
