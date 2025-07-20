<?php
include '../include/db-connection.php';
include '../include/session.php';



$userId = $_SESSION['user_id'];
$sql3 = "SELECT remaining_leaves,remaining_casual_leaves FROM users WHERE id=$userId";
$result3 = $conn->query($sql3);
$count; 
$count2;
while ($rows2 = $result3->fetch_assoc()) {
  $count = $rows2['remaining_leaves'];
  $count2 = $rows2['remaining_casual_leaves'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['add_leave'])) {
    // Insert new department
    $leave_type_id = $_POST['leave_type'];
    $reason = $conn->real_escape_string($_POST['reason']);
    $startDate = $conn->real_escape_string($_POST['fromDate']);
    $endDate = $conn->real_escape_string($_POST['toDate']);
    if ($startDate >= date("Y-m-d")) {
      if(dateDiffInDays($startDate,$endDate)<=9){
        $dif1=$count-dateDiffInDays($startDate,$endDate);
        $dif2=$count2-dateDiffInDays($startDate,$endDate);
      $sql = "INSERT INTO leaves (user_id, leave_type_id ,start_date ,end_date ,reason) VALUES ('$userId', '$leave_type_id' ,'$startDate' ,'$endDate','$reason')";
      if($leave_type_id=="1"){
        $sql4="UPDATE users SET remaining_leaves ='$dif1' WHERE id='$userId'";
      }elseif($leave_type_id=="3"){
        $sql4="UPDATE users SET remaining_casual_leaves ='$dif2' WHERE id='$userId'";
      }
      if ($conn->query($sql) === TRUE and $conn->query($sql4)===TRUE) {
        $_SESSION['message'] = "Leave Application Successfull";
      } else {
        $_SESSION['error'] = 'Error: ' . $conn->error;
      }
    }
    else{
      $_SESSION['error'] = 'Leave Duration more than limit ' . $conn->error;
    }
      // Redirect to avoid form resubmission
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    } else {
      $_SESSION['error'] = "Enter Valid Dates";
    }
  }
}

$sql = "SELECT l.* , lt.type FROM leaves as l INNER JOIN leave_types as lt ON l.leave_type_id=lt.id WHERE l.user_id = $userId";
$result = $conn->query($sql);
$leaves = [];
while ($row = $result->fetch_assoc()) {
  $leaves[] = $row;
}


$sql2 = "SELECT * FROM leave_types";
$result2 = $conn->query($sql2);
$leaves_types = [];
while ($rows = $result2->fetch_assoc()) {
  $leaves_types[] = $rows;
}

function dateDiffInDays($date1, $date2)
{

  // Calculating the difference in timestamps 
  $diff = strtotime($date2) - strtotime($date1);

  // 1 day = 24 hours 
  // 24 * 60 * 60 = 86400 seconds 
  return abs(round($diff / 86400));
}

include '../templates/admin-header.php';
?>
<script>
  setTimeout(function () {
    let alertContainer = document.getElementById('alert-container');
    if (alertContainer) {
      alertContainer.style.display = 'none';
    }
  }, 5000);
</script>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Leave List</h1>
  </div><!-- End Page Title -->
  <?php if (isset($_SESSION['message']) || isset($_SESSION['error'])): ?>
    <div id="alert-container" style="position: fixed; top: 10px; right: 10px; z-index: 1050;">
      <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['message']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['error']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>
    </div>
    <script>
      setTimeout(function () {
        let alertContainer = document.getElementById('alert-container');
        if (alertContainer) {
          alertContainer.style.display = 'none';
        }
      }, 5000);
    </script>
  <?php endif; ?>
  <button type="button" class="btn btn-primary mt-3 mb-3 gradient" data-bs-toggle="modal" data-bs-target="#add">
    Apply for Leave
  </button>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <!-- Table with stripped rows -->
            <table class="table datatable table-striped" id="leave">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Type</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Days</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($leaves as $leave) {
                  $dateDiff = dateDiffInDays($leave["start_date"], $leave["end_date"]);
                  echo '<tr>
                    <td>' . $leave["id"] . '</td>
                    <td>' . $leave["type"] . '</td>
                    <td>' . $leave["start_date"] . '</td>   
                    <td>' . $leave["end_date"] . '</td>   
                    <td>' . $dateDiff . '</td>  
                    <td>' . $leave["status1"] . '</td>   
                  </tr>';
                } ?>

              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->

<!-- add depertmanet modal -->
<div class="modal fade" id="add" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Apply for Leave</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-header">
        <h5 class="modal-title">Remaining Leaves- 
          <?php 
            echo "<br>Sick Leave: .$count <br>";
            echo "Casual Leave: .$count2";
        ?></h5>
        
      </div>
      <!-- Vertical Form -->
      <form action="" method="post" class="row g-3 p-3">
        <div class="form-row d-flex add-staf-field">

          <div class="form-group col">
            <label for="fromDate" class="form-label">From Date</label>
            <input type="date" name="fromDate" id="fromDate" required />
          </div>
          <div class="form-group col">
            <label for="toDate" class="form-label">To Date</label>
            <input type="date" name="toDate" id="toDate" required />

          </div>
        </div>
        <div class="form-row d-flex add-staf-field">
          <div class="form-group col">
            <label for="role" class="form-label">Leave Type</label>
            <select class="form-select" id="leave_type" name="leave_type">
              <?php foreach ($leaves_types as $leave): ?>
                <option value="<?php echo $leave['id']; ?>"><?php echo $leave['type']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col">
            <label for="reason" class="form-label">Reason</label>
            <input type="text" name="reason" id="reason">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="add_leave">Add</button>
        </div>
      </form><!-- Vertical Form -->

    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $('#leave').DataTable({
      "scrollX": false, // Enable horizontal scrolling
      "columns": [
        { "width": "10%" }, // Adjust width as needed for each column
        { "width": "15%" },
        { "width": "15%" },
        { "width": "20%" },
        { "width": "20%" },
        { "width": "20%", "orderable": false } // Disable sorting for action column
      ]
    });
  });
</script>
<?php
include '../templates/footer.php';
?>