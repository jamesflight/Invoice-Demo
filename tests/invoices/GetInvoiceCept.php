<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('get an invoice with line items');

$invoice = $I->createInvoiceWithLineItems(3);

$I->sendGET("invoices/$invoice->id");

$I->seeResponseContainsJson([
    'id' => $invoice->id
]);

$I->seeResponseContainsJson([
    'id' => $invoice->line_items[0]->id
]);

$I->seeResponseContainsJson([
    'id' => $invoice->line_items[1]->id
]);

$I->seeResponseContainsJson([
    'id' => $invoice->line_items[2]->id
]);