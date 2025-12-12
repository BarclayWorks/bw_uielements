<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Uielements
 *
 * @copyright   (C) 2025 Barclay.Works Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

namespace Bw\Plugin\Fields\Uielements\Extension;

use Joomla\CMS\Form\Form;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Component\Fields\Administrator\Plugin\FieldsPlugin;

defined('_JEXEC') or die;

/**
 * UI Elements Plugin
 *
 * Provides non-editable UI field types for organizing custom fields:
 * - hr: Horizontal rule separator
 * - heading: Section heading
 * - infotext: Informational text block
 * - spacer: Vertical spacing
 * - sectiondivider: Horizontal line with centered text
 */
final class Uielements extends FieldsPlugin
{
    /**
     * The plugin should not render a label for these fields in the form
     *
     * @return  boolean
     */
    public function onCustomFieldsBeforePrepareField($field)
    {
        // Skip if field is not an object
        if (!is_object($field)) {
            return;
        }

        // Skip if not our field type
        if (!$this->isTypeSupported($field->type)) {
            return;
        }

        // Set render options to prevent standard field wrapper
        $field->renderLayout = 'plugins.fields.uielements.field.render';
    }

    /**
     * Transforms the field into a DOM XML element and appends it as a child on the given parent.
     *
     * Uses our custom 'uielement' field type which has renderField() overridden
     * to output clean HTML without Joomla's standard field wrapper.
     *
     * @param   \stdClass      $field   The field.
     * @param   \DOMElement    $parent  The field node parent.
     * @param   Form           $form    The form.
     *
     * @return  \DOMElement|null
     */
    public function onCustomFieldsPrepareDom($field, \DOMElement $parent, Form $form)
    {
        // Check if this field type is one we handle
        if (!$this->isTypeSupported($field->type)) {
            return null;
        }

        // Create the form field node using our custom field type
        $node = $parent->appendChild(new \DOMElement('field'));
        $node->setAttribute('name', $field->name);
        $node->setAttribute('type', 'uielement');
        $node->setAttribute('label', $field->label);
        $node->setAttribute('description', $field->description);

        // Pass all field parameters as attributes so UielementField can access them
        $params = $field->fieldparams;
        $node->setAttribute('element_type', $params->get('element_type', 'hr'));
        $node->setAttribute('linestyle', $params->get('linestyle', 'solid'));
        $node->setAttribute('linecolor', $params->get('linecolor', '#dee2e6'));
        $node->setAttribute('lineweight', $params->get('lineweight', '1'));
        $node->setAttribute('margintop', $params->get('margintop', '1'));
        $node->setAttribute('marginbottom', $params->get('marginbottom', '1'));
        $node->setAttribute('headinglevel', $params->get('headinglevel', 'h3'));
        $node->setAttribute('headingclass', $params->get('headingclass', ''));
        $node->setAttribute('headingstyle', $params->get('headingstyle', ''));
        $node->setAttribute('alertstyle', $params->get('alertstyle', 'info'));
        $node->setAttribute('showicon', $params->get('showicon', '1'));
        $node->setAttribute('dismissible', $params->get('dismissible', '0'));
        $node->setAttribute('height', $params->get('height', '1'));
        $node->setAttribute('textposition', $params->get('textposition', 'center'));
        $node->setAttribute('textalign', $params->get('textalign', 'center'));

        return $node;
    }
}
