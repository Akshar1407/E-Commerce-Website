<?php
// define constant values
define("TAX", 0.1345);
define("PRODUCT_CODE_MAX_LENGTH", 12);
define("CUSTOMER_FIRST_NAME_MAX_LENGTH", 20);
define("CUSTOMER_LAST_NAME_MAX_LENGTH", 20);
define("CUSTOMER_CITY_MAX_LENGTH", 8);
define("COMMENT_MAX_LENGTH", 200);
define("PRICE_MAX_VALUE", 10000);
define("QUANTITY_MAX_VALUE", 100);
define("ROUND_VALUE", 2);
define("ORDER_FILE", "orders.txt");

//include_once is used to include commanFunctions.php file in this file(just once a time)
include_once ('FUNCTIONS/commonFunctions.php');

// for giving title of Buying Page we use PageTop and pass BuyingPage inside that.
PageTop("BuyingPage");

// not to contain(fetch data from catch) we have included following lines.
header('Expires: Thursday, 01 Dec 1994 16:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE); 
header('Pragma: no-cache');

//declaring all the variables required in this file
$productCode = "";
$customerFirstName = "";
$customerLastName = "";
$customerCity = "";
$comment = "";
$Price = "";
$Quantity = "";

// those are the variables used for error
$errorProductCode = "";
$errorCustomerFirstName = "";
$errorCustomerLastName = "";
$errorCustomerCity = "";
$errorComment = "";
$errorPrice = "";
$errorQuantity = "";

// in initials we declare error as a false
$errorOccured = false;
// when submit button is clicked
if(isset($_POST["submitbutton"])){
    
    $productCode = htmlspecialchars(trim($_POST["product-code"]));
    $customerFirstName = htmlspecialchars(trim($_POST["customerfname"]));
    $customerLastName = htmlspecialchars($_POST["customerlname"]);
    $customerCity = htmlspecialchars(trim($_POST["customercity"]));
    $comment = htmlspecialchars(trim($_POST["comment"]));
    $Price = htmlspecialchars($_POST["price"]);
    $Quantity = htmlspecialchars(trim($_POST["quantity"]));

    // stating condition for productcode, one form of validations
    if(mb_strlen($productCode) == 0){
        $errorOccured = true;
        $errorProductCode = "The Product Code cannot be an empty.";
    }else if(mb_substr($productCode, 0, 1) != "p" && mb_substr($productCode, 0, 1) != "P"){
        $errorOccured = true;
        $errorProductCode = "The Product Code must start with p or P.";
    } 
    else if (mb_strlen($productCode) > PRODUCT_CODE_MAX_LENGTH) {
           $errorOccured = true;
            $errorProductCode = "The Product Code cannot contain more then 12 letters.";
    }
    
     // stating condition for customerFirstName ,one form of validations
    if(mb_strlen($customerFirstName) == null){
        $errorOccured = true;
        $errorCustomerFirstName = "Customer's First Name cannot be an empty.";
    }elseif (mb_strlen($customerFirstName) > CUSTOMER_FIRST_NAME_MAX_LENGTH) {
        $errorOccured = true;
            $errorCustomerFirstName = "Customer's First Name cannot contain more then 20 letters.";
    }
    
         // stating condition for customerLastName, one form of validations
    if(mb_strlen($customerLastName) == null){
        $errorOccured = true;
        $errorCustomerLastName = "Customer's Last Name cannot be an empty.";
    }elseif (mb_strlen($customerLastName) > CUSTOMER_LAST_NAME_MAX_LENGTH) {
        $errorOccured = true;
            $errorCustomerLastName = "Customer's Last Name cannot contain more then 20 letters.";
    }
         
// stating condition for customerCity, one form of validations
    if(mb_strlen($customerCity) == null){
        $errorOccured = true;
        $errorCustomerCity = "Customer's City Name cannot be an empty.";
    }elseif (mb_strlen($customerCity) > CUSTOMER_CITY_MAX_LENGTH) {
        $errorOccured = true;
            $errorCustomerCity = "Customer's City Name cannot contain more then 8 letters.";
    }
    
    // stating condition for comment, one form of validations
    if(mb_strlen($comment) > COMMENT_MAX_LENGTH){
        $errorOccured = true;
        $errorComment = "Comment cannot contain more then 200 letters.";
    }
    
    // stating condition for price, one form of validations
    if(mb_strlen($Price) == null){
        $errorOccured = true;
        $errorPrice= "Price cannot be an empty.";
    }elseif(!is_numeric($Price)){
        $errorOccured = true;
        $errorPrice =  "Price must be in a numberic form.";
    }elseif (($Price) >= PRICE_MAX_VALUE) {
        $errorOccured = true;
            $errorPrice = "Price must be less then 10000.";
    }elseif(($Price) <= 0){
        $errorOccured = true;
        $errorPrice = "Price must be greater then 0.";
    }
    
    // stating condition for quantity, one form of validations
    if(mb_strlen($Quantity) == 0){
        $errorOccured = true;
        $errorQuantity = "Quantity cannot be an empty.";
    }
    elseif(!is_numeric($Quantity)){
        $errorOccured = true;
        $errorQuantity = "Quantity must be in a numberic form.";
   }elseif(mb_strpos($Quantity, ".")==true){
       $errorOccured = true;
        $errorQuantity = "Quantity must be in an Integer form.";
   }elseif (($Quantity) >= QUANTITY_MAX_VALUE ) {
        $errorOccured = true;
            $errorQuantity = "Quantity must be less then 100.";
    }
    elseif(($Quantity) <= 0){
        $errorOccured = true;
        $errorQuantity =  "Quantity must be greater then 0.";
    }
    
    // now if there is no error in the form then it will come over here as in this condition it is already stated that errorOccured == false
//    Here all the calculation is done as per stated formulas and then
//    the value is rounded by 2 to get output as per our needs
    if($errorOccured == false){
        $subTotal = $Price * $Quantity;
        $taxAmount = TAX * $subTotal;
        $total = $subTotal + $taxAmount;
        $subTotal = round($subTotal, ROUND_VALUE);
        $total = round($total, ROUND_VALUE);
        $taxAmount = round($taxAmount, ROUND_VALUE);
        
        // creating the array named as a Products and it contains all the things which are stated in the round bracket on the right hand side 
        $Products = array($productCode, $customerFirstName, $customerLastName, $customerCity, $comment, $Price, $Quantity, $subTotal,$taxAmount, $total);
//    encoding the array to write that in one text file 
        $JSONstring = json_encode($Products);
    // now we need to decode it again in the process to achieve our text in the file
    //$otherProducts = json_decode($JSONstring);

    // here we open the file name as an orders.txt which is defined above
        $fileHandel = fopen(ORDER_FILE, "a") or die("Cannot Open");
        
        // code to write in a file
        fwrite($fileHandel, $JSONstring."\n");
        //here we close the file
        fclose($fileHandel);
        
        // this is use to give message to the user stating that your order is being placed
        echo '<script>alert("Your Order Is Being Placed. :)")</script>';
        
        // then again we need to make all the fileds empty in the form
        $productCode = "";
        $customerFirstName = "";
        $customerLastName = "";
        $customerCity = "";
        $comment = "";
        $Price = "";
        $Quantity = "";

        // it is use just not to place order again when page is refreshed
       echo "<meta http-equiv='refresh' content='0'>";
        }
}


?>
<!-- generating the form with necessary labels and textboxes -->
<form action="Buying_Page.php" method="POST">
        
    <!-- span is just used to write the thing in one same line placeholder is use to give name in background to that textbox
    so that the user can know what to enter in that field,, for in label is use because when the user click on that label at that time 
    particular textbox is highlighted, moreover, if any error in one or more field of the form happens then we will be in need to
     use the other span just to indicate the error which has happen   -->
        <label for="product-code">Product Code</label><span class="redcolor" >*</span><br>
        <input type="text"  class="fullwidth" name="product-code" id="product-code"
              placeholder="Enter Product Code" value="<?php echo $productCode; ?>" />
        <span class="redcolor"><?php echo $errorProductCode; ?></span><br><br>
        
        <label for="customerfname">Customer first name</label><span class="redcolor" >*</span><br>
        <input type="text"  class="fullwidth" name="customerfname" id="customerfname"
              placeholder="Enter Customer First Name" value="<?php echo $customerFirstName; ?>" />
        <span class="redcolor"><?php echo $errorCustomerFirstName; ?></span><br><br>
     
        <label for="customerlname">Customer last name</label><span class="redcolor" >*</span><br>
        <input type="text"  class="fullwidth" name="customerlname" id="customerlname"
              placeholder="Enter Customer Last Name" value="<?php echo $customerLastName; ?>" />
        <span class="redcolor"><?php echo $errorCustomerLastName; ?></span><br><br>
    
        <label for="customercity">Customer City</label><span class="redcolor" >*</span><br>
        <input type="text"  class="fullwidth" name="customercity" 
              placeholder="Enter Customer City Name" id="customercity" value="<?php echo $customerCity; ?>"/>
        <span class="redcolor"><?php echo $errorCustomerCity; ?></span><br><br>
   
    
        <label for="comment" >Comments</label>
        <textarea type="textarea" name="comment" class="fullwidth" placeholder="Enter Comments" id="comment" value="<?php echo $comment; ?>"></textarea>
        <span class="redcolor"><?php echo $errorComment; ?></span><br>
        
        <label for="price" >Price</label><span class="redcolor" >*</span><br>
        <input type="text"  class="fullwidth" name="price"  id="price"
              placeholder="Enter Price" value="<?php echo $Price; ?>"/>
        <span class="redcolor"><?php echo $errorPrice; ?></span><br><br>
    
        <label for="quantity">Quantity</label><span class="redcolor" >*</span><br>
        <input type="text"  class="fullwidth" name="quantity" id="quantity"
              placeholder="Enter Quantity" value="<?php echo $Quantity; ?>"/>
        <span class="redcolor"><?php echo $errorQuantity; ?></span><br><br>
    
        <!-- for submit button -->
        <button type="submit" class="addButton" name="submitbutton">ADD</button>
    
        </form>

    <?php
// to include the page bottom of copyright
PageBottom();
?>