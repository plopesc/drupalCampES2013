<?php

/**
 * @file
 * Definition of Drupal\addition_formatter\Plugin\field\formatter\BasicAdditionFormatter.
 *
 * Basic formatter that represent the sum of all numeric field items.
 */

namespace Drupal\addition_formatter\Plugin\field\formatter;

use Drupal\field\Annotation\FieldFormatter;
use Drupal\Core\Annotation\Translation;
use Drupal\field\Plugin\Type\Formatter\FormatterBase;
use Drupal\Core\Entity\Field\FieldItemListInterface;

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
