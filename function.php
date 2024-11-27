<?php
DEFINE('DB', $_SERVER['DOCUMENT_ROOT'].'/db.php');

include DB;

$conn = connect();

function paginate($table){
    $html = "<div style='overflow: auto' class='fluid-container'>";
    $html .= "<ul class='pagination'>";

    global $per_page;
    global $conn;
    global $pdf;
    global $page;

    $fetched_rows =  $conn->query("SELECT * FROM $table")->num_rows;

    $total_page = floor($fetched_rows / $per_page);

    for ($i = 0; $i <= $total_page; $i++) {
        $current_page = $i + 1;
        if($current_page == $page){
            $html .= "<li class='page-item active'><a href='?page=$current_page' class='page-link'>$current_page</a></li>";

        }else{
            $html .= "<li class='page-item'><a href='?page=$current_page' class='page-link'>$current_page</a></li>";
        }
    }
    $html .= "</ul>";
    $html .= "</div>";
    echo $html;
}


function form_alert(){
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

}

function html_header($title, $user = false){
//Display this if user is admin
    $userHTML = <<< HTML
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>$title</title>
                <link href="/assets/bootstrap.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                <script src="/assets/script.js"></script>
            <script src="/assets/jquery.min.js"></script>
            </head>
            <body style='height: 100vh; background-color: #c3a75e' class="d-flex flex-column gap-3 p-3">
                <header class='navbar p-2 rounded'>
                    <a href='/' class='navbar-brand'>
                        <img src='/images/logo.png' height=34 class='d-inline-block align-text-center'><b>200LVL CSC</b>
                    </a>
                    <button class='navbar-toggler' data-bs-target='#offnavs' data-bs-toggle='offcanvas'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    <div id='offnavs' class='offcanvas offcanvas-end'>
                        <div class='offcanvas-header p-4 text-bg-light'>
                            <h2>USER DASHBOARD</h2>
                            <button class='btn-close' data-bs-dismiss='offcanvas'></button>
                        </div>
                        <div class='offcanvas-body' tabindex='-1'>
                            <ul class='list-group mb-3'>
                                <li class='list-group-item'><a class='nav-link' href='index.php'>Home</a></li>
                            </ul>
                            <ul class='list-group mb-3'>
                                <li class='list-group-item list-group-item-action'><a class='nav-link' href='/cbt'>CBT</a></li>
                                <li class='list-group-item list-group-item-action'><a class='nav-link' href='ebook.php'>Library</a></li>
                            </ul>
                            <ul class='list-group mb-3'>
                                <li class='list-group-item list-group-item-action'><a class='nav-link' href='#'>Contributors</a></li>
                                <li class='list-group-item list-group-item-action'><a class='nav-link' href='http://wa.me/+2348132332408'>Contact</a></li>
                            </ul>
                            <ul class='list-group mb-3'>
                                <li class='list-group-item list-group-item-action'><a class='nav-link' href='#events'>Events</a></li>
                            </ul>
                            <ul class='list-group mb-3'>
                                <li class='list-group-item list-group-item-action'><a class='nav-link' href='/admin'>Login</a></li>
                            </ul>
                        </div>
                    </div>
        </header>
        HTML;
$adminHTML = <<< HTML
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>$title</title>
            <link href="/assets/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
            <script src="/assets/script.js"></script>
            <script src="/assets/jquery.min.js"></script>
        </head>
        <body style='height: 100vh; background-color: #c3a75e' class="d-flex flex-column gap-3 p-3">
            <header class='navbar p-2 rounded'>
            <a href='/' class='navbar-brand'>
                <img src='/images/logo.png' height=24 class='d-inline-block align-text-top'>200LVL CSC
            </a>

                <button class='navbar-toggler' data-bs-target='#offnavs' data-bs-toggle='offcanvas'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                <div id='offnavs' class='offcanvas offcanvas-end'>
                    <div class='offcanvas-header p-4 text-bg-light'>
                        <h2>ADMIN DASHBOARD</h2>
                        <button class='btn-close' data-bs-dismiss='offcanvas'></button>
                    </div>
                    <div class='offcanvas-body' tabindex='-1'>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item'><a class='nav-link' href='index.php'>Home</a></li>
                        </ul>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='question.php'>Questions</a></li>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='category.php'>Category</a></li>
                        </ul>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='pdf.php'>Pdf</a></li>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='user.php'>User</a></li>
                        </ul>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='event.php'>Events</a></li>
                        </ul>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='/admin/dashboard?logout'>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class='card p-4 text-bg-primary opacity-1'>
                <small>service to Humanity is the rent we pay for our stay here on earth - <i>Mohammed Ali</i></small>
            </div>

HTML;
if($user){
    echo $userHTML;
}else{
    echo $adminHTML;
}

}

function html_footer(){
    global $conn;
    $conn->close();
    $html = <<< HTML
                <footer class='text-bg-dark p-3'>
                    Want to Learn Programming? Click <a href='http://wa.me/+2348132332408'>HERE</a> to message via whatsapp so you can be added to my Telegram group where you start your journey to web development    
                </footer>
                <script>
                    //for feather icons...
                    feather.replace()
                </script>
                <script src="/assets/bootstrap.bundle.min.js"></script>
            </body>
        </html>
    HTML;
echo $html;
}



function question_form($question = '', $A = '', $B = '', $C = '', $D = '', $correct_value=''){
    global $category;
    global $change_id;
    global $conn;

    $cat_id = '';

    if($change_id){
        $query = $conn->query("SELECT question, category_id FROM questions where id=$change_id");

        list($question, $cat_id) = $query->fetch_array();

        $query = $conn->query("SELECT answer, correct, keyword FROM answers where id=$change_id");
        while(list($answer, $correct, $keyword) = $query->fetch_array()){
            switch($keyword){
            case 'A':
                $A = $answer;
                break;
            case 'B':
                $B = $answer;
                break;
            case 'C':
                $C = $answer;
                break;
            case 'D':
                $D = $answer;
                break;
            }
            if($correct == '1'){
                $correct_value = $keyword;
            }
        }
    }

    $check_correct = function($correct_value, $condition){
        return $correct_value == $condition ? 'checked': '';
    };

    $show = $change_id ? 'show' : '';

    $html = <<< HTML
        <div class='card p-3'>
            <form method='POST' id='form' class='collapse fade $show'>
                <div class="form-floating">
                    <input name='question' type="text" id='question' value='$question' class="form-control">
                    <label for='question'>Question</label>
                </div>
                <h6 class="pt-4">Answers</h6>

                <div class="d-flex flex-column gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" value="A" {$check_correct($correct_value, 'A')} required>
                        <label class="form-check-label">A.</label>
                        <input type="text" name="A" value='$A' class="form-control w-50"  required></input>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" {$check_correct($correct_value, 'B')}  value="B" required>
                        <label class="form-check-label">B.</label>
                        <input type="text" name="B" value='$B' class="form-control w-50" required></input>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" {$check_correct($correct_value, 'C')}  value="C" required>
                        <label class="form-check-label">C.</label>
                        <input type="text" name="C" value='$C' class="form-control w-50" required></input>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correct" value="D" {$check_correct($correct_value, 'D')}  required>
                        <label class="form-check-label">D.</label>
                        <input type="text" name="D" value='$D' class="form-control w-50" required></input>
                    </div>
                </div>
                <div class='d-flex justify-content-between gap-3 mt-3'>
                    <div class='input-group w-50'>
                        <label class='input-group-text'>Select Course</label>
                        <select class='form-select w-25' name="category" required>
    HTML;
    $check_category = function($id, $cat_id){return $cat_id == $id ? 'selected="selected"' : '';};
    while(list($id, $course) = $category->fetch_array()){
        $html .= "<option value='$id' {$check_category($id, $cat_id)}>$course</option>";
    }

    $html .= <<< HTML
                        </select>
                    </div>
                    <input type="submit" name="form-submit" class="btn mt-2 btn-primary d-block" value="Add Question">

                </div>
            </form>
        </div>
    HTML;
    echo $html;
}

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
        $stmt->bind_param('isis', $id, $answers, $correct_binary, $keyword);
        $keyword = $keyword[$i];
        $answers = $answers[$i];
        if($keyword == $correct){
            $correct_binary = 1;
        }else{
            $correct_binary = 0;
        }
        echo $correct_binary;


        $stmt->execute();
    }
}

?>
