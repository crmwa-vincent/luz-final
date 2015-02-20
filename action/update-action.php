<?php

include('../functions.php');

    if(isset($_GET['edit']))
	    {
	    	if(!empty($_GET['rinterest'])){
						foreach($_GET['rinterest'] as $zzz){
							$rinterest 	= implode(',',$_GET['rinterest']);
						}
					}

	    	$id = $_GET['id'];
	    	$fname = $_GET['fname'];
	    	$mname = $_GET['mname'];
	    	$lname = $_GET['lname'];
	    	$email = $_GET['email'];
	    	$gender = $_GET['gender'];
	    	$contact = $_GET['contact'];
	    	$bday = $_GET['bday'];
	    	$sitio = $_GET['sitio'];
	    	update_resident($id,$fname,$mname,$lname,$email,$gender,$contact,$bday,$sitio,$rinterest);
	    }
  	if(isset($_GET['edit_clerk']))
	    {
	    	$id = $_GET['id'];
	    	$fname = $_GET['fname'];
	    	$lname = $_GET['lname'];
	    	$email = $_GET['email'];
	    	$contact = $_GET['contact'];
	    	$bday = $_GET['bday'];
	    	$uname = $_GET['uname'];	    	
	    	update_clerk($id, $fname, $lname, $email, $contact, $bday, $uname);
	    }
  	if(isset($_POST['edit_program']))
  		{
			$id = $_POST['eid'];
			$eparts = '';
			if(!empty($_POST['participants'])) $eparts = $_POST['participants'];
			$ename = $_POST['ename'];
			$edates = $_POST['edates'];
			$edatee = $_POST['edatee'];
			$evenue = $_POST['evenue'];
			$ecat 	= $_POST['event_category'];
			$edesc 	= $_POST['event_desc'];
			$esponsors = $_POST['event_sponsors'];
			$ebudget = $_POST['event_budget'];
			$estat 	= $_POST['event_status'];
			$epartcat 	= implode(',',$_POST['event_part_cat']);

			update_program($id, $ename, $edates, $edatee, $evenue, $eparts, $ecat, $edesc, $esponsors, $ebudget, $estat, $epartcat);
  		}
 ?>