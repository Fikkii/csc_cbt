<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body style='height: 100vh; background-color: #c3a75e' class="d-flex justify-content-center align-items-center">
        <form method='post' class="bg-body-tertiary text-black d-flex flex-column gap-2 align-items-center rounded p-5">
            <img src="../images/logo.png" height="65" alt="Company's Logo"/>
            <h6>Please Sign in To continue...</h6>
<?php
include '../db.php';
$form = isset($_POST['submit']) ? true : false;

$conn = connect();

if($form){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedpassword = sha1($password);

    $result = $conn->query('SELECT password FROM user WHERE nicename="'.$username.'"');

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['password'] === $hashedpassword){
                session_start();
                $_SESSION['username'] = $username;
                header('location:  ./dashboard');
            }
        }
    }else{
        $alert = "<div class='alert alert-danger d-flex align-items-center p-1 gap-1'>";
        $alert .= "<span>invalid Credential</span>";
        $alert .= "<button class='btn-close p-1 btn-sm' data-bs-dismiss='alert'></button>";
        $alert .= "</div>";
        echo $alert;
    }

}
?>
            <label>username<input class="form-control" type="text" name="username" id="username" required/></label>
            <label>password<input class="form-control" type="password" name="password" id="password"/></label>
            <input type="submit" name="submit" class="btn btn-primary ms-auto" required>

        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>

