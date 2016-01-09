<?php

/**
 * This file contains a network error trait.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Network
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network;

/**
 * Network Error Trait.
 */
trait NetworkErrorTrait
{

    /**
     * Network error number
     * @var Integer
     */
    protected $error_number;

    /**
     * Network error message
     * @var String
     */
    protected $error_message;

    /**
     * Return the last error message.
     *
     * @return String $error Error message
     */
    public function get_network_error_message()
    {
        return $this->error_message;
    }

    /**
     * Return the last error number.
     *
     * @return String $errno Error number
     */
    public function get_network_error_number()
    {
        return $this->error_number;
    }

}

?>
