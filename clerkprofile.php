<?php

	include('header.php');
	include_once('functions.php');
?>			
<div class="container shadow">
	<div class="row clearfix">
		<div class="col-md-4 col">
			<?php
			if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2)
				{
					$id= $_GET['id'];
					$result = mysql_query("SELECT * FROM clerk");
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$img = $row['cler_img'];
					$bday = $_GET['bday'];
					$bday1 = explode("-",$bday);
					$age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));


					$target = "upload/".$img;
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
						echo "</br>";
						}

				elseif(isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
				{
				
					
					$id = $_GET['id'];
					$fname = $_GET['fname'];
					$lname = $_GET['lname'];
					$contact = $_GET['contact'];
					$uname = $_GET['uname'];
					$email = $_GET['email'];
					$img = $_GET['img'];
					$bday = $_GET['bday'];
					$bday1 = explode("-",$bday);
					$age = (date("md",date("U",mktime(0,0,0,$bday1[0],$bday1[1],$bday1[2])))>date("md")?((date("Y")-$bday1[0])-1):(date("Y")-$bday1[0]));

				

					$target = "upload/".$img;
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
						echo "</br>";


						}
				else{
	echo '<center><h4 class="text-info">You do not have authority to view this page! Please <a href="login.php">Login</a></h4></center>';
		die;}

	
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
						            <form enctype="multipart/form-data" action="action/upload-action.php" role="form" method="POST">
						              <input type="hidden" name="MAX_FILE_SIZE" value="750002400" />
						              <input type="hidden" name="id" value="'.$id.'">
						              <input type="file" name="fupload" />
						              <input type="submit" name="submit1" value="Upload!"/>
						          </div>
						          <div class="modal-footer">
						             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						            </form>';
					echo "</td><td></td></tr>
					<tr class='success'><td>Firstname: </td><td>".$fname."</td></tr>
					<tr class='success'><td>Lastname: </td><td>".$lname."</td></tr>
					<tr class='success'><td>Contact Number:</td><td>".$contact."</td></tr>
					<tr class='success'><td>Email: </td><td>".$email."</td></tr>
					<tr class='success'><td>Username: </td><td>".$uname."</td></tr>
					<tr class='success'><td>Birthday: </td><td>".$bday."</td></tr>
					<tr class='success'><td>Age: </td><td>".$age."</td></tr>
					</table>";

					echo'<form action="home.php" ><button id="back"  class="btn btn-default">Back</button></form>';
		
			?>
		</div>
		
	</div>
</div>
<?php
	include('footer.php');
?>