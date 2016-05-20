<?php

/**
 * Created by PhpStorm.
 * User: i2
 * Date: 16/1/17
 * Time: 下午10:10
 */
require_once dirname(__FILE__)."/../config/config.php";

class DSDDatabaseConnector {
    static $pdo;
    static $affectedRows;

    /**
     * CHDatabaseConnector constructor.
     * Initialize PDO engine
     */
    static function init() {
        try{
            DSDDatabaseConnector::$pdo=new PDO('mysql:dbname=' . $GLOBALS["db_database"] .';host=' . $GLOBALS["db_host"] . ';charset=utf8mb4;port=' . $GLOBALS["db_port"], $GLOBALS["db_username"], $GLOBALS["db_password"]);
        }catch(PDOException $e){
            echo $e->getMessage();
            die();
        }
    }

    /**
     * @param $statement
     * @param null $paras
     * @return array
     */
    static function read($statement, $paras=null, $order=null, $desc=false, $page=1, $per_page=12, &$totalPage=null){
        if(!DSDDatabaseConnector::$pdo) DSDDatabaseConnector::init();
        if($order==null){
            $query=DSDDatabaseConnector::$pdo->prepare($statement);
            $query->execute($paras);
            $res=$query->fetchAll(PDO::FETCH_ASSOC);
            if (DSDDatabaseConnector::$pdo->errorCode() != '00000'){
                return false;
            }
            return $res;
        }else{
            $page=intval($page);
            $per_page=intval($per_page);
            if($per_page<=0) $per_page=12;

            $start=$page*$per_page;
            if($desc){
                $data=self::read($statement." order by $order desc limit $start, $per_page", $paras);
            }else{
                $data=self::read($statement." order by $order limit $start, $per_page", $paras);
            }

            $count_statement=preg_replace('#(select|SELECT)\s+(.+?)(\sFROM|from)#', '$1 count(*) as c $3', $statement);
            $count=self::get_first_match($count_statement, $paras, "c");

            $totalPage=ceil($count/$per_page);
            return $data;
        }
    }

    /**
     * @param $statement
     * @param null $paras
     * @return bool
     */
    static function write($statement, $paras=null, $debug=false){
        if($debug){
            var_dump($statement, $paras);
        }
        if(!DSDDatabaseConnector::$pdo) DSDDatabaseConnector::init();
        $query=DSDDatabaseConnector::$pdo->prepare($statement);
        $query->execute($paras);
        if (DSDDatabaseConnector::$pdo->errorCode() != '00000'){
            return false;
        }
        DSDDatabaseConnector::$affectedRows=$query->rowCount();
        return true;
    }

    static function getError(){
        return DSDDatabaseConnector::$pdo->errorInfo()[2];
    }

    static function get_first_match($statement, $paras=null, $key=null){
        $res=DSDDatabaseConnector::read($statement, $paras);
        if(count($res)==0) return null;
        $res=$res[0];
        if($key) return $res[$key];
        else return $res;
    }

    static function exists($statement, $paras){
        return self::get_first_match($statement, $paras)?true:false;
    }

    static function insert($table, $kv, $debug=false){
        $excute=array();
        $fakekeys=array();
        $fakevalues=array();
        $n=0;
        foreach($kv as $key=>$value) {
            $currentValue = ":value$n";
            array_push($fakekeys, $key);
            array_push($fakevalues, $currentValue);
            $excute[$currentValue] = $value;
            $n++;
        }
        $statement="insert into $table (".join(",", $fakekeys).") values (".join(",", $fakevalues).")";
        if(!DSDDatabaseConnector::write($statement, $excute, $debug)){
            return false;
        }
        if(DSDDatabaseConnector::getAffectedRows()==0){
            return false;
        }
        return true;

    }
    static function insertOrUpdate($table, $kv, $idkey=null){
        $execute=array();
        $fakekeys=array();
        $fakevalues=array();
        $updatevalues=array();
        $n=0;
        foreach($kv as $key=>$value) {
            $currentValue = ":value$n";
            array_push($fakekeys, $key);
            array_push($fakevalues, $currentValue);
            $execute[$currentValue] = $value;
            array_push($updatevalues, $key."=".$currentValue);
            $n++;
        }
        $statement="insert into $table (".join(",", $fakekeys).") values (".join(",", $fakevalues).") on duplicate key update ".join(",",$updatevalues);
        if(DSDDatabaseConnector::write($statement, $execute)) {
            if ($idkey) {
                $res=DSDDatabaseConnector::get_first_match("select * from $table where ".join(" and ",$updatevalues), $execute);
                return $res[$idkey];
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    static function update($table, $kv, $condition_template, $condition=null, $debug=false){
        $updatevalues=array();
        $execute=array();
        $n=0;
        foreach($kv as $key=>$value) {
            $currentValue = ":value$n";
            $execute[$currentValue] = $value;
            array_push($updatevalues, $key."=".$currentValue);
            $n++;
        }
        if($condition){
            foreach($condition as $key=>$value){
                $execute[$key]=$value;
            }
        }
        $statement="update $table set ".join(",", $updatevalues)." where ".$condition_template;
        return DSDDatabaseConnector::write($statement, $execute, $debug);
    }
    static function getAffectedRows(){
        return DSDDatabaseConnector::$affectedRows;
    }
    static function getInsertId(){
        return DSDDatabaseConnector::$pdo->lastInsertId();
    }
}
