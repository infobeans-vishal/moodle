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
 * Displays external information about a course
 * @package    core
 * @category   course
 * @copyright  Shashikant Vaishnav
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/coursecatlib.php');

$search     = optional_param('search', '', PARAM_RAW);  // Search words.
$page       = optional_param('page', 0, PARAM_INT);     // Which page to show.
$perpage    = optional_param('perpage', '', PARAM_RAW); // How many per page, may be integer or 'all'.
$blocklist  = optional_param('blocklist', 0, PARAM_INT);
$modulelist = optional_param('modulelist', '', PARAM_PLUGIN);
$tagid      = optional_param('tagid', '', PARAM_INT);   // Searches for courses tagged with this tag id.

// List of minimum capabilities which user need to have for editing/moving course.
$capabilities = array('moodle/course:create', 'moodle/category:manage');

// Populate usercatlist with list of category id's with course:create and category:manage capabilities.
$usercatlist = coursecat::make_categories_list($capabilities);

$search = trim(strip_tags($search)); // Trim & clean raw searched string.

$site = get_site();

$searchcriteria = array();
foreach (array('search', 'blocklist', 'modulelist', 'tagid') as $param) {
    if (!empty($$param)) {
        $searchcriteria[$param] = $$param;
    }
}
$urlparams = array();
if ($perpage !== 'all' && !($perpage = (int)$perpage)) {
    // Default number of courses per page.
    $perpage = $CFG->coursesperpage;
} else {
    $urlparams['perpage'] = $perpage;
}
if (!empty($page)) {
    $urlparams['page'] = $page;
}
$PAGE->set_url('/course/search.php', $searchcriteria + $urlparams);
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$courserenderer = $PAGE->get_renderer('core', 'course');

if ($CFG->forcelogin) {
    require_login();
}

$strcourses = new lang_string("courses");
$strsearch = new lang_string("search");
$strsearchresults = new lang_string("searchresults");
$strnovalidcourses = new lang_string('novalidcourses');

$PAGE->navbar->add($strcourses, new moodle_url('/course/index.php'));
$PAGE->navbar->add($strsearch, new moodle_url('/course/search.php'));
if (!empty($search)) {
    $PAGE->navbar->add(s($search));
}

if (empty($searchcriteria)) {
    // No search criteria specified, print page with just search form.
    $PAGE->set_title("$site->fullname : $strsearch");
} else {
    // This is search results page.
    $PAGE->set_title("$site->fullname : $strsearchresults");
    // Link to manage search results should be visible if user have system or category level capability.
    if ((can_edit_in_category() || !empty($usercatlist))) {
        $aurl = new moodle_url('/course/manage.php', $searchcriteria);
        $searchform = $OUTPUT->single_button($aurl, get_string('managecourses'), 'get');
    } else {
        $searchform = $courserenderer->course_search_form($search, 'navbar');
    }
    $PAGE->set_button($searchform);
}
$PAGE->set_heading($site->fullname);
echo $OUTPUT->header();
$renderer = $PAGE->get_renderer('tool_coursesearch');
echo $renderer->search_courses($searchcriteria);
echo $OUTPUT->footer();