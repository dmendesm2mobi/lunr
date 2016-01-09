<?php

/**
 * This file contains the ResponseBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Response class.
 *
 * @covers     Lunr\Corona\Response
 */
class ResponseBaseTest extends ResponseTest
{

    /**
     * Test that the data array is empty by default.
     */
    public function testDataEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that there is no error message set by default.
     */
    public function testErrorMessageEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('errmsg'));
    }

    /**
     * Test that there is no error information set by default.
     */
    public function testErrorInfoEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('errinfo'));
    }

    /**
     * Test that the default return code is empty by default.
     */
    public function testReturnCodeIsEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('return_code'));
    }

    /**
     * Test that there is no view set by default.
     */
    public function testViewIsNotSetByDefault()
    {
        $this->assertPropertyEquals('view', '');
    }

}

?>
