<?php
define("DIR", __DIR__);

require_once DIR . "/connection/connect.php";
// require_once DIR . "/core/app.php";



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
        $message = "please Enter completely. ";
        $valid = false;
    }

    if(!filter_var($Email, FILTER_VALIDATE_EMAIL) && $valid ){
        $message = " please enter a valid Email";
        $valid = false;
    }



    if($valid !== false){
        $sql = "INSERT INTO student (firstName , lastName , Email) 
                VALUES ('$firstName' , '$lastName' , '$Email')";

        if($conn->query($sql) == true){
            $message = "your data successfully added ";
        }else{
            $message = "sorry a problem happend";
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
        $message = "your data successfully deleted ";
    }else{
        $message = "sorry a problem happend";
    }
    
}
/////////////////////////////////////////////

$disable = "";
//marhale aval : gereftan etelaat az jadval database 
if(isset($_POST['edit']) && $_POST['edit'] == 'edit'){
    $sql = "SELECT * FROM student WHERE id ={$_POST['editId']}";
    $result = $conn->query($sql);

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
        $message = "please Enter completely. ";
        $valid = false;
    }

    if(!filter_var($emailedit, FILTER_VALIDATE_EMAIL) && $valid ){
        $message = " please enter a valid Email";
        $valid = false;
    }

    if($valid !== false){
    
        $sql = "UPDATE student SET firstName='$fnameedit', lastName='$lnameedit',Email='$emailedit' WHERE id={$idedit}";

        if($conn->query($sql) == true){
            $message = " your data successfully updated ";
        }else{
            $message = "sorry a problem happend";
        }
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
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                <span class="card-title">Personal Information</span>
                    <form method="POST">
                        <input type="text" name="firstName" id="first" value="<?php echo @$fname; ?>" placeholder="Enter your Name:">
                        <input type="text" name="lastName" id="last" value="<?php echo @$lname; ?>" placeholder="Enter your Family:">
                        <input type="text" name="Email" id="email" value="<?php echo @$email; ?>" placeholder="Enter your Email:">
                        <input type="submit" value="add" name="submit" id="add_id" class="waves-effect waves-light btn" <?php echo @$disable; ?> > 
                        
                        <?php
                        if($edit == true){
                            echo "<input type='submit' value='edite' name='edite' class='waves-effect waves-light btn'>";
                            echo "<input type='hidden' value='{$id}' name='editeId'>";
                        }
     
                        ?>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <?php
    if(isset($message)){
        echo "<p>". $message . "</p>" ;
    }
    ?>
    <br>

    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                <span class="card-title">Checking Information</span>
                    <table>
                        <tr>
                            <th>id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Reg Date</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                        <?php  
                            
                            foreach ($data as $d){
                                echo "<tr>  

                                <td>  {$d["id"]}  </td>
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
                            }
                            
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="./materialaize/materialize2.js"></script>
</body>
</html>

 
  
