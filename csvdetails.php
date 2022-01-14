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
$usagetype = optional_param('usagetype', ALL_USAGE_TYPE, PARAM_ALPHANUM);    // usage type
$category = optional_param('category', ALL_CATEGORIES, PARAM_INT);
$dep = optional_param('dep', ALL_DEP, PARAM_ALPHANUM);
$depname = optional_param('depname', '', PARAM_ALPHANUM);
$backto = optional_param('backto', DEPARTMENTS_PAGE, PARAM_ALPHANUM);

admin_externalpage_setup('reportcoursestats', '', null, '', array('pagelayout'=>'report'));

if ($category == ALL_CATEGORIES) {
	$catname = get_string('lb_all_categories', 'report_coursestats');	
	
	if ($dep == ALL_DEP) {
		$rs = $DB->get_recordset_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.visible = :visible ORDER BY co.shortname', 
			array('type'=>$usagetype, 'visible'=>'1'));
	} else {
		$rs = $DB->get_recordset_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false) . '  ORDER BY co.shortname', 
			array('type'=>$usagetype, 'visible'=>'1', 'name'=>'%'.$dep.'%'));
	}
	
} else {
	$cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	if ($dep == ALL_DEP) {
		$rs = $DB->get_recordset_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.category = :cat AND co.visible = :visible ORDER BY co.shortname', 
			array('type'=>$usagetype, 'cat'=>$category, 'visible'=>'1'));
	} else {
		$rs = $DB->get_recordset_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.category = :cat AND co.visible = :visible AND ' . 
			$DB->sql_like('co.shortname', ':name', false, false) . '  ORDER BY co.shortname', 
			array('type'=>$usagetype, 'cat'=>$category, 'visible'=>'1', 'name'=>'%'.$dep.'%'));
	}
}

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$fp = fopen('php://output', 'w');

$head = array(	get_string('lb_course_name', 'report_coursestats'),
						get_string('lb_course_fullname', 'report_coursestats'), 
						get_string('lb_professors', 'report_coursestats'));
fputcsv($fp, $head);

foreach ($rs as $cs) {
    $row = array();
    $row[] = $cs->shortname;
    $row[] = substr($cs->fullname, 0, strpos($cs->fullname, ")") + 2);
    $row[] = substr($cs->fullname, strpos($cs->fullname, ")") + 4);

    fputcsv($fp, $row);
}

fclose($fp);
