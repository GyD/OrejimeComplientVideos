<?php

namespace Drupal\orejime_complient_videos\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;

/**
 * Trait OrejimeWrapperTrait
 *
 * @package Drupal\orejime_complient_videos\Plugin\Field\FieldFormatter
 */
trait OrejimeWrapperTrait {

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
      if ($this->needWrapper($items[$key])) {
        $element = [
          '#theme' => 'orejime_video',
          '#original' => $element,
          // videoID is parentID (entity type + drupal id) followed by position in the array
          '#contentID' => $parentID . '--' . $key,
        ];
      }
    }

    return $elements;
  }

  /**
   * @param $item
   *
   * @return false
   */
  protected function needWrapper($item) {
    return FALSE;
  }

}
