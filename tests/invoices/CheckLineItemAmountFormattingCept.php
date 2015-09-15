<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('check that the amount for a line item is formatted as follows: xx.xx');

$invoice = $I->createInvoiceWithLineItems(1);
$invoice->line_items[0]->amount = 300;
$invoice->line_items[0]->save();

$I->sendGET("invoices/$invoice->id");

$I->seeResponseContainsJson([
    'line_items' => [
        'amount' => '3.00'
    ]
]);