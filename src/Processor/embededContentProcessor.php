<?php

namespace Drupal\orejime_complient_videos\Processor;

use Drupal;
use Drupal\Component\Utility\Html;

/**
 * Class embededContentProcessor
 *
 * @package Drupal\orejime_complient_videos\Processor
 */
class embededContentProcessor {

  /**
   * @var array
   */
  private $embededContents = [];

  /**
   * @param $text
   *
   * @return array|mixed|string|string[]
   */
  public function process($text) {
    $processedText = $text;
    $renderer = Drupal::service('renderer');

    foreach ($this->embededContents as $contentKey => $embededContent) {

      $renderable = [
        '#theme' => 'orejime_video',
        '#original' => $embededContent['source'],
        '#contentID' => $contentKey,
      ];

      $processedText = str_ireplace('[orejime-embeded=' . $contentKey . ']', $renderer->render($renderable), $processedText);
    }

    return $processedText;
  }

  /**
   * @param $text
   *
   * @return array|mixed|string|string[]
   */
  public function preprocess($text) {
    $matches = $this->getAllMatchs($text);
    $processedText = $text;

    foreach ($matches[0] as $content) {

      if (!empty($content)) {
        $contentKey = $this->getContentKey($content);

        $this->embededContents[$contentKey] = [
          'source' => $content,
        ];

        $processedText = str_ireplace($content, '[orejime-embeded=' . $contentKey . ']', $processedText);
      }
    }

    return $processedText;

  }

  /**
   * @param $text
   *
   * @return array
   */
  protected function getAllMatchs($text) {
    return [];
  }

  private function getContentKey($content) {
    return Drupal\Component\Utility\Crypt::hashBase64($content);
  }

}
