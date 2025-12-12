<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Uielements
 *
 * @copyright   (C) 2025 Barclay.Works Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Bw\Plugin\Fields\Uielements\Extension\Uielements;

// Register the custom form field namespace so Joomla can find UielementField
FormHelper::addFieldPrefix('Bw\\Plugin\\Fields\\Uielements\\Field');

return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     */
    public function register(Container $container): void
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $dispatcher = $container->get(DispatcherInterface::class);
                $pluginConfig = PluginHelper::getPlugin('fields', 'bw_uielements');

                $plugin = new Uielements(
                    $dispatcher,
                    (array) $pluginConfig
                );
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
