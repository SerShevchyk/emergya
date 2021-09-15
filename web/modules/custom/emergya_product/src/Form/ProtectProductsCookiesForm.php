<?php

namespace Drupal\emergya_product\Form;

use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * ProtectProductsCookiesForm class.
 */
class ProtectProductsCookiesForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'protect_products_cookies_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $options = NULL) {
    $form['#prefix'] = '<div id="protect-products-cookies-form">';
    $form['#suffix'] = '</div>';

    // A required checkbox field.
    $form['checkbox'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('I Agree with cookies protection'),
      '#required' => TRUE,
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Agree'),
      '#attributes' => [
        'class' => [
          'use-ajax',
        ],
      ],
      '#ajax' => [
        'callback' => [$this, 'submitModalFormAjax'],
        'event' => 'click',
      ],
    ];

    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    return $form;
  }

  /**
   * AJAX callback handler that displays any errors or a success message.
   */
  public function submitModalFormAjax(array $form, FormStateInterface $form_state) {
    $ajaxResponse = new AjaxResponse();
    $ajaxResponse->addCommand(new RemoveCommand('#protect-products-cookies-form'));
    $ajaxResponse->headers->setCookie(new Cookie('product_protect_accept', '1', '+30 seconds'));
    return $ajaxResponse;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {}

}
