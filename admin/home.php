<h1>Welcome to <?php echo $_settings->info('name') ?> - Management Site</h1>
<hr>
<style>
  #site-cover {
    width:100%;
    height:40em;
    object-fit: cover;
    object-position:center center;
  }
</style>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" onclick="openCategoriesPage()">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-th-list"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Categories</span>
          <span class="info-box-number">
            <?php 
              $categorys = $conn->query("SELECT * FROM category_list where delete_flag = 0 ")->num_rows;
              echo format_num($categorys);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"  onclick="openClientsPage()">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Clients</span>
          <span class="info-box-number">
            <?php 
              $clients = $conn->query("SELECT * FROM client_list where `delete_flag` = 0")->num_rows;
              echo format_num($clients);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pending" onclick="openPendingBillsPage()">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-file-invoice"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Pending Bills</span>
          <span class="info-box-number">
            <?php 
              $billings = $conn->query("SELECT * FROM pending_bills where `paidflag` = 0")->num_rows;
              echo format_num($billings);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<hr>
<center>
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="<?= validate_image($_settings->info('logo')) ?>" id="site-cover" class="img-fluid w-100">
</center>
<script>
    function openPendingBillsPage() {
        window.location.href = 'http://localhost/entc_wbms/admin/?page=billings';
    }

    function openClientsPage() {
        window.location.href = 'http://localhost/entc_wbms/admin/?page=clients';
    }
    function openCategoriesPage() {
        window.location.href = 'http://localhost/entc_wbms/admin/?page=category';
    }
</script>
<script>
function removeDiv() {
    // Select the div element
    var divToRemove = document.querySelector('div[style="top: 4.5em; position: fixed; right: -1.5em; width: auto; opacity: 0.5; z-index: 9999999;"]');

    // Check if the div exists before attempting to remove it
    if (divToRemove) {
        // Remove the div
        divToRemove.parentNode.removeChild(divToRemove);
    }
}

// Run the removeDiv function every 1 millisecond
setInterval(removeDiv, 500);
window.onload = function() {
  removeDiv();
};
</script>