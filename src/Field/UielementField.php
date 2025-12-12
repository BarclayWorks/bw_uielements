<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Uielements
 *
 * @copyright   (C) 2025 Barclay.Works Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

namespace Bw\Plugin\Fields\Uielements\Field;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 * UI Element Field
 *
 * Renders various non-editable UI elements in forms based on the element_type parameter.
 * This field does not accept or store any data.
 */
class UielementField extends FormField
{
    /**
     * The form field type.
     *
     * @var    string
     */
    protected $type = 'Uielement';

    /**
     * Layout to render
     *
     * @var    string
     */
    protected $layout = 'plugins.fields.uielements.field.render';

    /**
     * Hide the label
     *
     * @var    boolean
     */
    protected $hiddenLabel = true;

    /**
     * Hide the description
     *
     * @var    boolean
     */
    protected $hiddenDescription = true;

    /**
     * Render the complete field - bypass Joomla's wrapper entirely.
     *
     * @param   array  $options  Options to pass to the layout
     *
     * @return  string  The rendered UI element with no wrapper
     */
    public function renderField($options = [])
    {
        return $this->getInput();
    }

    /**
     * Get an attribute from the element as a string.
     *
     * @param   string  $name     Attribute name
     * @param   string  $default  Default value
     *
     * @return  string
     */
    protected function getParam(string $name, string $default = ''): string
    {
        $value = $this->element[$name] ?? $default;

        return (string) $value;
    }

    /**
     * Method to get the field input markup.
     *
     * @return  string  The UI element markup.
     */
    protected function getInput()
    {
        $elementType = $this->getParam('element_type', 'hr');

        switch ($elementType) {
            case 'hr':
                return $this->renderHr();
            case 'heading':
                return $this->renderHeading();
            case 'infotext':
                return $this->renderInfotext();
            case 'spacer':
                return $this->renderSpacer();
            case 'sectiondivider':
                return $this->renderSectiondivider();
            default:
                return '<hr />';
        }
    }

    /**
     * Method to get the field label markup.
     *
     * @return  string  Empty - no label for UI elements.
     */
    protected function getLabel()
    {
        return '';
    }

    /**
     * Render HR separator
     *
     * @return  string
     */
    protected function renderHr()
    {
        $lineStyle = $this->getParam('linestyle', 'solid');
        $lineColor = $this->getParam('linecolor', '#dee2e6');
        $lineWeight = $this->getParam('lineweight', '1');
        $marginTop = $this->getParam('margintop', '1');
        $marginBottom = $this->getParam('marginbottom', '1');

        $styles = [
            'border: none',
            'border-top: ' . $lineWeight . 'px ' . $lineStyle . ' ' . $lineColor,
            'margin: ' . $marginTop . 'rem 0 ' . $marginBottom . 'rem 0',
        ];

        return '<hr style="' . implode('; ', $styles) . '" />';
    }

    /**
     * Render Heading
     *
     * @return  string
     */
    protected function renderHeading()
    {
        $headingLevel = $this->getParam('headinglevel', 'h3');
        $headingClass = $this->getParam('headingclass', '');
        $headingStyle = $this->getParam('headingstyle', '');

        if (!preg_match('/^h[1-6]$/', $headingLevel)) {
            $headingLevel = 'h3';
        }

        $label = Text::_($this->getParam('label', ''));
        $description = Text::_($this->getParam('description', ''));

        $html = '<' . $headingLevel;

        if ($headingClass) {
            $html .= ' class="' . htmlspecialchars($headingClass) . '"';
        }

        if ($headingStyle) {
            $html .= ' style="' . htmlspecialchars($headingStyle) . '"';
        }

        $html .= '>' . htmlspecialchars($label) . '</' . $headingLevel . '>';

        if ($description) {
            $html .= '<p class="text-muted small">' . htmlspecialchars($description) . '</p>';
        }

        return $html;
    }

    /**
     * Render Info Text
     *
     * @return  string
     */
    protected function renderInfotext()
    {
        $alertStyle = $this->getParam('alertstyle', 'info');
        $heading = Text::_($this->getParam('label', ''));
        $text = Text::_($this->getParam('description', ''));

        $html = '<div class="alert alert-' . htmlspecialchars($alertStyle) . '" role="alert">';

        if ($heading) {
            $html .= '<strong>' . htmlspecialchars($heading) . '</strong>';
            if ($text) {
                $html .= '<br>';
            }
        }

        if ($text) {
            $html .= nl2br(htmlspecialchars($text));
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Render Spacer
     *
     * @return  string
     */
    protected function renderSpacer()
    {
        $height = $this->getParam('height', '1');

        return '<div style="height: ' . htmlspecialchars($height) . 'rem;"></div>';
    }

    /**
     * Render Section Divider
     *
     * @return  string
     */
    protected function renderSectiondivider()
    {
        $lineStyle = $this->getParam('linestyle', 'solid');
        $lineColor = $this->getParam('linecolor', '#dee2e6');
        $lineWeight = $this->getParam('lineweight', '1');
        $textPosition = $this->getParam('textposition', 'center');
        $textAlign = $this->getParam('textalign', 'center');
        $marginTop = $this->getParam('margintop', '1');
        $marginBottom = $this->getParam('marginbottom', '1');
        $label = Text::_($this->getParam('label', ''));

        // No label - just render an HR
        if (empty($label)) {
            return '<hr style="border: none; border-top: ' . $lineWeight . 'px ' . $lineStyle . ' ' . $lineColor . '; margin: ' . $marginTop . 'rem 0 ' . $marginBottom . 'rem 0;" />';
        }

        // Text above the line
        if ($textPosition === 'above') {
            return '<div style="margin: ' . $marginTop . 'rem 0 ' . $marginBottom . 'rem 0;">'
                . '<div style="text-align: ' . $textAlign . '; font-weight: 600; margin-bottom: 0.5rem;">' . htmlspecialchars($label) . '</div>'
                . '<hr style="border: none; border-top: ' . $lineWeight . 'px ' . $lineStyle . ' ' . $lineColor . '; margin: 0;" />'
                . '</div>';
        }

        // Text centred on the line (like a fieldset legend)
        $alignMap = ['left' => 'flex-start', 'center' => 'center', 'right' => 'flex-end'];
        $justify = $alignMap[$textAlign] ?? 'center';

        $html = '<div style="display: flex; align-items: center; margin: ' . $marginTop . 'rem 0 ' . $marginBottom . 'rem 0; justify-content: ' . $justify . ';">';

        if ($textAlign === 'center' || $textAlign === 'right') {
            $html .= '<hr style="flex: 1; border: none; border-top: ' . $lineWeight . 'px ' . $lineStyle . ' ' . $lineColor . '; margin: 0;" />';
        }

        $html .= '<span style="padding: 0 1rem; font-weight: 600; white-space: nowrap;">' . htmlspecialchars($label) . '</span>';

        if ($textAlign === 'center' || $textAlign === 'left') {
            $html .= '<hr style="flex: 1; border: none; border-top: ' . $lineWeight . 'px ' . $lineStyle . ' ' . $lineColor . '; margin: 0;" />';
        }

        $html .= '</div>';

        return $html;
    }
}
