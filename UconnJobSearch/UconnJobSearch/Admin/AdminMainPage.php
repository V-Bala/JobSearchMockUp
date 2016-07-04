<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>AdminMainPage</title>
		<meta name="author" content="Vijay" />
		<!-- Date: 2015-04-27 -->
		<link rel="stylesheet" type="text/css" 
		href="admincss.css">
	</head>
	
	<?php
		session_start();
		require "./../includes/login.handler.php";
		if(!validLogin('admin')) die();
	?>
	
	<body>
		<h1>Please select a report to generate:</h1>
		<form name="search" action="ViewAllJobSeekers.php" method="post">
			<input class="button"type="button" name="ViewAllJobSeekers" onclick="window.location.href='ViewAllJobSeekers.php'" id="viewall" 
			value="View All Job Seekers"/>	
		</form>
<form>
			<input class="button"type="button" name="SearchBySeeker" id="seeker"
			value="Search by Seeker" onclick="window.location.href='SearchBySeeker.html'"/>
			<input class="button"type="button" name="SearchByCompany" id="company"
			value="Search by Company" onclick="window.location.href='SearchByCompany.html'"/>
			<input class="button"type="button" name="SearchByDateRange"id="date"
			value="Search by Date Range" onclick="window.location.href='SearchByDateRange.html'"/>
			<input class="button"type="button" name="SearchBySalary" id="salary"
			value="Search by Salary" onclick="window.location.href='SearchBySalary.html'"/>
			<input class="button"type="button" name="SearchByJobID" id="jobid"
			value="Search by JobID" onclick="window.location.href='SearchByJobID.html'"/>
			<input class="button"type="button" name="SearchByUniv" id="univ"
			value="Search by University" onclick="window.location.href='SearchByUniv.html'"/>
			<input class="button"type="button" name="SearchBySkills" id="skills"
			value="Search by Skills" onclick="window.location.href='SearchBySkills.php'"/>
			<input class="button"type="button" name="SearchBySkillsSeeker" id="skillsseeker"
			value="Search Seekers By Skills" onclick="window.location.href='SearchBySkillsSeeker.php'"/>
			<input class="button"type="button" name="ViewPaymentReport" id="payment"
			value="Generate Payment Report" onclick="window.location.href='ViewPaymentReport.html'"/>
		</form>
		
		<a href="/UconnJobSearch/includes/logout.php">Log out</a>
		
	</body>
</html>

