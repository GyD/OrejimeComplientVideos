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
 *         "filtered_domains": "youtube.com|youtube
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

    $processedText = $processor->process($text, $this->getDomainSettings());

    $result->setProcessedText($processedText);

    return $result;
  }

  /**
   * @return array
   */
  private function getDomainSettings() {
    $domains = [];

    foreach (preg_split("/(\r\n|\n|\r)/", $this->settings["filtered_domains"]) as $line) {
      [$host, $domain] = explode('|', $line);
      $domains[$host] = $domain;
    }

    return $domains;
  }


  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['filtered_domains'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Domains filtered for orejime embed'),
      '#default_value' => $this->settings['filtered_domains'],
      '#description' => $this->t('A list of host name and orejime constent domain. Please enter them one per line with the followed format: host.ext|consent'),
      '#attached' => [],
    ];
    return $form;
  }

}
