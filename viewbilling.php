<?php
session_start();
include("dbconnection.php");
if (isset($_GET['delid'])) {
	$sql = "DELETE FROM billing_records WHERE billingid='$_GET[delid]'";
	$qsql = mysqli_query($con, $sql);
	if (mysqli_affected_rows($con) == 1) {
		echo "<script>alert('billing record deleted successfully..');</script>";
	}
}
?>
<section class="container">
    <?php
    // Fetch billing information based on appointment ID
    $billappointmentid = $_GET['appointmentid'] ?? $rsappointment[0] ?? null;

    if ($billappointmentid) {
        $sqlbilling_records = "SELECT * FROM billing WHERE appointmentid='$billappointmentid'";
        $qsqlbilling_records = mysqli_query($con, $sqlbilling_records);
        $rsbilling_records = mysqli_fetch_array($qsqlbilling_records);

        if ($rsbilling_records) {
            ?>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th scope="col">
                            <div align="right">Bill number &nbsp;</div>
                        </th>
                        <td><?php echo '#HMS_' . $rsbilling_records['billingid']; ?></td>
                    </tr>
                    <tr>
                        <th width="124" scope="col">
                            <div align="right">Appointment Number &nbsp;</div>
                        </th>
                        <td width="413"><?php echo $rsbilling_records['appointmentid']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <div align="right">Billing Date &nbsp;</div>
                        </th>
                        <td>&nbsp;<?php echo $rsbilling_records['billingdate']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <div align="right">Billing Time &nbsp;</div>
                        </th>
                        <td>&nbsp;<?php echo $rsbilling_records['billingtime']; ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="97" scope="col">Date</th>
                        <th width="245" scope="col">Description</th>
                        <th width="86" scope="col">Bill Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch billing records for this billing ID
                    $sql = "SELECT * FROM billing_records WHERE billingid='{$rsbilling_records['billingid']}'";
                    $qsql = mysqli_query($con, $sql);
                    $billamt = 0;

                    while ($rs = mysqli_fetch_array($qsql)) {
                        echo "<tr>
                                <td>&nbsp;{$rs['bill_date']}</td>
                                <td>&nbsp;{$rs['bill_type']}";

                        // Add specific details for bill types
                        if ($rs['bill_type'] == "Consultancy Charge") {
                            $sqldoctor = "SELECT * FROM doctor WHERE doctorid='{$rs['bill_type_id']}'";
                            $qsqldoctor = mysqli_query($con, $sqldoctor);
                            $rsdoctor = mysqli_fetch_array($qsqldoctor);
                            echo " - Dr. " . $rsdoctor['doctorname'];
                        }

                        if ($rs['bill_type'] == "Treatment Cost") {
                            $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='{$rs['bill_type_id']}'";
                            $qsqltreatment = mysqli_query($con, $sqltreatment);
                            $rstreatment = mysqli_fetch_array($qsqltreatment);
                            echo " - " . $rstreatment['treatmenttype'];
                        }

                        if ($rs['bill_type'] == "Prescription charge") {
                            $sqlprescription = "SELECT * FROM prescription WHERE prescriptionid='{$rs['bill_type_id']}'";
                            $qsqlprescription = mysqli_query($con, $sqlprescription);
                            $rsprescription = mysqli_fetch_array($qsqlprescription);

                            $sqltreatment_records = "SELECT * FROM treatment_records WHERE treatment_records_id='{$rsprescription['treatment_records_id']}'";
                            $qsqltreatment_records = mysqli_query($con, $sqltreatment_records);
                            $rstreatment_records = mysqli_fetch_array($qsqltreatment_records);

                            $sqltreatment = "SELECT * FROM treatment WHERE treatmentid='{$rstreatment_records['treatmentid']}'";
                            $qsqltreatment = mysqli_query($con, $sqltreatment);
                            $rstreatment = mysqli_fetch_array($qsqltreatment);
                            echo " - " . $rstreatment['treatmenttype'];
                        }

                        echo "</td><td>&nbsp;£ {$rs['bill_amount']}</td></tr>";
                        $billamt += $rs['bill_amount'];
                    }
                    ?>
                </tbody>
            </table>

            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th scope="col">
                            <div align="right">Bill Amount &nbsp;</div>
                        </th>
                        <td>&nbsp;£ <?php echo $billamt; ?></td>
                    </tr>
                    <tr>
                        <th width="442" scope="col">
                            <div align="right">Tax Amount (5%) &nbsp;</div>
                        </th>
                        <td width="95">&nbsp;£ <?php echo $taxamt = 0.05 * $billamt; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <div align="right">Discount &nbsp;</div>
                        </th>
                        <td>&nbsp;£ <?php echo $rsbilling_records['discount']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">
                            <div align="right">Grand Total &nbsp;</div>
                        </th>
                        <td>&nbsp;£ <?php echo ($billamt + $taxamt) - $rsbilling_records['discount']; ?></td>
                    </tr>
                </tbody>
            </table>
            <?php
        } else {
            echo "<p>No billing information found for this appointment.</p>";
        }
    } else {
        echo "<p>Invalid appointment ID.</p>";
    }
    ?>
</section>
