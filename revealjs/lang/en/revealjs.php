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
 * Strings for component 'revealjs', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   revealjs
 * @copyright 2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['configdisplayoptions'] = 'Select all options that should be available, existing settings are not modified. Hold CTRL key to select multiple fields.';
$string['content'] = 'Presentation content';
$string['contentheader'] = 'Presentation';
$string['createrevealjs'] = 'Create a new Presentation resource';
$string['displayoptions'] = 'Available display options';
$string['displayselect'] = 'Display';
$string['displayselectexplain'] = 'Select display type.';
$string['legacyfiles'] = 'Migration of old course file';
$string['legacyfilesactive'] = 'Active';
$string['legacyfilesdone'] = 'Finished';
$string['modulename'] = 'Presentation';
$string['modulename_help'] = 'The Presentation module enables a teacher to create a web presentation resource. A presentation can display text, images, sound, video, web links and embedded code, such as Google maps. It is intended as a web friendly alternative to PowerPoint and PDF slide shows.
    
It uses the Reveal.js library (See: https://github.com/hakimel/reveal.js).

Advantages of using the Presentation module rather than the file module include the resource being more accessible (for example to users of mobile devices) and easier to update.

For large amounts of content, it\'s recommended that a book is used rather than a Presentation.

A presentation may be used

* To present a series of slides and subslides with embedded multimedia
* To embed several videos or sound files together with some explanatory text';
$string['modulename_link'] = 'mod/revealjs/view';
$string['modulenameplural'] = 'Presentations';
$string['neverseen'] = 'Never seen';
$string['optionsheader'] = 'Display options';
$string['revealjs-mod-revealjs-x'] = 'Any Presentation module Presentation';
$string['revealjs:addinstance'] = 'Add a new Presentation resource';
$string['revealjs:view'] = 'View presentation content';
$string['pluginadministration'] = 'Presentation module administration';
$string['pluginname'] = 'Presentation';
//
$string['contentdir'] = 'Presentation Directory';
$string['contentdirexplain'] = 'The directory where presentations and media files are stored.';
$string['popupheight'] = 'Pop-up height (in pixels)';
$string['popupheightexplain'] = 'Specifies default height of popup windows.';
$string['popupwidth'] = 'Pop-up width (in pixels)';
$string['popupwidthexplain'] = 'Specifies default width of popup windows.';
$string['printheading'] = 'Display presentation name';
$string['printheadingexplain'] = 'Display presentation name above content?';
$string['printintro'] = 'Display presentation description';
$string['printintroexplain'] = 'Display presentation description above content?';
//
$string['theme'] = 'Theme';
$string['theme_help'] = 'The appearance of the text font, colors, and styling for the content of the slides.';
$string['presentation'] = 'Presentation';
$string['choosefile'] = 'Choose a file...';
$string['presentation_help'] = 'The presentation HTML fragment with the <code>section</code> parts containing the slides.';
$string['margin'] = 'Margin';
$string['margin_help'] = 'Factor of the display size that should remain empty around the content, e.g. 0.1 = 10%';
$string['minscale'] = 'Min Scale';
$string['minscale_help'] = 'The minimum scale a presentation can scale down to, e.g. 0.5 = half size';
$string['maxscale'] = 'Max Scale';
$string['maxscale_help'] = 'The maximum scale a presentation can scale up to, e.g. 1.0 = full size';
$string['controls'] = 'Controls';
$string['controls_help'] = 'Show navigation controls at the bottom right of the screen.';
$string['progress'] = 'Progress Bar';
$string['progress_help'] = 'Shows a thin progress bar at the bottom of the screen.';
$string['slidenumber'] = 'Show slide numbers';
$string['slidenumber_help'] = 'Display the page number of the current slide';
$string['history'] = 'Browser History';
$string['history_help'] = 'Makes the page URLs correspond to individual slides and records them in the user\'s browser history. This allows users to copy and paste links to specific slides within a presentation.';
$string['keyboard'] = 'Keyboard Shortcuts';
$string['keyboard_help'] = 'Enable keyboard shortcuts for navigation:
    
* up, down, left, right cursor keys,
* f = fullscreen,
* s = show notes';
$string['overview'] = 'Overview';
$string['overview_help'] = 'Enable slide overview mode.';
$string['center'] = 'Center';
$string['center_help'] = 'Vertically center the text, images, and media on each slide.';
$string['touch'] = 'Touchscreen';
$string['touch_help'] = 'Enable user input for touchscreens.';
$string['looped'] = 'Loop';
$string['rtl'] = 'RTL';
$string['rtl_help'] = 'Set this to true if your presentation is in a right to left script, e.g. Arabic.';
$string['fragments'] = 'Fragments';
$string['fragments_help'] = 'Turns fragments on and off globally.';
$string['embedded'] = 'Embedded';
$string['embedded_help'] = 'Flags if the presentation is running in an embedded mode, i.e. contained within a limited portion of the screen.';
$string['help'] = 'Enable help';
$string['help_help'] = 'Show a help overlay when the questionmark key is pressed.';
$string['autoslide'] = 'Auto Slide';
$string['autoslide_help'] = 'Automatically move on to the next slide on a timer. In milliseconds, so 5 seconds = 5000. Only one time can be set for all slides.';
$string['autoslidestoppable'] = 'Auto Slide stoppable';
$string['autoslidestoppable_help'] = 'Allow users to stop auto-slide.';
$string['mousewheel'] = 'Mouse Wheel';
$string['mousewheel_help'] = 'Users can use their mouse wheel to navigate forward and back through the presentations.';
$string['remotes'] = 'Enable remote control';
$string['remotes_help'] = 'Users can use their touch device or remote controller to navigate through the presentations.';
$string['audioslideshow'] = 'Enable audio slideshow';
$string['audioslideshow_help'] = 'Enable text-to-speech and audio synchronisation features. See: <a href="http://courses.telematique.eu/reveal.js-plugins/audio-slideshow-demo.html#/" target="_blank">http://courses.telematique.eu/reveal.js-plugins/audio-slideshow-demo.html#/</a> for examples.See: <a href="https://github.com/rajgoel/reveal.js-plugins/tree/master/audio-slideshow" target="_blank">https://github.com/rajgoel/reveal.js-plugins/tree/master/audio-slideshow</a> for docs and source code.';
$string['audioslideshowtime'] = 'Audio slideshow default time';
$string['audioslideshowtime_help'] = 'If there is no audio on a slide or slide fragment, set the default time to pause before advancing.';
$string['hideaddressbar'] = 'Hide address bar';
$string['hideaddressbar_help'] = 'Hide address bar on mobile devices.';
$string['showmenu'] = 'Enable side menu';
$string['showmenu_help'] = 'Automatically generates a slideout side menu from slide titles.';
$string['showcharts'] = 'Enable charts';
$string['showcharts_help'] = 'Generates graphical charts from data provided in slide show files. See: <a href="http://courses.telematique.eu/reveal.js-plugins/chart-demo.html" target="_blank">http://courses.telematique.eu/reveal.js-plugins/chart-demo.html</a> for examples. See: <a href="https://github.com/rajgoel/reveal.js-plugins/tree/master/chart" target="_blank">https://github.com/rajgoel/reveal.js-plugins/tree/master/chart</a> for docs and source code.';
$string['previewlinks'] = 'Preview links';
$string['previewlinks_help'] = 'Opens links in an iframe preview overlay.';
$string['transition'] = 'Transition';
$string['transition_help'] = 'Transition style: Some transitions prevent video and audio playback controls from responding and prevent SVG animations from playing.';
$string['transitionspeed'] = 'Transition speed';
$string['backgroundtransition'] = 'Background transition';
$string['backgroundtransition_help'] = 'Transition style for full page backgrounds';
$string['backgroundimage'] = 'Background image';
$string['backgroundimage_help'] = 'A default background presentation image.';
$string['viewdistance'] = 'Preload slides';
$string['viewdistance_help'] = 'Number of slides to preload images, audio, video, and animations in either side of the current slide.';
$string['parallaxbackground'] = 'Background Image';
$string['parallaxbackgroundimage'] = 'Image';
$string['parallaxbackgroundimage_help'] = 'Background image to use, e.g. https://s3.amazonaws.com/hakim-static/reveal-js/reveal-parallax-1.jpg';
$string['parallaxbackgroundsize'] = 'Size';
$string['parallaxbackgroundsize_help'] = 'Width and height of background image in CSS pixels, width and height, e.g. 2100px 900px Don\'t use % or auto.';
$string['parallaxbackgroundhorizontal'] = 'Horizontal movement';
$string['parallaxbackgroundhorizontal_help'] = 'Amount to move background horizontally on slide change for parallax effect.';
$string['parallaxbackgroundvertical'] = 'Vertical movement';
$string['parallaxbackgroundvertical_help'] = 'Amount to move background vertically on slide change for parallax effect.';
$string['appearance'] = 'Appearance';
// content.php
$string['content_error'] = '404 Error: File not found. Presentation settings and/or path to file not set correctly.';
// settings.php
$string['data_dir'] = 'Files Directory';
$string['data_dir_explain'] = 'Directory were presentations and media files are located.';
$string['data_url'] = 'URL';
$string['data_url_explain'] = 'URL to Files Directory (Proxy)';
$string['data_structure'] = 'Directory Structure';
$string['data_structure_explain'] = 'How the files are organised and where the Presentation module will search for presentations.';
$string['data_dir_exists'] = 'Files Directory is located at: ';
$string['data_dir_moved'] = 'FIRST INSTALL Files Directory has been successfully moved: ';
$string['data_dir_error'] = 'Please check: A possible error occured while attempting to move /moodle/mod/revealjs/revealjs/ directory and all its contents to: ';
// view.php
$string['overview'] = 'Overview';
$string['toggleoverview'] = 'Show/Hide overview of slides';
$string['hidetranscript'] = 'Hide';
$string['toggletranscript'] = 'Transcript';
$string['showhidetranscript'] = 'Show audio transcript if available';
$string['saveandclose'] = 'Save & Close';
$string['saveandclose_title'] = 'Save slideshow position and return to course page';
