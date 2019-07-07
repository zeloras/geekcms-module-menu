<?php

namespace Modules\Menu\Libs;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return MenuBuilder::class;
    }
}
