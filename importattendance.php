
<?php

include("functions.php");


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';
 
$inputFileName = 'attendance.xlsx';
 
try {
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}
 
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet






$id = $_POST['id'];
$result =mysql_query("SELECT r.res_fname, r.res_mname, r.res_lname FROM residents_programs rp left join resident r on rp.res_id = r.res_id where rp.prog_id = ".$id." && rp.checked = 0"); 

for($i=3;$i<=$arrayCount;$i++)
{
	if(!empty($allDataInSheet[$i]["A"]))
	{
		$fnamex = trim($allDataInSheet[$i]["A"]);
		$mnamex = trim($allDataInSheet[$i]["B"]);
		$lnamex = trim($allDataInSheet[$i]["C"]);
		//echo $fnamex;
					 				
		while($row=mysql_fetch_array($result,MYSQL_ASSOC))
			{
				$fname = $row['res_fname'];
				$mname = $row['res_mname'];
				$lname = $row['res_lname'];
			}
				//echo 
				
		}
			//echo $fname, $mname, $lname;
			//		echo '</br>';
					echo $fnamex, $mnamex, $lnamex;
					echo '</br>';
					
		if($fname==$fnamex && $mname==$mnamex && $lname==$lnamex)
					{

					}		
			
	}
?>