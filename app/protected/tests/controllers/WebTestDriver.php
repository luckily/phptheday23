<?php

require_once dirname(__FILE__).'/../../vendor/autoload.php';

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 16/2/23
 * Time: 下午11:43
 */
class WebTestDriver extends PHPUnit_Framework_TestCase
{
    /**
     * @var Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected $driver;

    protected $seleniumHost = 'http://ec2-54-179-153-227.ap-southeast-1.compute.amazonaws.com:4444/wd/hub';
//	protected $seleniumHost = 'http://localhost:4444/wd/hub';

    protected $timeout = 15;

    /**
     * @var array a list of fixtures that should be loaded before each test method executes.
     * The array keys are fixture names, and the array values are either AR class names
     * or table names. If table names, they must begin with a colon character (e.g. 'Post'
     * means an AR class, while ':Post' means a table name).
     * Defaults to false, meaning fixtures will not be used at all.
     */
    protected $fixtures = false;

    /**
     * 每次執行測試時，都會執行的method
     */
    protected function setUp()
    {
        /**
         * 可以設定你要使用哪一種瀏覽器
         * android, firefox, internetExplorer, safari ... etc
         */
        $capabilities = DesiredCapabilities::chrome();
        $this->driver = RemoteWebDriver::create($this->seleniumHost, $capabilities);

        /**
         * 最長timeout時間
         */
        $this->driver->manage()->timeouts()->implicitlyWait($this->timeout);

        if(is_array($this->fixtures))
            $this->getFixtureManager()->load($this->fixtures);
    }

    /**
     * 測試結束時會執行的method
     */
    public function tearDown()
    {
        $this->getFixtureManager()->truncateTable('tbl_product');
        sleep(3);

        $this->driver->close();
        sleep(3);
    }

    /**
     * 等待ajax
     * @param unknown $driver
     * @param string $framework
     * @throws Exception
     */
    protected function waitForAjax($driver, $framework='jquery')
    {
        // javascript framework
        switch($framework){
            case 'jquery':
                $code = "return jQuery.active;"; break;
            case 'prototype':
                $code = "return Ajax.activeRequestCount;"; break;
            case 'dojo':
                $code = "return dojo.io.XMLHTTPTransport.inFlight.length;"; break;
            default:
                throw new Exception('Not supported framework');
        }

        do {
            sleep(5);
        } while ($driver->executeScript($code));
    }

    /**
     * PHP magic method.
     * This method is overridden so that named fixture data can be accessed like a normal property.
     * @param string $name the property name
     * @throws Exception if unknown property is used
     * @return mixed the property value
     */
    public function __get($name)
    {
        if(is_array($this->fixtures) && ($rows=$this->getFixtureManager()->getRows($name))!==false)
            return $rows;
        else
            throw new Exception("Unknown property '$name' for class '".get_class($this)."'.");
    }

    /**
     * PHP magic method.
     * This method is overridden so that named fixture ActiveRecord instances can be accessed in terms of a method call.
     * @param string $name method name
     * @param string $params method parameters
     * @return mixed the property value
     */
    public function __call($name,$params)
    {
        if(is_array($this->fixtures) && isset($params[0]) && ($record=$this->getFixtureManager()->getRecord($name,$params[0]))!==false)
            return $record;
        else
            throw new Exception("Unknown method '$name' for class '".get_class($this)."'.");
    }

    /**
     * @return CDbFixtureManager the database fixture manager
     */
    public function getFixtureManager()
    {
        return Yii::app()->getComponent('fixture');
    }

    /**
     * @param string $name the fixture name (the key value in {@link fixtures}).
     * @return array the named fixture data
     */
    public function getFixtureData($name)
    {
        return $this->getFixtureManager()->getRows($name);
    }

    /**
     * @param string $name the fixture name (the key value in {@link fixtures}).
     * @param string $alias the alias of the fixture data row
     * @return CActiveRecord the ActiveRecord instance corresponding to the specified alias in the named fixture.
     * False is returned if there is no such fixture or the record cannot be found.
     */
    public function getFixtureRecord($name,$alias)
    {
        return $this->getFixtureManager()->getRecord($name,$alias);
    }
}