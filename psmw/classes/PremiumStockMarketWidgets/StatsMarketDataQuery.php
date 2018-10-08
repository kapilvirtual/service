<?php

namespace PremiumStockMarketWidgets;

class StatsMarketDataQuery extends MarketDataQuerySingle {
  private static $percentageFields = array(
    'summaryDetail.dividendYield',
    'summaryDetail.trailingAnnualDividendYield',
    'summaryDetail.payoutRatio',
    'defaultKeyStatistics.heldPercentInsiders',
    'defaultKeyStatistics.heldPercentInstitutions',
    'defaultKeyStatistics.shortPercentOfFloat',
    'defaultKeyStatistics.profitMargins',
    'defaultKeyStatistics.earningsQuarterlyGrowth',
    'financialData.grossMargins',
    'financialData.operatingMargins',
    'financialData.ebitdaMargins',
    'financialData.returnOnAssets',
    'financialData.returnOnEquity',
    'financialData.earningsGrowth',
    'financialData.revenueGrowth',
  );

  protected function initialize($env) {
    $serverNumber = $env->randomServer ? rand(1,2) : 1;
    $this->type = 'stats';
    $this->maxCacheTime = 900; // 15 minutes
    $this->dataUrl = 'https://query'.$serverNumber.'.finance.yahoo.com/v10/finance/quoteSummary/%s?formatted=false&modules=summaryProfile,summaryDetail,defaultKeyStatistics,financialData';
    $this->resultPropertyPath = 'quoteSummary.result';
  }

  protected function format($rawData, $arguments, $env) {
    $data = [];
    if (isset($arguments['fields'])) {
      foreach ($arguments['symbols'] as $symbol) {
        foreach ($arguments['fields'] as $field) {
          if (isset($rawData->$symbol) && is_object($rawData->$symbol)) {
            $value = Helper::getObjectProperty($rawData->$symbol, $field);
            if (in_array($field, self::$percentageFields))
              $value *= 100; // some values need to be converted to percentage
            $data[$symbol][$field] =
              isset($env->liveDataFields->$field->format) && method_exists('\PremiumStockMarketWidgets\Helper', 'format' . $env->liveDataFields->$field->format) ?
                call_user_func([
                  '\PremiumStockMarketWidgets\Helper',
                  'format' . $env->liveDataFields->$field->format
                ], $value, $env, $symbol) :
                $value;
          }
        }
      }
    }
    return $data;
  }
}