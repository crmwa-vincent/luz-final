<?php

session_start();
include_once("../functions.php");
include("../searchheader.php");


if(isset($_POST['search']))
	{
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$bday = $_POST['bday'];
		display_search($fname, $lname, $bday);
	}
elseif(isset($_POST['searchprog']))
	{
		$progname = $_POST['progname'];
		$evenue = $_POST['evenue'];
		$esched = $_POST['esched'];
		display_searchprog($progname, $evenue, $esched);
	}
 elseif (isset($_POST['searchspons']))
  {
 	$sponsorname = $_POST['sponsor'];
 	display_searchsponsor($sponsorname);
 }
?>