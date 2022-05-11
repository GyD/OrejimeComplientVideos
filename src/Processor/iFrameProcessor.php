<?php

namespace Drupal\orejime_complient_videos\Processor;

use Drupal\orejime_complient_videos\Processor\embededContentProcessor;

/**
 * Class iFrameProcessor
 *
 * @package Drupal\orejime_complient_videos\Processor
 */
class iFrameProcessor extends embededContentProcessor {

  protected $contentIDprefix = 'orejime-iframe';

  /**
   * @param $text
   *
   * @return false|int|null
   */
  protected function getAllMatchs($text) {
    preg_match_all('/<iframe[^>]*src\s*=\s*"?https?:\/\/[^\s"\/]*youtube.com(?:\/embed)\/([^\s"]*)?"?[^>]*>.*?<\/iframe>/i', $text, $matches);

    return $matches;
  }

}
