<?php
//defining all the constant things which we used in this file
define("FOLDER_PICTURES", "pictures/");
define("PICTURE_LOGO", FOLDER_PICTURES . "Logo.png");
define("PICTURE_LG", FOLDER_PICTURES . "lg.jpeg");
define("PICTURE_Apple", FOLDER_PICTURES . "apple.png");
define("PICTURE_SAMSUNG", FOLDER_PICTURES . "samsung.png");
define("PICTURE_ONEPLUS", FOLDER_PICTURES . "onePlus.jpeg");
define("PICTURE_HP", FOLDER_PICTURES . "hp.jpeg");
define("FOLDER_CSS" , "CSS/");
define("FILE_CSS" , FOLDER_CSS . "style1.css");

// to include commonFunctions.php just for once in this file
include_once ('FUNCTIONS/commonFunctions.php');

// to give title as Home Page we have used pageTop passing Homepage inside of it which also includes the image of logo
pageTop("Homepage");


?>
        
        <?php
        // generating array of all five images
        $myArray = array(PICTURE_Apple, PICTURE_HP, PICTURE_LG, PICTURE_ONEPLUS, PICTURE_SAMSUNG);
        // to shuffle all the images means to just show one image at once on a screen
        shuffle($myArray);
        
        ?>
        <!-- giving link to that image which is indicated after being shuffled and in that if the image of apple will be displayed  -->
        <!-- then we will be using class, named as an advertising1 just to indicate it 100% bigger and to give red color border of 5px -->
        <!-- for other images other than the apple then it will make a use of advertising -->
        <!-- to open the link in a new tab we have used target="_blank" -->
        <a href="https://www.google.com/" target="_blank"><img src=" <?php echo $myArray[0]; ?>" 
                                               class="<?php if ($myArray[0] == PICTURE_Apple) {
          
            echo 'advertising1';
            
            } else {
            
                    echo 'advertising';
            
            } ?>"  alt="Advertising Ad"/></a>
        
        <!-- to start paragraph we use <p> tag -->
             <p >
            The Company 2031119 is established since 2001, it has worked as serving hand 
            to the society and its intelligent minds by selling the computer products to all and everyone 
            at an affordable price.<br>
            Here are the list of products that we are selling : <br>
                Computer<br>
                Laptops<br>
                Macs<br>
                Mobiles<br>
                Television
        </p>
                
     <?php
    // to include copyright in page at a bottom we use pageBottom
    pageBottom();
    ?>
