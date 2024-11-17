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
    $category = $stmt->execute();
    header('location: '.$_SERVER['PHP_SELF']);
}

function fetchPage(){
    global $page;
    global $per_page;
    global $conn;
    
    $offset = ($per_page * $page) - $per_page;
    return $conn->query("SELECT id, course FROM category limit $per_page offset $offset");
}

if($page){
    $category = fetchPage();
}

if($delete_id){
    $conn->query("DELETE FROM category where id=$delete_id");
    $category = fetchPage();
}


if($change_id){
    $conn->query("DELETE FROM category where id=$delete_id");
}

html_header('CBT Category');
form_alert();
?>
    <h2>ADD NEW COURSE</h2>
    <div class='card p-3'>
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
    </div>
    <br>
    <h5>COURSES IN DATABASE</h5>
    <div class='card p-3'>
        <table class="table table-hover">
            <thead>
                <tr scope='row'>
                    <td>id</td>
                    <td colspan=4>Courses</td>
                </tr>
            </thead>
            <tbody>
<?php
if($category->num_rows > 0){
while(list($id, $course) = $category->fetch_array()){
$data = <<< script
        <tr scope='row'>
            <td>$id</td>
            <td>$course</td>
            <td class='w-25'>
                    <td><a class='btn btn-warning btn-sm p-1' href='?change=$id'><i data-feather='edit'></i></a></td>
                    <td><a class='btn btn-danger btn-sm p-1' href='?delete=$id'><i data-feather='trash'></i></a></td>
            </td>
        </tr>
     script; 
    echo $data;
}
} else {
echo "<tr><td colspan='3'>No categories found.</td></tr>"; // Optional: Message when no data is found
}
?>
            </tbody>
        </table>
<?php
paginate('category');
html_footer();
?>
