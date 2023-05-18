<?php
$productMenu = array();

function addGroceryFile (){
    $groceryFile = fopen("grocery.txt", "r"); 
    $groceryList = array(); 
  while (($data = fgetcsv($groceryFile, 1000, ",")) !== FALSE) { 
        $groceryList[] = $data; 
    } 
    
    for($i=0;$i<count($groceryList);$i++){
        array_push($GLOBALS['productMenu'],$groceryList[$i]);
        // print_r($groceryList[$i]);
    }
    
    // echo "->".sizeof($GLOBALS['productMenu']);
    // // print_r($GLOBALS['productMenu']);
    // // print_r($groceryList);
  fclose ($groceryFile);
  return $groceryList;
}
addGroceryFile();


function readGroceryFile() { 
    $groceryFile = fopen("grocery.txt", "r"); 
    $groceryList = array(); 
    while (($data = fgetcsv($groceryFile, 1000, ",")) !== FALSE) { 
        $groceryList[] = $data; 
    } 
    fclose($groceryFile); 
    return $groceryList; 
    
}


function checkMenu($pid,$pname,$pprice){
    if($pid<1000000 && strlen($pname)<=20 && $pprice<1000000){
        return true;
    }
    else{
        return false;
    }
}

function addMenu(int $pid,string $pname,int $pprice){
    // echo "In ADD";
    $newProduct=array();
    array_push($newProduct,$pid,$pname,$pprice);
    // print_r($newProduct);
    array_push($GLOBALS['productMenu'],$newProduct);
    // printMenu();
    
    // --------- FILE ----------------
    echo "\n\nFrom File\n\n";
    $groceryFile = fopen ("grocery.txt", "a");
    fwrite ($groceryFile, "$pid, $pname, $pprice\n");
    fclose ($groceryFile);
  
    menu();
}

function updateMenu(){
    if (empty($GLOBALS['productMenu'])) {
        echo "No products to update.\n";
        menu();
    }
    // echo "In UPDATE";
    $updatePID=readline("Enter the PID of product to be updated: ");
    $updatePName=readline("Enter Product name ");
    $updatePPrice=readline("Enter Product price: ");
    if(checkMenu($updatePID,$updatePName,$updatePPrice)){
        for($i=0;$i<sizeof($GLOBALS['productMenu']);$i++){
            if($GLOBALS['productMenu'][$i][0]==$updatePID){
                $GLOBALS['productMenu'][$i][1]=$updatePName;
                $GLOBALS['productMenu'][$i][2]=$updatePPrice;
                echo "\n\tUPDATED!!";
            }
        }
        
        // ---------------- FILE ----------------
        echo "\n\nFrom File\n\n";
        $groceryList = readGroceryFile ();
        $groceryFile = fopen ("grocery.txt", "w");
        foreach ($groceryList as $item)
        {
            if ($item[0] == $updatePID)
            {
        	    $item[1] = $updatePName;
        	    $item[2] = $updatePPrice;
            }
            fwrite ($groceryFile, implode (",", $item)."\n");
        }
        fclose ($groceryFile);
    }
    else{
            echo "\n\tNot Updated\nCritiria not met!!";
    }

    
    menu();
}

function searchMenu($choice){
    if (empty($GLOBALS['productMenu'])) {
        echo "No products to display.\n";
        menu();
    }
    
    $present=false;
    // echo "In SEARCH=>".$choice;
    switch ($choice) {
        case '1':
            // printMenu();
            $searchPID = (int)readline("Enter PID: ");
            foreach ($GLOBALS['productMenu'] as $items){
                // echo $items[0]." in ID";
                if($items[0]==$searchPID){
                    print_r($items);
                    $present=true;
                }
            }
            // ---------------- FILE ----------------
            echo "\n\nFrom File\n\n";
            $groceryList = readGroceryFile ();
            foreach ($groceryList as $item)
            {
                if ($item[0] == $searchPID)
                {
        	        print_r($item);
                    $present=true;
                }
            }
          
            
            break;
            
        case '2':
            // printMenu();
            $searchName = (string)readline("Enter PNAME: ");
            foreach ($GLOBALS['productMenu'] as $items){
                // echo $items[1]." in name";
                if($items[1]==$searchName){
                    print_r($items);
                    $present=true;
                }
            }
            
            // ---------------- FILE ----------------
            echo "\n\nFrom File\n\n";
            $groceryList = readGroceryFile ();
            foreach ($groceryList as $item)
            {
                if ($item[1] == $searchName)
                {
        	        print_r($item);
                    $present=true;
                }
            }
            
            break;
        
        case '3':
            // printMenu();
            $searchPrice = (int)readline("Enter PPRICE: ");
            foreach ($GLOBALS['productMenu'] as $items){
                // echo $items[2]." in price";
                if($items[2]==$searchPrice){
                    print_r($items);
                    $present=true;
                }
            }
            
            // ---------------- FILE ----------------
            echo "\n\nFrom File\n\n";
            $groceryList = readGroceryFile ();
            foreach ($groceryList as $item)
            {
                if ($item[2] == $searchPrice)
                {
        	        print_r($item);
                    $present=true;
                }
            }
            
            break;
            
        default:
            echo "Enter valid CHOICE!!";
            menu();
            break;
            
    }
    if(!$present){
        echo "\nEntered product not found!";
    }
    
    menu();
}

function deleteMenu($choice){
    // echo "In DELETE".$choice;
    if (empty($GLOBALS['productMenu'])) {
        echo "No products to delete.\n";
        menu();
    }
    
    switch ($choice) {
        case '1':
            // printMenu();
            $deletePID = (int)readline("Enter PID: ");
            for($i=0;$i<sizeof($GLOBALS['productMenu']);$i++){
                // echo $GLOBALS['productMenu'][$i][0]." ".$deletePID."\n";
                if($GLOBALS['productMenu'][$i][0]==$deletePID){
                    echo "Deleted \t";
                    unset($GLOBALS['productMenu'][$i]);
                }
            }
            
            // ---------------- FILE ----------------
            echo "\n\nFrom File\n\n";
            $groceryList = readGroceryFile ();
            $groceryFile = fopen ("grocery.txt", "w");
            foreach ($groceryList as $item)
            {
                if ($item[0] != $deletePID)
                {
            	    fwrite ($groceryFile, implode (",", $item)."\n");
                }
            }
            fclose ($groceryFile);
            
            break;
            
        case '2':
            // printMenu();
            // echo "in Name delete"."\n";
            $deletePname = readline("Enter PNAME: ");
            for($i=0;$i<sizeof($GLOBALS['productMenu']);$i++){
                // echo $GLOBALS['productMenu'][$i][1]." ".$deletePname."\n";
                if($GLOBALS['productMenu'][$i][1]==$deletePname){
                    echo "Deleted \t";
                    unset($GLOBALS['productMenu'][$i]);
                }
            }
            
            // ---------------- FILE ----------------
            echo "\n\nFrom File\n\n";
            $groceryList = readGroceryFile ();
            $groceryFile = fopen ("grocery.txt", "w");
            foreach ($groceryList as $item)
            {
                if ($item[1] == $deletePname)
                {
            	    fwrite ($groceryFile, implode (",", $item)."\n");
                }
            }
            fclose ($groceryFile);
  
  
            break;
            
        default:
            echo "Enter valid CHOICE!!";
            menu();
            break;
            
    }
    menu();
}

function printMenu(){
    echo "\n\tMenu\n";
    echo"\t----\n";
    
    if (empty($GLOBALS['productMenu'])) {
        echo "No products to display.\n";
        menu();
    }
    // print_r($GLOBALS['productMenu']);
    echo "PID    PName".str_repeat(" ", 15)."Price\n";
    // for ($i = 0; $i < count($GLOBALS['productMenu']); $i++) {
    foreach ($GLOBALS['productMenu'] as $item){
        $space = str_repeat(" ", 20 - strlen($item[1]));
        $idspace = str_repeat(" ", 7 - strlen($item[0]));
        echo $item[0] . $idspace . $item[1] . $space . $item[2] . "\n";
        // print_r($GLOBALS['productMenu'][$i]);
    }
    // for ($i = 0; $i < count($GLOBALS['productMenu']); $i++) {
    //     $space = str_repeat(" ", 20 - strlen($GLOBALS['productMenu'][$i][1]));
    //     $idspace = str_repeat(" ", 7 - strlen($GLOBALS['productMenu'][$i][0]));
        
    //     echo $GLOBALS['productMenu'][$i][0] . $idspace . $GLOBALS['productMenu'][$i][1] . $space . $GLOBALS['productMenu'][$i][2] . "\n";
        
    // }
    
    // ============================= FILE ============================
    $groceryList = readGroceryFile ();
    echo "\n\nFrom File\n\n";
    echo "PID    PName".str_repeat(" ", 15)."Price\n";
    foreach ($groceryList as $item) { 
        $space = str_repeat(" ", 20 - strlen($item[1]));
        $idspace = str_repeat(" ", 7 - strlen($item[0]));
        
        echo $item[0] . $idspace . $item[1] . $space . $item[2] . "\n";
        
    }

    // print_r($GLOBALS['productMenu']);
    menu();
}

function exitMenu(){
    echo "\nIn EXIT";
    echo "\nThank you!!";
    
}

function menu(){
    
    echo "\n------------------------------";
    echo "\nEnter 1 to ADD menu.\nEnter 2 to UPDATE menu.\nEnter 3 to SEARCH menu.\nEnter 4 to DELETE menu.\nEnter 5 to PRINT menu.\nEnter 6 to EXIT menu.\n";
    $choice = (int)readline("\tEnter your choice: ");
    switch ($choice) {
        case '1':
            $plength = sizeof($GLOBALS['productMenu']);
            $pid = $plength+1;
            echo "\nYour PID is: ".$pid."\n";
            $pname = readline("Enter product name: ");
            while(!checkMenu($pid,$pname,$plength)){
                echo "The criteria has not been met. Please take a look\n";
                $pname=readline("\nEnter product name: ");
            }
            $pprice = (int)readline("\nEnter product price: ");
            addMenu($pid,$pname,$pprice);
            break;
        
        case '2':
            updateMenu();
            break;
        
        case '3':
            echo "\nEnter 1 to search by PID.\nEnter 2 to search by PNAME.\nEnter 3 to search by PPRICE\n";
            $searchchoice=(int)readline("\nEnter your choice: ");
            searchMenu($searchchoice);
            break;
        
        case '4':
            echo "\nEnter 1 to delete by PID.\nEnter 2 to delete by PNAME.\n";
            $deletechoice=(int)readline("\nEnter your choice: ");
            deleteMenu($deletechoice);
            break;
        
        case '5':
            printMenu();
            break;
        
        case '6':
            exitMenu();
            break;
        
        default:
            echo "Enter a valid choice";
            menu();
            break;
    }
}


// echo "inside menu\n";
menu();
// addMenu("1","medi","60");
// addMenu("2","lux","40");






