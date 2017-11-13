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

$category = optional_param('category', ALL_CATEGORIES, PARAM_INT);

if ($category == ALL_CATEGORIES) {
	$only_forum_courses = $DB->count_records(PLUGIN_TABLE_NAME, array('curr_usage_type'=>FORUM_USAGE_TYPE));
	$only_repository_courses = $DB->count_records(PLUGIN_TABLE_NAME, array('curr_usage_type'=>REPOSITORY_USAGE_TYPE));
	$activity_courses = $DB->count_records(PLUGIN_TABLE_NAME, array('curr_usage_type'=>ACTIVITY_USAGE_TYPE));
	$catname = get_string('lb_all_categories', 'report_coursestats');
	$amount_of_created_courses = $DB->count_records(COURSE_TABLE_NAME);
} else {
	$only_forum_courses = $DB->count_records(PLUGIN_TABLE_NAME, array('curr_usage_type'=>FORUM_USAGE_TYPE, 'categoryid'=>$category));
	$only_repository_courses = $DB->count_records(PLUGIN_TABLE_NAME, array('curr_usage_type'=>REPOSITORY_USAGE_TYPE, 'categoryid'=>$category));
	$activity_courses = $DB->count_records(PLUGIN_TABLE_NAME, array('curr_usage_type'=>ACTIVITY_USAGE_TYPE, 'categoryid'=>$category));
	$cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	$amount_of_created_courses = $DB->count_records(COURSE_TABLE_NAME, array('category'=>$category));
}

$amount_of_courses = $only_forum_courses +  $only_repository_courses + $activity_courses;

$url = new moodle_url($CFG->wwwroot . '/report/coursestats/index.php');
$link = html_writer::link($url, get_string('link_back', 'report_coursestats'));

echo $OUTPUT->header();

if ($amount_of_courses > 0) {
	echo $OUTPUT->heading(get_string('pluginname', 'report_coursestats') . ' (' . $catname . ') - ' . $link);

	if (class_exists('core\chart_pie')) {
		$data = new core\chart_series(get_string('lb_chart_series', 'report_coursestats'), [$only_forum_courses, $only_repository_courses, $activity_courses]);
		$chart = new core\chart_pie();
		$chart->add_series($data); 
		$chart->set_labels([get_string('lb_forum_usage', 'report_coursestats'), get_string('lb_repository_usage', 'report_coursestats'), get_string('lb_activity_usage', 'report_coursestats')]);
		echo $OUTPUT->render_chart($chart, false);
	} 

	$table = new html_table();
	
	$table->head = array(	get_string('lb_usage_type_name', 'report_coursestats'),
						get_string('lb_courses_amount', 'report_coursestats'), 
						get_string('lb_percent_of_used_courses', 'report_coursestats'),
						get_string('lb_percent_of_created_courses', 'report_coursestats'),
						get_string('lb_usage_type_desc', 'report_coursestats'));
	
	$url_filter_forum_usage_type = new moodle_url($CFG->wwwroot . '/report/coursestats/details.php?usagetype=' . FORUM_USAGE_TYPE . '&category=' . $category);
	$url_filter_repository_usage_type = new moodle_url($CFG->wwwroot . '/report/coursestats/details.php?usagetype=' . REPOSITORY_USAGE_TYPE . '&category=' . $category);
	$url_filter_activities_usage_type = new moodle_url($CFG->wwwroot . '/report/coursestats/details.php?usagetype=' . ACTIVITY_USAGE_TYPE . '&category=' . $category);

	$table->data = array(
		array(html_writer::link($url_filter_forum_usage_type, get_string('lb_forum_usage', 'report_coursestats')), $only_forum_courses, number_format(($only_forum_courses/$amount_of_courses)*100, 2) . '%', number_format(($only_forum_courses/$amount_of_created_courses)*100, 2) . '%', get_string('lb_forum_usage_help', 'report_coursestats')),
		array(html_writer::link($url_filter_repository_usage_type, get_string('lb_repository_usage', 'report_coursestats')), $only_repository_courses, number_format(($only_repository_courses/$amount_of_courses)*100, 2) . '%', number_format(($only_repository_courses/$amount_of_created_courses)*100, 2) . '%', get_string('lb_repository_usage_help', 'report_coursestats')),
		array(html_writer::link($url_filter_activities_usage_type, get_string('lb_activity_usage', 'report_coursestats')), $activity_courses, number_format(($activity_courses/$amount_of_courses)*100, 2) . '%', number_format(($activity_courses/$amount_of_created_courses)*100, 2) . '%', get_string('lb_activity_usage_help', 'report_coursestats'))
	);
	echo html_writer::table($table);
	echo html_writer::tag('p', get_string('lb_courses_stats', 'report_coursestats') . ": " . $amount_of_courses . '/' . $amount_of_created_courses . ' = ' . number_format(($amount_of_courses/$amount_of_created_courses)*100, 2) . '%');
} else {
	echo html_writer::tag('p', get_string('lb_there_are_no_courses_stats', 'report_coursestats') . ' (' .$link . ')', array('align' => 'center'));
}

echo $OUTPUT->footer();

