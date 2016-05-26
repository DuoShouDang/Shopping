<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 16/5/25
 * Time: 下午11:51
 */

require_once "../request_and_respond/DSDRequestAccountHandler.php";
require_once "../goods_management/DSDGoodsManager.php";

class DSDRequestAdminHandler{

    public static function login(){
        DSDRequestAccountHandler::loginWithType(DSDAccountManager::ADMIN);
    }

    public static function logout(){
        $res = DSDAccountManager::invalidateAccessToken(DSDAuthorizationChecker::getCurrentToken());
        DSDRequestResponder::respond($res);
    }

    public static function modify($gid = null) {
        DSDAuthorizationChecker::ensureIam(DSDAccountManager::ADMIN);

        if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "PUT") {
            Utils::ensureKeys($GLOBALS["data"], ["name", "cid", "info", "abstract", "description", "remains"]);
            if (!DSDGoodsManager::check_category($GLOBALS["data"]["cid"])) {
                DSDRequestResponder::http_code(404, false);
                DSDRequestResponder::respond(false, "类别不存在");
            }
            if (!json_decode($GLOBALS["data"]["info"], true)) {
                DSDRequestResponder::http_code(400, false);
                DSDRequestResponder::respond(false, "信息格式错误");
            }
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $info = DSDGoodsManager::add_goods(
                $GLOBALS["data"]["name"],
                $GLOBALS["data"]["cid"],
                $GLOBALS["data"]["info"],
                $GLOBALS["data"]["abstract"],
                $GLOBALS["data"]["description"],
                $GLOBALS["data"]["remains"]
            );
            DSDRequestResponder::respond(true, null, array("gid" => $info));
            
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "PUT") {
                Utils::ensureKeys($GLOBALS["data"], ["gid"]);
                $gid = $GLOBALS["data"]["gid"];
            }
            if (!DSDGoodsManager::check_goods($gid)) {
                DSDRequestResponder::http_code(404, false);
                DSDRequestResponder::respond(false, "商品不存在");
            }
            
            $info = null;
            if ($_SERVER["REQUEST_METHOD"] == "PUT") {
                $info = DSDGoodsManager::update_goods(
                    $gid,
                    $GLOBALS["data"]["name"],
                    $GLOBALS["data"]["cid"],
                    $GLOBALS["data"]["info"],
                    $GLOBALS["data"]["abstract"],
                    $GLOBALS["data"]["description"],
                    $GLOBALS["data"]["remains"]
                );
            } else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                $info = DSDGoodsManager::delete_goods($gid);
            }
            if ($info > 0) {
                DSDRequestResponder::respond(true);
            } else {
                DSDRequestResponder::respond(false);
            }
        }
        
    }
    
}