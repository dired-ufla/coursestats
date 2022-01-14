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

$type = optional_param('type', CREATED_COURSES, PARAM_ALPHA);    // usage type
$category = optional_param('category', ALL_CATEGORIES, PARAM_INT);
$dep = optional_param('dep', ALL_DEP, PARAM_ALPHANUM);

admin_externalpage_setup('reportcoursestats', '', null, '', array('pagelayout'=>'report'));

if ($type == CREATED_COURSES && $category == ALL_CATEGORIES && $dep == ALL_DEP) {
    $catname = get_string('lb_all_categories', 'report_coursestats');	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co WHERE co.visible = :visible ORDER BY co.shortname', 
			array('visible'=>'1'));
} else if ($type == CREATED_COURSES && $category == ALL_CATEGORIES && $dep != ALL_DEP) {
    $catname = get_string('lb_all_categories', 'report_coursestats');	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co WHERE co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false) . ' ORDER BY co.shortname', 
            array('visible'=>'1', 'name'=>'%'.$dep.'%'));
    
} else if ($type == CREATED_COURSES && $category != ALL_CATEGORIES && $dep == ALL_DEP) {
    $cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co WHERE co.category = :cat AND co.visible = :visible ORDER BY co.shortname', 
			array('cat'=>$category, 'visible'=>'1'));
} else if ($type == CREATED_COURSES && $category != ALL_CATEGORIES && $dep != ALL_DEP) {
    $cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co WHERE co.category = :cat AND co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false) . ' ORDER BY co.shortname', 
			array('cat'=>$category, 'visible'=>'1', 'name'=>'%'.$dep.'%'));
} else if ($type == USED_COURSES && $category == ALL_CATEGORIES && $dep == ALL_DEP) {
    $catname = get_string('lb_all_categories', 'report_coursestats');	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible ORDER BY co.shortname', 
			array('visible'=>'1'));
} else if ($type == USED_COURSES && $category == ALL_CATEGORIES && $dep != ALL_DEP) {
    $catname = get_string('lb_all_categories', 'report_coursestats');	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false) . ' ORDER BY co.shortname', 
			array('visible'=>'1', 'name'=>'%'.$dep.'%'));
} else if ($type == USED_COURSES && $category != ALL_CATEGORIES && $dep == ALL_DEP) {
    $cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.category = :cat AND co.visible = :visible ORDER BY co.shortname', 
			array('cat'=>$category, 'visible'=>'1'));        
} else if ($type == USED_COURSES && $category != ALL_CATEGORIES && $dep != ALL_DEP) {
    $cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.category = :cat AND co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false) . ' ORDER BY co.shortname', 
			array('cat'=>$category, 'visible'=>'1', 'name'=>'%'.$dep.'%'));        
} else if ($type == NOTUSED_COURSES && $category == ALL_CATEGORIES && $dep == ALL_DEP) {
    $catname = get_string('lb_all_categories', 'report_coursestats');	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co LEFT JOIN {report_coursestats} cs ON co.id = cs.courseid WHERE co.visible = :visible AND cs.courseid IS NULL ORDER BY co.shortname', 
			array('visible'=>'1'));
} else if ($type == NOTUSED_COURSES && $category == ALL_CATEGORIES && $dep != ALL_DEP) {
    $catname = get_string('lb_all_categories', 'report_coursestats');	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co LEFT JOIN {report_coursestats} cs ON co.id = cs.courseid WHERE co.visible = :visible AND cs.courseid IS NULL AND ' . $DB->sql_like('co.shortname', ':name', false, false) . ' ORDER BY co.shortname', 
			array('visible'=>'1', 'name'=>'%'.$dep.'%'));
} else if ($type == NOTUSED_COURSES && $category != ALL_CATEGORIES && $dep == ALL_DEP) { 
    $cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co LEFT JOIN {report_coursestats} cs ON co.id = cs.courseid WHERE co.category = :cat AND co.visible = :visible AND cs.courseid IS NULL ORDER BY co.shortname', 
			array('cat'=>$category, 'visible'=>'1'));
} else { // ($type == NOTUSED_COURSES && $category != ALL_CATEGORIES && $dep != ALL_DEP) 
    $cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
	
	$rs = $DB->get_recordset_sql('SELECT co.id, co.shortname FROM {course} co LEFT JOIN {report_coursestats} cs ON co.id = cs.courseid WHERE co.category = :cat AND co.visible = :visible AND cs.courseid IS NULL AND ' . $DB->sql_like('co.shortname', ':name', false, false) . ' ORDER BY co.shortname', 
			array('cat'=>$category, 'visible'=>'1', 'name'=>'%'.$dep.'%'));
}

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$fp = fopen('php://output', 'w');

$head = array(	get_string('lb_course_name', 'report_coursestats'));
fputcsv($fp, $head);

foreach ($rs as $cs) {
    $row = array();
    $row[] = $cs->shortname;
	fputcsv($fp, $row);
    
}
$rs->close();
fclose($fp);
