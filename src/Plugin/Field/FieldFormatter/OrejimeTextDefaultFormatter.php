<?php

namespace Drupal\orejime_videos\Plugin\Field\FieldFormatter;

use DOMXPath;
use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\UrlHelper;
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
  protected function needWrapper($item): bool {
    $value = $item->getValue();

    if (isset($value['value'])) {
      $dom = Html::load($value['value']);
      $xpath = new DOMXPath($dom);

      foreach ($xpath->query('//*[@src]') as $domNode) {
        $url = UrlHelper::parse($domNode->getAttribute('src'));

        foreach (orejime_videos_filtered_domains() as $website) {
          if (stripos($url['path'], $website) !== FALSE) {
            return TRUE;
          }
        }
      }
    }
    return FALSE;
  }

}
