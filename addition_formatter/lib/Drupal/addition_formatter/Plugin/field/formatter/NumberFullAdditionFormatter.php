<?php

/**
 * @file
 * Definition of Drupal\addition_formatter\Plugin\field\formatter\NumberFullAdditionFormatter.
 *
 * This formatter inherits from
 * Drupal\number\Plugin\field\formatter\NumberDecimalFormatter, then its code is
 * simpler and more maintainable than
 * Drupal\addition_formatter\Plugin\field\formatter\FullAdditionFormatter,
 * whe code is copied&pasted from NumberDecimalFormatter.
 *
 * OO inheritance for Field API is great!!
 */

namespace Drupal\addition_formatter\Plugin\field\formatter;

use Drupal\field\Annotation\FieldFormatter;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\Field\FieldItemListInterface;
use Drupal\number\Plugin\field\formatter\NumberDecimalFormatter;

/**
 * Plugin implementation of the 'number_full_addition' formatter.
 *
 * @FieldFormatter(
 *   id = "number_full_addition",
 *   label = @Translation("Number Full Addition"),
 *   field_types = {
 *     "number_integer",
 *     "number_decimal",
 *     "number_float"
 *   },
 *   settings = {
 *     "thousand_separator" = "",
 *     "decimal_separator" = ".",
 *     "scale" = "2",
 *     "prefix_suffix" = "TRUE"
 *   }
 * )
 */
class NumberFullAdditionFormatter extends NumberDecimalFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();

      foreach ($items as $delta => $item) {
        if ($delta != 0) {
          $items[0]->value += $item->value;
          unset($items[$delta]);
        }
      }

    return parent::viewElements($items);
  }

}
