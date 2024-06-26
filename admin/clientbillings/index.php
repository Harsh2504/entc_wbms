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
              </small> <br><small>Meter Code :
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
                  class="nav-link nav-clients active bg-gradient-primary">
                  <i class="nav-icon fas fa-th-list"></i>
                  <p>
                    Daily Usage
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="http://localhost/entc_wbms/admin/?page=monthlybill&phone_number=<?php echo urlencode($phone_number); ?>"
                  class="nav-link nav-billings ">
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
      <h3 class="card-title">List of Bill</h3>
      <div id="dataContainer">
        <!-- Data table will be displayed here -->
        <?php

        function getLastEntriesWithDay30($feeds)
        {
          $lastEntries = array();

          // Organize feeds by month
          foreach ($feeds as $feed) {
            $createdAt = strtotime($feed['created_at']);
            $day = date('d', $createdAt);
            $month = date('m', $createdAt);
            $year = date('Y', $createdAt);
            $lastDayOfMonth = date('t', mktime(0, 0, 0, $month, 1, $year)); // Get the last day of the month
        
            if ($day == $lastDayOfMonth) {
              // Store the entry only if it was created on the last day of the month
              $lastEntries[$month] = array(
                'created_at' => $feed['created_at'],
                'entry_id' => $feed['entry_id'],
                'field1' => $feed['field1'],
                'field2' => $feed['field2'],
                'field3' => $feed['field3']
              );
            }
          }

          // Select the last entry for each month
          $lastEntriesByMonth = array();
          foreach ($lastEntries as $month => $entry) {
            $lastEntriesByMonth[$month] = $entry;
          }

          return $lastEntriesByMonth;
        }

        function insertLastEntriesToPendingBills($lastEntries, $dbConnection) {
          global $fullname, $meter_code;
          foreach ($lastEntries as $entry) {
              // Extracting necessary values from the entry
              $createdAt = substr($entry['created_at'], 0, 10);
              $unit = (int)$entry['field2'];
              $amount = calculateWaterCost($unit);
              $billDate = date('Y-m-d', strtotime($createdAt));
              $dueDate = date('Y-m-d', strtotime($createdAt . ' +5 days'));
              $paymentDate = null;
              $entryId = $entry['entry_id'];
      
              // Check if the entry already exists in the database based on name and bill date
              $stmt = $dbConnection->prepare("SELECT COUNT(*) FROM pending_bills WHERE name = ? AND billdate = ?");
              $stmt->bind_param("ss", $fullname, $billDate);
              $stmt->execute();
              $stmt->bind_result($count);
              $stmt->fetch();
              $stmt->close();
      
              // If no matching records are found, proceed with insertion
              if ($count == 0) {
                // Insert data into database
                $stmt = $dbConnection->prepare("INSERT INTO pending_bills (name, meter_code, unit, amount, billdate, dueDate, paymentdate, paidflag) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
                $stmt->bind_param("ssdssss", $fullname, $meter_code, $unit, $amount, $billDate, $dueDate, $paymentDate);
                $stmt->execute();
                $stmt->close();
            }
            
          }
      }
      
      
      
      
            
      
      
      
      

        // function getLastEntriesWithDay30($feeds)
        // {
        // 	$lastEntries = array();
        
        // 	// Organize feeds by month
        // 	foreach ($feeds as $feed) {
        // 		$createdAt = strtotime($feed['created_at']);
        // 		$day = date('d', $createdAt);
        // 		$month = date('m', $createdAt);
        // 		$year = date('Y', $createdAt);
        
        // 		if ($day == 30) {
        // 			$lastEntries[$month] = array(
        // 				'created_at' => $feed['created_at'],
        // 				'entry_id' => $feed['entry_id'],
        // 				'field1' => $feed['field1'],
        // 				'field2' => $feed['field2'],
        // 				'field3' => $feed['field3']
        // 			);
        // 		}
        // 	}
        
        // 	// Select the last entry for each month
        // 	$lastEntriesByMonth = array();
        // 	foreach ($lastEntries as $month => $entry) {
        // 		$lastEntriesByMonth[$month] = $entry;
        // 	}
        
        // 	return $lastEntriesByMonth;
        // }
        


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



        function fetchData()
        {

          global $dbConnection;

          $channelID = '2416103';
          $apiKey = '9Y9MIRGXAAE1BY94';
          $feedUrl = "https://api.thingspeak.com/channels/{$channelID}/feeds.json?api_key={$apiKey}";

          $response = file_get_contents($feedUrl);
          $data = json_decode($response, true);

          $jsonData = json_encode($data, JSON_HEX_APOS);
          $lastEntriesWithDay30 = getLastEntriesWithDay30($data['feeds']);

          insertLastEntriesToPendingBills($lastEntriesWithDay30, $dbConnection);
          $vsy = calculateWaterCost($lastEntriesWithDay30['02']['field2']);
     
          echo "<script>";
          echo "console.log(`total data`);";
          echo "console.log(" . json_encode($data) . ");";
          echo "console.log('Last entries with day 30 for each month: ');";
          echo "console.log(" . json_encode($lastEntriesWithDay30) . ");";
          echo "console.log(`its charges`);";
          echo "console.log(" . json_encode($vsy) . ");";
          echo "</script>";

          echo "<script>";
          echo "document.addEventListener('DOMContentLoaded', function() {";
          echo "    var userChargesDiv = document.querySelector('.usercharges');";
          echo "    if (userChargesDiv) {";  // Check if userChargesDiv is not null
          echo "        userChargesDiv.innerHTML += '<br><strong>Date:</strong><br>';";
          echo "        userChargesDiv.innerHTML += " . json_encode($lastEntriesWithDay30['01']['created_at'], JSON_PRETTY_PRINT) . ";";
          echo "        userChargesDiv.innerHTML += '<br><strong>Charges:</strong><br>';";
          echo "        userChargesDiv.innerHTML += " . json_encode($vsy, JSON_PRETTY_PRINT) . ";";
          echo "    } else {";
          echo "        console.error('Element with class name \"usercharges\" not found.');";
          echo "    }";
          echo "});";
          echo "</script>";



          displayStats($data['channel'], $data['feeds']);
        }

        function displayStats($channelData, $feeds)
        {
       
          echo "
      <div>
	  <br>
	  <br>
       
        <p><b>Last entry:</b> " . date('Y-m-d H:i:s', strtotime($channelData['updated_at'])) . "</p>
        <p><b>Entries:</b>  {$channelData['last_entry_id']}</p>
      </div>
    ";

          // Create a Bootstrap table
          echo "
      <table class='table mt-4'>
        <thead>
          <tr>
            <th>#</th>
            <th>Bill</th>
            <th>Units</th>
            <th>Amount</th>
            <th>Date & Time</th>
          </tr>
        </thead>
        <tbody>
    ";

          foreach ($feeds as $feed) {
            echo createTableRow($feed);
          }

          echo "
        </tbody>
      </table>
    ";
        }

        function formatIndianCurrency($value)
        {
          $formattedValue = number_format($value);
          return "₹{$formattedValue}";
        }

        function calculateWaterCost($field2Value)
        {
            // Convert field2Value to float
            $waterConsumption = floatval($field2Value);
            
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


            
            // Prepare and execute a query to fetch the rate from system_info
            $sql = "SELECT meta_value FROM system_info WHERE meta_field = ?";
            $stmt = $dbConnection->prepare($sql);
            $rateField = "rate"; // Assuming the field value for rate is "rate"
            $stmt->bind_param("s", $rateField);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Check if there is a result
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $rate = floatval($row['meta_value']); // Convert rate to float
            } else {
                // Default rate if no value found
                $rate = 0.10; // Set a default rate
            }
            
            // Close database connection
            $stmt->close();
            $dbConnection->close();
        
            // Calculate water cost using the fetched rate
            $waterCost = $waterConsumption * $rate;
        
            // Echo the rate value
           // echo "Current rate: " . $rate . "<br>";
        
            return $waterCost;
        }
        


        function createTableRow($feed)
        {
          $createdAt = date('Y-m-d H:i:s', strtotime($feed['created_at']));
          $field2Value = isset($feed['field2']) ? trim($feed['field2']) : '';
          $waterCost = calculateWaterCost($field2Value);
          $formattedWaterCost = formatIndianCurrency($waterCost);

          return "
      <tr>
        <td>{$feed['entry_id']}</td>
        <td>{$feed['field1']}</td>
        <td>{$field2Value}</td>
        <td>{$formattedWaterCost}</td>
        <td>{$createdAt}</td>
      </tr>
    ";
        }
        global $check_status;
        // Call fetchData when the page loads
        if ($check_status == 1) {
        fetchData();
        }
        else {
          echo "<br><br><div class='alert alert-dark' style='text-align:center;' role='alert'>
          Your water connection has been disabled. Please pay all pending dues. If already paid, please contact the administrator.
          </div>";
      }
        ?>
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