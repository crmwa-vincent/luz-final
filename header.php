<?php
ob_start();
session_start();
include ('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
<link rel="icon" href="img/brgyluz1.jpg">
<title>Barangay Luz</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet/less" href="css/bootswatch.less" type="text/css">
<link rel="stylesheet/less" href="css/variables.less" type="text/css">	

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>

</head>
<body background="img/background01.jpg">

<div class="navbar navbar-default navbar-inverse" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>	
    </button>
    <a class="navbar-brand" href="index.php"><u>Barri<img src="img/logo.jpg" height="20"> Luz</u></a>
  </div>
  <ul class="breadcrumb" style="margin-bottom: 5px;" align="center">




  <li><a href="index.php">Home</a></li>
  <li><a href="program.php">Programs</a></li>
	  
  	<?php
  		if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2)
	  		{
	  			echo '<li><a href="home.php">Residents</a></li>
	  					<li><a href="reports.php">Reports</a></li>';
	  		}

	  	else if(isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
	  		{	
	  			echo '<li><a href="home.php">Users</a></li>
	  				  <li><a href="home1.php">Residents</a></li>
	  				  <li><a href="reports.php">Reports</a></li>';
	  		}
	?>
 	<?php
		if(isset($_SESSION['username']) && isset($_SESSION['usertype']) && $_SESSION['usertype']==2)
	    	{
	    		$x = -1000;
				$result = mysql_query("SELECT * FROM clerk");

				$row = mysql_fetch_array($result,MYSQL_ASSOC);
            
                  $id=$_SESSION['user_id'];
                  $fname=$_SESSION['fname'];
                  $lname=$_SESSION['lname'];
                  $contact=$_SESSION['contact'];
                  $uname=$_SESSION['username'];
                  $email=$_SESSION['email'];
                  $bday=$_SESSION['bday'];
                  $img=$_SESSION['img'];
                  $target = "upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
	  echo '
	  <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome ' .$_SESSION['username'].'<b class="caret"></b></a>
    <ul class="dropdown-menu">
	  <li>
	  <form action="clerkprofile.php" method="GET">
	  			<input type="hidden" value="'.$fname.'" name="fname">
                <input type="hidden" value="'.$id.'" name="id">
                <input type="hidden" value="'.$lname.'" name="lname">
                <input type="hidden" value="'.$contact.'" name="contact"> 
                <input type="hidden" value="'.$uname.'" name="uname">
                <input type="hidden" value="'.$bday.'" name="bday">                 
                <input type="hidden" value="'.$email.'" name="email">
                <td><button>Profile</button></td></form></li>
	  <li><a href="action/logout.php">Logout</a></li>
	</ul>';
			}

		else if(isset($_SESSION['username']) && isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
	    	{
	  echo '
	  				  
	  <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome ' .$_SESSION['username'].'<b class="caret"></b></a>
    <ul class="dropdown-menu">
	  <li><a href="action/logout.php">Logout</a></li>
	</ul>';
			}

	else
		echo '<li><a href="login.php">Login</a></li>';
	?>
</ul>
 </div>
 <br/>

