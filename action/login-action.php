<?php

 ob_start();
 session_start();

 if(isset($_POST['submit']))
                 {
                      include('../functions.php');
                      $username=$_POST['uname'];
                      $password=$_POST['pword'];
                      login($username, $password);
                 }
?>