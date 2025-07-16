<?php

    echo 'Укажите через запятую номер первого и последнего месяца в периоде для расчета календаря' . PHP_EOL;   

    $month_period = trim(fgets(STDIN));

    function jobCalendar ( string $month_period ): void {
        $months = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
        $mp = explode(',', $month_period);
        if (empty($mp[0]) || empty($mp[1])) {
            fwrite(STDERR, "Номер месяца не указан" . PHP_EOL);
            return;
	    }
        $month = (int)trim($mp[0]);
        $end_month = (int)trim($mp[1]);
        $tz = ini_get('date.timezone');
        $dtz = new DateTimeZone($tz);

        $i = 0;

        while ($month <= $end_month) {
            
            $dts = new DateTime("2025-$month", $dtz);
            $endDate = date('t', strtotime("2025-$month"));
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($dts, $interval, $endDate - 1);            
        
            echo $months[$dts->format("m") - 1] . PHP_EOL;    

            $dates = [];

            foreach ($period as $date) {        
                $dates[] = $date->format("d - D");        
            }

            for ( ; $i < ($endDate) ; ) {
                if(str_contains($dates[$i], 'Sat') || str_contains($dates[$i], 'Sun')) {
                    ++$i;
                } else { 
                    $dates[$i] = "$dates[$i] - рабочий день";
                    $i = $i + 3; 
                }           
            }

            foreach($dates as $date) {
                echo $date . PHP_EOL;
            }

            $month += 1;            
            
            foreach(array_reverse($dates) as $key => $date) {
                if(str_contains($date, 'рабочий день')) {
                    $last_index = $key;
                    break;
                }
            }
            if ($last_index > 1) {
                $i = 0;
            } else {
                $i = 2 - $last_index;
            }                       
        }
    }

    jobCalendar ( $month_period );

?>