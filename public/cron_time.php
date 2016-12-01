<?php
	class Scheduler {
		private $last;

		function __construct() {
			require_once dirname(__FILE__) . '/cron_job.php';
			$this->last = time();
		}

		public function execute() {
			$now = time();
			$diff = $now - $this->last;
			if(abs($diff)== 3600) {
			    $ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8080/cron_job.php');
			    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
			    curl_exec($ch);
			    curl_close($ch);
			    $this->last = $now;
			}
		}
	}
?>
