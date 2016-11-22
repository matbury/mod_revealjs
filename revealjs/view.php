<?php

// This package is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Reveal.js renders revealjs main view
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2015 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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

// Completion and trigger events.
revealjs_view($revealjs, $course, $cm, $context);

// Either navigate to course page or close popup link
$revealjs_back_close = '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'" title="'.get_string('saveandclose_title','revealjs').'">'.get_string('saveandclose','revealjs').'</a>';
if($inpopup === 1)
{
    $revealjs_back_close = '<a href="javascript:window.close();" title="'.get_string('saveandclose_title','revealjs').'">'.get_string('saveandclose','revealjs').'</a>';
}

// Enable remote control?
$revealjs_remotes = '';
if($revealjs->remotes === 'true')
{
    $revealjs_remotes = '{ src: \'plugin/remotes/remotes.js\', async: true },';
}

// Enable audio-slideshow?
$revealjs_audioslideshow = '';
$revealjs_transcript = '';
if($revealjs->audioslideshow === 'true')
{
    $revealjs_audioslideshow = '{ src: \'plugin/audio-slideshow/slideshow-recorder.js\', condition: function( ) { return !!document.body.classList; } },
                { src: \'plugin/audio-slideshow/audio-slideshow.js\', condition: function( ) { return !!document.body.classList; } },';
    $revealjs_transcript = '<a href="javascript: showHide();" title="'.get_string('showhidetranscript','revealjs').'"><transcript>'.get_string('hidetranscript','revealjs').' </transcript>'.get_string('toggletranscript','revealjs').'</a>';
}

// Enable menu plugin?
$revealjs_menu = '';
if($revealjs->showmenu === 'true')
{
    $revealjs_menu = '{ src: \'plugin/menu/menu.js\' },';
}

//Enable chart plugin?
$revealjs_charts = '';
if($revealjs->showcharts === 'true')
{
    $revealjs_charts = '{ src: \'plugin/chart/Chart.min.js\' },
                        { src: \'plugin/chart/csv2chart.js\' },';
}

//background image used?
if($revealjs->parallaxbackgroundimage === '')
{
    $revealjs->parallaxbackgroundsize = '0';
    $revealjs->parallaxbackgroundhorizontal = '0';
    $revealjs->parallaxbackgroundvertical = '0';
}

// Load HTML presentation file
$revealjs->presentation = file_get_contents($CFG->revealjs_data_dir.$revealjs->presentation);
// Replace URLs to embedded media in moodledata in HTML presentation file
$revealjs->presentation = str_replace('_revealjs_/', $CFG->wwwroot.'/mod/revealjs/content.php/_revealjs_/', $revealjs->presentation);

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $revealjs->name; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
        <link rel="stylesheet" href="css/reveal.css">
        <link rel="stylesheet" href="css/theme/<?php echo $revealjs->theme; ?>" id="theme">
        <link rel="stylesheet" href="plugin/accessibility/helper.css">
        <!-- Code syntax highlighting -->
        <link rel="stylesheet" href="lib/css/zenburn.css">
        <link href="css/menu.css" rel="stylesheet" type="text/css"/>
        <!-- Printing and PDF exports -->
        <script>
            var link = document.createElement( 'link' );
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = window.location.search.match( /print-pdf/gi ) ? 'css/print/pdf.css' : 'css/print/paper.css';
            document.getElementsByTagName( 'head' )[0].appendChild( link );
        </script>
        <!-- Show/Hide <transcript/> tags -->
        <style>
            .trans {
                display: none;
            }
            .topbar a {
                font-family: Arial;
                font-weight: bold;
                text-decoration: none;
                color: #888;
                float: right;
                padding: 5px;
            }
        </style>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script>
        function showHide() {
            $( "transcript" ).toggleClass( "trans" );
        };
	window.onload = function() {
            showHide();
        };
        </script>
        <!-- End of Show/Hide <transcript/> tags -->
        <!--[if lt IE 9]>
            <script src="lib/js/html5shiv.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="topbar"><?php echo $revealjs_back_close .' '. $revealjs_transcript ?> <a href="javascript:Reveal.toggleOverview();" title="<?php get_string('toggleoverview','revealjs'); ?>"><?php get_string('overview','revealjs'); ?></a></div>
    
        <div class="reveal">
            <!-- Any section element inside of this container is displayed as a slide -->
            <div class="slides">
                <?php echo $revealjs->presentation; ?>
            </div>
        </div>
        
        <script src="lib/js/head.min.js"></script>
        <script src="js/reveal.js"></script>
        <script src="js/cookies.js"></script>
        <script>
            // Full list of configuration options available at:
            // https://github.com/hakimel/reveal.js#configuration
            Reveal.initialize({
                margin: <?php echo $revealjs->margin; ?>,
                minScale: <?php echo $revealjs->minscale; ?>,
                maxScale: <?php echo $revealjs->maxscale; ?>,
                controls: <?php echo $revealjs->controls; ?>,
                progress: <?php echo $revealjs->progress; ?>,
                slideNumber: <?php echo $revealjs->slidenumber; ?>,
                history: <?php echo $revealjs->history; ?>,
                keyboard: <?php echo $revealjs->keyboard; ?>,
                overview: <?php echo $revealjs->overview; ?>,
                center: <?php echo $revealjs->center; ?>,
                touch: <?php echo $revealjs->touch; ?>,
                loop: <?php echo $revealjs->looped; ?>,
                rtl: <?php echo $revealjs->rtl; ?>,
                fragments: <?php echo $revealjs->fragments; ?>,
                embedded: <?php echo $revealjs->embedded; ?>,
                help: <?php echo $revealjs->help; ?>,
                autoSlide: <?php echo $revealjs->autoslide; ?>,
                autoSlideStoppable: <?php echo $revealjs->autoslidestoppable; ?>,
                mouseWheel: <?php echo $revealjs->mousewheel; ?>,
                hideAddressBar: <?php echo $revealjs->hideaddressbar; ?>,
                previewLinks: <?php echo $revealjs->previewlinks; ?>,
                transition: '<?php echo $revealjs->transition; ?>', // none/fade/slide/convex/concave/zoom
                transitionSpeed: '<?php echo $revealjs->transition; ?>', // default/fast/slow
                backgroundTransition: '<?php echo $revealjs->backgroundtransition; ?>', // none/fade/slide/convex/concave/zoom
                viewDistance: <?php echo $revealjs->viewdistance; ?>,
                parallaxBackgroundImage: '<?php echo $revealjs->parallaxbackgroundimage; ?>', // URL to img or HTML file
                parallaxBackgroundSize: '<?php echo $revealjs->parallaxbackgroundimage; ?>',
                parallaxBackgroundHorizontal: <?php echo $revealjs->parallaxbackgroundhorizontal; ?>,
                parallaxBackgroundVertical: <?php echo $revealjs->parallaxbackgroundvertical; ?>,
                //
                audioPrefix: 'audio/',
                audioSuffix: '.mp3',
                audioDefaultDuration: <?php echo $revealjs->audioslideshowtime; ?>,
                audioPlayerOpacity: 0.2,
                
                menu: {
                    // Documentation and source code is at: https://github.com/denehyg/reveal.js-menu
                    side: 'left', // 'left' or 'right'
                    numbers: false, // Numbered list instead of bullet list,  true or false 
                    hideMissingTitles: false, // Hide slides without titles
                    markers: true, // Mark current position on slideshow menu
                    custom: false, // Add custom items to menu
                    themes: false, // Don't allow switching themes
                    transitions: false, // Don't allow switching transitions
                    openButton: true,
                    openSlideNumber: true,
                    keyboard: <?php echo $revealjs->keyboard; ?> // Allow keyboard navigation
                },

            // Optional reveal.js plugins
            dependencies: [
                // Cross-browser shim that fully implements classList - https://github.com/eligrey/classList.js/
                { src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
                // Accessibility https://github.com/marcysutton/reveal-a11y
                { src: 'plugin/accessibility/helper.js', async: true, condition: function() { return !!document.body.classList; } },
                // Interpret Markdown in <section> elements
                { src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
                { src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
                // Syntax highlight for <code> elements
                { src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
                // Zoom in and out with Alt+click
                { src: 'plugin/zoom-js/zoom.js', async: true },
                // menu
                <?php echo $revealjs_menu; ?>
                // Speaker notes
                { src: 'plugin/notes/notes.js', async: true },
                // Remote control your reveal.js presentation using a touch device
                <?php echo $revealjs_remotes; ?>
                // audio-slideshow
                <?php echo $revealjs_audioslideshow; ?>
                // chart
                <?php echo $revealjs_charts; ?>
                // math (MathJax)
                { src: 'plugin/math/math.js', async: true },
                ],
            });
            // Save slide show position on each slide change
            Reveal.addEventListener( 'slidechanged', function() {
                docCookies.setItem('<?php echo $cm->id ?>', document.URL, 31536e3); // Save cookies for 1 year
            });
            // If a position saved, go to it
            if(docCookies.hasItem('<?php echo $cm->id ?>'))
            {
                window.location.replace(docCookies.getItem('<?php echo $cm->id ?>'));
            }
        </script>
    </body>
</html>
