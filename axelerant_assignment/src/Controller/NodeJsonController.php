<?php

namespace Drupal\axelerant_assignment\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class NodeJsonController.
 *
 * Provides JSON representation of a node if API key is valid.
 */
class NodeJsonController extends ControllerBase {

  /**
   * Returns a JSON representation of a node.
   *
   * @param string $site_api_key
   *   The site API key provided in the request.
   * @param int $nid
   *   The node ID.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The JSON response containing node data or an access denied exception.
   */
  public function json_representation($site_api_key, $nid) {
    $site_api = $this->config('system.site')->get('siteapikey');
    $check_nid = \Drupal::entityQuery('node')
      ->condition('nid', $nid)
      ->condition('type', 'page')
      ->execute();

    if ($site_api_key != $site_api || empty($check_nid)) {
      throw new AccessDeniedHttpException();
    }
    else {
      $node = Node::load($nid);
      $json_array['data'][] = [
        'type' => $node->get('type')->value,
        'id' => $node->get('nid')->value,
        'attributes' => [
          'title' => $node->get('title')->value,
          'content' => $node->get('body')->value,
        ],
      ];
      return new JsonResponse($json_array);
    }
  }

}
