<?php

/**
 * This file contains the ControllerResultTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains test methods for the Controller class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Controller
 */
class ControllerResultTest extends ControllerTest
{

    /**
     * Test calling unimplemented methods without error enums set.
     *
     * @covers Lunr\Core\Controller::__call
     */
    public function testNonImplementedCallWithoutEnumsSet()
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with($this->equalTo('controller/method'), $this->equalTo('Not implemented!'));

        $this->response->expects($this->never())
                       ->method('set_return_code');

        $this->class->unimplemented();
    }

    /**
     * Test calling unimplemented methods with error enums set.
     *
     * @covers Lunr\Core\Controller::__call
     */
    public function testNonImplementedCallWithEnumsSet()
    {
        $ERROR['not_implemented'] = 503;

        $this->set_reflection_property_value('error', $ERROR);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with($this->equalTo('controller/method'), $this->equalTo('Not implemented!'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(503));

        $this->class->unimplemented();
    }

    /**
     * Test setting a result return code with error enums set.
     *
     * @covers Lunr\Core\Controller::set_result
     */
    public function testSetResultReturnCodeWithEnumsSet()
    {
        $ERROR['not_implemented'] = 503;

        $this->set_reflection_property_value('error', $ERROR);

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(503));

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, ['not_implemented']);
    }

    /**
     * Test setting a result return code with error enums not set.
     *
     * @covers Lunr\Core\Controller::set_result
     */
    public function testSetResultReturnCodeWithoutEnumsSet()
    {
        $this->request->expects($this->never())
                      ->method('__get');

        $this->response->expects($this->never())
                       ->method('set_return_code');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, ['not_implemented']);
    }

    /**
     * Test setting a result without error message.
     *
     * @covers Lunr\Core\Controller::set_result
     */
    public function testSetResultErrorMessageNull()
    {
        $this->request->expects($this->never())
                      ->method('__get');

        $this->response->expects($this->never())
                       ->method('set_error_message');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, ['not_implemented']);
    }

    /**
     * Test setting a result error message.
     *
     * @covers Lunr\Core\Controller::set_result
     */
    public function testSetResultErrorMessage()
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with($this->equalTo('controller/method'), $this->equalTo('errmsg'));

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, ['not_implemented', 'errmsg']);
    }

    /**
     * Test setting a result without error information.
     *
     * @covers Lunr\Core\Controller::set_result
     */
    public function testSetResultErrorInfoNull()
    {
        $this->request->expects($this->never())
                      ->method('__get');

        $this->response->expects($this->never())
                       ->method('set_error_info');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, ['not_implemented']);
    }

    /**
     * Test setting result error information.
     *
     * @covers Lunr\Core\Controller::set_result
     */
    public function testSetResultErrorInfoNotNull()
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_error_info')
                       ->with($this->equalTo('controller/method'), $this->equalTo('errinfo'));

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, ['not_implemented', NULL, 'errinfo']);
    }

}

?>
