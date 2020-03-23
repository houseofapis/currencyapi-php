# CurrencyApi PHP wrapper 

<img src="https://user-images.githubusercontent.com/42932986/77355951-4ff35080-6d3d-11ea-88a9-20fee97adb04.png" width="104" height="20" /><br>

<a href="https://currencyapi.net" title="CurrencyApi">CurrencyApi.net</a> provides live currency rates via a REST API. A live currency feed for over 152 currencies, including physical (USD, GBP, EUR + more) and cryptos (Bitcoin, Litecoin, Ethereum + more). A JSON and XML currency api updated every 60 seconds. 

Features:

- Live exchange rates (updated every 60 seconds).
- 152 currencies world currencies.
- Popular cryptocurrencies included; Bitcoin, Litecoin etc.
- Convert currencies on the fly with the convert endpoint.
- Historical currency rates back to year 2000.
- Easy to follow <a href="https://currencyapi.net/documentation" title="currency-api-documentation">documentation</a>

Signup for a free or paid account <a href="https://currencyapi.net/#pricing-sec" title="currency-api-pricing">here</a>.

## This package

PHP wrapper for <a href="https://currencyapi.net" title="CurrencyApi">CurrencyApi.net</a> endpoints.

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

