<?php

/**
 * Created by PhpStorm.
 * User: iodine
 * Date: 16/5/25
 * Time: 下午8:00
 */
require_once "../request_and_respond/DSDRequestResponder.php";
require_once "../utils/Utils.php";
require_once "../data_management/DSDDatabaseConnector.php";

class DSDRequestShoppingcartHandler{
    public static function add(){
        DSDRequestResponder::respond(
            DSDDatabaseConnector::insert(
                "shopping_cart",
                array_merge(Utils::filter($GLOBALS["data"], ["good_id!", "number!", "sort_identifier!"])), array(
                "user_id"=>DSDAuthorizationChecker::getCurrentUid()
            ))
        );
    }
    public static function modify($good_id, $sid){
        if($_SERVER["REQUEST_METHOD"]=="PUT"){
            DSDRequestResponder::respond(
                DSDDatabaseConnector::update(
                    "shopping_cart",
                    Utils::filter($GLOBALS["data"], ["number!"]),
                    "user_id=:uid AND good_id=:gid AND sort_identifier=:sid",
                    array(
                        ":uid"=>DSDAuthorizationChecker::getCurrentUid(),
                        ":gid"=>$good_id,
                        ":sid"=>$sid
                    )
                )
            );
        }elseif($_SERVER["REQUEST_METHOD"]=="POST"){
            DSDRequestResponder::respond(
                DSDDatabaseConnector::insert(
                    "shopping_cart",
                    array_merge(Utils::filter($GLOBALS["data"], ["good_id!", "number!", "sort_identifier!"])), array(
                    "user_id"=>DSDAuthorizationChecker::getCurrentUid()
                ))
            );
        }elseif($_SERVER["REQUEST_METHOD"]=="DELETE"){
            DSDRequestResponder::respond(
                DSDDatabaseConnector::write("delete from shopping_cart WHERE user_id=:uid AND good_id=:gid AND sort_identifier=:sid", array(
                    ":uid"=>DSDAuthorizationChecker::getCurrentUid(),
                    ":gid"=>$good_id,
                    ":sid"=>$sid
                ))
            );
        }
    }
    public static function delete($good_id, $sid){
        DSDRequestResponder::respond(
            DSDDatabaseConnector::write("delete from shopping_cart WHERE user_id=:uid AND good_id=:gid AND sort_identifier=:sid", array(
                ":uid"=>DSDAuthorizationChecker::getCurrentUid(),
                ":gid"=>$good_id,
                ":sid"=>$sid
            ))
        );
    }
    public static function get(){
        DSDRequestResponder::respond(true, null,
            array_map(function($one){
                $info=DSDDatabaseConnector::get_first_match("select name, info from goods WHERE gid=:gid", array(":gid"=>$one["good_id"]));
                DSDGoodsManager::restore_info($info);
                $one["product_info"]=array_merge($info["info"][$one["sort_identifier"]], array("product_name"=>$one["name"]));
                return $one;
            }, DSDDatabaseConnector::read("select * from shopping_cart WHERE user_id=:uid",
                array(":uid"=>DSDAuthorizationChecker::getCurrentUid()))
            )
        );
    }
}