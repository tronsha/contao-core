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

namespace Contao\ContaoBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EnvironmentTest
 *
 * @package Contao\ContaoBundle\Tests
 * @author  Leo Feyer <https://contao.org>
 */
class EnvironmentTest extends WebTestCase
{
    protected $request;
    protected static $root;

    /**
     * Set up the test case
     */
    public function setUp()
    {
        $this->request = new Request;

        static::createClient()
            ->getKernel()
            ->getContainer()
            ->get('request_stack')
            ->push($this->request);

        if (static::$root === null) {
            static::$root = str_replace(TL_PATH, '', $_SERVER['PWD']);
        }
    }

    /**
     * Test the mod_php environment
     */
    public function testApache()
    {
        $GLOBALS['PHP_SAPI_TEST'] = 'apache2';

        $_SERVER = array(
            'SERVER_PORT'          => 80,
            'HTTP_HOST'            => 'localhost',
            'HTTP_CONNECTION'      => 'keep-alive',
            'HTTP_ACCEPT'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'HTTP_USER_AGENT'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.149 Safari/537.36',
            'HTTP_ACCEPT_ENCODING' => 'gzip,deflate,sdch',
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.6,en;q=0.4',
            'HTTP_X_FORWARDED_FOR' => '123.456.789.0',
            'SERVER_NAME'          => 'localhost',
            'SERVER_ADDR'          => '127.0.0.1',
            'REMOTE_ADDR'          => '123.456.789.0',
            'DOCUMENT_ROOT'        => static::$root,
            'SCRIPT_FILENAME'      => static::$root . '/core/index.php',
            'SERVER_PROTOCOL'      => 'HTTP/1.1',
            'QUERY_STRING'         => 'do=test',
            'REQUEST_URI'          => '/core/en/academy.html?do=test',
            'SCRIPT_NAME'          => '/core/index.php',
            'PHP_SELF'             => '/core/index.php'
        );

        $this->request->initialize(array(), array(), array(), array(), array(), $_SERVER);

        $this->runTests();
    }

    /**
     * Test the cgi_fcgi environment
     */
    public function testCgiFcgi()
    {
        $GLOBALS['PHP_SAPI_TEST'] = 'cgi-fcgi';

        $_SERVER = array(
            'SERVER_PORT'          => 80,
            'HTTP_HOST'            => 'localhost',
            'HTTP_CONNECTION'      => 'close',
            'HTTP_ACCEPT'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'HTTP_USER_AGENT'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.149 Safari/537.36',
            'HTTP_ACCEPT_ENCODING' => 'gzip,deflate,sdch',
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.6,en;q=0.4',
            'HTTP_X_FORWARDED_FOR' => '123.456.789.0',
            'SERVER_NAME'          => 'localhost',
            'SERVER_ADDR'          => '127.0.0.1',
            'REMOTE_ADDR'          => '123.456.789.0',
            'DOCUMENT_ROOT'        => static::$root,
            'SCRIPT_FILENAME'      => static::$root . '/core/index.php',
            'ORIG_SCRIPT_FILENAME' => static::$root . '/fcgi-bin/php-fcgi-starter',
            'SERVER_PROTOCOL'      => 'HTTP/1.1',
            'QUERY_STRING'         => 'do=test',
            'REQUEST_URI'          => '/core/en/academy.html?do=test',
            'SCRIPT_NAME'          => '/core/index.php',
            'ORIG_SCRIPT_NAME'     => '/fcgi-bin/php-fcgi-starter',
            'PHP_SELF'             => '/core/index.php',
            'GATEWAY_INTERFACE'    => 'CGI/1.1',
            'ORIG_PATH_INFO'       => '/core/index.php',
            'ORIG_PATH_TRANSLATED' => static::$root . '/core/index.php',
            'SCRIPT_URI'           => 'http://localhost/core/en/academy.html',
            'SCRIPT_URL'           => '/core/en/academy.html'
        );

        $this->request->initialize(array(), array(), array(), array(), array(), $_SERVER);

        $this->runTests();
    }

    /**
     * Test the fpm_fcgi environment
     */
    public function testFpmFcgi()
    {
        $GLOBALS['PHP_SAPI_TEST'] = 'fpm-fcgi';

        $_SERVER = array(
            'SERVER_PORT'          => 80,
            'HTTP_HOST'            => 'localhost',
            'HTTP_CONNECTION'      => 'close',
            'HTTP_ACCEPT'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'HTTP_USER_AGENT'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.149 Safari/537.36',
            'HTTP_ACCEPT_ENCODING' => 'gzip,deflate,sdch',
            'HTTP_ACCEPT_LANGUAGE' => 'de-DE,de;q=0.8,en-GB;q=0.6,en;q=0.4',
            'HTTP_X_FORWARDED_FOR' => '123.456.789.0',
            'SERVER_NAME'          => 'localhost',
            'SERVER_ADDR'          => '127.0.0.1',
            'REMOTE_ADDR'          => '123.456.789.0',
            'DOCUMENT_ROOT'        => static::$root,
            'SCRIPT_FILENAME'      => static::$root . '/core/index.php',
            'ORIG_SCRIPT_FILENAME' => '/var/run/localhost.fcgi',
            'SERVER_PROTOCOL'      => 'HTTP/1.1',
            'QUERY_STRING'         => 'do=test',
            'REQUEST_URI'          => '/core/en/academy.html?do=test',
            'SCRIPT_NAME'          => '/core/index.php',
            'ORIG_SCRIPT_NAME'     => '/php.fcgi',
            'PHP_SELF'             => '/core/index.php',
            'GATEWAY_INTERFACE'    => 'CGI/1.1',
            'ORIG_PATH_INFO'       => '/core/index.php',
            'ORIG_PATH_TRANSLATED' => static::$root . '/core/index.php'
        );

        $this->request->initialize(array(), array(), array(), array(), array(), $_SERVER);

        $this->runTests();
    }

    /**
     * Do the actual testing
     */
    protected function runTests()
    {
        $agent = \Environment::get('agent');

        $this->assertEquals('mac', $agent->os);
        $this->assertEquals('mac chrome webkit ch33', $agent->class);
        $this->assertEquals('chrome', $agent->browser);
        $this->assertEquals('ch', $agent->shorty);
        $this->assertEquals(33, $agent->version);
        $this->assertEquals('webkit', $agent->engine);
        $this->assertEquals(array(33, 0, 1750, 149), $agent->versions);
        $this->assertFalse($agent->mobile);

        $this->assertEquals('HTTP/1.1', \Environment::get('serverProtocol'));
        $this->assertEquals(static::$root . '/core/index.php', \Environment::get('scriptFilename'));
        $this->assertEquals('/core/index.php', \Environment::get('scriptName'));
        $this->assertEquals(static::$root, \Environment::get('documentRoot'));
        $this->assertEquals('/core/en/academy.html?do=test', \Environment::get('requestUri'));
        $this->assertEquals(array('de-DE', 'de', 'en-GB', 'en'), \Environment::get('httpAcceptLanguage'));
        $this->assertEquals(array('gzip', 'deflate', 'sdch'), \Environment::get('httpAcceptEncoding'));
        $this->assertEquals('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.149 Safari/537.36', \Environment::get('httpUserAgent'));
        $this->assertEquals('localhost', \Environment::get('httpHost'));
        $this->assertEmpty(\Environment::get('httpXForwardedHost'));

        $this->assertFalse(\Environment::get('ssl'));
        $this->assertEquals('http://localhost', \Environment::get('url'));
        $this->assertEquals('http://localhost/core/en/academy.html?do=test', \Environment::get('uri'));
        $this->assertEquals('123.456.789.0', \Environment::get('ip'));
        $this->assertEquals('127.0.0.1', \Environment::get('server'));
        $this->assertEquals('/core/index.php', \Environment::get('script'));
        $this->assertEquals('/core/en/academy.html?do=test', \Environment::get('request'));
        $this->assertEquals('/core/en/academy.html?do=test', \Environment::get('indexFreeRequest'));
        $this->assertEquals('http://localhost' . TL_PATH . '/', \Environment::get('base'));
        $this->assertFalse(\Environment::get('isAjaxRequest'));
    }
}
