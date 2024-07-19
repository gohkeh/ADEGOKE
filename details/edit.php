<?php 
session_start();
    
    // Config
    include ('../config.php');

    $urlID = $_GET['id'];
    $uniqueVoter = mysqli_query($conn, "SELECT * FROM `users` WHERE (`id` = '$urlID') ");
    $unique = mysqli_fetch_array($uniqueVoter);

    if (isset($_POST["submit"])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $role = $_POST['role'];
        $idno = $_POST['idno'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $pstation = $_POST['pstation'];
        $password = $_POST['password'];
        // Picture Upload
        $updir = "../uploads/voters/";
        $image = $_FILES["picture"]["name"];
        $imgTemp1 = $_FILES["picture"]["tmp_name"];
        if($image){
            $imgExt1 = strtolower(pathinfo($image,PATHINFO_EXTENSION));
            $pictureLink = 'updatedvoter'.'_'.rand(10000,99999).'.'.$imgExt1;
            move_uploaded_file($imgTemp1,$updir.$pictureLink);
        }else{
            die('no image');
        }

        $msg = mysqli_query($conn, "UPDATE `users` SET `name`='$name',`email`='$email',`username`='$username',`role`='$role',`idno`='$idno',`pstation`='$pstation',`phone`='$phone',`address`='$address',`picture`='$pictureLink',`password`='$password' WHERE `id` = '$urlID' ");
        if ($msg) {
            $extra = "single.php?id=".$urlID;
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $link = "http://$host$uri/$extra";
            $_SESSION['success'] = "You have updated your Voter's details successfully.";
            header("Location: $link"); 
            exit();
        } else {
            echo "<script>alert('Invalid update credentials. Please try again.'); window.location.href='" . $_SERVER['PHP_SELF'] . "'; </script>";
        }
    }

?>

<?php include("../layout/header.php"); ?>

<!-- ===== REGISTER ===== -->
<div class="flex flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-7 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Update Voter's Record</h2>
  </div>

  <div class="mt-10 bg-white p-7 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="" method="POST" enctype="multipart/form-data">

      <div class="space-y-2">
        <h1 class="block text-sm font-medium leading-6 text-gray-900">Personal Details</h1>
        <div class="relative">
            <input type="text" name="name" id="name" value="<?= $unique['name'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Name</label>
        </div>
        <div class="relative">
            <input type="text" name="address" id="address" value="<?= $unique['address'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="address" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Address</label>
        </div>
      </div>

      <div class="space-y-2">
        <h1 class="block text-sm font-medium leading-6 text-gray-900">Contact Details</h1>
        <div class="relative">
            <input type="email" name="email" id="email" value="<?= $unique['email'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Email</label>
        </div>
        <div class="relative">
            <input type="phone" name="phone" id="phone" value="<?= $unique['phone'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="phone" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Phone Number</label>
        </div>
      </div>

      <div class="space-y-2">
        <h1 class="block text-sm font-medium leading-6 text-gray-900">Voting Details</h1>
        <div class="relative">
            <input type="number" name="idno" id="idno" value="<?= $unique['idno'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " maxlength="10" oninput="this.value=this.value.slice(0,10)" />
            <label for="idno" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">ID Number</label>
        </div>
        <div class="relative">
            <select name="pstation" id="pstation" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <option value="Scotland">Scotland</option>
                <option value="Manchester">Manchester</option>
                <option value="DebbyCounty">DebbyCounty</option>
                <option value="Sunderland">Sunderland</option>
                <option value="Norwich">Norwich</option>
            </select>
            <label for="pstation" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Polling Station</label>
        </div>
      </div>

      <div class="space-y-2">
        <h1 class="block text-sm font-medium leading-6 text-gray-900">Profile Picture</h1>
        <div class="relative">
            <p class="text-sm text-gray-500 mb-2">Preview:</p>
            <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg mb-3">
              <img src="../uploads/voters/<?= $unique['picture'] ?>" width="300" alt="Default DP" class="h-full w-full object-cover object-center">
            </div>
            <p class="text-sm text-gray-500 mb-2">Update:</p>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" name="picture" type="file">
            <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">For best output, file upload max size is 768x512px</div>
        </div>
      </div>

      <div class="space-y-2">
        <h1 class="block text-sm font-medium leading-6 text-gray-900">Account Details</h1>
        <div class="relative">
            <input type="text" name="username" id="username" value="<?= $unique['username'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="username" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Username</label>
        </div>
        <div class="relative">
            <input type="text" id="role" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " disabled />
            <label for="role" class="absolute text-sm text-gray-400 dark:text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Voter Role</label>
            <input type="hidden" name="role" value="voter" />
        </div>
        <div class="relative">
            <input type="password" name="password" id="password" value="<?= $unique['password'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="password" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Password</label>
        </div>
        <div class="relative">
            <input type="password" name="cpassword" id="cpassword" value="<?= $unique['password'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="cpassword" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Confirm Password</label>
        </div>
      </div>
      
      <div>
        <button type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">UPDATE</button>
      </div>
    </form>
  </div>
</div>
<!-- ===== /.REGISTER END ===== -->

<?php include("../layout/footer.php"); ?>