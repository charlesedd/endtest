<?php
/**
 * Created by PhpStorm.
 * User: Charles
 * Date: 06/03/2019
 * Time: 22:21
 */

require __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../bootstrap/app.php';

$shippingRates = App\ShippingRate::all();

foreach ($shippingRates as $rate) {
    echo $rate->name;
}