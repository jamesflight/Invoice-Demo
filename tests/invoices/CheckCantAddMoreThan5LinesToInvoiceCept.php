<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('check cant add more than 5 line items to invoice');

$invoice = $I->createInvoiceWithLineItems(5);

$I->sendPOST("invoices/$invoice->id/line_items", [
    'name' => 'Staples',
    'amount' => '2.50',
    'discount' => 20
]);

$I->seeResponseContainsJson([
    'errors' => true
]);