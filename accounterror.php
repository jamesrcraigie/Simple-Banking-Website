<!-- Error page shown when no session is found or login details are incorrect. -->
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

 <!-- On submit the session is destroyed through destroy.php page and user returned to index page -->
<hr id = 'line'>
<form action= "destroy.php">
<label>Account Error! Please log in again </label>
<br>
<input type="submit" value="Return to Login" />
</form>
</body>



</html> 
