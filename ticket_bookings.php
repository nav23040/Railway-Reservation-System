<?php
	session_start();
	$agent_email = "Not_logged";
	$agent_email = $_SESSION['email'];
	// $pnr_num = $_GET['mypnr'];
	

		$conn = mysqli_connect("localhost","test","123","railway_tickets");
		if(!$conn){ 
			echo "Error".mysql_error();
		}

	if(!isset($_SESSION['email'])){
		header('Location : login.php');
		$message = "Not Logged in! Error";
	}

		
	$sql = "SELECT pnr_booked FROM agent_bookings WHERE email='$agent_email'";

	$result = $conn->query($sql);

	$pnr_list = array();
	while($r =  mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$pnr_list[] = $r;
	}

	$pass_list = array();
	foreach($pnr_list as $pnr_num ){

		$pnr_no = (int)$pnr_num['pnr_booked'];


		$sql = "SELECT pnr, trainnum, date_of_journey FROM ticket_details WHERE pnr='$pnr_no'";

		$result = $conn->query($sql);
		
		$pass_list1 = array();
		while($r =  mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$pass_list1[] = $r;
		}

		// print_r($pass_list);
		$train_no = $pass_list1[0]['trainnum'];
		$doj = $pass_list1[0]['date_of_journey'];
		$num_pass = count($pass_list1);
		$pass_list[] =  array('pnr' => $pnr_no, 'trainnum' => $train_no, 'date_of_journey' => $doj, 'num_pass' => $num_pass);
		

	}



	$sql="SELECT name from booking_agent WHERE email='$agent_email'";
	$result=$conn->query($sql);
	$r =  mysqli_fetch_array($result, MYSQLI_ASSOC);
	$agent_name=$r['name'];
	

 ?> 

<!DOCTYPE html>
<html>
<head>
	<title>Agent Bookings</title>
</head>

<style>
		#tkt	{
			margin:auto;
			margin-top: 70px;
			width: 50%;
			height: 60%;
			padding: auto;
			padding-top: 40px;
			padding-left: 20px;
			border: 2px solid white;
			background-color: rgba(0,0.1,0.2,0.5);
	    	/*box-shadow: inset -2px -2px rgba(0,0,0,0.5);*/
			border-radius: 25px;
		}
		html { 
		  background: url(image.jpg) no-repeat center center fixed; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}
		#journeytext	{
			color: white;
			font-size: 28px;
			font-family:"Comic Sans MS", cursive, sans-serif;
		}
		.data	{
		font-size: 20px;
		color: white;
		}
		.data1	{
		font-size: 20px;
		color: white;
		}
	</style>


<body>


	 <?php include ('header.php'); ?> 
	<div id="tkt">
	
		<h1 align="center" id="journeytext">Agent Bookings</h1><br/><br/>



		<table>

			<tr>
				<div class="data">Booking agent Name: 
					<?php echo $agent_name; ?>
				</div>
			</tr>
			<tr></tr>
			<tr>
				<div class="data">Booking agent E-mail: 
					<?php echo $agent_email; ?>
				</div>
			</tr>
			<tr></tr>

		</table>
		<table class="data1">
			<tr>
				 <td class="data1">PNR</td> 
				 <td></td>
				 <td>Train Number</td>
				 <td></td>
				 <td>Date of Journey</td>
				 <td></td> 	
				 <td>Number of Passenger</td>
				 <td></td> 				          			          
			</tr>
			
				<?php foreach ($pass_list as $pnr) {?>
					<tr>
						
						<td> <a href=<?php echo "ticket.php?mypnr=".$pnr['pnr']; ?> >  <?php  echo '      '.$pnr['pnr']?> </a> </td> <td></td> 
						&emsp;&nbsp;

						<td><?php  echo '      '.$pnr['trainnum']?></td><td></td> 

						<td><?php  echo '      '.$pnr['date_of_journey']?></td><td></td> 
						
						<td><?php  echo '      '.$pnr['num_pass']?></td><td></td> 
					
					</tr>

				<?php } ?>
			<tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr>
		</table>

		

	</div>

</body>
</html>