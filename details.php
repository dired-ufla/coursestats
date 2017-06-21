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

// page parameters
$page    = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 30, PARAM_INT);    // how many per page

admin_externalpage_setup('reportcoursestats', '', null, '', array('pagelayout'=>'report'));

$url = new moodle_url($CFG->wwwroot . '/report/coursestats/index.php');
$link = html_writer::link($url, get_string('link_back', 'report_coursestats'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'report_coursestats') . ' - ' . $link);

$baseurl = new moodle_url('details.php', array('perpage' => $perpage));
echo $OUTPUT->paging_bar(5, $page, $perpage, $baseurl);

$sql = "SELECT co.shortname, cs.courseid, cs.prev_usage_type, cs.curr_usage_type, cs.last_update  
        FROM {report_coursestats} cs 
        JOIN {course} co ON co.id = cs.courseid
        ORDER BY co.shortname";
$rs = $DB->get_recordset_sql($sql, array(), $page*$perpage, $perpage);


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
