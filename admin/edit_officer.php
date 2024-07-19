<?php
session_start();

    include ('../config.php');

    $urlID = $_GET['id'];
    $uniqueOfficer = mysqli_query($conn, "SELECT * FROM `users` WHERE (`id` = '$urlID') ");
    $unique = mysqli_fetch_array($uniqueOfficer);

    if (isset($_POST["submit"])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        // Picture Upload
        $updir = "../uploads/voters/";
        $image = $_FILES["picture"]["name"];
        $imgTemp1 = $_FILES["picture"]["tmp_name"];
        if($image){
            $imgExt1 = strtolower(pathinfo($image,PATHINFO_EXTENSION));
            $pictureLink = 'updatedofficer'.'_'.rand(10000,99999).'.'.$imgExt1;
            move_uploaded_file($imgTemp1,$updir.$pictureLink);
        }else{
            die('no image');
        }
        $msg = mysqli_query($conn, "UPDATE `users` SET `name`='$name',`email`='$email',`username`='$username',`role`='$role',`picture`='$pictureLink',`password`='$password' WHERE `id` = '$urlID' ");
        if ($msg) {
            $extra = 'officers.php';
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $link = "http://$host$uri/$extra";
            $_SESSION['success'] = "You have updated the Officer's details successfully.";
            header("Location: $link"); 
            exit();
        } else {
            echo "<script>alert('Invalid update credentials. Please try again.'); window.location.href='" . $_SERVER['PHP_SELF'] . "'; </script>";
        }
    }

?>

<?php include("header.php"); ?>

<div class="w-full overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Edit Officer's Details</h1>

        <!-- <div class="w-full mt-7"></div> -->
        <div class="mt-7 bg-white p-7 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="" method="POST" enctype="multipart/form-data">

            <div class="space-y-2">
                <h1 class="block text-sm font-medium leading-6 text-gray-900"><b>Contact Details</b></h1>
                <div class="relative">
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($unique['name']) ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Name</label>
                </div>
                <div class="relative">
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($unique['email']) ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Email</label>
                </div>
            </div>

            <div class="space-y-2">
                <h1 class="block text-sm font-medium leading-6 text-gray-900">Profile Picture</h1>
                <div class="relative">
                    <p class="text-sm text-gray-500 mb-2">Preview previous:</p>
                    <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg mb-3">
                        <img src="../uploads/voters/<?= $unique['picture'] ?>" width="300" alt="Default DP" class="h-full w-full object-cover object-center">
                    </div>
                    <p class="text-sm text-gray-500 mb-2">Update:</p>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" name="picture" type="file">
                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">For best output, file upload max size is 768x512px</div>
                </div>
            </div>
            
            <div class="space-y-2">
                <h1 class="block text-sm font-medium leading-6 text-gray-900"><b>Account Details</b></h1>
                <div class="relative">
                    <input type="text" name="username" id="username" value="<?= htmlspecialchars($unique['username']) ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="username" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Username</label>
                </div>
                <div class="relative">
                    <input type="text" id="role" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " disabled />
                    <label for="role" class="absolute text-sm text-gray-400 dark:text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Election Officer Role</label>
                    <input type="hidden" name="role" value="officer" />
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" value="<?= htmlspecialchars($unique['password']) ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="password" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Password</label>
                </div>
                <div class="relative">
                    <input type="password" name="cpassword" id="cpassword" value="<?= htmlspecialchars($unique['password']) ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="cpassword" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Confirm Password</label>
                </div>
            </div>
            
            <div>
                <button type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">UPDATE</button>
            </div>
            </form>
        </div>
    </main>

<?php include("footer.php"); ?>