<?php
// Include necessary files
include("adheader.php");
include("dbconnection.php");

// Redirect if patient is not logged in
if (!isset($_SESSION['patientid'])) {
    echo "<script>window.location='patientlogin.php';</script>";
    exit;
}

// Fetch patient details
$sqlpatient = "SELECT * FROM patient WHERE patientid='$_SESSION[patientid]' ";
$qsqlpatient = mysqli_query($con, $sqlpatient);
$rspatient = mysqli_fetch_array($qsqlpatient);

// Fetch latest appointment details
$sqlpatientappointment = "SELECT * FROM appointment WHERE patientid='$_SESSION[patientid]' ORDER BY appointmentid DESC LIMIT 1";
$qsqlpatientappointment = mysqli_query($con, $sqlpatientappointment);
$rspatientappointment = mysqli_fetch_array($qsqlpatientappointment);

// Fetch treatment records for data visualization
$sqltreatment = "SELECT blood_pressure, blood_sugar, cholesterol, treatment_date 
                 FROM treatment_records 
                 WHERE patientid='$_SESSION[patientid]' 
                 ORDER BY treatment_date DESC";
$qsqltreatment = mysqli_query($con, $sqltreatment) or die(mysqli_error($con));

$treatment_data = [];
while ($row = mysqli_fetch_assoc($qsqltreatment)) {
    $treatment_data[] = $row;
}

// Benchmarks for comparison
$benchmarks = [
    "blood_pressure" => [120, 80], // Normal systolic/diastolic
    "blood_sugar" => 100.0,       // Normal blood sugar (mg/dL)
    "cholesterol" => 200.0        // Normal cholesterol (mg/dL)
];
?>

<div class="container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
    </div>

    <div class="card">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <div class="alert bg-teal">
                            <h3>Welcome, <?php echo $rspatient['patientname']; ?>!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#home_animation_1"
                            aria-expanded="true">Registration History</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile_animation_1"
                            aria-expanded="false">Appointment</a></li>
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#report_graphs"
                            aria-expanded="true">Report Graphs</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="padding: 10px">
                    <!-- Registration History -->
                    <div role="tabpanel" class="tab-pane animated flipInX" id="home_animation_1" aria-expanded="false">
                        <b>Registration History</b>
                        <h3>You are with us from <?php echo $rspatient['admissiondate']; ?>
                            <?php echo $rspatient['admissiontime']; ?>
                        </h3>
                    </div>

                    <!-- Appointment Details -->
                    <div role="tabpanel" class="tab-pane animated flipInX" id="profile_animation_1"
                        aria-expanded="false">
                        <b>Appointment</b>
                        <?php
                        if (mysqli_num_rows($qsqlpatientappointment) == 0) {
                            echo "<h3>Appointment records not found.</h3>";
                        } else {
                            echo "<h3>Last Appointment taken on - " . $rspatientappointment['appointmentdate'] . " at " . $rspatientappointment['appointmenttime'] . "</h3>";
                        }
                        ?>
                    </div>

                    <!-- Report Graphs -->
                    <div role="tabpanel" class="tab-pane animated flipInX active" id="report_graphs"
                        aria-expanded="true">
                        <h3>Data Analysis for <?php echo $rspatient['patientname']; ?></h3>
                        <hr>

                        <!-- Graph Section -->
                        <div>
                            <canvas id="bloodSugarChart" style="max-height: 400px;"></canvas>
                            <hr>
                            <canvas id="cholesterolChart" style="max-height: 400px;"></canvas>
                            <hr>
                            <canvas id="bloodPressureChart" style="max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js CDN -->
<script>
    // Convert PHP data to JavaScript
    const treatmentData = <?php echo json_encode($treatment_data); ?>;
    const benchmarks = <?php echo json_encode($benchmarks); ?>;

    // Extract data for charts
    const dates = treatmentData.map(data => data.treatment_date);
    const bloodSugar = treatmentData.map(data => parseFloat(data.blood_sugar));
    const cholesterol = treatmentData.map(data => parseFloat(data.cholesterol));
    const bloodPressure = treatmentData.map(data => {
        const [systolic, diastolic] = data.blood_pressure.split('/').map(Number);
        return {
            systolic,
            diastolic
        };
    });

    const bloodSugarBenchmark = new Array(treatmentData.length).fill(benchmarks.blood_sugar);
    const cholesterolBenchmark = new Array(treatmentData.length).fill(benchmarks.cholesterol);
    const systolicBenchmark = new Array(treatmentData.length).fill(benchmarks.blood_pressure[0]);
    const diastolicBenchmark = new Array(treatmentData.length).fill(benchmarks.blood_pressure[1]);

    // Blood Sugar Line Chart
    new Chart(document.getElementById('bloodSugarChart'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Blood Sugar (mg/dL)',
                data: bloodSugar,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            },
            {
                label: 'Normal Blood Sugar',
                data: bloodSugarBenchmark,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderDash: [5, 5],
                borderWidth: 1
            }
            ]
        }
    });

    // Cholesterol Bar Chart
    new Chart(document.getElementById('cholesterolChart'), {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: 'Cholesterol (mg/dL)',
                data: cholesterol,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Normal Cholesterol',
                data: cholesterolBenchmark,
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderDash: [5, 5],
                borderWidth: 1
            }
            ]
        }
    });

    // Blood Pressure Chart
    new Chart(document.getElementById('bloodPressureChart'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Systolic BP',
                data: bloodPressure.map(bp => bp.systolic),
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderWidth: 1
            },
            {
                label: 'Diastolic BP',
                data: bloodPressure.map(bp => bp.diastolic),
                borderColor: 'rgba(255, 159, 64, 1)',
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderWidth: 1
            }
            ]
        }
    });
</script>

<?php include("adfooter.php"); ?>