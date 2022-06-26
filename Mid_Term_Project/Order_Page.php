<?php
//defining all the constant things which we used in this file
define("PRICE_INDEX", 5);
define("SUB_TOTAL_INDEX", 7);
define("TAX_AMOUNT_INDEX", 8);
define("TOTAL_INDEX", 9);
define("RED_COLOR_VALUE", 100);
define("ORANGE_COLOR_INDEX", 999.99);
define("GREEN_COLOR_INDEX", 1000);
define("ORDER_FILE", "orders.txt");
// to include commonFunctions.php just for once in this file
include_once ('FUNCTIONS/commonFunctions.php');

// to give title as Order Page we have used pageTop passing OderPage inside of it which also includes the image of logo
PageTop("OrderPage");

?>
<!-- TO generate paragraph we have used the tag <p> -->
        <p>Click on the link below to download the Cheat Sheet of 2031119.</p>
        <!-- to give link to download the cheatsheet we need to use a hrefd tag and for that at the same time we need to write downland word at the last of starting tag of a -->
        <a href="/Mid_Term_Project/CheatSheet.doc" download>Cheat Sheet</a><br><br>
        <!-- to generate table -->
        <table class="border">
            <thead><!-- for table head we have use thead tag -->
                <tr><!-- for one row -->
                    <th>Product Code</th>
                    <th>Customer First Name</th>
                    <th>Customer Last Name</th>
                    <th>Customer City</th>
                    <th>Comment</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub-Total</th>
                    <th>Tax-Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
       

        
    
    <?php
    // to check if the file name orders.txt exits or not
    if(file_exists(ORDER_FILE)){
        
        // if exists then to
        #open the file
        $fileHandle = fopen(ORDER_FILE,"r");#use r for Reading
        #read from a file
        while(!feof($fileHandle)){

            # read the file, decode the JSON string,
            #use the array to fill the HTML table
            $fileLine = fgets($fileHandle); #read a line in the file and put it in variable
            $obj = json_decode($fileLine,true);

            // if its not empty
            if(($obj)!=""){
                echo '<tr>';// generate tag tr
                foreach ($obj as $index=>$column){ // to displa all record  we use foreach
                    if($index==PRICE_INDEX || $index==SUB_TOTAL_INDEX|| $index==TAX_AMOUNT_INDEX || $index==TOTAL_INDEX){ // conditions to print $ sign with price, subtotal, tax and with total, in that its also a condition for checking command = print
                        // if command=print is written in url then it will change according to the value of subtotal if less then 100 then it will be indicated in red color font
                        // if more than 100 and less then 999.99 then in orange color  and if biggervthen 1000 then in green color
                        if(isset($_GET["command"]) && htmlspecialchars($_GET["command"])=="color"){
                            if($index==SUB_TOTAL_INDEX){
                                if($column<RED_COLOR_VALUE){
                                        echo '<td class="redcolor">'.$column.' $'.'</td>';
                                }
                                elseif ($column>=RED_COLOR_VALUE && $column<ORANGE_COLOR_INDEX) {
                                    echo '<td class="orangeColor">'.$column.' $'.'</td>';
                                }
                                elseif ($column>GREEN_COLOR_INDEX) {
                                    echo '<td class="greenColor">'.$column.' $'.'</td>';
                                }
                            }
                            else{
                                echo '<td>'.$column.' $'.'</td>';
                            }    
                        }
                        else{
                            echo '<td>'.$column.' $'.'</td>';
                        }
                    }
                    else{
                        echo '<td>'.$column.'</td>';
                    }
                }
                // closing tr tag
                echo '</tr>';
}
}

#close the file
fclose($fileHandle);
// closing table tag
echo "</table>";
}
// to include copyright in page at a bottom we use pageBottom
PageBottom();
?>
