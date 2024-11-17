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

$form_submit = isset($_POST['form-submit']) ? $_POST['form-submit'] : '';
$event = isset($_POST['event']) ? $_POST['event'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';

if($form_submit){
    $stmt = $conn->prepare("INSERT INTO event(event, time, location, date) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $event, $time, $location, $date);
    $event = $stmt->execute();
    header('location: '.$_SERVER['PHP_SELF']);
}

function fetchPage(){
    global $page;
    global $per_page;
    global $conn;
    
    $offset = ($per_page * $page) - $per_page;
    return $conn->query("SELECT id, event, time FROM event limit $per_page offset $offset");
}

if($page){
    $event = fetchPage();
}

if($delete_id){
    $conn->query("DELETE FROM event where id=$delete_id");
    $event = fetchPage();
}


if($change_id){
    $conn->query("DELETE FROM event where id=$delete_id");
}

html_header('CBT Category');
?>
    <h2>ADD NEW EVENT</h2>
    <div class='card p-3'>
        <form method='POST' class='d-flex flex-column gap-3'>
            <input name='event' class='form-control' placeholder='Enter event' required>
            <input name='location' class='form-control' placeholder='Enter Location' required>
            <input type='time' name='time' class='form-control' placeholder='Enter time' required>
            <input type='date' name='date' class='form-control' placeholder='Enter event' required>
            <input  name='form-submit'type='submit' class='form-control btn btn-success' placeholder='course code' required>
        </form>
    </div>
    <br>
    <h5>EVENTS IN DATABASE</h5>
    <div class='card p-3'>
        <table class="table table-hover">
            <thead>
                <tr scope='row'>
                    <td>Id</td>
                    <td>Events</td>
                    <td>Date</td>
                </tr>
            </thead>
            <tbody>
<?php
if($event->num_rows > 0){
while(list($id, $title, $time) = $event->fetch_array()){
$data = <<< script
        <tr scope='row'>
            <td>$id</td>
            <td>$title</td>
            <td>$time</td>
            <td class='w-25'>
                    <td><a class='btn btn-warning btn-sm p-1' href='?change=$id'><i data-feather='edit'></i></a></td>
                    <td><a class='btn btn-danger btn-sm p-1' href='?delete=$id'><i data-feather='trash'></i></a></td>
            </td>
        </tr>
     script; 
    echo $data;
}
} else {
echo "<tr><td colspan='3'>No Events found.</td></tr>"; // Optional: Message when no data is found
}
?>
            </tbody>
        </table>
<?php
paginate('category');
html_footer();
?>
