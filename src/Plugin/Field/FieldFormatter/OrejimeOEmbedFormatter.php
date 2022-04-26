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
    $elements = parent::viewElements($items, $langcode);

    // Get parent
    $parent = $items->getParent()->getEntity();
    // generate id based on parent entity type and entity id
    $parentID = $parent->getEntityTypeId() . '-' . $parent->id();

    foreach ($elements as $key => &$element) {
      $element = [
        '#theme' => 'orejime_video',
        '#original' => $element,
        // videoID is parentID (entity type + drupal id) followed by position in the array
        '#videoID' => $parentID . '--' . $key,
        "#attached" => [
          "library" => [
            'orejime_complient_videos/orejimeVideos',
          ],
        ],
      ];
    }

    return $elements;
  }

}