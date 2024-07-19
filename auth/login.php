<?php
session_abort();
session_start();

    include ('../config.php');

    // if(isset($_POST['submit'])){
    //     header('Location: ../details/single.php');
    // }
    
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = $_POST['password'];

        if($role == 'admin'){
          $confirm = mysqli_query($conn,"SELECT * FROM `admins` WHERE (`email` = '$email') AND (`password` = '$password') ") or die(mysqli_error($conn));
          if (mysqli_num_rows($confirm) > 0) {
              $admin = mysqli_fetch_array($confirm);
              $_SESSION['id'] = $admin['id'];
              echo "<script> alert('Login successful'); window.location.href = '../admin/dashboard.php'; </script>";
          } else {
              echo "<script> alert('Invalid email or password'); window.location.href = 'login.php'; </script>";
          }
        } else {

          $users = mysqli_query($conn, "SELECT * FROM `users` WHERE (`email` = '$email') AND (`role` = '$role') AND (`password` = '$password') ");
          $user = mysqli_fetch_array($users);

          if($user){
              $_SESSION['id'] = $user['id'];
              $_SESSION['name'] = $user['name'];
              $_SESSION['role'] = $db_role = $user['role'];
              if ($db_role === 'officer') {
                  $extra = '../details/all.php';
              } elseif ($db_role === 'voter') {
                  $extra = '../details/single.php?id='.$_SESSION['id'];
              } elseif ($db_role === 'admin') {
                  $extra = '../admin/dashboard.php';
              }
              $host = $_SERVER['HTTP_HOST'];
              $uri = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
              $link = "http://$host$uri/$extra";
              echo "<script>window.location.href='".$link."'</script>";
          }else{
              // $extra = "sign-in.php";
              // $host = $_SERVER['HTTP_HOST'];
              // $uri = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
              // $link = "http://$host$uri/$extra";
              // echo "<script>alert('Invalid login credentials. Please use correct details or Register.'); window.location.href='".$link."'</script>";
              echo "<script>alert('Invalid login credentials. Please try again.'); window.location.href='" . $_SERVER['PHP_SELF'] . "'; </script>";
          }
        }
    }

?>

<?php include("../layout/header.php"); ?>

<!-- ===== LOGIN ===== -->
<div class="flex flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-7 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
  </div>

  <div class="mt-10 bg-gray-50 p-7 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="#" method="POST">
      <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
          <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>
      
      <div>
        <label for="role" class="block text-sm font-medium text-gray-900 dark:text-white">Select your Role</label>
        <select id="role" name="role" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="voter">Voter</option>
            <option value="officer">Election Officer</option>
            <option value="admin">Admin</option>
        </select>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <hr>

      <p id="helper-text-explanation" class="mt-2 text-center text-sm text-gray-500 dark:text-gray-400">Don't have an account yet! You can <b>Register</b> as a <a href="voter_register.php" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Voter here</a> or as an <a href="officer_register.php" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Election Officer</a>.</p>
      
      <div>
        <button type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
      </div>
    </form>
  </div>
</div>
<!-- ===== /.LOGIN END ===== -->

<?php include("../layout/footer.php"); ?>