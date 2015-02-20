<?php

	include('header.php');
	include_once("functions.php");
?>
<script type="text/javascript">
function getParticipants(par){
	
	var form       = $(par).closest('form')[0];
	var datastring = $(form).serialize();
	
    $.ajax
    ({
        type: "POST",
        url: "action/residents.php",
        data: datastring,
        success: function(msg)
        {
            $(".participants").html(msg);
        }
    });
}
$(document).ready(function(){
	var $loading = $('.loadingDiv').hide();
	$(document)
	  .ajaxStart(function () {
	    $loading.show();
	  })
	  .ajaxStop(function () {
	    $loading.hide();
	  });
	$(".prog_cat").click(function () {
	       getParticipants(this);
	    });
	$(".part_cat").change(function () { 
	       getParticipants(this);
	    });
	
 });
</script>
<?php
if(isset($_SESSION['usertype']) && $_SESSION['usertype']==2 || isset($_SESSION['usertype']) && $_SESSION['usertype']==1)
{
echo '
<div class="container shadow">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<ul class="nav nav-tabs">
			  <li class=""><a href="#programs" data-toggle="tab">Add A New Program</a></li>
			  <li class=""><a href="#displaypast" data-toggle="tab">Past Programs</a></li>
			  <li class="active"><a href="#displaytoday" data-toggle="tab">Ongoing Programs</a></li>
			  <li class=""><a href="#displayprog" data-toggle="tab">Upcoming Programs</a></li>
			  <li class=""><a href="#displaycancel" data-toggle="tab">Cancelled Programs</a></li>
			  <li class=""><a href="#search_prog" data-toggle="tab">Search Programs</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane fade" id="programs">
			<form action="action/register-action.php" method="POST" role="form" id="addForm">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Make A New Program</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>Program Name: </td><td><input type="text" class="form-control" placeholder="Enter Program Name" name="ename" id="inputDefault" required/></td></tr>
						<tr><td>Program Venue: </td><td><input type="text" class="form-control" placeholder="Enter Venue" name="evenue" id="inputDefault" required/></td></tr>
						<tr><td>Program Schedule Start: </td><td><input type="datetime-local" class="form-control" name="edates" placeholder="" id="inputDefault" required/></td></tr>
						<tr><td>Program Schedule End: </td><td><input type="datetime-local" class="form-control" name="edatee" placeholder=" " id="inputDefault" required/></td></tr>
						<tr><td>Program Category: </td><td><input type="radio" name="event_category" class="prog_cat" value="Education">Education<br>
											                   <input type="radio" name="event_category" class="prog_cat" value="Health Services">Health Services<br>
											                   <input type="radio" name="event_category" class="prog_cat" value="Peace and Order">Peace and Order<br>
											                   <input type="radio" name="event_category" class="prog_cat" value="Transportation">Transportation<br>
											                   <input type="radio" name="event_category" class="prog_cat" value="Solid Waste Management">Solid Waste Management<br>
											                   <input type="radio" name="event_category" class="prog_cat" value="Use of Barangay Facilities">Use of Barangay Facilities</td></tr>
						<tr><td>Program Participants Category: </td> <td><input type="checkbox" name="event_part_cat[]" class="part_cat" value="Seniors">Seniors<br>
											                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Youth">Youth<br>
											                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Children">Children<br>
											                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Women">Women<br>
											                   <input type="checkbox" name="event_part_cat[]" class="part_cat" value="Men">Men</td></tr>
						<tr><td>Program Participants: </td> <td><div class="loadingDiv"><img src="img/loading.gif" /></div><div class="participants"></div></td></tr>
						<tr><td>Program Description: </td> <td><textarea id="event_desc" name="event_desc" style="width: 400px; height: 100px;">
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
					                <input id="event_budget" onkeypress="return isNumberKey(event)" type="text" name="event_budget"></td></tr>          
					      <tr><td>Program Sponsors: </td> <td><textarea  id="event_sponsors" name="event_sponsors" style="width: 400px; height: 100px;">
					                </textarea>
					                
					<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="event_status" value="1"><button name="programs" class="btn btn-primary">Submit</button></td></tr>

						</tbody>';
					echo '</table>
				</form>
			  </div>';
			  echo '<div class="tab-pane fade" id="displaypast">';

			  		echo display_past();
			  echo '</div><div class="tab-pane fade active in" id="displaytoday">';

			  		echo display_present();//today	
			  echo '</div><div class="tab-pane fade" id="displayprog">';

			  		echo display_incoming();//incoming

			  echo '</div><div class="tab-pane fade" id="displaycancel">';

			  		echo display_cancelled();//cancelled


			  echo' </div><div class="tab-pane fade " id="search_prog">
			  	<form action="action/search-action.php" method="POST" role="form">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Search Programs</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>Enter Program Name: </td><td><input type="text" class="form-control"  name="progname" id="inputDefault" required/></td></tr>
						<tr><td>Enter Program Venue: </td><td><input type="text" class="form-control"  name="evenue" id="inputDefault" required/></td></tr>
						<tr><td>Enter Program Schedule: </td><td><input type="date" class="form-control" name="esched" id="inputDefault" required/></td></tr>
						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="searchprog" class="btn btn-primary">Submit</button></td></tr>
						</tbody>';
					echo '</table>
				</form>
				</div>';

			  '</div>
			</div>
		</div>
	</div>
</div>';
}
else //if(isset($_SESSION['usertype']) && $_SESSION['usertype']!=2 || isset($_SESSION['usertype']) && $_SESSION['usertype']!=1)
{
	echo '<div class="container shadow">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<ul class="nav nav-tabs">
			  <li class=""><a href="#displaypast" data-toggle="tab">Past Programs</a></li>
			  <li class="active"><a href="#displaytoday" data-toggle="tab">Ongoing Programs</a></li>
			  <li class=""><a href="#displayprog" data-toggle="tab">Upcoming Programs</a></li>
			  <li class=""><a href="#displaycancel" data-toggle="tab">Cancelled Programs</a></li>
			  <li class=""><a href="#search_prog" data-toggle="tab">Search Programs</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
			 ';
			  echo '<div class="tab-pane fade" id="displaypast">';

			  		echo display_past();
			  echo '</div><div class="tab-pane fade active in" id="displaytoday">';

			  		echo display_present();//today	
			  echo '</div><div class="tab-pane fade" id="displayprog">';

			  		echo display_incoming();//incoming

			  echo '</div><div class="tab-pane fade" id="displaycancel">';

			  		echo display_cancelled();//cancelled


			  echo' </div><div class="tab-pane fade " id="search_prog">
			  	<form action="action/search-action.php" method="POST" role="form">
					<table class="table table-striped table-hover">
						<thead><tr><td colspan="2" align="center"><h1 class="text-success">Search Programs</h1></td><td></td></tr></thead>
						<tbody>
						<tr><td>Enter Program Name: </td><td><input type="text" class="form-control"  name="progname" id="inputDefault" required/></td></tr>
						<tr><td>Enter Program Venue: </td><td><input type="text" class="form-control"  name="evenue" id="inputDefault" required/></td></tr>
						<tr><td>Enter Program Schedule: </td><td><input type="date" class="form-control" name="esched" id="inputDefault" required/></td></tr>
						<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="searchprog" class="btn btn-primary">Submit</button></td></tr>
						</tbody>';
					echo '</table>
				</form>
				</div>';

			  '</div>
			</div>
		</div>
	</div>
</div>';
}
	include('footer.php')


?>