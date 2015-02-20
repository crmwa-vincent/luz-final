<?php

	include ("../functions.php");
	
	$where = "";
  //$result = mysql_query("SELECT res_bday FROM resident");
  //$bday = $row['res_bday'];

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
		$x = -1000;
		while($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
		  $id=$row['res_id'];
          $fname=ucfirst($row['res_fname']);
          $lname=ucfirst($row['res_lname']);
          $mname=ucfirst($row['res_mname']);
          $contact=$row['res_contact'];
          $email=$row['res_email'];
          $sitio=ucfirst($row['res_add_sitio']);
          $bday=$row['res_bday'];
          $gender = $row['res_gender'];
          $r_gender1 = $row['res_gender'] == 'male' ? 'checked' : '';
          $r_gender2 = $row['res_gender'] == 'female' ? 'checked' : '';
          $rinterest = $row['res_interest'];
          $img=$row['res_img'];
          $target = "upload/".$img;
          $imgstr = "<p><img width=\"75\" height=\"75\" ";         
          $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
          $r_interests = explode(',', $rinterest); 
                  $r_interest1 = $r_interest2 = $r_interest3 = $r_interest4 = $r_interest5 = $r_interest6 ='';
                  foreach($r_interests as $key => $value) {    
                      if($value == 'Education') $r_interest1 = 'checked';
                      if($value == 'Health Services') $r_interest2 = 'checked';
                      if($value == 'Peace and Order') $r_interest3 = 'checked';
                      if($value == 'Transportation') $r_interest4 = 'checked';
                      if($value == 'Solid Waste Management') $r_interest5 = 'checked';
                      if($value == 'Use of Barangay Facilities') $r_interest6 = 'checked';
                  }
		  
		  $output .= '<tr class="info">
                  <td><button class="btn btn-primary btn-sm" onclick="window.location=\'profile.php?fname='.$fname.'&mname='.$mname.'&id='.$id.'&lname='.$lname.'&contact='.$contact.'&img='.$img.'&email='.$email.'&sitio='.$sitio.'&bday='.$bday.'&gender='.$gender.'&rinterest='.$rinterest.'\'">' . $id . '</button></td>
                  <td>' . $imgstr .   '</td>
                  <td>' . $lname .   '</td>
                 <td>' . $fname .   '</td>
                  <td>' . $mname .   '</td> 
                  <td>' . $contact .   '</td>
                  <td>' . $sitio .   '</td>
                  <td>' . $bday .   '</td>
                  <td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
                  <div class="modal fade" id="modal-container-'.$x.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title" id="myModalLabel" align="center">
                            Edit Resident Details
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form action="action/update-action.php" role="form" method="GET" id="editForm'.$id.'">
                            <input type="hidden" name="id" value="'.$id.'">
                            <input type="hidden" name="sitio" value="'.$sitio.'">
                            <input type="hidden" name="edit" value="1" />
                            <table>
                              <tr>
                                <td></br><label for="inputFname" class="col-lg-2 control-label">Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputFname" name="fname" value="'.$fname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputMname" class="col-lg-2 control-label">Middlename:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputMname" name="mname" value="'.$mname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputLname" class="col-lg-2 control-label">Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputLname" name="lname" value="'.$lname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputEmail" class="col-lg-2 control-label">Email:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputEmail" name="email" value="'.$email.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputGender" class="col-lg-2 control-label">Gender:</label></td>
                                <div class="col-lg-10">
                                <td><input type="radio" name="gender" class="r_gen" value="male" '.$r_gender1.'>Male<br>
                                <input type="radio" name="gender" class="r_gen" value="female" '.$r_gender2.'>Female<br>
                              </tr>
                              <tr>
                                <td></br><label for="inputContact" class="col-lg-2 control-label">Contact No.:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputContact" name="contact" value="'.$contact.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputBday" class="col-lg-2 control-label">Birthday:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="date" class="form-control" id="inputBday" name="bday" value="'.$bday.'" required/></td>
                              </tr>
                                    <td></br><label for="inputinterest" class="col-lg-2 control-label">Interests:</label></td>
                                    <td><input type="checkbox" name="rinterest[]"  value="Education" '.$r_interest1.'>Education<br>
                                    <input type="checkbox" name="rinterest[]"  value="Health Services" '.$r_interest2.'>Health Services<br>
                                    <input type="checkbox" name="rinterest[]"  value="Peace and Order" '.$r_interest3.'>Peace and Order<br>
                                    <input type="checkbox" name="rinterest[]"  value="Transportation" '.$r_interest4.'>Transportation<br>
                                    <input type="checkbox" name="rinterest[]"  value="Solid Waste Management" '.$r_interest5.'>Solid Waste Management<br>
                                    <input type="checkbox" name="rinterest[]"  value="Use of Barangay Facilities" '.$r_interest6.'>Use of Barangay Facilities</td>
                                    </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit" onclick="document.getElementById(\'editForm'.$id.'\').submit();">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="id" value="'.$id.'">
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
                  $x++;
		}
	}else {
		$output = "no residents found...";
	}
	echo $output;

