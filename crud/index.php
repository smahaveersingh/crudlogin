<?php
require_once("../crud/php/component.php");
require_once("../crud/php/operation.php");



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-v8BU367qNbs/aIZIxuivaU55N5GPF89WBerHoGA4QTcbUjYiLQtKdrfXnqAcXyTv" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>



<body>
<main>
    <div class="container text-center">
     <h1 class="py"><i class="fas fa-book-reader"></i> Book Store</h1>
    
    

    <div class="alert alert-warning">
        You need to verify your account.
        Sign in to verify your email account and click on the verification link we just emailed you.
    </div>

    <button class="btn btn-block btn-lg btn-primary">I am Verified!</button>
    <a href="#" class="logout">Logout</a>

    <div class="d-flex justify-content-center">
        <form action="" method="post" class="w-50">
            <div class="py-2">
                <?php inputElement("<i class='fas fa-id-badge'></i>","ID","book_id",""); ?>
            </div>
            <div class="pt-2">
                <?php inputElement("<i class='fas fa-book'></i>","Bookname","book_name",""); ?>
            </div>
            <div class="row">
            <div class="col">
                <?php inputElement("<i class='fas fa-people-carry'></i>","Publisher","book_publisher",""); ?>
                </div>
                <div class="col">
                <?php inputElement("<i class='fas fa-euro-sign'></i>","Price","book_price",""); ?>
                </div>

                <div class="d-flex justify-content-bottom">
                    <?php buttonElement("btn-create", "btn btn-success","<i class='fas fa-plus'></i>", "create", "data-toggle='tooltip' data-placement='buttom' title='Create'")?>
                    <?php buttonElement("btn-read", "btn btn-primary","<i class='fas fa-sync'></i>", "read", "data-toggle='tooltip' data-placement='buttom' title='Read'")?>
                    <?php buttonElement("btn-update", "btn btn-light","<i class='fas fa-pen-alt'></i>", "update", "data-toggle='tooltip' data-placement='buttom' title='Update'")?>
                    <?php buttonElement("btn-delete", "btn btn-danger","<i class='fas fa-trash-alt'></i>", "delete", "data-toggle='tooltip' data-placement='buttom' title='Delete'")?>
                    
                    <?php deleteBtn();?>
                </div>
            </div>
        </form>
    </div>

       <div style="padding: 20px 0; margin: 1em 10em;" class="d-flex table-data">
           <table class="table table-striped table-dark">
               <thead class="thead-dark">
                   <tr>
                       <th>ID</th>
                       <th>Book Name</th>
                       <th>Publisher</th>
                       <th>Book Price</th>
                       <th>Edit</th>
                </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                    
                    if(isset($_POST['read'])){
                        $result = getData();

                        if($result){

                            while($row = mysqli_fetch_assoc($result)){?>

                                <tr>
                                    <td data-id="<?php echo $row['id'];?> "><?php echo $row['id']; ?></td>
                                    <td data-id="<?php echo $row['id'];?>"><?php echo $row['book_name']; ?></td>
                                    <td data-id="<?php echo $row['id'];?>"><?php echo $row['book_publisher']; ?></td>
                                    <td data-id="<?php echo $row['id'];?>"><?php echo $row['book_price']; ?></td>
                                    <td><i class="fas fa-edit btnedit" data-id="<?php echo $row['id'];?>"></i></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    
                    ?>
                </tbody>
                </table>

       </div>

    </div>
</main>





<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="../crud/php/main.js"></script>

</body>
</html>
