<?php

/**
 * Created by PhpStorm.
 * User: iodine
 * Date: 16/5/16
 * Time: 下午1:01
 */
require_once "../request_and_respond/DSDRequestResponder.php";

class DSDRequestHandler{
    static function handleRequest(){
        $action=@$_GET["action"];
        if(!preg_match("#^[0-9a-zA-Z_]+$#", $action)){
            DSDRequestResponder::respond(false, "Invalid action: illegal character");
        }
        $action=strtolower($action);
        $comps=explode("_", $action);
        if(file_exists("../request_and_respond/routers.json")){
            $paths=json_decode(file_get_contents("../request_and_respond/routers.json"), true);
        }else{
            $paths=array();
        }
        $params=[];
        foreach($paths as $pattern=>$rout){
            $pattern_comps=explode("/", $pattern);
            $params=[];
            if(count($pattern_comps)==count($comps)){
                $test=true;
                for($i=0;$i<count($pattern_comps);$i++){
                    if($pattern_comps[$i][0]==":"){
                        $params[]=$comps[$i];
                    }elseif($pattern_comps[$i]!=$comps[$i]){
                        $test=false;
                        break;
                    }
                }
                if($test){
                    #Matched
                    $comps=explode("/", $rout);
                    break;
                }
            }
        }
        $first_action=array_shift($comps);
        if(strlen($first_action)==0){
            DSDRequestResponder::respond(false, "Invalid action: illegal length");
        }
        $first_action[0]=strtoupper($first_action[0]);
        try{
            $data=file_get_contents("php://input");
            if($data) $GLOBALS["data"]=json_decode($data, true);
            else $GLOBALS["data"]=[];

            $classname="DSDRequest".$first_action."Handler";
            $classFilePath="../request_and_respond/".$classname.".php";
            if(!file_exists($classFilePath)){
                DSDRequestResponder::respond(false, "Undefined action: ".$classname);
            }
            require_once $classFilePath;
            $class = new ReflectionClass($classname);
            $functionName=implode("", array_map(function($one){
                $one[0]=strtoupper($one[0]);
                return $one;
            }, $comps));
            if(!$functionName) $functionName="get";
            $functionName[0]=strtolower($functionName[0]);

            if(!$class->hasMethod($functionName)){
                DSDRequestResponder::respond(false, "Undefined function: ".$classname."::".$functionName);
            }
            $handler = $class->getMethod($functionName);
            $handler->invokeArgs($class, $params);
        }catch(ReflectionException $e){
            DSDRequestResponder::respond(false, "Invalid action: ".$first_action);
        }
    }
}