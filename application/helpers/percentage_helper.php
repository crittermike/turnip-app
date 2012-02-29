<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Takes an array of values and returns an array of percentages.
 *
 * For example, the array with values 2, 2, 4 will be converted to an array of
 * values 0.25, 0.25, 0.5.
 *
 * @paray array
 *   The array of values
 * @return array
 *   The array of percentages
 */
function to_percentages($values) {
  $total = array_sum($values);
  foreach ($values as $key => $value) {
    $values[$key] = $value / $total;
  }
  return $values;
}
