<?php
include("header.php");
include("dbconnection.php");
session_start();

if (!isset($_SESSION['patientid'])) {
    echo "<script>alert('Please login to continue.');</script>";
    echo "<script>window.location='patientlogin.php';</script>";
    exit();
}

$patientid = $_SESSION['patientid'];

if (isset($_POST['submit'])) {
    $appointmentDate = $_POST['appointmentdate'];
    $appointmentTime = $_POST['appointmenttime'];
    $departmentId = $_POST['department'];
    $doctorId = $_POST['doct'];
    $reason = $_POST['app_reason'];

    $sqlappointment = "SELECT * FROM appointment 
                        WHERE appointmentdate='$appointmentDate' 
                          AND appointmenttime='$appointmentTime' 
                          AND doctorid='$doctorId' 
                          AND status='Approved'";
    $qsqlappointment = mysqli_query($con, $sqlappointment);

    if (mysqli_num_rows($qsqlappointment) >= 1) {
        echo "<script>alert('Appointment already scheduled for this time.');</script>";
    } else {
        $sql = "INSERT INTO appointment 
        (appointmenttype, patientid, appointmentdate, appointmenttime, app_reason, status, departmentid, doctorid) 
        VALUES 
        ('ONLINE', '$patientid', '$appointmentDate', '$appointmentTime', '$reason', 'Pending', '$departmentId', '$doctorId')";

        if ($qsql = mysqli_query($con, $sql)) {
            echo "<script>alert('Appointment record inserted successfully.');</script>";
        } else {
            echo "SQL Error: " . mysqli_error($con);
            echo "SQL Query: " . $sql;
        }

    }
}

// Fetch patient details
$sqlpatient = "SELECT * FROM patient WHERE patientid='$patientid'";
$qsqlpatient = mysqli_query($con, $sqlpatient);
$rspatient = mysqli_fetch_array($qsqlpatient);
?>
<div class="wrapper col4">
    <div id="container">
        <section class="main-oppoiment" style="background-image:url('images/appointment.jpg');background-repeat: no-repeat;background-size: 75%;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="appointment">
                            <div class="heading-block head-left margin-bottom-50">
                                <h4 style="color:black;font-weight:500;">Make an Appointment</h4>
                            </div>
                            <form method="post" action="" name="frmpatapp" onsubmit="return validateform()" class="appointment-form">
                                <ul class="row">
                                    <li class="col-sm-12">
                                        <label>
                                            <input type="text" class="form-control" value="<?php echo $rspatient['patientname']; ?>" readonly>
                                            <i class="icon-user"></i>
                                        </label>
                                    </li>
                                    <li class="col-sm-12">
                                        <label>
                                            <input type="text" class="form-control" value="<?php echo $rspatient['address']; ?>" readonly>
                                            <i class="icon-compass"></i>
                                        </label>
                                    </li>
                                    <li class="col-sm-12">
                                        <label>
                                            <input type="text" class="form-control" value="<?php echo $rspatient['mobileno']; ?>" readonly>
                                            <i class="icon-phone"></i>
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <label>
                                            <input type="text" class="form-control" name="appointmentdate" placeholder="Appointment Date" onfocus="(this.type='date')" min="<?php echo date('Y-m-d'); ?>">
                                            <i class="ion-calendar"></i>
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <label>
                                            <input type="text" class="form-control" name="appointmenttime" placeholder="Appointment Time" onfocus="(this.type='time')">
                                            <i class="ion-ios-clock"></i>
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <label>
                                            <select name="department" class="selectpicker">
                                                <option value="">Select Department</option>
                                                <?php
                                                $sqldept = "SELECT * FROM department WHERE status='Active'";
                                                $qsqldept = mysqli_query($con, $sqldept);
                                                while ($rsdept = mysqli_fetch_array($qsqldept)) {
                                                    echo "<option value='$rsdept[departmentid]'>$rsdept[departmentname]</option>";
                                                }
                                                ?>
                                            </select>
                                            <i class="ion-university"></i>
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <label>
                                            <select name="doct" class="selectpicker">
                                                <option value="">Select Doctor</option>
                                                <?php
                                                $sqldoctor = "SELECT * FROM doctor WHERE status='Active'";
                                                $qsqldoctor = mysqli_query($con, $sqldoctor);
                                                while ($rsdoctor = mysqli_fetch_array($qsqldoctor)) {
                                                    $sqldept = "SELECT * FROM department WHERE departmentid='$rsdoctor[departmentid]'";
                                                    $qsqldepta = mysqli_query($con, $sqldept);
                                                    $rsdept = mysqli_fetch_array($qsqldepta);
                                                    echo "<option value='$rsdoctor[doctorid]'>$rsdoctor[doctorname] ($rsdept[departmentname])</option>";
                                                }
                                                ?>
                                            </select>
                                            <i class="ion-medkit"></i>
                                        </label>
                                    </li>
                                    <li class="col-sm-12">
                                        <label>
                                            <textarea class="form-control" name="app_reason" placeholder="Appointment reason"></textarea>
                                        </label>
                                    </li>
                                    <li class="col-sm-12">
                                        <button type="submit" class="btn" name="submit">Make an Appointment</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="application/javascript">
function validateform() {
    if (document.frmpatapp.appointmentdate.value == "") {
        alert("Appointment date should not be empty.");
        document.frmpatapp.appointmentdate.focus();
        return false;
    } else if (document.frmpatapp.appointmenttime.value == "") {
        alert("Appointment time should not be empty.");
        document.frmpatapp.appointmenttime.focus();
        return false;
    } else if (document.frmpatapp.department.value == "") {
        alert("Department should not be empty.");
        document.frmpatapp.department.focus();
        return false;
    } else if (document.frmpatapp.doct.value == "") {
        alert("Doctor should not be empty.");
        document.frmpatapp.doct.focus();
        return false;
    } else if (document.frmpatapp.app_reason.value == "") {
        alert("Appointment reason should not be empty.");
        document.frmpatapp.app_reason.focus();
        return false;
    } else {
        return true;
    }
}
</script>
<?php include("footer.php"); ?>
