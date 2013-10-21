<?php

/**
 * @file
 * Contains \Drupal\arithmetic_field\Plugin\Field\FieldType\ArithmeticItemBase.
 */

namespace Drupal\arithmetic_field\Plugin\Field\FieldType;

use Drupal\Core\Field\ConfigFieldItemBase;
use Drupal\field\FieldInterface;

/**
 * Plugin implementation of the 'arithmetic' field type.
 *
 * @FieldType(
 *   id = "arithmetic",
 *   label = @Translation("Arithmetic"),
 *   description = @Translation("Field that represents arithmetic operations."),
 *   default_widget = "arithmetic",
 *   default_formatter = "arithmetic"
 * )
 */
class ArithmeticItem extends ConfigFieldItemBase {

  /**
   * Definitions of the contained properties.
   *
   * @var array
   */
  static $propertyDefinitions;

  /**
   * Value that represents an addition.
   */
  const ADDITION = '+';

  /**
   * Value that represents a subtraction.
   */
  const SUBTRACTION = '-';

  /**
   * Value that represents a multiplication.
   */
  const MULTIPLICATION = 'X';

  /**
   * Value that represents a division.
   */
  const DIVISION = '/';

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset(static::$propertyDefinitions)) {
      static::$propertyDefinitions['operand1'] = array(
        'type' => 'float',
        'label' => t('First value'),
      );
      static::$propertyDefinitions['operand2'] = array(
        'type' => 'float',
        'label' => t('Second value'),
      );
      static::$propertyDefinitions['operation'] = array(
        'type' => 'string',
        'label' => t('operation'),
      );
      static::$propertyDefinitions['value'] = array(
        'type' => 'float',
        'label' => t('Operation result'),
      );
    }
    return static::$propertyDefinitions;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldInterface $field) {
    return array(
      'columns' => array(
        'operand1' => array(
          'type' => 'float',
          'not null' => FALSE,
        ),
        'operand2' => array(
          'type' => 'float',
          'not null' => FALSE,
        ),
        'operation' => array(
          'type' => 'varchar',
          'length' => 1,
          'not null' => FALSE
        ),
        'value' => array(
          'type' => 'float',
          'not null' => FALSE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if ((empty($this->operand1) && (string) $this->operand1 !== '0') || (empty($this->operand2) && (string) $this->operand2 !== '0')) {
      return TRUE;
    }
    return FALSE;
  }

}
