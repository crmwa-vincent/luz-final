<?php

	include ("../functions.php");

	$attendees ='';
	//$resid = $_GET['resid'];
	$result = mysql_query("SELECT * FROM resident ");
	$x=1;

	while($row=mysql_fetch_array($result,MYSQL_ASSOC))
	{
		
	if(isset($_GET['.$x.']))
			$attendees .= $row['res_fname'];

	}
//		$attendees = explode("/",$attendees);
		echo $attendees;
//		echo $attendees[1];

?>