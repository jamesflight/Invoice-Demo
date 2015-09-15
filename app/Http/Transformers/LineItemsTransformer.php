<?php
namespace App\Http\Transformers;

use App\LineItem;
use League\Fractal\TransformerAbstract;

class LineItemsTransformer extends TransformerAbstract
{
    public function transform(LineItem $model)
    {
        return [
            'id' => $model->id,
            'amount' => $this->formatAmount($model->amount),
            'discount' => $model->discount
        ];
    }

    protected function formatAmount($amount)
    {
        $decimalAmount = round($amount / 100, 2);
        return number_format($decimalAmount, 2, '.', '');
    }
}
 