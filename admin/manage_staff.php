<?php 
session_start();

include '../include/db-connection.php';
include '../include/session.php';


checkLogin();

// Check if user is admin
if (!isAdmin()) {
    header('Location: ../login.php');
    exit();
}
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['add_staff']) && !empty($_POST['email'])) {
      // Insert new staff
      $full_name = $conn->real_escape_string($_POST['firstname'].' '.$_POST['lastname']);
      $username = $conn->real_escape_string($_POST['username']);
      $email = $conn->real_escape_string($_POST['email']); 
      $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
      $phone =  $conn->real_escape_string($_POST['phone']);
      $address =   $conn->real_escape_string($_POST['address']);
      $dob =  $conn->real_escape_string($_POST['dob']);
      $gender =  $conn->real_escape_string($_POST['gender']); 
      $role_id = $_POST['role'];
      $department_id = $_POST['department'];
      $status = $_POST['status']; 

      // Initialize the image_url
    $image_url = '';
 
    // Image upload handling
    if ($_FILES["profile"]["name"]) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["profile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["profile"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk != 0) {
            if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
       
    }

      $sql = "INSERT INTO users (full_name, username , email , password ,phone , address ,dob ,gender ,profile_image ,role_id ,department_id , status) VALUES ('$full_name', '$username' ,'$email' ,'$password','$phone' ,'$address', '$dob' , '$gender', '$image_url' , $role_id ,$department_id , '$status')";

      if ($conn->query($sql) === TRUE) {
          $_SESSION['message'] = 'New staff created successfully';
      } else {
          $_SESSION['error'] = 'Error: ' . $conn->error;
      }
      // Redirect to avoid form resubmission
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
  } elseif (isset($_POST['update_staff']) && !empty($_POST['updatestaffId'])) {
      // Update existing staff
      $full_name = $conn->real_escape_string($_POST['updatefirstname'].' '.$_POST['updatelastname']);
      $username = $conn->real_escape_string($_POST['updateusername']);
      $email = $conn->real_escape_string($_POST['updateemail']); 
      // $password = $conn->real_escape_string($_POST['password']);
      $phone =  $conn->real_escape_string($_POST['updatephone']);
      $address =   $conn->real_escape_string($_POST['updateaddress']);
      $dob =  $conn->real_escape_string($_POST['updatedob']);
      $gender =  $conn->real_escape_string($_POST['updategender']); 
      $role_id = $_POST['updaterole_id'];
      $department_id = $_POST['updatedepartment_id'];
      $status = $_POST['updatestatus']; 

      // Initialize the image_url
    $image_url = '';
 
    // Image upload handling
    if (isset($_FILES["updateprofile"]["name"]) && $_FILES["updateprofile"]["name"] != '') {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["updateprofile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["updateprofile"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["updateprofile"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk != 0) {
            if (move_uploaded_file($_FILES["updateprofile"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    
    }
    else
    {
      $image_url = $_POST['image_url'];
    }
      $staffId= $_POST["updatestaffId"];
      $sql = "UPDATE  users SET `full_name`='$full_name',`username`='$username',`email`='$email',`phone`='$phone',`address`='$address',`dob`='$dob',`gender`='$gender',`profile_image`='$image_url',`role_id`='$role_id',`department_id`='$department_id',`status`='$status' WHERE `id` = '$staffId' ";
      
      if ($conn->query($sql) === TRUE) {
          $_SESSION['message'] = 'staff Updates successfully';
      } else {
          $_SESSION['error'] = 'Error: ' . $conn->error;
      }
      // Redirect to avoid form resubmission
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
  } elseif (isset($_POST['delete_staff']) && !empty($_POST['staff_id'])) {
      // Delete Staff
      $staff_id = intval($_POST['staff_id']);
      $sql = "DELETE FROM users WHERE id=$staff_id";
      if ($conn->query($sql) === TRUE) {
          $_SESSION['message'] = 'staff deleted successfully';
      } else {
          $_SESSION['error'] = 'Error: ' . $conn->error;
      }
      // Redirect to avoid form resubmission
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
  }
}

// Fetch Staff
$sql = "SELECT * FROM users ";
$result = $conn->query($sql);
$staffArray = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $staffArray[] = $row;
  }
}

// Fetch Roles 
$sql = "SELECT * FROM `role`";
$result = $conn->query($sql);
$roleArray = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $roleArray[] = $row;
  }
}

// Fetch Roles 
$sql = "SELECT * FROM `departments`";
$result = $conn->query($sql);
$departmentArray = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $departmentArray[] = $row;
  }
}

include '../templates/admin-header.php'; 
?>

<style>
  table.dataTable.no-footer {
    border-bottom: 1px #403d3d1c;
  }
  form.add-staff {
    padding: 10px;
  }
  form div.add-staf-field {
    padding: 0px;
  }
  form div.form-group{
    padding: 15px;
  }
</style>


<main id="main" class="main">
    <div class="pagetitle">
        <h1>Staff</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:scroll;">
                        <!-- Alert Messages -->
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
                                setTimeout(function() {
                                    let alertContainer = document.getElementById('alert-container');
                                    if (alertContainer) {
                                        alertContainer.style.display = 'none';
                                    }
                                }, 5000);
                            </script>
                        <?php endif; ?>

                        <button type="button" class="btn btn-primary mt-3 mb-3 gradient" data-bs-toggle="modal" data-bs-target="#addModal">
                            Add Staff
                        </button>
                        <!-- Table with stripped rows -->
                        <table id="staffsTable" class="table datatable table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone no.</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staffArray as $staff): ?>
                                <tr>
                                    <td><?php echo $staff["id"]; ?></td>
                                    <td><?php echo $staff["full_name"]; ?></td>
                                    <td><?php echo $staff["username"]; ?></td>
                                    <td><?php echo $staff["email"]; ?></td>
                                    <td><?php echo $staff["phone"]; ?></td>
                                   
                                    <td class="badge badge-primary" style="padding:21px 51px;"> <?php print $staff["status"]; ?> </td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal" onclick='setViewData(<?php echo json_encode($staff); ?>)'>View</button>
                                        <button type="button" class="btn btn-warning orange" data-bs-toggle="modal" data-bs-target="#updateModal" onclick='setUpdateData(<?php echo json_encode($staff); ?>)'>Update</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteData(<?php echo $staff['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<!-- Add Staff Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="" method="POST" class="add-staff" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname">
                  </div>
                  <div class="form-group col">  
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" id="lastname" placeholder="Last Name" name="lastname">
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="email">username</label>
                    <input type="username" class="form-control" id="username" placeholder="username" name="username">
                  </div>
                  <div class="form-group col">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email"> 
                  </div> 
                </div>
                <div class="form-row d-flex add-staf-field">
                <div class="form-group col">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                  </div> 
                  <div class="form-group col">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" placeholder="confirm-password" name="confirmPassword">
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" placeholder="phone" name="phone">
                  </div>
                  <div class="form-group col">
                    <label for="dob">DOB</label>
                    <input type="date" class="form-control" id="dob" placeholder="dob" name="dob">
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="inputEmail4">Gender</label>
                    <div>
                      <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                      <label class="form-check-label" for="inlineRadio1">Male</label>
                      <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                      <label class="form-check-label" for="inlineRadio1">Female</label>
                      <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                      <label class="form-check-label" for="inlineRadio1">Other</label>
                    </div>
                  </div>
                  <div class="form-group col">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Adress" name="address">
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role">
                      <?php foreach($roleArray as $val): ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['role_name']; echo $val['id']; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-select" id="department" name="department">
                      <?php foreach($departmentArray as $val): ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="addStatus" class="form-label">Status</label>
                    <select class="form-select" id="addStatus" name="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                  <div class="form-group col">
                    <label for="inputPassword4">Profile Image</label>
                    <input type="file" class="form-control" id="profile" placeholder="Profile Image" name="profile">
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_staff" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Staff Modal -->
<div class="modal fade" id="updateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
              <form action="" method="POST" class="add-staff" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" id="updatestaffId" name="updatestaffId">

                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" id="updatefirstname" placeholder="First Name" name="updatefirstname">
                  </div>
                  <div class="form-group col">  
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" id="updatelastname" placeholder="Last Name" name="updatelastname">
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="email">username</label>
                    <input type="username" class="form-control" id="updateusername" placeholder="username" name="updateusername">
                  </div>
                  <div class="form-group col">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="updateemail" placeholder="Email" name="updateemail"> 
                  </div> 
                </div> 
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="updatephone" placeholder="phone" name="updatephone">
                  </div>
                  <div class="form-group col">
                    <label for="dob">DOB</label>
                    <input type="date" class="form-control" id="updatedob" placeholder="dob" name="updatedob">
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="inputEmail4">Gneder</label>
                    <div>
                      <input class="form-check-input" type="radio" name="updategender" id="updategendermale" value="male">
                      <label class="form-check-label" for="inlineRadio1">Male</label>
                      <input class="form-check-input" type="radio" name="updategender" id="updategenderfemale" value="female">
                      <label class="form-check-label" for="inlineRadio1">Female</label>
                      <input class="form-check-input" type="radio" name="updategender" id="updategenderother" value="other">
                      <label class="form-check-label" for="inlineRadio1">Other</label>
                    </div>
                  </div>
                  <div class="form-group col">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="updateaddress" placeholder="Adress" name="updateaddress">
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="updaterole_id" name="updaterole_id">
                    <?php foreach($roleArray as $val): ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['role_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-select" id="updatedepartment_id" name="updatedepartment_id">
                    <?php foreach($departmentArray as $val): ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div class="form-group col">
                    <label for="updatestatus" class="form-label">Status</label>
                    <select class="form-select" id="updatestatus" name="updatestatus">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                  </div>
                 
                </div>
                <div class="form-row d-flex add-staf-field">
                  <div clas="col"> 
                    <img src="" alt="" srcset="" style="width: 50px;" id="Imagesrc">
                    <input type="hidden" name="image_url" id="image_url"> 
                  </div>
                </div>
                <div class="form-group col">
                    <label for="inputPassword4">Upload New Profile Image</label>
                    <input type="file" class="form-control" id="updateprofile" placeholder="Profile Image" name="updateprofile">
                  </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_staff" class="btn btn-primary">Update</button>
                </div>
              </form>
        </div>
    </div>
</div>

<!-- Delete Staff Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deleteStaffId" name="staff_id">
                    <p>Are you sure you want to delete this Staff?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="delete_staff" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View modal -->
 <div class="modal fade" id="viewModal" tabindex="-1">
 <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Staff Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="form-row d-flex add-staf-field">
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewfirstname">First Name</label>
                    <input type="text" class="form-control" id="viewfirstname" disabled>
                </div>
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewlastname">Last Name</label>
                    <input type="text" class="form-control" id="viewlastname" disabled>
                </div>
            </div>
            <div class="form-row d-flex add-staf-field">
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewusername">Username</label>
                    <input type="text" class="form-control" id="viewusername" disabled>
                </div>
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewemail">Email</label>
                    <input type="email" class="form-control" id="viewemail" disabled>
                </div>
            </div>
            <div class="form-row d-flex add-staf-field">
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewphone">Phone</label>
                    <input type="text" class="form-control" id="viewphone" disabled>
                </div>
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewdob">DOB</label>
                    <input type="date" class="form-control" id="viewdob" disabled>
                </div>
            </div>
            <div class="form-row d-flex add-staf-field">
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewgender">Gender</label>
                    <input type="text" class="form-control" id="viewgender" disabled>
                </div>
                <div class="form-group col-md-12 col-lg-6">
                    <label for="viewaddress">Address</label>
                    <input type="text" class="form-control" id="viewaddress" disabled>
                </div>
            </div>
            <div class="form-row d-flex add-staf-field">
                <div class="form-group col-md-12 col-lg-4">
                    <label for="viewrole">Role</label>
                    <input type="text" class="form-control" id="viewrole" disabled>
                </div>
                <div class="form-group col-md-12 col-lg-4">
                    <label for="viewdepartment">Department</label>
                    <input type="text" class="form-control" id="viewdepartment" disabled>
                </div><br>
                <div class="form-group col-md-12 col-lg-4">
                    <label for="viewstatus">Status</label>
                    <input type="text" class="form-control" id="viewstatus" disabled>
                </div>
            </div>
            </div>
        </div>
    </div>
 </div>

<script>
    $(document).ready(function() {
        $('#staffsTable').DataTable({
            "scrollX": false, // Enable horizontal scrolling
            "columns": [
              { "width": "10%" }, // Adjust width as needed for each column
                { "width": "15%" },
                { "width": "15%" },
                { "width": "20%" },
                { "width": "10%" },
                { "width": "10%" },
                { "width": "20%", "orderable": false } // Disable sorting for action column
            ]
        });
    });
      function setViewData(staff) {
          document.getElementById('viewfirstname').value = staff.full_name.split(' ')[0];
          document.getElementById('viewlastname').value = staff.full_name.split(' ')[1];
          document.getElementById('viewusername').value = staff.username;
          document.getElementById('viewemail').value = staff.email;
          document.getElementById('viewphone').value = staff.phone;
          document.getElementById('viewdob').value = staff.dob;
          document.getElementById('viewgender').value = staff.gender;
          document.getElementById('viewaddress').value = staff.address;
          document.getElementById('viewrole').value = staff.role_id; // Adjust if you have a role name instead of ID
          document.getElementById('viewdepartment').value = staff.department_id; // Adjust if you have a department name instead of ID
          document.getElementById('viewstatus').value = staff.status;
      }

    function setUpdateData(staff) {
        // var staff = JSON.stringify(staffData);
        console.log(staff);
        if(staff.gender == 'Male')
        {
          document.getElementById('updategendermale').checked = true;   
          
        }
        else if(staff.gender == 'Female')
        {
          document.getElementById('updategenderfemale').checked = true;   
          
        }
        else if(staff.gender == 'Other')
        {
          document.getElementById('updategenderother').checked = true;   
          
        }
        var name = staff.full_name.split(" ");
        console.log(name);
        document.getElementById('updatestaffId').value = staff.id;
        document.getElementById('updatefirstname').value = name['0'];
        document.getElementById('updatelastname').value = name['1'];
        document.getElementById('updateusername').value = staff.username;
        document.getElementById('updateemail').value = staff.email;
        document.getElementById('updatephone').value = staff.phone;
        document.getElementById('updateaddress').value = staff.address;
        document.getElementById('updatedob').value = staff.dob;
        document.getElementById('Imagesrc').src = staff.profile_image;
        document.getElementById('image_url').value = staff.profile_image;
        document.getElementById('updaterole_id').value = staff.	role_id;
        document.getElementById('updatedepartment_id').value = staff.	department_id	; 
        document.getElementById('updatestatus').value = staff.status; 
    }

    function setDeleteData(id) {
        document.getElementById('deleteStaffId').value = id;
    }
 
</script>

<?php include '../templates/footer.php'; ?>