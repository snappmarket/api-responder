<?php

namespace SnappMarket\ApiResponder\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array success(array $results, array $metadata = [], array $messages = [])
 * @method static array clientError(string $errorCode, array $replaces = [], $errors = [])
 * @method static array serverError(string $errorCode, array $replaces = [], $errors = [])
 * @method static array error(string $errorCode, int $status, array $replaces = [], $errors = [])
 * @method static void registerFormatter(Closure $formatter)
 */
class Response extends Facade
{
    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'snappmarket.response';
    }
}
