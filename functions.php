
<?php
$link=mysql_connect('localhost', 'root', '');

if(!$link)
{

	die('could not connect to the database' .mysql_error());
}
	mysql_select_db('luz', $link);

 ?>
 
 <?php 
function login($username, $password)
{
  $result = mysql_query("SELECT * from admin WHERE admin_username='".$username."'");
  $result1 = mysql_query("SELECT * from clerk WHERE clerk_username='".$username."'");
  
  if($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
    if($password==$row['admin_password'])
    {
      $_SESSION['user_id']=$row['admin_id'];
      $_SESSION['username']=$row['admin_username'];
      $_SESSION['password']=$row['admin_password'];
      $_SESSION['usertype']=$row['user_type'];
      header("refresh:1; url='../home.php'");
    }
    else
    {
      echo '"Login failed! please try again!"';
       header("refresh:1; url='../index.php'");
    }
  }

  if($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
  {
    if($password==$row1['clerk_password'])
    {
      $_SESSION['user_id']=$row1['clerk_id'];
      $_SESSION['usertype']=$row1['user_type'];
      $_SESSION['username']=$row1['clerk_username'];
      $_SESSION['password']=$row1['clerk_password'];
      $_SESSION['fname']=ucfirst($row1['clerk_Fname']);
      $_SESSION['lname']=ucfirst($row1['clerk_Lname']);
      $_SESSION['bday']=$row1['clerk_Bdate'];
      $_SESSION['email']=$row1['clerk_Email'];
      $_SESSION['contact']=$row1['clerk_Contact'];
      $_SESSION['img']=$row1['cler_img'];

    header("refresh:1; url='../home.php'");
    }
    else
    {
      echo "Login failed! please try again!";
  header("refresh:1; url='../login.php'");
    }
  }  
}

function logout()
{
echo "</br></br></br></br></br>Thank you for your time, ", $_SESSION['username'];
session_destroy();

header("Refresh: 3; url=../index.php");

}

function regRes($fname,$mname,$lname,$gender,$bday,$age,$contact,$email,$sitio,$rinterest,$img)
{
 $query="INSERT INTO resident (res_fname, res_mname, res_lname, res_gender,res_bday, res_age, res_contact, res_email, res_add_sitio, res_interest, res_img)
  VALUES ('$fname','$mname','$lname','$gender','$bday', $age, '$contact','$email','$sitio','$rinterest','$img')";

  if(!mysql_query($query))
  {
    die('error sa pag insert sa resident' .mysql_error());
  }
  header("Refresh:1; url=../home1.php");

}

function regClerk($fname,$lname,$email,$contact,$bday,$uname,$pword,$img)
{
  $query="INSERT INTO clerk (clerk_Fname, clerk_Lname, clerk_Email, clerk_Contact, clerk_Bdate, clerk_username, clerk_password, user_type, cler_img)
  VALUES ('$fname','$lname', '$email', '$contact', '$bday', '$uname','$pword', 2,'$img')";

  if(!mysql_query($query))
  {
    die('error sa pag insert sa clerk' . mysql_error());
  }
  header("refresh:1;url='../home.php'");
  
}

function regProg($ename,$edates, $edatee, $evenue, $eparts, $ecat, $edesc, $esponsors, $ebudget, $estat, $epartcat)
{
  if($edatee<$edates)
  {
    echo 'Date end must be later than date start';
    header("refresh:2; url='../program.php'");
    die();  
  }
  $id = '';
  $query="INSERT INTO programs (event_name, event_startsched, event_endsched, event_venue, event_category, event_desc, event_sponsors, event_budget, event_status, event_part_cat)
  VALUES ('$ename', '$edates', '$edatee', '$evenue', '$ecat', '$edesc', '$esponsors', '$ebudget', '$estat', '$epartcat')";

  if(!mysql_query($query))
  {
    die('error sa pag insert sa program' . mysql_error());
  }
  $id = mysql_insert_id();
  regParts($eparts,$id, 1);
  header("refresh:2;url='../program.php'");
  
}

function regParts($eparts,$id, $flag){
  if(!empty($eparts) && !empty($id)){
    if($flag == 1){ // insert
      foreach ($eparts as $key => $value) {
          $query="INSERT INTO residents_programs (res_id, prog_id, checked) VALUES ('$value', '$id', 0)";
          mysql_query($query);
      }  
    }
    if($flag == 2){ //update
      $query="UPDATE residents_programs SET checked = 0 where prog_id = '$id'";
      mysql_query($query);
       foreach ($eparts as $key => $value) {
          $query1="UPDATE residents_programs SET checked = 1 where res_id = '$value' AND prog_id = '$id'";
          mysql_query($query1);
      }  
    }
  }
}

/*function display_register()
{
$x = -1000;
$result = mysql_query("SELECT * FROM resident");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
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
                  
                

                  echo '<tr class="info">';
                  echo '<form action="profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                 
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
                            <input type="hidden" name="sitio" value="'.$sitio.'">
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
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="id" value="'.$id.'">
                  
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }

                echo "</tbody></table>";
              
}
function display_register_senior()
{
$x = -1000;
$result = mysql_query("SELECT * FROM resident");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';
      
          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['res_id'];
                  $fname=ucfirst($row['res_fname']);
                  $lname=ucfirst($row['res_lname']);
                  $mname=ucfirst($row['res_mname']);
                  $contact=$row['res_contact'];
                  $email=$row['res_email'];
                  $sitio=ucfirst($row['res_add_sitio']);
                  $bday=$row['res_bday'];
                  $mfname=ucfirst($row['res_m_fname']);
                  $mlname=ucfirst($row['res_m_lname']);
                  $ffname=ucfirst($row['res_f_fname']);
                  $flname=ucfirst($row['res_f_lname']);
                  $gender = $row['res_gender'];
                  $rinterest = $row['res_interest'];
                  $img=$row['res_img'];
                  $target = "upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
                  $bday1 = explode("-",$bday);
                  $age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
                  

                

                  echo '<tr class="info">';
                  if($age>='60')
                  {
                  echo '<form action="profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$mfname.'" name="mfname">
                  <input type="hidden" value="'.$mlname.'" name="mlname">
                  <input type="hidden" value="'.$ffname.'" name="ffname">
                  <input type="hidden" value="'.$flname.'" name="flname">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  

                 
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
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
                                <td></br><label for="inputContact" class="col-lg-2 control-label">Contact No.:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputContact" name="contact" value="'.$contact.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputBday" class="col-lg-2 control-label">Birthday:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="date(yyyy-mm-dd)" class="form-control" id="inputBday" name="bday" value="'.$bday.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmfname" class="col-lg-2 control-label">Mother Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmfname" name="mfname" value="'.$mfname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmlname" class="col-lg-2 control-label">Mother Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmlname" name="mlname" value="'.$mlname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputffname" class="col-lg-2 control-label">Father Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputffname" name="ffname" value="'.$ffname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputflname" class="col-lg-2 control-label">Father Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputflname" name="flname" value="'.$flname.'" required/></td>
                              </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="fname" value="'.$fname.'">
                  <input type="hidden" name="lname" value="'.$lname.'">
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }
}
                echo "</tbody></table>";
              
}

function display_register_youth()
{
$x = -1000;
$result = mysql_query("SELECT * FROM resident");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';
      
          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['res_id'];
                  $fname=ucfirst($row['res_fname']);
                  $lname=ucfirst($row['res_lname']);
                  $mname=ucfirst($row['res_mname']);
                  $contact=$row['res_contact'];
                  $email=$row['res_email'];
                  $sitio=ucfirst($row['res_add_sitio']);
                  $bday=$row['res_bday'];
                  $mfname=ucfirst($row['res_m_fname']);
                  $mlname=ucfirst($row['res_m_lname']);
                  $ffname=ucfirst($row['res_f_fname']);
                  $flname=ucfirst($row['res_f_lname']);
                  $gender = $row['res_gender'];
                  $rinterest = $row['res_interest'];
                  $img=$row['res_img'];
                  $target = "upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
                  $bday1 = explode("-",$bday);
                  $age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
                  

                 

                  echo '<tr class="info">';
                  if($age>='15' && $age<='25')
                  {
                  echo '<form action="profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$mfname.'" name="mfname">
                  <input type="hidden" value="'.$mlname.'" name="mlname">
                  <input type="hidden" value="'.$ffname.'" name="ffname">
                  <input type="hidden" value="'.$flname.'" name="flname">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  


                 
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
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
                                <td></br><label for="inputContact" class="col-lg-2 control-label">Contact No.:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputContact" name="contact" value="'.$contact.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputBday" class="col-lg-2 control-label">Birthday:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="date(yyyy-mm-dd)" class="form-control" id="inputBday" name="bday" value="'.$bday.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmfname" class="col-lg-2 control-label">Mother Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmfname" name="mfname" value="'.$mfname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmlname" class="col-lg-2 control-label">Mother Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmlname" name="mlname" value="'.$mlname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputffname" class="col-lg-2 control-label">Father Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputffname" name="ffname" value="'.$ffname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputflname" class="col-lg-2 control-label">Father Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputflname" name="flname" value="'.$flname.'" required/></td>
                              </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="fname" value="'.$fname.'">
                  <input type="hidden" name="lname" value="'.$lname.'">
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }
}
                echo "</tbody></table>";
              
}

function display_register_children()
{
$x = -1000;
$result = mysql_query("SELECT * FROM resident");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';
      
          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['res_id'];
                  $fname=ucfirst($row['res_fname']);
                  $lname=ucfirst($row['res_lname']);
                  $mname=ucfirst($row['res_mname']);
                  $contact=$row['res_contact'];
                  $email=$row['res_email'];
                  $sitio=ucfirst($row['res_add_sitio']);
                  $bday=$row['res_bday'];
                  $mfname=ucfirst($row['res_m_fname']);
                  $mlname=ucfirst($row['res_m_lname']);
                  $ffname=ucfirst($row['res_f_fname']);
                  $flname=ucfirst($row['res_f_lname']);
                  $gender = $row['res_gender'];
                  $rinterest = $row['res_interest'];
                  $img=$row['res_img'];
                  $target = "upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
                  $bday1 = explode("-",$bday);
                  $age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
                  

                 

                  echo '<tr class="info">';
                  if($age<'15' )
                  {
                  echo '<form action="profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$mfname.'" name="mfname">
                  <input type="hidden" value="'.$mlname.'" name="mlname">
                  <input type="hidden" value="'.$ffname.'" name="ffname">
                  <input type="hidden" value="'.$flname.'" name="flname">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  


                 
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
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
                                <td></br><label for="inputContact" class="col-lg-2 control-label">Contact No.:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputContact" name="contact" value="'.$contact.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputBday" class="col-lg-2 control-label">Birthday:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="date(yyyy-mm-dd)" class="form-control" id="inputBday" name="bday" value="'.$bday.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmfname" class="col-lg-2 control-label">Mother Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmfname" name="mfname" value="'.$mfname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmlname" class="col-lg-2 control-label">Mother Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmlname" name="mlname" value="'.$mlname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputffname" class="col-lg-2 control-label">Father Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputffname" name="ffname" value="'.$ffname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputflname" class="col-lg-2 control-label">Father Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputflname" name="flname" value="'.$flname.'" required/></td>
                              </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="fname" value="'.$fname.'">
                  <input type="hidden" name="lname" value="'.$lname.'">
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }
}
                echo "</tbody></table>";
              
}


function display_register_men()
{
$x = -1000;
$result = mysql_query("SELECT * FROM resident WHERE resident.res_gender = 'male'");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';
      
          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['res_id'];
                  $fname=ucfirst($row['res_fname']);
                  $lname=ucfirst($row['res_lname']);
                  $mname=ucfirst($row['res_mname']);
                  $contact=$row['res_contact'];
                  $email=$row['res_email'];
                  $sitio=ucfirst($row['res_add_sitio']);
                  $bday=$row['res_bday'];
                  $mfname=ucfirst($row['res_m_fname']);
                  $mlname=ucfirst($row['res_m_lname']);
                  $ffname=ucfirst($row['res_f_fname']);
                  $flname=ucfirst($row['res_f_lname']);
                  $gender = $row['res_gender'];
                  $rinterest = $row['res_interest'];
                  $img=$row['res_img'];
                  $target = "upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
                  $bday1 = explode("-",$bday);
                  $age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
                  

                 

                  echo '<tr class="info">';
                  if($age>'25' && $age<'60')
                  {
                  echo '<form action="profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$mfname.'" name="mfname">
                  <input type="hidden" value="'.$mlname.'" name="mlname">
                  <input type="hidden" value="'.$ffname.'" name="ffname">
                  <input type="hidden" value="'.$flname.'" name="flname">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  


                 
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
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
                                <td></br><label for="inputContact" class="col-lg-2 control-label">Contact No.:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputContact" name="contact" value="'.$contact.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputBday" class="col-lg-2 control-label">Birthday:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="date(yyyy-mm-dd)" class="form-control" id="inputBday" name="bday" value="'.$bday.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmfname" class="col-lg-2 control-label">Mother Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmfname" name="mfname" value="'.$mfname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmlname" class="col-lg-2 control-label">Mother Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmlname" name="mlname" value="'.$mlname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputffname" class="col-lg-2 control-label">Father Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputffname" name="ffname" value="'.$ffname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputflname" class="col-lg-2 control-label">Father Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputflname" name="flname" value="'.$flname.'" required/></td>
                              </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="fname" value="'.$fname.'">
                  <input type="hidden" name="lname" value="'.$lname.'">
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }
}
                echo "</tbody></table>";
              
}

function display_register_women()
{
$x = -1000;
$result = mysql_query("SELECT * FROM resident WHERE resident.res_gender = 'female'");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';
      
          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['res_id'];
                  $fname=ucfirst($row['res_fname']);
                  $lname=ucfirst($row['res_lname']);
                  $mname=ucfirst($row['res_mname']);
                  $contact=$row['res_contact'];
                  $email=$row['res_email'];
                  $sitio=ucfirst($row['res_add_sitio']);
                  $bday=$row['res_bday'];
                  $mfname=ucfirst($row['res_m_fname']);
                  $mlname=ucfirst($row['res_m_lname']);
                  $ffname=ucfirst($row['res_f_fname']);
                  $flname=ucfirst($row['res_f_lname']);
                  $gender = $row['res_gender'];
                  $rinterest = $row['res_interest'];
                  $img=$row['res_img'];
                  $target = "upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
                  $bday1 = explode("-",$bday);
                  $age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
                  

                 

                  echo '<tr class="info">';
                  if($age>'25' && $age<'60')
                  {
                  echo '<form action="profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$mfname.'" name="mfname">
                  <input type="hidden" value="'.$mlname.'" name="mlname">
                  <input type="hidden" value="'.$ffname.'" name="ffname">
                  <input type="hidden" value="'.$flname.'" name="flname">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  


                 
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
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
                                <td></br><label for="inputContact" class="col-lg-2 control-label">Contact No.:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputContact" name="contact" value="'.$contact.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputBday" class="col-lg-2 control-label">Birthday:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="date(yyyy-mm-dd)" class="form-control" id="inputBday" name="bday" value="'.$bday.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmfname" class="col-lg-2 control-label">Mother Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmfname" name="mfname" value="'.$mfname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputmlname" class="col-lg-2 control-label">Mother Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputmlname" name="mlname" value="'.$mlname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputffname" class="col-lg-2 control-label">Father Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputffname" name="ffname" value="'.$ffname.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputflname" class="col-lg-2 control-label">Father Lastname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputflname" name="flname" value="'.$flname.'" required/></td>
                              </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="fname" value="'.$fname.'">
                  <input type="hidden" name="lname" value="'.$lname.'">
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }
}
                echo "</tbody></table>";
              
}



function display_register()
{
$x = -1000;
$result = mysql_query("SELECT * FROM resident");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
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
                  
                

                  echo '<tr class="info">';
                  echo '<form action="profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                 
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
                            <input type="hidden" name="sitio" value="'.$sitio.'">
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
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="id" value="'.$id.'">
                  
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }

                echo "</tbody></table>";
 }
*/
function display_searchsponsor($sponsorname)
  {
  echo'
<div class="container shadow">
  <div class="row clearfix">
   <div class="col-md-12 column">
      
                      <h1><center>Sponsor\'s Programs</h1>
  <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>PROGRAM ID.</th>
          <th>Program Name</th>
          <th>Venue</th>
          <th>Schedule Start</th>
          <th>Schedule End</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';



  $result = mysql_query("SELECT * from programs");
    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
      {
            $id = $row['event_id'];
            $sponsor = $row['event_sponsors'];
            $edates = $row['event_startsched'];
            $edatee = $row['event_endsched'];
            $evenue = $row['event_venue'];
            $ename = $row ['event_name'];
            $sponsors = explode(',',$sponsor);
            $i=0;
            foreach ($sponsors as $key => $value);
            
              for($i=0;$i<count($sponsors);$i++)
                {
                  //echo $sponsors[$i];
                  if ($sponsorname == $sponsors[$i])
                   {
                    echo '<tr class="info">       
                          <form action="../progdetails.php" method="POST">
                          <input type="hidden" value="'.$ename.'" name="ename">
                          <input type="hidden" value="'.$evenue.'" name="evenue">
                          <input type="hidden" value="'.$edates.'" name="edates">
                          <input type="hidden" value="'.$edatee.'" name="edatee">
                          <input type="hidden" value="'.$id.'" name="id">
                          <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                                 
                          echo "<td>" . $ename . "</td>"; 
                          echo "<td>" . $evenue . "</td>";
                          echo "<td>" . $edates ."</td>";
                          echo "<td>" . $edatee ."</td>";                
                             
                        
               }
                }
              }
               echo "</tbody></table>";
                       
              echo'</div></div>';
          }

function display_search($fname, $lname, $bday)
{
  $x = 1000;
  $result = mysql_query("SELECT * FROM resident WHERE res_fname LIKE '".$fname."' && res_lname LIKE '".$lname."' && res_bday LIKE '".$bday."' ");

  echo '
<div class="container shadow">
  <div class="row clearfix">
    <div class="col-md-12 column">
      
  <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>RES ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Middle Name</th>
          <th>Contact Number</th>
          <th>Sitio</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

      while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
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
                  $target = "../upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
                  $bday1 = explode("-",$bday);
                  $age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
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

                

                  echo '<tr class="info">';
                  
                  echo '<form action="../profile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$mname.'" name="mname">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$sitio.'" name="sitio">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <input type="hidden" value="'.$gender.'" name="gender">
                  <input type="hidden" value="'.$rinterest.'" name="rinterest">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";
                  echo "<td>" . $mname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $sitio ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
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
                          <form action="update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
                            <input type="hidden" name="sitio" value="'.$sitio.'">
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
                                <tr>    <td></br><label for="inputinterest" class="col-lg-2 control-label">Interests:</label></td>
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
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="id" value="'.$id.'">
                  <button name="delete_resident" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
              }

                echo "</tbody></table>";
                echo'<form action="../home.php" ><button id="back"  class="btn btn-default">Back</button></form>';
              
}




function display_clerks()
{
$x = -1000;
$result = mysql_query("SELECT * FROM clerk");
echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>CLERK ID.</th>
          <th></th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Contact Number</th>
          <th>Username</th>
          <th>Email</th>
          <th>Birthday</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['clerk_id'];
                  $lname=ucfirst($row['clerk_Lname']);
                  $fname=ucfirst($row['clerk_Fname']);
                  $contact=$row['clerk_Contact'];
                  $uname=$row['clerk_username'];
                  $email=$row['clerk_Email'];
                  $bday=$row['clerk_Bdate'];
                  $img=$row['cler_img'];
                  $target = "upload/".$img;
                  $imgstr = "<p><img width=\"75\" height=\"75\" ";         
                  $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";

                  echo '<tr class="info">';
                  echo '<form action="clerkprofile.php" method="GET">
                  <input type="hidden" value="'.$fname.'" name="fname">
                  <input type="hidden" value="'.$lname.'" name="lname">
                  <input type="hidden" value="'.$contact.'" name="contact">
                  <input type="hidden" value="'.$id.'" name="id">
                  <input type="hidden" value="'.$uname.'" name="uname"> 
                  <input type="hidden" value="'.$img.'" name="img">                 
                  <input type="hidden" value="'.$email.'" name="email">
                  <input type="hidden" value="'.$bday.'" name="bday">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  
                  echo '<td>' . $imgstr .   '</td>';
                  echo "<td>" . $lname . "</td>"; 
                  echo "<td>" . $fname . "</td>";  
                  echo "<td>" . $contact . "</td>";
                  echo "<td>" . $uname ."</td>";
                  echo "<td>" . $email ."</td>";
                  echo "<td>" . $bday ."</td>";
                  echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
                  <div class="modal fade" id="modal-container-'.$x.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title" id="myModalLabel" align="center">
                            Edit Barangay Clerk Details
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
                            <table>
                              <tr>
                                <td></br><label for="inputFname" class="col-lg-2 control-label">Firstname:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputFname" name="fname" value="'.$fname.'" required/></td>
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
                                <td></br><label for="inputContact" class="col-lg-2 control-label">Contact No.:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputContact" name="contact" value="'.$contact.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputBday" class="col-lg-2 control-label">Birthday:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="date(yyyy-mm-dd)" class="form-control" id="inputBday" name="bday" value="'.$bday.'" required/></td>
                              </tr>
                               <tr>
                                <td></br><label for="inputUname" class="col-lg-2 control-label">Username:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputUname" name="uname" value="'.$uname.'" required/></td>
                              </tr>
                            
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="edit_clerk">Submit</button>
                          </form></td>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="fname" value="'.$fname.'">
                  <input type="hidden" name="lname" value="'.$lname.'">
                  <button name="delete_clerk" class="btn btn-danger btn-sm">Delete</button></td></form>';
              $x++;
              }

                echo "</tbody></table>";
              
}

function display_past()
{
if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2 || isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
{
$x = -1000;
$date1 = new datetime();
$date1 = date("y-m-d h:i:a");
$today = date("y-m-d");
$result = mysql_query("SELECT * FROM programs WHERE event_startsched < '$date1' && event_status != 2 ORDER BY event_startsched");

echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>PROGRAM ID.</th>
          <th>Program Name</th>
          <th>Venue</th>
          <th>Schedule Start</th>
          <th>Schedule End</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {

                  $id=$row['event_id'];
                  $output = "";
                  $ename=ucfirst($row['event_name']);
                  $date1 = new datetime();
                  $evenue=ucfirst($row['event_venue']);
                  $edates=$row['event_startsched'];
                  $edates=strtotime($edates);
                  $edates=date("y-m-d h:i:a",$edates);
                  $date1=date("y-m-d");
                  $edatee=$row['event_endsched'];
                  $edatee=strtotime($edatee);
                  $edatee=date("y-m-d h:i:a",$edatee);
                  $edesc=$row['event_desc'];
                  $ebudget=$row['event_budget'];
                  $esponsors=$row['event_sponsors'];
                  $ecat1 = $row['event_category'] == 'Education' ? 'checked' : '';
                  $ecat2 = $row['event_category'] == 'Health Services' ? 'checked' : '';
                  $ecat3 = $row['event_category'] == 'Peace and Order' ? 'checked' : '';
                  $ecat4 = $row['event_category'] == 'Transportation' ? 'checked' : '';
                  $ecat5 = $row['event_category'] == 'Solid Waste Management' ? 'checked' : '';
                  $ecat6 = $row['event_category'] == 'Use of Barangay Facilities' ? 'checked' : '';
                  $epartcats = explode(',', $row['event_part_cat']); 
                  $estat1 = $estat2 = $estat3 = '';
                  $estat1 = $row['event_status'] == '1' ? 'checked' : '';
                  $estat2 = $row['event_status'] == '2' ? 'checked' : '';
                  $estat3 = $row['event_status'] == '3' ? 'checked' : '';
                  $epartcat1 = $epartcat2 = $epartcat3 = $epartcat4 = $epartcat5 = '';
                  foreach($epartcats as $key => $value) {    
                      if($value == 'Seniors') $epartcat1 = 'checked';
                      if($value == 'Youth') $epartcat2 = 'checked';
                      if($value == 'Children') $epartcat3 = 'checked';
                      if($value == 'Women') $epartcat4 = 'checked';
                      if($value == 'Men') $epartcat5 = 'checked'; 
                  }

                                   
                  // get participants from residents_programs table
                  $result2 = mysql_query("SELECT * FROM residents_programs where prog_id = '$id'");

                  while($row1 = mysql_fetch_array($result2,MYSQL_ASSOC)){

                    $res_id = $row1['res_id'];
                    $sql    = "SELECT * FROM resident WHERE res_id = '$res_id' ORDER BY res_lname"; 
                    $res    = mysql_query($sql);
                    $rows   = mysql_num_rows($res);
                    if($rows >= 1) {
                      while($row2 = mysql_fetch_array($res,MYSQL_ASSOC)) {
                        $output .= '<input type="checkbox" name="participants[]" id="participants" value="'.$row2['res_id'].'" checked/> '.$row2['res_lname'].', '.$row2['res_fname'].'<br/>';
                      }
                    }else {
                      $output = "no residents found...";
                    }
                  }

                  echo '<tr class="info">

                  <form action="progdetails.php" method="POST">
                  <input type="hidden" value="'.$ename.'" name="ename">
                  <input type="hidden" value="'.$evenue.'" name="evenue">
                  <input type="hidden" value="'.$edates.'" name="edates">
                  <input type="hidden" value="'.$edatee.'" name="edatee">
                  <input type="hidden" value="'.$id.'" name="id">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td>";                
                  echo '<td><button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>';
                  echo '<div class="modal fade" id="modal-container-'.$x.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title" id="myModalLabel" align="center">
                            Edit Program Details
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form action="action/update-action.php" role="form" method="POST" id="editForm">
                            <input type="hidden" name="eid" value="'.$id.'">
                            <table>
                              <tbody>
                                <tr><td>Program Name: </td><td><input type="text" class="form-control" placeholder="Enter Program Name" name="ename" value="'.$ename.'" required/></td></tr>
                                <tr><td>Program Venue: </td><td><input type="text" class="form-control" placeholder="Enter Venue" name="evenue" value="'.$evenue.'" required/></td></tr>
                                <tr><td>Program Schedule Start: </td><td><input type="datetime" class="form-control" name="edates" placeholder="" value="'.$edates.'" required/></td></tr>
                                <tr><td>Program Schedule End: </td><td><input type="datetime" class="form-control" name="edatee" placeholder=" " value="'.$edatee.'" required/></td></tr>
                                <tr><td>Program Category: </td><td><input type="radio" name="event_category" class="prog_cat" value="Education" '.$ecat1.'>Education<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Health Services" '.$ecat2.'>Health Services<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Peace and Order" '.$ecat3.'>Peace and Order<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Transportation" '.$ecat4.'>Transportation<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Solid Waste Management" '.$ecat5.'>Solid Waste Management<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Use of Barangay Facilities" '.$ecat6.'>Use of Barangay Facilities</td></tr>
                                <tr><td>Program Participants Category: </td> <td><input type="checkbox" name="event_part_cat[]" class="part_cat" value="Seniors" '.$epartcat1.'>Seniors<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Youth" '.$epartcat2.'>Youth<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Children" '.$epartcat3.'>Children<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Women" '.$epartcat4.'>Women<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Men" '.$epartcat5.'>Men</td></tr>
                                <tr><td>Program Participants: </td> <td><div class="loadingDiv"><img src="img/loading.gif" /></div><div class="participants">'.$output.'</div></td></tr>
                                <tr><td>Program Description: </td> <td><textarea id="event_desc" name="event_desc" style="width: 400px; height: 100px;">
                                              '.$edesc.'
                                              </textarea>
                                              
                                    <tr><td>Program Budget: </td> <td><script type="text/javascript">
                                              function isNumberKey(evt)
                                                  {
                                                     var charCode = (evt.which) ? evt.which : evt.keyCode;
                                                     if (charCode != 46 && charCode > 31 
                                                       && (charCode < 48 || charCode > 57))
                                                        return false;

                                                     return true;
                                                  }
                                              </script>
                                              <input id="event_budget" onkeypress="return isNumberKey(event)" type="text" name="event_budget" value="'.$ebudget.'"></td></tr>          
                                    <tr><td>Program Sponsors: </td> <td><textarea id="event_sponsors" name="event_sponsors" style="width: 400px; height: 100px;">
                                              '.$esponsors.'
                                              </textarea>
                                                      
                                    <tr><td>Status: </td><td><input type="radio" name="event_status" value="1" '.$estat1.'>Active<br>
                                                             <input type="radio" name="event_status" value="2" '.$estat2.'>Canceled<br>
                                                             <input type="radio" name="event_status" value="3" '.$estat3.'>Completed</td></tr>                      
                                </tbody>
                            
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button class="btn btn-primary" name="edit_program">Submit</button>
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="ename" value="'.$ename.'">
                  <input type="hidden" name="edates" value="'.$edates.'">
                  <input type="hidden" name="edatee" value="'.$edatee.'">
                  <input type="hidden" name="evenue" value="'.$evenue.'">
                  <button name="delete_program" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
          
                echo "</tbody></table>";
           } }  
else{
                   $x = -1000;
          $date1 = new datetime();
        $date1 = date("y-m-d h:i:a");
        $today = date("y-m-d");
        $result = mysql_query("SELECT * FROM programs WHERE event_startsched < '$date1' && event_status != 2 ORDER BY event_startsched");       

        echo '<table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>PROGRAM ID.</th>
                  <th>Program Name</th>
                  <th>Venue</th>
                  <th>Schedule Start</th>
                  <th>Schedule End</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';       

                  while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
                    {       

                          $id=$row['event_id'];
                          $output = "";
                          $ename=ucfirst($row['event_name']);
                          $date1 = new datetime();
                          $evenue=ucfirst($row['event_venue']);
                          $edates=$row['event_startsched'];
                          $edates=strtotime($edates);
                          $edates=date("y-m-d h:i:a",$edates);
                          $date1=date("y-m-d");
                          $edatee=$row['event_endsched'];
                          $edatee=strtotime($edatee);
                          $edatee=date("y-m-d h:i:a",$edatee);
                                 

                                           
                          // get participants from residents_programs table
                         
                          echo '<tr class="info">       

                          <input type="hidden" value="'.$ename.'" name="ename">
                          <input type="hidden" value="'.$evenue.'" name="evenue">
                          <input type="hidden" value="'.$edates.'" name="edates">
                          <input type="hidden" value="'.$edatee.'" name="edatee">
                          <input type="hidden" value="'.$id.'" name="id">
                          <td>' . $id . '</td>'; 
                          echo "<td>" . $ename . "</td>"; 
                          echo "<td>" . $evenue . "</td>";
                          echo "<td>" . $edates ."</td>";
                          echo "<td>" . $edatee ."</td>";                
                          }
                        echo "</tbody></table>";
                   
                   }
}
//else





function display_present()
{
if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2 || isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
{

$x = -1000;
$date1 = new datetime();
$date1 = date("y-m-d h:i:a");
$today = date("y-m-d");
$result = mysql_query("SELECT * FROM programs WHERE event_startsched LIKE '%$today%' && event_status = 1 ORDER BY event_startsched");

echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>PROGRAM ID.</th>
          <th>Program Name</th>
          <th>Venue</th>
          <th>Schedule Start</th>
          <th>Schedule End</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {

                  $id=$row['event_id'];
                  $output = "";
                  $ename=ucfirst($row['event_name']);
                  $date1 = new datetime();
                  $evenue=ucfirst($row['event_venue']);
                  $edates=$row['event_startsched'];
                  $edates=strtotime($edates);
                  $edates=date("y-m-d h:i:a",$edates);
                  $date1=date("y-m-d");
                  $edatee=$row['event_endsched'];
                  $edatee=strtotime($edatee);
                  $edatee=date("y-m-d h:i:a",$edatee);
                  $edesc=$row['event_desc'];
                  $ebudget=$row['event_budget'];
                  $esponsors=$row['event_sponsors'];
                  $ecat1 = $row['event_category'] == 'Education' ? 'checked' : '';
                  $ecat2 = $row['event_category'] == 'Health Services' ? 'checked' : '';
                  $ecat3 = $row['event_category'] == 'Peace and Order' ? 'checked' : '';
                  $ecat4 = $row['event_category'] == 'Transportation' ? 'checked' : '';
                  $ecat5 = $row['event_category'] == 'Solid Waste Management' ? 'checked' : '';
                  $ecat6 = $row['event_category'] == 'Use of Barangay Facilities' ? 'checked' : '';
                  $epartcats = explode(',', $row['event_part_cat']); 
                  $estat1 = $estat2 = $estat3 = '';
                  $estat1 = $row['event_status'] == '1' ? 'checked' : '';
                  $estat2 = $row['event_status'] == '2' ? 'checked' : '';
                  $estat3 = $row['event_status'] == '3' ? 'checked' : '';
                  $epartcat1 = $epartcat2 = $epartcat3 = $epartcat4 = $epartcat5 = '';
                  foreach($epartcats as $key => $value) {    
                      if($value == 'Seniors') $epartcat1 = 'checked';
                      if($value == 'Youth') $epartcat2 = 'checked';
                      if($value == 'Children') $epartcat3 = 'checked';
                      if($value == 'Women') $epartcat4 = 'checked';
                      if($value == 'Men') $epartcat5 = 'checked'; 
                  }

                                   
                  // get participants from residents_programs table
                  $result2 = mysql_query("SELECT * FROM residents_programs where prog_id = '$id'");

                  while($row1 = mysql_fetch_array($result2,MYSQL_ASSOC)){

                    $res_id = $row1['res_id'];
                    $sql    = "SELECT * FROM resident WHERE res_id = '$res_id' ORDER BY res_lname"; 
                    $res    = mysql_query($sql);
                    $rows   = mysql_num_rows($res);
                    if($rows >= 1) {
                      while($row2 = mysql_fetch_array($res,MYSQL_ASSOC)) {
                        $output .= '<input type="checkbox" name="participants[]" id="participants" value="'.$row2['res_id'].'" checked/> '.$row2['res_lname'].', '.$row2['res_fname'].'<br/>';
                      }
                    }else {
                      $output = "no residents found...";
                    }
                  }

                  echo '<tr class="info">

                  <form action="progdetails.php" method="POST">
                  <input type="hidden" value="'.$ename.'" name="ename">
                  <input type="hidden" value="'.$evenue.'" name="evenue">
                  <input type="hidden" value="'.$edates.'" name="edates">
                  <input type="hidden" value="'.$edatee.'" name="edatee">
                  <input type="hidden" value="'.$id.'" name="id">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td>";                
                  echo '<td><button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>';
                  echo '<div class="modal fade" id="modal-container-'.$x.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title" id="myModalLabel" align="center">
                            Edit Program Details
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form action="action/update-action.php" role="form" method="POST" id="editForm">
                            <input type="hidden" name="eid" value="'.$id.'">
                            <table>
                              <tbody>
                                <tr><td>Program Name: </td><td><input type="text" class="form-control" placeholder="Enter Program Name" name="ename" value="'.$ename.'" required/></td></tr>
                                <tr><td>Program Venue: </td><td><input type="text" class="form-control" placeholder="Enter Venue" name="evenue" value="'.$evenue.'" required/></td></tr>
                                <tr><td>Program Schedule Start: </td><td><input type="datetime" class="form-control" name="edates" placeholder="" value="'.$edates.'" required/></td></tr>
                                <tr><td>Program Schedule End: </td><td><input type="datetime" class="form-control" name="edatee" placeholder=" " value="'.$edatee.'" required/></td></tr>
                                <tr><td>Program Category: </td><td><input type="radio" name="event_category" class="prog_cat" value="Education" '.$ecat1.'>Education<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Health Services" '.$ecat2.'>Health Services<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Peace and Order" '.$ecat3.'>Peace and Order<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Transportation" '.$ecat4.'>Transportation<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Solid Waste Management" '.$ecat5.'>Solid Waste Management<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Use of Barangay Facilities" '.$ecat6.'>Use of Barangay Facilities</td></tr>
                                <tr><td>Program Participants Category: </td> <td><input type="checkbox" name="event_part_cat[]" class="part_cat" value="Seniors" '.$epartcat1.'>Seniors<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Youth" '.$epartcat2.'>Youth<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Children" '.$epartcat3.'>Children<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Women" '.$epartcat4.'>Women<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Men" '.$epartcat5.'>Men</td></tr>
                                <tr><td>Program Participants: </td> <td><div class="loadingDiv"><img src="img/loading.gif" /></div><div class="participants">'.$output.'</div></td></tr>
                                <tr><td>Program Description: </td> <td><textarea id="event_desc" name="event_desc" style="width: 400px; height: 100px;">
                                              '.$edesc.'
                                              </textarea>
                                              
                                    <tr><td>Program Budget: </td> <td><script type="text/javascript">
                                              function isNumberKey(evt)
                                                  {
                                                     var charCode = (evt.which) ? evt.which : evt.keyCode;
                                                     if (charCode != 46 && charCode > 31 
                                                       && (charCode < 48 || charCode > 57))
                                                        return false;

                                                     return true;
                                                  }
                                              </script>
                                              <input id="event_budget" onkeypress="return isNumberKey(event)" type="text" name="event_budget" value="'.$ebudget.'"></td></tr>          
                                    <tr><td>Program Sponsors: </td> <td><textarea id="event_sponsors" name="event_sponsors" style="width: 400px; height: 100px;">
                                              '.$esponsors.'
                                              </textarea>
                                                      
                                    <tr><td>Status: </td><td><input type="radio" name="event_status" value="1" '.$estat1.'>Active<br>
                                                             <input type="radio" name="event_status" value="2" '.$estat2.'>Canceled<br>
                                                             <input type="radio" name="event_status" value="3" '.$estat3.'>Completed</td></tr>                      
                                </tbody>
                            
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button class="btn btn-primary" name="edit_program">Submit</button>
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="ename" value="'.$ename.'">
                  <input type="hidden" name="edates" value="'.$edates.'">
                  <input type="hidden" name="edatee" value="'.$edatee.'">
                  <input type="hidden" name="evenue" value="'.$evenue.'">
                  <button name="delete_program" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
          }
                echo "</tbody></table>";
             
             } 
    else{
                   $x = -1000;
          $date1 = new datetime();
        $date1 = date("y-m-d h:i:a");
        $today = date("y-m-d");
        $result = mysql_query("SELECT * FROM programs WHERE event_startsched LIKE '$date1' && event_status != 2 ORDER BY event_startsched");       

        echo '<table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>PROGRAM ID.</th>
                  <th>Program Name</th>
                  <th>Venue</th>
                  <th>Schedule Start</th>
                  <th>Schedule End</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';       

                  while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
                    {       

                          $id=$row['event_id'];
                          $output = "";
                          $ename=ucfirst($row['event_name']);
                          $date1 = new datetime();
                          $evenue=ucfirst($row['event_venue']);
                          $edates=$row['event_startsched'];
                          $edates=strtotime($edates);
                          $edates=date("y-m-d h:i:a",$edates);
                          $date1=date("y-m-d");
                          $edatee=$row['event_endsched'];
                          $edatee=strtotime($edatee);
                          $edatee=date("y-m-d h:i:a",$edatee);
                                 

                                           
                          // get participants from residents_programs table
                         
                          echo '<tr class="info">       

                          <input type="hidden" value="'.$ename.'" name="ename">
                          <input type="hidden" value="'.$evenue.'" name="evenue">
                          <input type="hidden" value="'.$edates.'" name="edates">
                          <input type="hidden" value="'.$edatee.'" name="edatee">
                          <input type="hidden" value="'.$id.'" name="id">
                          <td>' . $id . '</td>'; 
                          echo "<td>" . $ename . "</td>"; 
                          echo "<td>" . $evenue . "</td>";
                          echo "<td>" . $edates ."</td>";
                          echo "<td>" . $edatee ."</td>";                
                        }  
                        echo "</tbody></table>";
                   } 
                   
}

function display_incoming()
{
if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2 || isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
{
$x = -1000;
$date1 = new datetime();
$date1 = date("y-m-d");
$today = date("y-m-d");
$result = mysql_query("SELECT * FROM programs WHERE event_startsched > '$date1' && event_status = 1 ORDER BY event_startsched");

echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>PROGRAM ID.</th>
          <th>Program Name</th>
          <th>Venue</th>
          <th>Schedule Start</th>
          <th>Schedule End</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {

                  $id=$row['event_id'];
                  $output = "";
                  $ename=ucfirst($row['event_name']);
                  $date1 = new datetime();
                  $evenue=ucfirst($row['event_venue']);
                  $edates=$row['event_startsched'];
                  $edates=strtotime($edates);
                  $edates=date("y-m-d h:i:a",$edates);
                  $date1=date("y-m-d");
                  $edatee=$row['event_endsched'];
                  $edatee=strtotime($edatee);
                  $edatee=date("y-m-d h:i:a",$edatee);
                  $edesc=$row['event_desc'];
                  $ebudget=$row['event_budget'];
                  $esponsors=$row['event_sponsors'];
                  $ecat1 = $row['event_category'] == 'Education' ? 'checked' : '';
                  $ecat2 = $row['event_category'] == 'Health Services' ? 'checked' : '';
                  $ecat3 = $row['event_category'] == 'Peace and Order' ? 'checked' : '';
                  $ecat4 = $row['event_category'] == 'Transportation' ? 'checked' : '';
                  $ecat5 = $row['event_category'] == 'Solid Waste Management' ? 'checked' : '';
                  $ecat6 = $row['event_category'] == 'Use of Barangay Facilities' ? 'checked' : '';
                  $epartcats = explode(',', $row['event_part_cat']); 
                  $estat1 = $estat2 = $estat3 = '';
                  $estat1 = $row['event_status'] == '1' ? 'checked' : '';
                  $estat2 = $row['event_status'] == '2' ? 'checked' : '';
                  $estat3 = $row['event_status'] == '3' ? 'checked' : '';
                  $epartcat1 = $epartcat2 = $epartcat3 = $epartcat4 = $epartcat5 = '';
                  foreach($epartcats as $key => $value) {    
                      if($value == 'Seniors') $epartcat1 = 'checked';
                      if($value == 'Youth') $epartcat2 = 'checked';
                      if($value == 'Children') $epartcat3 = 'checked';
                      if($value == 'Women') $epartcat4 = 'checked';
                      if($value == 'Men') $epartcat5 = 'checked'; 
                  }

                                   
                  // get participants from residents_programs table
                  $result2 = mysql_query("SELECT * FROM residents_programs where prog_id = '$id'");

                  while($row1 = mysql_fetch_array($result2,MYSQL_ASSOC)){

                    $res_id = $row1['res_id'];
                    $sql    = "SELECT * FROM resident WHERE res_id = '$res_id' ORDER BY res_lname"; 
                    $res    = mysql_query($sql);
                    $rows   = mysql_num_rows($res);
                    if($rows >= 1) {
                      while($row2 = mysql_fetch_array($res,MYSQL_ASSOC)) {
                        $output .= '<input type="checkbox" name="participants[]" id="participants" value="'.$row2['res_id'].'" checked/> '.$row2['res_lname'].', '.$row2['res_fname'].'<br/>';
                      }
                    }else {
                      $output = "no residents found...";
                    }
                  }

                  echo '<tr class="info">

                  <form action="progdetails.php" method="POST">
                  <input type="hidden" value="'.$ename.'" name="ename">
                  <input type="hidden" value="'.$evenue.'" name="evenue">
                  <input type="hidden" value="'.$edates.'" name="edates">
                  <input type="hidden" value="'.$edatee.'" name="edatee">
                  <input type="hidden" value="'.$id.'" name="id">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td>";                
                  echo '<td><button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>';
                  echo '<div class="modal fade" id="modal-container-'.$x.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title" id="myModalLabel" align="center">
                            Edit Program Details
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form action="action/update-action.php" role="form" method="POST" id="editForm">
                            <input type="hidden" name="eid" value="'.$id.'">
                            <table>
                              <tbody>
                                <tr><td>Program Name: </td><td><input type="text" class="form-control" placeholder="Enter Program Name" name="ename" value="'.$ename.'" required/></td></tr>
                                <tr><td>Program Venue: </td><td><input type="text" class="form-control" placeholder="Enter Venue" name="evenue" value="'.$evenue.'" required/></td></tr>
                                <tr><td>Program Schedule Start: </td><td><input type="datetime" class="form-control" name="edates" placeholder="" value="'.$edates.'" required/></td></tr>
                                <tr><td>Program Schedule End: </td><td><input type="datetime" class="form-control" name="edatee" placeholder=" " value="'.$edatee.'" required/></td></tr>
                                <tr><td>Program Category: </td><td><input type="radio" name="event_category" class="prog_cat" value="Education" '.$ecat1.'>Education<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Health Services" '.$ecat2.'>Health Services<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Peace and Order" '.$ecat3.'>Peace and Order<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Transportation" '.$ecat4.'>Transportation<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Solid Waste Management" '.$ecat5.'>Solid Waste Management<br>
                                                             <input type="radio" name="event_category" class="prog_cat" value="Use of Barangay Facilities" '.$ecat6.'>Use of Barangay Facilities</td></tr>
                                <tr><td>Program Participants Category: </td> <td><input type="checkbox" name="event_part_cat[]" class="part_cat" value="Seniors" '.$epartcat1.'>Seniors<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Youth" '.$epartcat2.'>Youth<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Children" '.$epartcat3.'>Children<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Women" '.$epartcat4.'>Women<br>
                                                             <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Men" '.$epartcat5.'>Men</td></tr>
                                <tr><td>Program Participants: </td> <td><div class="loadingDiv"><img src="img/loading.gif" /></div><div class="participants">'.$output.'</div></td></tr>
                                <tr><td>Program Description: </td> <td><textarea id="event_desc" name="event_desc" style="width: 400px; height: 100px;">
                                              '.$edesc.'
                                              </textarea>
                                              
                                    <tr><td>Program Budget: </td> <td><script type="text/javascript">
                                              function isNumberKey(evt)
                                                  {
                                                     var charCode = (evt.which) ? evt.which : evt.keyCode;
                                                     if (charCode != 46 && charCode > 31 
                                                       && (charCode < 48 || charCode > 57))
                                                        return false;

                                                     return true;
                                                  }
                                              </script>
                                              <input id="event_budget" onkeypress="return isNumberKey(event)" type="text" name="event_budget" value="'.$ebudget.'"></td></tr>          
                                    <tr><td>Program Sponsors: </td> <td><textarea id="event_sponsors" name="event_sponsors" style="width: 400px; height: 100px;">
                                              '.$esponsors.'
                                              </textarea>
                                                      
                                    <tr><td>Status: </td><td><input type="radio" name="event_status" value="1" '.$estat1.'>Active<br>
                                                             <input type="radio" name="event_status" value="2" '.$estat2.'>Canceled<br>
                                                             <input type="radio" name="event_status" value="3" '.$estat3.'>Completed</td></tr>                      
                                </tbody>
                            
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button class="btn btn-primary" name="edit_program">Submit</button>
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                  <td><form method="GET" action="action/delete-action.php">
                  <input type="hidden" name="ename" value="'.$ename.'">
                  <input type="hidden" name="edates" value="'.$edates.'">
                  <input type="hidden" name="edatee" value="'.$edatee.'">
                  <input type="hidden" name="evenue" value="'.$evenue.'">
                  <button name="delete_program" class="btn btn-danger btn-sm">Delete</button></form></td>';
              $x++;
          
                echo "</tbody></table>";
            }}
       else{
                   $x = -1000;
          $date1 = new datetime();
        $date1 = date("y-m-d h:i:a");
        $today = date("y-m-d");
        $result = mysql_query("SELECT * FROM programs WHERE event_startsched > '$date1' && event_status != 2 ORDER BY event_startsched");       

        echo '<table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>PROGRAM ID.</th>
                  <th>Program Name</th>
                  <th>Venue</th>
                  <th>Schedule Start</th>
                  <th>Schedule End</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>';       

                  while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
                    {       

                          $id=$row['event_id'];
                          $output = "";
                          $ename=ucfirst($row['event_name']);
                          $date1 = new datetime();
                          $evenue=ucfirst($row['event_venue']);
                          $edates=$row['event_startsched'];
                          $edates=strtotime($edates);
                          $edates=date("y-m-d h:i:a",$edates);
                          $date1=date("y-m-d");
                          $edatee=$row['event_endsched'];
                          $edatee=strtotime($edatee);
                          $edatee=date("y-m-d h:i:a",$edatee);
                                 

                                           
                          // get participants from residents_programs table
                         
                          echo '<tr class="info">       

                          <input type="hidden" value="'.$ename.'" name="ename">
                          <input type="hidden" value="'.$evenue.'" name="evenue">
                          <input type="hidden" value="'.$edates.'" name="edates">
                          <input type="hidden" value="'.$edatee.'" name="edatee">
                          <input type="hidden" value="'.$id.'" name="id">
                          <td>' . $id . '</td>'; 
                          echo "<td>" . $ename . "</td>"; 
                          echo "<td>" . $evenue . "</td>";
                          echo "<td>" . $edates ."</td>";
                          echo "<td>" . $edatee ."</td>";                
                        }  
                        echo "</tbody></table>";
                   } 
                   
}

function display_cancelled()
{
$x = -1000;
$date1 = new datetime();
$date1 = date("y-m-d");
$today = date("y-m-d");
$result = mysql_query("SELECT * FROM programs WHERE event_status = 2 ORDER BY event_startsched");

echo '<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>PROGRAM ID.</th>
          <th>Program Name</th>
          <th>Venue</th>
          <th>Schedule</th>
          <th>Remarks</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {

                  $id=$row['event_id'];
                  $output = "";
                  $ename=ucfirst($row['event_name']);
                  $date1 = new datetime();
                  $evenue=ucfirst($row['event_venue']);
                  $edates=$row['event_startsched'];
                  $edates=strtotime($edates);
                  $edates=date("y-m-d h:i:a",$edates);
                  $date1=date("y-m-d");
                  $edatee=$row['event_endsched'];
                  $edatee=strtotime($edatee);
                  $edatee=date("y-m-d h:i:a",$edatee);
                  $edesc=$row['event_desc'];
                  
                  
                  echo '<tr class="info">';
                 
                  echo'<td>' . $id . '</td>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edesc ."</td>";                
                   $x++;
          }
                echo "</tbody></table>";
              
}

function display_searchprog($progname)
{
$x = -1000;
$result = mysql_query("SELECT * FROM programs WHERE event_name LIKE '".$progname."'");

echo '<div class="container shadow">
  <div class="row clearfix">
    <div class="col-md-12 column">
      
<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>PROGRAM ID.</th>
          <th>Program Name</th>
          <th>Program Venue</th>
          <th>Program Schedule Start</th>
          <th>Program Schedule End</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['event_id'];
                  $ename=ucfirst($row['event_name']);
                  $date1 = new datetime();
                  $evenue=ucfirst($row['event_venue']);
                  $edates=$row['event_startsched'];
                  $edates=strtotime($edates);
                  $edates=date("y-m-d h:i:a",$edates);
                  $date1=date("y-m-d h:i:a");
                  $edatee=$row['event_endsched'];
                  $edatee=strtotime($edatee);
                  $edatee=date("y-m-d h:i:a",$edatee);
                  
                  echo '<tr class="info">';
                 
                 if($edates>=$date1)
                   {
                  echo '<form action="../progdetails.php" method="POST">
                  <input type="hidden" value="'.$ename.'" name="ename">
                  <input type="hidden" value="'.$evenue.'" name="evenue">
                  <input type="hidden" value="'.$edates.'" name="edates">
                  <input type="hidden" value="'.$edatee.'" name="edatee">
                  <input type="hidden" value="'.$eparts.'" name="eparts">
                  <input type="hidden" value="'.$id.'" name="id">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td>";
                                   
                 echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
                  <div class="modal fade" id="modal-container-'.$x.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title" id="myModalLabel" align="center">
                            Edit Program Details
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
                            <table>
                              <tr>
                                <td></br><label for="inputename" class="col-lg-2 control-label">Program Name:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputename" name="ename" value="'.$ename.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputevenue" class="col-lg-2 control-label">Program Venue:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputevenue" name="evenue" value="'.$evenue.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputedates" class="col-lg-2 control-label">Program Schedule Start:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="datetime" class="form-control" id="inputedates" name="edates" value="'.$edates.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputedatee" class="col-lg-2 control-label">Program Schedule End:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="datetime" class="form-control" id="inputedatee" name="edatee" value="'.$edatee.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputeorg" class="col-lg-2 control-label">Program Organizer:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputeorg" name="eorg" value="'.$eorg.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputeparts" class="col-lg-2 control-label">Program Participants:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputeparts" name="eparts" value="'.$eparts.'" required/></td>
                              </tr>
                            
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="update">Submit</button>
                          </form></td>
                 ';
              $x++;
   }           
  else if($edates<$date1)
                  {
                 
                   
                  echo '<form action="../progdetailspast.php" method="POST">
                  <input type="hidden" value="'.$ename.'" name="ename">
                  <input type="hidden" value="'.$evenue.'" name="evenue">
                  <input type="hidden" value="'.$edates.'" name="edates">
                  <input type="hidden" value="'.$edatee.'" name="edatee">
                  <input type="hidden" value="'.$id.'" name="id">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td>";
                                   
                
                 
              $x++;
              }
}
                echo "</tbody></table>";
              echo'<form action="../program.php" ><button id="back"  class="btn btn-default">Back</button></form>';
}

function display_programs()
{
$x = -1000;
$result = mysql_query("SELECT * FROM programs");

echo '<div class="container shadow">
  <div class="row clearfix">
    <div class="col-md-12 column">
      
<table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>PROGRAM ID.</th>
          <th>Program Name</th>
          <th>Venue</th>
          <th>Schedule Start</th>
          <th>Schedule End</th>
          <th></th>
        </tr>
      </thead>
      <tbody>';

          while($row = mysql_fetch_array($result,MYSQL_ASSOC)) 
            {
                  $id=$row['event_id'];
                  $ename=ucfirst($row['event_name']);
                  $date1 = new datetime();
                  $evenue=ucfirst($row['event_venue']);
                  $edates=$row['event_startsched'];
                  $edates=strtotime($edates);
                  $edates=date("y-m-d h:i:a",$edates);
                  $date1=date("y-m-d h:i:a");
                  $edatee=$row['event_endsched'];
                  $edatee=strtotime($edatee);
                  $edatee=date("y-m-d h:i:a",$edatee);
                  $eparts=$row['event_participants'];
                  $eorg=$row['event_organizer'];
                  
                  echo '<tr class="info">';
                 
                 if($edates>=$date1)
                   {
                  echo '<form action="../progdetails.php" method="POST">
                  <input type="hidden" value="'.$ename.'" name="ename">
                  <input type="hidden" value="'.$evenue.'" name="evenue">
                  <input type="hidden" value="'.$edates.'" name="edates">
                  <input type="hidden" value="'.$edatee.'" name="edatee">
                  <input type="hidden" value="'.$eorg.'" name="eorg">
                  <input type="hidden" value="'.$eparts.'" name="eparts">
                  <input type="hidden" value="'.$id.'" name="id">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td>";
                                   
                 echo '<td> <button id="modal-'.$x.'" class="btn btn-primary btn-sm" href="#modal-container-'.$x.'" data-toggle="modal">Edit</button>
                  <div class="modal fade" id="modal-container-'.$x.'" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="modal-title" id="myModalLabel" align="center">
                            Edit Program Details
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form action="action/update-action.php" role="form" method="GET">
                            <input type="hidden" name="id" value="'.$id.'">
                            <table>
                              <tr>
                                <td></br><label for="inputename" class="col-lg-2 control-label">Program Name:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputename" name="ename" value="'.$ename.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputevenue" class="col-lg-2 control-label">Program Venue:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputevenue" name="evenue" value="'.$evenue.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputedates" class="col-lg-2 control-label">Program Schedule Start:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="datetime" class="form-control" id="inputedates" name="edates" value="'.$edates.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputedatee" class="col-lg-2 control-label">Program Schedule End:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="datetime" class="form-control" id="inputedatee" name="edatee" value="'.$edatee.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputeorg" class="col-lg-2 control-label">Program Organizer:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputeorg" name="eorg" value="'.$eorg.'" required/></td>
                              </tr>
                              <tr>
                                <td></br><label for="inputeparts" class="col-lg-2 control-label">Program Participants:</label></td>
                                <div class="col-lg-10">
                                <td></br><input type="text" class="form-control" id="inputeparts" name="eparts" value="'.$eparts.'" required/></td>
                              </tr>
                            
                            </table>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button class="btn btn-primary" name="update">Submit</button>
                          </form></td>
                 ';
              $x++;
   }           
  else if($edates<$date1)
                  {
                  echo '<form action="../progdetailspast.php" method="POST">
                  <input type="hidden" value="'.$ename.'" name="ename">
                  <input type="hidden" value="'.$evenue.'" name="evenue">
                  <input type="hidden" value="'.$edates.'" name="edates">
                  <input type="hidden" value="'.$edatee.'" name="edatee">
                  <input type="hidden" value="'.$eorg.'" name="eorg">
                  <input type="hidden" value="'.$eparts.'" name="eparts">
                  <input type="hidden" value="'.$id.'" name="id">
                  <td><button class="btn btn-primary btn-sm">' . $id . '</button></td></form>'; 
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td>";                                                                  
              $x++;
              }              
}
                echo "</tbody></table>";
              echo'<form action="../program.php" ><button id="back"  class="btn btn-default">Back</button></form>';
}

function update_resident($id,$fname,$mname,$lname,$email,$gender,$contact,$bday,$sitio,$rinterest)
{
 
 $result= mysql_query("SELECT res_id FROM resident WHERE res_id='".$id."'");
 $row = mysql_fetch_array($result,MYSQL_ASSOC);
 $resid = $row['res_id'];

 $query = "UPDATE resident SET res_fname = '".$fname."', res_mname = '".$mname."',res_lname='".$lname."' , res_email = '".$email."', res_bday = '".$bday."', res_gender = '".$gender."', res_contact = '".$contact."', res_add_sitio = '".$sitio."', res_interest = '".$rinterest."'  WHERE res_id = '".$resid."'";
 $result = mysql_query($query);
 header("Refresh:2; url=../home.php");
}

function delete_resident($id)
{
  $query="DELETE FROM resident WHERE res_id='".$id."' ";
  $result = mysql_query($query);
  header("Refresh:2; url=../home.php");
}

function update_clerk($id, $fname, $lname, $email, $contact, $bday, $uname)
{
 
 $result= mysql_query("SELECT clerk_id FROM clerk WHERE clerk_id='".$id."'");
 $row = mysql_fetch_array($result,MYSQL_ASSOC);
 $clerkid = $row['clerk_id'];

 $query = "UPDATE clerk SET clerk_Fname = '".$fname."', clerk_Lname = '".$lname."', clerk_Email = '".$email."',  clerk_Contact = '".$contact."',  clerk_Bdate = '".$bday."',  clerk_username = '".$uname."'  WHERE clerk_id = '".$clerkid."'";
 $result = mysql_query($query);
 header("Refresh:2; url=../home.php");
}

function delete_clerk($id)
{
  $query="DELETE FROM clerk WHERE clerk_id='".$id."' ";
  $result= mysql_query($query);

  header("Refresh:2; url=../home.php");
}
         
function update_program($id, $ename, $edates, $edatee, $evenue, $eparts, $ecat, $edesc, $esponsors, $ebudget, $estat, $epartcat)
{
 $query = "UPDATE programs SET event_name = '".$ename."', event_startsched = '".$edates."', event_endsched = '".$edatee."',  event_venue = '".$evenue."',  event_category = '".$ecat."', event_desc = '".$edesc."', event_part_cat = '".$epartcat."', event_sponsors = '".$esponsors."', event_budget = '".$ebudget."', event_status = '".$estat."'  WHERE event_id = '".$id."'";
 $result = mysql_query($query);
 regParts($eparts, $id, 2);

 header("Refresh:2; url=../program.php");
}

function delete_program($id)
{
  $query="DELETE FROM programs WHERE event_id='".$id."' ";
  $result= mysql_query($query);

  header("Refresh:2; url=../program.php");
}

function uploadimage($img, $id)
  {
  
    $query = "UPDATE resident SET res_img='".$img."' WHERE res_id = '".$id."' ";
    if(mysql_query($query))
    {
      echo "Profile picture successfully changed!";

      header("refresh:2;url='../home.php'");
        
    }
    else
    {
      echo "$query<br/>";
      print mysql_error();
      echo "Error in changing your profile picture!";
      header("refresh:2;url='../home.php'");
    }
  }

  function uploadimageclerk($img, $id)
  {
  
    $query = "UPDATE clerk SET cler_img='".$img."' WHERE clerk_id = '".$id."' ";
    if(mysql_query($query))
    {
      echo "Profile picture successfully changed!";
      header("refresh:2;url='../home.php'");
    }
    else
    {
      echo "$query<br/>";
      print mysql_error();
      echo "Error in changing your profile picture!";
      header("refresh:2;url='../home.php'");
    }
  }

  function importexcel()
  {
    $uploadedStatus = 0;
    if ( isset($_POST["submit"]) )
     {
      if ( isset($_FILES["file"]))
       {
//if there was an error uploading the file
      if ($_FILES["file"]["error"] > 0)    
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
      
  else
   {
   if (file_exists($_FILES["file"]["name"]))   
    unlink($_FILES["file"]["name"]);
    
  $storagename = "residents.xlsx";
move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
$uploadedStatus = 1;
}
} else 
echo "No file selected <br />";


}
 
echo'<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:20px 0 25px 0;">
<form action="import.php" method="POST" enctype="multipart/form-data">
<tr><td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Browse and Upload Your File </td></tr>
<tr>
<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>
<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="file" name="file" id="file" /></td>
</tr>
<tr>
<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>
<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>
</tr></form>
</table>';}

//function importattendance()
//  {
//    
//    $uploadedStatus = 0;
//    if ( isset($_POST["submit"]) )
//     {
//      if ( isset($_FILES["file"]))
//       {
////if there was an error uploading the file
//      if ($_FILES["file"]["error"] > 0)    
//        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
//      
//  else
//   {
//   if (file_exists($_FILES["file"]["name"]))   
//    unlink($_FILES["file"]["name"]);
//    
//  $storagename = "attendance.xlsx";
//move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
//$uploadedStatus = 1;
//}
//} else 
//echo "No file selected <br />";//
//

//}
//echo $id;//

//echo'<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:20px 0 25px 0;">
//<form action="importattendance.php" method="POST" enctype="multipart/form-data">
//<tr><td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Browse and Upload Your Attendance File </td></tr>
//<tr>
//<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>
//<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="file" name="file" id="file" /></td>
//</tr>
//<tr>
//<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>
//<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>
//</tr>
//<input type="hidden" name="id" value="."></form>
//</table>';}//

