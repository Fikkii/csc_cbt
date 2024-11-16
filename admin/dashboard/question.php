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

$form_submit = isset($_POST['form-submit']) ? $_POST['form-submit'] : '';

function insertQuestion(){
    global $conn;
    $question = isset($_POST['question']) ? $_POST['question'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $A = isset($_POST['A']) ? $_POST['A'] : '';
    $B = isset($_POST['B']) ? $_POST['B'] : '';
    $C = isset($_POST['C']) ? $_POST['C'] : '';
    $D = isset($_POST['D']) ? $_POST['D'] : '';
    $correct = isset($_POST['correct']) ? $_POST['correct'] : '';

    //adding questions simultaneuosly with answers
    $stmt = $conn->prepare("INSERT INTO questions(question, category_id) VALUES (?,?)");
    $stmt->bind_param('si', $question, $category);
    $stmt->execute();

    //question id so as to link the table using foreign key restriction
    $id = $stmt->insert_id;

    //adding answers simultaneuosly with questions
    for($i=0; $i < 4; $i++){
        $keyword = ['A', 'B', 'C', 'D'];
        $answers = [$A, $B, $C, $D];
        $stmt = $conn->prepare("INSERT INTO answers(id, answer, correct, keyword) VALUES (?,?,?,?)");
        $stmt->bind_param('isis', $id, $A, $correct, $keyword);
        $keyword = $keyword[$i];
        $answers = $answers[$i];
        $stmt->execute();
    }
}

if($form_submit){
    insertQuestion();
}

$category = $conn->query("SELECT id, course FROM category");

function fetchPage(){
    global $page;
    global $per_page;
    global $conn;

    $offset = ($per_page * $page) - $per_page;
    return $conn->query("SELECT id, question FROM questions limit $per_page offset $offset");
}

if($page){
    $question = fetchPage();
}

if($delete_id){
    $conn->query("DELETE FROM questions where id=$delete_id");
    $question = fetchPage();
}


if($change_id){
    $conn->query("DELETE FROM category where id=$delete_id");
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
    <body style='height: 100vh; background-color: #c3a75e' class="d-flex flex-column gap-3 p-5">
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
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='question.php'>questions</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='user.php'>user</a></li>
                    </ul>
                </div>
                <div class='mb-5 d-flex justify-content-between'>
                    <a class='btn btn-secondary'>Change Password</a>
                    <a class='btn btn-secondary'>Password</a>
                </div>
            </div>
        </header>

        <button class='btn btn-success' data-bs-toggle='collapse' data-bs-target='#form'>ADD QUESTIONS</button>
        <form method='POST' id='form' class='collapse'>
            <div class="form-floating">
                <input name='question' type="text" id='question' class="form-control">
                <label for='question'>Question</label>
            </div>
            <h6 class="pt-4">Answers</h6>

            <div class="d-flex flex-column gap-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="1">
                    <label class="form-check-label">A.</label>
                    <input type="text" name="A" class="form-control w-50"></input>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="1">
                    <label class="form-check-label">B.</label>
                    <input type="text" name="B" class="form-control w-50"></input>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="1">
                    <label class="form-check-label">C.</label>
                    <input type="text" name="C" class="form-control w-50"></input>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="1">
                    <label class="form-check-label">D.</label>
                    <input type="text" name="D" class="form-control w-50"></input>
                </div>
            </div>
            <div class='d-flex justify-content-between gap-3 mt-3'>
                <div class='input-group w-50'>
                    <label class='input-group-text'>Select Course</label>
                    <select class='form-select w-25' name="category">
<?php
while(list($id, $course) = $category->fetch_array()){
    echo "<option value='$id'>$course</option>";
}
?>
                    </select>
                </div>
                <input type="submit" name="form-submit" class="btn mt-2 btn-primary d-block" value="Add Question">

            </div>
        </form>
        <h5>QUESTIONS IN DATABASE</h5>
        <table class="table table-hover">
            <thead>
                <tr scope='row'>
                    <td>Id</td>
                    <td colspan=4>Questions</td>
                </tr>
            </thead>
            <tbody>
<?php
$question = fetchPage();
if($question->num_rows > 0){
    while(list($id, $course) = $question->fetch_array()){
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
    echo "<tr><td colspan='3'>No courses found.</td></tr>"; // Optional: Message when no data is found
}
?>
            </tbody>
        </table>
<ul class='pagination'>
<?php

function paginate(){
global $per_page;
global $question;
$fetched_rows =  $question->num_rows;

$total_page = floor($fetched_rows / $per_page);

for ($i = 0; $i <= $total_page; $i++) {
    $current_page = $i + 1;
    echo "<li class='page-item'><a href='?page=$current_page' class='page-link'>$current_page</a></li>";
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

