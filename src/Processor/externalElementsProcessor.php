<?php


namespace Drupal\orejime_complient_videos\Processor;


use DOMDocument;
use DOMXPath;
use Drupal\Component\Utility\Crypt;
use Drupal\Component\Utility\Html;
use Drupal\Console\Bootstrap\Drupal;
use Drupal\Core\Render\Markup;

class externalElementsProcessor {

  public function process($text) {

    $dom = Html::load($text);
    $xpath = new DOMXPath($dom);
    $renderer = \Drupal::service('renderer');

    $queries = [];

    foreach (orejime_complient_videos_concerned_websites() as $website) {
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

      #$test = $dom->createDocumentFragment();
      #$test->appendXML($renderer->render($element));

      #$domNode->parentNode->replaceChild($test, $domNode);
      $this->set_inner_html($domNode, $renderer->render($element));
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

  function set_inner_html($element, $content) {
    $DOM_inner_HTML = new DOMDocument();
    $internal_errors = libxml_use_internal_errors(TRUE);
    $DOM_inner_HTML->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
    libxml_use_internal_errors($internal_errors);
    $content_node = $DOM_inner_HTML->getElementsByTagName('body')->item(0);
    $content_node = $element->ownerDocument->importNode($content_node, TRUE);
    while ($element->hasChildNodes()) {
      $element->removeChild($element->firstChild);
    }
    $element->parentNode->replaceChild($content_node, $element);
  }

}
