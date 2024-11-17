<?php
include 'function.php';
$course = isset($_GET['course']) ? $_GET['course'] : '';

if ($course){
    session_start();
    $_SESSION['course'] = $course;
    header("location: cbt");
}

html_header('Home', true);
?>

<!doctype html>
    <body style='height: 100vh'>
        <div class='row text-bg-light mx-2 border rounded'>
            <div class='h6 px-4 py-2'>Personal Development</div>
            <a href='/cbt' class='d-flex col-4 flex-column align-items-center p-3'><i data-feather='file-plus'></i><small>CBT</small></a>
            <a href='/ebook.php' class='d-flex col-4 flex-column align-items-center p-3'><i data-feather='tool'></i><small>LIBRARY</small></a>
            <a href='https://wa.me/+2348132332408' class='d-flex col-4 flex-column align-items-center p-3'><i data-feather='file-text'></i><small>CONNECT</small></a>
        </div>


<div class='card'>
    <div class='h6 px-4 py-2'>Services</div>
    <div class='row p-3 py-1 g-2'>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>Past Questions</b></div>
                    <a href="/cbt" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>Join Whats-group</b></div>
                    <a href="http://wa.me/+2348132332408" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>Upcoming Events</b></div>
                    <a href="#events" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>Our Contributors</b></div>
                    <a href="#contributor" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id='events' class='card p-3'>
    <div class='h6'>Upcoming Events</div>
    <div class='row p-3 g-3'>
<?php
$event = $conn->query('SELECT event, location, date, time FROM event');

if($event->num_rows > 0){
    while(list($name, $location, $date, $time) = $event->fetch_array()){
        $html = <<< HTML
            <div class='card col col-sm-6'>
                <img class='img-card-top' height='60px' src='/images/map.png' alt='location map'>
                <div class='card-header'>
                    <h5 class='card-title'>$name</h5>
                    <div>
                        <div>Date: $date</div>
                        <div>Time: $time</div>
                        <span class='badge ms-1 text-bg-success'>$location</span>
                    </div>
                </div>
            </div>
        HTML;
        echo $html;
    }

}
?>
    </div>
</div>
        <div style='background-color: #c9b75e' class="card m-3 text-white h-50 d-flex justify-content-center align-items-center gap-2 flex-column text-center p-3"> 
            <a href="./admin" class="align-self-end btn border border-3">
                <i data-feather='user'></i>
            </a>
            <div class="d-flex">
                <img src="./images/logo.png" height="65" alt="">
                <div class="text-start border-bottom">
                    <h5>200LVL</h5>
                    <h5>COMPUTER SCIENCE</h5>
                </div>

            </div>
            <div class="d-flex gap-2">
                <i data-feather='facebook'></i>
                <i data-feather='instagram'></i>
                <i data-feather='twitter'></i>
                <i data-feather='youtube'></i>
                <i data-feather='whatsapp'></i>

            </div>
            <b class="mt-4">CBT IS NOT A JOKE, START PRACTISING</b><button class="btn dropdown-toggle" data-bs-toggle='collapse' data-bs-target='#announcement'>Learn More</button>
            <div id="announcement" class="collapse">
                <p class='px-5'>If you notice any incosistency in the past questions or will like to add to it, message us @<a href="wa.me/+2348132332408" target="_blank">whatsapp</a> and stand a chance to be a CONTRIBUTOR</p>
            </div>
        </div>

        <div class="container">
            <div class="row p-4 g-2">
            </div>
        </div>
<?php
html_footer();
?>
