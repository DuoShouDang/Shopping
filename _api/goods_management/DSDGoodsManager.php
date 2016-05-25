<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 16/5/25
 * Time: 下午2:02
 */
require_once "../data_management/DSDDatabaseConnector.php";
require_once "../utils/Utils.php";

class DSDGoodsManager {
    static function view_all_goods($page) {
        $total_page = null;
        $result = DSDDatabaseConnector::read("select * from goods", null, "timestamp", false, $page, 12, $total_page);
        return DSDGoodsManager::return_simplify_result($result, $total_page);
    }

    static function view_goods_by_category($cid, $page) {
        $total_page = null;
        $result = DSDDatabaseConnector::read("select * from goods WHERE cid=:cid", array(":cid" => $cid), "timestamp", false, $page, 12, $total_page);
        return DSDGoodsManager::return_simplify_result($result, $total_page);
    }
    
    static function check_cid($cid) {
        return (DSDDatabaseConnector::get_first_match("select * from category where cid=:cid", array(":cid"=>$cid)) != null);
    }

    static function search_goods($keyword, $page) {
        $total_page = null;
        $result = DSDDatabaseConnector::read("select * from goods WHERE CONCAT_WS(' ', name, description) LIKE :keyword", array(":keyword" => "%".$keyword."%"), "timestamp", false, $page, 12, $total_page);
        return DSDGoodsManager::return_simplify_result($result, $total_page);
    }

    static function view_certain_goods($gid) {
        $result = DSDDatabaseConnector::read("select * from goods WHERE gid=:gid", array(":gid" => $gid));
        unset($result[0]["abstract"]);
        return $result;
    }
    
    static function return_simplify_result($result, $total_page) {
        for ($i = 0; $i < count($result); $i++) {
            unset($result[$i]["description"]);
        }
        return array("goods" => $result, "total_page" => $total_page);
    }
}