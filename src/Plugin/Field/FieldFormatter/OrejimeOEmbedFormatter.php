<?php

namespace Drupal\orejime_complient_videos\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
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

  /**
   * {@inheritDoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = parent::viewElements($items, $langcode);

    return [
      '#theme' => 'orejime_video',
      '#original' => $element,
      '#videoID' => 'test',
      "#attached" => [
        "library" => [
          'orejime_complient_videos/orejimeVideos',
        ]
      ],
    ];
  }

}
