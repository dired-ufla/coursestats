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

$usagetype = optional_param('usagetype', ALL_USAGE_TYPE, PARAM_ALPHA);    // usage type
$category = optional_param('category', ALL_CATEGORIES, PARAM_INT);

admin_externalpage_setup('reportcoursestats', '', null, '', array('pagelayout'=>'report'));

$url = new moodle_url($CFG->wwwroot . '/report/coursestats/main.php?category=' . $category);
$link = html_writer::link($url, get_string('link_back', 'report_coursestats'));

echo $OUTPUT->header();

if ($category == ALL_CATEGORIES) {
	$catname = get_string('lb_all_categories', 'report_coursestats');	
	$rs = $DB->get_recordset_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.visible = :visible ORDER BY co.shortname', 
			array('type'=>$usagetype, 'visible'=>'1'));
} else {
	$cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	$rs = $DB->get_recordset_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.category = :cat AND co.visible = :visible ORDER BY co.shortname', 
			array('type'=>$usagetype, 'cat'=>$category, 'visible'=>'1'));
}

echo $OUTPUT->heading(get_string('lb_category', 'report_coursestats') . ': ' . $catname . ' - ' . $link);

$table = new html_table();
$table->head = array(	get_string('lb_course_name', 'report_coursestats'),
						get_string('lb_prev_usage_type', 'report_coursestats'), 
						get_string('lb_curr_usage_type', 'report_coursestats'),
						get_string('lb_last_update', 'report_coursestats'));
foreach ($rs as $cs) {
    $row = array();
    $row[] = '<a href=' . $CFG->wwwroot . '/course/view.php?id=' . $cs->courseid . '>' . $cs->shortname . '</a>';
    
    if ($cs->prev_usage_type === FORUM_USAGE_TYPE) {
		$row[] = get_string('lb_forum_usage', 'report_coursestats');
	} else if ($cs->prev_usage_type === REPOSITORY_USAGE_TYPE) {
		$row[] = get_string('lb_repository_usage', 'report_coursestats');
	} else if ($cs->prev_usage_type === ACTIVITY_USAGE_TYPE) {
		$row[] = get_string('lb_activity_usage', 'report_coursestats');
	} else {
		$row[] = get_string('lb_null_usage', 'report_coursestats');
	}  
    
    if ($cs->curr_usage_type === FORUM_USAGE_TYPE) {
		$row[] = get_string('lb_forum_usage', 'report_coursestats');
	} else if ($cs->curr_usage_type === REPOSITORY_USAGE_TYPE) {
		$row[] = get_string('lb_repository_usage', 'report_coursestats');
	} else if ($cs->curr_usage_type === ACTIVITY_USAGE_TYPE) {
		$row[] = get_string('lb_activity_usage', 'report_coursestats');
	} else {
		$row[] = get_string('lb_null_usage', 'report_coursestats');
	}
	
	$row[] = userdate($cs->last_update, get_string('strftimedatefullshort'));

	$table->data[] = $row;
}
$rs->close();

echo html_writer::table($table);


echo $OUTPUT->footer();
