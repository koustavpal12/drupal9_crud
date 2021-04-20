<?php

namespace Drupal\crud_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class CrudExampleFirstBlockForm extends FormBase
{
  public function getFormId()
  {
    return 'crudexamplefirstblock_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
    );

    $form['submit'] = [
      '#type'  => 'submit',
      '#value' => $this->t('Filter')
    ];
    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    $email = $form_state->getValue('email');
    if (empty($email)) {
      $form_state->setErrorByName('email', $this->t('Please use an email.'));
    }
  }
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    // Handle submitted form data.

    $field = $form_state->getValues();
    $email = $field["email"];

    $url = \Drupal\Core\Url::fromRoute('crud_example.content')->setRouteParameters(array('email' => $email));
    $form_state->setRedirectUrl($url);
  }
}
