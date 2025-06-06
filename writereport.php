<?php
session_start();
include("dbconnection.php");

if (!isset($_SESSION['doctorid'])) {
    echo "<script>alert('Please login first.'); window.location='doctorlogin.php';</script>";
    exit;
}

$doctorid = $_SESSION['doctorid'];
$dt = date("Y-m-d");
$tim = date("H:i:s");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientid = $_POST['patientid'];
    $treatmentid = $_POST['treatmentid'];
    $treatment_description = mysqli_real_escape_string($con, $_POST['treatment_description']);
    $blood_pressure = $_POST['blood_pressure'];
    $blood_sugar = $_POST['blood_sugar'];
    $cholesterol = $_POST['cholesterol'];
    $temperature = $_POST['temperature'];
    $pulse_rate = $_POST['pulse_rate'];
    $oxygen_saturation = $_POST['oxygen'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $bmi = $_POST['bmi'];
    $blood_tests = mysqli_real_escape_string($con, $_POST['blood_tests']);
    $urine_tests = mysqli_real_escape_string($con, $_POST['urine_tests']);
    $imaging_results = mysqli_real_escape_string($con, $_POST['imaging_results']);
    $biopsy_results = mysqli_real_escape_string($con, $_POST['biopsy_results']);
    $other_tests = mysqli_real_escape_string($con, $_POST['other_tests']);
    $status = $_POST['status'];

    // Get a random appointmentid from appointment table
    $sql_appoint = "SELECT appointmentid FROM appointment ORDER BY RAND() LIMIT 1";
    $res_appoint = mysqli_query($con, $sql_appoint);

    if ($res_appoint && mysqli_num_rows($res_appoint) > 0) {
        $row_appoint = mysqli_fetch_assoc($res_appoint);
        $appointmentid = $row_appoint['appointmentid'];
    } else {
        echo "<script>alert('No appointment found in the system. Please add an appointment first.'); window.history.back();</script>";
        exit;
    }

    // Insert treatment record
    $sql = "INSERT INTO treatment_records 
            (treatmentid, appointmentid, patientid, doctorid, treatment_description, blood_pressure, blood_sugar, cholesterol, temperature, pulse_rate, oxygen_saturation, weight, height, bmi, blood_tests, urine_tests, imaging_results, biopsy_results, other_tests, treatment_date, treatment_time, status)
            VALUES
            ('$treatmentid', '$appointmentid', '$patientid', '$doctorid', '$treatment_description', '$blood_pressure', '$blood_sugar', '$cholesterol', '$temperature', '$pulse_rate', '$oxygen_saturation', '$weight', '$height', '$bmi', '$blood_tests', '$urine_tests', '$imaging_results', '$biopsy_results', '$other_tests', '$dt', '$tim', '$status')";

    $qsql = mysqli_query($con, $sql);

    if ($qsql) {
        echo "<script>alert('Treatment record saved successfully.'); window.location='doctoraccount.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
        exit;
    }
}

// Fetch patients for dropdown
$patients = [];
$sql_patients = "SELECT patientid, patientname FROM patient ORDER BY patientname ASC";
$res_patients = mysqli_query($con, $sql_patients);
if ($res_patients) {
    while ($row = mysqli_fetch_assoc($res_patients)) {
        $patients[] = $row;
    }
} else {
    die("Error fetching patients: " . mysqli_error($con));
}

// Fetch treatments for dropdown
$treatments = [];
$sql_treatments = "SELECT treatmentid, treatmenttype FROM treatment WHERE status = 'Active' ORDER BY treatmenttype ASC";
$res_treatments = mysqli_query($con, $sql_treatments);
if ($res_treatments) {
    while ($row = mysqli_fetch_assoc($res_treatments)) {
        $treatments[] = $row;
    }
} else {
    die("Error fetching treatments: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Treatment Report</title>
    <style>
        .container { max-width: 600px; margin: 30px auto; font-family: Arial, sans-serif; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        textarea { resize: vertical; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <h2>Add New Treatment Report</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="patientid">Select Patient:</label>
            <select name="patientid" id="patientid" required>
                <option value="">-- Select Patient --</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?php echo htmlspecialchars($patient['patientid']); ?>">
                        <?php echo htmlspecialchars($patient['patientname']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="treatmentid">Select Treatment:</label>
            <select name="treatmentid" id="treatmentid" required>
                <option value="">-- Select Treatment --</option>
                <?php foreach ($treatments as $treatment): ?>
                    <option value="<?php echo htmlspecialchars($treatment['treatmentid']); ?>">
                        <?php echo htmlspecialchars($treatment['treatmenttype']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="treatment_description">Treatment Description:</label>
            <textarea name="treatment_description" id="treatment_description" required></textarea>
        </div>

        <div class="form-group">
            <label for="blood_tests">Blood Tests:</label>
            <textarea name="blood_tests" id="blood_tests" required></textarea>
        </div>

        <div class="form-group">
            <label for="urine_tests">Urine Tests:</label>
            <textarea name="urine_tests" id="urine_tests" required></textarea>
        </div>

        <div class="form-group">
            <label for="imaging_results">Imaging Results:</label>
            <textarea name="imaging_results" id="imaging_results" required></textarea>
        </div>

        <div class="form-group">
            <label for="biopsy_results">Biopsy Results:</label>
            <textarea name="biopsy_results" id="biopsy_results" required></textarea>
        </div>

        <div class="form-group">
            <label for="other_tests">Other Tests:</label>
            <textarea name="other_tests" id="other_tests" required></textarea>
        </div>

        <!-- Remaining fields -->
        <div class="form-group"><label for="blood_pressure">Blood Pressure:</label> <input type="text" name="blood_pressure" id="blood_pressure" required></div>
        <div class="form-group"><label for="blood_sugar">Blood Sugar:</label> <input type="text" name="blood_sugar" id="blood_sugar" required></div>
        <div class="form-group"><label for="cholesterol">Cholesterol:</label> <input type="text" name="cholesterol" id="cholesterol" required></div>
        <div class="form-group"><label for="temperature">Temperature:</label> <input type="text" name="temperature" id="temperature" required></div>
        <div class="form-group"><label for="pulse_rate">Pulse Rate:</label> <input type="text" name="pulse_rate" id="pulse_rate" required></div>
        <div class="form-group"><label for="oxygen">Oxygen Saturation:</label> <input type="text" name="oxygen" id="oxygen" required></div>
        <div class="form-group"><label for="weight">Weight:</label> <input type="text" name="weight" id="weight" required></div>
        <div class="form-group"><label for="height">Height:</label> <input type="text" name="height" id="height" required></div>
        <div class="form-group"><label for="bmi">BMI:</label> <input type="text" name="bmi" id="bmi" required></div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="Active">Active</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <button type="submit">Save Report</button>
    </form>
</div>
</body>
</html>
