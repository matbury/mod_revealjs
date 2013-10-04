<?php

// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Private revealjs module utility functions
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matt@matbury.com>  {@link http://matbury.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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

function revealjs_get_presentations() {
    global $CFG;
    $revealjs_html_urls = array('' => get_string('choosefile', 'revealjs'));
    $revealjs_html_content = $CFG->dataroot.$CFG->revealjs_content_dir.'/aaaaa/*/*/*.html'; 
    foreach (glob($revealjs_html_content) as $revealjs_html_filename) {
        $revealjs_html_path_parts = pathinfo($revealjs_html_filename);
        $revealjs_html_path = str_replace($CFG->dataroot.$CFG->revealjs_content_dir,'',$revealjs_html_filename);
        $revealjs_html_urls[$revealjs_html_path] = $revealjs_html_path;
    }
    return $revealjs_html_urls;
}

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
    //return array('beige.css', 'default.css', 'moon.css', 'right.css', 'serif.css', 'simple.css', 'sky.css', 'solarized.css');
}

function revealjs_get_transitions() {
    return array('default', 'cube', 'page', 'concave', 'zoom', 'linear', 'fade', 'none');
}

function revealjs_get_transitionspeeds() {
    return array('default', 'fast', 'slow');
}

function revealjs_get_backgroundtransitions() {
    return array('default', 'linear', 'none');
}