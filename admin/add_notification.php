<?php
session_start();

    include ('../config.php');

    if (isset($_POST['submit'])) {

        $topic = $_POST['topic'];
        $about = $_POST['about'];
        $details1 = $_POST['details1'];
        $details2 = $_POST['details2'];
        $details3 = $_POST['details3'];
        $msg = mysqli_query($conn, "INSERT INTO `settings` (`topic`, `about`, `details1`, `details2`, `details3`) VALUES ('$topic','$about','$details1','$details2','$details3')");
    
        if ($msg) {
            $extra = 'dashboard.php';
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $link = "http://$host$uri/$extra";
            $_SESSION['success'] = "You have uploaded a new Notification successfully.";
            header("Location: $link"); 
            exit();
        } else {
            echo "<script>alert('Invalid credentials. Please try again.'); window.location.href='" . $_SERVER['PHP_SELF'] . "'; </script>";
        }

    }

    $settings = mysqli_query($conn, "SELECT * FROM `settings` ORDER BY `id` DESC LIMIT 1");
    $setting = mysqli_fetch_array($settings);

?>

<?php include("header.php"); ?>

<div class="w-full overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Update Announcement</h1>

        <!-- <div class="w-full mt-7"></div> -->
        <div class="mt-7 bg-white p-7 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="" method="POST">

            <div class="space-y-2">
                <h1 class="block text-sm font-medium leading-6 text-gray-900"><b>Heading</b></h1>
                <div class="relative">
                    <input type="text" name="topic" id="topic" value="<?= $setting['topic'] ?>" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="topic" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Topic</label>
                </div>
                <div class="relative">
                    <textarea type="text" name="about" id="about" rows="5" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "><?= $setting['about'] ?></textarea>
                    <label for="about" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Short About</label>
                </div>
            </div>
            
            <div class="space-y-2">
                <h1 class="block text-sm font-medium leading-6 text-gray-900"><b>More Details</b></h1>
                <div class="relative">
                    <textarea type="text" name="details1" id="details1" rows="6" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "><?= $setting['details1'] ?></textarea>
                    <label for="details1" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">First Details</label>
                </div>
                <div class="relative">
                    <textarea type="text" name="details2" id="details2" rows="6" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "><?= $setting['details2'] ?></textarea>
                    <label for="details2" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Second Details</label>
                </div>
                <div class="relative">
                    <textarea type="text" name="details3" id="details3" rows="6" class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" "><?= $setting['details3'] ?></textarea>
                    <label for="details3" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Third Details</label>
                </div>
            </div>
            
            <div>
                <button type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">UPLOAD</button>
            </div>
            </form>
        </div>
    </main>

<?php include("footer.php"); ?>