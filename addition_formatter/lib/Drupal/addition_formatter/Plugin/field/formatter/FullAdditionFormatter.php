<?php

/**
 * @file
 * Definition of Drupal\addition_formatter\Plugin\field\formatter\FullAdditionFormatter.
 *
 * Full formatter for additions that inherits from
 * Drupal\addition_formatter\Plugin\field\formatter\FullAdditionFormatter and
 * includes full support for prefix, suffix and separators.
 */

namespace Drupal\addition_formatter\Plugin\field\formatter;

use Drupal\field\Annotation\FieldFormatter;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'full_addition' formatter.
 *
 * @FieldFormatter(
 *   id = "full_addition",
 *   label = @Translation("Full Addition"),
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
class FullAdditionFormatter extends BasicAdditionFormatter {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $options = array(
      ''  => t('- None -'),
      '.' => t('Decimal point'),
      ',' => t('Comma'),
      ' ' => t('Space'),
      chr(8201) => t('Thin space'),
      "'" => t('Apostrophe'),
    );
    $elements['thousand_separator'] = array(
      '#type' => 'select',
      '#title' => t('Thousand marker'),
      '#options' => $options,
      '#default_value' => $this->getSetting('thousand_separator'),
      '#weight' => 0,
    );

    $elements['prefix_suffix'] = array(
      '#type' => 'checkbox',
      '#title' => t('Display prefix and suffix.'),
      '#default_value' => $this->getSetting('prefix_suffix'),
      '#weight' => 10,
    );

    $elements['decimal_separator'] = array(
      '#type' => 'select',
      '#title' => t('Decimal marker'),
      '#options' => array('.' => t('Decimal point'), ',' => t('Comma')),
      '#default_value' => $this->getSetting('decimal_separator'),
      '#weight' => 5,
    );
    $elements['scale'] = array(
      '#type' => 'select',
      '#title' => t('Scale'),
      '#options' => drupal_map_assoc(range(0, 10)),
      '#default_value' => $this->getSetting('scale'),
      '#description' => t('The number of digits to the right of the decimal.'),
      '#weight' => 6,
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $summary[] = number_format(1234.1234567890, $this->getSetting('scale'), $this->getSetting('decimal_separator'), $this->getSetting('thousand_separator'));
    if ($this->getSetting('prefix_suffix')) {
      $summary[] = t('Display with prefix and suffix.');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = parent::viewElements($items);

    $settings = $this->getFieldSettings();

    if ($elements) {
      $output = number_format($elements[0]['#markup'], $this->getSetting('scale'), $this->getSetting('decimal_separator'), $this->getSetting('thousand_separator'));

      // Account for prefix and suffix.
      if ($this->getSetting('prefix_suffix')) {
        $prefixes = isset($settings['prefix']) ? array_map('field_filter_xss', explode('|', $settings['prefix'])) : array('');
        $suffixes = isset($settings['suffix']) ? array_map('field_filter_xss', explode('|', $settings['suffix'])) : array('');
        $prefix = (count($prefixes) > 1) ? format_plural($item->value, $prefixes[0], $prefixes[1]) : $prefixes[0];
        $suffix = (count($suffixes) > 1) ? format_plural($item->value, $suffixes[0], $suffixes[1]) : $suffixes[0];
        $output = $prefix . $output . $suffix;
      }

      $elements[0] = array('#markup' => $output);
    }

    return $elements;
  }

}
