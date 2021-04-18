<?php

namespace Drupal\crud_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class EditForm extends FormBase
{
  public function getFormId()
  {

    // Unique ID of the form.
    return 'example_form_edit';
  }
  public function buildForm(array $form, FormStateInterface $form_state, $wid = NULL)
  {

    if(!empty($wid)) {
        $query = \Drupal::database()->select('crud_example', 'm');
        $query->condition('wid', $wid);
        $query->fields('m', ['first_name', 'last_name', 'email']);
        $results = $query->execute()->fetchAssoc();
    } else {

    }

    // Create a $form API array.
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#default_value' => $results['first_name']
    );
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#default_value' => $results['last_name']

    );
    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#default_value' => $results['email']
    );
    $form['wid'] = array(
      '#type' => 'hidden',
      '#default_value' => $wid
    );
    $form['save'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    );
    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state)
  {

    if ($form_state->getValue('wid') < 1) {
      $form_state->setErrorByName('first_name', $this->t('Update action failed!!!'));
    }
    // Validate submitted form data.
    if (strlen($form_state->getValue('first_name')) < 1) {
      $form_state->setErrorByName('first_name', $this->t('Please enter a first name.'));
    }

    if (strlen($form_state->getValue('last_name')) < 1) {
      $form_state->setErrorByName('last_name', $this->t('Please enter a last name.'));
    }

    if (strlen($form_state->getValue('email')) < 3) {
      $form_state->setErrorByName('email', $this->t('Please enter valid email.'));
    }
  }
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    // Handle submitted form data.

    $fields = array(
      'first_name' => $form_state->getValue('first_name'),
      'last_name' => $form_state->getValue('last_name'),
      'email' => $form_state->getValue('email'),
    );
    $result = \Drupal::database()
      ->update('crud_example')
      ->condition('wid',$form_state->getValue('wid'))
      ->fields($fields)
      ->execute();


    $this->messenger()->addStatus($this->t('Your data for @email is updated...', ['@email' => $form_state->getValue('email')]));
  }
}
