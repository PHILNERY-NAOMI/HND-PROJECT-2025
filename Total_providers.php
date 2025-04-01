<?php

require_once('config/db2.php');
$query ="select * from company_registration";
$result = mysqli_query($con,$query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/newestlogo.jpg">
    <link rel="stylesheet" href="Bootstrap file/bootstrap 4/css/bootstrap.min.css">
    <title>Total Companies</title>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5" style="width:1300px;margin-left:-170px;">
                    <div class="card-header">
                        <h2 class="display-6 text-center">Total Registered Companies</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <tr class=" text-black" style="background-color:yellow;">
                                <td>Company Id</td>
                                <td>Company Name</td>
                                <td>Manager Name</td>
                                <td>Town</td>
                                <td>Country</td>
                                <td>Email</td>
                                <td>Password</td>
                            </tr>
                            <tr>
                                <?php
                                
                                while($row = mysqli_fetch_assoc($result))
                                {
                              ?>
                                    <td><?php echo $row['id']?></td>
                                    <td><?php echo $row['company_name']?></td>
                                    <td><?php echo $row['manager_name']?></td>
                                    <td><?php echo $row['town']?></td>
                                    <td><?php echo $row['country']?></td>
                                    <td><?php echo $row['email']?></td>
                                    <td><?php echo $row['password']?></td>
                                    <td><a href="#" class="btn btn-primary">Edit</a></td>
                                    <td><a href="#" class="btn btn-danger">Delete</a></td>
                                

                            </tr>
                               <?php
                                }
                                ?>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>