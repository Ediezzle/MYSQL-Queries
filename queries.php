<?php
	public function getEmployeeLatestHealthCovidStatusReportName($empoyeeId)
    {
        global $db;
        $sql = "SELECT m1.* FROM tbl_covid_staff_status m1 LEFT JOIN tbl_covid_staff_status m2 ON (m1.employee_id = m2.employee_id AND m1.id<m2.id) WHERE m2.id is NULL AND m1.employee_id = ".$db->sqs($empoyeeId);
        $response = $db->getRow($sql);
        if($response) {
            return $response;
        } else {
            return false;
        }
    }

    public function getMonthTotalStatuses()
    {
        global $db;

        $sql = "SELECT m1.* FROM tbl_covid_staff_status m1 LEFT JOIN tbl_covid_staff_status m2 ON (m1.employee_id = m2.employee_id AND m1.id<m2.id) WHERE m2.id is NULL AND DATEDIFF(now(),m1.date_created) <= 30";

        $response = $db->getAll($sql);
       
        if($response)
        {
            $finalResult = array();
            foreach($response as $result)
            {
                if($result['settings_id'] == 1 || $result['settings_id'] == 4)
                {
                    $finalResult[] = "selfIsolation";
                }

                if($result['settings_id'] == 3 || $result['settings_id'] == 6)
                {
                    $finalResult[] = "negative";
                }

                if($result['settings_id'] == 2 || $result['settings_id'] == 5)
                {
                    $finalResult[] = "positive";
                } 

            }

            return $finalResult;
             
        }
        
        else 
        {
            return false;
        }
    }
?>