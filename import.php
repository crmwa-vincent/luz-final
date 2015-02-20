<?php
/************************ YOUR DATABASE CONNECTION START HERE   ****************************/
 

include("functions.php");

 
/************************ YOUR DATABASE CONNECTION END HERE  ****************************/
 
 
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';
 
// This is the file path to be uploaded.
$inputFileName = 'residents.xlsx';
 
try {
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}
 
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

for($i=3;$i<=$arrayCount;$i++){
	if(!empty($allDataInSheet[$i]["A"])) {

		//$phpDateValue = PHPExcel_Shared_Date::ExcelToPHP($allDataInSheet[$i]["H"]);
		//$bday = date('Y-m-d', $phpDateValue);

		$date = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));

		$fname = trim($allDataInSheet[$i]["A"]);
		$mname = trim($allDataInSheet[$i]["B"]);
		$lname = trim($allDataInSheet[$i]["C"]);
		$gender= trim($allDataInSheet[$i]["D"]);
		$email = trim($allDataInSheet[$i]["E"]);
		$contact = trim($allDataInSheet[$i]["F"]);
		$sitio = trim($allDataInSheet[$i]["G"]);
		$bday  = $date;
		$rinterest = trim($allDataInSheet[$i]["I"]);
		$img = trim($allDataInSheet[$i]["J"]);
		//echo $allDataInSheet[$i]["H"].' '.$bday.'<br/>';
		 
		//$sheet = $objPHPExcel->setActiveSheetIndex();
		//$maxCell = $sheet->getHighestRowAndColumn();
		//$allDataInSheet = $sheet->rangeToArray('A1:'.$maxCell['column'].$maxCell['row']);

		$query = "SELECT res_fname FROM resident WHERE res_fname = '".$fname."' and res_bday = '".$bday."'";
		$sql = mysql_query($query);
		$recResult = mysql_fetch_array($sql);
		$existName = $recResult["res_fname"];
		if($existName=="") {
			$insertTable= mysql_query("INSERT INTO resident (res_fname, res_mname, res_lname, res_gender, res_bday, res_contact, res_email, res_add_sitio, res_interest,res_img)
			  VALUES ('$fname','$mname','$lname','$gender','$bday','$contact','$email','$sitio','$rinterest','$img')");
			 
			$msg = 'Record has been added.';
		} else {
			$msg = 'Record already exist.';
		} 
	}
}
echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";
  
?>
