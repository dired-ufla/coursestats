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

function get_amount_created_courses($category) {
	global $DB;
	
	if ($category == ALL_CATEGORIES) {
		return ($DB->count_records(COURSE_TABLE_NAME, 
			array('visible'=>'1')) - 1);
	} else {
		return $DB->count_records(COURSE_TABLE_NAME, 
			array('visible'=>'1', 'category'=>$category));
	} 	
}
function get_amount_used_courses($category) {
	global $DB;
	
	if ($category == ALL_CATEGORIES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible', 
			array('visible'=>'1'));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.category = :cat AND co.visible = :visible', 
			array('cat'=>$category, 'visible'=>'1'));
	} 
}

echo $OUTPUT->header();

$result = $DB->get_records(COURSE_CATEGORIES_TABLE_NAME, null, 'name');
		
$table = new html_table();
$table->size = array( '60%', '10%', '10%', '10%', '10%');
$table->head = array(get_string('lb_category', 'report_coursestats'), get_string('lb_courses_created_amount', 'report_coursestats'),
	get_string('lb_used_courses', 'report_coursestats'), get_string('lb_not_used_courses', 'report_coursestats'), get_string('lb_percent_of_used_courses', 'report_coursestats'));

// All categories
$link = '<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . ALL_CATEGORIES . '>' . 
	get_string('lb_all_categories', 'report_coursestats') . '</a>';
$co_created = get_amount_created_courses(ALL_CATEGORIES);
$co_used = get_amount_used_courses(ALL_CATEGORIES);
if ($co_created > 0) {
	$co_percent = number_format(($co_used / $co_created) * 100, 2) . '%';
} else {
	$co_percent = '-';
}

$link_co_created = '<a href=' . $CFG->wwwroot . '/report/coursestats/courses.php?type=' . CREATED_COURSES . '&category=' . ALL_CATEGORIES . '>' . 
	$co_created . '</a>';

$link_co_used = '<a href=' . $CFG->wwwroot . '/report/coursestats/courses.php?type=' . USED_COURSES . '&category=' . ALL_CATEGORIES . '>' . 
	$co_used . '</a>';

$link_co_notused = '<a href=' . $CFG->wwwroot . '/report/coursestats/courses.php?type=' . NOTUSED_COURSES . '&category=' . ALL_CATEGORIES . '>' . 
	($co_created - $co_used) . '</a>';

$table->data[] = array($link, $link_co_created, $link_co_used, $link_co_notused, $co_percent);

// Each category
$cat_array = array();
$created_courses_array = array();
$used_courses_array = array();
$percentage_used_courses_array = array();

foreach ($result as $cs) {
	$co_created = get_amount_created_courses($cs->id);
	$co_used = get_amount_used_courses($cs->id);
    
    $cat_array[] = $cs->name;
    $created_courses_array[] = $co_created;
	$used_courses_array[] = $co_used;
    
    if ($co_created > 0) {
		$co_percent = number_format(($co_used / $co_created) * 100, 2) . '%';
		$percentage_used_courses_array[] = number_format(($co_used / $co_created) * 100, 2);
	} else {
		$co_percent = '-';
		$percentage_used_courses_array[] = 0;
	}
	
    $link = '<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $cs->id . '>' . $cs->name . '</a>';
	
	$link_co_created = '<a href=' . $CFG->wwwroot . '/report/coursestats/courses.php?type=' . CREATED_COURSES . '&category=' . $cs->id . '>' . 
		$co_created . '</a>';

	$link_co_used = '<a href=' . $CFG->wwwroot . '/report/coursestats/courses.php?type=' . USED_COURSES . '&category=' . $cs->id . '>' . 
		$co_used . '</a>';

	$link_co_notused = '<a href=' . $CFG->wwwroot . '/report/coursestats/courses.php?type=' . NOTUSED_COURSES . '&category=' . $cs->id . '>' . 
		($co_created - $co_used) . '</a>';

	$row = array($link, $link_co_created, $link_co_used, $link_co_notused, $co_percent);
	$table->data[] = $row;
}

if (class_exists('core\chart_bar')) {
	$chart_stacked = new core\chart_bar();
	
	$created_courses_serie = new core\chart_series(get_string('lb_courses_created_amount', 'report_coursestats'), $created_courses_array);
	$used_courses_serie = new core\chart_series(get_string('lb_used_courses', 'report_coursestats'), $used_courses_array);
	$percentage_used_courses_serie = new core\chart_series(get_string('lb_percent_of_used_courses', 'report_coursestats'), $percentage_used_courses_array);
	$percentage_used_courses_serie->set_type(\core\chart_series::TYPE_LINE);
	
	$chart_stacked->add_series($percentage_used_courses_serie);
	$chart_stacked->add_series($created_courses_serie);
	$chart_stacked->add_series($used_courses_serie);
	$chart_stacked->set_labels($cat_array);
	
	echo $OUTPUT->render_chart($chart_stacked, false);
}

$url_csv = new moodle_url($CFG->wwwroot . '/report/coursestats/csvgen.php');
$link_csv = html_writer::link($url_csv, get_string('link_csv', 'report_coursestats'));
echo '<p align="center">' . $link_csv . '</p>';

echo html_writer::table($table);

echo $OUTPUT->footer();

