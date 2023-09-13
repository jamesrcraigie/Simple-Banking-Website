<!-- Upon enter of the page the session variables are set using the post varliables and then the client is directed to the accounts page without any post variables set. 
This prevents post variables being initiated when the session is exited and the client presses the browser back button.  -->
<?php
    session_start();

    if (isset($_POST['cid']) && isset($_POST['customerName'])){
        $_SESSION['cid'] = $_POST['cid'];
        $_SESSION['customerName'] = $_POST['customerName'];
        header('Location: accounts.php');
    }
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Bank of Kent</title>
    <link rel="icon" type="image/x-icon" href="bank.png">
<!--Favicon was found here: 
        https://iconarchive.com/tag/bank-favicon
 -->    
 <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

 <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>

<!-- Delete function for the accounts table. -->
<script >
      // The function takes a single input, the account ID.
    function deleteAccount(acid){
        //find the row in the table
        const row = document.getElementById(acid);
        
        //asked user to cinfirm to delete the account, ACID is referenced.
        confirmed = confirm('Are you sure you want to delete this account account (ID: ' + acid +')?');
        if (confirmed) {
            
            $(document).ready(function(){
                $.ajax({
                // Action file
                    url: 'deleteaccount.php',
                // Method
                    type: 'POST',
                // Varialbes to be sent with POST
                    data: {
                        accountNumber: acid
                    },
                    success:function(response){
                   // Response is the output of deleteaccount.php, returns 1 if account has a balance of 0.
                        if(response == 1){
                            alert("Account " + acid + " Deleted Successfully");
                            //Dynamically remove row from table.
                            row.remove();
                            
                        }
                    // action file returns 0 if balance is not 0.
                    //Display error.
                       else if (response == 0) {
                            alert("Account Cannot Be Deleted");
                        }
                    }
                });
            });
        }
    }
</script>

</head>
<body>
    <img align = "left" src="Logo.png" alt="Bank Logo"/>
    <h1>Bank of Kent</h1>
<!--  Logo found here:
           https://logodix.com/logos/871229
 -->

 <hr id = 'line'>

<?php
    require 'connect.php';

    // Check that session variables are set. If not send the client to account error page.
    if (isset($_SESSION['cid']) && isset($_SESSION['customerName'])){
        $cid =$_SESSION['cid'];
        $name= $_SESSION['customerName'];
    }
    else {
        header('Location: accounterror.php');
    }

    
    // Connect to database.
    $conn = connect();
    //Prepare & execute SQL query for checking customer details
    $sql = "SELECT c.Name FROM Customers c WHERE CID = $cid";
    $handle = $conn->prepare($sql);
    $handle->execute();

    //Collect results of SQL query
    $result = $handle -> fetchall(PDO :: FETCH_ASSOC);

    //Find name accociated with account number proided by the client
    $checkName = $result[0]['Name'];

    //If name provided by client and the name accoiciated with account number do not match, send client to error page.
    if($checkName != $name){
        header('Location: accounterror.php');
    }
    echo "<h2> Welcome, " . Htmlspecialchars($name) . "! Here is a summary of your accounts: </h2>" ;

    //Retrieve accounts of customer from database.
    $handle = $conn->prepare(
        "SELECT ac.ACID AS 'Account Number', p.Name AS Product, ac.Balance AS Balance, p.Rate AS Rate, ac.PID AS PID FROM Accounts ac JOIN Products p ON p.PID = ac.PID WHERE ac.CID = :n"
    );

    $handle -> execute(array(":n" => $cid));
    $result = $handle->fetchall(PDO :: FETCH_ASSOC);
   
?>

<hr>
<!-- SQL results are displayed in the table. 
For the delete account button, onclick of each rows button, the account number is sent as the paramenter to the function. -->
<table>
    <tr ><th>Account Number</th><th>Product</th><th>Balance</th><th>Rate</th></tr>
    <?php foreach($result as $row) {
        echo "<tr id = " .  $row['Account Number'] . "><td>" . $row['Account Number'] . "</td><td>" . $row['Product'] . "</td><td>" . $row['Balance'] . " ". getCurrency($row['PID']) . 
            "</td><td>" . $row['Rate'] . "</td><td><input type='button' name='delete' value='Delete' onclick='deleteAccount(" . $row['Account Number'] . ");'></td></tr>";
    }?>
</table>

<hr>

<!-- button to add add new account. Sends client to new accounts page. -->
<form action="new.php">
    <input type="submit" value="New" />  
</form>

<!-- Exit button destroys session and sends client to index page. -->
<form action="destroy.php">
    <input type="submit" value="Exit" />  
</form>

</body>
</html> 
