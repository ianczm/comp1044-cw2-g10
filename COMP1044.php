<?php  include('php_code.php'); ?>
<?php

    require_once("dbtools.inc.php");

    function createSearchBox($icon, $placeholder, $name, $value) {
        $ele = "
        
        <div class=\"input-group mb-3\">
            <input type=\"text\" class=\"form-control\" name=\"$name\" placeholder=\"$placeholder\" aria-label=\"$placeholder\" aria-describedby=\"basic-addon2\">
            <div class=\"input-group-append\">
                <button class=\"btn btn-warning\" type=\"button\">$icon</button>
            </div>
        </div>
        
        ";
        echo $ele;
    }

    function getTable($sql) {
        $records_per_page = 20;

        if(isset($_GET["page"]))
        $page=$_GET["page"];
        else
        $page=1;

        $link=create_connection();

        // $table_selection = "customer";
        $result=execute_sql($link, "cw2-entertainment", $sql);
        $total_fields=mysqli_num_fields($result);

        $total_records=mysqli_num_rows($result);

        $total_pages=ceil($total_records/$records_per_page);

        $started_record=$records_per_page*($page-1);

        $result_array = array($page, $total_pages, $result, $link, $total_fields, $records_per_page, $sql, $total_records, $started_record);

        return $result_array;

    }

    function printTable($page, $total_pages, $result, $link, $total_fields, $records_per_page, $sql, $total_records, $started_record) {
        mysqli_data_seek($result,$started_record);

        if (isset($_GET['table'])) {
            $table = $_GET['table'];
        }
        else {
            $table = "Customer";
        }

        echo "<table class=\"table table-sm table-light table-striped table-bordered table-hover\">";
        echo "<thead class=\"table-dark\"><tr>";
        for ($i=0; $i<$total_fields; $i++) {
            echo"<th>". mysqli_fetch_field_direct($result, $i)->name ."</th>";
        }
        echo"<th>Edit</th>";
        echo"<th>Delete</th>";
        echo"</tr></thead>";

        $j=1;
        while($row=mysqli_fetch_row($result)and $j <= $records_per_page)
        {
            echo"<tr>";
            for($i=0;$i<$total_fields;$i++) {
                echo"<td class=\"align-middle\">$row[$i]</td>";
            }
            
            // // edit bottom
            // echo "<td><a href='COMP1044.php?page=$page&table=$table&edit_id=$row[0]'><i class=\"fas fa-edit btnedit\"></i></a></td>";
 
            // // delete bottom
            // echo "<td><a href='COMP1044.php?page=$page&table=$table&del_id=$row[0]'><i class=\"fas fa-trash-alt\"></i></a></td>";

            // edit bottom
            echo "
            <form action='#' method='post'>
                <td><button class='btn' type='submit' name='edit' value=$row[0]><i class=\"fas fa-edit btnedit\"></i></button></td>
            </form>
            ";
 
            // delete bottom
            echo "
            <form action='#' method='post'>
                <td><button class='btn' type='submit' name='del' value='".htmlentities(serialize(array(mysqli_fetch_field_direct($result, 0)->name, $row[0], $table)))."'><i class=\"fas fa-trash-alt\"></i></button></td>
            </form>
            ";
            
            $j++;
            echo"</tr>";
        }
        echo"</table>";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMP1044</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/6283cae941.js" crossorigin="anonymous"></script>
</head>
<body>
    <main>
        <div class="container-fluid text-center">
            <h1 class="py-4 bg-dark text-light rounded"><i class="fas fa-database"></i> Group 10 - COMP1044</h1>
            <div id="control" class="d-flex justify-content-center">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php

                                    if ($_SESSION['is_search']) {
                                        $final_query_sql = $_SESSION['search_sql'];
                                        $_SESSION['is_search'] = 0;
                                    } elseif (isset($_GET['table'])) {
                                        $final_query_sql = "SELECT * FROM ".$_GET['table'];
                                    }

                                    if (isset($_GET['table'])) {
                                        echo $_GET['table'];
                                        $result_array = getTable($final_query_sql);
                                        $table = $_GET['table'];
                                        $_SESSION['table'] = $table;
                                    }
                                    else {
                                        echo "Customer";
                                        $result_array = getTable("SELECT * FROM Customer");
                                        $table = "Customer";
                                    }
                                    

                                    if (isset($_POST['edit'])) {
                                        $id = $_POST['edit'];
                                        $update = true;
                                        $id_field_name = mysqli_fetch_field_direct($result_array[2], 0)->name;
                                        $record = mysqli_query($db, "SELECT * FROM $table WHERE $id_field_name=$id");

                                        if ($record !== false && $record->num_rows == 1) {
                                            $n = mysqli_fetch_array($record);
                                        }
                                    }

                                    $fieldname_array = array();

                                        for ($i=0; $i<$result_array[4]; $i++) {
                                            $field_name = mysqli_fetch_field_direct($result_array[2], $i)->name;
                                            array_push($fieldname_array, $field_name);
                                        }

                                    $_SESSION['fieldnames'] = implode(", ", $fieldname_array);

                                    $update_fail = -1;    
                                    if (isset($_POST['update'])) {

                                        $temp_update_array = array();
                                        $id = $_POST['fields'][0];
                                        $id_field_name = mysqli_fetch_field_direct($result_array[2], 0)->name;

                                        for ($i=1;$i<$result_array[4];$i++) {
                                            $temp_fieldname = $fieldname_array[$i];
                                            $temp_fieldvalue = $_POST['fields'][$i];
                                            array_push($temp_update_array, $temp_fieldname."='".$temp_fieldvalue."'");
                                        }

                                        $sql = "UPDATE $table
                                        SET ".implode(", ", $temp_update_array)."WHERE $id_field_name=$id";

                                        // echo $sql;

                                        if ($db->query($sql) === TRUE) {
                                            $update_fail = 0;
                                        } else {
                                            $update_fail = $db->error;
                                        }

                                        $_POST['update'] = 0;
                                    }

                                    ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Actor">Actor</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Address">Address</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Category">Category</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=City">City</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Country">Country</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Customer">Customer</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Film">Film</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Film_Actor">Film_Actor</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Film_Category">Film_Category</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Film_DetailRental">Film_DetailRental</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Film_Text">Film_Text</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Inventory">Inventory</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Language">Language</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Payment">Payment</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Phone_Detail">Phone_Detail</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Rental">Rental</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Staff">Staff</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Staff_Detail">Staff_Detail</a></li>
                                    <li><a class="dropdown-item" href="COMP1044.php?table=Store">Store</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <form action="" method="post" class="w-50">
                                <div class="pt-2">
                                    <form action="#" method="post">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="search-box" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-warning" type="submit"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form action="#" method="post">
                        <?php

                        // $fieldname_array = array();

                        for ($i=0; $i<$result_array[4]; $i++) {

                            $temp = $i;
                            // $field_name = mysqli_fetch_field_direct($result_array[2], $i)->name;
                            $field_name = $fieldname_array[$i];
                            // array_push($fieldname_array, $field_name);

                            if ($temp % 2 == 0) {
                                echo "<div class='row' style='margin-bottom: 15px'>";
                            }

                            if ($update) {
                                $temp_value = $n[$field_name];
                            } else {
                                $temp_value = "";
                            }

                            echo "
                                    <div class='col'>
                                        <div class='form-floating'>
                                            <input type='text' class='form-control' id='floatingInputValue' placeholder='x' name='fields[]' value='".
                                            $temp_value
                                            ."'
                                            >
                                            <label for='floatingInputValue'>".$field_name."</label>
                                        </div>
                                    </div>
                            ";

                            if ($temp % 2 == 1) {
                                echo "</div>";
                            }
                        }

                        if ($temp % 2 == 0) {
                            echo "</div>";
                        }

                        ?>

                        <?php if ($update == true): ?>
                        <button class="btn btn-info" type="submit" name="update" value=<?php echo $table?>>Update</button>
                        <?php elseif ($update_fail != 0): ?>
                        <button class="btn btn-primary" type="submit" name="save" value=<?php echo $table?>>Save</button>
                        <?php endif ?>
                        <?php
                        
                        if ($update_fail == 0) {
                            echo "<button class=\"btn btn-outline-success\" onClick=\"window.location.reload();\">Refresh</button>";
                        } elseif ($update_fail == -1) {
                            // nothing here
                        } else {
                            echo "Error updating record: ".$update_fail;
                        }

                        ?>
                    </form>
                </div>
            </div>
            <div class="d-flex table-data container">
                <!-- print table -->
                <?php printTable(...$result_array) ?>
            </div>
            <div id="pagenumbers" class="btn-group btn-group-sm container" style="margin-bottom: 10em">
            <?php

            if ($result_array[0]-8 < 1) {
                $lower = 1;
                $showfirst = 0;
            } else {
                $lower = $result_array[0]-8;
                $showfirst = 1;
            }

            if ($result_array[0]+8 > $result_array[1]) {
                $upper = $result_array[1];
                $showlast = 0;
            } else {
                $upper = $result_array[0]+8;
                $showlast = 1;
            }

            // double left chevron
            if ($showfirst) {
                echo"<a class='btn btn-outline-secondary' href='COMP1044.php?page=1&table=".($table)."'><i class=\"fas fa-angle-double-left\"></i></a>";
            }

            // left chevron
            if($result_array[0]>1)
                echo"<a class='btn btn-outline-secondary' href='COMP1044.php?page=".($result_array[0]-1)."&table=".($table)."'><i class=\"fas fa-chevron-left\"></i></a>";

            // normal display
            if($result_array[1] < 21) {
                for($i=1; $i<=$result_array[1]; $i++)
                {
                    if($i==$result_array[0])
                        echo"<a class='btn btn-outline-secondary active' href='COMP1044.php?page=$i".($table)."'>$i</a>";
                    else
                        echo"<a class='btn btn-outline-secondary' href='COMP1044.php?page=$i&table=".($table)."'>$i</a>";
                }
            } else { // minimised display
                for($i=$lower; $i<=$upper; $i++)
                {
                    if($i==$result_array[0])
                        echo"<a class='btn btn-outline-secondary active' href='COMP1044.php?page=$i".($table)."'>$i</a>";
                    else
                        echo"<a class='btn btn-outline-secondary' href='COMP1044.php?page=$i&table=".($table)."'>$i</a>";
                }
            }

            // right chevron
            if($result_array[0]<$result_array[1])
                echo"<a class='btn btn-outline-secondary' href='COMP1044.php?page=".($result_array[0]+1)."&table=".($table)."'><i class=\"fas fa-chevron-right\"></i></a>";

            // right double chevron
            if ($showlast) {
                echo"<a class='btn btn-outline-secondary' href='COMP1044.php?page=$result_array[1]&table=".($table)."'><i class=\"fas fa-angle-double-right\"></i></a>";
            }

            mysqli_free_result($result_array[2]);

            mysqli_close($result_array[3]);

            ?>
            </div>
            <div class="container-fluid" style="margin-bottom: 50px">
                <div class="card text-center">
                    <div class="card-header">
                        Our Team
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Database and Interfaces - Group 10</h5>
                        <p class="card-text">Tan Khai Han, Lim Shin Huey, Ian Chong Zhen Ming, Justin Sem Ee Qing, Lee Sen Wei</p>
                    </div>
                    <div class="card-footer text-muted"></div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>