<?php

namespace Drupal\orejime_videos\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\orejime_videos\Processor\externalElementsProcessor;

/**
 * Provides a filter to convert URLs into links.
 *
 * @Filter(
 *     id="filter_videos_orejime",
 *     title=@Translation("Convert Videos into Orejime Videos"),
 *     type=Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *     settings={
 *         "filtered_consents": "youtube.com|youtube
youtu.be|youtube
vimeo.com|vimeo
twitter.com|twitter",
 *     }
 * )
 */
class FilterVideosOrejime extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $processor = new externalElementsProcessor();
    $result = new FilterProcessResult($text);

    $processedText = $processor->process($text, $this->getConsentsSettings());

    $result->setProcessedText($processedText);

    return $result;
  }

  /**
   * @return array
   */
  private function getConsentsSettings() {
    $consents = [];

    foreach (preg_split("/(\r\n|\n|\r)/", $this->settings["filtered_consents"]) as $line) {
      [$host, $consent] = explode('|', $line);
      $consents[$host] = $consent;
    }

    return $consents;
  }


  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['filtered_consents'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Consents filtered for orejime embed'),
      '#default_value' => $this->settings['filtered_consents'],
      '#description' => $this->t('A list of host name and orejime constent domain. Please enter them one per line with the followed format: host.ext|consent'),
      '#attached' => [],
    ];
    return $form;
  }

}
