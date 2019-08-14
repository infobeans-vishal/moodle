<?php

/**
 * Block displaying information about current logged-in user.
 *
 * This block can be used as anti cheating measure, you
 * can easily check the logged-in user matches the person
 * operating the computer.
 *
 * @package   block_trending_courses
 * @copyright 2010 Remote-Learner.net
 * @author    Vishal Ingole <vishal.ingole@infobeans.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;

/**
 * Displays the current user's profile information.
 *
 * @author    Vishal Ingole <vishal.ingole@infobeans.com>
 * @copyright 2010 Remote-Learner.net
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// class block_trending_courses extends block_base
class block_trending_courses extends block_list
{
    /**
     * Block initializations
     */
    public function init()
    {
        $this->title = get_string('pluginname', 'block_trending_courses');
    }

    public function get_content()
    {
        global $CFG;
        $courseslib_file = $CFG->libdir . '/badgeslib.php';
        $assertions = array();

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content         = new stdClass;
        $this->content->items  = array();
        $this->content->icons  = array();

        if (file_exists($courseslib_file)) {
            require_once($courseslib_file);

            if ($badges = courses_get_trending_courses()) {
                $badges = json_decode(json_encode($badges), true);
                foreach ($badges as $badge) {
                    array_push($this->content->items, html_writer::tag('a', $badge['fullname'] , array('href' => $CFG->wwwroot.'/course/view.php?id='.$badge['id'])));
                }

            } else {
                $this->content->item .= get_string('nothingtodisplay', 'block_trending_courses');
            }
        }

        return $this->content;
    }

    public function specialization()
    {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_trending_courses');
            } else {
                $this->title = $this->config->title;
            }

            if (empty($this->config->text)) {
                $this->config->text = get_string('defaulttext', 'block_trending_courses');
            }
        }
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    public function has_config()
    {
        return true;
    }

    public function instance_config_save($data, $nolongerused = false)
    {
        if (get_config('trending_courses', 'Allow_HTML') == '1') {
            $data->text = strip_tags($data->text);
        }
        // And now forward to the default implementation defined in the parent class
        return parent::instance_config_save($data, $nolongerused);
    }
}
