<?php

session_start();

require_once("db.php");
require_once("component.php");

$con = Createdb();

$erros = array();
$username = "";
$email = "";




// create button click

if(isset($_POST['create'])){
    createData();
}

if(isset($_POST['update'])){
    UpdateData();
}

if(isset($_POST['delete'])){
    deleteRecord();
}

if(isset($_POST['deleteall'])){
    deleteAll();
}



if(isset($_POST['signup-btn'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    //Validation
    if(empty($username)){
        $erros['username'] = "Username Required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erros['email'] = "Email address in invalid!";
    }

    if(empty($email)){
        $erros['email'] = "Email Required";
    }

    if(empty($password)){
        $erros['password'] = "Password Required";
    }
    
    if($password !== $passwordConf) {
        $erros['password'] = "The Two passwords do not match";
    }

    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $con->prepare($emailQuery);
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;

    if($userCount > 0) {
        $erros['email'] = "Email already exists!";
    }

    
    if(count($errors) === 0){
        $password = password_hash($password,PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;

        $sql = "INSERT INTO users(username,email,verified,token,password) VALUES (?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssbss',$username,$email,$verified,$token,$password);

        if($stmt->execute()){

            //login user
            $user_id = $con->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = $verified;

            //flash message
            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: index.php');
            exit();

        }else {
            $errors['db_error'] = "Database error: failed to register";
        }

    }


}



function createData(){
    $bookname = textboxValue("book_name");
    $bookpublisher = textboxValue("book_publisher");
    $bookprice = textboxValue("book_price");

    if($bookname && $bookpublisher && $bookprice){

        $sql = "INSERT INTO books(book_name,book_publisher,book_price)
                VALUES('$bookname','$bookpublisher', '$bookprice')";

                if(mysqli_query($GLOBALS['con'],$sql)){
                    TextNode("success","Record Successfully Inserted..!");
                }else{
                    echo "Error";
                }
    }else{
        TextNode("error","Provide data in the textbox");
    }

}

function textboxValue($value){
    $textbox = mysqli_real_escape_string($GLOBALS['con'],trim($_POST[$value]));
    if(empty($textbox)){
        return false;
    }else{
        return $textbox;
    }
}

//messages
function TextNode($classname,$msg){
    $element="<h6 class='$classname'>$msg</h6>";
    echo $element;
}


//get data from mysql database

function getData(){
    $sql="SELECT*FROM books";

    $result = mysqli_query($GLOBALS['con'],$sql);

    if(mysqli_num_rows($result)>0){
       return $result;
    }
}

//update data

function UpdateData(){
    $bookid = textboxValue("book_id");
    $bookname = textboxValue("book_name");
    $bookpublisher = textboxValue("book_publisher");
    $bookprice = textboxValue("book_price");

    if($bookname && $bookpublisher && $bookprice){
        $sql="
            UPDATE books SET book_name='$bookname', book_publisher='$bookpublisher',book_price='$bookprice' WHERE id='$bookid';    
        ";

            if(mysqli_query($GLOBALS['con'],$sql)){
                TextNode("success","Data Successfully Updated");
            }else{
                TextNode("error","Unable to Update Data");
            }


    }else{
            TextNode("error","Select Data using edit icon");
    }
}


// delete data

function deleteRecord(){
    $bookid  = (int)textboxValue("book_id");

    $sql = "DELETE FROM books WHERE id=$bookid";

    if(mysqli_query($GLOBALS['con'],$sql)){
        TextNode("success","Record Deleted Succesfully...!");
    }else{
        TextNode("error","Unable to Delete Record...!");
    }
}

function deleteBtn(){
    $result = getData();
    $i = 0;
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $i++;
            if($i > 3){
                buttonElement("btn-deleteall","btn btn-danger","<i class='fas fa-trash'></i>Delete All","deleteall","");
                return;
            }
        }
    }
}

function deleteAll(){
    $sql = "DROP TABLE books";

    if(mysqli_query($GLOBALS['con'],$sql)){
        TextNode("success","All Record's deleted successfully...!");
        Createdb();
    }else{
        TextNode("error","Something went wrong All records cannot be  deleted");
    }
}


