<?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: ../auth/login.php");
        exit();
    }

    // Config
    include ('../config.php');

    // if (isset($_POST['pstation'])) {
      
    //   $station = $_POST['station'];
    //   $sql = "SELECT * FROM `users` WHERE `role` = 'voter' AND `pstation` = '$station' ORDER BY `id` DESC";
    //   $voters = mysqli_query($conn, $sql);
    // }else{
    //   $voters = mysqli_query($conn, "SELECT * FROM `users` WHERE (`role` = 'voter') ORDER BY `id` DESC ");
    // }

    if (isset($_GET['pstation']) && ($_GET['pstation'] != 'Filter by council')) {
      $station = $_GET['pstation'];
      $sql = "SELECT * FROM `users` WHERE `role` = 'voter' AND `pstation` = '$station' ORDER BY `id` DESC";
    } else {
      $sql = "SELECT * FROM `users` WHERE `role` = 'voter' ORDER BY `id` DESC";
    }
    
    $voters = mysqli_query($conn, $sql);
?>



<?php include("../layout/header.php"); ?>

<!-- ===== SINGLE VOTER ===== -->
<section class="container-fluid">
  <div class="bg-white">
    <?php if ($_SESSION['role'] == 'officer') { ?>
        <h2 class="text-3xl pt-8 pb-5 font-bold text-center">Welcome Officer <?= $_SESSION['name'] ?>!</h2>
    <?php } ?>
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
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">All Voters</h2>

        <!-- <div>
            <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                </svg>
                Sort by polling station
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            Dropdown menu
            <div id="dropdownRadio" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input checked="" id="filter-all" type="radio" value="" name="filter-all" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-all" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">All Stations</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-scotland" type="radio" value="" name="filter-scotland" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-scotland" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Scotland</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-manchester" type="radio" value="" name="filter-manchester" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-manchester" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Manchester</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-DebbyCounty" type="radio" value="" name="filter-DebbyCounty" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-DebbyCounty" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Debby County</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-sunderland" type="radio" value="" name="filter-sunderland" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-sunderland" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Sunderland</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-norwich" type="radio" value="" name="filter-norwich" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-norwich" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Norwich</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div> -->

        <!-- <div>
            <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                </svg>
                Sort by polling station
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            Dropdown menu
            <div id="dropdownRadio" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input checked="" id="filter-all" type="radio" value="all" name="filter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-all" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">All Stations</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-scotland" type="radio" value="Scotland" name="filter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-scotland" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Scotland</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-manchester" type="radio" value="Manchester" name="filter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-manchester" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Manchester</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-DebbyCounty" type="radio" value="Debby County" name="filter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-DebbyCounty" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Debby County</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-sunderland" type="radio" value="Sunderland" name="filter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-sunderland" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Sunderland</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-norwich" type="radio" value="Norwich" name="filter" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="filter-norwich" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Norwich</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div> -->

        <form class="flex items-center max-w-sm mx-auto" action="" method="GET">   
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <select id="simple-search" name="pstation" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option selected>Filter by council</option>
                  <option value="Scotland">Scotland</option>
                  <option value="Manchester">Manchester</option>
                  <option value="DebbyCounty">Debby County</option>
                  <option value="Sunderland">Sunderland</option>
                  <option value="Norwich">Norwich</option>
                </select>
            </div>
            <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1a1 1 0 0 1-.293.707L13 9.414V14a1 1 0 0 1-.447.894l-4 2.5A1 1 0 0 1 7 16.5V9.414L2.293 5.707A1 1 0 0 1 2 5V4z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </form>

        <?php if ($_SESSION['role'] == 'officer') { ?>
            <a href="../auth/voter_register.php" class="bg-blue-900 text-white hover:bg-blue-700 hover:text-white rounded-md px-5 py-2 text-base font-medium flex items-center"><i class="fa fa-plus mr-2" aria-hidden="true"></i> Add New Voter</a>
        <?php } ?>
      </div>

      <div class="mx-auto max-w-6xl px-6 pb-10 pt-8 sm:px-6 lg:grid lg:max-w-6xl lg:gap-x-8 lg:px-8 lg:pb-14 lg:pt-12">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <?php foreach ($voters as $voter) { ?>
        <a href="single.php?id=<?= $voter['id'] ?>" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
          <img class="object-cover w-full rounded-t-lg md:h-48 md:w-48 md:rounded-none md:rounded-s-lg" src="../uploads/voters/<?= $voter['picture'] ?>" alt="profile picture" width="588" height="392">
          <div class="flex flex-col justify-between p-4 leading-normal">
            <div class="flex justify-between items-center">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $voter['name'] ?></h5>
              <?php if ($_SESSION['id'] == $voter['id']) { ?>
                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Mine</span>
              <?php } ?>
            </div>
            <div class="flex justify-between">
              <p class="mb-2 font-medium text-gray-700 dark:text-gray-400"><?= $voter['idno'] ?></p>
              <p class="mb-2 font-medium text-gray-700 dark:text-gray-400">Station: <?= $voter['pstation'] ?></p>
            </div>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
          </div>
        </a>
        <?php } ?>

        <!-- Duplicate the card for the second card -->
        <!-- <a href="#" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
          <img class="object-cover w-full rounded-t-lg md:h-48 md:w-48 md:rounded-none md:rounded-s-lg" src="https://tailwindui.com/img/ecommerce-images/product-page-02-tertiary-product-shot-01.jpg" alt="profile picture">
          <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
          </div>
        </a> -->
      </div>
      </div>

      <!-- <script>
          $(document).ready(function() {
              $('input[name="filter"]').change(function() {
                  let station = $(this).val();
                  let label = $(this).next('label').text();

                  if (station !== 'all') {
                      $('#dropdownRadioButton').text('Sort by: ' + label);

                      $.ajax({
                          url: 'fetch_users.php',
                          method: 'POST',
                          data: { station: station },
                          success: function(data) {
                              $('#userList').html(data);
                          }
                      });
                  } else {
                      $('#dropdownRadioButton').text('Sort by polling station');
                      $('#userList').empty();
                  }
              });

              Do not trigger the change event on page load to ignore the "all" input
          });
      </script> -->
    </div>
  </div>
</section>
<!-- ===== /.SINGLE VOTER END ===== -->

<?php include("../notification.php"); ?>

<?php include("../layout/footer.php"); ?>