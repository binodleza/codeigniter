 <?php

 function show($result){
     echo '<pre>';
       print_r($result);
     echo '</pre>';
 }

 function setHash($password){
    return password_hash($password,PASSWORD_DEFAULT);
 }

 function matchHash($hashedPassword, $plainPassword){
     if (password_verify($plainPassword, $hashedPassword)) {
         return true;
     } else {
         return false;
     }
 }



 ?>