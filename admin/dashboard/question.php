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
        $stmt->bind_param('isis', $id, $answers, $correct, $keyword);
        $keyword = $keyword[$i];
        $answers = $answers[$i];
        if($keyword == $correct){
            $correct = 1;
        }else{
            $correct = 0;
        }
        $stmt->execute();
    }
}

if($form_submit){
    insertQuestion();
    header('location: '.$_SERVER['PHP_SELF']);
}

$category = $conn->query("SELECT id, course FROM category");

function fetchPage(){
    global $page;
    global $per_page;
    global $conn;

    $offset = ($per_page * $page) - $per_page;
    return $conn->query("SELECT id, question FROM questions limit $per_page offset $offset");
}

//This works with page id  for use with pagination
fetchPage();

if($delete_id){
    $conn->query("DELETE FROM questions where id=$delete_id");
    $question = fetchPage();
}


if($change_id){
    $conn->query("DELETE FROM category where id=$delete_id");
}

html_header('Question Page');
form_alert();
?>

        <span class='text-white'>Click on the green button to add questions...</span>
        <button class='btn btn-success' data-bs-toggle='collapse' data-bs-target='#form'><i data-feather='plus'></i>ADD QUESTIONS</button>
        <div class='card p-3'>
            <form method='POST' id='form' class='collapse'>
                <div class="form-floating">
                    <input name='question' type="text" id='question' class="form-control">
                    <label for='question'>Question</label>
                </div>
                <h6 class="pt-4">Answers</h6>

                <div class="d-flex flex-column gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" value="A" required>
                        <label class="form-check-label">A.</label>
                        <input type="text" name="A" class="form-control w-50" required></input>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" value="B" required>
                        <label class="form-check-label">B.</label>
                        <input type="text" name="B" class="form-control w-50" required></input>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" value="C" required>
                        <label class="form-check-label">C.</label>
                        <input type="text" name="C" class="form-control w-50" required></input>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" value="D" required>
                        <label class="form-check-label">D.</label>
                        <input type="text" name="D" class="form-control w-50" required></input>
                    </div>
                </div>
                <div class='d-flex justify-content-between gap-3 mt-3'>
                    <div class='input-group w-50'>
                        <label class='input-group-text'>Select Course</label>
                        <select class='form-select w-25' name="category" required>
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
        </div>
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
            echo "<tr><td colspan='3'>No questions found.</td></tr>"; // Optional: Message when no data is found
        }
        ?>
                    </tbody>
                </table>
<?php
        paginate("questions");
        html_footer();
?>
