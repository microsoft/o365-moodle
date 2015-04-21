<?php
namespace local_o365\form\element;

global $CFG;
require_once("$CFG->libdir/form/advcheckbox.php");

/**
 * Calendar form element. Provides checkbox to enable/disable calendar and options for sync behavior.
 */
class calendar extends \MoodleQuickForm_advcheckbox {
    /** @var bool Whether the calendar is checked (subscribed) or not. */
	protected $checked = false;

    /** @var string The o365 calendar id. */
	protected $syncwith = null;

    /** @var string Sync behaviour: in/out/both. */
	protected $syncbehav = 'out';

    /**
     * Constructor, accessed through __call constructor workaround.
     *
     * @param string $elementName The name of the element.
     * @param string $elementLabel The label of the element.
     * @param string $text Text that appears after the checkbox.
     * @param array $attributes Array of checkbox attributes.
     * @param array $customdata Array of form custom data.
     */
    public function calendarconstruct($elementName = null, $elementLabel = null, $text = null, $attributes = null, $customdata = []) {
        parent::MoodleQuickForm_advcheckbox($elementName, $elementLabel, $text, $attributes, null);
        $this->customdata = $customdata;
    }

    /**
     * Magic method to run the proper constructor since formslib uses named constructors.
     *
     * @param string $method The method called.
     * @param array $arguments Array of arguments used in call.
     */
	public function __call($method, $arguments) {
		if ($method === 'local_o365\form\element\calendar') {
			$func = [$this, 'calendarconstruct'];
			call_user_func_array($func, $arguments);
		}
	}

    /**
     * Set element value.
     *
     * @param array $value Array of information to set.
     */
 	public function setValue($value) {
 		if (!empty($value['checked'])) {
 			$this->checked = true;
 		}
 		if (!empty($value['syncwith'])) {
 			$this->syncwith = $value['syncwith'];
 		}
		if (!empty($value['syncbehav'])) {
			$this->syncbehav = $value['syncbehav'];
		}
 	}

    /**
     * Export value for the element.
     *
     * @param array &$submitValues Array of all submitted values.
     * @param bool $assoc
     * @return array Exported value.
     */
    public function exportValue(&$submitValues, $assoc = false) {
    	$value = $this->_findValue($submitValues);
    	return $this->_prepareValue($value, $assoc);
    }

    /**
     * Returns HTML for calendar form element.
     *
     * @return string The element HTML.
     */
    public function toHtml() {
    	$checkboxid = $this->getAttribute('id').'_checkbox';
    	$checkboxname = $this->getName().'[checked]';
    	$checkboxchecked = ($this->checked === true) ? 'checked="checked"' : '';
        $checkboxonclick = 'if($(this).is(\':checked\')){$(this).parent().siblings().show();}else{$(this).parent().siblings().hide();}';
    	$html = '<div>';
    	$html .= '<input type="checkbox" name="'.$checkboxname.'" onclick="'.$checkboxonclick.'" id="'.$checkboxid.'" '.$checkboxchecked.'/>';
    	$html .= \html_writer::label($this->_text, $checkboxid);
    	$html .= '</div>';

    	$showcontrols = ($this->checked === true) ? 'display:block;' : 'display:none;';
    	$stylestr = 'margin-left: 2rem;'.$showcontrols;

    	$availableo365calendars = (isset($this->customdata['o365calendars'])) ? $this->customdata['o365calendars'] : [];
    	$availcalid = $this->getAttribute('id').'_syncwith';
    	$availcalname = $this->getName().'[syncwith]';
    	$html .= '<div style="'.$stylestr.'">';
    	$html .= \html_writer::label(get_string('ucp_syncwith_title', 'local_o365'), $availcalid);
		$calselectopts = [];
        foreach ($availableo365calendars as $i => $info) {
            $calselectopts[$info['id']] = $info['name'];
        }
        $html .= \html_writer::select($calselectopts, $availcalname, $this->syncwith, false, ['id' => $availcalid]);
        $html .= '</div>';

        $syncbehavior = [
        	'out' => get_string('ucp_syncdir_out', 'local_o365'),
        ];
        if ($this->customdata['cansyncin'] === true) {
        	$syncbehavior['in'] = get_string('ucp_syncdir_in', 'local_o365');
        	$syncbehavior['both'] = get_string('ucp_syncdir_both', 'local_o365');
        }
        $syncbehavid = $this->getAttribute('id').'_syncbehav';
    	$syncbehavname = $this->getName().'[syncbehav]';
        $html .= '<div style="'.$stylestr.'">';
        $html .= \html_writer::label(get_string('ucp_syncdir_title', 'local_o365'), $syncbehavid);
        $html .= \html_writer::select($syncbehavior, $syncbehavname, $this->syncbehav, false, ['id' => $syncbehavid]);
        $html .= '</div>';

    	return $html;
    }
}
