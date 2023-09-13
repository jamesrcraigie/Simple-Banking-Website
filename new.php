<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Bank of Kent</title>
    <link rel="icon" type="image/x-icon" href="bank.png">
<!--Favicon was found here: 
        https://iconarchive.com/tag/bank-favicon
 -->    
 <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

 <script>
    //Checks whether a product is selected before form is submitted.
    function setProduct(){
        //Proceed if a product is selected.
        if(document.querySelector('input[name="product"]:checked')){
            form1.submit();
        }
        else {
            //Alert error if no product selected.
            alert('Please select a product'); 
        }

   
    }
    
    
    //Function called on change of the product currency radio buttons.
    function setRadioButtons(){
        //Retrieve the current value of the selected curreny radio button.
        const currentCurr = document.querySelector('input[name="currencies"]:checked').value;
        //Retrieve the radio buttons for the products.
        products = document.getElementsByName('product');

        // If currency is any, enable all buttons.
        if(currentCurr == 'Any'){
            products.forEach(product => {
            product.disabled = false;
            });
        }
        else{
            // Check the value of currentCurr against the currency retrieved from the pid for each row in the product table. 
            products.forEach(product => {
                if(getCurrencyJS(product.value) == currentCurr) {
                    //If the curreny matches enable the product button.
                    product.disabled = false;
                }
                else {
                    //If currency doesnt match, disable the button.
                    product.disabled = true;
                    //If disabled button is checked, uncheck it.
                    if(product.checked){
                        product.checked = false;
                    }
                }
            });
        }
    }

    //Check curreny for set radio buttons function. Returns the string intrepretation of the currency given the product ID.
    function getCurrencyJS(pid){
        if(pid==1 || pid==2){
            return "USD";
        }
        if(pid==3){
            return "GBP";
        }
        if(pid==4){
            return "Euro";
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
    session_start();
 
    // Send user to error page is session variables are not set.
    if (isset($_SESSION['customerName'])){
        $name= $_SESSION['customerName'];
    }
    else {
        header('Location: accounterror.php');
    }

    

    echo "<h2> Dear " . Htmlspecialchars($name) . ", Here is a list of products: </h2>" ;

    //Connect to database.
    $conn = connect();

    //Prepare and execute SQL query.
    $sql = "SELECT * FROM Products";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $result = $handle -> fetchall(PDO :: FETCH_ASSOC);
 
?>

<hr>

<!-- Radio buttons to filter products by currency. On change setRadioButtons script is called. -->
<label for='currencies'>Filter by currency: </label> 
<input type='radio' id='any' name='currencies' value='Any' checked='checked' Onchange='setRadioButtons()'> <label for='any'>Any</label>
<input type='radio' id='usd' name='currencies' value='USD' Onchange='setRadioButtons()'> <label for='usd'>USD</label> 
<input type='radio' id='gbp' name='currencies' value='GBP' Onchange='setRadioButtons()'><label for='gbp'>GBP</label> 
<input type='radio' id='euro' name='currencies' value='Euro' Onchange='setRadioButtons()'> <label for='euro'>Euro</label> 

<hr>

<!-- construct table for a list of products. Radio buttons allow client to select a product. On submit set product is called.
The product id is sent as the POST variable. -->
<form name='form1' action='book.php' method='POST'>
    <table name=table1>
        <tr><th>Product</th><th>Currency</th><th>Rate</th><th></th></tr>
            <?php foreach($result as $row):
                echo "<tr><td>" . $row['Name'] . "</td><td>" . getCurrency($row['PID']) . "</td><td>" . $row['Rate'] . 
                    "</td><td><input type='radio' name='product' value='" . $row['PID'] . "'></td></tr>";
            endforeach;?>
    </table>
    <input type='button' value = 'Buy Product' onclick='setProduct();'>
</form>



<form  action='accounts.php'>
    <input type='submit' value = 'Back'>
</form>

<form action="destroy.php">
    <input type="submit" value="Exit" />  
</form>
   
</body>

</html> 

 
