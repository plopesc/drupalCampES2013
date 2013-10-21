<?php

/**
 * @file
 * Contains \Drupal\arithmetic_field\Plugin\Field\FieldFormatter\ArithmeticFormatter.
 */

namespace Drupal\arithmetic_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'basic_addition' formatter.
 *
 * @FieldFormatter(
 *   id = "arithmetic",
 *   label = @Translation("Arithmetic"),
 *   field_types = {
 *     "arithmetic"
 *   }
 * )
 */
class ArithmeticFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $elements[$delta] = array('#markup' => "$item->operand1 $item->operation $item->operand2 = $item->value");
    }

    return $elements;
  }

}
