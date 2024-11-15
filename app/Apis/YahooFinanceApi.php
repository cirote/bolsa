<?php

namespace App\Apis;

use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use Scheb\YahooFinanceApi\Results\HistoricalData;

class YahooFinanceApi
{
    private static $objeto = null;

    static function get()
    {
        if (! static::$objeto)
        {
            static::$objeto = new static();
        }

        return static::$objeto;
    }

    private $client;

    public function __construct()
    {
        $this->client = ApiClientFactory::createApiClient();
    }

    public function getCotizador(string $stock)
    {
        return $this->getQuote($stock);
    }

    public function getQuote(string $stock)
    {
        $quote = $this->client->getQuote($stock);

        if (! $quote) {
            return null;
        }

        return $quote;
    }

    public function getExchangeRate(string $currency1, string $currency2)
    {
        $quote = $this->client->getExchangeRate($currency1, $currency2);

        if (! $quote) {
            return null;
        }

        return $quote;
    }

    public function getHistoricalQuoteData(string $symbol, string $interval, $startDate, $endDate)
    {
        $time = \DateTime::createFromFormat('Y-m-d', "2024-02-08");

        $historicalData = $this->client->getHistoricalData($symbol, '1d', $time, $time);

        dd($historicalData);

        $quote = $this->client->getHistoricalQuoteData($symbol, $interval, $time, $time);

        if (! $quote) {
            return null;
        }

        return $quote;
    }
}