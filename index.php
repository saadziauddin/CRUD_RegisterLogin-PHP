<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD & Register/Login</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-10">
                <h2>CRUD & Register/Login Practice</h2>
            </div>
            <div class="col-2">
                <a href="?add_data" class="btn btn-secondary ">Add New Data</a>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <th>ID</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Father Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Grade</th>
                <th>Address</th>
                <th>Date</th>
                <th>Edit Data</th>
                <th>Delete Data</th>
            </thead>
            <?php
                include "connection.php";
                $FetchAllData = mysqli_query($connect, 'SELECT * FROM mytable');
                while($FetchData = mysqli_fetch_assoc($FetchAllData)){
            ?>
            <tbody>
                <td><?php echo $FetchData['id']; ?></td>
                <td><img src="Images/<?php echo $FetchData['image']; ?>" width="100" height="60"/></td>
                <td><?php echo $FetchData['name']; ?></td>
                <td><?php echo $FetchData['fname']; ?></td>
                <td><?php echo $FetchData['email']; ?></td>
                <td><?php echo $FetchData['phone']; ?></td>
                <td><?php echo $FetchData['grade']; ?></td>
                <td><?php echo $FetchData['address']; ?></td>
                <td><?php echo $FetchData['date']; ?></td>
                <td><a href="?edit_data=<?php echo $FetchData['id']; ?>" class="btn btn-outline-info btn-sm">Edit Data</a></td>
                <td><a href="?delete_data=<?php echo $FetchData['id']; ?>" class="btn btn-outline-danger btn-sm">Delete Data</a></td>
            </tbody>
            <?php } ?>
        </table>
        
        <!-- Adding Data -->
        <?php
            if(isset($_GET['add_data'])){
        ?>    
        <form class="row" action="" method="POST" enctype="multipart/form-data">
            <h3 class="text-center text-uppercase">Add Data</h3>
            <div class="col-4"></div>
            <div class="col-4">
                <input type="text" class="form-control mb-2" name="name" placeholder="Enter Your Name" required>
            
                <input type="text" class="form-control mb-2" name="fname" placeholder="Enter Your Father Name" required>
            
                <input type="email" class="form-control mb-2" name="email" placeholder="Email Address" required>
            
                <input type="number" class="form-control mb-2" name="phone" placeholder="Enter Phone number" required>
            
                <input type="number" class="form-control mb-2" name="grade" placeholder="Enter Your Grade" required>
            
                <input type="text" class="form-control mb-2" name="address" placeholder="Residential Address" required>

                <input type="file" class="form-control mb-2" name="add_img" required>
            
                <button type="submit" class="btn btn-sm btn-dark" name="adding_data">Add Data</button>
            </div>
            <div class="col-4"></div>
        </form>
        <?php } 

            if(isset($_POST['adding_data'])){
                include "connection.php";
                $img = $_FILES['add_img']['name'];
                $img_size = $_FILES['add_img']['size'];
                $img_tmp_name = $_FILES['add_img']['tmp_name'];
                $extension = pathinfo($img,PATHINFO_EXTENSION);
                $destination = "Images/".$img;

                if($img_size <= 2000000){
                    if($extension = "JPG" OR $extension = "JPEG" OR $extension = "PNG"){
                        if(move_uploaded_file($img_tmp_name,$destination)){
                            $name = $_POST['name'];
                            $fname = $_POST['fname'];
                            $email = $_POST['email'];
                            $phone = $_POST['phone'];
                            $grade = $_POST['grade'];
                            $address = $_POST['address'];
                            mysqli_query($connect, "INSERT INTO mytable(image,name,fname,email,phone,grade,address)
                                                    VALUES ('$img','$name','$fname','$email','$phone','$grade','$address') ");
                            echo "<script>
                                    location.assign('index.php');
                                </script>";
                        }
                    }
                }
            }
        ?>

        <!-- Deleting Data -->
        <?php
            if(isset($_GET['delete_data'])){
                include "connection.php";
                $delete = $_GET['delete_data'];
                mysqli_query($connect, "DELETE FROM mytable WHERE id = '$delete' ");
                echo "<script>
                    location.assign('index.php');
                </script>";
            }
        ?>

        <!-- Editing Data -->
        <?php
            if(isset($_GET['edit_data'])){
                include "connection.php";
                $edit_data = $_GET['edit_data'];
                $fetch_edit_data = mysqli_query($connect, "SELECT * FROM mytable WHERE id = '$edit_data'");
                $edit = mysqli_fetch_assoc($fetch_edit_data);
        ?>
        <form class="row" action="" method="POST">
            <h3 class="text-center text-uppercase">Edit Data</h3>
            <div class="col-4"></div>
            <div class="col-4">
                <input type="hidden" class="form-control mb-2" name="id" value="<?php echo $edit['id'] ?>" required>

                <input type="text" class="form-control mb-2" name="name" value="<?php echo $edit['name'] ?>" required>
            
                <input type="text" class="form-control mb-2" name="fname" value="<?php echo $edit['fname'] ?>" required>
            
                <input type="email" class="form-control mb-2" name="email" value="<?php echo $edit['email'] ?>" required>
            
                <input type="number" class="form-control mb-2" name="phone" value="<?php echo $edit['phone'] ?>" required>
            
                <input type="number" class="form-control mb-2" name="grade" value="<?php echo $edit['grade'] ?>" required>
            
                <input type="text" class="form-control mb-2" name="address" value="<?php echo $edit['address'] ?>" required>
            
                <button type="submit" class="btn btn-sm btn-dark" name="editing_data">Edit Data</button>
            </div>
            <div class="col-4"></div>
        </form>
        <?php } 
            if(isset($_POST['editing_data'])){
                include "connection.php";
                $id = $_POST['id'];
                $name = $_POST['name'];
                $fname = $_POST['fname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $grade = $_POST['grade'];
                $address = $_POST['address'];
                mysqli_query($connect, "UPDATE mytable SET name = '$name',fname = '$fname',email = '$email',phone = '$phone',grade = '$grade',address = '$address' WHERE id = '$id'");
                echo "<script>
                    location.assign('index.php');
                </script>";
            }


        ?>


    </div>
</body>
</html>