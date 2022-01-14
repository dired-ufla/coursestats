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
 * Forum event handler definition.
 *
 * @package report
 * @subpackage report_coursesstats
 * @copyright 2017 Paulo Jr.
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// List of observers.
$observers = array(
	array(
        'eventname' => '\core\event\course_module_created',
        'callback'  => 'report_coursestats_observer::course_module_created',
    ),
	array(
        'eventname' => '\core\event\course_module_updated',
        'callback'  => 'report_coursestats_observer::course_module_updated',
    ),
	array(
        'eventname' => '\mod_forum\event\discussion_created',
        'callback'  => 'report_coursestats_observer::forum_discussion_created',
    ),
);
