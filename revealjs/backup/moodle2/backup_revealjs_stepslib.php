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
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matt@matbury.com>  {@link http://matbury.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Define all the backup steps that will be used by the backup_revealjs_activity_task
 */

/**
 * Define the complete revealjs structure for backup, with file and id annotations
 */
class backup_revealjs_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $revealjs = new backup_nested_element('revealjs', array('id'), array(
            'name', 
            'intro', 
            'introformat', 
            'autoslide',
            'backgroundtransition',
            'center',
            'controls',
            'display', 
            'displayoptions',
            'height',
            'history',
            'keyboard',
            'looped',
            'margin',
            'maxscale',
            'minscale',
            'mousewheel',
            'presentation',
            'progress',
            'overview',
            'revision', 
            'rtl',
            'theme',
            'timecreated',
            'timemodified',
            'touch',
            'transition',
            'transitionspeed',
            'width',));

        // Build the tree
        // (love this)

        // Define sources
        $revealjs->set_source_table('revealjs', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations
        // (none)

        // Define file annotations
        $revealjs->annotate_files('mod_revealjs', 'intro', null); // This file areas haven't itemid
        //$revealjs->annotate_files('mod_revealjs', 'content', null); // This file areas haven't itemid

        // Return the root element (revealjs), wrapped into standard activity structure
        return $this->prepare_activity_structure($revealjs);
    }
}
