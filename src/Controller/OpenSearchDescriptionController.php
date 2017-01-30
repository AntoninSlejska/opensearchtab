<?php

/**
 * Contains \Drupal\opensearchtab\Controller\OpenSearchDescriptionController class.
 */

namespace Drupal\opensearchtab\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * OpenSearchDescriptionController .
 */
class OpenSearchDescriptionController
{

  /**
   * {@inheritdoc}
   */
  public function content() {
    // Prepare variables for the XML content.
    $config = \Drupal::config('system.site');
    $short_name = !empty($config->get('name')) ? $config->get('name') : 'Drupal site';
    $description = !empty($config->get('slogan')) ? $config->get('slogan') : 'Search the site';
    $template = \Drupal::request()->getSchemeAndHttpHost() . '/search/node?keys={searchTerms}';

    // Define the XML content.
    $openTag = new \SimpleXMLElement('<OpenSearchDescription></OpenSearchDescription>');
    $openTag->addAttribute('xmlns', 'http://a9.com/-/spec/opensearch/1.1/');
    $openTag->addChild('ShortName', $short_name);
    $openTag->addChild('Description', $description);
    $url = $openTag->addChild('Url');
    $url->addAttribute('type', 'text/html');
    $url->addAttribute('method', 'get');
    $url->addAttribute('template', $template);

    // Prepare the response.
    $response = new Response();
    $response->setContent($openTag->asXML());
    $response->headers->set('Content-type', 'text/xml');

    return $response;
  }
  
}
