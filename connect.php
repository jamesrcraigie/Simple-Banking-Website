<?php
    // Function to conenct user to database.
    function connect(){
        $host = 'xxxx';
        $dbname = 'xxxx';
        $user = 'xxxxx';
        $pwd = 'xxxxx';
        try {
                    
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (!$conn) {
                
                echo 'Failed to connect to database';
            }
            
        } catch (PDOException $e) {
            echo "PDOException: ".$e->getMessage();
        }
        return $conn;
    }
    // Function to get curreny from product ID.
    function getCurrency($pid){
        if($pid==1 || $pid==2){
            return "USD";
        }
        if($pid==3){
            return "GBP";
        }
        if($pid==4){
            return "Euro";
        }
    }

?>