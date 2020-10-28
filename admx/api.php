<?php
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 27/10/2020 - api.php
 */
include "includes/Func.php";
/////////////////////////////////
$cmd = $_GET['cmd'];
switch ($cmd) {
    case 'import':
        doImport();
        break;
    case 'add-new':
        addNewPost();
        break;
    case 'del-quote':
        deleteQuote();
        break;
    case 'go-live':
        goLive();
        break;
    case 'photo-edit':
        photoEdit();
        break;
    case 'get-daily':
        getOneQuote();
        break;
    case 'get-all':
        getAllQuotes();
        break;
    default:
        exit();
}
//get all quotes
function getAllQuotes()
{
    header("Content-Type: application/json; charset=utf-8");
    //initialize model
    $model = new Model();
    exit(json_encode(array("status" => true, "msg" => "Successful !", "data" => $model->getAllQuotesFullPath())));
}

//get today's quotes
function getOneQuote()
{
    header("Content-Type: application/json; charset=utf-8");
    //initialize model
    $model = new Model();
    exit(json_encode(array("status" => true, "msg" => "Successful !", "data" => $model->getDaily())));
}

//start functioning
function doImport()
{
    header("Content-Type: application/json; charset=utf-8");
    //initialize model
    $model = new Model();
    $file_name = $_FILES['jsonfile']['tmp_name'];
    //do global import
    $raw = file_get_contents($file_name);
    $raw = json_decode($raw, true);
    $model->fileImport($raw);
    //done
    exit(json_encode(array("message" => "Successful !", "name" => null)));
}

function addNewPost()
{
    //initialize model
    $model = new Model();
    $file_name = $_FILES['qimage']['tmp_name'];
    //check if uploaded
    if ($_FILES['qimage']['error'] !== UPLOAD_ERR_OK || !isset($file_name) || $_FILES['qimage']['size'] < 5000) {
        setAlert(array("msg" => "No valid image file selected !", "type" => "alert-primary"));
    } else {
        //insert into db
        $image = (int)array_reverse($model->getQuotes())[0]['image'];
        $image = $image + 1;
        //add image space to post array
        $_POST['image'] = $image;
        if ($model->addQuotes($_POST)) {
            setAlert(array("msg" => "Quote added successfully...<a href=''>Click to reload</a>", "type" => "alert-success"));
            //move file now
            move_uploaded_file($file_name, "../images/" . $image . ".jpg");
        } else {
            setAlert(array("msg" => "Unable to add new quote, try again...", "type" => "alert-primary"));
        }
    }
    //load page
    header("location: dash");
}

function photoEdit()
{
    $file_name = $_FILES['qimage']['tmp_name'];
    //check if uploaded
    if ($_FILES['qimage']['error'] !== UPLOAD_ERR_OK || !isset($file_name) || $_FILES['qimage']['size'] < 5000) {
        setAlert(array("msg" => "No valid image file selected !", "type" => "alert-primary"));
    } else {
        move_uploaded_file($file_name, "../images/" . $_GET['target'] . ".jpg");
        setAlert(array("msg" => "Quote image changed successfully...<a href=''>Click to reload</a>", "type" => "alert-success"));
    }
    //load page
    //header("location: dash");
}

function deleteQuote()
{
    if ($_GET['ssk'] !== 'c7bbde24b87dfe0e201ec95ffc504dc6900ac5c4') {
        header("location: dash");
        return;
    }
    $model = new Model();
    if ($model->delQuote($_GET)) {
        setAlert(array("msg" => "Quote deleted <a href='' class='btn btn-sm text-white'> Click to reload</a>", "type" => "alert-success"));
        //move image here
        unlink("../images/" . $_GET['target'] . ".jpg");
    } else {
        setAlert(array("msg" => "Unable to delete this post.", "type" => "alert-primary"));
    }
    header("location: dash");
}

function goLive()
{
    if ($_GET['ssk'] !== 'c7bbde24b87dfe0e201ec95ffc504dc6900ac5c4') {
        header("location: dash");
        return;
    }
    $model = new Model();
    if ($model->goLive($_GET)) {
        setAlert(array("msg" => "Quote set to live <a href='' class='btn btn-sm text-white'> Click to reload</a>", "type" => "alert-success"));
    } else {
        setAlert(array("msg" => "Unable to go live.", "type" => "alert-primary"));
    }
    header("location: dash");
}