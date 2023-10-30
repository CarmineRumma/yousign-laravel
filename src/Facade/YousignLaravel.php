<?php namespace CarmineRumma\YousignLaravel\Facade;

use Illuminate\Support\Facades\Facade;

class YousignLaravel extends Facade {

    protected static function getFacadeAccessor() { return 'yousign.laravel'; }

}
