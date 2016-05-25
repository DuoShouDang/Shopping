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
                array_merge(Utils::filter($GLOBALS["data"], ["good_id!", "number!"])), array(
                "user_id"=>DSDAuthorizationChecker::getCurrentUid()
            ))
        );
    }
    public static function modify($good_id){
        DSDRequestResponder::respond(
            DSDDatabaseConnector::update(
                "shopping_cart",
                Utils::filter($GLOBALS["data"], ["number!"]),
                "user_id=:uid AND good_id=:gid",
                array(
                    ":uid"=>DSDAuthorizationChecker::getCurrentUid(),
                    ":gid"=>$good_id
                )
            )
        );
    }
}