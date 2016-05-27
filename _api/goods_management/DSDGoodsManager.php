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
    static function view_all_goods($page, $num_per_page) {
        $total_page = null;
        $result = DSDDatabaseConnector::read("select * from goods", null, "timestamp", false, $page, $num_per_page, $total_page);
        return self::return_simplify_result($result, $total_page);
    }

    static function view_goods_by_category($cid, $page, $num_per_page) {
        $total_page = null;
        $result = DSDDatabaseConnector::read("select * from goods WHERE cid=:cid", array(":cid" => $cid), "timestamp", false, $page, $num_per_page, $total_page);
        return self::return_simplify_result($result, $total_page);
    }
    
    static function check_category($cid) {
        return DSDDatabaseConnector::exists("select * from category where cid=:cid", array(":cid"=>$cid));
    }

    static function search_goods($keyword, $page, $num_per_page) {
        $total_page = null;
        $result = DSDDatabaseConnector::read("select * from goods WHERE CONCAT_WS(' ', name, description) LIKE :keyword", array(":keyword" => "%".$keyword."%"), "timestamp", false, $page, $num_per_page, $total_page);
        return self::return_simplify_result($result, $total_page);
    }

    static function view_certain_goods($gid) {
        $result = DSDDatabaseConnector::get_first_match("select * from goods WHERE gid=:gid", array(":gid" => $gid));
        self::restore_info($result);
        unset($result["abstract"]);
        return $result;
    }

    static function check_goods($gid) {
        return DSDDatabaseConnector::exists("select * from goods where gid=:gid", array(":gid"=>$gid));
    }
    
    static function return_simplify_result($result, $total_page) {
        for ($i = 0; $i < count($result); $i++) {
            self::restore_info($result[$i]);
            unset($result[$i]["description"]);
        }
        return array("goods" => $result, "total_page" => $total_page);
    }

    static function restore_info(&$goods) {
        $json = $goods["info"];
        $goods["info"] = json_decode($json, true);
    }

    static function add_goods($name, $cid, $info, $abstract, $description, $remains) {
        DSDDatabaseConnector::insert(
            "goods",
            array(
                "name" => $name,
                "cid" => $cid,
                "info" => $info,
                "abstract" => $abstract,
                "description" => $description,
                "remains" => intval($remains) > 1 ? intval($remains) : 1,
                "timestamp" => time()
            )
        );
        return DSDDatabaseConnector::getInsertId();
    }

    static function update_goods($gid, $name, $cid, $info, $abstract, $description, $remains) {
        DSDDatabaseConnector::update(
            "goods",
            array(
                "name" => $name,
                "cid" => $cid,
                "info" => $info,
                "abstract" => $abstract,
                "description" => $description,
                "remains" => intval($remains) > 1 ? intval($remains) : 1,
            ),
            "gid=:gid",
            array(":gid" => $gid)
        );
        return DSDDatabaseConnector::getAffectedRows();
    }

    static function delete_goods($gid) {
        DSDDatabaseConnector::write("DELETE FROM goods WHERE gid=:gid", array(":gid" => $gid));
        return DSDDatabaseConnector::getAffectedRows();
    }
}