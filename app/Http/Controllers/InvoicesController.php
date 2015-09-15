<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidModelException;
use App\Http\FractalTrait;
use App\Http\Transformers\InvoicesTransformer;
use App\Invoice;
use App\LineItem;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;

class InvoicesController extends Controller
{
    use FractalTrait;

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

        $errors = new MessageBag();

        $invoice = Invoice::find($invoice_id);

        if ($invoice->line_items()->count() > 4) {
            $errors->add('invoice', 'An Invoice can\'t have more than 5 line items.');
        }

        if ($errors->count()) {
            return response()->json([
                'errors' => true,
                'messages' => $errors->all()
            ]);
        }

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

        return $this->jsonItem($invoice, InvoicesTransformer::class);
    }
}
