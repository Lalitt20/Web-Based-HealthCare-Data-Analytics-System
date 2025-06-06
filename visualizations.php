<?php
// Include necessary files
include("adheader.php");
include("dbconnection.php");

// Redirect if doctor is not logged in
if (!isset($_SESSION['doctorid'])) {
    echo "<script>window.location='doctorlogin.php';</script>";
    exit;
}

// Fetch treatment records for the logged-in doctor's patients
$sqltreatment = "SELECT tr.blood_pressure, tr.blood_sugar, tr.cholesterol, tr.temperature, 
                        tr.pulse_rate, tr.oxygen_saturation, tr.weight, tr.height, tr.bmi, tr.treatment_date, p.patientname
                 FROM treatment_records tr
                 JOIN patient p ON tr.patientid = p.patientid
                 WHERE tr.doctorid = '$_SESSION[doctorid]'
                 ORDER BY tr.treatment_date DESC";
$qsqltreatment = mysqli_query($con, $sqltreatment) or die(mysqli_error($con));

// Prepare data for JavaScript
$treatment_data = [];
while ($row = mysqli_fetch_assoc($qsqltreatment)) {
    $treatment_data[] = $row;
}

// Benchmarks for comparison
$benchmarks = [
    "blood_pressure" => [120, 80], // Normal systolic/diastolic
    "blood_sugar" => 100.0,       // Normal blood sugar (mg/dL)
    "cholesterol" => 200.0,       // Normal cholesterol (mg/dL)
    "temperature" => 37.0,        // Normal temperature (°C)
    "bmi" => [18.5, 24.9]         // Normal BMI range
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Dashboard</title>

    <!-- Include required libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for basic charts -->
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script> <!-- Plotly for advanced charts like heat maps -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> <!-- DataTable for filtering -->
</head>
<body>

<div class="container-fluid">
    <div class="block-header">
        <h2>Visualizations</h2>
    </div>

    <div class="card">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <div class="alert bg-teal">
                            <h3>Welcome, Doctor!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#report_graphs" aria-expanded="true">Report Graphs</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#patient_data" aria-expanded="false">Patient Data</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" style="padding: 10px">
                    <!-- Report Graphs -->
                    <div role="tabpanel" class="tab-pane animated flipInX active" id="report_graphs" aria-expanded="true">
                        <h3>Data Analysis for Patients</h3>
                        <hr>

                        <!-- Graph Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="bloodPressureChart" style="max-height: 400px;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="bloodSugarChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="temperatureChart" style="max-height: 400px;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="bmiChart" style="max-height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Data Table -->
                    <div role="tabpanel" class="tab-pane" id="patient_data" aria-expanded="false">
                        <h3>Patient Treatment Records</h3>
                        <table id="patientDataTable" class="display">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Blood Pressure</th>
                                    <th>Blood Sugar</th>
                                    <th>Cholesterol</th>
                                    <th>Temperature</th>
                                    <th>Pulse Rate</th>
                                    <th>Oxygen Saturation</th>
                                    <th>BMI</th>
                                    <th>Treatment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($treatment_data as $data): ?>
                                    <tr>
                                        <td><?= $data['patientname'] ?></td>
                                        <td><?= $data['blood_pressure'] ?></td>
                                        <td><?= $data['blood_sugar'] ?></td>
                                        <td><?= $data['cholesterol'] ?></td>
                                        <td><?= $data['temperature'] ?></td>
                                        <td><?= $data['pulse_rate'] ?></td>
                                        <td><?= $data['oxygen_saturation'] ?></td>
                                        <td><?= $data['bmi'] ?></td>
                                        <td><?= $data['treatment_date'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#patientDataTable').DataTable();
    });

    // Convert PHP data to JavaScript
    const treatmentData = <?php echo json_encode($treatment_data); ?>;
    const benchmarks = <?php echo json_encode($benchmarks); ?>;

    // Prepare the labels (dates) and the datasets for each chart
    const dates = treatmentData.map(data => data.treatment_date);
    const bloodSugar = treatmentData.map(data => parseFloat(data.blood_sugar));
    const cholesterol = treatmentData.map(data => parseFloat(data.cholesterol));
    const bloodPressure = treatmentData.map(data => {
        const [systolic, diastolic] = data.blood_pressure.split('/').map(Number);
        return { systolic, diastolic };
    });
    const temperature = treatmentData.map(data => parseFloat(data.temperature));
    const pulseRate = treatmentData.map(data => data.pulse_rate);
    const oxygenSaturation = treatmentData.map(data => parseFloat(data.oxygen_saturation));
    const bmi = treatmentData.map(data => parseFloat(data.bmi));

    // Create pie chart for Blood Pressure (Normal vs High)
    const bloodPressureStatus = treatmentData.map(data => {
        const [systolic, diastolic] = data.blood_pressure.split('/').map(Number);
        return (systolic <= benchmarks.blood_pressure[0] && diastolic <= benchmarks.blood_pressure[1]) ? 'Normal' : 'High';
    });

    const bloodPressureCounts = ['Normal', 'High'].map(status => bloodPressureStatus.filter(statusItem => statusItem === status).length);

    new Chart(document.getElementById('bloodPressureChart'), {
        type: 'pie',
        data: {
            labels: ['Normal', 'High'],
            datasets: [{
                data: bloodPressureCounts,
                backgroundColor: ['#36A2EB', '#FF6384'],
            }]
        }
    });

    // Create line chart for Blood Sugar levels
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
                data: new Array(treatmentData.length).fill(benchmarks.blood_sugar),
                borderColor: 'rgba(255, 99, 132, 1)',
                borderDash: [5, 5],
                borderWidth: 1
            }]
        }
    });

    // Create bar chart for Temperature (Normal vs High)
    const temperatureStatus = temperature.map(temp => temp <= benchmarks.temperature ? 'Normal' : 'High');
    const temperatureCounts = ['Normal', 'High'].map(status => temperatureStatus.filter(statusItem => statusItem === status).length);

    new Chart(document.getElementById('temperatureChart'), {
        type: 'bar',
        data: {
            labels: ['Normal', 'High'],
            datasets: [{
                label: 'Temperature Count',
                data: temperatureCounts,
                backgroundColor: ['#4CAF50', '#FF9800'],
                borderWidth: 1
            }]
        }
    });


        // Create heat map for BMI classification
    const bmiCategory = bmi.map(val => {
        if (val < benchmarks.bmi[0]) return 'Underweight';
        if (val >= benchmarks.bmi[0] && val <= benchmarks.bmi[1]) return 'Normal';
        return 'Overweight';
    });

    const bmiData = {
        'Underweight': bmiCategory.filter(cat => cat === 'Underweight').length,
        'Normal': bmiCategory.filter(cat => cat === 'Normal').length,
        'Overweight': bmiCategory.filter(cat => cat === 'Overweight').length
    };

    const trace = {
        z: [[bmiData['Underweight'], bmiData['Normal'], bmiData['Overweight']]],
        x: ['BMI Categories'],
        y: ['Count'],
        colorscale: 'Viridis',
        type: 'heatmap'
    };

    const layout = {
        title: 'BMI Distribution Heatmap',
        xaxis: { title: 'BMI Categories' },
        yaxis: { title: 'Count' }
    };

    Plotly.newPlot('bmiChart', [trace], layout);

</script>

<!-- Include footer -->
<?php include("adfooter.php"); ?>

</body>
</html>
