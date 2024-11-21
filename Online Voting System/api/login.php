<?php
session_start();
include("connect.php");

/*$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];*/
$mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
$password = mysqli_real_escape_string($connect, $_POST['password']);
$role = mysqli_real_escape_string($connect, $_POST['role']);

$check = mysqli_query($connect, "SELECT * FROM user WHERE mobile = '$mobile' AND role = '$role'");

if (mysqli_num_rows($check) > 0) {
    $userdata = mysqli_fetch_array($check);

    // Verify the hashed password
    if (password_verify($password, $userdata['password'])) {
        $groups = mysqli_query($connect, "SELECT * FROM user WHERE role = 2");
        $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

        $_SESSION['userdata'] = $userdata;
        $_SESSION['groupsdata'] = $groupsdata;

        echo '
        <script>
            window.location = "../routes/dashboard.php";
        </script>
        ';
    } else {
        echo '
        <script>
            alert("Invalid Credentials!");
            window.location = "../";
        </script>
        ';
    }
} else {
    echo '
    <script>
        alert("User not found!");
        window.location = "../";
    </script>
    ';
}

?>