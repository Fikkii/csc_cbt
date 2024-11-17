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

//PDF upload functionality discontinued at the moment
//
//$form_submit = isset($_POST['form-submit']) ? $_POST['form-submit'] : '';
//$pdf_file = isset($_FILES['pdffile']) ? $_FILES['pdffile'] : '';
//
//if($form_submit){
//    $stmt = $conn->prepare("INSERT INTO category(course, unit) VALUES (?,?)");
//    $stmt->bind_param('ss', $course_code, $course_unit);
//    $pdf = $stmt->execute();
//    header('location: '.$_SERVER['PHP_SELF']);
//}

function uploadPDF(){
    global $pdf_file;
    $target_dir = "./trial/";
    $target_file = $target_dir.basename($pdf_file['name']);
    if(is_uploaded_file($pdf_file['tmp_name'])){
        move_uploaded_file($pdf_file['tmp_name'], $target_file);
        // instantiate Imagick 
        $im = new Imagick();

        $im->setResolution(300,300);
        $im->readimage($_SERVER['DOCUMENT_ROOT'].'/admin/dashboard/english.pdf'); 
        $im->setImageFormat('jpeg');    
        $im->writeImage('thumb.jpg'); 
        $im->clear(); 
        $im->destroy();
    }
}

function fetchPage(){
    global $page;
    global $per_page;
    global $conn;

    $offset = ($per_page * $page) - $per_page;
    return $conn->query("SELECT id, link FROM pdf limit $per_page offset $offset");
}

$pdf = fetchPage();

if($delete_id){
    $conn->query("DELETE FROM category where id=$delete_id");
    $pdf = fetchPage();
}


if($change_id){
    $conn->query("DELETE FROM category where id=$delete_id");
}

html_header('PDF Page')
?>
<b class='text-danger'>This section has currently been discontinued, contact webmaster for more info</b>
<div class='card p-3'>
    <form onsubmit='return false' action='<?php $_SERVER['PHP_SELF'] ?>' method='POST' enctype='multipart/form-data' class='input-group'>
            <input name='pdffile' type='file' class='form-control' placeholder='course code' required disabled>
            <input  name='form-submit' type='submit' class='form-control btn btn-success' required disabled>
        </form>
    </div>

<div class='card p-3 mt-5'>
    <h5>PDFs IN DATABASE</h5>
    <table class="table table-hover">
        <thead>
            <tr scope='row'>
                <td>id</td>
                <td colspan=4>Name</td>
            </tr>
        </thead>
        <tbody>

<?php
if($pdf->num_rows > 0){
    while(list($id, $link) = $pdf->fetch_array()){
        $filename = explode('/', $link)[2];
        $data = <<< script
            <tr scope='row'>
                <td>$id</td>
                <td>$filename</td>
            </tr>
         script; 
        echo $data;
    }
}
?>
                </tbody>
            </table>


<?php
paginate('pdf');
html_footer();
?>

