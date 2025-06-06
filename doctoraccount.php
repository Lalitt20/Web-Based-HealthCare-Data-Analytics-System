<?php

include("adheader.php");
include('dbconnection.php');

if (!isset($_SESSION['doctorid'])) {
    echo "<script>window.location='doctorlogin.php';</script>";
}

?>
<div class="container-fluid">
    <div class="block-header">
        <h2>Welcome <?php 
        $sql = "SELECT * FROM `doctor` WHERE doctorid='$_SESSION[doctorid]' ";
        $doctortable = mysqli_query($con, $sql);
        $doc = mysqli_fetch_array($doctortable);

        echo 'Dr. ' . $doc['doctorname']; 
        ?>
        </h2>
    </div>
</div>

<div class="card">
    <section class="container">
        <div class="row clearfix" style="margin-top: 10px">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon"> <i class="zmdi zmdi-file-plus col-blue"></i> </div>
                    <div class="content">
                        <div class="text">New Appointment</div>
                        <div class="number"><?php
                        $sql = "SELECT * FROM appointment WHERE `doctorid`= '$_SESSION[doctorid]' AND appointmentdate='" . date("Y-m-d") . "'";
                        $qsql = mysqli_query($con, $sql);
                        echo mysqli_num_rows($qsql);
                        ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon"> <i class="zmdi zmdi-account col-cyan"></i> </div>
                    <div class="content">
                        <div class="text">Number of Patients</div>
                        <div class="number"><?php
                        $sql = "SELECT * FROM patient WHERE status='Active'";
                        $qsql = mysqli_query($con, $sql);
                        echo mysqli_num_rows($qsql);
                        ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect" onclick="location.href='writereport.php';" style="cursor: pointer;">
                    <div class="icon"> <i class="zmdi zmdi-account-circle col-blush"></i> </div>
                    <div class="content">
                        <div class="text">Write Report</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                    <div class="icon"> <i class="zmdi zmdi-chart col-green"></i> </div>
                    <div class="content">
                        <div class="text">Visualizations</div>
                        <div class="number">
                            <a href="visualizations.php" class="btn btn-success">View Metrics</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include("adfooter.php");
?>
