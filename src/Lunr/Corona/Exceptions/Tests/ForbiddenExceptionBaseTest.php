<?php

/**
 * This file contains the ForbiddenExceptionBaseTest class.
 *
 * @package   Lunr\Corona\Exceptions
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018-2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions\Tests;

use Lunr\Corona\Exceptions\Tests\Helpers\HttpExceptionTest;

/**
 * This class contains tests for the ForbiddenException class.
 *
 * @covers Lunr\Corona\Exceptions\ForbiddenException
 */
class ForbiddenExceptionBaseTest extends HttpExceptionTest
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('code', 403);
    }

    /**
     * Test that the error code was set correctly.
     */
    public function testApplicationErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('app_code', $this->code);
    }

    /**
     * Test that the input data key was set correctly.
     */
    public function testInputDataKeyIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('key'));
    }

    /**
     * Test that the input data value was set correctly.
     */
    public function testInputDataValueIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('value'));
    }

    /**
     * Test that the error message was passed correctly.
     */
    public function testErrorMessagePassedCorrectly(): void
    {
        $this->expectExceptionMessage($this->message);

        throw $this->class;
    }

}

?>
