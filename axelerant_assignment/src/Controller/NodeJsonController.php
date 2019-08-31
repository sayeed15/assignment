<?php

namespace Drupal\axelerant_assignment\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class NodeJsonController.
 */
class NodeJsonController extends ControllerBase {

  /**
   * Json_representation.
   *
   * @param $site_api_key site key
   * @param $nid nid
   *
   * @return string json response
   */
  public function json_representation($site_api_key, $nid) {
    $site_api = $this->config('system.site')->get('siteapikey');
    $check_nid = \Drupal::entityQuery('node')
      ->condition('nid', $nid)
      ->condition('type', 'page')->execute();

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
