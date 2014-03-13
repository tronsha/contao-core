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

namespace Contao\ContaoBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class ContaoLoader
 *
 * @package Contao\ContaoBundle\Routing
 * @author  Andreas Schempp <http://terminal42.ch>
 * @author  Leo Feyer <https://contao.org>
 */
class ContaoLoader extends Loader
{
    /**
     * Universal Contao front end router
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     *
     * @return RouteCollection A RouteCollection instance
     */
    public function load($resource, $type = null)
    {
        $pattern = '/{alias}';

        $defaults = array(
            '_controller' => 'ContaoBundle:Frontend:index',
        );

        $requirements = array(
            'alias' => '.*',
        );

        if ($GLOBALS['TL_CONFIG']['urlSuffix'] != '') {
            $pattern .= '.{_format}';
            $requirements['_format'] = substr($GLOBALS['TL_CONFIG']['urlSuffix'], 1);
            $defaults['_format'] = substr($GLOBALS['TL_CONFIG']['urlSuffix'], 1);
        }

        if ($GLOBALS['TL_CONFIG']['addLanguageToUrl']) {
            $pattern = '/{_locale}' . $pattern;
        }

        $routes = new RouteCollection();
        $route  = new Route($pattern, $defaults, $requirements);

        $routes->add('contao_frontend', $route);

        return $routes;
    }

    /**
     * Return true if the class supports the given resource
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     *
     * @return boolean True if the class supports the given resource
     */
    public function supports($resource, $type = null)
    {
        return $type === 'contao_frontend';
    }
}
