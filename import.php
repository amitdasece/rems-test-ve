<?php
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "symfony_work";


$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";



$row = 1;
if (($handle = fopen("sample_data1.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";

        if ($row !== 1) {
            //for ($c=0; $c < $num; $c++) {
                //echo $data[$c] . "<br />\n";
                 $tableNo = $data[5];
                 $maxGeuest = $data[6];
                 $firstName = $data[2];
                 $lastName = $data[3];
                 $email = $data[4];
                 $seatedAt = date('Y-m-d h:i:s',strtotime($data[0] ." ". $data[1]));
                 $totalAmount = $data[7]*100;
           // }

            $tablesql = "INSERT INTO `table` (`number`, `max_guests`) VALUES ($tableNo, $maxGeuest)";
             //$result = $conn->query($tablesql);
            // $table_id = $conn->insert_id;
            if ($conn->query($tablesql) === TRUE) {
                    $table_id = $conn->insert_id;
                    echo "New record created successfully. Last inserted ID is: " . $table_id;

                    echo $guestsql = "INSERT INTO `guest` (`first_name`, `last_name`, `email`) VALUES ('".$firstName."', '".$lastName."', '".$email."')";
                   // $result1 = $conn->query($guestsql);
               // $userId = $conn->insert_id;
                    if ($conn->query($guestsql) === TRUE) {
                        $userId = $conn->insert_id;
                        echo "New record created successfully. Last inserted ID is: " . $userId;

                       echo $booksql = "INSERT INTO `booking` (`booked_by_id`, `reserved_table_id`, `seated_at`, `party_size`, `total_amount`) VALUES ($userId, $table_id, '". $seatedAt ."', $maxGeuest, $totalAmount)";
                        $result2 = $conn->query($booksql);
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }


            // $guestsql = "INSERT INTO `guest` (`first_name`, `last_name`, `email`) VALUES ($firstName, $lastName, $email)";
           //  $result1 = $conn->query($guestsql);
             //$userId = $conn->insert_id;


             /*$booksql = "INSERT INTO `booking` (`booked_by_id`, `reserved_table_id`, `seated_at`, `party_size`, `total_amount`) VALUES ($userId, $table_id, $seatedAt, $maxGeuest)";
             $result = $conn->query($booksql);*/


        }

        $row++;
    }
    fclose($handle);
}
?>
