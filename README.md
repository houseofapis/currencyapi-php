# CurrencyApi PHP wrapper 

[![Latest Stable Version](https://poser.pugx.org/houseofapis/currencyapi/v/stable)](https://packagist.org/packages/houseofapis/currencyapi) [![License](https://poser.pugx.org/houseofapis/currencyapi/license)](https://packagist.org/packages/houseofapis/currencyapi) [![Build Status](https://travis-ci.org/houseofapis/currencyapi-php.svg?branch=master)](https://travis-ci.org/houseofapis/currencyapi-php) [![Coverage Status](https://coveralls.io/repos/github/houseofapis/currencyapi-php/badge.svg?branch=master)](https://coveralls.io/github/houseofapis/currencyapi-php?branch=master) 

<a href="https://currencyapi.net" title="CurrencyApi">CurrencyApi.net</a> provides live currency rates via a REST API. A live currency feed for over 152 currencies, including physical (USD, GBP, EUR + more) and cryptos (Bitcoin, Litecoin, Ethereum + more). A JSON and XML currency api updated every 60 seconds. 

Features:

- Live exchange rates (updated every 60 seconds).
- 152 currencies world currencies.
- Popular cryptocurrencies included; Bitcoin, Litecoin etc.
- Convert currencies on the fly with the convert endpoint.
- Historical currency rates back to year 2000.
- Easy to follow <a href="https://currencyapi.net/documentation" title="currency-api-documentation">documentation</a>

Signup for a free or paid account <a href="https://currencyapi.net/pricing" title="currency-api-pricing">here</a>.

## This package is a:

PHP wrapper for <a href="https://currencyapi.net" title="CurrencyApi">CurrencyApi.net</a> endpoints.

## Developer Guide

For an easy to following developer guide, check out our [PHP Developer Guide](https://currencyapi.net/sdk/php).

Alternatively keep reading below.

#### Prerequisites

- Minimum PHP 7.1+
- Working on PHP 8.2.10
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
    ->setOutput('JSON')
    ->setLimit('BTC,EUR,GBP')
    ->rates();
```
**Available methods for rates endpoint**

| Methods | Description |
| --- | --- |
| `setBase()` | The base currency you wish you receive the currency conversions for. This will output all currency conversions for that currency. **Default: USD**. |
| `setOutput()` | Response output in either JSON or XML. **Default: JSON**. |
| `setLimit()` | Limit which currency conversions are returned using the limit param. Comma separated (no space) values. **Optional** |

<br>

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

**Available methods for currencies endpoint**

| Methods | Description |
| --- | --- |
| `setOutput()` | Response output in either JSON or XML. **Default: JSON**. |

<br>

### Convert:

```php
$result = $currencyApi
    ->setAmount(100)
    ->setFrom('BTC')
    ->setTo('GBP')
    ->convert();
```

**Available methods for convert endpoint**

| Methods | Description |
| --- | --- |
| `setAmount()` | The value of the currency you want to convert from. This should be a number and can contain a decimal place. **Required**. |
| `setFrom()` | The currency you want to convert. This will be a three letter ISO 4217 currency code from one of the currencies we have rates for. **Required**. |
| `setTo()` | The currency you want to convert the amount 'to'. Again this will be a three letter currency code from the ones we offer. **Required**. |
| `setOutput()` | Response output in either JSON or XML. **Default: JSON**. |

<br>

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

**Available methods for historical endpoint**

| Methods | Description |
| --- | --- |
| `setDate()` | The historical date you wish to receive the currency conversions for. This should be formatted as YYYY-MM-DD. **Required**. |
| `setBase()` | The base currency you wish you receive the currency conversions for. This will output all currency conversions for that currency. **Default: USD**. |
| `setOutput()` | Response output in either JSON or XML. **Default: JSON**. |
| `setLimit()` | Limit which currency conversions are returned using the limit param. Comma separated (no space) values. **Optional** |

<br>

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

**Available methods for timeframe endpoint**

| Methods | Description |
| --- | --- |
| `setStartDate()` | The historical date you wish to receive the currency conversions from. This should be formatted as YYYY-MM-DD. **Required**. |
| `setEndDate()` | The historical date you wish to receive the currency conversions until. This should be formatted as YYYY-MM-DD. **Required**. |
| `setBase()` | The base currency you wish you receive the currency conversions for. This will output all currency conversions for that currency. **Default: USD**. |
| `setOutput()` | Response output in either JSON or XML. **Default: JSON**. |
| `setLimit()` | Limit which currency conversions are returned using the limit param. Comma separated (no space) values. **Optional** |

