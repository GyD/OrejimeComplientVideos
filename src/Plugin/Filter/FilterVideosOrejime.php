<?php

namespace Drupal\orejime_complient_videos\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\orejime_complient_videos\Processor\YoutubeProcessor;

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
    // <iframe width height src title frameborder allow allowfullscreen>
    $youtubeProcessor = new YoutubeProcessor();
    $result = new FilterProcessResult($text);

    $processedText = $youtubeProcessor->preprocess($text);
    $processedText = $youtubeProcessor->process($processedText);


    $result->setProcessedText($processedText);

    return $result;
  }

}
