<?php

namespace Drupal\emergya_product\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "protect_products_cookies_block",
 *   admin_label = @Translation("Protect Products Cookies Block"),
 * )
 */
class ProtectProductsCookiesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\emergya_product\Form\ProtectProductsCookiesForm');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

}
