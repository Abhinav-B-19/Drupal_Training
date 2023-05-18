<?php
namespace web;

?>

<!DOCTYPE html>
<html>

<head>
    <title>
        Product Menu
    </title>
</head>

<body style="text-align:center;">

    <h1 style="color:green;">
        Product Management System
    </h1>
    <!-- 	
    <h4>
        How to call PHP function
        on the click of a Button ?
    </h4> -->

    <form method="POST" action="">

        <!-- <input onclick="this.form.submit()" type="submit" name="button1" class="button" value="Button1" />

        <input type="submit" name="button2" class="button" value="Button2" /> -->

        <input type="submit" name="addMenu" class="button" value="addMenu" />

        <input type="submit" name="updateMenu" class="button" value="updateMenu" />

        <input type="submit" name="searchMenu" class="button" value="searchMenu" />

        <input type="submit" name="deleteMenu" class="button" value="deleteMenu" />

        <input type="submit" name="printMenu" class="button" value="printMenu" />

        <input type="submit" name="exitMenu" class="button" value="exitMenu" />

    </form>

    <br>
    <hr>

    <div id="defaultFields" style="display: block;">
        <h1>Use the Buttons!!</h1>
    </div>

    <div id="productFields" style="display: none;">
        <h1>Add Product</h1>
        <form method="POST" action="">
            <label for="pName">Product Name:</label>
            <input type="text" name="pName" id="pName" required><br><br>
            <label for="pPrice">Product Price:</label>
            <input type="number" name="pPrice" id="pPrice" required><br><br>
            <input type="submit" value="Submit" name="addProduct">
        </form>
    </div>

    <div id="updateProductId" style="display: none;">
        <h1>Update Product</h1>
        <form method="POST" action="">
            <label for="pID">Product ID:</label>
            <input type="text" name="pID" id="pID" required><br><br>
            <label for="pName">Product Name:</label>
            <input type="text" name="pName" id="pName" required><br><br>
            <label for="pPrice">Product Price:</label>
            <input type="number" name="pPrice" id="pPrice" required><br><br>
            <input type="submit" value="Submit" name="updateProduct">
        </form>

    </div>

    <div id="deleteProductId" style="display: none;">
        <h1>Delete Product</h1>
        <form method="POST" action="">
            <label for="pID">Product ID:</label>
            <input type="text" name="pID" id="pID" required><br><br>
            <input type="submit" value="Submit" name="deleteProduct">
        </form>
    </div>

    <div id="searchMenuId" style="display: none;">
        <h1>Search Product</h1>
        <form method="POST" action="">
            <label for="pID">Product ID:</label>
            <input type="text" name="pID" id="pID" required><br><br>
            <input type="submit" value="Submit" name="searchMenu">
        </form>
    </div>

    <!-- ===================================    START OF PHP      =============================== -->

    <?php

    $productMenu = array();

    // ======================================CODE================================
    
    $productMenu = array();



    function addGroceryFile()
    {
        $groceryFile = fopen("grocery.txt", "r");
        $groceryList = array();
        while (($data = fgetcsv($groceryFile, 1000, ",")) !== FALSE) {
            $groceryList[] = $data;
        }

        for ($i = 0; $i < count($groceryList); $i++) {
            array_push($GLOBALS['productMenu'], $groceryList[$i]);
            // print_r($groceryList[$i]);
        }

        // echo "->" . sizeof($GLOBALS['productMenu']);
        // print_r($GLOBALS['productMenu']);
        // print_r($groceryList);
        fclose($groceryFile);
        return $groceryList;
    }
    addGroceryFile();

    function readGroceryFile()
    {
        $groceryFile = fopen("grocery.txt", "r");
        $groceryList = array();
        while (($data = fgetcsv($groceryFile, 1000, ",")) !== FALSE) {
            $groceryList[] = $data;
        }

        fclose($groceryFile);
        return $groceryList;
    }

    function checkMenu($pid, $pname, $pprice)
    {
        if ($pid < 1000000 && strlen($pname) <= 20 && $pprice < 1000000) {
            return true;
        } else {
            return false;
        }
    }


    if (isset($_POST['addProduct'])) {
        addMenu();
    }

    function addMenu()
    {
        if (isset($_POST["pName"]) && isset($_POST["pPrice"])) {
            $plength = sizeof($GLOBALS['productMenu']);
            $pid = $plength + 1;
            // global $product, $pID;
            $product = readGroceryFile();
            for ($i = 0; $i < $plength; $i++) {
                if ($pid == $product[$i][0]) {
                    $pid += 1;
                }
            }
            $pName = $_POST["pName"];
            $pPrice = $_POST["pPrice"];
            // do {
            //     $isUnique = true;
            //     $pID = rand(1, 10000);
            //     foreach ($product as $p) {
            //         if ($p[0] == "P" . $pID) {
            //             $isUnique = false;
            //             break;
            //         }
            //     }
            // } while (!$isUnique);
            $groceryFile = fopen("grocery.txt", "a");
            fwrite($groceryFile, "$pid, $pName, $pPrice\n");
            fclose($groceryFile);
        }

        // $plength = sizeof($GLOBALS['productMenu']);
        // $pid = $plength + 1;
        // echo "\nYour PID is: " . $pid . "\n";
        // $pname = readline("Enter product name: ");
        // while (!checkMenu($pid, $pname, $plength)) {
        //     echo "The criteria has not been met. Please take a look\n";
        //     $pname = readline("\nEnter product name: ");
        // }
        // $pprice = (int) readline("\nEnter product price: ");
        // // echo "In ADD";
        // $newProduct = array();
        // array_push($newProduct, $pid, $pname, $pprice);
        // // print_r($newProduct);
        // array_push($GLOBALS['productMenu'], $newProduct);
        // // printMenu();
    
        // // --------- FILE ----------------
        // echo "\n\nFrom File\n\n";
        // $groceryFile = fopen("grocery.txt", "a");
        // fwrite($groceryFile, "$pid, $pname, $pprice\n");
        // fclose($groceryFile);
    
        // menu();
    }

    function updateMenu($pID)
    {
        global $product;
        $product = readGroceryFile();
        if (empty($product)) {
            ?>
            <script>
                document.getElementById("defaultFields").style.display = "none";
            </script>
            <h3>No products to update.\n</h3>
            <?php
            return;
        }
        $index = searchMenu($pID);
        if ($index != -1) {
            $pName = $_POST["pName"];
            $pPrice = $_POST["pPrice"];
            // $product[$index] = array($pID, $pName, $pPrice);
            // file_put_contents("Product.txt", '');
            // foreach ($product as $p) {
            //     file_put_contents("Product.txt", implode(" ", $p) . "\n", FILE_APPEND);
            // }
            $groceryList = readGroceryFile();
            $groceryFile = fopen("grocery.txt", "w");
            foreach ($groceryList as $item) {
                if ($item[0] == $pID) {
                    $item[1] = $pName;
                    $item[2] = $pPrice;
                }
                fwrite($groceryFile, implode(",", $item) . "\n");
            }
            fclose($groceryFile);
            echo "After Updation:\n";
            printMenu();
        }
        // echo "\n\nFrom File\n\n";
        //     $groceryList = readGroceryFile();
        //     $groceryFile = fopen("grocery.txt", "w");
        //     foreach ($groceryList as $item) {
        //         if ($item[0] == $updatePID) {
        //             $item[1] = $updatePName;
        //             $item[2] = $updatePPrice;
        //         }
        //         fwrite($groceryFile, implode(",", $item) . "\n");
        //     }
        //     fclose($groceryFile);
        // if (empty($GLOBALS['productMenu'])) {
        //     echo "No products to update.\n";
        //     // menu();
        // }
        // // echo "In UPDATE";
        // $updatePID = readline("Enter the PID of product to be updated: ");
        // $updatePName = readline("Enter Product name ");
        // $updatePPrice = readline("Enter Product price: ");
        // if (checkMenu($updatePID, $updatePName, $updatePPrice)) {
        //     for ($i = 0; $i < sizeof($GLOBALS['productMenu']); $i++) {
        //         if ($GLOBALS['productMenu'][$i][0] == $updatePID) {
        //             $GLOBALS['productMenu'][$i][1] = $updatePName;
        //             $GLOBALS['productMenu'][$i][2] = $updatePPrice;
        //             echo "\n\tUPDATED!!";
        //         }
        //     }
    
        //     // ---------------- FILE ----------------
        //     echo "\n\nFrom File\n\n";
        //     $groceryList = readGroceryFile();
        //     $groceryFile = fopen("grocery.txt", "w");
        //     foreach ($groceryList as $item) {
        //         if ($item[0] == $updatePID) {
        //             $item[1] = $updatePName;
        //             $item[2] = $updatePPrice;
        //         }
        //         fwrite($groceryFile, implode(",", $item) . "\n");
        //     }
        //     fclose($groceryFile);
        // } else {
        //     echo "\n\tNot Updated\nCritiria not met!!";
        // }
    

        // // menu();
    }

    function searchMenu($pID)
    {
        $product = readGroceryFile();
        if (empty($product)) {
            echo "No products to search.\n";
            return -1;
        }
        for ($i = 0; $i < count($product); $i++) {
            if ($product[$i][0] == $pID) {
                return $i;
            }
        }
        // echo "\n\nNo Product found for this ID.\n";
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "none";
        </script>
        <h3>No Product found for this ID.</h3>
        <?php
        return -1;

        // echo "\nEnter 1 to search by PID.\nEnter 2 to search by PNAME.\nEnter 3 to search by PPRICE\n";
        // $choice = (int) readline("\nEnter your choice: ");
        // if (empty($GLOBALS['productMenu'])) {
        //     echo "No products to display.\n";
        //     // menu();
        // }
    
        // $present = false;
        // // echo "In SEARCH=>".$choice;
        // switch ($choice) {
        //     case '1':
        //         // printMenu();
        //         $searchPID = (int) readline("Enter PID: ");
        //         foreach ($GLOBALS['productMenu'] as $items) {
        //             // echo $items[0]." in ID";
        //             if ($items[0] == $searchPID) {
        //                 print_r($items);
        //                 $present = true;
        //             }
        //         }
        //         // ---------------- FILE ----------------
        //         echo "\n\nFrom File\n\n";
        //         $groceryList = readGroceryFile();
        //         foreach ($groceryList as $item) {
        //             if ($item[0] == $searchPID) {
        //                 print_r($item);
        //                 $present = true;
        //             }
        //         }
    

        //         break;
    
        //     case '2':
        //         // printMenu();
        //         $searchName = (string) readline("Enter PNAME: ");
        //         foreach ($GLOBALS['productMenu'] as $items) {
        //             // echo $items[1]." in name";
        //             if ($items[1] == $searchName) {
        //                 print_r($items);
        //                 $present = true;
        //             }
        //         }
    
        //         // ---------------- FILE ----------------
        //         echo "\n\nFrom File\n\n";
        //         $groceryList = readGroceryFile();
        //         foreach ($groceryList as $item) {
        //             if ($item[1] == $searchName) {
        //                 print_r($item);
        //                 $present = true;
        //             }
        //         }
    
        //         break;
    
        //     case '3':
        //         // printMenu();
        //         $searchPrice = (int) readline("Enter PPRICE: ");
        //         foreach ($GLOBALS['productMenu'] as $items) {
        //             // echo $items[2]." in price";
        //             if ($items[2] == $searchPrice) {
        //                 print_r($items);
        //                 $present = true;
        //             }
        //         }
    
        //         // ---------------- FILE ----------------
        //         echo "\n\nFrom File\n\n";
        //         $groceryList = readGroceryFile();
        //         foreach ($groceryList as $item) {
        //             if ($item[2] == $searchPrice) {
        //                 print_r($item);
        //                 $present = true;
        //             }
        //         }
    
        //         break;
    
        //     default:
        //         echo "Enter valid CHOICE!!";
        //         // menu();
        //         break;
    
        // }
        // if (!$present) {
        //     echo "\nEntered product not found!";
        // }
    
        // // menu();
    }

    function deleteMenu($pID)
    {
        $product = readGroceryFile();
        if (empty($product)) {
            echo "No products to delete.\n";
            return;
        }
        $index = searchMenu($pID);
        if ($index != -1) {
            // array_splice($product, $index, 1);
            echo "After deletion:\n";
            $groceryList = readGroceryFile();
            $groceryFile = fopen("grocery.txt", "w");
            foreach ($groceryList as $item) {
                if ($item[0] != $pID) {
                    fwrite($groceryFile, implode(",", $item) . "\n");
                }
            }
            fclose($groceryFile);
            printMenu();
        }

        // echo "\nEnter 1 to delete by PID.\nEnter 2 to delete by PNAME.\n";
        // $choice = (int) readline("\nEnter your choice: ");
        // // echo "In DELETE".$choice;
        // if (empty($GLOBALS['productMenu'])) {
        //     echo "No products to delete.\n";
        //     // menu();
        // }
    
        // switch ($choice) {
        //     case '1':
        //         // printMenu();
        //         $deletePID = (int) readline("Enter PID: ");
        //         for ($i = 0; $i < sizeof($GLOBALS['productMenu']); $i++) {
        //             // echo $GLOBALS['productMenu'][$i][0]." ".$deletePID."\n";
        //             if ($GLOBALS['productMenu'][$i][0] == $deletePID) {
        //                 echo "Deleted \t";
        //                 unset($GLOBALS['productMenu'][$i]);
        //             }
        //         }
    
        //         // ---------------- FILE ----------------
        //         echo "\n\nFrom File\n\n";
        //         $groceryList = readGroceryFile();
        //         $groceryFile = fopen("grocery.txt", "w");
        //         foreach ($groceryList as $item) {
        //             if ($item[0] != $deletePID) {
        //                 fwrite($groceryFile, implode(",", $item) . "\n");
        //             }
        //         }
        //         fclose($groceryFile);
    
        //         break;
    
        //     case '2':
        //         // printMenu();
        //         // echo "in Name delete"."\n";
        //         $deletePname = readline("Enter PNAME: ");
        //         for ($i = 0; $i < sizeof($GLOBALS['productMenu']); $i++) {
        //             // echo $GLOBALS['productMenu'][$i][1]." ".$deletePname."\n";
        //             if ($GLOBALS['productMenu'][$i][1] == $deletePname) {
        //                 echo "Deleted \t";
        //                 unset($GLOBALS['productMenu'][$i]);
        //             }
        //         }
    
        //         // ---------------- FILE ----------------
        //         echo "\n\nFrom File\n\n";
        //         $groceryList = readGroceryFile();
        //         $groceryFile = fopen("grocery.txt", "w");
        //         foreach ($groceryList as $item) {
        //             if ($item[1] == $deletePname) {
        //                 fwrite($groceryFile, implode(",", $item) . "\n");
        //             }
        //         }
        //         fclose($groceryFile);
    

        //         break;
    
        //     default:
        //         echo "Enter valid CHOICE!!";
        //         // menu();
        //         break;
    
        // }
        // // menu();
    }

    function printMenu($products = null)
    {
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "none";
        </script>
        <?php

        $product = readGroceryFile();
        if ($products === null) {
            $products = $product;
        }
        if (empty($products)) {
            echo "No products to display.\n";
            return;
        }

        echo "<div style='text-align: center;'>";
        echo "<table style='margin: 0 auto; border-collapse: collapse;'>";
        echo "<tr><th style='border: 1px solid black; padding: 8px;'>PID</th><th style='border: 1px solid black; padding: 8px;'>PName</th><th style='border: 1px solid black; padding: 8px;'>Price</th></tr>";
        foreach ($products as $p) {
            echo "<tr>";
            echo "<td style='border: 1px solid black; padding: 8px;'>" . $p[0] . "</td>";
            echo "<td style='border: 1px solid black; padding: 8px;'>" . $p[1] . "</td>";
            echo "<td style='border: 1px solid black; padding: 8px;'>" . $p[2] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";

        //     echo "\n\tMenu\n";
        //     echo "\t----\n";
    
        //     if (empty($GLOBALS['productMenu'])) {
        //         echo "No products to display.\n";
        //         // menu();
        //     }
        //     // print_r($GLOBALS['productMenu']);
        //     echo "PID    PName" . str_repeat(" ", 15) . "Price\n";
        //     // for ($i = 0; $i < count($GLOBALS['productMenu']); $i++) {
        //     foreach ($GLOBALS['productMenu'] as $item) {
        //         $space = str_repeat(" ", 20 - strlen($item[1]));
        //         $idspace = str_repeat(" ", 7 - strlen($item[0]));
        //         echo $item[0] . $idspace . $item[1] . $space . $item[2] . "\n";
        //         // print_r($GLOBALS['productMenu'][$i]);
        //     }
        //     // for ($i = 0; $i < count($GLOBALS['productMenu']); $i++) {
        //     //     $space = str_repeat(" ", 20 - strlen($GLOBALS['productMenu'][$i][1]));
        //     //     $idspace = str_repeat(" ", 7 - strlen($GLOBALS['productMenu'][$i][0]));
    
        //     //     echo $GLOBALS['productMenu'][$i][0] . $idspace . $GLOBALS['productMenu'][$i][1] . $space . $GLOBALS['productMenu'][$i][2] . "\n";
    
        //     // }
    
        //     // ============================= FILE ============================
        //     $groceryList = readGroceryFile();
        //     echo "\n\nFrom File\n\n";
        //     echo "PID    PName" . str_repeat(" ", 15) . "Price\n";
        //     foreach ($groceryList as $item) {
        //         $space = str_repeat(" ", 20 - strlen($item[1]));
        //         $idspace = str_repeat(" ", 7 - strlen($item[0]));
    
        //         echo $item[0] . $idspace . $item[1] . $space . $item[2] . "\n";
    
        //     }
    
        //     // print_r($GLOBALS['productMenu']);
        //     // menu();
    }

    function exitMenu()
    {
        echo "\nIn EXIT";
        echo "\nThank you!!";

    }

    // function menu()
    // {
    
    //     echo "\n------------------------------";
    //     echo "\nEnter 1 to ADD menu.\nEnter 2 to UPDATE menu.\nEnter 3 to SEARCH menu.\nEnter 4 to DELETE menu.\nEnter 5 to PRINT menu.\nEnter 6 to EXIT menu.\n";
    //     $choice = (int) readline("\tEnter your choice: ");
    //     switch ($choice) {
    //         case '1':
    //             $plength = sizeof($GLOBALS['productMenu']);
    //             $pid = $plength + 1;
    //             echo "\nYour PID is: " . $pid . "\n";
    //             $pname = readline("Enter product name: ");
    //             while (!checkMenu($pid, $pname, $plength)) {
    //                 echo "The criteria has not been met. Please take a look\n";
    //                 $pname = readline("\nEnter product name: ");
    //             }
    //             $pprice = (int) readline("\nEnter product price: ");
    //             addMenu($pid, $pname, $pprice);
    //             break;
    
    //         case '2':
    //             updateMenu();
    //             break;
    
    //         case '3':
    //             echo "\nEnter 1 to search by PID.\nEnter 2 to search by PNAME.\nEnter 3 to search by PPRICE\n";
    //             $searchchoice = (int) readline("\nEnter your choice: ");
    //             searchMenu($searchchoice);
    //             break;
    
    //         case '4':
    //             echo "\nEnter 1 to delete by PID.\nEnter 2 to delete by PNAME.\n";
    //             $deletechoice = (int) readline("\nEnter your choice: ");
    //             deleteMenu($deletechoice);
    //             break;
    
    //         case '5':
    //             printMenu();
    //             break;
    
    //         case '6':
    //             exitMenu();
    //             break;
    
    //         default:
    //             echo "Enter a valid choice";
    //             menu();
    //             break;
    //     }
    // }
    

    // echo "inside menu\n";
    // menu();
    // addMenu("1","medi","60");
// addMenu("2","lux","40");
    if (isset($_POST["searchMenu"])) {
        if (isset($_POST["pID"])) {
            $index = searchMenu($_POST["pID"]);
            if ($index != -1) {
                printMenu(array($productMenu[$index]));
            }
        }
    }

    if (isset($_POST["updateProduct"])) {
        if (isset($_POST["pID"])) {
            updateMenu($_POST["pID"]);
        }
    }

    if (isset($_POST["deleteProduct"])) {
        if (isset($_POST["pID"])) {
            deleteMenu($_POST["pID"]);
        }
    }

    if (isset($_POST["addMenu"])) {
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "none";
            document.getElementById("productFields").style.display = "block";
        </script>
        <?php
    }

    if (isset($_POST["updateMenu"])) {
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "none";
            document.getElementById("updateProductId").style.display = "block";
        </script>
        <?php
    }

    if (isset($_POST["searchMenu"])) {
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "none";
            document.getElementById("searchMenuId").style.display = "block";
        </script>
        <?php
    }

    if (isset($_POST["deleteMenu"])) {
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "none";
            document.getElementById("deleteProductId").style.display = "block";
        </script>
        <?php
    }

    if (isset($_POST["printMenu"])) {
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "none";
        </script>
        <?php
        printMenu();
    }

    if (isset($_POST["exitMenu"])) {
        ?>
        <script>
            document.getElementById("defaultFields").style.display = "block";
            document.getElementById("defaultFields").innerHTML = `<h4>THANK YOU!!</h4>`
        </script>
        <?php
    }


    if (isset($_POST["choice"])) {
        $choice = $_POST["choice"];
        // $product = openfile();
        // for ($i = 0; $i < count($product); $i++) {
        //     if ($product[$i][0] == $pID) {
        //         $pID = rand(1, 10000);
        //     }
        // }
        switch ($choice) {
            case '0':
                ?>
                <script>
                    document.getElementById("defaultFields").style.display = "block";
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    document.getElementById("productFields").style.display = "block";
                </script>
                <?php
                break;
            case '2':
                ?>
                <script>
                    document.getElementById("updateProductId").style.display = "block";
                </script>
                <?php
                break;
            case '3':
                ?>
                <script>
                    document.getElementById("deleteProductId").style.display = "block";
                </script>
                <?php
                break;
            case '4':
                ?>
                <script>
                    document.getElementById("searchMenuId").style.display = "block";
                </script>
                <?php
                break;
            case '5':
                printMenu();
                break;
            default:
                echo "Invalid Choice";
                break;
        }
    }









    ?>
    <!-- ==========================END OF PHP=============================== -->


</body>

</html>