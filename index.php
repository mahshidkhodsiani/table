<?php

$servername = "localhost";
$username = "root";
$password = "freemint";
$dbname = "local_1";

$conn = new mysqli($servername, $username ,$password , $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
CONNECTION
*/


//gereftan dataha
if(isset($_POST['submit']) && $_POST["submit"] == "add"){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $Email = $_POST["Email"];
    


    $sql = "INSERT INTO student (firstName , lastName , Email) 
            VALUES ('$firstName' , '$lastName' , '$Email')";




    if($conn->query($sql) == true){
        $message = "your data successfully added";
    }else{
        $message = "sorry a problem happend";
    }
}
/////////////////////////////////////////////


//delet kardan
if(isset($_POST['delete']) && $_POST['delete']=='delete'){
    $sql = "DELETE FROM student WHERE id={$_POST['deletId']}";
   
   
    
    if($conn->query($sql) == true){
        $message = "your data successfully deleted";
    }else{
        $message = "sorry a problem happend";
    }
    
}
/////////////////////////////////////////////


//marhale aval : gereftan etelaat az jadval database 
if(isset($_POST['edit']) && $_POST['edit'] == 'edit'){
    $sql = "SELECT * FROM student WHERE id ={$_POST['editId']}";
    $result = $conn->query($sql);
    $edit = true ;
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $id    =  $row['id'];
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
    
    $sql = "UPDATE student SET firstName='$fnameedit', lastName='$lnameedit',Email='$emailedit' WHERE id={$idedit}";

    if($conn->query($sql) == true){
        $message = "your data successfully updated";
    }else{
        $message = "sorry a problem happend";
    }
}

/////////////////////////////////////////////



// SELECT DATA
// hamishe select mikonad
$sql = "SELECT * FROM student";
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
    <title>Document</title>
    <style>
        table , tr , th , td {
            border: solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col s12">
            <form method="POST">
                <input type="text" name="firstName" id="first" value="<?php echo @$fname; ?>" placeholder="Enter your Name:">
                <input type="text" name="lastName" id="last" value="<?php echo @$lname; ?>" placeholder="Enter your Family:">
                <input type="text" name="Email" id="email" value="<?php echo @$email; ?>" placeholder="Enter your Email:">
                <input type="submit" value="add" name="submit" id="add_id">
                <?php
                 if($edit == true){
                     echo "<input type='submit' value='edite' name='edite'>";
                     echo "<input type='hidden' value='{$id}' name='editeId'>";
                 }
                ?>
              
            </form>
        </div>
    </div>
    <br>

    <?php
    if(isset($message)){
        echo $message ;
    }
    ?>
    <br>

    <div class="row">
        <div class="col s12">
            <table>
                <tr>
                    <th>id</th>
                    <th>first name</th>
                    <th>last name</th>
                    <th>email</th>
                    <th>reg date</th>
                    <th>delete</th>
                    
                </tr>
                <?php  
                    
                    foreach ($data as $value){
                        echo "<tr>  

                        <td>  {$value["id"]}  </td>
                        <td>  {$value["firstName"]} </td>
                        <td>  {$value["lastName"] } </td>
                        <td>  {$value["Email"] } </td>
                        <td>  {$value["reg_date"] } </td>
                        <td> 
                            <form method='POST'>
                                <input type='submit' value='delete' name='delete'> 
                                <input type='hidden' value='{$value['id']}' name='deletId'>
                            </form>
                        </td>
                        <td> 
                            <form method='POST'>
                                <input type='submit' value='edit' name='edit'> 
                                <input type='hidden' value='{$value['id']}' name='editId'>
                            </form>
                        </td>
                        </tr>";
                    }
                    
                ?>
            </table>
        </div>
    </div>

    <script src="./materialaize/materialize2.js"></script>
</body>
</html>

 
  
