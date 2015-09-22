<?php

namespace App\Commands;

use App\Commands\Command;
use App\Invoice;
use Illuminate\Contracts\Bus\SelfHandling;

class AddLineItemToInvoice extends Command implements SelfHandling
{
    private $name;
    private $amount;
    private $discount;

    public function __construct(
        $invoice_id,
        $line_item
    ) {
        $this->invoice_id = $invoice_id;
        $this->line_item = $line_item;
    }

    public function handle()
    {
        $invoice = Invoice::find($this->invoice_id);

        $invoice->addLineItem(
            $this->line_item['name'],
            $this->line_item['amount'],
            $this->line_item['discount']
        );

        $invoice->push();
    }
}
