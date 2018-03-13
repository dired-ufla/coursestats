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
 * Strings for component 'report_coursestats', language 'en'
 *
 * @package   	report
 * @subpackage 	coursestats
 * @copyright 	2017 Paulo Jr.
 * @license   	http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(dirname(__FILE__).'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require(__DIR__. '/constants.php');

admin_externalpage_setup('reportcoursestats', '', null, '', array('pagelayout'=>'report'));

echo $OUTPUT->header();

$result = $DB->get_records(COURSE_CATEGORIES_TABLE_NAME, null, 'name');
		
$table = new html_table();

$row = array();
$row[] = '<a href=' . $CFG->wwwroot . '/report/coursestats/departments.php?category=' . ALL_CATEGORIES . '>' . get_string('lb_all_categories', 'report_coursestats') . '</a>';
$table->data[] = $row;

$table->head = array(	get_string('lb_choose_category', 'report_coursestats'));
foreach ($result as $cs) {
    $row = array();
    $row[] = '<a href=' . $CFG->wwwroot . '/report/coursestats/departments.php?category=' . $cs->id . '>' . $cs->name . '</a>';
	$table->data[] = $row;
}

echo html_writer::table($table);

echo $OUTPUT->footer();

