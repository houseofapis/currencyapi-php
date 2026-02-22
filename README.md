# CurrencyApi PHP wrapper

[![Latest Stable Version](https://poser.pugx.org/houseofapis/currencyapi/v/stable)](https://packagist.org/packages/houseofapis/currencyapi) [![License](https://poser.pugx.org/houseofapis/currencyapi/license)](https://packagist.org/packages/houseofapis/currencyapi) [![Build Status](https://travis-ci.org/houseofapis/currencyapi-php.svg?branch=main)](https://travis-ci.org/houseofapis/currencyapi-php) [![Coverage Status](https://coveralls.io/repos/github/houseofapis/currencyapi-php/badge.svg?branch=main)](https://coveralls.io/github/houseofapis/currencyapi-php?branch=main)

<a href="https://currencyapi.net" title="CurrencyApi">CurrencyApi.net</a> provides live currency rates via a REST API. A live currency feed for over 166 currencies, including physical (USD, GBP, EUR + more) and cryptos (Bitcoin, Litecoin, Ethereum + more). A JSON and XML currency api updated every 60 seconds.

Features:

- Live exchange rates (updated every 60 seconds).
- 166+ world currencies.
- Popular cryptocurrencies included; Bitcoin, Litecoin etc.
- Convert currencies on the fly with the convert endpoint.
- Historical currency rates back to year 2000.
- OHLC (candlestick) data for technical analysis.
- Easy to follow <a href="https://currencyapi.net/documentation" title="currency-api-documentation">documentation</a>

Signup for a free or paid account <a href="https://currencyapi.net/pricing" title="currency-api-pricing">here</a>.

> **Note:** API v1 is deprecated and will be retired on **31st July 2026**, at which point all v1 traffic will be redirected to v2. This SDK (v3.0.0+) targets API v2. If you are on an older version of this SDK, please upgrade.

## This package is a:

PHP wrapper for <a href="https://currencyapi.net" title="CurrencyApi">CurrencyApi.net</a> endpoints.

## Developer Guide

For an easy to following developer guide, check out our [PHP Developer Guide](https://currencyapi.net/sdk/php).

Alternatively keep reading below.

#### Prerequisites

- Minimum PHP 8.1+
- Working on PHP 8.5
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

Returns the latest exchange rates for all supported currencies.

```php
$result = $currencyApi->rates();
```

Example with all available methods:
```php
$result = $currencyApi
    ->setBase('USD')
    ->setOutput('JSON')
    ->rates();
```
**Available methods for rates endpoint**

| Methods | Description |
| --- | --- |
| `setBase()` | The base currency you wish you receive the currency conversions for. This will output all currency conversions for that currency. **Default: USD**. |
| `setOutput()` | Response output in either JSON or XML. **Default: JSON**. |

<br>

### List of available currencies:

Returns a list of all currencies supported by the API.

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

Converts an amount from one currency to another using the latest rates.

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

Returns exchange rates for all currencies on a specific date.

```php
$result = $currencyApi->setDate('2019-01-01')->historical();
```

Example with all available methods:

```php
$result = $currencyApi
    ->setDate('2019-01-01')
    ->setBase('GBP')
    ->setOutput('JSON')
    ->historical();
```

**Available methods for historical endpoint**

| Methods | Description |
| --- | --- |
| `setDate()` | The historical date you wish to receive the currency conversions for. This should be formatted as YYYY-MM-DD. **Required**. |
| `setBase()` | The base currency you wish you receive the currency conversions for. This will output all currency conversions for that currency. **Default: USD**. |
| `setOutput()` | Response output in either JSON or XML. **Default: JSON**. |

<br>

### Timeframe:

Returns exchange rates for all currencies across a date range, with one entry per day.

```php
$result = $currencyApi->setStartDate('2019-01-01')->setEndDate('2019-01-05')->timeframe();
```

Example with all available methods:

```php
$result = $currencyApi
    ->setStartDate('2019-01-01')
    ->setEndDate('2019-01-05')
    ->setBase('GBP')
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

<br>

### OHLC (Open, High, Low, Close):

Returns candlestick data for a currency pair on a given date, useful for charting and technical analysis.

```php
$result = $currencyApi
    ->setQuote('EUR')
    ->setDate('2023-12-25')
    ->ohlc();
```

Example with all available methods:

```php
$result = $currencyApi
    ->setQuote('EUR')
    ->setDate('2023-12-25')
    ->setBase('GBP')
    ->setInterval('1h')
    ->ohlc();
```

**Available methods for OHLC endpoint**

| Methods | Description |
| --- | --- |
| `setQuote()` | The quote currency to retrieve OHLC data for. Three letter ISO 4217 currency code. **Required**. |
| `setDate()` | The date to retrieve OHLC data for. This should be formatted as YYYY-MM-DD. **Required**. |
| `setBase()` | The base currency for the rates. **Default: USD**. |
| `setInterval()` | The interval for the OHLC candles. One of: `5m`, `15m`, `30m`, `1h`, `4h`, `12h`, `1d`. **Default: 1d**. |

**Example response:**

```json
{
    "valid": true,
    "base": "USD",
    "quote": "EUR",
    "date": "2023-12-25",
    "interval": "1d",
    "ohlc": [
        {
            "start": "2023-12-25T00:00:00Z",
            "open": 0.9123,
            "high": 0.9187,
            "low": 0.9098,
            "close": 0.9154
        }
    ]
}
```
