<?php

namespace App\Jobs;

use App\Invoice;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class AddLineItemToInvoice extends Job implements SelfHandling
{
    /**
     * @var
     */
    private $invoice_id;
    /**
     * @var
     */
    private $lineItem;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invoice_id, $lineItem)
    {
        $this->invoice_id = $invoice_id;
        $this->lineItem = $lineItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = Invoice::find($this->invoice_id);

        $invoice->addLineItem(
            $this->lineItem['name'],
            $this->lineItem['amount'],
            $this->lineItem['discount']
        );

        $invoice->push();
    }
}
