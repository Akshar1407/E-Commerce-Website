<?php
// declsring all the constant required in this file
// we use "define" to declare all the constant things which is not going to change 
//for eg : like value 100 is fix so we use constant
// or like as an image which will not change so we define that as well
// or even we can also define folders or file name too which we want to use in this file or project
define("FILE_INDEX", "index.php");
define("FILE_BUYING","Buying_Page.php");
define("FILE_ORDER","Order_Page.php");

define("FOLDER_IMAGES","Pictures/");
define("FILE_IMAGE",FOLDER_IMAGES."Logo.png");

define("DEBUGGING_MODE", false);
# log folder path
define("LOG_FOLDER", "./LogFolder/");
# Error file path
define("FILE_ERROR_LOG", LOG_FOLDER . "errors.log");
# Exception file path
define("FILE_EXCEPTION_LOG", LOG_FOLDER . "exception.log");



// this is the function which is made to get the page title of all different pages like home order and buying page
function PageTop($pageTitle){
?>
<!DOCTYPE html><html>
<head>
<meta charset="UTF-8">
<!-- here we define the page title of that particular page by doing echo -->
<title><?php echo $pageTitle;?></title>
    <!-- Giving the referance of style sheet whcih is named as style1.css, and located in CSS folder -->
<link rel="stylesheet" type="text/css" href="CSS/style1.css">
</head>
    <!-- here to get different class we use code of php, as we need to chage the class when the command=print or command=color is written in the url so on that command we need to chnage the class of body to get the white body and to do pictures opacity 0.3 -->
    <!-- here the background color will be changing as per changing of pages like for order opage the color will be cadetblue and like wise for others too.  -->
    <body class="<?php 
if($pageTitle == "OrderPage"){
    if(isset($_GET["command"]) && $_GET["command"] == "print"){
        echo "white";   
    }
    else{
        echo "cadetbluebackground";   
    } 
}
elseif ($pageTitle == "Homepage") {
    echo "grayBackGround";
}
elseif($pageTitle == "BuyingPage"){
    echo "bisquebackground";
}
?>">

<?php
// navigation will include the link to go all the different pages from one another and it will be includesd in the function pageTop, this function also includes the image of the company as it must also be printed in all the three pages.
navigationMenu();
}
function navigationMenu(){
    ?>
    <div>
        <!-- its use to do pictures opacity 0.3 when command = print is written in url -->
<img src="<?php echo FILE_IMAGE;?>"class="<?php if(isset($_GET["command"]) && $_GET["command"] == "print"){
     $bg = "whencomandisprint";
     
        } else{
        $bg = "logo_Picture";
        }
        echo $bg;
        
?>"/>
        
</div>
<br><br>
    <!-- a link to all the pages is given over here in this nav tag and class named as nav is used from style1.css to make it looks good -->
<nav class="nav">
    <!-- &nbsp; is used for giving space  -->
    <a href="<?php echo FILE_INDEX; ?>">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |   
<a href="<?php echo FILE_BUYING;?>">Buying Page</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|   

<a href="<?php echo FILE_ORDER;?>">Order Page</a> 
</nav>

<br><br><br>
<?php
}
// page bottom is the functon which will be helpful for us to write the sentence in all the pages at the bottom side
function PageBottom(){
?>
<p>CopyRight Akshar Patel (2031119) <script>document.write( new Date().getFullYear() );</script></p>
    <!-- script is used as we don't need to write 2022 manually.so, for bringing it automatically we have make use of that. -->
</body></html>

<?php
}
?>

<?php 
function manageError($errorNumber, $errorString, $errorFile, $errorLine) {
                    # current Date and Time global variable
                    global $errorDateAndTime;
                    $errorDateAndTime = date('Y-m-d');
                    //var_dump($errorNumber);
                    if ($errorNumber > 0) {
                        $errorNumberString = strval($errorNumber);
                    }
                    $saveError = $errorDateAndTime . " - An error " . $errorNumberString . "{" . $errorString .
                            "} occurred in the file " . $errorFile . " at line " . $errorLine;
                    if (DEBUGGING_MODE == true) {
                        #for developers
                        echo $saveError;
                    } else {
                        echo "<br>An Error occurred";
                    }
                    #for user
                    #save in the file
                    $data = $saveError;
                    $JSONdata = json_encode($saveError);
                    file_put_contents(FILE_ERROR_LOG, "$JSONdata\r\n", FILE_APPEND);
                    exit(); # kill PHP
                }

                # Manage Exception

                function manageException($exception) {
                    $errorDateAndTime = date('Y-m-d');
                    $exceptionNumberString = "";
                   // var_dump($errorNumber);
                    if ($exception->getCode() > 0) {
                        $exceptionNumberString = strval($exception->getCode());
                    }
                    $saveError = $errorDateAndTime . " - An exception " . $exceptionNumberString . "{" . $exception->getMessage() . "} occurred in the file " . $exception->getFile() . " at line " . $exception->getLine();
                    if (DEBUGGING_MODE == true) {
                        #for developers
                        echo $saveError;
                    } else {
                        echo "<br>An exception occurred";
                    }
                    #for user                    
                    #save in the file the detail error
                    $JSONdata = json_encode($saveError);
                    file_put_contents(FILE_EXCEPTION_LOG, "$JSONdata\r\n", FILE_APPEND);
                    exit(); # kill PHP
                }

                set_error_handler("manageError");
                set_exception_handler("manageException");
                # Test the exception handler   
//                 trigger_error("Cannot divide by zero", E_USER_ERROR);
                // throw new exception("Hi!");
?>