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

function html_header($title){
$html = <<< HTML
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Bootstrap demo</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        </head>
        <body style='height: 100vh; background-color: #c3a75e' class="d-flex flex-column gap-3 p-3">
            <header class='navbar'>
                <h3>200LVL CSC</h3>
                <div>
                    <i data-feather='settings'></i>

                    <button class='navbar-toggler border-0'>
                        <span class='navbar-toggler-icon' data-bs-toggle='offcanvas' data-bs-target='#offnav'></span>
                    </button>
                <div>
                <div id='offnav' class='offcanvas offcanvas-end'>
                    <div class='offcanvas-header p-4 text-bg-light'>
                        <h2>ADMIN DASHBOARD</h2>
                        <button class='btn-close' data-bs-dismiss='offcanvas'></button>
                    </div>
                    <div class='offcanvas-body' tabindex='-1'>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item'><a class='nav-link' href='index.php'>Home</a></li>
                        </ul>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='question.php'>questions</a></li>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='category.php'>category</a></li>
                        </ul>
                        <ul class='list-group mb-3'>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='pdf.php'>pdf</a></li>
                            <li class='list-group-item list-group-item-action'><a class='nav-link' href='user.php'>user</a></li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class='card p-4 text-bg-primary opacity-1'>
                <h2>Welcome</h2>
                <small>service to Humanity is the rent we pay for our stay here on earth - <i>Mohammed Ali</i></small>
            </div>

HTML;
echo $html;

}

function html_footer(){
    $html = <<< HTML
                <script>
                    //for feather icons...
                    feather.replace()
                </script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
            </body>
        </html>
    HTML;
echo $html;
}


?>
