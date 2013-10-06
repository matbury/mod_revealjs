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
 * Reveal.js renders presentation main view
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matt@matbury.com>  {@link http://matbury.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once($CFG->dirroot.'/mod/revealjs/locallib.php');
require_once($CFG->libdir.'/completionlib.php');

$id      = optional_param('id', 0, PARAM_INT); // Course Module ID
$p       = optional_param('p', 0, PARAM_INT);  // Page instance ID
$inpopup = optional_param('inpopup', 0, PARAM_BOOL);

if ($p) {
    if (!$revealjs = $DB->get_record('revealjs', array('id'=>$p))) {
        print_error('invalidaccessparameter');
    }
    $cm = get_coursemodule_from_instance('revealjs', $revealjs->id, $revealjs->course, false, MUST_EXIST);

} else {
    if (!$cm = get_coursemodule_from_id('revealjs', $id)) {
        print_error('invalidcoursemodule');
    }
    $revealjs = $DB->get_record('revealjs', array('id'=>$cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/revealjs:view', $context);

add_to_log($course->id, 'revealjs', 'view', 'view.php?id='.$cm->id, $revealjs->id, $cm->id);

// Update 'viewed' state if required by completion system
require_once($CFG->libdir . '/completionlib.php');
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

/*
// Don't use Moodle's page renderer
$PAGE->set_url('/mod/revealjs/view.php', array('id' => $cm->id));

$options = empty($revealjs->displayoptions) ? array() : unserialize($revealjs->displayoptions);

if ($inpopup and $revealjs->display == RESOURCELIB_DISPLAY_POPUP) {
    $PAGE->set_pagelayout('popup');
    $PAGE->set_title($course->shortname.': '.$revealjs->name);
    if (!empty($options['printheading'])) {
        $PAGE->set_heading($revealjs->name);
    } else {
        $PAGE->set_heading('');
    }
    echo $OUTPUT->header();

} else {
    $PAGE->set_title($course->shortname.': '.$revealjs->name);
    $PAGE->set_heading($course->fullname);
    $PAGE->set_activity_record($revealjs);
    echo $OUTPUT->header();

    if (!empty($options['printheading'])) {
        echo $OUTPUT->heading(format_string($revealjs->name), 2, 'main', 'revealjsheading');
    }
}

if (!empty($options['printintro'])) {
    if (trim(strip_tags($revealjs->intro))) {
        echo $OUTPUT->box_start('mod_introbox', 'revealjsintro');
        echo format_module_intro('revealjs', $revealjs, $cm->id);
        echo $OUTPUT->box_end();
    }
}

$content = file_rewrite_pluginfile_urls($revealjs->content, 'pluginfile.php', $context->id, 'mod_revealjs', 'content', $revealjs->revision);
$formatoptions = new stdClass;
$formatoptions->noclean = true;
$formatoptions->overflowdiv = true;
$formatoptions->context = $context;
$content = format_text($content, $revealjs->contentformat, $formatoptions);
echo $content;
echo $OUTPUT->box($content, "generalbox center clearfix");
echo $OUTPUT->footer();
 */

// Load HTML presentation file
$revealjs->presentation = file_get_contents($CFG->dataroot.$CFG->revealjs_content_dir.$revealjs->presentation);
// Replace URLs to embedded media in moodledata in HTML presentation file
$revealjs->presentation = str_replace('src="aaaaa/', 'src="'.$CFG->wwwroot.'/mod/revealjs/content.php/aaaaa/', $revealjs->presentation);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $revealjs->name; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?php echo $revealjs->name; ?>" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta name="last-modified" content="<?php echo userdate($revealjs->timemodified); ?>">
    <meta name="last-modified-timestamp" content="<?php echo $revealjs->timemodified; ?>">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/reveal.min.css">
    <!-- Set theme: beige, default, moon, right, serif, simple, sky, solarized -->
    <link rel="stylesheet" href="css/theme/<?php echo $revealjs->theme; ?>" id="theme">
    <!-- For syntax highlighting -->
    <link rel="stylesheet" href="lib/css/zenburn.css">
    <!-- If the query includes 'print-pdf', use the PDF print sheet -->
    <script type="text/javascript">
        document.write( '<link rel="stylesheet" href="css/print/' + ( window.location.search.match( /print-pdf/gi ) ? 'pdf' : 'paper' ) + '.css" type="text/css" media="print">' );
    </script>
    <!--[if lt IE 9]>
        <script src="lib/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
    <div class="reveal">
        
        <!-- Any section element inside of this container is displayed as a slide -->
        <div class="slides">
            <?php echo $revealjs->presentation; ?>
        </div>
        
    </div>
    <script src="lib/js/head.min.js"></script>
    <script src="js/reveal.min.js"></script>
    <script type="text/javascript">
        // Full list of configuration options available here:
        // https://github.com/hakimel/reveal.js#configuration
        Reveal.initialize({
        
        // The "normal" size of the presentation, aspect ratio will be preserved
        // when the presentation is scaled to fit different resolutions. Can be
        // specified using percentage units.
        width: <?php echo $revealjs->width ?>,
        height: <?php echo $revealjs->height ?>,

        // Factor of the display size that should remain empty around the content
        margin: <?php echo $revealjs->margin ?>,

        // Bounds for smallest/largest possible scale to apply to content
        minScale: <?php echo $revealjs->minscale ?>,
        maxScale: <?php echo $revealjs->maxscale ?>,
        
        // Display controls in the bottom right corner
        controls: <?php echo $revealjs->controls ?>,

        // Display a presentation progress bar
        progress: <?php echo $revealjs->progress ?>,

        // Push each slide change to the browser history
        history: <?php echo $revealjs->history ?>,

        // Enable keyboard shortcuts for navigation
        keyboard: <?php echo $revealjs->keyboard ?>,

        // Enable touch events for navigation
        touch: <?php echo $revealjs->touch ?>,

        // Enable the slide overview mode
        overview: <?php echo $revealjs->overview ?>,

        // Vertical centering of slides
        center: <?php echo $revealjs->center ?>,

        // Loop the presentation
        loop: <?php echo $revealjs->looped ?>,

        // Change the presentation direction to be RTL
        rtl: <?php echo $revealjs->rtl ?>,

        // Number of milliseconds between automatically proceeding to the
        // next slide, disabled when set to 0, this value can be overwritten
        // by using a data-autoslide attribute on your slides
        autoSlide: <?php echo $revealjs->autoslide ?>,

        // Enable slide navigation via mouse wheel
        mouseWheel: <?php echo $revealjs->mousewheel ?>,

        // Transition style
        transition: '<?php echo $revealjs->transition ?>', // default/cube/page/concave/zoom/linear/fade/none

        // Transition speed
        transitionSpeed: '<?php echo $revealjs->transitionspeed ?>', // default/fast/slow

        // Transition style for full page backgrounds
        backgroundTransition: '<?php echo $revealjs->backgroundtransition ?>', // default/linear/none
        
        // Optional libraries used to extend on reveal.js
        dependencies: [
            { src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
            { src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
            { src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
            { src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
            { src: 'plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } },
            { src: 'plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } }
        ]
        });
    </script>
</body>
</html>
?>