<!DOCTYPE html>
<?php
session_start();

require ("./ScheduleEmployees.php");

if (!isset($_SESSION['auth'])) {
	header( 'Location: http://localhost/index.html');
}
if ($_SESSION['type'] == "MANAGER") {
	scheduleEmployees();
}

if ($_SESSION['type'] === "MANAGER") {
	echo '
	<script>
	//Manager scripts here.

		function addEmployee() {
			var username = document.getElementById("employeeUsername").value;
			var password = document.getElementById("employeePassword").value;
			var firstName = document.getElementById("firstName").value;
			var middleName = document.getElementById("middleName").value;
			var lastName = document.getElementById("lastName").value;
			var address = document.getElementById("address").value;
			var phone = document.getElementById("phone").value;
			var email = document.getElementById("email").value;
			var dob = document.getElementById("dobField").value;
			var sex = document.getElementById("sex").value;
			var city = document.getElementById("city").value;
			var state = document.getElementById("state").value;
			var zip = document.getElementById("zip").value;
			var type = document.getElementById("type").value.toUpperCase();
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					console.log(xmlhttp.responseText);
					clickButton("my_schedule");
				}
			}
			xmlhttp.open("POST", "./AddEmployee.php?username="+username+"&password="+password+"&firstName="+firstName+"&middleName="+middleName+"&lastName="+lastName +
					"&address="+address+"&phone="+phone+"&email="+email+"&dob="+dob+"&sex="+sex+"&city="+city+"&state="+state+"&zip="+zip+"&type="+type);
			xmlhttp.send();
		}

		function fetchEmployeeDetails() {
			var username = document.getElementById("employeeUsername").value;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					if (xmlhttp.responseText == "Employee does not exist.") {
						document.getElementById("errorDiv").innerHTML = xmlhttp.responseText;
					} else {
						console.log(xmlhttp.responseText);
						var json = JSON.parse(xmlhttp.responseText);
						document.getElementById("address").value = json[0][\'address\'];
						document.getElementById("phone").value = json[0][\'phone\'];
						document.getElementById("email").value = json[0][\'email\'];
						document.getElementById("city").value = json[0][\'city\'];
						document.getElementById("state").value = json[0][\'state\'];
						document.getElementById("zip").value = json[0][\'zip\'];
						document.getElementById("type").value = json[0][\'type\'];
					}
				}
			}
			xmlhttp.open("GET", "./FetchEmployee.php?employee="+username, true);
			xmlhttp.send();
		}

		function updateEmployee() {
			var username = document.getElementById("employeeUsername").value;
			var address = document.getElementById("address").value;
			var phone = document.getElementById("phone").value;
			var email = document.getElementById("email").value;
			var city = document.getElementById("city").value;
			var state = document.getElementById("state").value;
			var zip = document.getElementById("zip").value;
			var type = document.getElementById("type").value.toUpperCase();
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					console.log(xmlhttp.responseText);
					clickButton("my_schedule");
				}
			}
			xmlhttp.open("POST", "./EditEmployee.php?username="+username+
					"&address="+address+"&phone="+phone+"&email="+email+"&city="+city+"&state="+state+"&zip="+zip+"&type="+type);
			xmlhttp.send();
		}
	</script>
	';
}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Main</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./calendarview-1.2/stylesheets/calendarview.css">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script src="./calendarview-1.2/javascripts/prototype.js"></script>
	<script src="./calendarview-1.2/javascripts/calendarview.js"></script>
	<script>
	// Views:
	/*
	*	ViewSched = 0;
	*	SchedAppt. = 1;
	*	AddEmployee = 2;
	*	EditEmployee = 3;
	*	ViewEmployeeSchedule = 4;
	*/
	var currentView = 0;
	var currentYear = -1;
	var currentMonth = -1;
	var currentDay = -1;
	function setupCalendar() {
		// Embedded Calendar
		document.getElementById("embeddedCalendar").innerHTML = "";
		Calendar.setup(
			{
				parentElement: 'embeddedCalendar'
			}
		)
	}

	function deleteAppointment(id) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				console.log("Response: "+xmlhttp.responseText);
				showShiftInformation(currentYear, currentMonth, currentDay);
			}
		}
		xmlhttp.open("POST", "./deleteAppointment.php?id="+id, true);
		xmlhttp.send();
	}

	function showShiftInformation(year, month, day) {
		currentYear = year;
		currentMonth = month;
		currentDay = day;
		if (currentView == 0) {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				//4 = finished, 200 = found. 404 !!!! 404!!!!!!!!!
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					console.log("Response: "+xmlhttp.responseText);
					document.getElementById("side_area").innerHTML = getShiftInfo(xmlhttp.responseText);
				}
			}
			xmlhttp.open("POST", "./GetShift.php?year="+year+"&month=" + month + "&day=" + day, true);
			xmlhttp.send();
			console.log("Get info for "+year+", "+month+", "+day);
		}
	}

	function submitAppointment() {
		var time = document.getElementById("apptTime").value;
		var details = document.getElementById("apptDetails").value;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				console.log("Response: "+xmlhttp.responseText);
				currentView = 0;
				showShiftInformation(currentYear, currentMonth, currentDay);
			}
		}
		xmlhttp.open("POST", "./CreateAppointment.php?year="+currentYear+"&month="+currentMonth+"&day="+currentDay+"&time="+time+"&details="+details, true);
		xmlhttp.send();
	}

	function getShiftInfo(time) {
		var times = time.split(",");
		var start = new Date(1970, 0, 1);
		start.setSeconds(times[0]);
		var end = new Date(1970, 0, 1);
		end.setSeconds(times[1]);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("appointmentDetails").innerHTML = xmlhttp.responseText;
				console.log(xmlhttp.responseText);
			}
		}
		xmlhttp.open("GET", "./GetAppointments.php?year="+start.getFullYear()+"&month="+start.getMonth()+"&day="+start.getDate(), true);
		xmlhttp.send();
		return "<h3>On "+start.toDateString()+"</h3><br>Your shift starts at: <br>"+start.toTimeString()+"<br> and ends at: <br>"+end.toTimeString()+"<br><br><br><p><h4>Appointment Details:</h4><div id='appointmentDetails'></div></p>";
	}

	function updatePunchStatus() {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				if (xmlhttp.responseText === "true") {
					document.getElementById("clockstatus").innerHTML = "You're currently clocked in.";
					document.getElementById("toggleclockstatus").value = "Clock Out";
				} else {
					document.getElementById("clockstatus").innerHTML = "You're not currently clocked in.";
					document.getElementById("toggleclockstatus").value = "Clock In";
				}
			}
		}
		xmlhttp.open("GET", "./IsClockedIn.php", true);
		xmlhttp.send();
	}

	function clockIn() {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				console.log(xmlhttp.responseText);
				updatePunchStatus();
			}
		}
		xmlhttp.open("POST", "./ToggleClockState.php", true);
		xmlhttp.send();
	}

	function clickButton(button) {
		var xmlhttp = new XMLHttpRequest();
		switch (button) {
			case "logout":
			xmlhttp.onreadystatechange = function() {
				//4 = finished, 200 = found. 404! 404 NF!!!!
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					window.location = "http://localhost/index.html";
				}
			};
			xmlhttp.open("POST", "./logout.php", true);
			xmlhttp.send();
			break;
			case "my_schedule":
				currentView = 0;
				document.getElementById("side_area").innerHTML = "";
				if (currentYear != -1) {
					showShiftInformation(currentYear, currentMonth, currentDay);
				}
				console.log("Pressed MySched");
				break;
			case "schedule_appt":
				currentView = 1;
				if (currentYear != -1) {
					document.getElementById("side_area").innerHTML =
					'Appointment Time: <input type="text" id="apptTime"></input><br>' +
					'Appointment Details: <br><textarea id="apptDetails"></textarea><br>' +
					'<input type="button" onclick="submitAppointment();" value="Submit"/>';
				}
				console.log("Pressed Schedule Appt");
				break;
			case "clockIn":
				clockIn();
				break;
			case "add_employee":
				if (currentView != 2) {
					document.getElementById("side_area").innerHTML =
						"<fieldset>" +
						"Employee Username: <br> <input type='text' id='employeeUsername' /><br>" +
						"Employee Password: <br> <input type='password' id='employeePassword' /><br>" +
						"First Name: <br> <input type='text' id='firstName' /><br>" +
						"Middle Name: <br> <input type='text' id='middleName' /><br>" +
						"Last Name:	<br>		<input type='text' id='lastName' /><br>" +
						"Address: <br>          <input type='text' id='address' /><br>" +
						"Phone:   <br>          <input type='text' id='phone' /><br>" +
						"Email:   <br>          <input type='text' id='email' /><br>" +
						"DOB:     <br>          <input type='text' id='dobField' /><br>" +
						"Sex:    <br>           <input type='text' id='sex' /><br>" +
						"City:   <br>           <input type='text' id='city' /><br>" +
						"State:  <br>           <input type='text' id='state' /><br>" +
						"Zip:   <br>            <input type='text' id='zip' /><br>" +
						"Type:   <br>           <input type='text' id='type' /><br>" +
						"<br><input type='button' id='submitEmployee' value='Submit' onclick='addEmployee();'/> <br>" +
						"<div id='confirmation'></div>" +
						"</fieldset>";
				}
				currentView = 2;
				console.log("Pressed add employee");
				break;
			case "edit_employee":
			if (currentView != 3) {
				document.getElementById("side_area").innerHTML =
					"<fieldset>" +
					"Employee Username: <br> <input type='text' id='employeeUsername' /><br>" +
					"<br><input type='button' id='fetchDetails' value='Fetch Details' onclick='fetchEmployeeDetails();' /> <br>" +
					"<div id='errorDiv'></div>" +
					"</fieldset>" +
					"<br>" +
					"<fieldset>" +
					"Address: <br>          <input type='text' id='address' /><br>" +
					"Phone:   <br>          <input type='text' id='phone' /><br>" +
					"Email:   <br>          <input type='text' id='email' /><br>" +
					"City:   <br>           <input type='text' id='city' /><br>" +
					"State:  <br>           <input type='text' id='state' /><br>" +
					"Zip:   <br>            <input type='text' id='zip' /><br>" +
					"Type:   <br>           <input type='text' id='type' /><br>" +
					"<br><input type='button' id='submitEmployee' value='Submit' onclick='updateEmployee();'/> <br>" +
					"</fieldset>";
			}
			currentView = 3;
			console.log("Pressed edit employee");
			break;
			case "view_employee_schedule":
				if (currentView != 4) {
					document.getElementById("side_area").innerHTML =
					"Employee Username: <br> <input type='text' id='employeeUsername' /><br>"+
					"<br><input type='button' id='fetchSchedule' value='Fetch' onclick='fetchEmployeeSchedule();' />";
				}
				currentView = 4;
				console.log("Pressed employee schedule");
				break;
		}
	}
	</script>
</head>

<body>

	<div class="container">
		<div class="header"><?php echo '
		<input class="content" id="logout" type="button" value="Logout" onclick="clickButton(\'logout\');" />
		<input class="content" id="my_schedule" type="button" value="My Schedule" onclick="clickButton(\'my_schedule\');" />
		<input class="content" id="schedule_appt" type="button" value="Schedule Appt." onclick="clickButton(\'schedule_appt\');" />'; if ($_SESSION['type'] == "MANAGER") { echo '
			<input class="content" id="add_employee" type="button" value="Add Employee" onclick="clickButton(\'add_employee\');" />
			<input class="content" id="edit_employee" type="button" value="Edit Employee" onclick="clickButton(\'edit_employee\');" />
			'; } ?>
		</div>
		<br>
		<div id="clockstatus" class="content"></div>
		<div class="content">
			<input id="toggleclockstatus" class="content" type="button" value="Clock In" onclick="clickButton('clockIn');" />
		</div>
		<br>
		<div id="content_area" class="content">
			<div id='embeddedCalendar'></div>
		</div><div id="side_area" class="content"></div>
		<div class="footer">
			Copyright© 2015-2016 Group 30, Inc.
		</div>
	</div>
</body>
</html>
<script>
setupCalendar();
updatePunchStatus();
</script>
