<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Convert a HH:MM (like 1:30) time to a decimal number of hours (like 1.5).
 *
 * Returns a float value for the number of hours.
 *
 * @param   $time - string formatted as HH:MM or H:MM
 * @return	float
 */
function time_to_decimal($time) {
  $time = explode(":", $time);
  return $time[0] . "." . ceil(intval($time[1]) * 1.66);
}

/**
 * Convert decimal number of hours to a HH:MM timespan.
 *
 * Returns HH:MM formatted string.
 *
 * @param   $time - float number of hours
 * @return	string
 */
function decimal_to_time($time) {
  $time = explode(".", $time);
  if (!isset($time[1])) // It was an even number of hours.
    $time[1] = '00';
  $time[1] = floor($time[1] / 1.66); // Conversion rate between decimal and minutes.
  if ($time[1] < 10) // Pad a single digit number of minutes to double digits.
    $time[1] = "0" . $time[1];
  return $time[0] . ":" . $time[1];
}
