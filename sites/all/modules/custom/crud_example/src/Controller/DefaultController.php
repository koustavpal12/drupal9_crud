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
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Durpal\Core\Messenger;

class DefaultController
{

  public function content()
  {

    //Get parameter value while submitting filter form
    $fname = \Drupal::request()->query->get('fname');
    $lname = \Drupal::request()->query->get('lname');
    $email = \Drupal::request()->query->get('email');

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

    $conn = Database::getConnection();
    $query = $conn->select('crud_example', 'm');
    $query->fields('m', ['wid', 'first_name', 'last_name', 'email']);

    if($fname) {
      $query->condition('first_name', $fname);
    }
    if($lname) {
      $query->condition('last_name', $lname);
    }
    if($lname) {
      $query->condition('email', $email);
    }

    $sorted_query = $query->extend('Drupal\Core\Database\Query\TableSortExtender');
    $sorted_query->orderByHeader($header);

    $paged_query = $sorted_query->extend('Drupal\Core\Database\Query\PagerSelectExtender');
    $paged_query->limit(10);
    $results = $paged_query->execute()->fetchAll();

    $row = array();

    foreach ($results as $value) {
      $row[] = ['wid' => $value->wid, 'first_name' => $value->first_name, 'last_name' => $value->last_name, 'email' => $value->email, 'opt' => Link::fromTextAndUrl('Edit', Url::fromUserInput('/crud_example/edit-form/' . $value->wid)), 'opt1' => Link::fromTextAndUrl('Delete', Url::fromUserInput('/crud_example/delete-form/' . $value->wid))];
    }

    $data['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $row,
      '#empty' => t('No record found'),
      '#caption' => Link::fromTextAndUrl('Add User', Url::fromUserInput('/crud_example/add-form')),
    ];

    $data['pager'] = array(
      '#type' => 'pager'
    );

    //$this->messenger()->addMessage('Records Listed');
    return $data;
  }
}
