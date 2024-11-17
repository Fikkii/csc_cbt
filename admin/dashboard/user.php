<?php
include '../../db.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    header('location: ../index.php');
}

$conn = connect();

#total data shown perpage
$per_page = 8;

#query requests to modify data
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$delete_id = isset($_GET['delete']) ? $_GET['delete'] : '';
$change_id = isset($_GET['change']) ? $_GET['change'] : '';
$filter_id = isset($_GET['filter']) ? $_GET['filter'] : '';

$form_submit = isset($_GET['form-submit']) ? $_GET['form-submit'] : '';
$course_code = isset($_GET['course-code']) ? $_GET['course-code'] : '';
$course_unit = isset($_GET['course-unit']) ? $_GET['course-unit'] : '';

if($form_submit){
    $stmt = $conn->prepare("INSERT INTO category(course, unit) VALUES (?,?)");
    $stmt->bind_param('ss', $course_code, $course_unit);
    $user = $stmt->execute();
    header('location: '.$_SERVER['PHP_SELF']);
}

function fetchPage(){
    global $page;
    global $per_page;
    global $conn;
    
    $offset = ($per_page * $page) - $per_page;
    return $conn->query("SELECT id, nicename FROM user limit $per_page offset $offset");
}

if($page){
    $user = fetchPage();
}

if($delete_id){
    $conn->query("DELETE FROM user where id=$delete_id");
    $user = fetchPage();
}


if($change_id){
    $conn->query("DELETE FROM user where id=$delete_id");
}


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    </head>
    <body style='height: 100vh; background-color: #c3a75e' class="fluid-container d-flex flex-column gap-3 p-3 p-sm-5">
        <header class='navbar'>
            <h3>200LVL CSC</h3>
            <button class='navbar-toggler border-0'>
                <span class='navbar-toggler-icon' data-bs-toggle='offcanvas' data-bs-target='#offnav'></span>
            </button>
            <div id='offnav' class='offcanvas offcanvas-end'>
                <div class='offcanvas-header p-4 text-bg-warning'>
                    <h2>ADMIN DASHBOARD</h2>
                    <button class='btn-close' data-bs-dismiss='offcanvas'></button>
                </div>
                <div class='offcanvas-body' tabindex='-1'>
                    <ul class='navbar-nav px-2'>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='index.php'>Home</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='question.php'>questions</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='category.php'>category</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='pdf.php'>pdf</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='user.php'>user</a></li>
                    </ul>
                </div>
                <div class='mb-5 d-flex justify-content-between'>
                    <a class='btn btn-secondary'>Change Password</a>
                    <a class='btn btn-secondary'>Password</a>
                </div>
            </div>
        </header>
        <div>
<?php
//Since i perform a redirect on submission
//i check which page they come from so as to provide feedback
//if they request the page the second time

$caller = explode('/', $_SERVER['HTTP_REFERER'])[5];

if($caller == explode("/", $_SERVER['PHP_SELF'])[3]){
    $alert = <<< html
        <div class='alert alert-success alert-dismissible'>
            <span>Course Registered Successfuly...</span>
            <button class='btn-close' data-bs-dismiss='alert'></button>
        </div>
    html;
    echo $alert;
}

?>
            <h2>ADD NEW COURSE</h2>
            <form class='input-group'>
                <input name='course-code' class='form-control' placeholder='course code' required>
                <label class='input-group-text'>Unit</label>
                <select name='course-unit' required>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                    <option value='6'>6</option>
                </select>
                <input  name='form-submit'type='submit' class='form-control btn btn-success' placeholder='course code' required>
            </form>
            <br>
            <h5>COURSES IN DATABASE</h5>
            <table class="table table-hover">
                <thead>
                    <tr scope='row'>
                        <td>id</td>
                        <td colspan=4>Courses</td>
                    </tr>
                </thead>
                <tbody>
<?php
if($user->num_rows > 0){
<<<<<<< HEAD
    while(list($id, $username) = $user->fetch_array()){
        $data = <<< script
            <tr scope='row'>
                <td>$id</td>
                <td>$username</td>
=======
    while(list($id, $course) = $user->fetch_array()){
        $data = <<< script
            <tr scope='row'>
                <td>$id</td>
                <td>$course</td>
>>>>>>> d61ea2f51fa23b463ce3661987c1d1e48d59009d
                <td class='w-25'>
                        <td><a class='btn btn-warning btn-sm p-1' href='?change=$id'><i data-feather='edit'></i></a></td>
                        <td><a class='btn btn-danger btn-sm p-1' href='?delete=$id'><i data-feather='trash'></i></a></td>
                </td>
            </tr>
         script; 
        echo $data;
    }
}
?>
                </tbody>
            </table>
<ul class='pagination'>
<?php

function paginate(){
    global $per_page;
    global $conn;
    global $pdf;
    global $page;
    $fetched_rows =  $conn->query('SELECT * FROM questions')->num_rows;

    $total_page = floor($fetched_rows / $per_page);

    for ($i = 0; $i <= $total_page; $i++) {
        $current_page = $i + 1;
        if($current_page == $page){
            echo "<li class='page-item active'><a href='?page=$current_page' class='page-link'>$current_page</a></li>";

        }else{
            echo "<li class='page-item'><a href='?page=$current_page' class='page-link'>$current_page</a></li>";
        }
    }
}

paginate();
?>
</ul>


        </div>

        <script>
            //for feather icons...
            feather.replace()
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>

