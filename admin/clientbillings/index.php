<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>


<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Bill</h3>
		<div class="card-tools">
			<a href="./?page=billings/manage_billing" id="create_new" class="btn btn-flat btn-primary"><span
					class="fas fa-plus"></span> Create New</a>
		</div>
	</div>

	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="25%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Reading Date</th>
						<th>Client</th>
						<th>Amount</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT b.*, c.code , concat(c.lastname, ', ', c.firstname, ' ', coalesce(c.middlename,'')) as `name` from `billing_list` b inner join client_list c on b.client_id = c.id order by unix_timestamp(`reading_date`) desc, `name` asc ");
					while ($row = $qry->fetch_assoc()):
						?>
						<tr>
							<td class="text-center">
								<?php echo $i++; ?>
							</td>
							<td>
								<?php echo date("Y-m-d", strtotime($row['reading_date'])) ?>
							</td>
							<td>
								<?php echo $row['code'] . " - " . $row['name'] ?>
							</td>
							<td>
								<?php echo format_num($row['total']) ?>
							</td>
							<td>
								<?php echo date("Y-m-d", strtotime($row['due_date'])) ?>
							</td>
							<td class="text-center">
								<?php
								switch ($row['status']) {
									case 0:
										echo '<span class="badge badge-secondary  bg-gradient-secondary  text-sm px-3 rounded-pill">Pending</span>';
										break;
									case 1:
										echo '<span class="badge badge-success bg-gradient-success text-sm px-3 rounded-pill">Paid</span>';
										break;
								}
								?>
							</td>
							<td align="center">
								<button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon"
									data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item view_data"
										href="./?page=billings/view_billing&id=<?php echo $row['id'] ?>"><span
											class="fa fa-eye text-dark"></span> View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item edit_data"
										href="./?page=billings/manage_billing&id=<?php echo $row['id'] ?>"><span
											class="fa fa-edit text-primary"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)"
										data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
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

						if ($day == 30) {
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


				function fetchData()
				{
					$channelID = '2416103';
					$apiKey = '9Y9MIRGXAAE1BY94';
					$feedUrl = "https://api.thingspeak.com/channels/{$channelID}/feeds.json?api_key={$apiKey}";

					$response = file_get_contents($feedUrl);
					$data = json_decode($response, true);

					$jsonData = json_encode($data, JSON_HEX_APOS);
					$lastEntriesWithDay30 = getLastEntriesWithDay30($data['feeds']);

					$vsy = calculateWaterCost($lastEntriesWithDay30['01']['field2']);

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
        <h5>Channel Stats</h5>
        <p>Last entry: " . date('Y-m-d H:i:s', strtotime($channelData['updated_at'])) . "</p>
        <p>Entries: {$channelData['last_entry_id']}</p>
      </div>
    ";

					// Create a Bootstrap table
					echo "
      <table class='table mt-4'>
        <thead>
          <tr>
            <th>Entry ID</th>
            <th>Bill</th>
            <th>Units</th>
            <th>Valve</th>
            <th>Created At</th>
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
					$waterCostRanges = [
						['min' => 0, 'max' => 100, 'rate' => 0.05],
						['min' => 101, 'max' => 200, 'rate' => 0.25],
						['min' => 201, 'max' => 300, 'rate' => 0.50],
						['min' => 301, 'max' => 400, 'rate' => 0.75],
						['min' => 401, 'max' => INF, 'rate' => 0.88],
					];

					$waterConsumption = floatval($field2Value);
					$waterCost = 0;

					foreach ($waterCostRanges as $range) {
						if ($waterConsumption >= $range['min'] && $waterConsumption <= $range['max']) {
							$waterCost = $waterConsumption * $range['rate'];
							break;
						}
					}

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

				// Call fetchData when the page loads
				fetchData();

				?>
			</div>
		</div>
	</div>
</div>
<div>
	<div class="usercharges">
		<h2>Bill payment</h2>
	</div>
	<div>
		<button>payy</button>
	</div>
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