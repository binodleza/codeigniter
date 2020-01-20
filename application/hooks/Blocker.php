<?php
class Blocker {

    function Blocker(){
    }

    /**
     * This function used to block the every request except allowed ip address
     */
    function requestBlocker(){

      /*  $CI =& get_instance();
       $className = $CI->router->fetch_class();
       $methodName = $CI->router->fetch_method();
       $makeUrl = '/'.$className.'/'.$methodName;
       if(!checkAccess($makeUrl)){
           echo "not allowed";
           die;
       } */
    }
}
?>