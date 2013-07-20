<?php

/**
 * This provides a user-interface for using the DbDiff class.
 *
 * More information on this tool can be found at:
 * http://joefreeman.co.uk/blog/2009/07/php-script-to-compare-mysql-database-schemas/
 *
 * Copyright (C) 2009, Joe Freeman <joe.freeman@bitroot.com>
 * Available under http://en.wikipedia.org/wiki/MIT_License
 */

/**
 * Strips new line characters (CR and LF) from a string.
 *
 * @param string $str The string to process.
 * @return string The string without CRs or LFs.
 */
function strip_nl($str) {
	return str_replace(array("\n", "\r"), '', $str);
}

/**
 * Returns an 's' character if the count is not 1.
 *
 * This is useful for adding plurals.
 *
 * @return string An 's' character or an empty string
 **/
function s($count) {
	return $count != 1 ? 's' : '';
}

?>