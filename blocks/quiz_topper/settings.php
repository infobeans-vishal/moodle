<?php

$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('headerconfig', 'block_quiz_topper'),
    get_string('descconfig', 'block_quiz_topper')
));

$settings->add(new admin_setting_configcheckbox(
    'quiz_topper/Allow_HTML',
    get_string('labelallowhtml', 'block_quiz_topper'),
    get_string('descallowhtml', 'block_quiz_topper'),
    '0'
));