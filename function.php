<?php
DEFINE('DB', $_SERVER['DOCUMENT_ROOT'].'/db.php');

include DB;

$conn = connect();

function paginate($table){
    $html = "<ul class='pagination'>";

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
            </head>
            <body style='height: 100vh; background-color: #c3a75e' class="d-flex flex-column gap-3 p-3">
                <header class='navbar p-2 rounded'>
                    <a href='/' class='navbar-brand'>
                        <img src='images/logo.png' height=34 class='d-inline-block align-text-center'><b>200LVL CSC</b>
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
        </head>
        <body style='height: 100vh; background-color: #c3a75e' class="d-flex flex-column gap-3 p-3">
            <header class='navbar p-2 rounded'>
            <a href='/' class='navbar-brand'>
                <img src='images/logo.png' height=24 class='d-inline-block align-text-top'>200LVL CSC
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


?>
