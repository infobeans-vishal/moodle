<?php

$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('headerconfig', 'block_trending_courses'),
    get_string('descconfig', 'block_trending_courses')
));

$settings->add(new admin_setting_configcheckbox(
    'trending_courses/Allow_HTML',
    get_string('labelallowhtml', 'block_trending_courses'),
    get_string('descallowhtml', 'block_trending_courses'),
    '0'
));