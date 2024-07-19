<?php
session_start();

    // Check if user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: ../auth/login.php");
        exit();
    }

    include ('../config.php');

    # DELETE BUTTON
    if((isset($_GET['func'])) && ($_GET['func'] == 'delete')){
        $deleteID = $_GET['id'];
        $delete = mysqli_query($conn, "DELETE FROM `users` WHERE `id` = '$deleteID' ");
        
        if($delete){
            $extra = "dashboard.php";
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
            $link = "http://$host$uri/$extra";
            $_SESSION['success'] = "You have deleted this user successfully.";
            header("Location: $link"); 
            exit();
        } else {
            echo "<script>alert('Something went wrong. Please try again.'); window.location.href='" . $link . "'; </script>";
        }
    }

    // Counters
    $voters = mysqli_query($conn, " SELECT COUNT(*) AS row_count FROM `users` WHERE `role` = 'voter' ");
    $voter = mysqli_fetch_array($voters); 

    $officers = mysqli_query($conn, " SELECT COUNT(*) AS row_count FROM `users` WHERE `role` = 'officer' ");
    $officer = mysqli_fetch_array($officers); 

    $messages = mysqli_query($conn, " SELECT COUNT(*) AS row_count FROM `contacts` ");
    $message = mysqli_fetch_array($messages); 

    $admins = mysqli_query($conn, " SELECT COUNT(*) AS row_count FROM `admins` ");
    $admin = mysqli_fetch_array($admins); 

    // Table
    $users = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `id` DESC ");

?>

<?php include("header.php"); ?>

<div class="w-full overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Dashboard</h1>

        <?php if (isset($_SESSION['success'])) { ?>
        <div id="alert-border-3" class="w-full flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4 mr-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium mr-4"><?= $_SESSION['success'] ?></div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-3" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        <?php session_destroy(); } ?>

        <!-- COUNTER -->
        <div class="flex flex-wrap mt-3">
            <div class="w-full lg:w-1/2 pr-0 lg:pr-2">
                <a href="voters.php" class="block max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-yellow-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-yellow-700">
                    <div class="flex justify-between items-center">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><i class="fa fa-users mr-3" aria-hidden="true"></i> Voters</h5>
                        <h3 class="text-xl font-bold text-gray-700"><?= $voter['row_count']; ?></h3>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">This represents the total number of voters registered in the system.</p>
                </a>
            </div>
            <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-6 lg:mt-0">
                <a href="officers.php" class="block max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-green-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-green-700">
                    <div class="flex justify-between items-center">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><i class="fa fa-user-tie mr-3" aria-hidden="true"></i> Election Officers</h5>
                        <h3 class="text-xl font-bold text-gray-700"><?= $officer['row_count']; ?></h3>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">This represents the total number of officers registered in the system.</p>
                </a>
            </div>
            <div class="w-full lg:w-1/2 pr-0 lg:pr-2 mt-6 lg:mt-6">
                <a href="messages.php" class="block max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-blue-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-blue-700">
                    <div class="flex justify-between items-center">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><i class="fa fa-comment mr-3" aria-hidden="true"></i> Contact Messages</h5>
                        <h3 class="text-xl font-bold text-gray-700"><?= $message['row_count']; ?></h3>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">This represents the total number of messages received from the contact form.</p>
                </a>
            </div>
            <div class="w-full lg:w-1/2 pl-0 lg:pl-2 mt-6 lg:mt-6">
                <a href="#" class="block max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-red-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-red-700">
                    <div class="flex justify-between items-center">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><i class="fa fa-user-shield mr-3" aria-hidden="true"></i> Admins</h5>
                        <h3 class="text-xl font-bold text-gray-700"><?= $admin['row_count']; ?></h3>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">This represents the total number of administrators managing the system.</p>
                </a>
            </div>
        </div>

        <!-- TABLE -->
        <div class="w-full mt-12">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-list mr-3"></i> Latest Users
            </p>
            <div class="bg-white overflow-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <!-- <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Name</th> -->
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">S/N</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Profile</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Username</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Role</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ID-No</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Polling Station</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Phone</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Address</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Created At</th>
                            <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                    <?php $id = 1; foreach ($users as $user) { ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="text-center py-3 px-2"><?= $id++; ?></td>
                            <td class="text-center py-3 px-2"><a href="../uploads/voters/<?= $user['picture']; ?>" target="_blank"><img src="../uploads/voters/<?= $user['picture']; ?>" style="height:30px;"></img></a></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['name']) ?></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['role']) ?></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['idno']) ?></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['pstation']) ?></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['phone']) ?></td>
                            <td class="text-left py-3 px-4"><?= htmlspecialchars($user['address']) ?></td>
                            <td class="text-left py-3 px-4"><?= $user['created_at'] ?></td>
                            <?php $edit_link = ($user['role'] == 'officer') ? "edit_officer.php?id={$user['id']}" : (($user['role'] == 'voter') ? "edit_voter.php?id={$user['id']}" : "#"); ?>
                            <td class="text-center py-3 px-4"><a href="<?= $edit_link ?>" class="text-blue-700 hover:text-blue-500 mr-3"><i class="fa fa-edit"></i></a><a href="dashboard.php?id=<?= $user['id']; ?>&func=delete" class="text-red-700 hover:text-red-500 delete-link-<?= $user['id']; ?>"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const deleteLinks = document.querySelectorAll('.delete-link-<?= $user['id']; ?>');

                                deleteLinks.forEach(function(link) {
                                    link.addEventListener('click', function(event) {
                                        // Prevent the default action of clicking the link
                                        event.preventDefault();

                                        // Ask for confirmation before proceeding
                                        const confirmation = window.confirm("Are you sure you want to delete this user's record?");
                                        
                                        // If user confirms, navigate to the specified link
                                        if (confirmation) {
                                            window.location.href = link.href;
                                        }
                                    });
                                });
                            });
                        </script>
                    <?php } ?>
                        <!-- <tr class="bg-gray-200">
                            <td class="w-1/3 text-left py-3 px-4">Emma</td>
                            <td class="w-1/3 text-left py-3 px-4">Johnson</td>
                            <td class="text-left py-3 px-4"><a class="hover:text-blue-500" href="tel:622322662">622322662</a></td>
                            <td class="text-left py-3 px-4"><a class="hover:text-blue-500" href="mailto:jonsmith@mail.com">jonsmith@mail.com</a></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

<?php include("footer.php"); ?>