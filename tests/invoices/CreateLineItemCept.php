<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('create a line item for an invoice');

$invoice = $I->createInvoice();

$I->sendPOST("invoices/$invoice->id/line_items", [
    'name' => 'Staples',
    'amount' => '2.50',
    'discount' => 20
]);

$I->seeRecord('line_items', [
    'invoice_id' => $invoice->id,
    'name' => 'Staples',
    'amount' => 250,
    'discount' => 20
]);

$I->seeResponseContainsJson([
    'errors' => false
]);
