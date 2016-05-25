<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 16/5/25
 * Time: 下午1:58
 */

require_once "../request_and_respond/DSDRequestResponder.php";
require_once "../goods_management/DSDGoodsManager.php";

class DSDRequestGoodsHandler{
    
    public static function all() {
        Utils::ensureKeys($GLOBALS["data"], ["page"]);
        $info = DSDGoodsManager::view_all_goods($GLOBALS["data"]["page"]);
        DSDRequestResponder::respond($info);
    }

    public static function certain() {
        Utils::ensureKeys($GLOBALS["data"], ["gid"]);
        $info = DSDGoodsManager::view_certain_goods($GLOBALS["data"]["gid"]);
        DSDRequestResponder::respond($info);
    }
}