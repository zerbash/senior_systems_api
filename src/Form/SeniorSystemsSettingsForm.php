<?php

namespace Drupal\senior_systems_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures Senior Systems module settings.
 */
class SeniorSystemsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'senior_systems_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['senior_systems_api.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('senior_systems_api.settings');
    
    $form['url'] = [
      '#type' => 'url',
      '#title' => 'URL',
      '#description' => $this->t('Enter the complete URL used to connect to Senior Systems.'),
      '#default_value' => $config->get('url'),
    ];
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#description' => $this->t('This username must be linked to an administrator role.'),
      '#default_value' => $config->get('username'),
    ];
    $form['password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Password'),
      '#default_value' => $config->get('password'),
    ];    
    
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    foreach($values as $key => $value){
      $this->config('senior_systems_api.settings')
        ->set($key, $value)
        ->save();        
    }
    $message = $this->t('Your configuration has been saved.');
    drupal_set_message($message);
  }
 
}