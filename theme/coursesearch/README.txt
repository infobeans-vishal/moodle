moodle-theme_coursesearch shows how the results evaluted from course search plugin are displayed. It is based on bootstrap
clean theme.

**** To enable "advance course search" ****


you may install search_coursesearch. It will make you use advance course search out of box.

OR 

follow these steps.

Step 1 :- Either copy/replace file renderer.php file to your theme renderer.php file.

* replace /theme/coursesearch/renderers.php (distributed with tool_coursesearch too /coursesearch/example/renderers.php)
with /theme/yourtheme/renderers.php

* The standard theme doesn't have renderer file so you need to simply copy the renderer file.

Step 2 :- Rename renderer class name acording to your theme name.

for example if you are using theme 'clean' then rename the class name to 'theme_clean_core_course_renderer'

Note:- You can try hwo the search results will look like by going to /course/example.php without installing

coursesearch theme or modifying rederers.php. 

Thanks :)