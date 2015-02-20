<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript">
function goBack() {
    window.history.back()

}
</script>
</head>
<body background="img/background.jpg">
<font face="tahoma">

<title>Registration</title>
</br>
</br>
</br>
</br>
	<table align="center">
	<tr>
	<td>
		<div>
				<form action="register-action.php" method="GET">
					<table align="left">
					<tr><td><center>First Name<input type="text" name="fname" placeholder="First Name" required/></center></td></tr>
					<tr><td><center>Middle Name<input type="text" name="mname" placeholder="Middle Name" required/></center></td></tr>
					<tr><td><center>Last Name<input type="text" name="lname" placeholder="Last Name" required/></center></td></tr>
					<tr><td><center>Birthday<input type="date" name="bday" placeholder="Birthday" required/></center></td></tr>
					<tr><td><center>Contact No.<input type="int" name="contact" placeholder="Contact No." required/></center></td></tr>
					<tr><td><center>E-Mail<input type="email" name="email" placeholder="E-Mail" required/></center></td></tr>
					<tr><td><center>Sitio<input type="text" name="sitio" placeholder="Sitio" required/></center></td></tr>
					<tr><td><center>Mother's First Name<input type="text" name="mfname" placeholder="First Name" required/></center></td></tr>
					<tr><td><center>Mother's Last Name<input type="text" name="mlname" placeholder="Last Name" required/></center></td></tr>
					<tr><td><center>Father's Last Name<input type="text" name="ffname" placeholder="First Name" required/></center></td></tr>
					<tr><td><center>Father's Last Name<input type="text" name="flname" placeholder="Last Name" required/></center></td></tr>
					<tr><td></br><button onclick="goBack()">Go Back</button></td><td align="center"></br><button>Submit</button></td></tr>
					</table>
				</form>
		</div>
	</td>
	</tr>
	</table>

<?php

include('footer.php');

?>