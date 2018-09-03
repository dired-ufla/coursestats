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
 *
 * @package   report
 * @subpackage coursestats
 * @copyright 2017 Paulo Jr.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(dirname(__FILE__).'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require(__DIR__. '/constants.php');

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

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$fp = fopen('php://output', 'w');

$head = array(get_string('lb_category', 'report_coursestats'), get_string('lb_courses_created_amount', 'report_coursestats'),
	get_string('lb_used_courses', 'report_coursestats'), get_string('lb_percent_of_used_courses', 'report_coursestats'));

fputcsv($fp, $head);

$result = $DB->get_records(COURSE_CATEGORIES_TABLE_NAME, null, 'name');

// All categories
$co_created = get_amount_created_courses(ALL_CATEGORIES);
$co_used = get_amount_used_courses(ALL_CATEGORIES);
if ($co_created > 0) {
	$co_percent = number_format(($co_used / $co_created) * 100, 2);
} else {
	$co_percent = '-';
}

$catdata = array(get_string('lb_all_categories', 'report_coursestats'), $co_created, $co_used, $co_percent);

fputcsv($fp, $catdata);

// For each category
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
		$co_percent = number_format(($co_used / $co_created) * 100, 2);
		$percentage_used_courses_array[] = number_format(($co_used / $co_created) * 100, 2);
	} else {
		$co_percent = '0';
		$percentage_used_courses_array[] = 0;
	}
    
    $catdata = array($cs->name, $co_created, $co_used, $co_percent);
	fputcsv($fp, $catdata);
}

fclose($fp);
