<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Bank of Kent</title>
    <link rel="icon" type="image/x-icon" href="bank.png">
<!--Favicon was found here: 
        https://iconarchive.com/tag/bank-favicon
 -->    
 <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">
 
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

    session_start();

    //Retrieve POST variable from new page, idicating which product they wish to purchase.
    if (isset($_POST['product'])){
        $pid = $_POST['product'];
    }

    // If session variables are not set, send user to error page.
    if (isset($_SESSION['cid']) && isset($_SESSION['customerName'])){
        $cid =$_SESSION['cid'];
        $name= $_SESSION['customerName'];
    }
    else {
        header('Location: accounterror.php');
    }

    // Connect to the database.
    $conn=connect();
    //prepare & execute query to add into database.
    $sql = "INSERT INTO Accounts(Balance, CID, PID) VALUES ('0','" . $cid . "','" . $pid . "')";
    $handle = $conn->prepare($sql);
    $handle->execute();
    
    echo "<h2>Thank you, " . Htmlspecialchars($name) . ". Your booking was successful! </h2>" ;

?>
<hr>
<!-- Button to return to accounts page. -->
<form id = 'other' action='accounts.php'>
    <input type='submit' value = 'Accounts'>
</form>
<!-- Button to exit the session. Client sent to index. -->
<form action="destroy.php">
    <input type="submit" value="Exit" />  
</form>

</body>





</html> 