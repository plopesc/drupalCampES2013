<?php

/**
 * @file
 * Contains \Drupal\arithmetic_field\Plugin\Field\FieldWidget\DoubleWidget.
 */

namespace Drupal\arithmetic_field\Plugin\Field\FieldWidget;

use Drupal\arithmetic_field\Plugin\Field\FieldType\ArithmeticItem;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Plugin implementation of the 'double' widget.
 *
 * @FieldWidget(
 *   id = "double",
 *   label = @Translation("Double"),
 *   field_types = {
 *     "arithmetic"
 *   },
 *   settings = {
 *     "placeholder" = ""
 *   }
 * )
 */
class DoubleWidget extends WidgetBase {

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

    $element += array(
      '#type' => 'number',
      '#default_value' => $operand1,
      '#placeholder' => $this->getSetting('placeholder'),
      '#step' => 'any',
    );

    return array('operand1' => $element);
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, array &$form_state) {
    foreach ($values as &$item) {
      $item['operation'] = ArithmeticItem::MULTIPLICATION;
      $item['operand2'] = 2;
    }

    return $values;
  }

}
