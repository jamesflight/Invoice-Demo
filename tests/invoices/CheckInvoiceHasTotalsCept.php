<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('check invoice has the correct totals');

$invoice = $I->createInvoiceWithLineItems(2);
$invoice->vat_percentage = 20;
$invoice->line_items[0]->amount = 200;
$invoice->line_items[0]->discount = 5;
$invoice->line_items[1]->amount = 400;
$invoice->line_items[1]->discount = 10;
$invoice->push();

$I->sendGET("invoices/$invoice->id");

$I->seeResponseContainsJson([
    'id' => $invoice->id,
    'net_total' => '5.50',
    'gross_total' => '6.60'
]);