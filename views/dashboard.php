<?php
// start the session
session_start();

require "../classes/user.php"; //include the user class

// 1 create a new user
$user_obj = new User;

// 2 call the method on the user object
// this method retrives all user information from the database and store it in the  all users
$all_users = $user_obj->getAllUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
                <form action="../actions/logout.php" method="post" class="d-flex ms-2">
                    <button type="submit" class="text-danger bg-transparent border-0"></button>
                </form>
            </div>
        </div>
    </nav>

    <main class="row justify-content-center gx-0">
        <div class="col-6">
            <h2 class="text-center">USER LIST</h2>

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th><!-- For photo --></th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>User Name</th>
                        <th><!-- for action buttons --></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($user = $all_users->fetch_assoc()){
                    ?>

                    <tr>
                        <td>
                            <?php
                                if($user['photo']){
                            ?>
                                <img src="../assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto dashboard-photo">
                                <?php
                                }else{
                                ?>
                                    <i class="fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>
                                <?php
                                }
                                ?>
                        </td>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['first_name'] ?></td>
                        <td><?= $user['last_name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td>
                            <?php
                            if($_SESSION['id'] == $user['id']){
                            ?>

                            <a href="edit-user.php" class="btn btn-outline-warning" title="edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <a href="delete-user.php" class="btn btn-outline-danger" title="delete">
                            <i class="fa-regular fa-trash-can"></i>
                            </a>
                            <?php
                            }
                            ?>
                            </td>
                            </tr>
                            <?php
                            }
                            ?>
                </tbody>
            </table>
        </div>
    </main>
    
</body>
</html>