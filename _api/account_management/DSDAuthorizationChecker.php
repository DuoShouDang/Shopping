<?php

/**
 * Created by PhpStorm.
 * User: i2
 * Date: 16/1/17
 * Time: 下午10:01
 */
require_once "../data_management/DSDDatabaseConnector.php";
require_once "../request_and_respond/DSDRequestResponder.php";
require_once "../account_management/DSDAccountManager.php";

class DSDAuthorizationChecker {

    const LOGGEDIN="loggedin";
    static $tempUid=null;

    static function getUserInfoFromToken($token){
        $res=DSDDatabaseConnector::read("select * from authorization where token=:token and tokentime>:time", array(":token"=>$token, ":time"=>time()));
        #$res=DSDDatabaseConnector::read("select * from authorization where user_id=1 limit 1");
        if(count($res)==0) return null;
        return $res[0];
    }
    static function getCurrentToken(){
        if (!function_exists('getallheaders')) {
            function getallheaders() {
                $headers=array();
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;
            }
        }

        $token=null;
        $headers=getallheaders();
        while (list($header, $value) = each($headers)) {
            if(strtolower($header)=="authorization"){
                $token=$value;
                break;
            }
        }
        return $token;
    }
    static function getCurrentUid(){
        if(!DSDAuthorizationChecker::$tempUid){
            $uinfo=self::getUserInfoFromToken(self::getCurrentToken());
            if($uinfo){
                DSDAuthorizationChecker::$tempUid=intval($uinfo["user_id"]);
            }else{
                return false;
            }
        }
        return DSDAuthorizationChecker::$tempUid;
    }
    static function checkAuthorizationWithToken($token){
        $user=DSDAuthorizationChecker::getUserInfoFromToken($token);
        if(!$user){
            DSDRequestResponder::respondUnauthorized();
        }
        return $user;
    }
    static function checkAuthorizationWithCurrentCookie(){
        return DSDAuthorizationChecker::checkAuthorizationWithToken(self::getCurrentToken());
    }
    static function logout(){
        return DSDAccountManager::invalidateAccessToken(self::getCurrentToken());
    }
    static function getCurrentUserInfo(){
        return self::getUserInfoFromToken(self::getCurrentToken());
    }

    static function ensureIam($what){
        if($what==DSDAuthorizationChecker::LOGGEDIN){
            if(self::getCurrentUid()==false) DSDRequestResponder::respondUnauthorized();
        }else{
            $res=self::getCurrentUserInfo();
            if(!$res) DSDRequestResponder::respondUnauthorized();
            if($res["type"]!=$what) DSDRequestResponder::respondUnauthorized();
        }
    }
}
