<?php

include ("../functions.php");


		if(isset($_POST['resident']))
		{
			// if(isset($_POST['event_category'])) {
			// 	 if (( sizeof( $_POST['event_category']) == 6 || sizeof( $_POST['event_category']) <= 6 )) {
				    $rinterest = '';
					if(!empty($_POST['event_category'])){
						foreach($_POST['event_category'] as $eventcat){
							$rinterest .= $eventcat;
						}
					}
				 // } else {echo 'Please select at least one interest.';} 
		   //  }

			if ( isset( $_FILES['fupload'] ) && isset($_POST['submit']) ) 
	{            
		if ( $_FILES['fupload']['type'] == "image/png" || $_FILES['fupload']['type'] == "image/jpg" || $_FILES['fupload']['type'] == "image/jpeg" && ($_FILES['fupload']['error']=='0')) 
		{        
			$source = $_FILES['fupload']['tmp_name'];         
			$target = "../upload/".$_FILES['fupload']['name'];
			move_uploaded_file( $source, $target ); 
			$img= $_FILES['fupload']['name'];
			} 
		else
		{
			print "error: ".    $_FILES['fupload']['error']      ."<br />";  
		}
	}

			
			$fname = $_POST['rfname'];
			$mname = $_POST['rmname'];
			$lname = $_POST['rlname'];
			$gender = $_POST['gender'];
			$bday = $_POST['rbday'];
			$bday1 = explode("-",$bday);
			$age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
			$contact = $_POST['rcontact'];
			$email = $_POST['remail'];
			$sitio = $_POST['rsitio'];
		
			regRes($fname,$mname,$lname,$gender,$bday,$age,$contact,$email,$sitio,$rinterest,$img);
		}
		if(isset($_POST['clerk']))
			{
			$fname = $_POST['cfname'];
			$lname = $_POST['clname'];
			$email = $_POST['cemail'];
			$contact = $_POST['ccontact'];
			$bday = $_POST['cbday'];
			$uname = $_POST['cuname'];
			$pword = $_POST['cpword'];
			$cpword = $_POST['ccpword'];
			$img = $_POST['img'];

			

		  	if($pword == $cpword)
		  		{
		  			$user_query = mysql_query("SELECT * from clerk WHERE clerk_username='".$uname."'");

				  	if(mysql_num_rows($user_query)==1)
				  		{
				  			echo "<center>Username is already being used!</center>";
				  			header("location:../home.php?error=1");
				  		}
				  	else
						regClerk($fname,$lname,$email,$contact,$bday,$uname,$pword,$img);
				}
			else
				{
		
					echo "<center>Passwords do not match!</center>";
					header("location:../home.php?error=2");
				}
			}	

		if (isset($_POST['programs'])) 
		{
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

			regProg($ename,$edates, $edatee, $evenue, $eparts, $ecat, $edesc, $esponsors, $ebudget, $estat, $epartcat);
		}

?>