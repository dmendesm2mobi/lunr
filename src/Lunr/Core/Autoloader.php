<?php

/**
 * This file contains a PHP Class autoloader.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core;

/**
 * PHP Class Autoloader, which on class instantiation tries
 * to load the required source file automatically without the
 * need to explicitely use a "require" or "include" statement.
 */
class Autoloader
{

    /**
     * List of controller prefixes of abstract controllers
     * that extend from the base Controller class.
     * @var array
     */
    private $controllers;

    /**
     * An array of prefixes for namespaces
     *
     * @var
     */
    private $prefixes;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->controllers = [];
        $this->prefixes    = [];
        $this->set_prefix('Lunr', '/');
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->controllers);
    }

    /**
     * Try to load the given class file from the include path.
     *
     * @param String $class The Class name of the Class to load
     *
     * @return void
     */
    public function load($class)
    {
        $file = $this->get_psr0_class_filepath($class);

        if (stream_resolve_include_path($file))
        {
            include_once $file;
            return;
        }

        $file = $this->get_psr4_class_filepath($class);

        if (stream_resolve_include_path($file))
        {
            include_once $file;
            return;
        }

        $file = $this->get_legacy_class_filepath($class);

        if (stream_resolve_include_path($file))
        {
            include_once $file;
        }
    }

    /**
     * Add a path to the include path.
     *
     * @param String $path New path that should be added to the include path
     *
     * @return void
     */
    public function add_include_path($path)
    {
        set_include_path(
            get_include_path() . ':' . $path
        );
    }

    /**
     * Register a project specific controller.
     *
     * @param String $controller Controller Prefix
     *
     * @return void
     */
    public function register_project_controller($controller)
    {
        $this->controllers[] = strtolower($controller);
    }

    /**
     * Register a function with the spl provided __autoload stack.
     *
     * @return Boolean $return TRUE on success, FALSE on failure.
     */
    public function register()
    {
        return spl_autoload_register([$this, 'load']);
    }

    /**
     * Register a function with the spl provided __autoload stack.
     *
     * @return Boolean $return TRUE on success, FALSE on failure.
     */
    public function unregister()
    {
        return spl_autoload_unregister([$this, 'load']);
    }

    /**
     * Convert namespaced classname to filepath.
     *
     * Rules according to PSR-0.
     *
     * @param String $class namespaced classname
     *
     * @return String $filepath Path and filename
     */
    public function get_psr0_class_filepath($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        $path = dirname($class);
        $path = ($path === '.') ? '' : $path . DIRECTORY_SEPARATOR;

        $class = basename($class);
        $class = str_replace('_', DIRECTORY_SEPARATOR, $class);

        return ltrim($path, '/') . $class . '.php';
    }

    /**
     * Convert namespaced classname to filepath.
     *
     * Rules according to PSR-4.
     *
     * @param String $class namespaced classname
     *
     * @return String $filepath Path and filename
     */
    public function get_psr4_class_filepath($class)
    {
        $namespace = substr($class, 0, strrpos($class, '\\'));
        $classname = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $class     = substr($class, strrpos($class, '\\') + 1);

        do
        {
            if (isset($this->prefixes[$namespace]) === TRUE)
            {
                $base_path = $this->prefixes[$namespace];
                $class     = str_replace('\\', DIRECTORY_SEPARATOR, $class);

                return $base_path . $class . '.php';
            }
            else
            {
                $class     = substr($namespace, strrpos($namespace, '\\') + 1) . '\\' . $class;
                $namespace = substr($namespace, 0, strrpos($namespace, '\\'));
            }
        }
        while (strrpos($namespace, '\\') > 1);

        return $classname . '.php';
    }

    /**
     * Convert namespaced classname to filepath.
     *
     * Rules according to Lunr 0.1 specifics.
     *
     * @param String $class namespaced classname
     *
     * @return String $filepath Path and filename
     */
    private function get_legacy_class_filepath($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $path  = strtolower(dirname($class));
        $path  = substr($path, strpos($path, DIRECTORY_SEPARATOR) + 1);
        $path  = empty($path) ? '' : $path . DIRECTORY_SEPARATOR;
        $class = basename($class);

        return $path . $this->get_legacy_class_filename($class);
    }

    /**
     * Construct the expected filename for a class.
     *
     * @param String $class Classname
     *
     * @return String $filename Expected filename
     */
    private function get_legacy_class_filename($class)
    {
        $normalized_name = trim(preg_replace('/([a-z0-9])?([A-Z])/', '$1 $2', $class));
        $split_name      = explode(' ', $normalized_name);

        if ($split_name[0] == 'Mock')
        {
            $class = strtolower(str_replace('Mock', '', $class));
            return "class.$class.mock.php";
        }

        $index = count($split_name) - 1;

        if ($index == 0)
        {
            $class = strtolower($class);
            return "class.$class.inc.php";
        }

        switch ($split_name[$index])
        {
            case 'Controller':
                $class = strtolower(str_replace($split_name[$index], '', $class));
                if (in_array($class, $this->controllers))
                {
                    return "class.${class}controller.inc.php";
                }
                else
                {
                    return "controller.$class.inc.php";
                }

                break;
            case 'Model':
            case 'View':
            case 'Interface':
                $class = strtolower(str_replace($split_name[$index], '', $class));
                return strtolower($split_name[$index]) . ".$class.inc.php";
                break;
            case 'Test':
                $class = strtolower(str_replace('Test', '', $class));
                return "class.$class.test.php";
                break;
            default:
                $class = strtolower($class);
                return "class.$class.inc.php";
                break;
        }
    }

    /**
     * Set a prefix to use in the PSR-4 implementation.
     *
     * @param string $class_prefix The class prefix to use PSR-4 override with
     * @param string $filepath     The file path to resolve the prefix to.
     *
     * @return void
     */
    public function set_prefix($class_prefix, $filepath)
    {
        $this->prefixes[$class_prefix] = $filepath;
    }

}

?>
