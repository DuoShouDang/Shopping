<?php

/**
 * Created by PhpStorm.
 * User: i2
 * Date: 16/1/20
 * Time: 下午10:54
 */

require_once "../request_and_respond/DSDRequestResponder.php";

class Utils {
    static function createRandom($num){
        $saltstr="qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
        $salt="";
        for($i=0;$i<$num;$i++){
            $salt=$salt. substr($saltstr, rand(0, strlen($saltstr)-1),1);
        }
        return $salt;
    }
    public static function ensureKeys($array, $keys){
        foreach($keys as $one){
            if(!isset($array[$one])){
                DSDRequestResponder::respond(false, "缺少必要参数: ".$one);
            }
        }
    }
    public static function format_time($timestamp, $force_date=false){
        if($force_date) return date("Y-m-d H:i:s",$timestamp);
        $target=intval($timestamp);
        $now=time();
        $s=$now-$target;
        if($s<0) return date("Y-m-d",$timestamp);
        if($s<60) return "不到1分钟前";
        if($s<3600) return intval($s/60)."分钟前";
        if($s<3600*24) return intval($s/3600)."小时前";
        if($s<3600*24*7) return intval($s/3600/24)."天前";
        if($s>10*365*24*3600) return "很久很久以前";
        return date("Y-m-d",$timestamp);
    }
    static function strMatchReg($str, $reg){
        return @preg_match('#' . $reg . '#', $str) == 0 ? false : true;
    }
    static function http($url, $method, $postfields = NULL, $header=FALSE, $cookie=NULL,$proxy=NULL, $auth=NULL) {
        $ci = curl_init();
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30); // 连接超时
        curl_setopt($ci, CURLOPT_TIMEOUT, 30); // 执行超时
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true); // 文件流的形式返回，而不是直接输出
        curl_setopt($ci, CURLOPT_ENCODING, "gzip, deflate");
        #curl_setopt($ci, CURLOPT_HEADER, $header);
        if($cookie){
            curl_setopt($ci, CURLOPT_COOKIE, $cookie);
        }
        if($proxy){
            curl_setopt ($ci, CURLOPT_PROXY, $proxy);
            curl_setopt ($ci, CURLOPT_PROXYUSERPWD, $auth);
        }

        if ('POST' == $method) {
            curl_setopt($ci, CURLOPT_POST, true); // post
        }
        if (!empty($postfields)) {
            curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields); // post数据 可为数组、连接字串
        }
        $response = curl_exec($ci);
        curl_close($ci);
        return $response;
    }
    static function superTrim($aline){
        $trimed=chr(10).chr(13).chr(9).chr(32);
        #$aline=trim($aline);
        $start=0;
        for($i=0;$i<mb_strlen($aline, "utf-8");$i++){
            $cur=mb_substr($aline, $i, 1, "utf-8");
            if(strstr($trimed, mb_substr($aline, $i, 1, "utf-8"))){
                $start++;
            }else{
                break;
            }
        }
        $end=mb_strlen($aline, "utf-8");
        for($i=mb_strlen($aline, "utf-8")-1;$i>=0;$i--){
            if(strstr($trimed, mb_substr($aline, $i, 1, "utf-8"))){
                $end--;
            }else{
                break;
            }
        }
        $aline=mb_substr($aline, $start, $end-$start, "utf-8");
        return $aline;
    }
    static function filter($obj, $keys){
        $ans=array();
        foreach($keys as $key){
            if(substr($key, strlen($key)-1, 1)=="!"){
                $key=substr($key, 0, strlen($key)-1);
                if(!isset($obj[$key])) DSDRequestResponder::respond(false, "缺少必要参数: ".$key);
            }
            if(@$obj[$key]) $ans[$key]=$obj[$key];
        }
        return $ans;
    }
    static function plainTextOfHTML($html){
        return preg_replace('/<[^>]+>|&nbsp;/', '', $html);
    }

    static function calculate($str, $allowedOprs=null){
        $str=$str."$";
        $num_stack=array();
        $opr_stack=array();
        $num_cache="";
        $sub_cache="";
        $subcachemode=0;
        if(!$allowedOprs) $allowedOprs=array("$","+","-","*","/");
        for($i=0;$i<strlen($str);$i++){
            $cur=substr($str, $i, 1);

//            echo("Num: ".$i."<br>");
//            echo("Cur: ".$cur."<br><br>");
//            echo("Start:<br>");
//            echo("Cache: ".$num_cache."<br>");
//            var_dump($num_stack);
//            echo("<br>");
//            var_dump($opr_stack);
//            echo("<br>");
//            echo("<br>");

            if($cur==" ") continue;
            if($cur=="("){
                $subcachemode++;
                if($subcachemode==1) continue;
            }else if($cur==")"){
                $subcachemode--;
                if($subcachemode==0){
                    $res=self::calculate($sub_cache, $allowedOprs);
                    $num_cache=$res;
                    continue;
                }
            }
            if($subcachemode>0){
                $sub_cache .= $cur;
                continue;
            }
            if(in_array($cur, $allowedOprs)){
                $shouldClear=false;
                if(count($opr_stack)>0){
                    $cur_value=array_search($cur, $allowedOprs);
                    $pre_value=array_search($opr_stack[count($opr_stack)-1], $allowedOprs);
                    if($cur_value<$pre_value){
                        $shouldClear=true;
                    }
                }
                if($shouldClear){
                    array_push($num_stack, $num_cache);
                    $num_cache="";
                    while(count($opr_stack)>0){
                        $b=array_pop($num_stack);
                        $a=array_pop($num_stack);
                        array_push($num_stack, self::performOpr($a, array_pop($opr_stack), $b));
//                        var_dump($num_stack);
//                        var_dump($opr_stack);
//                        echo("<br>");
                    }
                }
                array_push($opr_stack, $cur);
                if($num_cache!=""){
                    array_push($num_stack, $num_cache);
                    $num_cache="";
                }
            }else{
                $num_cache .= $cur;
            }

//            echo("End:<br>");
//            echo("Cache: ".$num_cache."<br>");
//            var_dump($num_stack);
//            echo("<br>");
//            var_dump($opr_stack);
//            echo("<br>");
//            echo("<br><br>");
        }
        return $num_stack[0];
    }

    static function performOpr($a, $opr, $b){
        if(is_numeric($a)&&is_numeric($b)){
            switch($opr){
                case '+': return $a+$b;
                case '-': return $a-$b;
                case '*': return $a*$b;
                case '/': return $a/$b;
            }
        }
        return 0;
    }
}