<?php

namespace Drupal\orejime_videos\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\UrlHelper;
use Drupal\media\Plugin\Field\FieldFormatter\OEmbedFormatter;

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
  protected function needWrapper($item): bool {
    $value = $item->getValue();

    if (isset($value['value'])) {
      $url = UrlHelper::parse($value['value']);

      foreach (orejime_videos_filtered_domains() as $website) {
        if (stripos($url['path'], $website) !== FALSE) {
          return TRUE;
        }
      }
    }

    return FALSE;
  }

}
