<?php
/**
 * Created by RSC BYTE LTD.
 * Author: Revelation A.F
 * Date: 27/10/2020 - Dash.php
 */
include "includes/Func.php";
restrictedZone();
$model = new Model();
$quotes = $model->getQuotes();
//export mode
if ($_GET['cmd'] === 'export') {
    //do export
    $model->goExport();
    header("location: dash");
}
//do page session
$_SESSION['csr'] = sha1(time());
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Daily Notifications">
    <meta name="author" content="Revelation A.F">
    <link rel="shortcut icon" href="assets/img/correct-ellington.jpg"/>

    <!-- Title -->
    <title>Ellington - Dashboard</title>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Icomoon Font Icons css -->
    <link rel="stylesheet" href="assets/fonts/style.css">
    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/main.css">


    <!-- DateRange css -->
    <link rel="stylesheet" href="assets/vendor/daterange/daterange.css"/>

    <!-- Datepicker css -->
    <link rel="stylesheet" href="assets/vendor/datepicker/css/classic.css"/>
    <link rel="stylesheet" href="assets/vendor/datepicker/css/classic.date.css"/>

</head>

<body>

<!-- Page content start  -->
<div class="page-content overflow-hidden">

    <!-- Page header start -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Ellington</li>
            <li class="breadcrumb-item active">App Feeder</li>
        </ol>

        <ul class="app-actions">
            <li>
                <a href="#" id="reportrange">
                    <span class="range-text"></span>
                    <i class="icon-chevron-down"></i>
                </a>
            </li>
            <li>
                <a href="#" onclick="if (confirm('Really want to logout ?')){ window.location.href='logout'}">
                    <i class="icon-log-out"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- Page header end -->

    <!-- Main container start -->
    <div class="main-container" id="app">
        <?php
        flashAlert();
        ?>
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="documents-section">

                    <!-- Row start -->
                    <div class="row no-gutters">
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-4">

                            <div class="docs-type-container">
                                <div class="mt-5"></div>

                                <div class="docTypeContainerScroll">
                                    <div class="docs-block">
                                        <h5>Quick Links</h5>
                                        <div class="doc-labels">
                                            <a href="" class="active">
                                                <i class="icon-receipt"></i> Ellington App
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#importNewJson">
                                                <i class="icon-receipt"></i> Import JSON
                                            </a>
                                            <a target="_blank"
                                               href="export?cmd=export&ssk=<?php echo @$_SESSION['csr']; ?>">
                                                <i class="icon-export"></i> Export JSON (Backup)
                                            </a>
                                        </div>
                                        <?php $item = $model->getDaily() ?>
                                        <div class="card text-center overflow-hidden">
                                            <div class="card-body">
                                                <img class="m-3"
                                                     src="https://ellingtonelectric.com/api/reedax/images/<?php echo $item['image'] ?>.jpg"
                                                     alt="Card image cap" width="80px" height="80px">
                                                <h5 class="card-title"><?php echo $item['author']; ?></h5>
                                                <p class="card-text"
                                                   style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $item['quote']; ?></p>
                                                <!--                                                                <p class="card-text">-->
                                                <!--                                                                    <small class="text-muted">Last updated 3 mins ago-->
                                                <!--                                                                    </small>-->
                                                <!--                                                                </p>-->
                                                <p>
                                                    <button onclick="photoEdit(<?php echo $item['image'] ?>)"
                                                            type="button" class="btn btn-primary"><i
                                                                class="icon-pencil"></i> Edit
                                                    </button>
                                                    <?php if ((int)$item['status'] === 0) { ?>
                                                        <button onclick="if (confirm('Make this quote go live ?')){ window.location.href='api?cmd=go-live&target=<?php echo $item['image'] ?>&ssk=c7bbde24b87dfe0e201ec95ffc504dc6900ac5c4'}"
                                                                type="button" class="btn btn-success"><i
                                                                    class="<?php echo((int)$item['status'] === 0 ? 'icon-timer' : 'icon-check') ?>"></i>
                                                            Go Live
                                                        </button>
                                                    <?php } else { ?>
                                                        <button disabled="disabled" type="button"
                                                                class="btn btn-success"><i
                                                                    class="<?php echo((int)$item['status'] === 0 ? 'icon-timer' : 'icon-check') ?>"></i>
                                                            Live Set
                                                        </button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php ?>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="modal fade" id="importNewJson" tabindex="-1" role="dialog"
                             aria-labelledby="importNewJson" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importNewJson">Import JSON File</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row gutters">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="docTitle">Import Label</label>
                                                    <input type="text" class="form-control" id="docTitle"
                                                           placeholder="Optional...">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="dovType">Document JSON {{status}}</label>
                                                    <input name="jsonfile" type="file" class="form-control"
                                                           id="jsonFile"
                                                           placeholder="File JSON">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer custom">
                                        <div class="left-side">
                                            <button type="button" class="btn btn-link danger btn-block"
                                                    data-dismiss="modal">Cancel
                                            </button>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="right-side">
                                            <button onclick="startUpload()" type="button"
                                                    class="btn btn-link success btn-block">
                                                Start Import
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-8">

                            <div class="documents-container">

                                <div class="modal fade" id="addNewDocument" tabindex="-1" role="dialog"
                                     aria-labelledby="addNewDocumentLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNewDocumentLabel">Add New Quote</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmQuote" class="row gutters" enctype="multipart/form-data"
                                                      method="post" action="api?cmd=add-new">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="docTitle">Quote Author</label>
                                                            <input name="author" type="text" class="form-control"
                                                                   id="docTitle"
                                                                   placeholder="Quote Author" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="dovType">Quote Image</label>
                                                            <input accept="image/*" name="qimage" type="file"
                                                                   class="form-control"
                                                                   id="dovType">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group mb-0">
                                                            <label for="docDetails">Quote Body</label>
                                                            <textarea name="quote" class="form-control"
                                                                      id="docDetails" required="required"></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer custom">
                                                <div class="left-side">
                                                    <button type="button" class="btn btn-link danger btn-block"
                                                            data-dismiss="modal">Cancel
                                                    </button>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="right-side">
                                                    <button onclick="document.getElementById('frmQuote').submit()"
                                                            type="button" class="btn btn-link success btn-block">
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="documents-header">
                                    <h3><?php echo count($quotes); ?> Quote(s) and <?php echo number_format(count(scandir("../images"))-2)?> local images file(s)<span class="date"
                                                                                     id="todays-date"></span></h3>
                                    <button class="btn btn-primary btn-lg" data-toggle="modal"
                                            data-target="#addNewDocument">Add New Quote
                                    </button>
                                </div>
                                <div class="documentsContainerScroll">
                                    <div class="documents-body">
                                        <!-- Row start -->
                                        <div class="row gutters">
                                            <input name="qimage" accept="image/*" type="file" id="tmp-image"
                                                   style="display: none;">
                                            <?php
                                            foreach (array_reverse($quotes) as $key => $item) {
                                                ?>
                                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                    <div class="card">
                                                        <img class="card-img-top"
                                                             src="https://ellingtonelectric.com/api/reedax/images/<?php echo $item['image'] ?>.jpg"
                                                             alt="Card image cap">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo $item['author']; ?></h5>
                                                            <p class="card-text"
                                                               style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $item['quote']; ?></p>
                                                            <!--                                                                <p class="card-text">-->
                                                            <!--                                                                    <small class="text-muted">Last updated 3 mins ago-->
                                                            <!--                                                                    </small>-->
                                                            <!--                                                                </p>-->
                                                            <p>
                                                                <button onclick="photoEdit(<?php echo $item['image'] ?>)"
                                                                        type="button" class="btn btn-primary"><i
                                                                            class="icon-pencil"></i> Edit
                                                                </button>
                                                                <button onclick="if (confirm('Delete this quote ?')){ window.location.href='api?cmd=del-quote&target=<?php echo $item['image'] ?>&ssk=c7bbde24b87dfe0e201ec95ffc504dc6900ac5c4'}"
                                                                        type="button" class="btn btn-primary"><i
                                                                            class="icon-delete"></i></button>
                                                                <?php if ((int)$item['status'] === 0) { ?>
                                                                    <button onclick="if (confirm('Make this quote go live ?')){ window.location.href='api?cmd=go-live&target=<?php echo $item['image'] ?>&ssk=c7bbde24b87dfe0e201ec95ffc504dc6900ac5c4'}"
                                                                            type="button" class="btn btn-success"><i
                                                                                class="<?php echo((int)$item['status'] === 0 ? 'icon-timer' : 'icon-check') ?>"></i>
                                                                        Go Live
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <button disabled="disabled" type="button"
                                                                            class="btn btn-success"><i
                                                                                class="<?php echo((int)$item['status'] === 0 ? 'icon-timer' : 'icon-check') ?>"></i>
                                                                        Live Set
                                                                    </button>
                                                                <?php } ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <!-- Row end -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Row end -->

                </div>
            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- Main container end -->

</div>
<!-- Page content end -->

<!-- Required jQuery first, then Bootstrap Bundle JS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/moment.js"></script>

<!-- Slimscroll JS -->
<script src="assets/vendor/slimscroll/slimscroll.min.js"></script>
<script src="assets/vendor/slimscroll/custom-scrollbar.js"></script>

<!-- Daterange -->
<script src="assets/vendor/daterange/daterange.js"></script>
<script src="assets/vendor/daterange/custom-daterange.js"></script>

<!-- Datepickers -->
<script src="assets/vendor/datepicker/js/picker.js"></script>
<script src="assets/vendor/datepicker/js/picker.date.js"></script>
<script src="assets/vendor/datepicker/js/custom-picker.js"></script>


<!-- Main JS -->
<script src="assets/js/main.js"></script>
<script src="simpleUpload.min.js" type="text/javascript"></script>
<script src="vue.min.js" type="text/javascript"></script>
<script>
    var vue = new Vue({
        el: '#app',
        data: {
            quotes: [],
            status: ''
        }
    });
    //do photo edit
    function photoEdit(id) {
        if (id === '') {
            return;
        }
        $('#tmp-image').trigger('click');
        $('#tmp-image').change(function () {
            $(this).simpleUpload("api?cmd=photo-edit&target=" + id, {

                start: function (file) {
                    //upload started
                    console.log("upload started");
                },

                progress: function (progress) {
                    //received progress
                    console.log("upload progress: " + Math.round(progress) + "%");
                },

                success: function (data) {
                    //upload successful
                    console.log("upload successful!");
                    window.location.reload();
                },

                error: function (error) {
                    //upload failed
                    console.log("upload error: " + error.name + ": " + error.message);
                }

            });
        });

    }
    //start uploads
    function startUpload() {
        vue.$data.status = "Start uploading...";
        $("#jsonFile").simpleUpload("api?cmd=import", {

            start: function (file) {
                //upload started
                vue.$data.status = "Start uploading...";
            },

            progress: function (progress) {
                //received progress
                vue.$data.status = "Start uploading..." + Math.round(progress) + "%";
            },

            success: function (data) {
                //upload successful
                vue.$data.status = "Completed !"
            },

            error: function (error) {
                //upload failed
                console.log(error);
                vue.$data.status = "Start uploading..." + error.name + ": " + error.message;
            }

        });
    }
</script>
</body>

</html>
