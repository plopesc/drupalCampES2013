<?php

/**
 * @file
 * Contains \Drupal\arithmetic_field\Plugin\Field\FieldWidget\ArithmeticWidget.
 */

namespace Drupal\arithmetic_field\Plugin\Field\FieldWidget;

use Drupal\arithmetic_field\Plugin\Field\FieldType\ArithmeticItem;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Plugin implementation of the 'arithmetic' widget.
 *
 * @FieldWidget(
 *   id = "arithmetic",
 *   label = @Translation("Arithmetic"),
 *   field_types = {
 *     "arithmetic"
 *   },
 *   settings = {
 *     "placeholder" = ""
 *   }
 * )
 */
class ArithmeticWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $element['placeholder'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $placeholder = $this->getSetting('placeholder');
    if (!empty($placeholder)) {
      $summary[] = t('Placeholder: @placeholder', array('@placeholder' => $placeholder));
    }
    else {
      $summary[] = t('No placeholder');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, array &$form_state) {
    $operand1 = isset($items[$delta]->operand1) ? $items[$delta]->operand1 : NULL;
    $operand2 = isset($items[$delta]->operand2) ? $items[$delta]->operand2 : NULL;
    $operation = isset($items[$delta]->operation) ? $items[$delta]->operation : ArithmeticItem::ADDITION;

    $element += array(
      '#type' => 'fieldset',
    );

    $element['operand1'] = array(
      '#type' => 'number',
      '#default_value' => $operand1,
      '#placeholder' => $this->getSetting('placeholder'),
      '#step' => 'any',
      '#weight' => 0,
    );

    $element['operation'] = array(
      '#type' => 'select',
      '#options' => drupal_map_assoc(array(
        ArithmeticItem::ADDITION,
        ArithmeticItem::SUBTRACTION,
        ArithmeticItem::MULTIPLICATION,
        ArithmeticItem::DIVISION,
      )),
      '#default_value' => $operation,
      '#weight' => 1,
    );

    $element['operand2'] = array(
      '#type' => 'number',
      '#default_value' => $operand2,
      '#placeholder' => $this->getSetting('placeholder'),
      '#step' => 'any',
      '#weight' => 2,
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, array &$form_state) {
    foreach ($values as $delta => &$item) {
      switch($item['operation']) {
        case ArithmeticItem::SUBTRACTION:
          $item['value'] = $item['operand1'] - $item['operand2'];
          break;
        case ArithmeticItem::MULTIPLICATION:
          $item['value'] = $item['operand1'] * $item['operand2'];
          break;
        case ArithmeticItem::DIVISION:
          $item['value'] = $item['operand1'] / $item['operand2'];
          break;
        case ArithmeticItem::ADDITION:
        default:
          $item['value'] = $item['operand1'] + $item['operand2'];
      }
    }
    return $values;
  }

}
