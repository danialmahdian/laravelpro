<?php

namespace Modules\Cart\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Clas Cart
 * @package App\Helpers\Cart
 * @method static bool has($id)
 * @method static collection all();
 * @method static array get($id);
 * @method static Cart put(array $value , Model|null $obj)
 * @method static Cart instance(string $name)
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
