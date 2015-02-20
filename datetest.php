<?php 
include('header.php');
include_once('functions.php');

$result = mysql_query("SELECT * from programs");
echo'
<div class="container shadow">
	<div class="row clearfix">
'	;

while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$id = $row['event_id'];
		$sponsor = $row['event_sponsors'];
		$sponsors = explode(',',$sponsor);
		$i=0;
		foreach ($sponsors as $key => $value) {
			
			for($i=0;$i<count($sponsors);$i++)
				{
					echo '</br>';
					echo $id, $sponsors[$i];
				}
		}
	}
echo'</div></div>';
//$day = date('Y-m-d', strtotime("+1 day"));

//echo $day;
?>

