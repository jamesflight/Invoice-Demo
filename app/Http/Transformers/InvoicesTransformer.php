<?php
namespace App\Http\Transformers;

use App\Invoice;
use League\Fractal\TransformerAbstract;

class InvoicesTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'line_items'
    ];

    public function transform(Invoice $model)
    {
        return [
            'id' => $model->id,
            'issue_date' => $model->issue_date->format('Y/m/d'),
            'due_date' => $model->due_date->format('Y/m/d'),
            'net_total' => $this->formatAmount($this->getNetTotal($model)),
            'gross_total' => $this->formatAmount($this->getGrossTotal($model))
        ];
    }

    public function includeLineItems(Invoice $model)
    {
        $lineItems = $model->line_items;
        return $this->collection($lineItems, new LineItemsTransformer());
    }

    protected function getNetTotal($model)
    {
        $total = 0;
        foreach ($model->line_items as $line_item) {
            $total += $line_item->amount - ($line_item->amount * ($line_item->discount / 100));
        }
        return $total;
    }

    protected function getGrossTotal($model)
    {
        $netTotal = $this->getNetTotal($model);
        return $netTotal + ($netTotal * ($model->vat_percentage / 100));
    }

    protected function formatAmount($amount)
    {
        $decimalAmount = round($amount / 100, 2);
        return number_format($decimalAmount, 2, '.', '');
    }
}
 