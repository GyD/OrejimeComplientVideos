<?php

namespace Drupal\orejime_videos\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Trait OrejimeWrapperTrait
 *
 * @package Drupal\orejime_videos\Plugin\Field\FieldFormatter
 */
trait OrejimeWrapperTrait {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'filtered_consents' => 'youtube.com|youtube
youtu.be|youtube
vimeo.com|vimeo
twitter.com|twitter',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return parent::settingsForm($form, $form_state) + [
        'filtered_consents' => [
          '#type' => 'textarea',
          '#title' => $this->t('Consents filtered for orejime embed'),
          '#default_value' => $this->getSetting('filtered_consents'),
          '#description' => $this->t('A list of host name and orejime consent domain. Please enter them one per line with the followed format: host.ext|consent'),
        ],
      ];
  }

  /**
   * {@inheritDoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = parent::viewElements($items, $langcode);

    // Get parent
    $parent = $items->getParent()->getEntity();
    // generate id based on parent entity type and entity id
    $parentID = $parent->getEntityTypeId() . '-' . $parent->id();

    foreach ($elements as $key => &$element) {
      if ($this->needWrapper($items[$key])) {
        $value = $items[$key]->getValue();
        $url = UrlHelper::parse($value['value']);

        $element = [
          '#theme' => 'orejime_video',
          '#original' => $element,
          '#contentID' => $parentID . '--' . $key,
          '#attributes' => [
            'width' => $element["#attributes"]["width"],
            'height' => $element["#attributes"]["height"],
          ],
          '#orejime_consent' => orejime_videos_get_orejime_consent_from_url($url['path'], $this->getSettingConsents()),
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
  protected function needWrapper($item): bool {
    return FALSE;
  }

  /**
   * @return array
   */
  private function getSettingConsents(): array {
    $consents = [];

    foreach (preg_split("/(\r\n|\n|\r)/", $this->settings["filtered_consents"]) as $line) {
      [$host, $consent] = explode('|', $line);
      $consents[$host] = $consent;
    }

    return $consents;
  }

}
