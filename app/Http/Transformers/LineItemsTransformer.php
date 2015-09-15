<?php
namespace App\Http\Transformers;

use App\LineItem;
use League\Fractal\TransformerAbstract;

class LineItemsTransformer extends BaseTransformer
{
    public function transform(LineItem $model)
    {
        return [
            'id' => $model->id,
            'amount' => $this->formatAmount($model->amount),
            'discount' => $model->discount
        ];
    }
}
 