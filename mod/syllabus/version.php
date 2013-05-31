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
 * Syllabus module version info
 *
 * @package    mod
 * @subpackage syllabus
 * @copyright  2012 onwards vTrainingRoom  {@link http://vtrainingroom.com}
 * @license    All Rights Reserved
 */

defined('MOODLE_INTERNAL') || die();

$module->version   = 2013053100;       // The current module version (Date: YYYYMMDDXX)
$module->requires  = 2011112900;       // Requires this Moodle version
$module->component = 'mod_syllabus'; // Full name of the plugin (used for diagnostics)
$module->cron      = 0;
