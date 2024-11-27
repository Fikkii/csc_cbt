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

if($form_submit){
    if($change_id){
        $conn->query("DELETE FROM questions WHERE id=$change_id");
    }
    insertQuestion();
    header('location: ./question.php');
}

$category = $conn->query("SELECT id, course FROM category");

function fetchPage(){
    global $page;
    global $per_page;
    global $conn;

    $offset = ($per_page * $page) - $per_page;
    return $conn->query("SELECT id, question FROM questions ORDER BY id DESC limit $per_page offset $offset");
}

if($delete_id){
    $conn->query("DELETE FROM questions where id=$delete_id");
    $result = fetchPage();
}


html_header('Question Page');
?>

        <span class='text-white'>Click on the green button to add questions...</span>
        <button class='btn btn-success' data-bs-toggle='collapse' data-bs-target='#form'><i data-feather='plus'></i>ADD QUESTIONS</button>
        <?php question_form() ?>
        <h5>QUESTIONS IN DATABASE</h5>
        <div class='card p-3'>
                <table class="table table-hover">
                    <thead>
                        <tr scope='row'>
                            <td>Id</td>
                            <td colspan=4>Questions</td>
                        </tr>
                    </thead>
                    <tbody>
        <?php
        $result = fetchPage();
        if($result->num_rows > 0){
            while(list($id, $course) = $result->fetch_array()){
                $data = <<<script
                    <tr scope='row'>
                        <td>$id</td>
                        <td>$course</td>
                        <td class='w-25'>
                            <a class='btn btn-warning btn-sm p-1' href='?change=$id'><i data-feather='edit'></i></a>
                            <a class='btn btn-danger btn-sm p-1' href='?delete=$id'><i data-feather='trash'></i></a>
                        </td>
                    </tr>
                script; 
                echo $data;
            }
        } else {
            echo "<tr><td colspan='3'>No questions found.</td></tr>"; // Optional: Message when no data is found
        }
        ?>
                    </tbody>
                </table>
<?php
        paginate("questions");
        html_footer();
?>
