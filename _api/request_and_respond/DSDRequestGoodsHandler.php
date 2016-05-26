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
    
    public static function all($page, $num_per_page) {
        $info = DSDGoodsManager::view_all_goods($page, $num_per_page);
        DSDRequestResponder::respond(true, null, $info);
    }

    public static function category($cid, $page, $num_per_page) {
        if (!DSDGoodsManager::check_category($cid)) {
            DSDRequestResponder::http_code(404, false);
            DSDRequestResponder::respond(false, "类别不存在");
        }
        $info = DSDGoodsManager::view_goods_by_category($cid, $page, $num_per_page);
        DSDRequestResponder::respond(true, null, $info);
    }

    public static function search($keyword, $page, $num_per_page) {
        $info = DSDGoodsManager::search_goods($keyword, $page, $num_per_page);
        DSDRequestResponder::respond(true, null, $info);
    }

    public static function detail($gid) {
        if (!DSDGoodsManager::check_goods($gid)) {
            DSDRequestResponder::http_code(404, false);
            DSDRequestResponder::respond(false, "商品不存在");
        }
        $info = DSDGoodsManager::view_certain_goods($gid);
        DSDRequestResponder::respond(true, null, $info);
    }
}