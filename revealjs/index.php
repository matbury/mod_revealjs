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
 * List of all revealjs in course
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matt@matbury.com>  {@link http://matbury.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$id = required_param('id', PARAM_INT); // course id

$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);

require_course_login($course, true);
$PAGE->set_revealjslayout('incourse');

add_to_log($course->id, 'revealjs', 'view all', "index.php?id=$course->id", '');

$strrevealjs         = get_string('modulename', 'revealjs');
$strrevealjss        = get_string('modulenameplural', 'revealjs');
$strsectionname  = get_string('sectionname', 'format_'.$course->format);
$strname         = get_string('name');
$strintro        = get_string('moduleintro');
$strlastmodified = get_string('lastmodified');

$PAGE->set_url('/mod/revealjs/index.php', array('id' => $course->id));
$PAGE->set_title($course->shortname.': '.$strrevealjss);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add($strrevealjss);
echo $OUTPUT->header();

if (!$revealjss = get_all_instances_in_course('revealjs', $course)) {
    notice(get_string('thereareno', 'moodle', $strrevealjss), "$CFG->wwwroot/course/view.php?id=$course->id");
    exit;
}

$usesections = course_format_uses_sections($course->format);

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $table->head  = array ($strsectionname, $strname, $strintro);
    $table->align = array ('center', 'left', 'left');
} else {
    $table->head  = array ($strlastmodified, $strname, $strintro);
    $table->align = array ('left', 'left', 'left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($revealjss as $revealjs) {
    $cm = $modinfo->cms[$revealjs->coursemodule];
    if ($usesections) {
        $printsection = '';
        if ($revealjs->section !== $currentsection) {
            if ($revealjs->section) {
                $printsection = get_section_name($course, $revealjs->section);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $revealjs->section;
        }
    } else {
        $printsection = '<span class="smallinfo">'.userdate($revealjs->timemodified)."</span>";
    }

    $class = $revealjs->visible ? '' : 'class="dimmed"'; // hidden modules are dimmed

    $table->data[] = array (
        $printsection,
        "<a $class href=\"view.php?id=$cm->id\">".format_string($revealjs->name)."</a>",
        format_module_intro('revealjs', $revealjs, $cm->id));
}

echo html_writer::table($table);

echo $OUTPUT->footer();
