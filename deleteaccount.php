<?php
    require 'connect.php';
    

    if (isset($_POST['accountNumber'])) {
        //Get the account number
         delete();
  
    }

    function delete(){
        global $conn;
      
        $accountNumber = $_POST['accountNumber'];

        //Connect to the database
        $conn = connect();

        $stmt = $conn->prepare("SELECT Balance FROM Accounts WHERE ACID = $accountNumber");
        $stmt->execute();
        $result = $stmt -> fetchall(PDO :: FETCH_ASSOC);

        $balance = $result[0]['Balance'];
        
        if($balance==0){
            //Delete the account only if the balance is equal to 0.
            $stmt = $conn->prepare("DELETE FROM Accounts WHERE ACID = $accountNumber");
            $stmt->execute();

            echo 1;
        }
        else {
            echo 0;
        }
      }
?>