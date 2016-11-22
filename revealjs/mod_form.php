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
 * Page configuration form
 *
 * @package    mod
 * @subpackage revealjs
 * @copyright  2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/revealjs/locallib.php');
require_once($CFG->libdir.'/filelib.php');

class mod_revealjs_mod_form extends moodleform_mod {
    function definition() {
        global $CFG, $DB;

        $mform = $this->_form;

        $config = get_config('revealjs');

        //-------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), array('size'=>'48'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        //$this->add_intro_editor();
        $this->standard_intro_elements();
        //$config->requiremodintro;

        //-------------------------------------------------------
        $mform->addElement('header', 'contentsection', get_string('contentheader', 'revealjs'));
        //$mform->addElement('editor', 'presentation', get_string('content', 'revealjs'), null, revealjs_get_editor_options($this->context));
        
        // HTML presentation slides file retrieved from moodledata/repository/revealjs/
        $mform->addElement('select', 'presentation', get_string('presentation', 'revealjs'), revealjs_get_presentations(), '');
        $mform->setDefault('presentation', '');
        $mform->setType('presentation', PARAM_TEXT);
        $mform->addHelpButton('presentation', 'presentation', 'revealjs');
        $mform->addRule('presentation', get_string('required'), 'required', null, 'client');
        
        //theme revealjs_get_themes()
        $mform->addElement('select', 'theme', get_string('theme', 'revealjs'), revealjs_get_themes(), '');
        $mform->setDefault('theme', 'black.css');
        $mform->setType('theme', PARAM_TEXT);
        $mform->addHelpButton('theme', 'theme', 'revealjs');
        
        //transition revealjs_get_transitions()
        $mform->addElement('select', 'transition', get_string('transition', 'revealjs'), revealjs_get_transitions(), '');
        $mform->setDefault('transition', 'slide');
        $mform->setType('transition', PARAM_TEXT);
        $mform->addHelpButton('transition', 'transition', 'revealjs');
        
        //transitionspeed revealjs_get_transitionspeeds()
        $mform->addElement('select', 'transitionspeed', get_string('transitionspeed', 'revealjs'), revealjs_get_transitionspeeds(), '');
        $mform->setDefault('transitionspeed', 'default');
        $mform->setType('transitionspeed', PARAM_TEXT);
        
        //backgroundtransition revealjs_get_backgroundtransitions()
        $mform->addElement('select', 'backgroundtransition', get_string('backgroundtransition', 'revealjs'), revealjs_get_backgroundtransitions(), '');
        $mform->setDefault('backgroundtransition', 'none');
        $mform->setType('backgroundtransition', PARAM_TEXT);
        $mform->addHelpButton('backgroundtransition', 'backgroundtransition', 'revealjs');
        
        //margin
        $mform->addElement('text', 'margin', get_string('margin', 'revealjs'), array('size'=>5));
        $mform->addRule('margin', null, 'required', null, 'client');
        $mform->setType('margin', PARAM_TEXT);
        $mform->setDefault('margin', '0.05');
        $mform->addHelpButton('margin', 'margin', 'revealjs');
        
        //minscale
        $mform->addElement('text', 'minscale', get_string('minscale', 'revealjs'), array('size'=>5));
        $mform->addRule('minscale', null, 'required', null, 'client');
        $mform->setType('minscale', PARAM_TEXT);
        $mform->setDefault('minscale', '0.2');
        $mform->addHelpButton('minscale', 'minscale', 'revealjs');
        
        //maxscale
        $mform->addElement('text', 'maxscale', get_string('maxscale', 'revealjs'), array('size'=>5));
        $mform->addRule('maxscale', null, 'required', null, 'client');
        $mform->setType('maxscale', PARAM_TEXT);
        $mform->setDefault('maxscale', '1.0');
        $mform->addHelpButton('maxscale', 'maxscale', 'revealjs');
        
        $revealjs_true_false = array('true'=>'true','false'=>'false');
        
        //controls
        $mform->addElement('select', 'controls', get_string('controls', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('controls', 'true');
        $mform->addHelpButton('controls', 'controls', 'revealjs');
        
        //progress
        $mform->addElement('select', 'progress', get_string('progress', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('progress', 'true');
        $mform->addHelpButton('progress', 'progress', 'revealjs');
        
        //slidenumber
        $mform->addElement('select', 'slidenumber', get_string('slidenumber', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('slidenumber', 'true');
        $mform->addHelpButton('slidenumber', 'slidenumber', 'revealjs');
        
        //history
        $mform->addElement('select', 'history', get_string('history', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('history', 'true');
        $mform->addHelpButton('history', 'history', 'revealjs');
        
        //keyboard
        $mform->addElement('select', 'keyboard', get_string('keyboard', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('keyboard', 'true');
        $mform->addHelpButton('keyboard', 'keyboard', 'revealjs');
        
        //overview
        $mform->addElement('select', 'overview', get_string('overview', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('overview', 'true');
        $mform->addHelpButton('overview', 'overview', 'revealjs');
        
        //center
        $mform->addElement('select', 'center', get_string('center', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('center', 'true');
        $mform->addHelpButton('center', 'center', 'revealjs');
        
        //touch
        $mform->addElement('select', 'touch', get_string('touch', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('touch', 'true');
        $mform->addHelpButton('touch', 'touch', 'revealjs');
        
        //looped
        $mform->addElement('select', 'looped', get_string('looped', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('looped', 'true');
        
        //rtl
        $mform->addElement('select', 'rtl', get_string('rtl', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('rtl', 'false');
        $mform->addHelpButton('rtl', 'rtl', 'revealjs');
        
        //fragments
        $mform->addElement('select', 'fragments', get_string('fragments', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('fragments', 'true');
        $mform->addHelpButton('fragments', 'fragments', 'revealjs');
        
        //embedded
        $mform->addElement('select', 'embedded', get_string('embedded', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('embedded', 'false');
        $mform->addHelpButton('embedded', 'embedded', 'revealjs');
        
        //help
        $mform->addElement('select', 'help', get_string('help', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('help', 'true');
        $mform->addHelpButton('help', 'help', 'revealjs');
        
        //autoslide
        $mform->addElement('text', 'autoslide', get_string('autoslide', 'revealjs'), array('size'=>5));
        $mform->addRule('autoslide', null, 'required', null, 'client');
        $mform->setType('autoslide', PARAM_TEXT);
        $mform->setDefault('autoslide', '0');
        $mform->addHelpButton('autoslide', 'autoslide', 'revealjs');
        
        //autoslidestoppable
        $mform->addElement('select', 'autoslidestoppable', get_string('autoslidestoppable', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('autoslidestoppable', 'true');
        $mform->addHelpButton('autoslidestoppable', 'autoslidestoppable', 'revealjs');
        
        //mousewheel
        $mform->addElement('select', 'mousewheel', get_string('mousewheel', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('mousewheel', 'true');
        $mform->addHelpButton('mousewheel', 'mousewheel', 'revealjs');
        
        //remotes
        $mform->addElement('select', 'remotes', get_string('remotes', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('remotes', 'false');
        $mform->addHelpButton('remotes', 'remotes', 'revealjs');
        
        //audioslideshow
        $mform->addElement('select', 'audioslideshow', get_string('audioslideshow', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('audioslideshow', 'false');
        $mform->addHelpButton('audioslideshow', 'audioslideshow', 'revealjs');
        
        //audioslideshowtime
        $mform->addElement('text', 'audioslideshowtime', get_string('audioslideshowtime', 'revealjs'), array('size'=>5));
        $mform->addRule('audioslideshowtime', null, 'required', null, 'client');
        $mform->setType('audioslideshowtime', PARAM_TEXT);
        $mform->setDefault('audioslideshowtime', '5');
        $mform->addHelpButton('audioslideshowtime', 'audioslideshowtime', 'revealjs');
        
        //hideaddressbar
        $mform->addElement('select', 'hideaddressbar', get_string('hideaddressbar', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('hideaddressbar', 'true');
        $mform->addHelpButton('hideaddressbar', 'hideaddressbar', 'revealjs');
        
        //showmenu
        $mform->addElement('select', 'showmenu', get_string('showmenu', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('showmenu', 'false');
        $mform->addHelpButton('showmenu', 'showmenu', 'revealjs');
        
        //showcharts
        $mform->addElement('select', 'showcharts', get_string('showcharts', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('showcharts', 'false');
        $mform->addHelpButton('showcharts', 'showcharts', 'revealjs');
        
        //previewlinks
        $mform->addElement('select', 'previewlinks', get_string('previewlinks', 'revealjs'), $revealjs_true_false);
        $mform->setDefault('previewlinks', 'false');
        $mform->addHelpButton('previewlinks', 'previewlinks', 'revealjs');
        
        //viewdistance
        $mform->addElement('text', 'viewdistance', get_string('viewdistance', 'revealjs'), array('size'=>5));
        $mform->addRule('viewdistance', null, 'required', null, 'client');
        $mform->setType('viewdistance', PARAM_TEXT);
        $mform->setDefault('viewdistance', '3');
        $mform->addHelpButton('viewdistance', 'viewdistance', 'revealjs');
        
        //parallaxbackground
        $mform->addElement('header', 'contentsection', get_string('parallaxbackground', 'revealjs'));
        //parallaxbackgroundimage
        $mform->addElement('text', 'parallaxbackgroundimage', get_string('parallaxbackgroundimage', 'revealjs'), array('size'=>80));
        $mform->setType('parallaxbackgroundimage', PARAM_TEXT);
        $mform->addHelpButton('parallaxbackgroundimage', 'parallaxbackgroundimage', 'revealjs');
        
        //parallaxbackgroundsize
        $mform->addElement('text', 'parallaxbackgroundsize', get_string('parallaxbackgroundsize', 'revealjs'), array('size'=>20));
        $mform->setType('parallaxbackgroundsize', PARAM_TEXT);
        $mform->setDefault('parallaxbackgroundsize', '1280px 700px');
        $mform->addHelpButton('parallaxbackgroundsize', 'parallaxbackgroundsize', 'revealjs');
        
        //parallaxbackgroundhorizontal
        $mform->addElement('text', 'parallaxbackgroundhorizontal', get_string('parallaxbackgroundhorizontal', 'revealjs'), array('size'=>20));
        $mform->setType('parallaxbackgroundhorizontal', PARAM_TEXT);
        $mform->setDefault('parallaxbackgroundhorizontal', '0');
        $mform->addHelpButton('parallaxbackgroundhorizontal', 'parallaxbackgroundhorizontal', 'revealjs');
        
        //parallaxbackgroundvertical
        $mform->addElement('text', 'parallaxbackgroundvertical', get_string('parallaxbackgroundvertical', 'revealjs'), array('size'=>20));
        $mform->setType('parallaxbackgroundvertical', PARAM_TEXT);
        $mform->setDefault('parallaxbackgroundvertical', '0');
        $mform->addHelpButton('parallaxbackgroundvertical', 'parallaxbackgroundvertical', 'revealjs');
        
        //-------------------------------------------------------
        $mform->addElement('header', 'appearance', get_string('appearance','revealjs'));

        if ($this->current->instance) {
            $options = resourcelib_get_displayoptions(explode(',', $config->displayoptions), $this->current->display);
        } else {
            $options = resourcelib_get_displayoptions(explode(',', $config->displayoptions));
        }
        if (count($options) == 1) {
            $mform->addElement('hidden', 'display');
            $mform->setType('display', PARAM_INT);
            reset($options);
            $mform->setDefault('display', key($options));
        } else {
            $mform->addElement('select', 'display', get_string('displayselect', 'revealjs'), $options);
            $mform->setDefault('display', $config->display);
        }

        if (array_key_exists(RESOURCELIB_DISPLAY_POPUP, $options)) {
            $mform->addElement('text', 'popupwidth', get_string('popupwidth', 'revealjs'), array('size'=>3));
            if (count($options) > 1) {
                $mform->disabledIf('popupwidth', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupwidth', PARAM_INT);
            $mform->setDefault('popupwidth', $config->popupwidth);

            $mform->addElement('text', 'popupheight', get_string('popupheight', 'revealjs'), array('size'=>3));
            if (count($options) > 1) {
                $mform->disabledIf('popupheight', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupheight', PARAM_INT);
            $mform->setDefault('popupheight', $config->popupheight);
        }

        $mform->addElement('advcheckbox', 'printheading', get_string('printheading', 'revealjs'));
        $mform->setDefault('printheading', $config->printheading);
        $mform->addElement('advcheckbox', 'printintro', get_string('printintro', 'revealjs'));
        $mform->setDefault('printintro', $config->printintro);

        // add legacy files flag only if used
        if (isset($this->current->legacyfiles) and $this->current->legacyfiles != RESOURCELIB_LEGACYFILES_NO) {
            $options = array(RESOURCELIB_LEGACYFILES_DONE   => get_string('legacyfilesdone', 'revealjs'),
                             RESOURCELIB_LEGACYFILES_ACTIVE => get_string('legacyfilesactive', 'revealjs'));
            $mform->addElement('select', 'legacyfiles', get_string('legacyfiles', 'revealjs'), $options);
            $mform->setAdvanced('legacyfiles', 1);
        }

        //-------------------------------------------------------
        $this->standard_coursemodule_elements();

        //-------------------------------------------------------
        $this->add_action_buttons();

        //-------------------------------------------------------
        $mform->addElement('hidden', 'revision');
        $mform->setType('revision', PARAM_INT);
        $mform->setDefault('revision', 1);
    }

    /*function data_preprocessing(&$default_values) {
        if ($this->current->instance) {
            $draftitemid = file_get_submitted_draft_itemid('revealjs');
            $default_values['revealjs']['format'] = $default_values['contentformat'];
            $default_values['revealjs']['text']   = file_prepare_draft_area($draftitemid, $this->context->id, 'mod_revealjs', 'content', 0, revealjs_get_editor_options($this->context), $default_values['content']);
            $default_values['revealjs']['itemid'] = $draftitemid;
        }
        if (!empty($default_values['displayoptions'])) {
            $displayoptions = unserialize($default_values['displayoptions']);
            if (isset($displayoptions['printintro'])) {
                $default_values['printintro'] = $displayoptions['printintro'];
            }
            if (isset($displayoptions['printheading'])) {
                $default_values['printheading'] = $displayoptions['printheading'];
            }
            if (!empty($displayoptions['popupwidth'])) {
                $default_values['popupwidth'] = $displayoptions['popupwidth'];
            }
            if (!empty($displayoptions['popupheight'])) {
                $default_values['popupheight'] = $displayoptions['popupheight'];
            }
        }
    }*/
}

