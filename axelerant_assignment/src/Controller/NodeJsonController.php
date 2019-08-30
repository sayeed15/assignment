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
   * @return string
   *   Return Hello string.
   */
  public function json_representation($site_api_key, $nid) {
      $site_api = \Drupal::config('system.site')->get('siteapikey');
      $check_nid = \Drupal::entityQuery('node')->condition('nid', $nid)->execute();
      if ( $site_api_key != $site_api || empty($check_nid) ) {
          throw new AccessDeniedHttpException();
      } else {
          $node =  Node::load($nid);
          $json_array['data'][] = array(
              'type' =>  $node->get('type')->value,
              'id' => $node->get('nid')->value,
              'attributes' => array(
                  'title' =>  $node->get('title')->value,
                  'content' => $node->get('body')->value,
              ),
          );
          return new JsonResponse($json_array);
      }
  }

}
