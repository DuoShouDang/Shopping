<?php

/**
 * Created by PhpStorm.
 * User: iodine
 * Date: 16/5/21
 * Time: 上午12:44
 */
require_once "../request_and_respond/DSDRequestResponder.php";
require_once "../account_management/DSDAccountManager.php";

class DSDRequestAccountHandler{
    public static function register(){
        Utils::ensureKeys($GLOBALS["data"], ["username", "email", "password"]);
        if(!$uid=DSDAccountManager::addAccount($GLOBALS["data"]["username"], $GLOBALS["data"]["email"], DSDAccountManager::USER, $GLOBALS["data"]["password"])){
            DSDRequestResponder::respond(false, "email已经被注册过了");
        }
        DSDRequestResponder::respond(true, null, DSDAccountManager::issueAccessTokenWithID($uid));
    }
}