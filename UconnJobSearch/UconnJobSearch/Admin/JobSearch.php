<?php
    include_once './../includes/DatabaseConnector.php';
	class JobSearch{
		
		private $searchParameters;
		
		public function JobSearch($SearchInfo){
			$this->searchParameters = $SearchInfo;
		}
		public function viewAllSeekers(){
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT user.UFName, user.ULName, user.UStreet1, user.UEmail, user.UState 
			FROM seeker INNER JOIN user WHERE seeker.UName = user.UName ORDER BY user.UState";
			$results = $db->query($query);
			return $results;
		}
		public function searchBySalaryAndTitle(){
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT JobID, CName, JTitle FROM job WHERE  JTitle 
			LIKE '%" . $this->searchParameters['title'] . "%' AND JHighRange>=" . $this->searchParameters['salary'];
			$results = $db->query($query);
			return $results;
		}
		public function searchByCompany(){
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT JobID, JTitle, JListDate FROM job WHERE CName LIKE '%" . $this->searchParameters['company'] . "%' ORDER BY JTitle";
			$results = $db->query($query);
			return $results;
		}
			public function searchByJobID(){
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT user.UName, user.UStreet1, user.UEmail FROM jobapp INNER JOIN user 
			WHERE jobapp.UName = user.UName AND jobapp.JobID=".intval($this->searchParameters['JobID']);
			//print($query);
			$results = $db->query($query);
			return $results;
		}
			public function searchByUniv(){
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT user.UName, user.UStreet1, user.UEmail FROM user INNER JOIN education INNER JOIN resume 
			WHERE user.UName = resume.UName AND resume.ResumeID = education.ResumeID AND education.EDegreeType LIKE '%Bachelor%'
			AND education.EUniversity LIKE '%" . $this->searchParameters['univ'] . "%'";
			//education.EDegreeType LIKE 'Bachelor's' 
			$results = $db->query($query);
			return $results;
			}
			public function searchBySeeker(){
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT user.UFName, user.ULName, job.CName, job.JobID, job.JListDate, job.JTitle FROM job INNER JOIN jobapp INNER JOIN user 
			WHERE job.JobID = jobapp.JobID AND user.UName = jobapp.UName AND user.ULName
			LIKE '%" . $this->searchParameters['lname'] . "%'";
			$results = $db->query($query);
			return $results;
			}
			public function searchByDateRange(){
			//print(json_encode($this->searchParameters));
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT job.JobID, job.CName, job.JTitle, job.JListDate FROM job WHERE  JListDate 
			>= '" . $this->searchParameters['startDate'] . "' AND JListDate<= '" . $this->searchParameters['endDate']."'";
			//print($query.$searchParams);
			$results = $db->query($query);
			return $results;
			}
			public function viewPaymentReport(){
			//print(json_encode($this->searchParameters));
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT payment.PaymentID, payment.PAmount, payment.PStatus, payment.PDate
			FROM job INNER JOIN payment INNER JOIN postpay 
			WHERE job.JobID = postpay.JobID AND payment.PaymentID = postpay.PaymentID 
			AND JListDate >= '" . $this->searchParameters['startDate'] . "' AND JListDate<= '" . $this->searchParameters['endDate']."'";
			//print($query.$searchParams);
			$results = $db->query($query);
			return $results;
			}
			//skills
			public function searchBySkills(){
			//print(json_encode($this->searchParameters));
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT DISTINCT job.JobID, job.JTitle, job.JListDate FROM job INNER JOIN requiresskill 
			WHERE job.JobID = requiresskill.JobID AND ";
			$searchParams = '';
			foreach($this->searchParameters as $key=>$value){
				$searchParams =  $searchParams."requiresskill.SSkillName=". "'".$key."' OR ";
			}
			$searchParams = substr($searchParams, 0, -4);
			//print($query.$searchParams);
			$results = $db->query($query.$searchParams);
			return $results;
			}
			public function searchBySkillsSeeker(){
			//print(json_encode($this->searchParameters));
			$db = new DatabaseConnector();
			$db->connect();
			$query="SELECT user.UName, user.UFName, user.ULName, user.UStreet1, user.UEmail 
			FROM user INNER JOIN resume INNER JOIN hasskill
			WHERE resume.ResumeID = hasskill.ResumeID AND resume.UName = user.UName AND ";
			$searchParams = '';
			foreach($this->searchParameters as $key=>$value){
				$searchParams = $searchParams."hasskill.SSkillName=". "'".$key."' OR ";
			}
			$searchParams = substr($searchParams, 0, -4);
			//print($query.$searchParams);
			$results = $db->query($query.$searchParams);
			return $results; 
			}
	}
	//new JobSearch($_GET);
?>