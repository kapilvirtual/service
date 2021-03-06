<?php defined('SMW_ROOT_DIR') or die('Direct access is not allowed');?>
<div id="<?php print $widgetId;?>" class="<?php print $widgetClass?>" <?php print $widgetDataAttributes?>>
  <table>
    <thead>
      <tr>
      <?php foreach ($widgetFields as $code):?>
        <?php if ($code=='quote.regularMarketPrice'):?>
          <th class="smw-tablesort smw-Float">Purchase price</th>
        <?php endif ?>
        <th<?php print isset($liveDataFields[$code]->format)?' class="smw-tablesort smw-'.$liveDataFields[$code]->format.'"':''?>><?php print $liveDataFields[$code]->name?></th>
      <?php endforeach?>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($widgetSymbols as $i => $symbol): ?>
      <tr>
      <?php foreach ($widgetFields as $code):?>
        <?php if ($code=='quote.regularMarketPrice'):?>
        <td data-title="<?php print $liveDataFields[$code]->name?>">
          <span class="smw-portfolio-asset-price" data-value="<?php print $purchasePrices[$i] ?>"><?php print \PremiumStockMarketWidgets\Helper::formatDecimal($purchasePrices[$i], $env) ?></span>
        </td>
        <td class="smw-cell-with-indicator" data-title="<?php print $liveDataFields[$code]->name?>">
          <span class="smw-change-indicator" data-symbol="<?php print $symbol ?>">
            <i class="fa fa-arrow-down smw-arrow-icon smw-arrow-drop"></i>
            <i class="fa fa-arrow-up smw-arrow-icon smw-arrow-rise"></i>
          </span>
          <span class="smw-market-data-field" data-symbol="<?php print $symbol ?>" data-field="<?php print $code?>"></span>
        </td>
        <?php elseif(in_array($code,['quote.regularMarketChange','quote.regularMarketChangePercent'])):?>
        <td data-title="<?php print $liveDataFields[$code]->name?>">
          <span class="smw-portfolio-asset-<?php print str_replace('.','-',$code)?>" data-symbol="<?php print $symbol ?>"></span>
        </td>
        <?php else:?>
        <td data-title="<?php print $liveDataFields[$code]->name?>"><span class="smw-market-data-field" data-symbol="<?php print $symbol ?>" data-field="<?php print $code?>"></span></td>
        <?php endif?>
        <?php endforeach?>
      </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <?php foreach ($widgetFields as $code):?>
          <td class="smw-portfolio-total-<?php print str_replace('.','-',$code)?> <?php print in_array($code,['quote.regularMarketChange','quote.regularMarketChangePercent'])?'smw-change-indicator':''?>" colspan="<?php print $code=='quote.regularMarketPrice'?2:1?>" data-title="<?php print $liveDataFields[$code]->name?>"></td>
        <?php endforeach?>
      </tr>
    </tfoot>
  </table>
</div>
<script>
  (function ($) {
    $(document).ready(function() {
      var $widget = $('#<?php print $widgetId?>');
      $widget.on('psmwReadyGlobal', function (event) {
        var totalAbsChange = 0, totalPctChange = 0;
        var assetsCount = $widget.find('tbody tr').length;
        $widget.find('.smw-portfolio-asset-quote-regularMarketChange').each(function (i, element) {
          var $element = $(element);
          var $lastPriceChangeIndicator = $element.closest('tr').find('.smw-change-indicator');
          var purchasePrice = $element.closest('tr').find('.smw-portfolio-asset-price').data('value') || 0;
          var lastPrice = parseFloat($element.closest('tr').find('.smw-field-quote-regularMarketPrice').data('previous-value'));
          var change = lastPrice - purchasePrice;
          totalAbsChange += change;
          $element.text(purchasePrice > 0 ? change.formatNumber() : '-');
          if (change > 0) {
            $element.removeClass('smw-drop').addClass('smw-rise');
            $lastPriceChangeIndicator.removeClass('smw-drop').addClass('smw-rise');
          } else if (change < 0) {
            $element.removeClass('smw-rise').addClass('smw-drop');
            $lastPriceChangeIndicator.removeClass('smw-rise').addClass('smw-drop');
          } else {
            $element.removeClass('smw-drop smw-rise');
            $lastPriceChangeIndicator.removeClass('smw-drop smw-rise');
          }
        });
        $widget.find('.smw-portfolio-asset-quote-regularMarketChangePercent').each(function (i, element) {
          var $element = $(element);
          var purchasePrice = $element.closest('tr').find('.smw-portfolio-asset-price').data('value') || 0;
          var lastPrice = parseFloat($element.closest('tr').find('.smw-field-quote-regularMarketPrice').data('previous-value'));
          var change = 100 * (lastPrice / purchasePrice - 1);
          totalPctChange += change;
          $element.text(purchasePrice > 0 ? change.formatNumber()+'%' : '-');
          if (change > 0) {
            $element.removeClass('smw-drop').addClass('smw-rise');
          } else if (change < 0) {
            $element.removeClass('smw-rise').addClass('smw-drop');
          } else {
            $element.removeClass('smw-drop smw-rise');
          }
        });

        if (assetsCount>0) {
          var avgAbsChange = totalAbsChange / assetsCount;
          var avgPctChange = totalPctChange / assetsCount;
          $widget.find('.smw-portfolio-total-virtual-symbol').text('Total: ' + assetsCount);
          $widget.find('.smw-portfolio-total-quote-regularMarketChange').text(avgAbsChange.formatNumber()).addClass(avgAbsChange>0?'smw-rise':(avgAbsChange<0?'smw-drop':''));
          $widget.find('.smw-portfolio-total-quote-regularMarketChangePercent').text(avgPctChange.formatNumber()+'%').addClass(avgAbsChange>0?'smw-rise':(avgAbsChange<0?'smw-drop':''));
        }
        $widget.tablesort({ compare: premiumStockMarketWidgetsPlugin.tablesortCompare });
      });
    });
  })(jQuery);
</script>