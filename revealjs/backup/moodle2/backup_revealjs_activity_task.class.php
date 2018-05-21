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
 * Defines backup_revealjs_activity_task class
 *
 * @package     mod_revealjs
 * @category    backup
 * @copyright   2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/revealjs/backup/moodle2/backup_revealjs_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Page instance
 */
class backup_revealjs_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the revealjs.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_revealjs_activity_structure_step('revealjs_structure', 'revealjs.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        //$base = preg_quote($CFG->wwwroot,"/");

        // Link to the list of revealjss
        //$search="/(".$base."\/mod\/revealjs\/index.php\?id\=)([0-9]+)/";
        //$content= preg_replace($search, '$@REVEALJSINDEX*$2@$', $content);

        // Link to revealjs view by moduleid
        //$search="/(".$base."\/mod\/revealjs\/view.php\?id\=)([0-9]+)/";
        //$content= preg_replace($search, '$@REVEALJSVIEWBYID*$2@$', $content);

        return $content;
    }
}
