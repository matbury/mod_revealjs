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
 * Presentation external API
 *
 * @package    mod_revealjs
 * @category   external
 * @copyright  2016 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */

defined('MOODLE_INTERNAL') || die;
require_once("$CFG->libdir/externallib.php");

/**
 * Presentation external functions
 *
 * @package    mod_revealjs
 * @category   external
 * @copyright  2016 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      Moodle 3.0
 */
class mod_revealjs_external extends external_api {

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     * @since Moodle 3.0
     */
    public static function view_revealjs_parameters() {
        return new external_function_parameters(
            array(
                'revealjsid' => new external_value(PARAM_INT, 'revealjs instance id')
            )
        );
    }

    /**
     * Simulate the revealjs/view.php web interface revealjs: trigger events, completion, etc...
     *
     * @param int $revealjsid the revealjs instance id
     * @return array of warnings and status result
     * @since Moodle 3.0
     * @throws moodle_exception
     */
    public static function view_revealjs($revealjsid) {
        global $DB, $CFG;
        require_once($CFG->dirroot . "/mod/revealjs/lib.php");

        $params = self::validate_parameters(self::view_revealjs_parameters(),
                                            array(
                                                'revealjsid' => $revealjsid
                                            ));
        $warnings = array();

        // Request and permission validation.
        $revealjs = $DB->get_record('revealjs', array('id' => $params['revealjsid']), '*', MUST_EXIST);
        list($course, $cm) = get_course_and_cm_from_instance($revealjs, 'revealjs');

        $context = context_module::instance($cm->id);
        self::validate_context($context);

        require_capability('mod/revealjs:view', $context);

        // Call the revealjs/lib API.
        revealjs_view($revealjs, $course, $cm, $context);

        $result = array();
        $result['status'] = true;
        $result['warnings'] = $warnings;
        return $result;
    }

    /**
     * Returns description of method result value
     *
     * @return external_description
     * @since Moodle 3.0
     */
    public static function view_revealjs_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_BOOL, 'status: true if success'),
                'warnings' => new external_warnings()
            )
        );
    }

}
