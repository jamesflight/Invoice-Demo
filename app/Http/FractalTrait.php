<?php
namespace App\Http;

use Illuminate\Support\Facades\App;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

trait FractalTrait
{
    protected function jsonItem($item, $transformerClassname)
    {
        $transformer = App::make($transformerClassname);
        $resource = new Item($item, $transformer);
        $fractal = new Manager;
        $result = $fractal->createData($resource)->toArray();
        return response()->json($result, 200);
    }

    protected function jsonCollection($collection, $transformerClassname)
    {
        $transformer = App::make($transformerClassname);
        $resource = new Collection($collection, $transformer);
        $fractal = new Manager;
        $result = $fractal->createData($resource)->toArray();
        return response()->json($result, 200);
    }
}
 