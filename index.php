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
    session_start();
?>

<!-- Form which direct user to accounts page upon submit. -->
 <form action= "accounts.php" method="POST">
<!-- Input for customer name. -->
 <label for="customerName">Name: </label>
 <br>
<input type="text" name="customerName" value="Sally" required/>

<hr>
<!-- input for customer ID. -->
<label for="cid">Customer ID:</label>
<br>
<!-- Checks that the account number is a positive number, error prompt is made is number is negative. -->
<input type="number" name="cid" value=2 required Onchange='
               if(!(this.value> 0)) {
        alert(this.value + " is not a valid account number. \n please check this number is correct");
        this.value ="";
        }'>
<input type="submit" value="Submit" />

<hr>
</form>
   
</body>



</html> 

 
 


