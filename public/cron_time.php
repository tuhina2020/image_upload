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
				$obj = new CronJob();
				$obj->cronJob();
			    $this->last = $now;
			}
		}
	}
?>
