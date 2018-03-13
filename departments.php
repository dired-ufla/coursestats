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

$url = new moodle_url($CFG->wwwroot . '/report/coursestats/index.php');
$link = html_writer::link($url, get_string('link_back', 'report_coursestats'));

if ($category == ALL_CATEGORIES) {
	$catname = get_string('lb_all_categories', 'report_coursestats');
} else {
	$cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'report_coursestats') . ' (' .$catname. ') - ' . $link);

$table = new html_table();

$row = array();
$row[] = '<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=' . get_string('lb_all_dep', 'report_coursestats') . '&dep=' . ALL_DEP . '>' .get_string('lb_all_dep', 'report_coursestats') . '</a>';
$table->data[] = $row;

$table->head = array(	get_string('lb_choose_dep', 'report_coursestats'));

// Departments
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DAE&dep=gae>DAE - Administração e Economia</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DAG&dep=gag>DAG - Agricultura</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DBI&dep=gbi>DBI - Biologia</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DCA&dep=gca>DCA - Ciência dos Alimentos</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DCC&dep=gcc>DCC - Ciência da Computação</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DCS&dep=gcs>DCS - Ciência do Solo</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DSA&dep=gsa>DSA - Ciências da Saúde</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DEX&dep=gex>DEX - Ciências Exatas</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DCF&dep=gef>DCF - Ciências Florestais</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DCH&dep=gch>DCH - Ciências Humanas</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DIR&dep=gdi>DIR - Direito</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DED&dep=gde>DED - Educação</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DEF&dep=gef>DEF - Educação Física</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DEG&dep=gne>DEG - Engenharia</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DEN&dep=get>DEN - Entomologia</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DES&dep=ges>DES - Estatística</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DFI&dep=gfi>DFI - Física</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DFP&dep=gfp>DFP - Fitopatologia</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DNU&dep=gnu>DNU - Nutrição</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DMV&dep=gmv>DMV - Medicina Veterinária</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DQI&dep=gqi>DQI - Química</a>');
$table->data[] = array('<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=DZO&dep=gzo>DZO - Zootecnia</a>');
 
echo html_writer::table($table);

echo $OUTPUT->footer();

