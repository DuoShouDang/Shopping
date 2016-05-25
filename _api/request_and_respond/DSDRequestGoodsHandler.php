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
        Utils::ensureKeys(@$_GET, ["page"]);
        $info = DSDGoodsManager::view_all_goods(@$_GET["page"]);
        DSDRequestResponder::respond(true, null, $info);
    }

    public static function category() {
        Utils::ensureKeys(@$_GET, ["page", "cid"]);
        if (!DSDGoodsManager::check_cid(@$_GET["cid"])) {
            DSDRequestResponder::respond(false, "类别不存在", nil);
        }
        $info = DSDGoodsManager::view_goods_by_category(@$_GET["cid"], @$_GET["page"]);
        DSDRequestResponder::respond(true, null, $info);
    }

    public static function search() {
        Utils::ensureKeys(@$_GET, ["page", "keyword"]);
        $info = DSDGoodsManager::search_goods(@$_GET["keyword"], @$_GET["page"]);
        DSDRequestResponder::respond(true, null, $info);
    }

    public static function detail() {
        Utils::ensureKeys(@$_GET, ["gid"]);
        $info = DSDGoodsManager::view_certain_goods(@$_GET["gid"]);
        DSDRequestResponder::respond(true, null, $info);
    }
}