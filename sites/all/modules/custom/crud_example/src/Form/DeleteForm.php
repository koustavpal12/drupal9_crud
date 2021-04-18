<?php

namespace Drupal\crud_example\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Messenger;

class DeleteForm extends ConfirmFormBase
{
    public function getFormId()
    {
      return 'delete_form_crud_example';
    }

    public $wid;

    public function getQuestion()
    {
      return t('Delete Record ? ');
    }

    public function getDescription()
    {
      return t('Are you sure to delete record ? ');
    }

    public function getConfirmText()
    {
      return t('Delete It !!!');
    }

    public function getCancelText()
    {
      return t('Cancel');
    }

    public function getCancelUrl()
    {
      return new Url('crud_example.content');
    }

    public function buildForm(array $form, FormStateInterface $form_state, $wid=NULL)
    {
      $this->wid = $wid;
      return parent::buildForm($form, $form_state);
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
      if(empty($this->wid)) {
        $this->messenger()->addMessage('Operation failed...');
        $form_state->setRedirect('crud_example.content');
      }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {

      // Handle submitted form data.

      $result = \Drupal::database()
      ->delete('crud_example')
      ->condition('wid',$this->wid)
      ->execute();

      $this->messenger()->addMessage('Successfully deleted!!!');
      $form_state->setRedirect('crud_example.content');
    }
}

