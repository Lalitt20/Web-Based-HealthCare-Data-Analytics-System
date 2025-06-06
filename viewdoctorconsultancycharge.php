<?php
include("adformheader.php");
include("dbconnection.php");

if (!isset($_SESSION['doctorid'])) {
    echo "<script>alert('Access denied. Please log in as a doctor.');window.location='index.php';</script>";
    exit;
}

$doctorid = $_SESSION['doctorid'];

// Get doctor info
$sqldoc = "SELECT doctorname, consultancy_charge FROM doctor WHERE doctorid = '$doctorid'";
$qdoc = mysqli_query($con, $sqldoc);
$rsdoc = mysqli_fetch_array($qdoc);
$consultancy_charge = $rsdoc['consultancy_charge'];
$doctorname = $rsdoc['doctorname'];

// Count appointments
$sqlapp = "SELECT COUNT(*) AS appt_count FROM appointment WHERE doctorid = '$doctorid'";
$qapp = mysqli_query($con, $sqlapp);
$rsapp = mysqli_fetch_array($qapp);
$appointment_count = $rsapp['appt_count'];

// Count prescriptions
$sqlpres = "SELECT COUNT(*) AS presc_count FROM prescription WHERE doctorid = '$doctorid'";
$qpres = mysqli_query($con, $sqlpres);
$rspres = mysqli_fetch_array($qpres);
$prescription_count = $rspres['presc_count'];

// Set fixed prescription charge
$prescription_charge = 30; // Change if needed

$total_consultancy_income = $consultancy_charge * $appointment_count;
$total_prescription_income = $prescription_charge * $prescription_count;
$total_income = $total_consultancy_income + $total_prescription_income;
?>

<div class="container-fluid">
    <div class="block-header">
        <h2 class="text-center">Doctor Earnings Report</h2>
    </div>

    <div class="card">
        <section class="container">
            <h4>Dr. <?php echo htmlspecialchars($doctorname); ?></h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Count</th>
                        <th>Rate (£)</th>
                        <th>Total (£)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Consultations</td>
                        <td><?php echo $appointment_count; ?></td>
                        <td><?php echo number_format($consultancy_charge, 2); ?></td>
                        <td><?php echo number_format($total_consultancy_income, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Prescriptions</td>
                        <td><?php echo $prescription_count; ?></td>
                        <td><?php echo number_format($prescription_charge, 2); ?></td>
                        <td><?php echo number_format($total_prescription_income, 2); ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Total Earnings</th>
                        <th>£ <?php echo number_format($total_income, 2); ?></th>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>

<?php include("adformfooter.php"); ?>