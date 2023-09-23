<?php
namespace HouseOfApis\CurrencyApi;

use Exception;
use HouseOfApis\CurrencyApi\Exceptions\BadRequestException;
use HouseOfApis\CurrencyApi\Exceptions\ConnectException;

/**
 * Class CurrencyApi
 * @package HouseOfApis\CurrencyApi
 */
class CurrencyApi
{
    /**
     * Base CurrencyApi Url
     */
    const BASE_URL = 'https://currencyapi.net/api/';

    /**
     * Version of the API
     */
    const API_VERSION = 'v1';

    /**
     * Default base currency
     */
    const DEFAULT_BASE = 'USD';

    /**
     * Default output format. This is either JSON or XML
     */
    const DEFAULT_OUTPUT = 'JSON';

    /**
     * Api key from your account on CurrencyApi
     * If you don't have a key, sign up free here -> https://currencyapi.net/
     *
     * @var string
     */
    private $key = '';

    /**
     * The base / source currency you wish you receive the currency conversions for
     *
     * @var string
     */
    protected $base = self::DEFAULT_BASE;

    /**
     * Response output in either JSON or XML
     *
     * @var string
     */
    protected $output = self::DEFAULT_OUTPUT;

    /**
     * Limit which currency conversions are returned
     * Comma separated values
     * eg: 'USD,GBP,BTC'
     *
     * @var string
     */
    protected $limit = '';

    /**
     * The value of the currency you want to convert from.
     * This should be a number and can contain a decimal place.
     *
     * @var int|float
     */
    protected $amount = 0.00;

    /**
     * The currency you want to convert.
     * This will be a three letter ISO 4217 currency code
     *
     * @var string
     */
    protected $convertFrom = '';

    /**
     * The currency you want to convert the amount to.
     * This will be a three letter ISO 4217 currency code
     *
     * @var string
     */
    protected $convertTo = '';

    /**
     * The historical date you wish to receive the currency conversions for.
     * This should be formatted as YYYY-MM-DD.
     *
     * @var string
     */
    protected $date = '';

    /**
     * The historical date you wish to receive the currency conversions from.
     * This should be formatted as YYYY-MM-DD.
     *
     * @var string
     */
    protected $start_date = '';

    /**
     * The historical date you wish to receive the currency conversions until.
     * This should be formatted as YYYY-MM-DD.
     *
     * @var string
     */
    protected $end_date = '';

    /**
     * CurrencyApi constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Sets the base currency
     * See base property for description ^
     *
     * @param string $base
     * @return CurrencyApi
     */
    public function setBase(string $base) : CurrencyApi
    {
        $this->base = strtoupper($base);
        return $this;
    }

    /**
     * Sets the output format
     * See output property for description ^
     *
     * @param string $output
     * @return CurrencyApi
     */
    public function setOutput(string $output) : CurrencyApi
    {
        $this->output = strtoupper($output);
        return $this;
    }

    /**
     * Sets the limit of currencies returned
     * See limit property for description ^
     *
     * @param string $limit
     * @return CurrencyApi
     */
    public function setLimit(string $limit) : CurrencyApi
    {
        $this->limit = str_replace(' ', '', strtoupper($limit));
        return $this;
    }

    /**
     * Sets the amount to convert
     * See amount property for description ^
     *
     * @param int|float $amount
     * @return CurrencyApi
     */
    public function setAmount($amount) : CurrencyApi
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Sets the currency to convert from
     * See convertFrom property for description ^
     *
     * @param string $convertFrom
     * @return CurrencyApi
     */
    public function setFrom(string $convertFrom) : CurrencyApi
    {
        $this->convertFrom = $convertFrom;
        return $this;
    }

    /**
     * Sets the currency to convert to
     * See convertTo property for description ^
     *
     * @param string $convertTo
     * @return CurrencyApi
     */
    public function setTo(string $convertTo) : CurrencyApi
    {
        $this->convertTo = $convertTo;
        return $this;
    }

    /**
     * Sets the historical date
     * See date property for description ^
     *
     * @param string $date
     * @return CurrencyApi
     */
    public function setDate(string $date) : CurrencyApi
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Sets the start date when using timeframe
     * See start_date property for description ^
     *
     * @param string $start_date
     * @return CurrencyApi
     */
    public function setStartDate(string $start_date) : CurrencyApi
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * Sets the end date when using timeframe
     * See end_date property for description ^
     *
     * @param string $end_date
     * @return CurrencyApi
     */
    public function setEndDate(string $end_date) : CurrencyApi
    {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * Get the live rates
     *
     * @return array
     * @throws BadRequestException
     * @throws ConnectException
     */
    public function rates() : array
    {
        return $this->get($this->buildUrl('rates', $this->getCommonBaseAndLimit()));
    }

    /**
     * Get list of currencies offered
     *
     * @return array
     * @throws BadRequestException
     * @throws ConnectException
     */
    public function currencies() : array
    {
        return $this->get($this->buildUrl('currencies'));
    }

    /**
     * Convert an amount from one currency to another
     *
     * @return array
     * @throws BadRequestException
     * @throws ConnectException
     */
    public function convert() : array
    {
        return $this->get($this->buildUrl('convert', $this->getConvertParams()));
    }

    /**
     * Get historical currency data from a single day
     *
     * @return array
     * @throws BadRequestException
     * @throws ConnectException
     */
    public function historical() : array
    {
        return $this->get($this->buildUrl('history', $this->getHistoricalParams()));
    }

    /**
     * Get historical currency data within a time period
     *
     * @return array
     * @throws BadRequestException
     * @throws ConnectException
     */
    public function timeframe() : array
    {
        return $this->get($this->buildUrl('timeframe', $this->getTimeFrameParams()));
    }

    /**
     * Prepares parameters for the convert endpoint
     *
     * @return array
     */
    protected function getConvertParams() : array
    {
        return [
            'amount' => $this->amount,
            'from' => $this->convertFrom,
            'to' => $this->convertTo
        ];
    }

    /**
     * Prepares parameters for the history endpoint
     *
     * @return array
     */
    protected function getHistoricalParams() : array
    {
        return array_merge(['date' => $this->date], $this->getCommonBaseAndLimit());
    }

    /**
     * Prepares parameters for the timeframe endpoint
     *
     * @return array
     */
    protected function getTimeFrameParams() : array
    {
        return array_merge([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ], $this->getCommonBaseAndLimit());
    }

    /**
     * Adds commonly used base and limit parameters if they are set
     *
     * @return array
     */
    protected function getCommonBaseAndLimit() : array
    {
        $queryParams = [];

        if($this->base !== self::DEFAULT_BASE) {
            $queryParams['base'] = $this->base;
        }
        if(!empty($this->limit)) {
            $queryParams['limit'] = $this->limit;
        }
        return $queryParams;
    }

    /**
     * Prepares parameters available for all endpoints
     *
     * @return array
     */
    protected function getSharedParams() : array
    {
        $commonParams['key'] = $this->key;
        if($this->output !== self::DEFAULT_OUTPUT) {
            $commonParams['output'] = $this->output;
        }
        return $commonParams;
    }

    /**
     * Build the URL
     *
     * @param string $endpoint
     * @param array $urlParams
     * @return string
     */
    protected function buildUrl(string $endpoint, array $urlParams = []) : string
    {
        return self::BASE_URL . self::API_VERSION . '/' . $endpoint . '?'
            . http_build_query(array_merge($urlParams, $this->getSharedParams()));
    }


    /**
     * Make request to CurrencyApi.net using cUrl
     * Endpoints return 200 when data is retrieved successfully
     * Endpoints return 400 when something is wrong with the request (api incorrect)
     *
     * Example of what's returned:
     *      [
     *          [valid] => true
     *          [timestamp] => 1583182512
     *          [base] => GBP
     *          [rates] => [
     *              [AED] => 4.68987
     *              [AFN] => 96.59355
     *              [ALL] => 141.63396
     *              ...
     *          ]
     *      ]
     *
     * Exceptions:
     *      if connection issue (timeout etc), throw custom ConnectException
     *      if response code is above 400, throw general exception
     *      if response has an error or returns a 400, throw BadRequestException
     *
     * @param string $url
     * @param int $timeout
     * @return array
     * @throws BadRequestException
     * @throws ConnectException
     * @throws Exception
     */
    protected function get(string $url, int $timeout = 5) : array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Sdk: PHP'
        ]);

        $responseBody = curl_exec($ch);

        if (curl_errno($ch) || $responseBody === false) {
            throw new ConnectException('Connection exception ' . curl_error($ch));
        }
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($responseCode > 400) {
            throw new Exception("The url ($url) returned response code $responseCode. Response: ".print_r($responseBody, true));
        }
        if($this->output === 'XML') {
            $responseBody = json_encode(simplexml_load_string($responseBody));
        }

        $response = json_decode($responseBody, true);
        if (array_key_exists('error', $response) || $responseCode === 400) {
            $message = !empty($response['error']['message']) ? (string)$response['error']['message'] : (string)$responseBody;
            $code = !empty($response['error']['code']) ? (int)$response['error']['code'] : 400;
            throw new BadRequestException($message, $code);
        }

        curl_close($ch);
        return $response;
    }
}
