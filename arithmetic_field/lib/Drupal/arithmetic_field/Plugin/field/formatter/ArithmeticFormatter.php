<?php

/**
 * @file
 * Definition of Drupal\arithmetic_field\Plugin\field\formatter\ArithmeticFormatter.
 */

namespace Drupal\arithmetic_field\Plugin\field\formatter;

use Drupal\field\Annotation\FieldFormatter;
use Drupal\Core\Annotation\Translation;
use Drupal\field\Plugin\Type\Formatter\FormatterBase;
use Drupal\Core\Entity\Field\FieldItemListInterface;

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
