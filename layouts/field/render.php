<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Uielements
 *
 * @copyright   (C) 2025 Barclay.Works Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   stdClass   $field        The field object
 * @var   string     $fieldId      The field ID
 * @var   string     $fieldName    The field name
 * @var   string     $value        The field value
 */

// Get field parameters
$fieldParams = $field->fieldparams;
$elementType = $fieldParams->get('element_type', 'hr');

// Render the UI element directly without field wrapper
?>
<div class="control-group field-uielement-wrapper" style="grid-column: 1 / -1; width: 100%;">
    <?php
    // Render based on element type
    switch ($elementType) {
        case 'hr':
            // HR Separator
            $lineStyle = $fieldParams->get('linestyle', 'solid');
            $lineColor = $fieldParams->get('linecolor', '#dee2e6');
            $lineWeight = $fieldParams->get('lineweight', '1');
            $marginTop = $fieldParams->get('margintop', '1');
            $marginBottom = $fieldParams->get('marginbottom', '1');

            $styles = [
                'border: none',
                'border-top: ' . $lineWeight . 'px ' . $lineStyle . ' ' . $lineColor,
                'margin: ' . $marginTop . 'rem 0 ' . $marginBottom . 'rem 0',
            ];
            ?>
            <hr class="field-uielement-hr" style="<?php echo implode('; ', $styles); ?>" />
            <?php
            break;

        case 'heading':
            // Heading
            $headingLevel = $fieldParams->get('headinglevel', 'h3');
            $headingClass = $fieldParams->get('headingclass', '');
            $headingStyle = $fieldParams->get('headingstyle', '');

            if (!preg_match('/^h[1-6]$/', $headingLevel)) {
                $headingLevel = 'h3';
            }

            $label = $field->label;
            $description = $field->description;
            ?>
            <<?php echo $headingLevel; ?> class="field-uielement-heading <?php echo htmlspecialchars($headingClass); ?>" <?php echo $headingStyle ? 'style="' . htmlspecialchars($headingStyle) . '"' : ''; ?>>
                <?php echo htmlspecialchars(Text::_($label)); ?>
            </<?php echo $headingLevel; ?>>
            <?php if ($description): ?>
                <p class="field-uielement-description text-muted small">
                    <?php echo htmlspecialchars(Text::_($description)); ?>
                </p>
            <?php endif;
            break;

        case 'infotext':
            // Info Text
            $alertStyle = $fieldParams->get('alertstyle', 'info');
            $showIcon = $fieldParams->get('showicon', '1');
            $dismissible = $fieldParams->get('dismissible', '0');

            $heading = $field->label;
            $text = $field->description;

            $styleMap = [
                'primary'   => ['class' => 'alert-primary', 'icon' => 'info-circle'],
                'secondary' => ['class' => 'alert-secondary', 'icon' => 'info-circle'],
                'success'   => ['class' => 'alert-success', 'icon' => 'check-circle'],
                'danger'    => ['class' => 'alert-danger', 'icon' => 'exclamation-triangle'],
                'warning'   => ['class' => 'alert-warning', 'icon' => 'exclamation-triangle'],
                'info'      => ['class' => 'alert-info', 'icon' => 'info-circle'],
                'light'     => ['class' => 'alert-light', 'icon' => 'info-circle'],
                'dark'      => ['class' => 'alert-dark', 'icon' => 'info-circle'],
            ];

            $alertClass = $styleMap[$alertStyle]['class'] ?? 'alert-info';
            $iconClass = $styleMap[$alertStyle]['icon'] ?? 'info-circle';

            $classes = ['alert', $alertClass, 'field-uielement-infotext'];

            if ($dismissible === '1') {
                $classes[] = 'alert-dismissible';
                $classes[] = 'fade';
                $classes[] = 'show';
            }
            ?>
            <div class="<?php echo implode(' ', $classes); ?>" role="alert">
                <?php if ($dismissible === '1'): ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php endif; ?>

                <div class="d-flex align-items-start">
                    <?php if ($showIcon === '1'): ?>
                        <span class="icon-<?php echo $iconClass; ?> me-2 flex-shrink-0" aria-hidden="true"></span>
                    <?php endif; ?>

                    <div class="flex-grow-1">
                        <?php if ($heading): ?>
                            <h4 class="alert-heading mb-1"><?php echo htmlspecialchars(Text::_($heading)); ?></h4>
                        <?php endif; ?>

                        <?php if ($text): ?>
                            <div><?php echo nl2br(htmlspecialchars(Text::_($text))); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
            break;

        case 'spacer':
            // Spacer
            $height = $fieldParams->get('height', '1');
            ?>
            <div class="field-uielement-spacer" style="height: <?php echo htmlspecialchars($height); ?>rem;"></div>
            <?php
            break;

        case 'sectiondivider':
            // Section Divider
            $lineStyle = $fieldParams->get('linestyle', 'solid');
            $lineColor = $fieldParams->get('linecolor', '#dee2e6');
            $lineWeight = $fieldParams->get('lineweight', '1');
            $textPosition = $fieldParams->get('textposition', 'center');
            $textAlign = $fieldParams->get('textalign', 'center');
            $marginTop = $fieldParams->get('margintop', '1');
            $marginBottom = $fieldParams->get('marginbottom', '1');

            $label = $field->label;

            if (empty($label)) {
                $styles = [
                    'border: none',
                    'border-top: ' . $lineWeight . 'px ' . $lineStyle . ' ' . $lineColor,
                    'margin: ' . $marginTop . 'rem 0 ' . $marginBottom . 'rem 0',
                ];
                ?>
                <hr class="field-uielement-sectiondivider" style="<?php echo implode('; ', $styles); ?>" />
                <?php
            } elseif ($textPosition === 'above') {
                ?>
                <div class="field-uielement-sectiondivider" style="margin: <?php echo $marginTop; ?>rem 0 <?php echo $marginBottom; ?>rem 0;">
                    <div class="mb-2 fw-semibold" style="text-align: <?php echo $textAlign; ?>;">
                        <?php echo htmlspecialchars(Text::_($label)); ?>
                    </div>
                    <hr style="border: none; border-top: <?php echo $lineWeight; ?>px <?php echo $lineStyle; ?> <?php echo $lineColor; ?>; margin: 0;" />
                </div>
                <?php
            } else {
                $alignMap = [
                    'left'   => 'flex-start',
                    'center' => 'center',
                    'right'  => 'flex-end',
                ];

                $justifyContent = $alignMap[$textAlign] ?? 'center';
                ?>
                <div class="field-uielement-sectiondivider" style="display: flex; align-items: center; margin: <?php echo $marginTop; ?>rem 0 <?php echo $marginBottom; ?>rem 0; justify-content: <?php echo $justifyContent; ?>;">
                    <?php if ($textAlign === 'center' || $textAlign === 'right'): ?>
                        <hr style="flex: 1; border: none; border-top: <?php echo $lineWeight; ?>px <?php echo $lineStyle; ?> <?php echo $lineColor; ?>; margin: 0;" />
                    <?php endif; ?>

                    <span class="px-3 fw-semibold" style="white-space: nowrap;">
                        <?php echo htmlspecialchars(Text::_($label)); ?>
                    </span>

                    <?php if ($textAlign === 'center' || $textAlign === 'left'): ?>
                        <hr style="flex: 1; border: none; border-top: <?php echo $lineWeight; ?>px <?php echo $lineStyle; ?> <?php echo $lineColor; ?>; margin: 0;" />
                    <?php endif; ?>
                </div>
                <?php
            }
            break;
    }
    ?>
</div>
