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
      $queries[] = "//*[contains(@src,'{$website}')]";
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
   * @param $element
   * @param $content
   */
  private function setInnerHtml($originalElement, $html) {
    $tmpDOM = new DOMDocument();
    $internal_errors = libxml_use_internal_errors(TRUE);
    $tmpDOM->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
    libxml_use_internal_errors($internal_errors);
    $contentNode = $tmpDOM->getElementsByTagName('body')->item(0);
    $contentNode = $element->ownerDocument->importNode($contentNode, TRUE);
    while ($element->hasChildNodes()) {
      $element->removeChild($element->firstChild);
    }
    $element->parentNode->replaceChild($contentNode, $element);
  }

}
