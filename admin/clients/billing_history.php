<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *, concat(lastname, ', ', firstname,' ', coalesce(middlename,'')) as `name` FROM client_list where id = '{$_GET['id']}' and delete_flag = 0");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
        echo '<script> alert("Client ID is invalid."); location.replace("./?page=clients");</script>';
    }
}else{
    echo '<script> alert("Client ID is required."); location.replace("./?page=clients");</script>';
}

// Display full name in the format "firstname lastname"
$fullname = $firstname . " " . $lastname;

?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b><?= isset($code) ? $code : '' ?> - <?= isset($name) ? $name : '' ?></b></h3>
</div>
<style>
	img#cimg{
      max-height: 15em;
      object-fit: scale-down;
    }
</style>
<div class="row justify-content-center" style="margin-top:-2em;">
	<div class="col-lg-10 col-md-11 col-sm-11 col-xs-11">
		<div class="card rounded-0 shadow">
            <div class="card-header">
                <h5 class="card-title">Client Billing History</h5>
            </div>
			<div class="card-body">
				<div class="container-fluid">
                    <!-- <table class="table table-hover table-striped table-bordered" id="list">
                        <colgroup>
                            <col width="5%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reading Date</th>
                                <th>Due Date</th>
                                <th>Current Reading</th>
                                <th>Previous Reading</th>
                                <th>Consumption</th>
                                <th>Rate (m<sup>3</sup>)</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($id)): ?>
                            <?php 
                            $i = 1;
                                $qry = $conn->query("SELECT b.*, c.code , concat(c.lastname, ', ', c.firstname, ' ', coalesce(c.middlename,'')) as `name` from `billing_list` b inner join client_list c on b.client_id = c.id where c.id = '{$id}' order by unix_timestamp(`reading_date`) desc, `name` asc ");
                                while($row = $qry->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td><?php echo date("Y-m-d",strtotime($row['reading_date'])) ?></td>
                                    <td><?php echo date("Y-m-d",strtotime($row['due_date'])) ?></td>
                                    <td class="text-right"><?= number_format($row['reading']) ?></td>
                                    <td class="text-right"><?= number_format($row['previous']) ?></td>
                                    <td class="text-right"><?php echo format_num($row['reading'] - $row['previous']) ?></td>
                                    <td class="text-right"><?= format_num($row['rate']) ?></td>
                                    <td class="text-center">
                                        <?php
                                        switch($row['status']){
                                            case 0:
                                                echo '<span class="badge badge-secondary  bg-gradient-secondary  text-sm px-3 rounded-pill">Pending</span>';
                                                break;
                                            case 1:
                                                echo '<span class="badge badge-success bg-gradient-success text-sm px-3 rounded-pill">Paid</span>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-right"><?php echo format_num($row['total']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table> -->
                    <?php
global $fullname;
// Assuming $conn is your database connection object
//db connection 
$host = 'localhost'; // Your database host
$dbname = 'wbms_db'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create a new mysqli instance
//port:3306
$dbConnection = new mysqli($host, $username, $password, $dbname, 3306);

// Check connection
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Assuming $fullname holds the full name you want to search for
// Replace with the actual full name

// Fetch data from pending_bills where name matches $fullname
$sql = "SELECT id, name, unit, amount, billdate, paymentdate, paidflag, transaction FROM pending_bills WHERE name = '$fullname'";
$result = $dbConnection->query($sql);

// Check if there are any matching records
if ($result->num_rows > 0) {
    // Initialize serial number
    $serial = 1;
    // Display data in a table
    echo "<table style='text-align:center;' class='table table-hover table-striped table-bordered' id='list'>";
    echo "<thead><tr ><th>#</th><th>Name</th><th>Unit</th><th>Amount</th><th>Bill Date</th><th>Payment Date</th><th>Transaction ID</th><th>Status</th></tr></thead>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        // Display serial number
        echo "<td>" . $serial . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['unit'] . "</td>";
        echo "<td>₹ " . $row['amount'] . "</td>";
        echo "<td>" . $row['billdate'] . "</td>";
       // Check if payment date is null
       if ($row['paymentdate'] === null) {
        echo "<td>--</td>";
    } else {
        echo "<td>" . $row['paymentdate'] . "</td>";
    }
    
    // Check if transaction is null
    if ($row['transaction'] === null) {
        echo "<td>--</td>";
    } else {
        echo "<td>" . $row['transaction'] . "</td>";
    }
        echo "<td style='text-align:center;'>";

        // Display badge based on paidflag value
        if ($row['paidflag'] == 0) {
            echo "<span class='badge badge-secondary bg-gradient-secondary text-sm px-3 rounded-pill'>Pending</span>";
        } else {
            echo "<span class='badge badge-success bg-gradient-success text-sm px-3 rounded-pill'>Paid</span>";
        }

        echo "</td>";
        echo "</tr>";
        // Increment serial number
        $serial++;
    }
    echo "</table>";
} else {
    echo "No bills found.";
}
?>


				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=clients/view_client&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-angle-left"></i> Back </a>
			</div>
		</div>
	</div>
</div>
<script>
	
	$(document).ready(function(){
        $('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
	})
    
</script>