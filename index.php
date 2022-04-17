<?php
define("DIR", __DIR__);

require_once DIR . "/connection/connect.php";


//insert dataha
if(isset($_POST['submit']) && $_POST["submit"] == "add"){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $Email = $_POST["Email"];
    
    $valid = true ;

    if (empty($firstName) || 
        empty($lastName) || 
        empty($Email)) 
        {
        $message = "<p class='error'> please Enter completely.</p>";
        $msgColor = "red";
        $valid = false;
    }

    if(!filter_var($Email, FILTER_VALIDATE_EMAIL) && $valid ){
        $message = "<p class='error'> please enter a valid Email. </p>";
        $msgColor = "red";
        $valid = false;
    }



    if($valid !== false){
        $sql = "INSERT INTO student (firstName , lastName , Email) 
                VALUES ('$firstName' , '$lastName' , '$Email')";

        if($conn->query($sql) == true){
            $message = "<p class='success'> your data successfully added </p>";
            $msgColor = "green";
        }else{
            $message = "<p class='error'> sorry a problem happend </p>";
            $msgColor = "red";
        }
    }else{
        $fname = $firstName;
        $lname = $lastName;
        $email = $Email;
    }
}
/////////////////////////////////////////////




//delet kardan
if(isset($_POST['delete']) && $_POST['delete']=='delete'){
    $sql = "DELETE FROM student WHERE id={$_POST['deletId']}";
   
    if($conn->query($sql) == true){
        $message = "<p class='success'> your data successfully deleted </p> ";
        $msgColor = "green";
    }else{
        $message = "<p class='error'> sorry a problem happend </p> ";
        $msgColor = "red";
    }
    
}
/////////////////////////////////////////////


$disable = "";
//marhale aval : gereftan etelaat az jadval database 
if(isset($_POST['edit']) && $_POST['edit'] == 'edit'){

    
    $sql = "SELECT * FROM student WHERE id ={$_POST['editId']}";
    $result = $conn->query($sql);
    
    $class_id = $_POST['editId'];
    $edit = true ;
    $disable = "disabled";

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $id    = $row['id'];
            $fname = $row['firstName'];
            $lname = $row['lastName'];
            $email = $row['Email'];
        }
    }

}
/////////////////////////////////////////////


//marhale dovom : gozashtan etelaat dar jadval
if(isset($_POST['edite']) && $_POST['edite']== 'edite'){
    
    $idedit    = $_POST['editeId'];
    $fnameedit = $_POST['firstName'];
    $lnameedit = $_POST['lastName'];
    $emailedit = $_POST['Email'];

    $valid = true ;

    if (empty($fnameedit) || 
        empty($lnameedit) || 
        empty($emailedit)) 
        {
        $message = "<p class='error'> please Enter completely.</p> ";
        $msgColor = "red";
        $valid = false;
    }

    if(!filter_var($emailedit, FILTER_VALIDATE_EMAIL) && $valid ){
        $message = "<p class='error'> please enter a valid Email.</p>";
        $msgColor = "red";
        $valid = false;
    }

    if($valid !== false){
    
        $sql = "UPDATE student SET firstName='$fnameedit', lastName='$lnameedit',Email='$emailedit' WHERE id={$idedit}";

        if($conn->query($sql) == true){
            $message = "<p class='success'> your data successfully updated </p>";
            $msgColor = "green";
        }else{
            $message = "<p class='error'> sorry a problem happend.</p>";
            $msgColor = "red";
        }
    }else{
        //hame chi kharab shode dobare emtehan konim
        $class_id = $idedit ;
        $edit = true ;
        $disable = "disabled";
        $id    = $idedit;
        $fname = $fnameedit;
        $lname = $lnameedit;
        $email = $emailedit;
    }

}

/////////////////////////////////////////////
$where =  ' 1 ';
if(isset($_POST['search']) && $_POST['search'] == 'search'){

    if (isset($_POST['sname']) && !empty($_POST['sname'])){
        $name = $_POST['sname'];
        $where .= " AND firstName LIKE '%$name%' ";
    }

    if (isset($_POST['lname']) && !empty($_POST['lname'])){
        $name = $_POST['lname'];
        $where .= " AND lastName LIKE '%$name%' ";
    }
}



// SELECT DATA
// hamishe select mikonad
$count = 10;
$page  = $_REQUEST['page'];
if (empty($page)) {
    $page = 0;
}
$start = $page * $count;


$sql = "SELECT count(id) as cid FROM student  WHERE $where ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total = $row['cid']; 
    }
}

$pages = floor($total / $count);



$sql = "SELECT * FROM student 
    WHERE $where
    ORDER BY reg_date DESC
    LIMIT $start , $count  ";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row; 
    }
}

/////////////////////////////////////////////




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./materialaize/materialaize1.css"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>

    <style>

    </style>
    
</head>
<body>
<div class="container ">
    <div class="row ">
        <div class="col s12 ">
            <div class="card ">
                <div class="card-content ">
                <span class="card-title">Personal Information</span>
                    <form method="POST">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input type="text" name="firstName" id="first" value="<?php echo @$fname; ?>" placeholder="Enter your Name:">
                            </div>
                        
                            <div class="input-field col s12 m6">
                                <input type="text" name="lastName" id="last" value="<?php echo @$lname; ?>" placeholder="Enter your Family:">
                            </div>
                        
                            <div class="input-field col s12 m6">   
                                <input type="text" name="Email" id="email" value="<?php echo @$email; ?>" placeholder="Enter your Email:">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">      
                                <input type="submit" value="add" name="submit" id="add_id" class="waves-effect waves-light btn" <?php echo @$disable; ?> > 
                                
                                <?php
                                if($edit == true){
                                    echo "<input type='submit' value='edite' name='edite' class='waves-effect waves-light btn'>";
                                    echo "<input type='hidden' value='{$id}' name='editeId'>";
                                    echo "<a href='index.php' style='color:black;margin-left: 5px;' id='aId' class='waves-effect waves-light btn'>cancel</a> ";
                                }
            
                                ?>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                <span class="card-title">search</span>
                    <form method="POST">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <input type="text" name="sname" id="searchfield" placeholder="search by name">
                            </div>
                            <div class="col s12">
                                <input type="submit" name="search" value="search" class="waves-effect waves-light btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    
        <?php
        if(isset($message)){
            echo "<div class='row '>
                    <div class='col s12 m6'>
                        <div class='card $msgColor'>
                            <div class='card-content'>
                                 $message 
                            </div>
                        </div>
                    </div>
                </div> " ;
        }
           
        ?>
                
    
    <br>

    <div class="row">
        <div class="col s12 ">
            <div class="card">
                <div class="card-content">
                <span class="card-title">Checking Information</span>
                    <table>
                        <tr >
                            <th>id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Reg Date</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                        <?php
                          
                          
                            $f= $start + 1;
                          
                            foreach ($data as $d) {


                                if( $d['id'] == $class_id) {
                                    $class = "pink lighten-3";
                                }else{
                                    $class = "";
                                }

                                echo "<tr class='$class'>  
                                <td>  $f  </td>
                                <td>  {$d["firstName"]} </td>
                                <td>  {$d["lastName"] } </td>
                                <td>  {$d["Email"] } </td>
                                <td>  {$d["reg_date"] } </td>
                                <td> 
                                    <form method='POST' class='center-align'>
                                        <input type='submit' value='delete' name='delete' class='waves-effect waves-light btn' $disable> 
                                        <input type='hidden' value='{$d['id']}' name='deletId'>
                                    </form>
                                </td>
                                <td> 
                                    <form method='POST' class='center-align'>
                                        <input type='submit' value='edit' name='edit' class='waves-effect waves-light btn' $disable> 
                                        <input type='hidden' value='{$d['id']}' name='editId'>
                                    </form>
                                </td>
                                </tr>";
                                $f++;
                            }
                            
                            
                        ?>
                    </table>
                    <?php


                    if($page == 0){
                        $disable ="disabled";
                    }elseif($page == $pages){
                        $dis ="disabled";
                    }

                    echo "<ul class='pagination center-align'>";
                    echo "<li class='$disable'><a href='?page=".($page-1)."'><i class='material-icons'>chevron_left</i></a></li>" ;
                   
                    for($i=0 ; $i<= $pages ; $i++){
                      
                        
                        if($page == $i){
                            $class = "active";
                        }else{
                            $class="";
                        }
                        
                        echo "<li class='waves-effect $class'><a href='?page=$i'> ".($i+1). " </a> </li>";
                        
                    }
                    echo "<li class='$dis'><a href='?page=".($page+1)."'><i class='material-icons'>navigate_next</i></a></li>" ;
                    echo "</ul>" ;
                        
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="./materialaize/materialize2.js"></script>
</body>
</html>

 
  
