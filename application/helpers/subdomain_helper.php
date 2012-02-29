<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Return the current subdomain.
 *
 * For example, if the user is using whatever.goturnip.com, then this function
 * returns the string "whatever".
 *
 * @return string
 *   Current subdomain
 */
function get_subdomain() {
  if ($_SERVER['HTTP_HOST'] == 'turnip.localhost') {
    // Hardcode Mike's localhost URL to return the 'mike' subdomain.
    return 'mike';
  } else {
    // Return the string subdomain.
    return str_replace('.goturnip.com', '', $_SERVER['HTTP_HOST']);
  }
}
