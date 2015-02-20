<?php
if($_POST) {
	include ("../functions.php");
	
	$from  = date('Y-m-d',strtotime($_POST['fromdate']));
	$to    = date('Y-m-d',strtotime($_POST['todate']));
	$where = "WHERE p.event_startsched >= '{$from}' AND p.event_startsched <= '{$to}'";
	
	if(!empty($_POST['category'])) {
		$where .= " AND p.event_category = '".$_POST['category']."'";
	}

	$sql    = "SELECT p.event_name,p.event_category,p.event_venue,p.event_startsched, p.event_endsched,p.event_budget,p.event_status, COUNT(rp.id) AS participants FROM programs p
			LEFT JOIN residents_programs rp ON rp.prog_id = p.event_id 
			{$where}
			GROUP BY rp.prog_id ORDER BY p.event_startsched";
	$res    = mysql_query($sql);
	$output = "";
	$rows   = mysql_num_rows($res);
	if($rows >= 1) {
		$budget = 0;
		$part   = 0;
		while($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
			$to      = date('Y/m/d h:i A',strtotime($row['event_startsched']));
			$from    = date('Y/m/d h:i A',strtotime($row['event_endsched']));
			$budget += $row['event_budget'];
			$part   += $row['participants'];

			$output .= ' <tr>
				          <td>'.$row['event_name'].'</td>
				          <td>'.$row['event_category'].'</td>
				          <td>'.$row['event_venue'].'</td>
				          <td>'.$to.'</td>
				          <td>'.$from.'</td>
				          <td>'.$row['participants'].'</td>
				          <td>'.$row['event_budget'].'</td>
				          <td>'.$row['event_status'].'</td>
				        </tr>';
		}
		$output .= ' <tr><td colspan="10" align="right">
							No. of Programs: '.$rows.' <br />
							Total Participants: '.$part.' <br />
							Total Budget: '.$budget.' <br />
					</td></tr>';
	}else {
		$output = ' <tr><td colspan="10" align="center">no programs found...</td></tr>';
	}
	echo $output;
}
