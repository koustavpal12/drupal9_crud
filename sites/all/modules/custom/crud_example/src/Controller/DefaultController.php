<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultController
 *
 * @author admin
 */

namespace Drupal\crud_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Durpal\Core\Messenger;

class DefaultController
{

  public function content()
  {

    //====load filter controller
    $form_class = '\Drupal\crud_example\Form\FilterForm';
    $data['form'] = \Drupal::formBuilder()->getForm($form_class);

    /*
        $header = [
            'id' => t('ID'),
            'fname' => t('First Name'),
            'lname' => t('Last Name'),
            'email' => t('Email'),
            'opt' => t('Edit'),
            'opt1' => t('Delete'),
        ];
*/
    $header = array(
      // We make it sortable by name.
      array('data' => t('ID'), 'field' => 'wid', 'sort' => 'asc'),
      array('data' => t('First Name'), 'field' => 'first_name', 'sort' => 'asc'),
      array('data' => t('Last Name')),
      array('data' => t('Email')),
      array('data' => t('Edit')),
      array('data' => t('Delete')),
    );

    //Get parameter value while submitting filter form
    $param = array();

    $param['fname'] = \Drupal::request()->query->get('fname');
    $param['lname'] = \Drupal::request()->query->get('lname');
    $param['email'] = \Drupal::request()->query->get('email');

    $param['header'] = $header;

    $data['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => get_records($param),
      '#empty' => t('No record found'),
      '#caption' => getLink('Add User', '/crud_example/add-form'),
    ];

    $data['pager'] = array(
      '#type' => 'pager'
    );

    //$this->messenger()->addMessage('Records Listed');
    return $data;
  }


}
