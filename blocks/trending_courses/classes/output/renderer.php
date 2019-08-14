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
 * trending_courses block rendrer
 *
 * @package    block_trending_courses
 * @copyright  2018 Mihail Geshoski <mihail@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_trending_courses\output;

defined('MOODLE_INTERNAL') || die;

use plugin_renderer_base;

/**
 * trending_courses block renderer
 *
 * @package    block_trending_courses
 * @copyright  2018 Mihail Geshoski <mihail@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Return the main content for the block trending_courses.
     *
     * @param trending_courses $trending_courses The trending_courses renderable
     * @return string HTML string
     */
    public function render_trending_courses(trending_courses $trending_courses) {
        return $this->render_from_template('block_trending_courses/trending_courses', $trending_courses->export_for_template($this));
    }
}
