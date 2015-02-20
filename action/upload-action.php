<?php

if ( isset( $_FILES['fupload'] ) && isset($_POST['submit']) ) 
	{            
		if ( $_FILES['fupload']['type'] == "image/png" || $_FILES['fupload']['type'] == "image/jpg" || $_FILES['fupload']['type'] == "image/jpeg" && ($_FILES['fupload']['error']=='0')) 
		{        
			$source = $_FILES['fupload']['tmp_name'];         
			$target = "../upload/".$_FILES['fupload']['name'];
			move_uploaded_file( $source, $target ); 
			$img= $_FILES['fupload']['name'];
			$id = $_POST['id'];
			include('../functions.php');
			uploadimage($img,$id);
		} 
		else
		{
			print "error: ".    $_FILES['fupload']['error']      ."<br />";  
		}
	}
else if ( isset( $_FILES['fupload'] ) && isset($_POST['submit1']) ) 
	{            
		if ( $_FILES['fupload']['type'] == "image/png" || $_FILES['fupload']['type'] == "image/jpg" || $_FILES['fupload']['type'] == "image/jpeg" && ($_FILES['fupload']['error']=='0')) 
		{        
			$source = $_FILES['fupload']['tmp_name'];         
			$target = "../upload/".$_FILES['fupload']['name'];
			move_uploaded_file( $source, $target ); 
			$img= $_FILES['fupload']['name'];
			$id = $_POST['id'];
			include('../functions.php');
			uploadimageclerk($img, $id);
		} 
		else
		{
			print "error: ".    $_FILES['fupload']['error']      ."<br />";  
		}
	}
elseif ( isset( $_FILES['fupload'] ) && isset($_POST['submit2']) ) 
	{            
		if ( $_FILES['fupload']['type'] == "image/png" || $_FILES['fupload']['type'] == "image/jpg" || $_FILES['fupload']['type'] == "image/jpeg" && ($_FILES['fupload']['error']=='0')) 
		{        
			$source = $_FILES['fupload']['tmp_name'];         
			$target = "../upload/".$_FILES['fupload']['name'];
			move_uploaded_file( $source, $target ); 
			$img= $_FILES['fupload']['name'];
			$id = $_POST['id'];
			include('../functions.php');
			uploadimageprog($img, $id);
		} 
		else
		{
			print "error: ".    $_FILES['fupload']['error']      ."<br />";  
		}
	}
?>