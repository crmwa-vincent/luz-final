<?php

	include('header.php');
	include_once('functions.php');

?>
<script type="text/javascript">
function goBack() {
    window.history.back()

}
</script>
                  

<div class="container shadow">
	<div class="row clearfix">
		<div class="col-md-4 col">
			<?php
			
			if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2 || isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
				{	
					$category ='';
					$id = $_GET['id'];
					$fname = $_GET['fname'];
					$mname = $_GET['mname'];
					$lname = $_GET['lname'];
					$image = $_GET['img'];
					$contact = $_GET['contact'];
					$gender = $_GET['gender'];
					$email = $_GET['email'];
					$bday = $_GET['bday'];
					$sitio = $_GET['sitio'];
					$rinterest = $_GET['rinterest'];
					$bday1 = explode("-",$bday);
					$age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));
					$result =mysql_query("SELECT p.* FROM residents_programs rp left join programs p on rp.prog_id = p.event_id where rp.res_id = ".$id." && rp.checked = 1"); 
					$result1 = mysql_query("SELECT * FROM residents_programs");
					$ctr1=$ctr2=0;

					while($row1=mysql_fetch_array($result1,MYSQL_ASSOC))
						if($row1['res_id']==$id)$ctr2++;
					


					if($age>=15 && $age<=25)
						$category='Youth';

					if($age>=60)
						$category='Senior';

					if($age>25 && $age<60)
						$category='Men';

					if($age<15)
						$category='Children';

					$target = "upload/".$image;
					$size = getImageSize( $target ); 
					if($size[1]>$size[0])
					{
							$newsize=($size[0] + $size[1]) / ($size[0] *($size[1]/70));
					}
					else
					{
							$newsize=($size[0] + $size[1]) / ($size[1] *($size[0]/50));
					}
							$height=$size[1] * $newsize;
							$width=$size[0] * $newsize; 


							$imgstr = "<p><img width=\"$width\" height=\"$height\" ";         
							$imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";
							




					

					echo $imgstr;
	
					echo "<table class='table table-striped table-hover' align='left'><tr class='success'></br><td>";
					echo '<button id="modal-10597" href="#modal-container-10597" data-toggle="modal" class="btn btn-default">Upload :)</button>
						    <div class="modal fade" id="modal-container-10597" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						      <div class="modal-dialog">
						        <div class="modal-content">
						          <div class="modal-header">
						             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
						            <h4 class="modal-title" id="myModalLabel" align="center">
						              Upload Picture
						            </h4>
						          </div>
						          <div class="modal-body">
						            <form enctype="multipart/form-data" action="action/upload-action.php" role="form" method="GET">
						              <input type="hidden" name="MAX_FILE_SIZE" value="750002400" />
						              <input type="hidden" name="id" value="'.$id.'">
						              <input type="file" name="fupload" /></br></br></br>
						              <input type="submit" name="submit" value="Upload!"/>
						          </div>
						          <div class="modal-footer">
						             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						            </form>';
					echo "</td><td></td></tr>
					<tr class='success'><td>Firstname: </td><td>".$fname."</td></tr>
					<tr class='success'><td>Middlename: </td><td>".$mname."</td></tr>
					<tr class='success'><td>Lastname: </td><td>".$lname."</td></tr>
					<tr class='success'><td>Gender: </td><td>".$gender."</td></tr>
					<tr class='success'><td>Contact Number:</td><td>".$contact."</td></tr>
					<tr class='success'><td>Email: </td><td>".$email."</td></tr>
					<tr class='success'><td>Sitio: </td><td>".$sitio."</td></tr>
					<tr class='success'><td>Birthday: </td><td>".$bday."</td></tr>
					<tr class='success'><td>Age: </td><td>".$age."</td></tr>
					<tr class='success'><td>Category: </td><td>".$category."</td></tr>
					<tr class='success'><td>Interests: </td><td>".$rinterest."</td></tr>
					</table>";
					
					
				

				}
			?>
		</div>
		<?php
echo'<table class="table table-striped table-hover">
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
          		  $ctr1++;
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
                  $eorg=$row['event_organizer'];

                  
                  echo "<tr><td>" . $id . "</td>";
                  echo "<td>" . $ename . "</td>"; 
                  echo "<td>" . $evenue . "</td>";
                  echo "<td>" . $edates ."</td>";
                  echo "<td>" . $edatee ."</td></tr>";
                  }
                  echo "<tr><td></td><td></td><td></td>";
                  echo "<td>No. of Programs Attended: </td><td>$ctr1</td></tr>";
                  echo "<tr><td></td><td></td><td></td>";
                  echo "<td>No. of Programs Invited To: </td><td>$ctr2</td></tr>";
                  
                  
                  echo'</table>';
                  
                  echo'<button onClick="goBack()"  class="btn btn-default">Back</button>
                  <br><br><form><input type="button" onClick="window.print()" value="Print Report"></form>';
      ?>

		
	</div>
</div>
<?php
	include('footer.php');
?>