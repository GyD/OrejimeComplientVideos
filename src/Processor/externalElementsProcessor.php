<?php

namespace Drupal\orejime_videos\Processor;

use DOMDocument;
use DOMXPath;
use Drupal;
use Drupal\Component\Utility\Crypt;
use Drupal\Component\Utility\Html;

class externalElementsProcessor {

  /**
   * @param $text
   *
   * @return string
   */
  public function process($text) {

    $dom = Html::load($text);
    $xpath = new DOMXPath($dom);
    $renderer = Drupal::service('renderer');

    $queries = [];

    foreach (orejime_videos_filtered_domains() as $website) {
      /**
       * Selector select:
       *  - elements with SRC attribute that contain the website domain name,
       *    that are not <source> and that do not have <picture> for parent ( <picture> can embed <img> )
       *  - <video> and <audio> elements that have a children with a SRC attribute
       *
       *  Tip: use http://xpather.com to test selector
       */
      $queries[] = "//*[(not(self::source) and contains(@src,\"{$website}\") and not(parent::picture)) or ((self::video or self::audio or self::picture) and .//*[contains(@src, \"{$website}\")])]";
    }

    foreach ($xpath->query(implode('|', $queries)) as $domNode) {
      /** @var \DOMElement $domNode */

      $html = $dom->saveHTML($domNode);

      $element = [
        '#theme' => 'orejime_video',
        '#original' => $html,
        '#contentID' => $this->getContentKey($html),
      ];

      $this->setInnerHtml($domNode, $renderer->render($element));
    }

    return Html::serialize($dom);
  }

  /**
   * @param $content
   *
   * @return mixed
   */
  private function getContentKey($content) {
    return Crypt::hashBase64($content);
  }

  /**
   * @param $originalElement
   * @param $html
   */
  private function setInnerHtml($originalElement, $html) {
    $tmpDOM = new DOMDocument();
    $tmpDOM->loadHTML($html);
    $contentNode = $tmpDOM->getElementsByTagName('body')->item(0);
    $contentNode = $originalElement->ownerDocument->importNode($contentNode, TRUE);
    while ($originalElement->hasChildNodes()) {
      $originalElement->removeChild($originalElement->firstChild);
    }
    $originalElement->parentNode->replaceChild($contentNode, $originalElement);
  }

}
