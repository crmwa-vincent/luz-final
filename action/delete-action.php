<?php

include('../functions.php');

	if(isset($_GET['delete_resident']))
		{
			$id = $_GET['id'];
			delete_resident($id);
		}

	else if(isset($_GET['delete_clerk']))
		{
			$fname = $_GET['fname'];
			$lname = $_GET['lname'];
			delete_clerk($fname, $lname);
		}
	else if(isset($_GET['delete_program']))
		{
			$ename = $_GET['ename'];
			$edates = $_GET['edates'];
			$edatee = $_GET['edatee'];
			$evenue = $_GET['evenue'];
			delete_program($ename, $edates, $edatee, $evenue);
		}
?>