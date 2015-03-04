<!--
/*
 * Copyright (c) 2015 AppLab, Grameen Foundation
 *
 *  Facebook MVP 
 *  
 *  
 **/
-->
<?php

include 'base.php';
include 'Db/connection.php';

if ($connection) {
  
$getMenus=("select * from menu where label='CKW Search'");
$resultMenus = mysqli_query($connection,$getMenus);
    
//getMenuIds
    if ($resultMenus) {     
        /* fetch object array */
    while ($menuObj = $resultMenus->fetch_object()) {
        $menuID=$menuObj->id;         
    }
              
    }  else {
        die('Invalid query for selecting menus: ' . mysqli_error($connection));    
    }
    echo ''. "</br>";
    
    //getMenuItemlabels whose parent ID is top
    $getMenuItems=("select * from menu_Item where menu_id='$menuID' and parent_id='' order by label asc");
    $resultMenuItems = mysqli_query($connection,$getMenuItems);
 
    if ($resultMenuItems) {
      
        /* fetch object array */
       $num=0;
    while ($menuItemObj = $resultMenuItems->fetch_object()) {
        $menuItemIDS=$menuItemObj->id;
        $menuItemLabels=$menuItemObj->label;
        $menuItemContent=$menuItemObj->content;
           
        if (strpos($menuItemContent,'No Content') !== false) {
            $menuItemContent='';
        }
           
        $ext='.php';
        $fullLink=$menuItemIDS.$ext; 
        $file =  fopen($fullLink, "c");
        
        echo ''."<ul id='menu'>";
        echo ''."<li ><a href=$fullLink>$menuItemLabels</a></li>";
        echo ''."$menuItemContent". "</ul> "; 
        
        $newPageContent = file_get_contents('/SubMenu.php', true);
        $more="<?php  \$var='$menuItemIDS'?>";
        fwrite($file, $more.$newPageContent);
        fclose($file);
           
    }
                 
    }  else {
        die('Invalid query for selecting menuItems: ' . mysqli_error($connection));    
    }   
    
}  else {
    echo 'No connection to Db'; 
}
mysqli_close($connection);

?>