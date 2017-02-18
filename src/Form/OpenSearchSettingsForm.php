<?php

namespace Drupal\opensearchtab\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Open Search Tab settings for this site.
 */
class OpenSearchSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'opensearchtab_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['opensearchtab.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('opensearchtab.settings');

    $form['opensearchtab_shortname'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Short name'),
      '#default_value' => $config->get('shortname'),
    );

    $form['opensearchtab_description'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('description'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!$form_state->isValueEmpty('opensearchtab_shortname')) {
      if (strlen($form_state->getValue('opensearchtab_shortname')) < 3) {
        $form_state->setErrorByName('opensearchtab_shortname', t('Short name is less than 3 characters'));
      }
    }

    if (!$form_state->isValueEmpty('opensearchtab_description')) {
      if (strlen($form_state->getValue('opensearchtab_description')) < 10) {
        $form_state->setErrorByName('opensearchtab_description', t('Short name is less than 10 characters'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('opensearchtab.settings')
      ->set('shortname', $form_state->getValue('opensearchtab_shortname'))
      ->set('description', $form_state->getValue('opensearchtab_description'))
      ->save();
  }

}
