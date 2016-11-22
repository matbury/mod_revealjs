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
 * Page module upgrade code
 *
 * This file keeps track of upgrades to
 * the resource module
 *
 * Sometimes, changes between versions involve
 * alterations to database structures and other
 * major things that may break installations.
 *
 * The upgrade function in this file will attempt
 * to perform all the necessary actions to upgrade
 * your older installation to the current version.
 *
 * If there's something it cannot do itself, it
 * will tell you what you need to do.
 *
 * The commands in here will all be database-neutral,
 * using the methods of database_manager class
 *
 * Please do not forget to use upgrade_set_timeout()
 * before any action that may take longer time to finish.
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

function xmldb_revealjs_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Add new DB columns to support paramters in Reaveal.js 3.0
    
    if ($oldversion < 2015103000) {
        
        $table = new xmldb_table('revealjs');
        
        //remotes
        $field = new xmldb_field('remotes');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'false', 'mousewheel');
        $dbman->add_field($table, $field);
        //$result = $result && $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'remotes', 'false');
        
        //audioslideshow
        $field = new xmldb_field('audioslideshow');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'false', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'audioslideshow', 'false');
        
        //audioslideshowtime
        $field = new xmldb_field('audioslideshowtime');
        $field->set_attributes(XMLDB_TYPE_CHAR, '10', null, null, null, '5', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'audioslideshowtime', '5');
        
        //autoslidestoppable
        $field = new xmldb_field('autoslidestoppable');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'true', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'autoslidestoppable', 'true');
        
        //fragments
        $field = new xmldb_field('fragments');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'true', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'fragments', 'true');
        
        //embedded
        $field = new xmldb_field('embedded');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'false', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'embedded', 'false');
        
        //help
        $field = new xmldb_field('help');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'true', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'help', 'true');
        
        //hideaddressbar
        $field = new xmldb_field('hideaddressbar');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'true', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'hideaddressbar', 'true');
        
        //viewdistance
        $field = new xmldb_field('viewdistance');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, '3', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'viewdistance', '3');
        
        //parallaxbackgroundimage
        $field = new xmldb_field('parallaxbackgroundimage');
        $field->set_attributes(XMLDB_TYPE_CHAR, '255', null, null, null, '', 'mousewheel');
        $dbman->add_field($table, $field);
        
        //parallaxbackgroundsize
        $field = new xmldb_field('parallaxbackgroundsize');
        $field->set_attributes(XMLDB_TYPE_CHAR, '20', null, null, null, '1280px 720px', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'parallaxbackgroundsize', '1280px 720px');
        
        //parallaxbackgroundhorizontal
        $field = new xmldb_field('parallaxbackgroundhorizontal');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, '100', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'parallaxbackgroundhorizontal', '100');
        
        //parallaxbackgroundvertical
        $field = new xmldb_field('parallaxbackgroundvertical');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, '100', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'parallaxbackgroundvertical', '100');
        
        //previewlinks
        $field = new xmldb_field('previewlinks');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'false', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'previewlinks', 'false');
        
        //slidenumber
        $field = new xmldb_field('slidenumber');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'true', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'slidenumber', 'true');
        
    }
    
    if ($oldversion < 2016010300) {
        
        $table = new xmldb_table('revealjs');
        
        //showmenu
        $field = new xmldb_field('showmenu');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'false', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'showmenu', 'false');
        
    }
    
    if ($oldversion < 2016010500) {
        
        $table = new xmldb_table('revealjs');
        
        //showmenu
        $field = new xmldb_field('showcharts');
        $field->set_attributes(XMLDB_TYPE_CHAR, '6', null, null, null, 'false', 'mousewheel');
        $dbman->add_field($table, $field);
        $DB->set_field('revealjs', 'showcharts', 'false');
    }
    
    return true;
}
