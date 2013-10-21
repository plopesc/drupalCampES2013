<?php

/**
 * @file
 * Contains \Drupal\addition_formatter\Plugin\Field\FieldFormatter\BasicAdditionFormatter.
 *
 * Basic formatter that represent the sum of all numeric field items.
 */

namespace Drupal\addition_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'basic_addition' formatter.
 *
 * @FieldFormatter(
 *   id = "basic_addition",
 *   label = @Translation("Basic Addition"),
 *   field_types = {
 *     "number_integer",
 *     "number_decimal",
 *     "number_float"
 *   }
 * )
 */
class BasicAdditionFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    if (!$items->isEmpty()) {
      $value = NULL;
      foreach ($items as $delta => $item) {
        $value += $item->value;
      }
      $elements[0] = array('#markup' => $value);
    }

    return $elements;
  }

}
