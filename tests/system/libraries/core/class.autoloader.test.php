<?php

use Lunr\Libraries\Core\Autoloader;

/**
 * This tests Lunr's Autoloader class
 * @covers Lunr\Libraries\Core\Autoloader
 */
class AutoloaderTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the static function add_include_path()
     * @covers Lunr\Libraries\Core\Autoloader::add_include_path
     */
    public function testAddIncludePath()
    {
        $path_before = get_include_path();
        Autoloader::add_include_path("LunrUnitTestString");
        $path_after = get_include_path();
        $this->assertEquals($path_before . ":LunrUnitTestString", $path_after);
    }

    /**
     * Test the static function register_project_controller()
     * @dataProvider controllerProvider
     * @covers Lunr\Libraries\Core\Autoloader::register_project_controller
     */
    public function testRegisterProjectController($input, $expected)
    {
        $autoloader_reflection = new ReflectionClass("Lunr\Libraries\Core\Autoloader");

        $properties = $autoloader_reflection->getStaticProperties();
        $controllers_base = $properties["controllers"];

        Autoloader::register_project_controller($input);
        $properties = $autoloader_reflection->getStaticProperties();
        $controllers_after = $properties["controllers"];

        $controllers_base[] = $expected;

        $this->assertEquals($controllers_base, $controllers_after);
    }

    /**
     * Test the static function load to autoload classes
     * @dataProvider fileProvider
     * @covers Lunr\Libraries\Core\Autoloader::load
     */
    public function testLoad($file, $filename)
    {
        $basename = str_replace("tests/system/libraries/core", "", dirname(__FILE__));
        $filename = $basename . $filename;

        $this->assertFalse(in_array($filename, get_included_files()));
        Autoloader::load($file);
        $this->assertTrue(in_array($filename, get_included_files()));
    }

    public function controllerProvider()
    {
        return array(array("lunr", "lunr"), array("Lunr", "lunr"));
    }

    public function fileProvider()
    {
        return array(
            array("Lunr\Libraries\Core\M2DateTime", "system/libraries/core/class.m2datetime.inc.php"),
            array("StubView", "application/views/view.stub.inc.php"),
            array("Lunr\Libraries\Core\WebServiceController", "system/libraries/core/class.webservicecontroller.inc.php"),
            array("Lunr\Libraries\Core\WebController", "system/libraries/core/class.webcontroller.inc.php"),
            array("Lunr\Libraries\Core\JsonInterface", "system/libraries/core/interface.json.inc.php"),
            array("Lunr\Models\Core\SessionModel", "system/models/core/model.session.inc.php"),
            array("StubController", "application/controllers/controller.stub.inc.php")
        );
    }

}

?>