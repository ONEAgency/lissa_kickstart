<?php

/**
 * @file
 * Contains \Drupal\event_monitor\Plugin\Field\FieldFormatter\DashFormatter.
 */

namespace Drupal\event_monitor\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'video_mpegdash' formatter.
 *
 * @FieldFormatter(
 *   id = "video_mpegdash",
 *   label = @Translation("Mpeg Dash video"),
 *   field_types = {
 *     "link",
 *   }
 * )
 */
class DashFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'dash_formatter',
        '#url' => $item->url,
        '#id' => $item->getEntity()->id(),
      );
    }

    // JS functionality to add mpeg dash player
    $elements['#attached'] = array(
      'library' => array(
        'event_monitor/dash_player',
      ),
    );

    return $elements;
  }

}
