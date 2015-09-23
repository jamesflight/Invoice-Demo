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
            'net_total' => $this->formatAmount($model->getNetTotal()),
            'gross_total' => $this->formatAmount($model->getGrossTotal())
        ];
    }

    public function includeLineItems(Invoice $model)
    {
        $lineItems = $model->line_items;
        return $this->collection($lineItems, new LineItemsTransformer());
    }

    private function formatAmount($amount)
    {
        return number_format(round($amount / 100, 2), 2, '.', '');
    }
}
