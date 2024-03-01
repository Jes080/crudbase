<?php

//show php error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();

//GET
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    try {
        if ($id != null) {
            if ($objUser->delete($id)) {
                $objUser->redirect('index.php?deleted'); // Redirect to index.php after deletion
            }
        } 
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Head metas, css and title -->
        <?php require_once 'includes/head.php';?>
    </head>
    <body>
        <!--Header banner-->
        <?php require_once 'includes/header.php';?>
        <div class="container_fluid">
            <div class="row">
                <!--sidebar menu-->
                <?php require_once 'includes/sidebar.php';?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <h1 style="margin-top: 10px">DataTable</h1>
                    <?php
                    if(isset($_GET['updated'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>User updated with success!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        <span aria-hidden="true"> &times; </span>
                        </button>
                        </div>';
                    }else if(isset($_GET['deleted'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>User deleted with success!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        <span aria-hidden="true"> &times; </span>
                        </button>
                        </div>';
                    }else if(isset($_GET['inserted'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>User inserted with success!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        <span aria-hidden="true"> &times; </span>
                        </button>
                        </div>';
                    }else if(isset($_GET['error'])){
                        echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                        <strong>Database Error! Something went wrong with your action.Try again.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        <span aria-hidden="true"> &times; </span>
                        </button>
                        </div>';
                    }
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php
                            $query  = "SELECT * FROM crud_users";
                            $stmt   = $objUser->runQuery($query);
                            $stmt->execute();
                            ?>
                            <tbody>
                                <?php
                                if ($stmt->rowCount() > 0) {
                                    while ($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?php print($rowUser['id']); ?></td>
                                        <td>
                                            <a href="form.php?edit_id=<?php print($rowUser['id']); ?>">
                                                <?php print($rowUser['name']); ?>
                                            </a>
                                        </td>
                                    <td><?php print($rowUser['email']); ?></td>
                                     <td>
                                        <a class="confirmation" href="index.php?delete_id=<?php print($rowUser['id']); ?>">
                                            <span data-feather="trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
        <!-- footer scripts and function-->
        <?php require_once 'includes/footer.php';?>

        <!--custom scripts-->
        <script>
            //Jquery confirmation
            $('.confirmation').on('click', function(){
                return confirm('Are you sure you want to delete this user?');
            });
        </script>
    </body>
</html>