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

        $input['amount'] = $input['amount'] * 100;

        $invoice = Invoice::find($invoice_id);

        try {
            $invoice->addItem(
                $input['name'],
                $input['amount'],
                $input['discount']
            );
        } catch(InvalidModelException $e) {
            return response()->json([
                'errors' => true,
                'messages' => $e->getErrors()
            ], 400);
        }

        return response()->json(['errors' => false], 200);
    }

    public function get($id)
    {
        $invoice = Invoice::find($id);

        return $this->jsonItem($invoice, InvoicesTransformer::class);
    }
}
