<!doctype html>
                        <html>
                            <head>
                                <meta charset='utf-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1'>
                                <title>Payment Gateway</title>
                                <link rel="icon" type="image/png" href="logo.png">
                                
                                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
                                <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
                                <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                                <style>::-webkit-scrollbar {
                                  width: 8px;
                                }
                                /* Track */
                                ::-webkit-scrollbar-track {
                                  background: #f1f1f1; 
                                }
                                 
                                /* Handle */
                                ::-webkit-scrollbar-thumb {
                                  background: #888; 
                                }
                                
                                /* Handle on hover */
                                ::-webkit-scrollbar-thumb:hover {
                                  background: #555; 
                                } 
                                body {
                                  height: auto;
                                  justify-content: center;                             
                                  align-items: center;
                                  display: flex;
                                  background-color: #eee;
                                  padding:20px;
                                  overflow: hidden;
                                  }

                                   .launch {
                                       height: 50px;
                                   }

                                   .close {                                 
                                     font-size: 21px;
                                     cursor: pointer;
                                   }

  .modal-body {
      height: auto;
  }

  .nav-tabs {
      border: none !important;
  }

  .nav-tabs .nav-link.active {
      color: #495057;
      background-color: #fff;
      border-color: #ffffff #ffffff #fff;
      border-top: 3px solid blue !important;
  }

  .nav-tabs .nav-link {
      margin-bottom: -1px;
      border: 1px solid transparent;
      border-top-left-radius: 0rem;
      border-top-right-radius: 0rem;
      border-top: 3px solid #eee;
      font-size: 20px;
  }

  .nav-tabs .nav-link:hover {
      border-color: #e9ecef #ffffff #ffffff;
  }

  .nav-tabs {
      display: table !important;
      width: 100%;
  }

  .nav-item {
      display: table-cell;
  }

  .form-control {
      border-bottom: 1px solid #eee !important;
      border: none;
      font-weight: 600;
  }

  .form-control:focus {
      color: #495057;
      background-color: #fff;
      border-color: #8bbafe;
      outline: 0;
      box-shadow: none;
  }

  .inputbox {
      position: relative;
      margin-bottom: 20px;
      width: 100%;
  }

  .inputbox span {
      position: absolute;
      top: 7px;
      left: 11px;
      transition: 0.5s;
  }

  .inputbox i {
      position: absolute;
      top: 13px;
      right: 8px;
      transition: 0.5s;
      color: #3F51B5;
  }

  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }

  .inputbox input:focus~span {
      transform: translateX(-0px) translateY(-15px);
      font-size: 12px;
  }

  .inputbox input:valid~span {
      transform: translateX(-0px) translateY(-15px);
      font-size: 12px;
  }

  .pay button {
      height: 47px;
      border-radius: 37px;
  }

  .modal-dialog {
      min-width: 500px;
  }
  </style>
                                </head>
                                <body className='snippet-body'>
                                <?php
                                  // Retrieve the id value from the URL
                                  $id = $_GET['id'];
                                  
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
                                  
                                  // Prepare and execute a query to fetch data from pending_bills based on the id
                                  $sql = "SELECT * FROM pending_bills WHERE id = ?";
                                  $stmt = $dbConnection->prepare($sql);
                                  $stmt->bind_param("i", $id);
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  
                                  // Check if there are any matching records
                                  if ($result->num_rows > 0) {
                                      // Fetch and display data
                                      while ($row = $result->fetch_assoc()) {
                                        $billDate = date("F d, Y", strtotime($row['billdate']));
                                        $meter_code = $row['meter_code'];
                                        $sql_contact = "SELECT contact FROM client_list WHERE meter_code = ?";
                                        $stmt_contact = $dbConnection->prepare($sql_contact);
                                        $stmt_contact->bind_param("s", $meter_code);
                                        $stmt_contact->execute();
                                        $result_contact = $stmt_contact->get_result();
                                
                                        // Check if contact information is found
                                        if ($result_contact->num_rows > 0) {
                                            $contact_row = $result_contact->fetch_assoc();
                                            $phoneNumber = $contact_row['contact'];
                                        } else {
                                            $phoneNumber = ""; // Set to empty string if contact information is not found
                                        }
                                      }
                                    } else {
                                        echo "No record found for the provided ID.";
                                    }
                                    
                                    $stmt->close();
                                    $dbConnection->close();
                                        ?>

                                <!-- <button type="button" class="btn btn-primary launch" data-toggle="modal" data-target="#staticBackdrop"> <i class="fa fa-rocket"></i> Pay Now</button> -->
<!-- Modal -->
<div> 
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <div class="modal-body"> 
        <div class="text-right"> 
        <i class="fa fa-close close" data-dismiss="modal" onclick="confirmRedirect('<?php global $phoneNumber; echo $phoneNumber; ?>')"></i>
      
<script>
function confirmRedirect(phoneNumber) {
    // Ask for confirmation
    var confirmation = confirm("Are you sure you want to close?");

    // If user confirms, redirect
    if (confirmation) {
        window.location.href = "http://localhost/entc_wbms/admin/?page=monthlybill&phone_number=" + phoneNumber;
    }
}
</script>

        </div> 
        <h4>Billing Summary</h4>
        <?php
                                  // Retrieve the id value from the URL
                                  $id = $_GET['id'];
                                  
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
                                  
                                  // Prepare and execute a query to fetch data from pending_bills based on the id
                                  $sql = "SELECT * FROM pending_bills WHERE id = ?";
                                  $stmt = $dbConnection->prepare($sql);
                                  $stmt->bind_param("i", $id);
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  
                                  // Check if there are any matching records
                                  if ($result->num_rows > 0) {
                                      // Fetch and display data
                                      while ($row = $result->fetch_assoc()) {
                                        $billDate = date("F d, Y", strtotime($row['billdate']));
                                        $meter_code = $row['meter_code'];
                                        $sql_contact = "SELECT contact FROM client_list WHERE meter_code = ?";
                                        $stmt_contact = $dbConnection->prepare($sql_contact);
                                        $stmt_contact->bind_param("s", $meter_code);
                                        $stmt_contact->execute();
                                        $result_contact = $stmt_contact->get_result();
                                
                                        // Check if contact information is found
                                        if ($result_contact->num_rows > 0) {
                                            $contact_row = $result_contact->fetch_assoc();
                                            $phoneNumber = $contact_row['contact'];
                                        } else {
                                            $phoneNumber = ""; // Set to empty string if contact information is not found
                                        }
                                        echo "<hr>";
                                        echo "<div style='padding:10px 10px;'>";
                                          echo "<p><b> Client Name: " . $row['name'] . "</b></p> ";
                                          echo "<div style='display: flex; justify-content: space-between;'>";
                                          echo "<p>Meter Reading: " . $row['unit'] . " units </p>";
                                          echo "<p>Meter Code: " . $row['meter_code'] . "</p>";
                                          echo "</div>";
                                          echo "<p>Bill Date: " . $billDate . "</p>";
                                          echo "<div style='display: flex; justify-content: space-between;'>";
                                          echo "<h5><b>Total Amount</b></h5> ";
                                          echo "<h5><b>₹ " . $row['amount'] . "</b></h5> ";
                                          echo "</div>";
                                          echo "</div>";
                                          // Display other fields as needed
                                      }
                                  } else {
                                      echo "No record found for the provided ID.";
                                  }
                                  
                                  $stmt->close();
                                  $dbConnection->close();

                
// PHP code to handle form submission
if (isset($_POST['payButton'])) {
    // Your existing PHP code to generate transaction ID, update database, etc.
    function generateTransactionID() {
        // Get current timestamp
        $timestamp = time();

        // Generate a random number with at least 6 digits
        $random = mt_rand(100000, 999999);

        // Concatenate timestamp and random number
        $transactionID = $timestamp . $random;

        // Ensure the transaction ID is exactly 12 digits long
        if(strlen($transactionID) > 12) {
            $transactionID = substr($transactionID, 0, 12);
        } elseif(strlen($transactionID) < 12) {
            $transactionID .= str_repeat('0', 12 - strlen($transactionID));
        }

        return $transactionID;
    }
   
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the id value from the POST request
        $id = $_GET['id'];
      
        // Get today's date in yyyy-mm-dd format
        $paymentDate = date('Y-m-d');

        // Assuming $conn is your database connection object
        // db connection
        $host = 'localhost'; // Your database host
        $dbname = 'wbms_db'; // Your database name
        $username = 'root'; // Your database username
        $password = ''; // Your database password
        
        // Create a new mysqli instance
        // port:3306
        $dbConnection = new mysqli($host, $username, $password, $dbname, 3306);
        
        // Check connection
        if ($dbConnection->connect_error) {
            die("Connection failed: " . $dbConnection->connect_error);
        }

        // Generate transaction ID
        $transactionID = generateTransactionID();
        
        // Prepare and execute a query to update the paidflag to 1, set the transaction column to $transactionID, and set the paymentdate to today's date for the record with the provided ID
        $sql = "UPDATE pending_bills SET paidflag = 1, transaction = ?, paymentdate = ? WHERE id = ?";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bind_param("ssi", $transactionID, $paymentDate, $id); // "ssi" indicates that the parameters are string, string, and integer respectively
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
          // Payment successful alert
          echo "<script>alert('Payment done successfully.');</script>";

          
          // Redirect to the specified URL
          echo "<script>window.location.href = 'http://localhost/entc_wbms/admin/?page=monthlybill&phone_number=$phoneNumber';</script>";
      } else {
          echo "No record found for the provided ID.";
      }
        $stmt->close();
        $dbConnection->close();
    }
}
?>




        <div class="tabs mt-3"> 
          <ul class="nav nav-tabs" id="myTab" role="tablist"> 
            <li class="nav-item" role="presentation"> 
              <a class="nav-link active" id="visa-tab" data-toggle="tab" href="#visa" role="tab" aria-controls="visa" aria-selected="true">
                 <img src="https://i.imgur.com/sB4jftM.png" width="80"> </a> 
            </li> 
            <li class="nav-item" role="presentation"> 
              <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false"> 
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/UPI-Logo-vector.svg/2560px-UPI-Logo-vector.svg.png" width="80"> </a> 
            </li> 
          </ul> 
          <div class="tab-content" id="myTabContent"> 
            <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab"> 
              <div class="mt-4 mx-4"> 
                <div class="text-center">
                 <h5>Debit / Credit Card</h5> 
                </div> 
                <div class="form mt-3"> 
                  <div class="inputbox"> 
                  <form method="POST" action="">
                    <input type="text" name="name" class="form-control" required="required"> 
                    <span>CardHolder Name</span> </div> <div class="inputbox"> 
                      <input type="text" name="name" min="1" max="999" class="form-control" required="required"> 
                      <span>Card Number</span> 
                      <!--<i class="fa fa-eye"></i>-->
                     </div> 
                      <div class="d-flex flex-row">
                         <div class="inputbox"> 
                          <input type="text" name="name" min="1" max="999" class="form-control" required="required"> 
                         <span>Expiration Date</span> </div> <div class="inputbox"> 
                          <input type="text" name="name" min="1" max="999" class="form-control" required="required"> 
                          <span>CVV</span>
                          <input type="hidden" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>"> 
                        </div> 
                      </div> 
                      <div class="px-5 pay"> 
                        <button type="submit" name="payButton" class="btn btn-success btn-block">Pay</button> 
                        </form>
                      </div> 
                    </div> 
                  </div> 
                </div> 

                <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab"> 
                  
                  <div class="px-5 mt-5">
                  <div class="text-center">
                 <h5>UPI Payment</h5> 
                </div> 
                     <div class="inputbox"> 
                     <form method="POST" action="">
                      <input type="text" name="name" class="form-control" required="required"> 
                      <span>UPI ID or number</span> </div> <div class="pay px-5"> 
                      <input type="hidden" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">
                      <!-- Other form elements -->
                      <button type="submit" name="payButton" class="btn btn-primary btn-block">Pay</button>
                        </form>
                       

                      </div> 
                    </div> 
                  </div> 
                </div> 
              </div> 
            </div>
           </div>
           </div>
</div>


<script>
function confirmRedirect(phoneNumber) {
    // Ask for confirmation
    var confirmation = confirm("Are you sure you want to close?");

    // If user confirms, redirect
    if (confirmation) {
        window.location.href = "http://localhost/entc_wbms/admin/?page=monthlybill&phone_number=" + phoneNumber;
    }
}
</script>
                                <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
                                
                                <script type='text/javascript'></script>
                                <script type='text/javascript'>var myLink = document.querySelector('a[href="#"]');
                                myLink.addEventListener('click', function(e) {
                                  e.preventDefault();
                                });</script>
                            
                                </body>
                            </html>