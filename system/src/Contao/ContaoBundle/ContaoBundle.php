<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Contao\ContaoBundle
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Contao\ContaoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ContaoBundle
 *
 * @package Contao\ContaoBundle
 * @author  Andreas Schempp <http://terminal42.ch>
 * @author  Leo Feyer <https://contao.org>
 */
class ContaoBundle extends Bundle
{
    /**
     * Make the container available in the global scope
     */
    public function boot()
    {
        $GLOBALS['container'] = $this->container;
    }

    /**
     * Set some kernel parameters from the Contao configuration
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('kernel.secret', $GLOBALS['TL_CONFIG']['encryptionKey']);

        if ($container->getParameter('kernel.charset') === '') {
            $container->setParameter('kernel.charset', strtoupper($GLOBALS['TL_CONFIG']['characterSet']));
        }

        $container->setParameter('kernel.trusted_proxies', array_map('trim', explode(',', $GLOBALS['TL_CONFIG']['proxyServerIps'])));
    }
}
