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
 * Page module version information
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matt@matbury.com>  {@link http://matbury.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$module->version   = 2013100600;       // The current module version (Date: YYYYMMDDXX)
$module->requires  = 2013050100;    // Requires this Moodle version
$module->component = 'mod_revealjs';       // Full name of the plugin (used for diagnostics)
$module->cron      = 0;
$module->release   = 'v0.2.0';        // Human-readable version name
$module->maturity = MATURITY_BETA;      // How stable the plugin is MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC, MATURITY_STABLE