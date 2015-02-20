<?php
include_once("functions.php");

$next_day = date('Y-m-d', strtotime(' +1 day'));

$result = mysql_query("SELECT event_id, event_startsched, event_venue, event_name from programs WHERE event_startsched LIKE '%".$next_day."%' && event_status = 1");
 while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	$prog_id =  $row['event_id'];
	$ename = $row['event_name'];
	$esched = $row['event_startsched'];
	$evenue = $row['event_venue'];

	
	$result1 = mysql_query("SELECT r.res_contact, r.res_fname, r.res_lname from residents_programs rp
	 LEFT JOIN resident r ON rp.res_id = r.res_id
	 WHERE rp.prog_id = ".$prog_id);

 	 while($row1 = mysql_fetch_array($result1,MYSQL_ASSOC)) {
 		$phone = $row1['res_contact'];
 		$fname = $row1['res_fname'];
 		$lname = $row1['res_lname'];
 		echo '<br/>'.$phone;
 		$a = shell_exec('"C:\Program Files\Gammu 1.32.0\bin\gammu.exe" --sendsms TEXT '.$phone.' -len 320 -text "Good day '.$fname.' '.$lname.'! We would like to invite you to our '.$ename.' program this '.$esched.' at the '.$evenue.'. We only have limited slots, first come first served basis only."');
 	 }

}
