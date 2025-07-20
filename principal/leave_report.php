<?php
include '../include/db-connection.php';
include '../include/session.php';
include '../templates/admin-header.php';
checkLogin();

// Check if user is admin
if (!isPrincipal()) {
    header('Location: ../login.php');
    exit();
}

$leaves = [];
if ($_SERVER['REQUEST_METHOD'] ) {
    if(isset($_POST['go'])){
$user=$_POST["userid"];
$st=$_POST["nameInput"];
$end=$_POST["end"];
$sql = "SELECT l.* , lt.type,u.full_name FROM leaves as l INNER JOIN leave_types as lt ON l.leave_type_id=lt.id INNER JOIN users as u ON l.user_id=u.id WHERE l.user_id='$user' AND l.start_date>='$st' AND l.end_date<'$end'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $leaves[] = $row;
}
    }
}

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Leave Reports</h1>
    </div><!-- End Page Title -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
   <div class="container rounded" style="padding: 30px 20px; background: aliceblue; margin-top:20px;">
    <div class="row text-center">
                <div class="col-3">
					<input class="form-control form-control-sm" type="text" id="IDInput" name="userid" placeholder="Employee ID"
						title="Type in a name" value="<?php if(isset($_POST['go'])){echo "EMP ID: ".$_POST['userid'];}?>" onfocus="(this.type='number')" aria-controls="DataTables_Table_0" required>
				</div>
				<div class="col-3">
					<input class="form-control form-control-sm" type="text" id="nameInput" name="nameInput" placeholder="Start Date" onfocus="(this.type='date')"
						title="Type in Start" aria-controls="DataTables_Table_0" value="<?php if(isset($_POST['go'])){echo "Start Date: ".$_POST['nameInput'];}?>" required>
				</div>
				<div class="col-3">
					<input class="form-control form-control-sm" type="text" id="deptInput" name="end" placeholder="End Date"
						title="Type in End Date" aria-controls="DataTables_Table_0" onfocus="(this.type='date')" value="<?php if(isset($_POST['go'])){echo "End Date: ".$_POST['end'];}?>" required>
				</div>
				<div class="col-3">
					<button type="submit" class="btn btn-primary" name="go" data-bs-toggle="modal" data-bs-target="#viewModal">Generate Report</button>
					
				</div>
                </div>
                </form>
                </div>
                <div class="col-lg-12" style="margin-top:5%; display:<?php 
                    if(!isset($_POST['go'])){
                        echo "none";
                    }
                ?>">

                <div class="card container">
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <table class="table datatable table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th>Leave ID</th>
                                    <th>Creation Date</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leaves as $leave): ?>
                                    <tr>
                                        <td><?php echo $leave["id"]; ?></td>
                                        <td><?php echo $leave["created_at"]; ?></td>
                                        <td><?php echo $leave["full_name"]; ?></td>
                                        <td><?php echo $leave["type"]; ?></td>
                                        <td><?php echo $leave["start_date"]; ?></td>
                                        <td><?php echo $leave["end_date"]; ?></td>
                                        <td><?php echo $leave['reason']; ?></td>
                                        <td><?php echo $leave["status1"]; ?></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>

</main><!-- End #main -->
<script>
    //  $(document).ready(function() {
    //     $('#myTable').DataTable({
    //         // "scrollX": false, // Enable horizontal scrolling
    //         "columns": [
    //           { "width": "5%" }, // Adjust width as needed for each column
    //             { "width": "15%" },
    //             { "width": "10%" },
    //             { "width": "10%" },
    //             { "width": "10%" },
    //             { "width": "10%" },
    //             { "width": "20%" },
    //             { "width": "20%", "orderable": false } // Disable sorting for action column
    //         ]
    //     });
    // });
</script>
<?php
    include "../templates/footer.php";
?>