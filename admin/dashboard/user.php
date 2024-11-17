<?php
include $_SERVER['DOCUMENT_ROOT'].'/function.php';

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

html_header('User Section');
?>
        <div>
            <h5>ADMINISTRATORS</h5>
            <div class='card p-3'>
                <table class="table table-hover">
                    <thead>
                        <tr scope='row'>
                            <td>Id</td>
                            <td colspan=4>Username</td>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    if($user->num_rows > 0){
        while(list($id, $username) = $user->fetch_array()){
            $data = <<< script
                <tr scope='row'>
                    <td>$id</td>
                    <td>$username</td>
                    <td class='w-25'>
                    </td>
                </tr>
             script; 
            echo $data;
        }
    }
    ?>
                    </tbody>
                </table>
<?php
paginate('user');
html_footer();
?>
