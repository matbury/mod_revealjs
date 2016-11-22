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
 * Private revealjs module utility functions
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2015 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/filelib.php");
require_once("$CFG->libdir/resourcelib.php");
require_once("$CFG->dirroot/mod/revealjs/lib.php");


/**
 * File browsing support class
 */
class revealjs_content_file_info extends file_info_stored {
    public function get_parent() {
        if ($this->lf->get_filepath() === '/' and $this->lf->get_filename() === '.') {
            return $this->browser->get_file_info($this->context);
        }
        return parent::get_parent();
    }
    public function get_visible_name() {
        if ($this->lf->get_filepath() === '/' and $this->lf->get_filename() === '.') {
            return $this->topvisiblename;
        }
        return parent::get_visible_name();
    }
}

function revealjs_get_editor_options($context) {
    global $CFG;
    return array('subdirs'=>1, 'maxbytes'=>$CFG->maxbytes, 'maxfiles'=>-1, 'changeformat'=>1, 'context'=>$context, 'noclean'=>1, 'trusttext'=>0);
}

/**
 * Searches and lists all files in moodledata/repository/revealjs/_revealjs_/[usr]/[name]/[revealjs].*
 * @global object $CFG
 * @return array (list of presentations)
 */
function revealjs_get_presentations() {
    global $CFG;
    $revealjs_html_urls = array('' => get_string('choosefile', 'revealjs'));
    $revealjs_html_content = $CFG->revealjs_data_dir.$CFG->revealjs_data_structure; 
    foreach (glob($revealjs_html_content) as $revealjs_html_filename) {
        $revealjs_html_path_parts = pathinfo($revealjs_html_filename);
        $revealjs_html_path = str_replace($CFG->revealjs_data_dir,'',$revealjs_html_filename);
        $revealjs_html_urls[$revealjs_html_path] = $revealjs_html_path;
    }
    return $revealjs_html_urls;
}

/**
 * Searches and lists all CSS themes in moodle/mod/revealjs/css/theme/*.css
 * @global object $CFG
 * @return array (list of CSS themes)
 */
function revealjs_get_themes() {
    global $CFG;
    $revealjs_urls = array();
    $revealjs_themes = $CFG->dirroot.'/mod/revealjs/css/theme/*.css';
    foreach (glob($revealjs_themes) as $revealjs_filename) {
        $revealjs_path_parts = pathinfo($revealjs_filename);
        $revealjs_filename = $revealjs_path_parts['basename'];
        $revealjs_urls[$revealjs_filename] = $revealjs_path_parts['basename'];
    }
    return $revealjs_urls;
    // return array('beige.css', 'black.css', 'blood.css', 'league.css', 'moon.css', 'night.css', 'serif.css', 'simple.css', 'sky.css', 'solarized.css', 'white.css');
}

/**
 * List of transition types
 * @return array
 */
function revealjs_get_transitions() {
    // none/fade/slide/convex/concave/zoom
    return array('none' => 'none', 'fade' => 'fade', 'slide' => 'slide', 'convex' => 'convex', 'concave' => 'concave', 'zoom' => 'zoom');
}

/**
 * List of transition speeds
 * @return array
 */
function revealjs_get_transitionspeeds() {
    return array('default' => 'default', 'fast' => 'fast', 'slow' => 'slow');
}

/**
 * List of background transition types
 * @return array
 */
function revealjs_get_backgroundtransitions() {
    // none/fade/slide/convex/concave/zoom
    return array('none' => 'none', 'fade' => 'fade', 'slide' => 'slide', 'convex' => 'convex', 'concave' => 'concave', 'zoom' => 'zoom');
}

/**
 * Searches and lists all files in moodledata/repository/revealjs/_revealjs_/[usr]/commonfiles/backgrounds/*.*
 * @global object $CFG
 * @return array
 */
function revealjs_get_backgroundimages() {
    global $CFG;
    $revealjs_backgroundimages = array('' => get_string('choosefile', 'revealjs'));
    $revealjs_image_content = $CFG->revealjs_data_dir.'_revealjs_/*/commonfiles/backgrounds/*.*';
    foreach (glob($revealjs_image_content) as $revealjs_image_filename) {
        $revealjs_image_path_parts = pathinfo($revealjs_image_filename);
        $revealjs_image_path = str_replace($CFG->revealjs_data_dir,'',$revealjs_image_filename);
        $revealjs_backgroundimages[$revealjs_image_path] = $revealjs_image_path;
    }
    return $revealjs_backgroundimages;
}