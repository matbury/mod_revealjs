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
 * Page module post install function
 *
 * This file replaces:
 *  - STATEMENTS section in db/install.xml
 *  - lib.php/modulename_install() post installation hook
 *  - partially defaults.php
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

function xmldb_revealjs_install() {
    global $CFG;

}
