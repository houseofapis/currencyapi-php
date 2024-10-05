<?php

require_once __DIR__ . '/vendor/autoload.php';
use HouseOfApis\CurrencyApi\CurrencyApi;

$currencyApi = new CurrencyApi('YOUR_API_KEY');

try {
    $result = $currencyApi->rates();
    print_r($result);

} catch (\Exception $e) {
    print_r("An error occurred: " . $e->getMessage());
}