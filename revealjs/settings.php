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
 * Page module admin settings and defaults
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once("$CFG->libdir/resourcelib.php");
    require_once($CFG->dirroot.'/mod/revealjs/lib.php');
    
    $revealjs_width = 90;
    
    // Move swf directory?
    $revealjs_data_dir = '';
    if(isset($CFG->revealjs_data_dir)) {
        $revealjs_data_dir = revealjs_rename_dir();
    }
    
    // Server path to where all presentation files are stored, usually in /moodledata/repository/revealjs
    $settings->add(new admin_setting_configtext(
            'revealjs_data_dir', 
            get_string('data_dir', 'revealjs'), 
            get_string('data_dir_explain', 'revealjs').' '.$revealjs_data_dir, 
            $CFG->dataroot.'/repository/revealjs/', 
            PARAM_RAW, 
            $revealjs_width));
    
    // Location of content.php proxy script that accesses presentation files
    $settings->add(new admin_setting_configtext(
            'revealjs_data_url', 
            get_string('data_url', 'revealjs'), 
            get_string('data_url_explain', 'revealjs'), 
            'content.php/', 
            PARAM_RAW, 
            $revealjs_width));
    
    // Directory structure for presentation files. Where /revealjs/mod_form.php searches to find presentations
    $settings->add(new admin_setting_configtext(
            'revealjs_data_structure', 
            get_string('data_structure', 'revealjs'), 
            get_string('data_structure_explain', 'revealjs'), 
            '_revealjs_/*/*/*.*', 
            PARAM_RAW, 
            $revealjs_width));

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_configcheckbox(
            'revealjs/requiremodintro', 
            get_string('requiremodintro', 'admin'), 
            get_string('requiremodintro_desc', 'admin'), 
            0));
    
    // Display presentations inline and/or in popup
    $displayoptions = resourcelib_get_displayoptions(array(RESOURCELIB_DISPLAY_OPEN, RESOURCELIB_DISPLAY_POPUP));
    $defaultdisplayoptions = array(RESOURCELIB_DISPLAY_OPEN, RESOURCELIB_DISPLAY_POPUP);
    $settings->add(new admin_setting_configmultiselect(
            'revealjs/displayoptions', 
            get_string('displayoptions', 'revealjs'), 
            get_string('configdisplayoptions', 'revealjs'), 
            $defaultdisplayoptions, 
            $displayoptions));

    //--- modedit defaults -----------------------------------------------------------------------------------
    
    $settings->add(new admin_setting_heading(
            'revealjsmodeditdefaults', 
            get_string('modeditdefaults', 'admin'), 
            get_string('condifmodeditdefaults', 'admin')));

    $settings->add(new admin_setting_configcheckbox(
            'revealjs/printheading', 
            get_string('printheading', 'revealjs'), 
            get_string('printheadingexplain', 'revealjs'), 
            1));
    
    $settings->add(new admin_setting_configcheckbox(
            'revealjs/printintro', 
            get_string('printintro', 'revealjs'), 
            get_string('printintroexplain', 'revealjs'), 
            0));
    
    $settings->add(new admin_setting_configselect(
            'revealjs/display', 
            get_string('displayselect', 'revealjs'), 
            get_string('displayselectexplain', 'revealjs'), 
            RESOURCELIB_DISPLAY_OPEN, 
            $displayoptions));
    
    $settings->add(new admin_setting_configtext(
            'revealjs/popupwidth', 
            get_string('popupwidth', 'revealjs'), 
            get_string('popupwidthexplain', 'revealjs'), 
            1280, 
            PARAM_INT, 
            7));
    
    $settings->add(new admin_setting_configtext(
            'revealjs/popupheight', 
            get_string('popupheight', 'revealjs'), 
            get_string('popupheightexplain', 'revealjs'), 
            720, 
            PARAM_INT, 
            7));
}
