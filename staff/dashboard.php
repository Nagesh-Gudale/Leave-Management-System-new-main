
<?php 
include '../include/db-connection.php';
include '../include/session.php'; 
include '../templates/admin-header.php';


$sql = "SELECT * from leaves where status1='pending';";
$result = $conn->query($sql);
$leaves = [];
while($row = $result->fetch_assoc())
{
    $leaves[] = $row;
}
$sql2 = "SELECT * from leaves where status1='approved';";
$result2 = $conn->query($sql2);
$leaves2 = [];
while($row = $result2->fetch_assoc())
{
    $leaves2[] = $row;
}
?>
<div class="container mt-5 p-4 text-center" style="margin-left:320px; border-bottom:1px solid gray;">
	<h1 class="text-dark">Welcome to Leave Management System</h1>
</div>
<div class="container" style="margin-left:320px; margin-top:20px">
	<div class="row">
		<div class="col-3">
			<div class="card rounded shadow-lg " style="background-color:#38384f;">
				<div class="card-body text-light" style="padding:20px;">
					<span><i class="fa fa-file-alt " style="font-size: 50px; color:#00ffff;"></i>
						<h4>Pending Applications- <?php echo count($leaves) ?></h4>
					</span>
				</div>
			</div>
		</div>
		<div class="col-3">
			<div class="card rounded shadow-lg " style="background-color:#38384f;">
				<div class="card-body text-light" style="padding:15x;">
					<span><i class="fa fa-check " style="font-size: 40px; color:#00ffff;"></i>
						<h4>Approved Applications- <?php echo count($leaves2) ?></h4>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include '../templates/footer.php';
