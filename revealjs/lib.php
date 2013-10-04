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
 * List of features supported in Page module
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know
 */
function revealjs_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_GROUPS:                  return false;
        case FEATURE_GROUPINGS:               return false;
        case FEATURE_GROUPMEMBERSONLY:        return true;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_BACKUP_MOODLE2:          return true;
        case FEATURE_SHOW_DESCRIPTION:        return true;
        default: return null;
    }
}

/**
 * Returns all other caps used in module
 * @return array
 */
function revealjs_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function revealjs_reset_userdata($data) {
    return array();
}

/**
 * List of view style log actions
 * @return array
 */
function revealjs_get_view_actions() {
    return array('view','view all');
}

/**
 * List of update style log actions
 * @return array
 */
function revealjs_get_post_actions() {
    return array('update', 'add');
}

/**
 * Add revealjs instance.
 * @param stdClass $data
 * @param mod_revealjs_mod_form $mform
 * @return int new revealjs instance id
 */
function revealjs_add_instance($data, $mform = null) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");
    $cmid = $data->coursemodule;
    $data->timemodified = time();
    $data->timecreated = time();
    $displayoptions = array();
    if ($data->display == RESOURCELIB_DISPLAY_POPUP) {
        $displayoptions['popupwidth']  = $data->popupwidth;
        $displayoptions['popupheight'] = $data->popupheight;
        $data->width  = $data->popupwidth;
        $data->height  = $data->popupheight;
    }
    $displayoptions['printheading'] = $data->printheading;
    $displayoptions['printintro']   = $data->printintro;
    $data->displayoptions = serialize($displayoptions);
    if ($mform) {
        //$data->content       = $data->revealjs['text'];
        //$data->contentformat = $data->revealjs['format'];
    }
    $data->id = $DB->insert_record('revealjs', $data);
    // we need to use context now, so we need to make sure all needed info is already in db
    $DB->set_field('course_modules', 'instance', $data->id, array('id'=>$cmid));
    $context = context_module::instance($cmid);
    /*if ($mform and !empty($data->revealjs['itemid'])) {
        $draftitemid = $data->revealjs['itemid'];
        $data->content = file_save_draft_area_files($draftitemid, $context->id, 'mod_revealjs', 'content', 0, revealjs_get_editor_options($context), $data->content);
        $DB->update_record('revealjs', $data);
    }*/
    return $data->id;
}

/**
 * Update revealjs instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function revealjs_update_instance($data, $mform) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");
    $cmid        = $data->coursemodule;
    $draftitemid = $data->revealjs['itemid'];
    $data->timemodified = time();
    $data->id           = $data->instance;
    $data->revision++;
    $displayoptions = array();
    if ($data->display == RESOURCELIB_DISPLAY_POPUP) {
        $displayoptions['popupwidth']  = $data->popupwidth;
        $displayoptions['popupheight'] = $data->popupheight;
        $data->width  = $data->popupwidth;
        $data->height  = $data->popupheight;
    }
    $displayoptions['printheading'] = $data->printheading;
    $displayoptions['printintro']   = $data->printintro;
    $data->displayoptions = serialize($displayoptions);
    //$data->content       = $data->revealjs['text'];
    //$data->contentformat = $data->revealjs['format'];
    $DB->update_record('revealjs', $data);
    //$context = context_module::instance($cmid);
    /*if ($draftitemid) {
        $data->content = file_save_draft_area_files($draftitemid, $context->id, 'mod_revealjs', 'content', 0, revealjs_get_editor_options($context), $data->content);
        $DB->update_record('revealjs', $data);
    }*/
    return true;
}

/**
 * Delete revealjs instance.
 * @param int $id
 * @return bool true
 */
function revealjs_delete_instance($id) {
    global $DB;
    if (!$revealjs = $DB->get_record('revealjs', array('id'=>$id))) {
        return false;
    }
    // note: all context files are deleted automatically
    $DB->delete_records('revealjs', array('id'=>$revealjs->id));
    return true;
}

/**
 * Return use outline
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $revealjs
 * @return object|null
 */
function revealjs_user_outline($course, $user, $mod, $revealjs) {
    global $DB;
    if ($logs = $DB->get_records('log', array('userid'=>$user->id, 'module'=>'revealjs', 'action'=>'view', 'info'=>$revealjs->id), 'time ASC')) {
        $numviews = count($logs);
        $lastlog = array_pop($logs);
        $result = new stdClass();
        $result->info = get_string('numviews', '', $numviews);
        $result->time = $lastlog->time;
        return $result;
    }
    return NULL;
}

/**
 * Return use complete
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $revealjs
 */
function revealjs_user_complete($course, $user, $mod, $revealjs) {
    global $CFG, $DB;
    if ($logs = $DB->get_records('log', array('userid'=>$user->id, 'module'=>'revealjs', 'action'=>'view', 'info'=>$revealjs->id), 'time ASC')) {
        $numviews = count($logs);
        $lastlog = array_pop($logs);
        $strmostrecently = get_string('mostrecently');
        $strnumviews = get_string('numviews', '', $numviews);
        echo "$strnumviews - $strmostrecently ".userdate($lastlog->time);
    } else {
        print_string('neverseen', 'revealjs');
    }
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 *
 * See {@link get_array_of_activities()} in course/lib.php
 *
 * @param stdClass $coursemodule
 * @return cached_cm_info Info to customise main revealjs display
 */
function revealjs_get_coursemodule_info($coursemodule) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");
    if (!$revealjs = $DB->get_record('revealjs', array('id'=>$coursemodule->instance), 'id, name, display, displayoptions, intro, introformat')) {
        return NULL;
    }
    $info = new cached_cm_info();
    $info->name = $revealjs->name;
    if ($coursemodule->showdescription) {
        // Convert intro to html. Do not filter cached version, filters run at display time.
        $info->content = format_module_intro('revealjs', $revealjs, $coursemodule->id, false);
    }
    if ($revealjs->display != RESOURCELIB_DISPLAY_POPUP) {
        return $info;
    }
    $fullurl = "$CFG->wwwroot/mod/revealjs/view.php?id=$coursemodule->id&amp;inpopup=1";
    $options = empty($revealjs->displayoptions) ? array() : unserialize($revealjs->displayoptions);
    $width  = empty($options['popupwidth'])  ? 620 : $options['popupwidth'];
    $height = empty($options['popupheight']) ? 450 : $options['popupheight'];
    $wh = "width=$width,height=$height,toolbar=no,location=no,menubar=no,copyhistory=no,status=no,directories=no,scrollbars=yes,resizable=yes";
    $info->onclick = "window.open('$fullurl', '', '$wh'); return false;";
    return $info;
}


/**
 * Lists all browsable file areas
 *
 * @package  mod_revealjs
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @return array
 */
function revealjs_get_file_areas($course, $cm, $context) {
    $areas = array();
    $areas['content'] = get_string('content', 'revealjs');
    return $areas;
}

/**
 * File browsing support for revealjs module content area.
 *
 * @package  mod_revealjs
 * @category files
 * @param stdClass $browser file browser instance
 * @param stdClass $areas file areas
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param int $itemid item ID
 * @param string $filepath file path
 * @param string $filename file name
 * @return file_info instance or null if not found
 */
function revealjs_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    global $CFG;
    if (!has_capability('moodle/course:managefiles', $context)) {
        // students can not peak here!
        return null;
    }
    $fs = get_file_storage();
    if ($filearea === 'content') {
        $filepath = is_null($filepath) ? '/' : $filepath;
        $filename = is_null($filename) ? '.' : $filename;
        $urlbase = $CFG->wwwroot.'/pluginfile.php';
        if (!$storedfile = $fs->get_file($context->id, 'mod_revealjs', 'content', 0, $filepath, $filename)) {
            if ($filepath === '/' and $filename === '.') {
                $storedfile = new virtual_root_file($context->id, 'mod_revealjs', 'content', 0);
            } else {
                // not found
                return null;
            }
        }
        require_once("$CFG->dirroot/mod/revealjs/locallib.php");
        return new revealjs_content_file_info($browser, $context, $storedfile, $urlbase, $areas[$filearea], true, true, true, false);
    }
    // note: revealjs_intro handled in file_browser automatically
    return null;
}

/**
 * Serves the revealjs files.
 *
 * @package  mod_revealjs
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if file not found, does not return if found - just send the file
 */
function revealjs_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");
    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }
    require_course_login($course, true, $cm);
    if (!has_capability('mod/revealjs:view', $context)) {
        return false;
    }
    if ($filearea !== 'content') {
        // intro is handled automatically in pluginfile.php
        return false;
    }
    // $arg could be revision number or index.html
    $arg = array_shift($args);
    if ($arg == 'index.html' || $arg == 'index.htm') {
        // serve revealjs content
        $filename = $arg;
        if (!$revealjs = $DB->get_record('revealjs', array('id'=>$cm->instance), '*', MUST_EXIST)) {
            return false;
        }
        // remove @@PLUGINFILE@@/
        $content = str_replace('@@PLUGINFILE@@/', '', $revealjs->content);
        $formatoptions = new stdClass;
        $formatoptions->noclean = true;
        $formatoptions->overflowdiv = true;
        $formatoptions->context = $context;
        $content = format_text($content, $revealjs->contentformat, $formatoptions);
        send_file($content, $filename, 0, 0, true, true);
    } else {
        $fs = get_file_storage();
        $relativepath = implode('/', $args);
        $fullpath = "/$context->id/mod_revealjs/$filearea/0/$relativepath";
        if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
            $revealjs = $DB->get_record('revealjs', array('id'=>$cm->instance), 'id, legacyfiles', MUST_EXIST);
            if ($revealjs->legacyfiles != RESOURCELIB_LEGACYFILES_ACTIVE) {
                return false;
            }
            if (!$file = resourcelib_try_file_migration('/'.$relativepath, $cm->id, $cm->course, 'mod_revealjs', 'content', 0)) {
                return false;
            }
            //file migrate - update flag
            $revealjs->legacyfileslast = time();
            $DB->update_record('revealjs', $revealjs);
        }
        // finally send the file
        send_stored_file($file, 86400, 0, $forcedownload, $options);
    }
}

/**
 * Return a list of revealjs types
 * @param string $revealjstype current revealjs type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 */
function revealjs_revealjs_type_list($revealjstype, $parentcontext, $currentcontext) {
    $module_revealjstype = array('mod-revealjs-*'=>get_string('revealjs-mod-revealjs-x', 'revealjs'));
    return $module_revealjstype;
}

/**
 * Export revealjs resource contents
 *
 * @return array of file content
 */
function revealjs_export_contents($cm, $baseurl) {
    global $CFG, $DB;
    $contents = array();
    $context = context_module::instance($cm->id);
    $revealjs = $DB->get_record('revealjs', array('id'=>$cm->instance), '*', MUST_EXIST);
    // revealjs contents
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_revealjs', 'content', 0, 'sortorder DESC, id ASC', false);
    foreach ($files as $fileinfo) {
        $file = array();
        $file['type']         = 'file';
        $file['filename']     = $fileinfo->get_filename();
        $file['filepath']     = $fileinfo->get_filepath();
        $file['filesize']     = $fileinfo->get_filesize();
        $file['fileurl']      = file_encode_url("$CFG->wwwroot/" . $baseurl, '/'.$context->id.'/mod_revealjs/content/'.$revealjs->revision.$fileinfo->get_filepath().$fileinfo->get_filename(), true);
        $file['timecreated']  = $fileinfo->get_timecreated();
        $file['timemodified'] = $fileinfo->get_timemodified();
        $file['sortorder']    = $fileinfo->get_sortorder();
        $file['userid']       = $fileinfo->get_userid();
        $file['author']       = $fileinfo->get_author();
        $file['license']      = $fileinfo->get_license();
        $contents[] = $file;
    }
    // revealjs html conent
    $filename = 'index.html';
    $revealjsfile = array();
    $revealjsfile['type']         = 'file';
    $revealjsfile['filename']     = $filename;
    $revealjsfile['filepath']     = '/';
    $revealjsfile['filesize']     = 0;
    $revealjsfile['fileurl']      = file_encode_url("$CFG->wwwroot/" . $baseurl, '/'.$context->id.'/mod_revealjs/content/' . $filename, true);
    $revealjsfile['timecreated']  = null;
    $revealjsfile['timemodified'] = $revealjs->timemodified;
    // make this file as main file
    $revealjsfile['sortorder']    = 1;
    $revealjsfile['userid']       = null;
    $revealjsfile['author']       = null;
    $revealjsfile['license']      = null;
    $contents[] = $revealjsfile;
    return $contents;
}

/**
 * Register the ability to handle drag and drop file uploads
 * @return array containing details of the files / types the mod can handle
 */
function revealjs_dndupload_register() {
    return array('types' => array(
                     array('identifier' => 'text/html', 'message' => get_string('createrevealjs', 'revealjs')),
                     array('identifier' => 'text', 'message' => get_string('createrevealjs', 'revealjs'))
                 ));
}

/**
 * Handle a file that has been uploaded
 * @param object $uploadinfo details of the file / content that has been uploaded
 * @return int instance id of the newly created mod
 */
function revealjs_dndupload_handle($uploadinfo) {
    // Gather the required info.
    $data = new stdClass();
    $data->course = $uploadinfo->course->id;
    $data->name = $uploadinfo->displayname;
    $data->intro = '<p>'.$uploadinfo->displayname.'</p>';
    $data->introformat = FORMAT_HTML;
    if ($uploadinfo->type == 'text/html') {
        $data->contentformat = FORMAT_HTML;
        $data->content = clean_param($uploadinfo->content, PARAM_CLEANHTML);
    } else {
        $data->contentformat = FORMAT_PLAIN;
        $data->content = clean_param($uploadinfo->content, PARAM_TEXT);
    }
    $data->coursemodule = $uploadinfo->coursemodule;
    // Set the display options to the site defaults.
    $config = get_config('revealjs');
    $data->display = $config->display;
    $data->popupheight = $config->popupheight;
    $data->popupwidth = $config->popupwidth;
    $data->printheading = $config->printheading;
    $data->printintro = $config->printintro;
    return revealjs_add_instance($data, null);
}
