<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\LineItem;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{
    public function create(Request $request)
    {
        $input = $request->only(
            'issue_date',
            'due_date',
            'vat_percentage'
        );

        Invoice::create([
            'issue_date' => new DateTime($input['issue_date']),
            'due_date' => new DateTime($input['due_date']),
            'vat_percentage' => $input['vat_percentage']
        ]);

        return response()->json(['errors' => false], 200);
    }

    public function addLineItem(Request $request, $invoice_id)
    {
        $input = $request->only(
            'name',
            'amount',
            'discount'
        );

        $invoice = Invoice::find($invoice_id);

        $lineItem = LineItem::create([
            'name' => $input['name'],
            'amount' => $input['amount'] * 100,
            'discount' => $input['discount']
        ]);

        $invoice->line_items()->save($lineItem);

        return response()->json(['errors' => false], 200);
    }

    public function get($id)
    {
        $invoice = Invoice::find($id);

        $invoiceArray = $invoice->toArray();

        $invoiceArray['line_items'] = $invoice->line_items->toArray();

        foreach ($invoiceArray['line_items'] as $key => $line_item) {
            $invoiceArray['line_items'][$key]['amount'] = number_format(round($line_item['amount'] / 100, 2), 2, '.', '');
        }

        return response()->json($invoiceArray, 200);
    }
}
