<?php

/**
 * This file contains the RequestMagicGetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers     Lunr\Corona\Request
 */
class RequestMagicGetTest extends RequestTest
{

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @dataProvider requestValueProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetMethod($key, $value)
    {
        $this->assertEquals($value, $this->class->$key);
    }

    /**
     * Check that the magic get function correctly returns mocked values if present.
     *
     * @param String $key key for a request value
     *
     * @dataProvider requestValueProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetWithMockedValue($key)
    {
        $this->set_reflection_property_value('mock', [ $key => 'mock' ]);

        $this->assertEquals('mock', $this->class->$key);
    }

    /**
     * Check that the magic get function returns NULL for invalid mock values.
     */
    public function testMagicGetWithInvalidMockValue()
    {
        $this->set_reflection_property_value('mock', [ 'invalid' => 'mock' ]);

        $this->assertNull($this->class->invalid);
    }

    /**
     * Test that __get() returns NULL for unhandled keys.
     *
     * @param String $key key for __get()
     *
     * @dataProvider unhandledMagicGetKeysProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetIsNullForUnhandledKeys($key)
    {
        $this->assertNull($this->class->$key);
    }

}

?>
