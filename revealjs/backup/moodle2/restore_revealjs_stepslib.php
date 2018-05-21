<?php

// This package is part of Moodle - https://moodle.org
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
 * @subpackage  backup-moodle2
 * @copyright   2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Define all the restore steps that will be used by the restore_revealjs_activity_task
 */

/**
 * Structure step to restore one revealjs activity
 */
class restore_revealjs_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $paths[] = new restore_path_element('revealjs', '/activity/revealjs');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_revealjs($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        // insert the revealjs record
        $newitemid = $DB->insert_record('revealjs', $data);
        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function after_execute() {
        // Add revealjs related files, no need to match by itemname (just internally handled context)
        $this->add_related_files('mod_revealjs', 'intro', null);
        //$this->add_related_files('mod_revealjs', 'content', null);
    }
}
