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
        $uid=DSDAccountManager::addAccount($GLOBALS["data"]["username"], $GLOBALS["data"]["email"], DSDAccountManager::USER);
        if(!$uid){
            DSDRequestResponder::respond(false, "email已经被注册过了");
        }
        if(DSDAccountManager::activateAccountWithPasswordAndUid($GLOBALS["data"]["password"], $uid)){
            DSDRequestResponder::respond(true, null, DSDAccountManager::issueAccessTokenWithID($uid));
        }
    }
}