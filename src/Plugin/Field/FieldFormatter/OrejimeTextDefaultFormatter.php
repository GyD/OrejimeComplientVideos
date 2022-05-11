<?php

namespace Drupal\orejime_complient_videos\Plugin\Field\FieldFormatter;

use DOMXPath;
use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\text\Plugin\Field\FieldFormatter\TextDefaultFormatter;

/**
 * Plugin implementation of the 'text_default' formatter.
 *
 * @FieldFormatter(
 *   id = "orejime_text_default",
 *   label = @Translation("Orejime Text Default"),
 *   field_types = {
 *     "text",
 *     "text_long",
 *     "text_with_summary",
 *   }
 * )
 */
class OrejimeTextDefaultFormatter extends TextDefaultFormatter {

  use OrejimeWrapperTrait;


  /**
   * @param $item
   *
   * @return bool
   */
  protected function needWrapper($item) {
    $value = $item->getValue();

    if (isset($value['value'])) {
      $dom = Html::load($value['value']);
      $xpath = new DOMXPath($dom);

      foreach ($xpath->query('//*[@src]') as $domNode) {
        $url = UrlHelper::parse($domNode->getAttribute('src'));

        foreach (orejime_complient_videos_concerned_websites() as $website) {
          if (stripos($url['path'], $website) !== FALSE) {
            return TRUE;
          }
        }
      }
    }
    return FALSE;
  }

}
