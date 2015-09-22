<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('check total discount cant be more that 20% of total');

// Total (without discount) is 35
// Total (with discount) is 27.1
// Total discount is 22.57%

$invoice = $I->createInvoiceWithLineItems(2);
$invoice->line_items[0]->amount = 1000;
$invoice->line_items[0]->discount = 15;
$invoice->line_items[1]->amount = 1200;
$invoice->line_items[1]->discount = 10;
$invoice->push();

$I->sendPOST("invoices/$invoice->id/line_items", [
    'name' => 'Staples',
    'amount' => '13.00',
    'discount' => 40
]);

$I->seeResponseContainsJson([
    'errors' => true
]);
