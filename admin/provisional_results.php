<?php
/*
 * Created on Thu Jul 08 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 MartDevelopers Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

session_start();
require_once '../config/config.php';
require_once '../config/checklogin.php';
admin_check_login();
require_once '../config/codeGen.php';

/* Marks Entry */
if (isset($_POST['add_marks'])) {
    //Error Handling and prevention of posting double entries
    $error = 0;

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, trim($_POST['id']));
    } else {
        $error = 1;
        $err = 'ID Cannot Be Empty';
    }

    if (isset($_POST['course_id']) && !empty($_POST['course_id'])) {
        $course_id = mysqli_real_escape_string($mysqli, trim($_POST['course_id']));
    } else {
        $error = 1;
        $err = 'Course ID Cannot Be Empty';
    }

    if (isset($_POST['course_name']) && !empty($_POST['course_name'])) {
        $course_name = mysqli_real_escape_string($mysqli, trim($_POST['course_name']));
    } else {
        $error = 1;
        $err = 'Course Name Cannot Be Empty';
    }

    if (isset($_POST['unit_code']) && !empty($_POST['unit_code'])) {
        $unit_code = mysqli_real_escape_string($mysqli, trim($_POST['unit_code']));
    } else {
        $error = 1;
        $err = 'Enrolled Unit Code Cannot Be Empty';
    }

    if (isset($_POST['unit_name']) && !empty($_POST['unit_name'])) {
        $unit_name = mysqli_real_escape_string($mysqli, trim($_POST['unit_name']));
    } else {
        $error = 1;
        $err = 'Enrolled Unit Name Cannot Be Empty';
    }

    if (isset($_POST['std_regno']) && !empty($_POST['std_regno'])) {
        $std_regno = mysqli_real_escape_string($mysqli, trim($_POST['std_regno']));
    } else {
        $error = 1;
        $err = 'Student Registration Number Cannot Be Empty';
    }

    if (isset($_POST['std_name']) && !empty($_POST['std_name'])) {
        $std_name = mysqli_real_escape_string($mysqli, trim($_POST['std_name']));
    } else {
        $error = 1;
        $err = 'Student Name Cannot Be Empty';
    }

    if (isset($_POST['semester_enrolled']) && !empty($_POST['semester_enrolled'])) {
        $semester_enrolled = mysqli_real_escape_string($mysqli, trim($_POST['semester_enrolled']));
    } else {
        $error = 1;
        $err = 'Semester Enrolled Cannot Be Empty';
    }

    if (isset($_POST['academic_year']) && !empty($_POST['academic_year'])) {
        $academic_year = mysqli_real_escape_string($mysqli, trim($_POST['academic_year']));
    } else {
        $error = 1;
        $err = 'Academic Year Enrolled Cannot Be Empty';
    }

    if (isset($_POST['marks']) && !empty($_POST['marks'])) {
        $marks = mysqli_real_escape_string($mysqli, trim($_POST['marks']));
    } else {
        $error = 1;
        $err = 'Marks Cannot Be Empty';
    }


    if (!$error) {
        //prevent Double entries
        $sql = "SELECT * FROM  iCollege_exammarks WHERE  std_regno='$std_regno' AND unit_code = '$unit_code' AND semester_enrolled = '$semester_enrolled' AND academic_year = '$academic_year' ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if (
                $std_regno = $row['std_regno'] &&
                $unit_code = $row['unit_code'] &&
                $semester_enrolled = $row['semester_enrolled'] &&
                $academic_year = $row['academic_year']

            ) {
                $err =  "$std_name  Marks For  $unit_name Already Added  ";
            } else {
            }
        } else {

            $query = 'INSERT INTO iCollege_exammarks (id, course_id, course_name, unit_code, unit_name, std_regno, std_name, semester_enrolled, academic_year, marks) VALUES(?,?,?,?,?,?,?,?,?,?)';
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param(
                'ssssssssss',
                $id,
                $course_id,
                $course_name,
                $unit_code,
                $unit_name,
                $std_regno,
                $std_name,
                $semester_enrolled,
                $academic_year,
                $marks
            );
            $stmt->execute();
            if ($stmt) {
                $success =
                    'Student Marks' && header('refresh:1; url=marks_entry.php');
            } else {
                $info = 'Please Try Again Or Try Later';
            }
        }
    }
}

require_once '../partials/head.php';
?>

<body>

    <!--  BEGIN NAVBAR  -->
    <?php require_once '../partials/admin_nav.php'; ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg></a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">

                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Exams</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Provisional Results</span></li>
                            </ol>
                        </nav>

                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php require_once '../partials/admin_sidebar.php'; ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <div class="text-center">
                                <br>
                                <h1 class="text-bold">Students Provisional Results</h1>
                            </div>
                            <hr>
                            <div class="table-responsive mb-4 mt-4">
                                <table id="default-ordering" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Unit Code</th>
                                            <th>Unit Name</th>
                                            <th>Admno</th>
                                            <th>Name</th>
                                            <th>Semester</th>
                                            <th>Academic Year</th>
                                            <th>Marks Scored</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = 'SELECT * FROM `iCollege_exammarks`';
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        while ($marks = $res->fetch_object()) { ?>
                                            <tr>
                                                <td><?php echo $marks->course_name; ?></td>
                                                <td><?php echo $marks->unit_code; ?></td>
                                                <td><?php echo $marks->unit_name; ?></td>
                                                <td><?php echo $marks->std_regno; ?></td>
                                                <td><?php echo $marks->std_name; ?></td>
                                                <td><?php echo $marks->semester_enrolled; ?></td>
                                                <td><?php echo $marks->academic_year; ?></td>
                                                <td><?php echo $marks->marks; ?></td>
                                                <td>
                                                    <a href="#generate-<?php echo $marks->id; ?>" data-toggle="modal" class="badge outline-badge-danger">Provisional Results</a>
                                                    <!-- Exam Card Generation Modal -->
                                                    <div class="modal animated zoomInUp custo-zoomInUp" id="generate-<?php echo $marks->id; ?>" role="dialog">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="text-center">
                                                                        Single Unit Provisional Results
                                                                    </h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card" id="PrintExamCard">
                                                                        <div class="card-header text-center">
                                                                            <?php echo $marks->std_regno; ?> <?php echo $marks->std_name; ?> <?php echo $marks->unit_name; ?> Provisional Results
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <h5 class="card-title text-center"><?php echo $marks->unit_code; ?> <?php echo $marks->unit_name; ?></h5>
                                                                            <table id="default-ordering" class="table" style="width:100%">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Course</th>
                                                                                        <th>Semester</th>
                                                                                        <th>Academic Year</th>
                                                                                        <th>Marks Scored</th>
                                                                                        <th>Grade</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><?php echo $marks->course_name; ?></td>
                                                                                        <td><?php echo $marks->semester_enrolled; ?></td>
                                                                                        <td><?php echo $marks->academic_year; ?></td>
                                                                                        <td><?php echo $marks->marks; ?></td>
                                                                                        <td>
                                                                                            <?php
                                                                                            $workScore = $marks->marks;

                                                                                            switch ($workScore) {
                                                                                                case $workScore >= 70 and $workScore <= 100:
                                                                                                    echo 'A';
                                                                                                    break;
                                                                                                case $workScore >= 60 and $workScore <= 69:
                                                                                                    echo 'B';
                                                                                                    break;
                                                                                                case $workScore >= 50 and $workScore <= 59:
                                                                                                    echo 'C';
                                                                                                    break;
                                                                                                case $workScore >= 40 and $workScore <= 49:
                                                                                                    echo 'D';
                                                                                                    break;
                                                                                                case $workScore >= 0 and $workScore <= 39:
                                                                                                    echo 'E';
                                                                                                    break;
                                                                                                default:
                                                                                                    echo 'N/A';
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="card-footer">
                                                                            <small class="text-muted">Generated On <?php echo date('d M Y g:ia', strtotime($marks->created_at)); ?></small>
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button id="print" onclick="printContent('PrintExamCard');" type="button" class="btn btn-primary">Print</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once '../partials/footer.php'; ?>
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->
    <?php require_once '../partials/scripts.php'; ?>
</body>

</html>