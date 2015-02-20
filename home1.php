<?php

	include('header.php');
	include_once("functions.php");

?>
<script type="text/javascript">
$(document).ready(function(){
	var $loading = $('#loadingDiv').hide();

	$(document)
	  .ajaxStart(function () {
	    $loading.show();
	  })
	  .ajaxStop(function () {
	    $loading.hide();
	  });
	$(function () {
    $("#residentForm").submit(function() {  
        var datastring = $("#residentForm").serialize();		
	
		    $.ajax
		    ({
		        type: "POST",
		        url: "action/resident-action.php",
		        data: datastring,
		        success: function(msg)
		        {
		                jQuery("#res tbody").html(msg);
		               //$("#results").html(msg);
		        }
		    });
		    return false;
    
    }).trigger('submit');

});
		
 });
</script>
<?php
if(isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
{
echo '
<div class="container shadow">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<ul class="nav nav-tabs">
			  <li class=""><a href="#resident" data-toggle="tab">Add Resident</a></li>
			  <li class=""><a href="#import" data-toggle="tab">Import Residents from Excel</a></li>
			  <li class="active"><a href="#display" data-toggle="tab">All Residents</a></li>
			  <li class=""><a href="#search_res" data-toggle="tab">Search Resident</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane fade " id="resident">
			  	<form action="action/register-action.php" method="POST" role="form">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Register a Resident</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>First Name: </td><td><input type="text" class="form-control" placeholder="Enter Resident First Name" name="rfname" id="inputDefault" required/></td></tr>
						<tr><td>Middle Name: </td><td><input type="text" class="form-control" placeholder="Enter Resident Middle Name" name="rmname" id="inputDefault" required/></td></tr>
						<tr><td>Lastname: </td><td><input type="text" class="form-control" placeholder="Enter Resident Last Name" name="rlname" id="inputDefault" required/></td></tr>
						<tr><td>Gender: </td><td><input type="radio" name="gender" id="inputDefault" value = "male">Male<br>
												 <input type="radio" name="gender" id="inputDefault" value = "female">Female<br></td></tr>
						<tr><td>Contact Number: </td><td><input type="int" class="form-control" placeholder="Enter Contact Number" name="rcontact" id="inputDefault"required/></td></tr>
						<tr><td>Email: </td><td><input type="email" class="form-control" placeholder="Enter Email" name="remail" id="inputDefault" required/></td></tr>
						<tr><td>Sitio: </td><td><select name="rsitio">
												<option value="Abellana">Abellana</option>
												<option value="City Central">City Central</option>
												<option value="Kalinao">Kalinao</option>
												<option value="Lubi">Lubi</option>
												<option value="Mabuhay">Mabuhay</option>
												<option value="Nangka">Nangka</option>
												<option value="New Era">New Era</option>
												<option value="Regla">Regla</option>
												<option value="San Antonio">San Antonio</option>
												<option value="San Roque">San Roque</option>
												<option value="San Vicente">San Vicente</option>
												<option value="Sta. Cruz">Sta. Cruz</option>
												<option value="Sto.Nino I">Sto.Nino I</option>
												<option value="Sto.Nino II">Sto.Nino II</option>
												<option value="Sto.Nino III">Sto.Nino III</option>
												<option value="Zapatera">Zapatera</option></select></td></tr>
						<tr><td>Birthday: </td><td><input type="date" class="form-control" name="rbday" id="inputDefault" required/></td></tr>
						<tr><td>Interests:</td><td><input type="checkbox" name="event_category[]" value="Education">Education<br>
											     <input type="checkbox" name="event_category[]" value="Health Services">Health Services<br>
											     <input type="checkbox" name="event_category[]" value="Peace and Order">Peace and Order<br>
											     <input type="checkbox" name="event_category[]" value="Transportation">Transportation<br>
											     <input type="checkbox" name="event_category[]" value="Solid Waste Management">Solid Waste Management<br>
											     <input type="checkbox" name="event_category[]" value="Use of Barangay Facilities">Use of Barangay Facilities</td></tr> 
						<input type="hidden" value="no_photo.jpg" name="img">
						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="resident" class="btn btn-primary">Submit</button></td></tr>
						</tbody>
					</table>
				</form></div>';
				echo '<div class="tab-pane fade" id="import">';

			  		echo importexcel();

			  		echo'</div>';

			  	 echo'<div class="tab-pane fade " id="search_res">
			  	<form action="action/search-action.php" method="POST" role="form">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Search Resident</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>Enter First Name: </td><td><input type="text" class="form-control"  name="fname" id="inputDefault" required/></td></tr>
						<tr><td>Enter Last Name: </td><td><input type="text" class="form-control"  name="lname" id="inputDefault" required/></td></tr>
						<tr><td>Enter Birthday: </td><td><input type="date" class="form-control"  name="bday" id="inputDefault" required/></td></tr>

						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="search" class="btn btn-primary">Submit</button></td></tr>
						</tbody>';
					echo '</table>
				</form>
			  </div>';
			 



			  echo '<div class="tab-pane fade active in" id="display">';
			  		echo '<div>
							  <div>
								<form method="POST" role="form" id="residentForm">
									<table class="table table-striped table-hover">
										<tbody>
										<tr><td>Filters: &nbsp;&nbsp;
										   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Seniors"> Seniors &nbsp;&nbsp;
						                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Youth"> Youth &nbsp;&nbsp;
						                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Children"> Children &nbsp;&nbsp;
						                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Women"> Women &nbsp;&nbsp;
						                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Men"> Men</td></tr>
										<tr><td><button name="searchreport" class="btn btn-primary submit">Submit</button></td></tr>
										</tbody>
								</form>
								</div>
							  </div>';
			  		echo '<div id="loadingDiv"><img src="img/loading.gif" /></div>
			  			<table class="table table-striped table-hover" id="res">
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
						      <tbody>
				      		  </tbody>
				      		</table>';
			 
				
}


else
	echo '<center><h4 class="text-info">You do not have authority to view this page! Login as <a href="login.php">Clerk</a></h4></center>';


	include('footer.php')


?>