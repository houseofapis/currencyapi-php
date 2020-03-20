# CurrencyApi

<a href="#"><img src="https://user-images.githubusercontent.com/42932986/77211101-bb99ab80-6afa-11ea-8d37-941c9016b012.png" width="104" height="20" /></a><br>

CurrencyApi provides live currency rates via a REST API. A live currency feed for over 152 currencies including cryptos, like Bitcoin, Litecoin and Ethereum. JSON and XML currency api updated every 60 seconds. 

Features:

- Live exchange rates (updated every 60 seconds).
- 152 currencies world currencies.
- Popular cryptocurrencies included; Bitcoin, Litecoin etc.
- Convert currencies on the fly with the convert endpoint.
- Historical currency rates back to year 2000.


## This package

PHP wrapper for CurrencyApi.net endpoints.

#### Prerequisites

- Minimum PHP 7.1+ (tested and working on PHP 7.4) 
- Free or Paid account with CurrencyApi.net
- Composer or clone this repo

#### Test Coverage

- 100% coverage

## Installation

#### Using composer:

```bash
composer require houseofapis/currencyapi
```
then include the package with:

```php
use HouseOfApis\CurrencyApi\CurrencyApi;
```

#### Without composer:


```php
require_once('/path/to/currencyapi/src/CurrencyApi.php');
$currencyApi = new \CurrencyApi\CurrencyApi('API_KEY');
```

## Usage

### Live rates:

```php
$result = $currencyApi->rates();
```

Example with all available methods:
```php
$result = $currencyApi
    ->setBase('USD')
    ->setLimit('BTC,EUR,GBP')
    ->setOutput('JSON')
    ->rates();
```

Methods for rates endpoint:

`setBase()`

`setLimit()`

`setOutput()`

### List of available currencies:

```php
$result = $currencyApi->currencies();
```

Example with all available methods:
```php
$result = $currencyApi
    ->setOutput('XML')
    ->currencies();
```

Methods for currencies endpoint:

`setOutput()`

### Convert:

```php
$result = $currencyApi
    ->setAmount(100)
    ->setFrom('BTC')
    ->setTo('GBP')
    ->convert();
```

Methods for convert endpoint:

`setAmount()` * Required

`setFrom()` * Required

`setTo()` * Required

`setOutput()`


### Historical:

```php
$result = $currencyApi->setDate('2019-01-01')->historical();
```

Example with all available methods:

```php
$result = $currencyApi
    ->setDate('2019-01-01')
    ->setBase('GBP')
    ->setLimit('USD')
    ->setOutput('JSON')
    ->historical();
```

Methods for historical endpoint:

`setDate()` * Required

`setBase()`

`setLimit()`

`setOutput()`

### Timeframe:

```php
$result = $currencyApi->setStartDate('2019-01-01')->setEndDate('2019-01-05')->historical();
```

Example with all available methods:

```php
$result = $currencyApi
    ->setStartDate('2019-01-01')
    ->setEndDate('2019-01-05')
    ->setBase('GBP')
    ->setLimit('USD,BTC')
    ->setOutput('XML')
    ->timeframe();
```

Methods for timeframe endpoint:

`setStartDate()` * Required

`setEndDate()` * Required

`setBase()`

`setLimit()`

`setOutput()`


