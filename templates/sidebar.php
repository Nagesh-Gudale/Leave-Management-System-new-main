<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <?php if (isAdmin()) : ?>
  <li class="nav-item">
    <a class="nav-link " href="../admin/dashboard.php">
      <i class="fa fa-dashboard"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a class="nav-link " href="../admin/manage_departments.php">
      <i class="fa fa-building"></i>
      <span>Department</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a class="nav-link " href="../admin/manage_leave_types.php">
      <i class="fa fa-list"></i>
      <span>Leave Type</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a class="nav-link " href="../admin/manage_role.php">
      <i class="fa-solid fa-user"></i>
      <span>Role Management</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a class="nav-link " href="../admin/manage_staff.php">
      <i class="fa fa-users"></i>
      <span>Staff Management</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a class="nav-link " href="../admin/list_leaves.php">
      <i class="fa fa-list"></i>
      <span>Leave Application List</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a class="nav-link " href="../admin/leave_report.php">
      <i class="fa fa-list"></i>
      <span>Leave Reports</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <?php elseif (isPrincipal()) : ?> 
    <li class="nav-item">
      <a class="nav-link " href="../principal/dashboard.php">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="../principal/leaves.php">
        <i class="fa fa-list"></i>
        <span>Leaves</span>
      </a>
    </li> 
    <li class="nav-item">
      <a class="nav-link " href="../principal/leave_report.php">
        <i class="fa fa-user"></i>
        <span>Leave Report</span>
      </a>
    </li> 
    
  
    <?php elseif (isHOD()) : ?> 
    <li class="nav-item">
      <a class="nav-link " href="../HOD/dashboard.php">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="../HOD/leaves.php">
        <i class="fa fa-list"></i>
        <span>Leaves</span>
      </a>
    </li> 
    
    <li class="nav-item">
    <a class="nav-link " href="../HOD/list_leaves.php">
      <i class="fa fa-users"></i>
      <span>Leave Application List</span>
    </a>
  </li>
  <li class="nav-item">
      <a class="nav-link " href="../HOD/leave_report.php">
        <i class="fa fa-user"></i>
        <span>Leave Report</span>
      </a>
    </li> 
    <?php elseif (isStaff()) : ?>
    <li class="nav-item">
      <a class="nav-link " href="../staff/dashboard.php">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="../staff/leaves.php">
        <i class="fa fa-list"></i>
        <span>Leaves</span>
      </a>
    </li> 
  <?php endif ?>
</ul>

</aside>