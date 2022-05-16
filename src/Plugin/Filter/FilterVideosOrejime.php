<?php

namespace Drupal\orejime_videos\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\orejime_videos\Processor\embededContentProcessor;
use Drupal\orejime_videos\Processor\externalElementsProcessor;
use Drupal\orejime_videos\Processor\iFrameProcessor;

/**
 * Provides a filter to convert URLs into links.
 *
 * @Filter(
 *   id = "filter_videos_orejime",
 *   title = @Translation("Convert Videos into Orejime Videos"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE
 * )
 */
class FilterVideosOrejime extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $processor = new externalElementsProcessor();
    $result = new FilterProcessResult($text);

    $processedText = $processor->process($text);

    $result->setProcessedText($processedText);

    return $result;
  }

}
