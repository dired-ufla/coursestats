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

function get_amount_created_courses($course) {
	global $category;
	global $DB;
	
	if ($category == ALL_CATEGORIES and $course == ALL_COURSES) {
		return ($DB->count_records(COURSE_TABLE_NAME, 
			array('visible'=>'1')) - 1);
	} else if ($category == ALL_CATEGORIES and $course != ALL_COURSES) {
		return ($DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE ' . $DB->sql_like('co.shortname', ':name', false, false). ' AND co.visible = :visible', 
			array('name'=>'%'.$course.'%', 'visible'=>'1')));
	} else if ($category != ALL_CATEGORIES and $course == ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE co.visible = :visible AND co.category = :cat', 
			array('cat'=>$category, 'visible'=>'1'));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE co.visible = :visible AND co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('visible'=>'1', 'cat'=>$category, 'name'=>'%'.$course.'%'));
	}	
}

function get_amount_used_courses($course) {
	global $category;
	global $DB;
	
	if ($category == ALL_CATEGORIES and $course == ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible', 
			array('visible'=>'1'));
	} else if ($category == ALL_CATEGORIES and $course != ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('visible'=>'1', 'name'=>'%'.$course.'%'));
	} else if ($category != ALL_CATEGORIES and $course == ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible AND co.category = :cat', 
			array('visible'=>'1', 'cat'=>$category));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE co.visible = :visible AND  co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('visible'=>'1', 'cat'=>$category, 'name'=>'%'.$course.'%'));
	}
}

$courses = array(
	array('cod'=>'G001', 'acr'=>'G001', 'name'=>'Agronomia'),
	array('cod'=>'G002', 'acr'=>'G002', 'name'=>'Zootecnia'),
	array('cod'=>'G003', 'acr'=>'G003', 'name'=>'Engenharia Agrícola'),
	array('cod'=>'G005', 'acr'=>'G005', 'name'=>'Engenharia Florestal'),
	array('cod'=>'G007', 'acr'=>'G007', 'name'=>'Medicina Veterinária'),
	array('cod'=>'G009', 'acr'=>'G009', 'name'=>'Administração'),
	array('cod'=>'G010', 'acr'=>'G010', 'name'=>'Ciência da Computação'),
	array('cod'=>'G011', 'acr'=>'G011', 'name'=>'Engenharia de Alimentos'),
	array('cod'=>'G012', 'acr'=>'G012', 'name'=>'Ciências Biológicas'),
	array('cod'=>'G013', 'acr'=>'G013', 'name'=>'Química (Licenciatura)'),
	array('cod'=>'G014', 'acr'=>'G014', 'name'=>'Sistemas de Informação'),
	array('cod'=>'G015', 'acr'=>'G015', 'name'=>'Matemática'),
	array('cod'=>'G018', 'acr'=>'G018', 'name'=>'Física'),
	array('cod'=>'G019', 'acr'=>'G019', 'name'=>'Engenharia Ambiental e Sanitária'),
	array('cod'=>'G020', 'acr'=>'G020', 'name'=>'Ciências Biológicas'),
	array('cod'=>'G021', 'acr'=>'G021', 'name'=>'Química (Bacharelado)'),
	array('cod'=>'G022', 'acr'=>'G022', 'name'=>'Engenharia de Controle e Automação'),
	array('cod'=>'G023', 'acr'=>'G023', 'name'=>'Nutrição'),
	array('cod'=>'G024', 'acr'=>'G024', 'name'=>'Filosofia'),
	array('cod'=>'G025', 'acr'=>'G025', 'name'=>'Letras'),
	array('cod'=>'G026', 'acr'=>'G026', 'name'=>'Administração Pública'),
	array('cod'=>'G027', 'acr'=>'G027', 'name'=>'Direito'),
	array('cod'=>'G028', 'acr'=>'G028', 'name'=>'Educação Física (Licenciatura)'),
	array('cod'=>'G029', 'acr'=>'G029', 'name'=>'Educação Física (Bacharelado)'),
	array('cod'=>'G030', 'acr'=>'G030', 'name'=>'ABI Engenharia'),
	array('cod'=>'G031', 'acr'=>'G031', 'name'=>'Engenharia Civil'),
	array('cod'=>'G032', 'acr'=>'G032', 'name'=>'Engenharia Mecânica'),
	array('cod'=>'G033', 'acr'=>'G033', 'name'=>'Engenharia Química'),
	array('cod'=>'G034', 'acr'=>'G034', 'name'=>'Engenharia de Materiais'),
	array('cod'=>'G035', 'acr'=>'G035', 'name'=>'Medicina'),
	array('cod'=>'G036', 'acr'=>'G036', 'name'=>'Pedagogia')
); 


$courses_acr_array = array('G001', 'G002', 'G003', 'G005', 'G007', 'G009', 'G010', 'G011', 
	'G012', 'G013', 'G014', 'G015', 'G018', 'G019', 'G020', 'G021', 'G022', 'G023', 'G024', 
	'G025', 'G026', 'G027', 'G028', 'G029', 'G030', 'G031', 
	'G032', 'G033', 'G034', 'G035', 'G036');

$url = new moodle_url($CFG->wwwroot . '/report/coursestats/index.php');
$link = html_writer::link($url, get_string('link_back', 'report_coursestats'));

if ($category == ALL_CATEGORIES) {
	$catname = get_string('lb_all_categories', 'report_coursestats');
} else {
	$cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('lb_category', 'report_coursestats') . $catname. ' - ' . $link);

$table = new html_table();
$table->size = array( '55%', '15%', '15%', '15%');
$table->head = array(get_string('lb_choose_dep', 'report_coursestats'), get_string('lb_courses_created_amount', 'report_coursestats'),
	get_string('lb_used_courses', 'report_coursestats'), get_string('lb_percent_of_used_courses', 'report_coursestats'));

$link = '<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=' . get_string('lb_all_dep', 'report_coursestats') . '&dep=' . ALL_DEP . '>' .get_string('lb_all_dep', 'report_coursestats') . '</a>';
$co_created = get_amount_created_courses(ALL_COURSES);
$co_used = get_amount_used_courses(ALL_COURSES);
if ($co_created > 0) {
	$co_percent = number_format(($co_used / $co_created) * 100, 2) . '%';
} else {
	$co_percent = '-';
}
	
$table->data[] = array($link, $co_created, $co_used, $co_percent);

$created_courses_array = array();
$used_courses_array = array();
$percentage_used_courses_array = array();

foreach ($courses as $course) {
	$co_created = get_amount_created_courses($course['cod']);
	$co_used = get_amount_used_courses($course['cod']);
	
	$created_courses_array[] = $co_created;
	$used_courses_array[] = $co_used;
	
	$link = '<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=' . $course['acr'] . 
		'&dep=' . $course['cod'] . '>' . $course['name'] . '</a>';
	
	if ($co_created > 0) {
		$co_percent = number_format(($co_used / $co_created) * 100, 2) . '%';
		$percentage_used_courses_array[] = number_format(($co_used / $co_created) * 100, 2);
	} else {
		$co_percent = '-';
		$percentage_used_courses_array[] = 0;
	}
	$table->data[] = array($link, $co_created, $co_used, $co_percent);
}
 
if (class_exists('core\chart_bar')) {
	$chart_stacked = new core\chart_bar();
	//$chart_percentage = new core\chart_bar();
	
	$created_courses_serie = new core\chart_series(get_string('lb_courses_created_amount', 'report_coursestats'), $created_courses_array);
	$used_courses_serie = new core\chart_series(get_string('lb_used_courses', 'report_coursestats'), $used_courses_array);
	$percentage_used_courses_serie = new core\chart_series(get_string('lb_percent_of_used_courses', 'report_coursestats'), $percentage_used_courses_array);
	$percentage_used_courses_serie->set_type(\core\chart_series::TYPE_LINE);
	
	$chart_stacked->add_series($percentage_used_courses_serie);
	$chart_stacked->add_series($created_courses_serie);
	$chart_stacked->add_series($used_courses_serie);
	$chart_stacked->set_labels($courses_acr_array);
	
	echo $OUTPUT->render_chart($chart_stacked, false);
	//echo $OUTPUT->render_chart($chart_percentage, false);
}

$url_csv = new moodle_url($CFG->wwwroot . '/report/coursestats/csvgen.php?category=' . $category);
$link_csv = html_writer::link($url_csv, get_string('link_csv', 'report_coursestats'));

echo '<p align="center">' . $link_csv . '</p>';

echo html_writer::table($table);

echo $OUTPUT->footer();

