<?php

/**
 * @file
 *
 * Contains \Drupal\notification_timeline\Form\NotificationTimelineNotificationForm.
 */

namespace Drupal\notification_timeline\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class NotificationTimelineNotificationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'notification_timeline_notification_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['notification_timeline'] = array(
      '#tree' => TRUE,
    );

    // Build a list of notification types.
    $options = array('0' => t('- Pick Notification Type -'));
    foreach (\Drupal::entityManager()->getStorage('notification_type')->loadMultiple() as $type) {
      $options[$type->id()] = $type->label();
    }

    $form['notification_timeline']['notification_type'] = array(
      '#type' => 'select',
      '#options' => $options,
    );

    $form['add'] = array(
      '#type' => 'submit',
      '#name' => 'add',
      '#value' => t('Add'),
      '#attributes' => array(
        'class' => array('js-hide'),
      ),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $notification_type = $form_state->getValue(array('notification_timeline', 'notification_type'));
    $node = \Drupal::request()->attributes->get('node');
    $params = array(
      'node' => $node->id(),
      'notification_type' => $notification_type,
    );
    // Redirect the next form to this page.
    $options = array('query' => drupal_get_destination());
    $form_state->setRedirect('entity.node.notification_form', $params, $options);
  }
}