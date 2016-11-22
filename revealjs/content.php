<?php

// This package is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * @package     mod_revealjs
 * @copyright   2013 Matt Bury
 * @author      Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('../../lib/filelib.php'); // for mimeinfo() and send_file()

//require_login(); // Users must be logged in to access files

global $CFG;
    
//$CFG->revealjs_content_dir = clean_param($CFG->revealjs_content_dir, PARAM_PATH); // (Optional) Clean the SWF content directory setting.
$CFG->revealjs_data_dir = rtrim($CFG->revealjs_data_dir, '/'); // Remove trailing slash(es).
$revealjs_relative_path = get_file_argument(); // Get the relative path of the requested content.

if (empty($CFG->revealjs_data_dir) || !$revealjs_relative_path) {
    header('HTTP/1.0 404 Not Found');
    exit(get_string('content_error','revealjs'));
} else if ($revealjs_relative_path{0} != '/') {
    // Relative path must start with '/'.
    header('HTTP/1.0 404 Not Found');
    exit(get_string('content_error','revealjs'));
}

$revealjs_data_path = realpath($CFG->revealjs_data_dir . $revealjs_relative_path);

// (Paranoid) Content will be served just from the SWF content dir.
if (strpos($revealjs_data_path, realpath($CFG->revealjs_data_dir)) === 0) {
    $revealjs_data_info = pathinfo($revealjs_data_path);
    $revealjs_mime_type = mimeinfo('type', $revealjs_data_info['basename']);
    send_file($revealjs_data_path, $revealjs_data_info['basename'], 'default', 0, false, false, $revealjs_mime_type, false);
} else {
    header('HTTP/1.0 404 Not Found');
    exit(get_string('content_error','revealjs'));
}
