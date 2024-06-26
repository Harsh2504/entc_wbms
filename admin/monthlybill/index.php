<?php


if (isset($_GET['phone_number'])) {
  $phone_number = $_GET['phone_number'];
} else {
  header("Location: error404.php");
  exit;
}


?>
<?php
// Assuming $conn is your database connection object

// Escape the contact number to prevent SQL injection
$contact = $conn->real_escape_string($phone_number);

// Construct the SQL query
$sql = "SELECT * FROM client_list WHERE contact = '$contact'";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
  // Fetch the result as an associative array
  $row = $result->fetch_assoc();

  // Check if any rows were returned
  if ($row) {
    // Retrieve firstname and lastname from the result
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];

    $fullname = $firstname . " " . $lastname;
    $meter_code = $row['meter_code'];
    $check_status = $row['status'];
    if ($check_status == 1) {
      $status = '<span class="badge badge-primary bg-gradient-primary text-sm px-2 py-1 rounded-pill">Active</span>';
    } else {
      $status = '<span class="badge badge-danger bg-gradient-danger text-sm px-2 py-1 rounded-pill">Inactive</span>';
    }
  } else {
    echo "No matching records found.";
  }
} else {
  // Query execution failed, handle the error
  echo "Error executing query: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
<?php if ($_settings->chk_flashdata('success')): ?>
  <script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
  </script>
<?php endif; ?>

<nav class="main-header navbar navbar-expand navbar-light shadow text-sm">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="http://localhost/entc_wbms/admin/clientlogin.php" class="nav-link">Water Billing Management System -
        Client</a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <!-- <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
              <form class="form-inline">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li> -->
    <!-- Messages Dropdown Menu -->

    <!--  <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
            </a>
          </li> -->
  </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="http://localhost/entc_wbms/admin" class="brand-link bg-gradient-primary text-sm">
    <img src="http://localhost/entc_wbms/uploads/logo.png?v=1651282049" alt="Store Logo"
      class="brand-image img-circle elevation-3 bg-gradient-light"
      style="opacity: .8;width: 1.5rem;height: 1.5rem;max-height: unset">
    <span class="brand-text font-weight-light">WBMS - PHP</span>

  </a>
  <!-- Sidebar -->
  <div
    class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <div class="clientname brand-text"
              style="color:#ccd0d7; text-align:center; padding:10px; font-size:15px; font-weight:bold;">
              Welcome,
              <?php echo $fullname; ?>
              <br><small>Contact :
                <?php echo $contact; ?>
              </small><br><small>Meter Code :
                <?php echo $meter_code; ?>
              </small>
              <br><small>Status :
                <?php echo $status; ?>
              </small>
          
            </div>
            <ul
              class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child"
              data-widget="treeview" role="menu" data-accordion="false">

              <li class="nav-header">Main</li>
              <li class="nav-item dropdown">
                <a href="http://localhost/entc_wbms/admin/?page=clientbillings&phone_number=<?php echo urlencode($phone_number); ?>"
                  class="nav-link nav-clients">
                  <i class="nav-icon fas fa-th-list"></i>
                  <p>
                    Daily Usage
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="http://localhost/entc_wbms/admin/?page=monthlybill&phone_number=<?php echo urlencode($phone_number); ?>"
                  class="nav-link nav-billings active bg-gradient-primary">
                  <i class="nav-icon fas fa-file-invoice"></i>
                  <p>
                    Monthly Bill
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="http://localhost/entc_wbms/admin/clientlogin.php" class="nav-link nav-billings ">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                    Logout
                  </p>
                </a>
              </li>
              <!-- <li class="nav-header">Reports</li>
                    <li class="nav-item dropdown">
                      <a href="http://localhost/entc_wbms/admin/?page=reports/monthly_billing" class="nav-link nav-reports_monthly_billing">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                          Monthly Report
                        </p>
                      </a>
                    </li>
                                        <li class="nav-header">Maintenance</li>
                    <li class="nav-item dropdown">
                      <a href="http://localhost/entc_wbms/admin/?page=category" class="nav-link nav-category">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                          List of Category
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="http://localhost/entc_wbms/admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="http://localhost/entc_wbms/admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                          Settings
                        </p>
                      </a>
                    </li> -->
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar-corner"></div>
  </div>
  <!-- /.sidebar -->
</aside>
<div class="card card-outline rounded-0 card-navy">
  <div class="card-header">
    <div class="card-header">
      <h3 class="card-title">Bill Payments</h3>

      <br>
      <br>
      <!-- <div class="usercharges">

      </div> -->
      <div class="bills">
      <?php
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

// Fetch data from pending_bills for a specific fullname where paidflag is 0
$sql = "SELECT id, name, unit, amount, billdate, dueDate FROM pending_bills WHERE name = ? AND paidflag = 0";
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("s", $fullname);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Check if there are any matching records
if ($result->num_rows > 0) {
    // Display data in a table
    $serial = 1;
    echo "<table  class='table mt-4 ' id='list'> ";
    echo "<thead><tr><th>#</th><th>Name</th><th>Unit</th><th>Amount</th><th>Bill Date</th><th>Due Date</th><th> </th></tr></thead>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $serial . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['unit'] . "</td>";
        echo "<td>₹ " . $row['amount'] . "</td>";
        echo "<td>" . $row['billdate'] . "</td>";
        echo "<td>" . $row['dueDate'] . "</td>";
        // Adding pay button with a form to pass ID
        echo "<td>";
        echo "<form id='paymentForm_" . $row['id'] . "' method='POST' action='http://localhost/entc_wbms/admin/monthlybill/payment.php?id=" . $row['id'] . "'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "' />";
        echo "<button type='submit' class='btn btn-outline-success'><i class='fa fa-rocket'></i> Pay</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
        $serial++;
    }
    echo "</table>";
} else {
    echo "No pending bills found for $fullname.";
}
?>


      </div>
      
      <div>

   
      </div>
    </div>

  </div>

</div>
<!-- Harsh -->
<div class="card card-outline rounded-0 card-navy">
  <div class="card-header">
    <div class="card-header">
      <h3 class="card-title">Payment History</h3>
      <br>
      <br>
      <div class="bills">
      <?php
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

// Fetch data from pending_bills for a specific fullname where paidflag is 0
$sql = "SELECT id, name, unit, amount, billdate, dueDate, paymentdate FROM pending_bills WHERE name = ? AND paidflag = 1";
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("s", $fullname);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$serial = 1;
// Check if there are any matching records
if ($result->num_rows > 0) {
    // Display data in a table
    echo "<table  class='table mt-4 dataTable'>";
    echo "<tr><th>#</th><th>Name</th><th>Unit</th><th>Amount</th><th>Bill Date</th><th>Payment Date</th><th>Receipt </th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $serial . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['unit'] . "</td>";
        echo "<td>₹ " . $row['amount'] . "</td>";
        echo "<td>" . $row['billdate'] . "</td>";
        echo "<td>" . $row['paymentdate'] . "</td>";
        // Adding pay button with a form to pass ID
        echo "<td>";
        echo "<form id='paymentForm_" . $row['id'] . "' method='POST' action='http://localhost/entc_wbms/admin/monthlybill/payment_history.php?id=" . $row['id'] . "'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "' />";
        echo "<button type='submit' class='btn btn-outline-primary'><i class='fa fa-eye'></i> View</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
        $serial++;
    }
    echo "</table>";
} else {
    echo "No bills paid yet. Please pay the pending dues as soon as possible.";
}
?>


      </div>
      
      <div>

   
      </div>
    </div>

  </div>

</div>
<div>

</div>

<script>
  $(document).ready(function () {
    $('.delete_data').click(function () {
      _conf("Are you sure to delete this billing permanently?", "delete_billing", [$(this).attr('data-id')])
    })
    $('.table').dataTable({
      columnDefs: [
        { orderable: false, targets: [4] }
      ],
      order: [0, 'asc']
    });
    $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
  })
  function delete_billing($id) {
    start_loader();
    $.ajax({
      url: _base_url_ + "classes/Master.php?f=delete_billing",
      method: "POST",
      data: { id: $id },
      dataType: "json",
      error: err => {
        console.log(err)
        alert_toast("An error occured.", 'error');
        end_loader();
      },
      success: function (resp) {
        if (typeof resp == 'object' && resp.status == 'success') {
          location.reload();
        } else {
          alert_toast("An error occured.", 'error');
          end_loader();
        }
      }
    })
  }
</script>