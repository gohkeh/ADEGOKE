<!DOCTYPE html>
<html class="h-full bg-gray-100">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Tailwind CDN -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"/>
    <!-- Flowbite CDN -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Home || VoteWebApp</title>
  </head>
  <body class="h-full">

  <?php 
    $current_uri = $_SERVER['REQUEST_URI']; 
    $base_href = (strpos($current_uri, '/auth/') !== false || strpos($current_uri, '/details/') !== false) ? '../' : '';
    $current_page = basename($_SERVER['PHP_SELF']);
    $main_pages = ['index.php', 'about.php', 'contact.php'];
    $auth_pages = ['login.php', 'officer_register.php', 'voter_register.php'];
    $is_main_page = in_array($current_page, $main_pages);
    $is_auth_page = in_array($current_page, $auth_pages);
  ?>
<!-- ===== NAVBAR ===== -->
  <nav class="bg-gray-800">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="">
            <a href="<?= $base_href ?>index.php" class="flex items-center">
              <span class="self-center text-xl font-semibold whitespace-nowrap text-white dark:text-white">VoteWebApp</span>
            </a>
          </div>
          <div class="hidden md:block">
          <?php if ($is_main_page) { ?>
            <div class="ml-10 flex items-baseline space-x-4">
              <a href="index.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>
              <a href="about.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">About</a>
              <a href="contact.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Contact</a>
            </div>
          <?php } ?>
          </div>
        </div>

        <div class="hidden md:block">
        <?php if ($is_main_page) { ?>
          <div class="ml-4 flex items-center md:ml-6">
            <a href="auth/login.php" class="bg-blue-900 w-fit text-white hover:bg-blue-700 hover:text-white rounded-md px-5 py-2 text-base font-medium flex items-center">Login <i class="ml-2.5 fa fa-sign-in" aria-hidden="true"></i></a>
          </div>
        <?php } elseif ($is_auth_page) { ?>
          <div class="ml-4 flex items-center space-x-4 md:ml-6">
            <a href="login.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Login</a>
            <a href="voter_register.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Register</a>
          </div>
        <?php } else { ?>
          <div class="ml-4 flex items-center md:ml-6">
            <a href="../auth/login.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-red-700 hover:text-white">Logout <i class="ml-2.5 fa fa-sign-out" aria-hidden="true"></i></a>
          </div>
        <?php } ?>
        </div>

        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden" id="mobile-menu">
    <?php if ($is_main_page) { ?>
      <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
        <a href="index.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>
        <a href="about.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">About</a>
        <a href="contact.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Contact</a>
      </div>
    <?php } elseif ($is_auth_page) { ?>
      <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
        <a href="login.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Login</a>
        <a href="officer_register.php" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Register</a>
      </div>
    <?php } else { ?>
      <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
        <a href="../auth/login.php" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-red-700 hover:text-white">Logout <i class="ml-2.5 fa fa-sign-out" aria-hidden="true"></i></a>
      </div>
    <?php } ?>

    <?php if ($is_main_page) { ?>
      <div class="border-t border-gray-700 pb-3 pt-4">
        <div class="mt-3 space-y-1 px-2">
            <a href="auth/login.php" class="w-fit bg-blue-900 text-white hover:bg-blue-700 hover:text-white rounded-md px-5 py-2 text-base font-medium flex items-center">Login <i class="ml-2.5 fa fa-sign-in" aria-hidden="true"></i></a>
        </div>
      </div>
    <?php } ?>
    </div>
  </nav>
<!-- ===== NAVBAR ===== -->