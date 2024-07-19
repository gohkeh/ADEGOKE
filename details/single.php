<?php
  session_start();

  // Check if user is logged in
  if (!isset($_SESSION['id'])) {
      header("Location: ../auth/login.php");
      exit();
  }

  // Config
  include ('../config.php');

  $urlID = $_GET['id'];
  $uniqueVoter = mysqli_query($conn, "SELECT * FROM `users` WHERE (`id` = '$urlID') ");
  $unique = mysqli_fetch_array($uniqueVoter);

  # DELETE BUTTON
  if((isset($_GET['func'])) && ($_GET['func'] == 'delete')){

    $delete = mysqli_query($conn, "DELETE FROM `users` WHERE `id` = '$urlID' ");
    if($delete){
      if ($_SESSION['role'] === 'officer') {
        $extra = "all.php";
        $_SESSION['success'] = "You have deleted Voter's details successfully.";
      } else {
        $extra = "../auth/login.php";
        session_destroy();
      }
      $host = $_SERVER['HTTP_HOST'];
      $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $link = "http://$host$uri/$extra";
      header("Location: $link"); 
      exit();
    }else{
      echo "<script>alert('Something went wrong. Please try again.'); window.location.href='" . $_SERVER['PHP_SELF'] . "'; </script>";
    }
  }

?>

<?php include("../layout/header.php"); ?>

<!-- ===== SINGLE VOTER ===== -->
<section class="container-fluid">
  <div class="bg-white">
    <?php if (isset($_SESSION['success'])) { ?>
      <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
          <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
          </svg>
          <div class="ms-3 text-sm font-medium"><?= $_SESSION['success'] ?></div>
          <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-3" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
          </button>
      </div>
    <?php session_destroy(); ?>
    <?php } ?>
    
    <div class="pt-10">
      <!-- Nav and add button -->
      <div class="mx-auto max-w-6xl px-6 lg:px-8 flex justify-between items-center">
        <nav aria-label="Breadcrumb">
            <ol role="list" class="mx-auto flex max-w-2xl items-center space-x-2 pr-4 sm:pr-6 lg:max-w-7xl lg:pr-8">
            <li>
                <div class="flex items-center">
                <a href="all.php" class="mr-2 text-sm font-medium text-gray-900 hover:underline hover:text-blue-500">All Voters</a>
                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true" class="h-5 w-4 text-gray-300">
                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                </svg>
                </div>
            </li>
            <li class="text-sm">
                <a href="#" aria-current="page" class="font-medium text-gray-500 hover:text-gray-600 hover:underline"><?= $unique['username'] ?></a>
            </li>
            </ol>
        </nav>
        <?php if ($_SESSION['role'] == 'officer') { ?>
          <a href="../auth/voter_register.php" class="bg-blue-900 text-white hover:bg-blue-700 hover:text-white rounded-md px-5 py-2 text-base font-medium flex items-center"><i class="fa fa-plus mr-2" aria-hidden="true"></i> Add New Voter</a>
        <?php } ?>
      </div>
  
      <!-- Product info -->
      <div class="mx-auto max-w-6xl px-6 pb-10 pt-8 sm:px-6 lg:grid lg:max-w-6xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-14 lg:pt-12">
        <div class="px-4 sm:px-0 lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
            <h3 class="text-2xl font-semibold leading-7 text-gray-900"><?= $unique['name'] ?></h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500"><?= $unique['address'] ?></p>
        </div>

        <!-- Right side details -->
        <div class="mt-4 lg:row-span-3 lg:mt-0">
          <!-- Image gallery -->
          <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg">
            <img src="../uploads/voters/<?= $unique['picture'] ?>" width="768" alt="Default DP" class="h-full w-full object-cover object-center">
          </div>
          <!-- Button -->
          <?php if (($_SESSION['role'] == 'officer') || ($_SESSION['id'] == $unique['id'])) { ?>
          <div class="flex mt-10 space-x-2">
            <a href="edit.php?id=<?= $unique['id'] ?>" class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Edit Details</a>
            <a href="single.php?id=<?= $urlID ?>&func=delete" class="flex items-center justify-center rounded-md border border-transparent bg-red-700 hover:bg-red-800 px-8 py-3 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 focus:ring-offset-2 delete-link-<?= $urlID  ?>">Delete Details <i class="fa fa-trash ml-1" aria-hidden="true"></i></a>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                  const deleteLinks = document.querySelectorAll('.delete-link-<?= $urlID ?>');

                  deleteLinks.forEach(function(link) {
                      link.addEventListener('click', function(event) {
                          // Prevent the default action of clicking the link
                          event.preventDefault();

                          // Ask for confirmation before proceeding
                          const confirmation = window.confirm("Are you sure you want to delete this voter's record?");
                          
                          // If user confirms, navigate to the specified link
                          if (confirmation) {
                              window.location.href = link.href;
                          }
                      });
                  });
              });
            </script>
          </div>
          <?php } ?>
        </div>
  
        <!-- Description and Details -->
        <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-6 lg:pr-8 lg:pt-6">
            <div class="border-t border-gray-100">
                <dl class="divide-y divide-gray-100">
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Phone Number</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $unique['phone'] ?></dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Email Address</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $unique['email'] ?></dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Voter ID Number</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $unique['idno'] ?></dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Polling Station</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><?= $unique['pstation'] ?></dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.</dd>
                </div>
                </dl>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ===== /.SINGLE VOTER END ===== -->

<?php include("../notification.php"); ?>

<?php include("../layout/footer.php"); ?>