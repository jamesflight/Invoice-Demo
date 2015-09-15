<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('create an invoice');

$I->sendPOST('invoices', [
    'issue_date' => '2015-01-01',
    'due_date' => '2015-01-15',
    'vat_percentage' => 20
]);

$I->seeRecord('invoices', [
    'issue_date' => new DateTime('2015-01-01'),
    'due_date' => new DateTime('2015-01-15'),
    'vat_percentage' => 20
]);

$I->seeResponseContainsJson(['errors' => false]);