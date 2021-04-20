<?php

namespace Drupal\crud_example\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "crudexamplefirst_block",
 *   admin_label = @Translation("Crud Example First Block"),
 *   category = @Translation("Crud Example First Block"),
 * )
 */

class CrudExampleFirstBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {
    return \Drupal::formBuilder()->getForm('\Drupal\crud_example\Form\CrudExampleFirstBlockForm');
  }

  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'generate crud module');
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('crudexamplefirstblock_settings', $form_state->getValue('crudexamplefirstblock_settings'));
  }

}
