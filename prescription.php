<?php
include("adheader.php");
include("dbconnection.php");

if (isset($_POST['submit'])) {
    $doctorid = $_POST['select2'];
    $treatmentid = $_POST['treatmentid'];
    $patientid = $_POST['patientid'];
    $prescriptionDate = $_POST['date'];
    $appointmentid = $_POST['appid'];

    // Validate existence of related data
    $checkDoctor = mysqli_query($con, "SELECT * FROM doctor WHERE doctorid='$doctorid' AND status='Active'");
    $checkTreatment = mysqli_query($con, "SELECT * FROM treatment_records WHERE treatment_records_id='$treatmentid' AND patientid='$patientid'");
    $checkAppointment = mysqli_query($con, "SELECT * FROM appointment WHERE appointmentid='$appointmentid'");

    if (!mysqli_num_rows($checkDoctor)) {
        echo "<script>alert('Doctor ID is invalid or inactive.');</script>";
    } elseif (!mysqli_num_rows($checkTreatment)) {
        echo "<script>alert('Treatment record is invalid or does not belong to this patient.');</script>";
    } elseif (!mysqli_num_rows($checkAppointment)) {
        echo "<script>alert('Appointment record is invalid.');</script>";
    } else {
        // Insert or update record
        if (isset($_GET['editid'])) {
            $sql = "UPDATE prescription SET 
                        treatment_records_id='$treatmentid', 
                        doctorid='$doctorid', 
                        patientid='$patientid', 
                        prescriptiondate='$prescriptionDate', 
                        status='Active', 
                        appointmentid='$appointmentid' 
                    WHERE prescriptionid='$_GET[editid]'";
            if (mysqli_query($con, $sql)) {
                echo "<script>alert('Prescription record updated successfully.');</script>";
            } else {
                echo mysqli_error($con);
            }
        } else {
            $sql = "INSERT INTO prescription (treatment_records_id, doctorid, patientid, prescriptiondate, status, appointmentid) 
                    VALUES ('$treatmentid', '$doctorid', '$patientid', '$prescriptionDate', 'Active', '$appointmentid')";
            if (mysqli_query($con, $sql)) {
                $prescriptionid = mysqli_insert_id($con);

                // Calculate total cost of prescription
                $total_cost = 0;
                $qsql = mysqli_query($con, "SELECT * FROM prescription_records WHERE prescription_id='$prescriptionid'");
                while ($row = mysqli_fetch_array($qsql)) {
                    $total_cost += $row['cost'] * $row['unit'];
                }

                // Find billing ID based on appointment
                $res = mysqli_query($con, "SELECT billingid FROM billing WHERE appointmentid='$appointmentid'");
                $bill = mysqli_fetch_array($res);
                $billingid = $bill['billingid'];

                // Insert into billing records
                mysqli_query($con, "INSERT INTO billing_records (billingid, bill_type, bill_type_id, bill_amount, bill_date)
                                    VALUES ('$billingid', 'Prescription charge', '$prescriptionid', '$total_cost', CURDATE())");

                echo "<script>alert('Prescription and billing added successfully.');</script>";
                echo "<script>window.location='prescriptionrecord.php?prescriptionid=$prescriptionid&patientid=$patientid&appid=$appointmentid';</script>";
            } else {
                echo mysqli_error($con);
            }
        }
    }
}

if (isset($_GET['editid'])) {
    $sql = "SELECT * FROM prescription WHERE prescriptionid='$_GET[editid]'";
    $qsql = mysqli_query($con, $sql);
    $rsedit = mysqli_fetch_array($qsql);
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2>Add New Prescription</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card" style="padding: 10px">
                <form method="post" action="" name="frmpres" onSubmit="return validateform()">
                    <input type="hidden" name="patientid" value="<?php echo htmlspecialchars($_GET['patientid']); ?>" />
                    <input type="hidden" name="appid" value="<?php echo htmlspecialchars($_GET['appid']); ?>" />

                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td>Patient</td>
                                <td>
                                    <?php
                                    $sqlpatient = "SELECT * FROM patient WHERE status='Active' AND patientid='" . mysqli_real_escape_string($con, $_GET['patientid']) . "'";
                                    $qsqlpatient = mysqli_query($con, $sqlpatient);
                                    if ($rspatient = mysqli_fetch_array($qsqlpatient)) {
                                        echo htmlspecialchars($rspatient['patientid']) . " - " . htmlspecialchars($rspatient['patientname']);
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Treatment Record</td>
                                <td>
                                    <select class="form-control" name="treatmentid" id="treatmentid" required>
                                        <option value="">Select Treatment Record</option>
                                        <?php
                                        $sqltreatment = "SELECT * FROM treatment_records WHERE patientid='" . mysqli_real_escape_string($con, $_GET['patientid']) . "'";
                                        $qsqltreatment = mysqli_query($con, $sqltreatment);
                                        while ($rstreatment = mysqli_fetch_array($qsqltreatment)) {
                                            $selected = ($rstreatment['treatment_records_id'] == $rsedit['treatment_records_id']) ? "selected" : "";
                                            echo "<option value='" . htmlspecialchars($rstreatment['treatment_records_id']) . "' $selected>
                                                  " . htmlspecialchars($rstreatment['treatment_description']) . " (Date: " . htmlspecialchars($rstreatment['treatment_date']) . ")
                                                  </option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Doctor</td>
                                <td>
                                    <?php
                                    $sqldoctor = "SELECT * FROM doctor 
                                                  INNER JOIN department ON department.departmentid=doctor.departmentid 
                                                  WHERE doctor.status='Active' AND doctor.doctorid='" . mysqli_real_escape_string($con, $_SESSION['doctorid']) . "'";
                                    $qsqldoctor = mysqli_query($con, $sqldoctor);
                                    if ($rsdoctor = mysqli_fetch_array($qsqldoctor)) {
                                        echo htmlspecialchars($rsdoctor['doctorname']) . " ( " . htmlspecialchars($rsdoctor['departmentname']) . " )";
                                    }
                                    ?>
                                    <input type="hidden" name="select2" value="<?php echo htmlspecialchars($_SESSION['doctorid']); ?>" />
                                </td>
                            </tr>

                            <tr>
                                <td>Prescription Date</td>
                                <td>
                                    <input class="form-control" type="date" name="date" id="date" 
                                           max="<?php echo date("Y-m-d"); ?>" 
                                           value="<?php echo htmlspecialchars($rsedit['prescriptiondate']); ?>" required />
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center">
                                    <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Submit" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("adfooter.php"); ?>

<script type="application/javascript">
function validateform() {
    if (document.frmpres.treatmentid.value == "") {
        alert("Treatment record must be selected.");
        document.frmpres.treatmentid.focus();
        return false;
    } else if (document.frmpres.select2.value == "") {
        alert("Doctor name must be selected.");
        document.frmpres.select2.focus();
        return false;
    } else if (document.frmpres.date.value == "") {
        alert("Prescription date must not be empty.");
        document.frmpres.date.focus();
        return false;
    } else {
        return true;
    }
}
</script>
