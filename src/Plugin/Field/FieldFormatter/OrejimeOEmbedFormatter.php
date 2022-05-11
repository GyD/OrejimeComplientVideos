<?php

namespace Drupal\orejime_complient_videos\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\media\Plugin\Field\FieldFormatter\OEmbedFormatter;
use http\Url;

/**
 * Plugin implementation of the 'oembed' formatter.
 *
 * @internal
 *   This is an internal part of the oEmbed system and should only be used by
 *   oEmbed-related code in Drupal core.
 *
 * @FieldFormatter(
 *   id = "orejime_oembed",
 *   label = @Translation("Orejime oEmbed content"),
 *   field_types = {
 *     "link",
 *     "string",
 *     "string_long",
 *   },
 * )
 */
class OrejimeOEmbedFormatter extends OEmbedFormatter {

  use OrejimeWrapperTrait;

  /**
   * @param $item
   *
   * @return bool
   */
  protected function needWrapper($item) {
    $value = $item->getValue();

    if (isset($value['value'])) {
      $url = UrlHelper::parse($value['value']);

      foreach (orejime_complient_videos_concerned_websites() as $website) {
        if (stripos($url['path'], $website) !== FALSE) {
          return TRUE;
        }
      }
    }

    return FALSE;
  }

}
