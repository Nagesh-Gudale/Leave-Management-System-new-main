<!-- ======= Header ======= -->
 <?php $userId = $_SESSION['user_id']; ?>
<?php include 'header.php'; ?>
 <header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="#" class="logo d-flex align-items-center">
    <img src="#" alt="">
    <span class="d-none d-lg-block text-light"><img src="../assets/images/logo.png" class="bg-light rounded p-1" alt="" height="150px" style>Kolhapur</span>
  </a>
  <i class="fa fa-bars toggle-sidebar-btn text-light"></i>
</div><!-- End Logo -->

<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="fa fa-search"></i></button>
    
  </form>
</div>

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="../assets/images/profile.png" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2 bg-light rounded-4 p-1"><?php echo $_SESSION['user_name']?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li>
          <a class="dropdown-item d-flex align-items-center" href="../templates/profile.php">
            <i class="fa fa-user"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li>
          <a class="dropdown-item d-flex align-items-center" href="../logout.php">
            <i class="fa fa-sign-out"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->
</header><!-- End Header -->
<?php include 'sidebar.php'; ?>
<?php //include 'footer.php'; ?> 