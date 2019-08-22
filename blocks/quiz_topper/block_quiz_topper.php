<?php

/**
 * Block displaying information about current logged-in user.
 *
 * This block can be used as anti cheating measure, you
 * can easily check the logged-in user matches the person
 * operating the computer.
 *
 * @package   block_quiz_topper
 * @copyright 2010 Remote-Learner.net
 * @author    Vishal Ingole <vishal.ingole@infobeans.com>
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
// class block_quiz_topper extends block_list
class block_quiz_topper extends block_base
{
    /**
     * Block initializations
     */
    public function init()
    {
        $this->title = get_string('pluginname', 'block_quiz_topper');
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

            if ($badges = quiz_get_quiz_topper()) {
                $badges = json_decode(json_encode($badges), true);
                $this->content->text = '<table width="100%"><tr><th width="70%">Quiz</th><th width="30%">User</th></tr>';
                foreach ($badges as $badge) {
                    $this->content->text .= '<tr><td><a class="ellipsis" href="'.$CFG->wwwroot.'/course/view.php?id='.$badge['courseid'].'">'.ucfirst($badge['name']).'</a></td> <td><a href="'.$CFG->wwwroot.'/user/profile.php?id='.$badge['id'].'">'.ucwords($badge['username']).'</a></td></tr>';
                }
                $this->content->text .= '</table>';
            } else {
                $this->content->item .= get_string('nothingtodisplay', 'block_quiz_topper');
            }
        }

        return $this->content;
    }

    public function specialization()
    {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('defaulttitle', 'block_quiz_topper');
            } else {
                $this->title = $this->config->title;
            }

            if (empty($this->config->text)) {
                $this->config->text = get_string('defaulttext', 'block_quiz_topper');
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
        if (get_config('quiz_topper', 'Allow_HTML') == '1') {
            $data->text = strip_tags($data->text);
        }
        // And now forward to the default implementation defined in the parent class
        return parent::instance_config_save($data, $nolongerused);
    }
}
