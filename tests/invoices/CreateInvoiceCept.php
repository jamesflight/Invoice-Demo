<?php 
$I = new InvoicesTester($scenario);
$I->wantTo('perform actions and see result');

$I->sendPOST('invoices', [
    'issue_date' => '2015-01-01',
    'due_date' => '2015-15-01',
    'vat_percentage' => 20
]);

$I->seeRecord('invoices', [
    'issue_date' => new DateTime('2015-01-01'),
    'due_date' => new DateTime('2015-15-01'),
    'vat_percentage' => 20
]);