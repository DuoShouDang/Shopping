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
        $index=strpos($action, "_");
        if($index!=false) {
            $first_action = substr($action, 0, $index);
        }else {
            $first_action = $action;
        }
        if(strlen($first_action)==0){
            DSDRequestResponder::respond(false, "Invalid action: illegal length");
        }
        $first_action=strtolower($first_action);
        $first_action[0]=strtoupper($first_action[0]);
        try{
            $classname="DSDRequest".$first_action."Handler";
            $classFilePath="../request_and_respond/".$classname.".php";
            if(!file_exists($classFilePath)){
                DSDRequestResponder::respond(false, "Undefined action: ".$classname);
            }
            require_once $classFilePath;
            $class = new ReflectionClass($classname);

            if(file_exists("routers.json")){
                $paths=json_decode(file_get_contents("routers.json"), true);
            }else{
                $paths=[];
            }
            foreach($paths as $one){

            }
            $remains=substr($action, $index+1);
            $functionName="";
            $shouldCapital=false;
            for($i=0;$i<strlen($remains);$i++){
                if($remains[$i]=="_"){
                    $shouldCapital=true;
                }else{
                    if($shouldCapital){
                        $shouldCapital=false;
                        $functionName .= strtoupper($remains[$i]);
                    }else{
                        $functionName .= $remains[$i];
                    }
                }
            }
            if(!$class->hasMethod($functionName)){
                DSDRequestResponder::respond(false, "Undefined function: ".$functionName);
            }
            $handler = $class->getMethod($functionName);
            $handler->invoke($class);
        }catch(ReflectionException $e){
            DSDRequestResponder::respond(false, "Invalid action: ".$first_action);
        }
    }
}