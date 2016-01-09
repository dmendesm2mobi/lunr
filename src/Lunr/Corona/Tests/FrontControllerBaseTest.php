<?php

/**
 * This file contains the FrontControllerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains base tests for the FrontController class.
 *
 * @covers     Lunr\Corona\FrontController
 */
class FrontControllerBaseTest extends FrontControllerTest
{

    /**
     * Test that the Request class was passed correctly.
     */
    public function testRequestPassedCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the FilesystemAccessObject class was passed correctly.
     */
    public function testFAOPassedCorrectly()
    {
        $this->assertPropertySame('fao', $this->fao);
    }

}

?>
