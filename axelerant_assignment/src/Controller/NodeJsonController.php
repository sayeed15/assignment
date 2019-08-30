<?php

namespace Drupal\axelerant_assignment\Controller;

use Drupal\Core\Controller\ControllerBase;

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
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: json_representation with parameter(s): $, $'),
    ];
  }

}
