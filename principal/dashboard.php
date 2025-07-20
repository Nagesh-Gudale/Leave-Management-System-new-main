<?php 
include '../include/db-connection.php';
include '../include/session.php'; 


checkLogin();

// Check if user is admin
if (!isPrincipal()) {
    header('Location: ../login.php');	
    exit();
}
include '../templates/admin-header.php';
$sql = "SELECT * from leaves where status1='pending';";
$result = $conn->query($sql);
$leaves = [];
while($row = $result->fetch_assoc())
{
    $leaves[] = $row;
}
$sql2 = "SELECT * from leave_types ";
$result2 = $conn->query($sql2);
$leavetype = [];
while($row = $result2->fetch_assoc())
{
    $leavetype[] = $row;
}
$sql3 = "SELECT * from departments ";
$result3 = $conn->query($sql3);
$totaldept = [];
while($row = $result3->fetch_assoc())
{
    $totaldept[] = $row;
}
$sql4 = "SELECT * from users ";
$result4 = $conn->query($sql4);
$totalemp = [];
while($row = $result4->fetch_assoc())
{
    $totalemp[] = $row;
}
?>
<main class="main" id="main">
	<section class="section">
<div class="container mt-5 p-4 text-center" style=" border-bottom:1px solid gray;">
	<h1 class="text-dark">Welcome to Leave Management System</h1>
</div>
<div class="container" style=" margin-top:20px">
	<div class="row">
		<div class="col-lg-3 col-sm-12 col-md-6">
			<div class="card rounded shadow-lg " style="background-color:#38384f;">
				<div class="card-body text-light" style="padding:20px;">
					<span><i class="fa fa-file-alt " style="font-size: 50px; color:#00ffff;"></i>
						<h4 class="d-inline-block">Pending Applications-</h4>
						<h4 class="d-inline-block"> <?php echo count($leaves) ?></h4>
					</span>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-sm-12 col-md-6">
			<div class="card rounded shadow-lg" style="background-color:#020109;">
				<div class="card-body text-light" style="padding:20px;">
					<span><i class="fa fa-users text-primary d-block" style="font-size: 50px;"></i>
						<h4 class="d-inline-block">Total Employees - </h4>
						<h4 class="d-inline-block "><?php echo count($totalemp) ?></h4>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
</main>
<?php include '../templates/footer.php';
