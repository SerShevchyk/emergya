<?php

namespace Drupal\emergya_product\EventSubscriber;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Routing\CurrentRouteMatch;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Implement ProductEventSubscriber.
 */
class ProductEventSubscriber implements EventSubscriberInterface {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;
  /**
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  private $currentRouteMatch;

  /**
   * The ModalFormExampleController constructor.
   *
   * @param \Drupal\Core\Form\FormBuilder $formBuilder
   *   The form builder.
   */
  public function __construct(FormBuilder $formBuilder, CurrentRouteMatch $current_route_match) {
    $this->formBuilder = $formBuilder;
    $this->currentRouteMatch = $current_route_match;
  }

  /**
   * Get Event Subscriber.
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => ['onKernelRequest', 31],
    ];
  }

  /**
   * Callback for event subscriber.
   */
  public function onKernelRequest(GetResponseEvent $event) {
    $node = $this->currentRouteMatch->getParameter('node');
    $request = $event->getRequest();
    $ajaxResponse = new AjaxResponse();

    if ($node && "product" == $node->bundle() && 1 == $node->field_protected->value) {
      if ($request->cookies->has('product_protect_accept') && 1 == $request->cookies->get("product_protect_accept")) {
        $ajaxResponse->addCommand(new RemoveCommand('#protect-products-cookies-form'));
        // \Drupal::messenger()->addMessage('Product Cookies Protected');
        $protect = $request->cookies->get("product_protect_accept");
        $this->openProtectProductsCookiesForm();
      }
      else {
        // \Drupal::messenger()->addMessage('Product Cookies Not Protected');
      }
    }
  }

  /**
   * Callback for opening the modal form.
   */
  public function openProtectProductsCookiesForm() {
    $response = new AjaxResponse();
    $modal_form = $this->formBuilder->getForm('Drupal\emergya_product\Form\ProtectProductsCookiesForm');
    $response->addCommand(new OpenModalDialogCommand('Protect Products Details', $modal_form, ['width' => '800']));

    return $response;
  }

}
