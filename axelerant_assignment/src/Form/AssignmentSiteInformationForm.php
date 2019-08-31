<?php

namespace Drupal\axelerant_assignment\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings for this site.
 */
class AssignmentSiteInformationForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form = parent::buildForm($form, $form_state);
    $site_api_key = $site_config->get('siteapikey');

    $form['site_information']['site_api_key'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => isset($site_api_key) ? $site_api_key : 'No API Key yet',
      '#description' => $this->t('Site API Key'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')
      ->set('siteapikey', $form_state->getValue('site_api_key'))
      ->save();
    $this->messenger()->addStatus($this->t('Site API Key has been saved.'));
    parent::submitForm($form, $form_state);
  }
}