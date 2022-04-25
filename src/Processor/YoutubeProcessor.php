<?php

namespace Drupal\orejime_complient_videos\Processor;

use Drupal;
use Drupal\Component\Utility\Html;

/**
 * Class YoutubeProcessor
 *
 * @package Drupal\orejime_complient_videos\Processor
 */
class YoutubeProcessor {

  /**
   * @var array
   */
  private $videos = [];

  /**
   * @param $text
   *
   * @return array|mixed|string|string[]
   */
  public function process($text) {
    $processedText = $text;
    $renderer = Drupal::service('renderer');

    foreach ($this->videos as $videoID => $video) {

      $renderable = [
        '#theme' => 'orejime_video',
        '#original' => $video['source'],
        '#videoID' => 'orejime-youtube-' . $videoID
      ];

      $rendered = $renderer->render($renderable);

      $processedText = str_ireplace('[orejime-youtube=' . $videoID . ']', $rendered, $processedText);
    }

    return $processedText;
  }

  /**
   * @param $text
   *
   * @return array|mixed|string|string[]
   */
  public function preprocess($text) {
    preg_match_all('/<iframe[^>]*src\s*=\s*"?https?:\/\/[^\s"\/]*youtube.com(?:\/embed)\/([^\s"]*)?"?[^>]*>.*?<\/iframe>/i', $text, $matches);

    $processedText = $text;

    foreach ($matches[1] as $k => $videoID) {
      if (!empty($videoID)) {

        $this->videos[$videoID] = [
          'source' => $matches[0][$k]
        ];

        $processedText = str_ireplace($matches[0][$k], '[orejime-youtube=' . $videoID . ']', $text);
      }
    }

    return $processedText;

  }

}
