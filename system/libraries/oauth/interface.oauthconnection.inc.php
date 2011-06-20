<?php

/**
 * This file contains a basic oauth connection
 * interface definition, meant to support login
 * through the service or to post messages to
 * it.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * OAuth connection interface
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface OAuthConnectionInterface
{

    public function __construct($token);

    public function get_request_token($callback);

    public function get_access_token($oauth_token, $request_token_secret);

    public function login();

    public function get_user_info();

    public function post_message();

}

?>
