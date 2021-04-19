<?php

namespace Drupal\crud_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Routing;

class FilterForm extends FormBase
{
  public function getFormId()
  {

    // Unique ID of the form.
    return 'filter_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    // Create a $form API array.
    $form['filters'] = [
      '#type'  => 'fieldset',
      '#title' => $this->t('Filter'),
      '#open'  => true,
    ];
    $form['filters']['first_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
    );
    $form['filters']['last_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
    );
    $form['filters']['email'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
    );
    $form['filters']['actions'] = [
      '#type'       => 'actions'
    ];

    $form['filters']['actions']['submit'] = [
      '#type'  => 'submit',
      '#value' => $this->t('Filter')
    ];
    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
  }
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    // Handle submitted form data.

    $field = $form_state->getValues();
    $fname = $field["first_name"];
    $lname = $field["last_name"];
    $email = $field["email"];

    $url = \Drupal\Core\Url::fromRoute('crud_example.content')->setRouteParameters(array('fname' => $fname, 'lname' => $lname, 'email' => $email));
    $form_state->setRedirectUrl($url);
  }
}
