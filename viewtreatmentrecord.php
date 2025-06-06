<?php
include("adformheader.php");
include("dbconnection.php");
if (isset($_GET['delid'])) {
	$sql = "DELETE FROM treatment_records WHERE appointmentid='$_GET[delid]'";
	$qsql = mysqli_query($con, $sql);
	if (mysqli_affected_rows($con) == 1) {
		echo "<script>alert('appointment record deleted successfully..');</script>";
	}
}
?>

<style>
	/* Styling for the tabs and table container */
	.card {
		padding: 20px;
		margin-top: 20px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		border-radius: 8px;
	}

	.nav-tabs .nav-link {
		color: #555;
		border: 1px solid #ddd;
		margin-right: 5px;
	}

	.nav-tabs .nav-link.active {
		color: #fff;
	}

	.tab-content {
		padding: 15px;
		background-color: #f9f9f9;
		border: 1px solid #ddd;
		border-top: none;
		border-radius: 0 0 8px 8px;
	}

	/* Scrollable table styling */
	.table-container {
		max-height: 400px;
		/* Limit the height of the table container */
		overflow-x: auto;
		/* Enable horizontal scrolling */
		overflow-y: auto;
		/* Enable vertical scrolling */
		border: 1px solid #ddd;
		border-radius: 5px;
		background-color: #fff;
	}

	.table {
		margin: 0;
		/* Remove default margin to fit within the container */
	}
</style>

<div class="container-fluid">
	<div class="block-header">
		<h2 class="text-center">View Records</h2>
	</div>

	<div class="card">

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="#treatment-records" data-toggle="tab">Treatment Records</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#checkup-records" data-toggle="tab">Checkup Records</a>
			</li>
		</ul>

		<div class="tab-content">
			<!-- Treatment Records Tab -->
			<div class="tab-pane fade show active" id="treatment-records">
				<section class="table-container">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
							<tr>
								<td width="71" scope="col">Treatment Type</td>
								<td width="52" scope="col">Patient</td>
								<td width="78" scope="col">Doctor</td>
								<td width="82" scope="col">Treatment Description</td>
								<td width="43" scope="col">Treatment Date</td>
								<td width="43" scope="col">Treatment Time</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT * FROM treatment_records WHERE status='Active'";
							if (isset($_SESSION['patientid'])) {
								$sql .= " AND patientid='$_SESSION[patientid]'";
							}
							if (isset($_SESSION['doctorid'])) {
								$sql .= " AND doctorid='$_SESSION[doctorid]'";
							}
							$qsql = mysqli_query($con, $sql);
							while ($rs = mysqli_fetch_array($qsql)) {
								$sqlpat = "SELECT * FROM patient WHERE patientid='$rs[patientid]'";
								$qsqlpat = mysqli_query($con, $sqlpat);
								$rspat = mysqli_fetch_array($qsqlpat);

								$sqldoc = "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
								$qsqldoc = mysqli_query($con, $sqldoc);
								$rsdoc = mysqli_fetch_array($qsqldoc);

								$sqltreatment = "SELECT * FROM treatment WHERE treatmentid='$rs[treatmentid]'";
								$qsqltreatment = mysqli_query($con, $sqltreatment);
								$rstreatment = mysqli_fetch_array($qsqltreatment);

								echo "<tr>
                  <td>$rstreatment[treatmenttype]</td>
                  <td>$rspat[patientname]</td>
                  <td>$rsdoc[doctorname]</td>
                  <td>$rs[treatment_description]</td>
                  <td>$rs[treatment_date]</td>
                  <td>$rs[treatment_time]</td>
                </tr>";
							}
							?>
						</tbody>
					</table>
				</section>
			</div>

			<!-- Checkup Records Tab -->
			<!-- Checkup Records Tab -->
			<div class="tab-pane fade" id="checkup-records">
				<section class="table-container">
					<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
							<tr>
								<th>Treatment ID</th>
								<th>Doctor Name</th>
								<th>Department</th>
								<th>Treatment Description</th>
								<th>Treatment Date</th>
								<th>Treatment Time</th>
								<th>Status</th>
								<th>Blood Tests</th>
								<th>Urine Tests</th>
								<th>Imaging Results</th>
								<th>Biopsy Results</th>
								<th>Blood Pressure</th>
								<th>Sugar Levels</th>
								<th>Cholesterol</th>
								<th>Temperature</th>
								<th>Pulse Rate</th>
								<th>Oxygen</th>
								<th>Weight</th>
								<th>BMI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Check if the user is a doctor or a patient
							$sql = "SELECT * FROM treatment_records 
									JOIN doctor ON treatment_records.doctorid = doctor.doctorid
									JOIN department ON doctor.departmentid = department.departmentid
									WHERE 1";

							if (isset($_SESSION['patientid'])) {
								// Include records for the logged-in patient
								$sql .= " AND treatment_records.patientid = '$_SESSION[patientid]'";
							} elseif (isset($_SESSION['doctorid'])) {
								// Include records created by the logged-in doctor
								$sql .= " AND treatment_records.doctorid = '$_SESSION[doctorid]'";
							}

							$sql .= " ORDER BY treatment_records.treatment_date DESC, treatment_records.treatment_time DESC";

							$qsql = mysqli_query($con, $sql);
							while ($row = mysqli_fetch_array($qsql)) {
								echo "<tr>
									<td>" . htmlspecialchars($row['treatmentid']) . "</td>
									<td>" . htmlspecialchars($row['doctorname']) . "</td>
									<td>" . htmlspecialchars($row['departmentname']) . "</td>
									<td>" . htmlspecialchars($row['treatment_description']) . "</td>
									<td>" . htmlspecialchars($row['treatment_date']) . "</td>
									<td>" . htmlspecialchars($row['treatment_time']) . "</td>
									<td>" . htmlspecialchars($row['status']) . "</td>
									<td>" . htmlspecialchars($row['blood_tests']) . "</td>
									<td>" . htmlspecialchars($row['urine_tests']) . "</td>
									<td>" . htmlspecialchars($row['imaging_results']) . "</td>
									<td>" . htmlspecialchars($row['biopsy_results']) . "</td>
									<td>" . htmlspecialchars($row['blood_pressure']) . "</td>
									<td>" . htmlspecialchars($row['blood_sugar']) . "</td>
									<td>" . htmlspecialchars($row['cholesterol']) . "</td>
									<td>" . htmlspecialchars($row['temperature']) . "</td>
									<td>" . htmlspecialchars($row['pulse_rate']) . "</td>
									<td>" . htmlspecialchars($row['oxygen_saturation']) . "</td>
									<td>" . htmlspecialchars($row['weight']) . "</td>
									<td>" . htmlspecialchars($row['bmi']) . "</td>
								</tr>";
							}
							?>
						</tbody>
					</table>
				</section>
			</div>

		</div>
	</div>
</div>

<?php
include("adformfooter.php");
?>