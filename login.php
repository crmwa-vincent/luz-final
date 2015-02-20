<?php

include('header.php');

?>

</br>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-4 col">
		</div>
		<div class="col-md-5 col shadow">
	<tr><td colspan="2">
<table align="center">
	<form method="POST" action="action/login-action.php" role="form">
		<div class="form-group">
			<tr>
				<td colspan="2" align="center"><h1>Barangay Luz!</h1></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php 
					if(isset($_GET['error']) && $_GET['error'] == 1) 
					echo "<h4 class='text-danger'><center>Wrong username or Password</center></h4>";
					?>
				</td>
				<td>
				</td>
			</tr>
		  	<tr>
		  		<td></br><label for="inputEmail" class="col-lg-2 control-label">Username:</label></td>
			  	<div class="col-lg-10">
			    <td></br><input type="text" class="form-control" id="inputEmail" name="uname" placeholder="Enter Username" required/></td>
			</tr>
		  		</div>
		</div>
		<div class="form-group">
			<tr>
		  		<td></br><label for="inputPassword" class="col-lg-2 control-label">Password:</label></td>
		  		<div class="col-lg-10">
		  		<td></br><input type="password" class="form-control" id="inputPassword" name="pword" placeholder="Enter Password" required/></td>
			</tr>
			<tr>
				 <div class="checkbox">
			     <label>
			    <td></td>
			    <td align="center"></br><input type="checkbox"> Remember User?</td>
			    </label>
			    </div>
			</tr>
		    <tr>
		    	<td>
				</td>
				<td align="center"></br><button class="btn btn-primary" name="submit">Go!</button></td>
			</tr>
		  </div>
		</div>
	</form>
	<tr>
		<td>
		</td>
		<td align="center"></br>
		</td>
	</tr>
</table>
	</td><td></td></tr>
	</div>
	<div class="col-md-3 col">
	</div>
</div>
</div>

<?php

include('footer.php');

?>