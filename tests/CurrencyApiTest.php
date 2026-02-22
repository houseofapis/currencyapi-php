<?php
namespace HouseOfApis\Tests;

use Exception;
use HouseOfApis\CurrencyApi\CurrencyApi;
use HouseOfApis\CurrencyApi\Exceptions\BadRequestException;
use HouseOfApis\CurrencyApi\Exceptions\ConnectException;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class CurrencyApiTest extends TestCase
{
    use PHPMock;

    protected $currencyApi;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        $this->currencyApi = new CurrencyApi('123');
    }

    /**
     * Call the protected/private method of this class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     * @throws ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);

        return $method->invokeArgs($object, $parameters);
    }

    public function getProtectedProperty($object, $property)
    {
        $reflection = new \ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        return $reflection_property->getValue($object);
    }

    public function testGetCommonBaseDefaultBase()
    {
        $this->currencyApi->setBase('USD');
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getCommonBase');
        $this->assertArrayNotHasKey('base', $invokedMethod);
        $this->assertEmpty($invokedMethod);
    }

    public function testGetCommonBaseNotDefaultBase()
    {
        $this->currencyApi->setBase('GBP');
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getCommonBase');
        $this->assertArrayHasKey('base', $invokedMethod);
        $this->assertContains('GBP', $invokedMethod);
    }

    public function testGetSharedParamsNotDefault()
    {
        $output = 'XML';
        $this->currencyApi->setOutput($output);
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getSharedParams');

        $this->assertContains($output, $invokedMethod);
        $this->assertArrayHasKey('output', $invokedMethod);
    }

    public function testGetSharedParamsDefault()
    {
        $output = 'JSON';
        $this->currencyApi->setOutput($output);
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getSharedParams');
        $this->assertArrayNotHasKey('output', $invokedMethod);
    }

    public function testSetBase()
    {
        $base = 'USD';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setBase($base));
        $this->assertEquals($base, $this->getProtectedProperty($this->currencyApi, 'base'));
    }

    public function testSetAmount()
    {
        $amount = 1;
        $this->assertEquals($this->currencyApi, $this->currencyApi->setAmount($amount));
        $this->assertEquals($amount, $this->getProtectedProperty($this->currencyApi, 'amount'));
    }

    public function testSetFrom()
    {
        $from = 'BTC';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setFrom($from));
        $this->assertEquals($from, $this->getProtectedProperty($this->currencyApi, 'convertFrom'));
    }

    public function testSetTo()
    {
        $from = 'EUR';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setTo($from));
        $this->assertEquals($from, $this->getProtectedProperty($this->currencyApi, 'convertTo'));
    }

    public function testSetDate()
    {
        $date = '2000-01-01';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setDate($date));
        $this->assertEquals($date, $this->getProtectedProperty($this->currencyApi, 'date'));
    }

    public function testSetStartDate()
    {
        $date = '2000-01-01';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setStartDate($date));
        $this->assertEquals($date, $this->getProtectedProperty($this->currencyApi, 'start_date'));
    }

    public function testSetEndDate()
    {
        $date = '2000-01-01';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setEndDate($date));
        $this->assertEquals($date, $this->getProtectedProperty($this->currencyApi, 'end_date'));
    }

    public function testSetQuote()
    {
        $quote = 'eur';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setQuote($quote));
        $this->assertEquals('EUR', $this->getProtectedProperty($this->currencyApi, 'quote'));
    }

    public function testSetInterval()
    {
        $interval = '1h';
        $this->assertEquals($this->currencyApi, $this->currencyApi->setInterval($interval));
        $this->assertEquals($interval, $this->getProtectedProperty($this->currencyApi, 'interval'));
    }

    public function testGetConvertParams()
    {
        $amount = 100;
        $from = 'USD';
        $to = 'EUR';
        $expected = [
            'amount' => $amount,
            'from' => $from,
            'to' => $to,
        ];
        $this->currencyApi->setAmount($amount);
        $this->currencyApi->setFrom($from);
        $this->currencyApi->setTo($to);
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getConvertParams');
        $this->assertEquals($expected, $invokedMethod);
    }

    public function testGetHistoricalParams()
    {
        $date = '2000-01-01';
        $this->currencyApi->setDate($date);
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getHistoricalParams');
        $this->assertEquals(['date' => $date], $invokedMethod);
    }

    public function testGetTimeFrameParams()
    {
        $start = '2000-01-01';
        $end = '2000-01-01';
        $this->currencyApi->setStartDate($start);
        $this->currencyApi->setEndDate($end);
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getTimeFrameParams');
        $this->assertEquals([
            'start_date' => $start,
            'end_date' => $end
        ], $invokedMethod);
    }

    public function testGetOhlcParams()
    {
        $quote = 'EUR';
        $date = '2023-12-25';
        $this->currencyApi->setQuote($quote);
        $this->currencyApi->setDate($date);
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getOhlcParams');
        $this->assertEquals([
            'quote' => $quote,
            'date' => $date,
        ], $invokedMethod);
    }

    public function testGetOhlcParamsWithBaseAndInterval()
    {
        $quote = 'EUR';
        $date = '2023-12-25';
        $base = 'GBP';
        $interval = '1h';
        $this->currencyApi->setQuote($quote);
        $this->currencyApi->setDate($date);
        $this->currencyApi->setBase($base);
        $this->currencyApi->setInterval($interval);
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'getOhlcParams');
        $this->assertEquals([
            'quote' => $quote,
            'date' => $date,
            'base' => $base,
            'interval' => $interval,
        ], $invokedMethod);
    }

    public function testBuildUrl()
    {
        $endpoint = 'rates';

        $urlParams = [];
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'buildUrl', [$endpoint, $urlParams]);
        $this->assertEquals('https://currencyapi.net/api/v2/rates?key=123', $invokedMethod);

        $urlParams = ['base' => 'BTC'];
        $this->currencyApi->setOutput('xMl');
        $invokedMethod = $this->invokeMethod($this->currencyApi, 'buildUrl', [$endpoint, $urlParams]);
        $this->assertEquals('https://currencyapi.net/api/v2/rates?base=BTC&key=123&output=XML', $invokedMethod);
    }

    public function testGetCurlError()
    {
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->once())->willReturn(false);
        $curl_errno = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_errno");
        $curl_errno->expects($this->once())->willReturn('');
        $this->expectException(ConnectException::class);
        $this->expectExceptionMessage('Connection exception ');
        $this->invokeMethod($this->currencyApi, 'get', ['http://test.com']);
    }

    public function testGetCurlErrorResponseCodeHigherThan400()
    {
        $expected = '{"valid": false, "error": {"code": 401, "message": "Your API key is not valid"}}';
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->once())->willReturn($expected);
        $curl_errno = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_getinfo");
        $curl_errno->expects($this->once())->willReturn(401);
        $this->expectException(Exception::class);
        $this->invokeMethod($this->currencyApi, 'get', ['http://test.com']);
    }

    public function testGetCurlErrorResponseCode400()
    {
        $expected = '{"valid": false}';
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->once())->willReturn($expected);
        $curl_errno = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_getinfo");
        $curl_errno->expects($this->once())->willReturn(400);
        $this->expectException(BadRequestException::class);
        $this->invokeMethod($this->currencyApi, 'get', ['http://test.com']);
    }

    public function testGetResponseBodyFalse()
    {
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->once())->willReturn(false);
        $this->expectException(ConnectException::class);
        $this->invokeMethod($this->currencyApi, 'get', ['http://test.com']);
    }

    public function testGetBadRequestExceptionJson()
    {
        $expected = '{"valid": false, "error": {"code": 401, "message": "Your API key is not valid"}}';
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->once())->willReturn($expected);
        $this->expectException(BadRequestException::class);
        $this->invokeMethod($this->currencyApi, 'get', ['http://test.com']);
    }

    public function testGetBadRequestExceptionXml()
    {
        $expected = '<root><valid/><error><code>401</code><message>Your API key is not valid</message></error></root>';
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->once())->willReturn($expected);
        $this->currencyApi->setOutput('XmL');
        $this->expectException(BadRequestException::class);
        $this->invokeMethod($this->currencyApi, 'get', ['http://test.com']);
    }

    public function testGet()
    {
        $expectedResponse = '{"valid": true, "updated": 1584738889, "base": "USD", "rates": {"AED": 3.67338, "AFN": 76.154}}';
        $expectedResult = [
            'valid' => true,
            'updated' => 1584738889,
            'base' => 'USD',
            'rates' => ['AED' => 3.67338, 'AFN' => 76.154]
        ];
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->once())->willReturn($expectedResponse);
        $method = $this->invokeMethod($this->currencyApi, 'get', ['http://test.com']);
        $this->assertEquals($expectedResult, $method);
    }

    public function testEndpointMethods()
    {
        $expectedResponse = '{"valid": true, "updated": 1584738889, "base": "USD", "rates": {"AED": 3.67338, "AFN": 76.154}}';
        $expectedResult = [
            'valid' => true,
            'updated' => 1584738889,
            'base' => 'USD',
            'rates' => ['AED' => 3.67338, 'AFN' => 76.154]
        ];
        $curl_exec = $this->getFunctionMock("HouseOfApis\CurrencyApi", "curl_exec");
        $curl_exec->expects($this->any())->willReturn($expectedResponse);
        $this->assertEquals($expectedResult, $this->currencyApi->rates());
        $this->assertEquals($expectedResult, $this->currencyApi->currencies());
        $this->assertEquals($expectedResult, $this->currencyApi->convert());
        $this->assertEquals($expectedResult, $this->currencyApi->historical());
        $this->assertEquals($expectedResult, $this->currencyApi->timeframe());
        $this->assertEquals($expectedResult, $this->currencyApi->ohlc());
    }
}


