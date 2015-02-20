<?php
if($_POST) {
	include ("../functions.php");
	
	$where = "";
	if(isset($_POST['event_category']) && !empty($_POST['event_category'])) {
		$where .= " AND res_interest LIKE '%".$_POST['event_category']."%'";
	}

	if(isset($_POST['event_part_cat']) && !empty($_POST['event_part_cat'])) {
		$w = array();
		$where .= " AND (";
		if(in_array('Seniors',$_POST['event_part_cat'])) {
			$w[] .= " res_age >= 60 ";
		}
		if(in_array('Youth',$_POST['event_part_cat'])) {
			$w[] .= " (res_age >= 15 AND res_age <=25) ";
		}
		if(in_array('Children',$_POST['event_part_cat'])) {
			$w[] .= " res_age < 15 ";
		}
		if(in_array('Women',$_POST['event_part_cat'])) {
			$w[] .= " (res_age > 25 AND res_age < 60 AND res_gender = 'female') ";
		}
		if(in_array('Men',$_POST['event_part_cat'])) {
			$w[] .= " (res_age > 25 AND res_age < 60 AND res_gender = 'male') ";
		}
		$cond = implode('OR', $w);
		$where .= $cond.")";

	}

	$sql    = "SELECT * FROM resident WHERE 1=1 ".$where." ORDER BY res_lname"; 
	$res    = mysql_query($sql);
	$output = "";
	$rows   = mysql_num_rows($res);
	if($rows >= 1) {
		while($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
			$output .= '<input type="hidden" name="participants[]" id="participants" value="'.$row['res_id'].'" /> ';
		}
	}else {
		$output = "no residents found...";
	}
	echo $output;
}

//.$row['res_lname'].', '.$row['res_fname'].'<br/>'