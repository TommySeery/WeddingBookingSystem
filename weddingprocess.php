<?php
    if($_SERVER["REQUEST_METHOD"]=="GET") {

        $date = $_REQUEST["date"];
        $size = $_REQUEST["partySize"];
        $grade = $_REQUEST["cateringGrade"];

            include "coa123-mysql-connect.php";
    
            $conn = mysqli_connect($servername,$username,$password,$dbName);
        
            if(!$conn){
                die("Connection failed: ".mysqli_connect_error());
            }
            $allDataArray = array(); //create empty array
            $sql = "SELECT name, capacity, licensed, cost, weekday_price, weekend_price,
            CASE WHEN WEEKDAY('{$date}') < 5 THEN weekday_price + (cost*{$size})
            ELSE weekend_price + (cost*{$size})
            END AS 'total', 
            COUNT(name), DAYNAME('{$date}') 
            FROM venue 
            INNER JOIN venue_booking 
            ON venue.venue_id = venue_booking.venue_id 
            INNER JOIN catering 
            ON venue.venue_id = catering.venue_id AND name NOT IN(SELECT name 
            FROM venue 
            INNER JOIN venue_booking 
            ON venue.venue_id=venue_booking.venue_id 
            AND booking_date='{$date}') 
            AND grade={$grade} 
            AND capacity>={$size}
            GROUP BY name, capacity, cost, weekend_price, weekday_price, licensed";
            $result = mysqli_query($conn,$sql);
    
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    $allDataArray[]=$row;
                }
            }
    
            echo json_encode($allDataArray); 
            mysqli_close($conn);
    }
    ?>