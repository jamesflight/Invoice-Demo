<?php
namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    protected function formatAmount($amount)
    {
        $decimalAmount = round($amount / 100, 2);
        return number_format($decimalAmount, 2, '.', '');
    }
}
 