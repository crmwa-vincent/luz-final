<?php

	include('header.php');
	include_once("functions.php");


if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2 || isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
{
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
	$("#reportsForm").submit(function() {
	       var datastring = $("#reportsForm").serialize();		
	
		    $.ajax
		    ({
		        type: "POST",
		        url: "action/reports.php",
		        data: datastring,
		        success: function(msg)
		        {
		                jQuery("#res tbody").html(msg);
		               //$("#results").html(msg);
		        }
		    });
		    return false;
	});
		
 });
</script>
<?php
echo '
<div class="container shadow">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<ul class="nav nav-tabs">
			  <li class="active"><a href="#percategory" data-toggle="tab">Categorized</a></li>
			  <li class=""><a href="#per_res" data-toggle="tab">Per Resident</a></li>
			  <li class=""><a href="#per_prog" data-toggle="tab">Per Program</a></li>
			  <li class=""><a href="#per_sponsor" data-toggle="tab">Per Sponsor</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane fade active in" id="percategory">
				<form method="POST" id="reportsForm" role="form">
					<table class="table table-striped table-hover">
						<tbody>
						<tr><td>Category: </td><td>
							<select name="category">
								<option value="">All</option>
								<option>Education</option>
								<option>Health Services</option>
								<option>Peace and Order</option>
								<option>Transportation</option>
								<option>Solid Waste Management</option>
								<option>Use of Barangay Facilities</option>
							</select>
						</td></tr>
						<tr><td>From: </td><td><input type="date" required class="form-control" name="fromdate" placeholder="" id="inputDefault"/></td></tr>
						<tr><td>To: </td><td><input type="date" required class="form-control" name="todate" placeholder=" " id="inputDefault"/></td></tr>
						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="searchreport" class="btn btn-primary submit">Submit</button></td></tr>
						</tbody>
				</form>
				</div>
			  </div>
			  <div class="tab-pane fade" id="displayprog">

			  <div id="loadingDiv"><img src="img/loading.gif" /></div>
			  		<table class="table table-striped table-hover" id="res">
				      <thead>
				        <tr>
				          <th>Program Name</th>
				          <th>Category</th>
				          <th>Venue</th>
				          <th>Start</th>
				          <th>End</th>
				          <th># of Participants</th>
				          <th>Budget</th>
				          <th>Status</th>
				        </tr>
				      </thead>
				      <tbody>
				      </tbody>
				      </table>
			  </div>

			  
			<div class="tab-pane fade " id="per_res">
			  	<form action="action/search-action.php" method="POST" role="form">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Search Resident</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>Enter First Name: </td><td><input type="text" class="form-control"  name="fname" id="inputDefault" required/></td></tr>
						<tr><td>Enter Last Name: </td><td><input type="text" class="form-control"  name="lname" id="inputDefault" required/></td></tr>
						<tr><td>Enter Birthday: </td><td><input type="date" class="form-control"  name="bday" id="inputDefault" required/></td></tr>

						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="search" class="btn btn-primary">Submit</button></td></tr>
						</tbody>
					</table>
				</form>
			  </div>
			 <div class="tab-pane fade " id="per_prog">
			  	<form action="action/search-action.php" method="POST" role="form">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Search Program</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>Program Name: </td><td><input type="text" class="form-control"  name="progname" id="inputDefault" required/></td></tr>
						<tr><td>Enter Program Venue: </td><td><input type="text" class="form-control"  name="evenue" id="inputDefault" required/></td></tr>
						<tr><td>Enter Program Schedule: </td><td><input type="date" class="form-control" name="esched" id="inputDefault" required/></td></tr>
						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="searchprog" class="btn btn-primary">Submit</button></td></tr>
						</tbody>
					</table>
				</form>
			  </div>
			   <div class="tab-pane fade " id="per_sponsor">
			  	<form action="action/search-action.php" method="POST" role="form">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Search Sponsor</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>Program Sponsor: </td><td><input type="text" class="form-control"  name="sponsor" id="inputDefault" required/></td></tr>
						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="searchspons" class="btn btn-primary">Submit</button></td></tr>
						</tbody>
					</table>
				</form>
			  </div>
		</div>
	</div>
</div>';
}
else
	echo '<center><h4 class="text-info">You do not have authority to view this page! Please <a href="login.php">Login</a></h4></center>';

	include('footer.php')


?>