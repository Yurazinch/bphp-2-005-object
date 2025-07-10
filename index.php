<?php

    echo 'Укажите номер месяца' . PHP_EOL;   

    $month = (int)trim(fgets(STDIN));

    function jobCalendar ( int $month ): void 
    {
        $months = array('январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
        $tz = ini_get('date.timezone');
        $dtz = new DateTimeZone($tz);
        $dts = new DateTime("2025-$month", $dtz);

        $endDate = date('t', strtotime("2025-$month"));
        $interval = new DateInterval('P1D'); // Интервал в 1 день
        $period = new DatePeriod($dts, $interval, $endDate - 1);
    
        echo $months[$dts->format("m") - 1] . PHP_EOL;    

        $dates = [];

        foreach ($period as $date) 
        {        
            $dates[] = $date->format("d");        
        }

        for ($i = 0; $i < $endDate; ) 
        {
            $dates[$i] = "$dates[$i] - рабочий день";
            $i = $i + 3;
        }

        foreach($dates as $date) 
        {
            echo $date . PHP_EOL;
        }
    }

    jobCalendar ( $month );

?>