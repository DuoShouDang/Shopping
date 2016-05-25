<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 16/5/25
 * Time: 下午11:51
 */

require_once "../request_and_respond/DSDRequestAccountHandler.php";

class DSDRequestAdminHandler{

    public static function login(){
        DSDRequestAccountHandler::loginWithType(DSDAccountManager::ADMIN);
    }

    public static function logout(){
        $res = DSDAccountManager::invalidateAccessToken(DSDAuthorizationChecker::getCurrentToken());
        DSDRequestResponder::respond($res);
    }

}