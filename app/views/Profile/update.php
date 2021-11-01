<html>
    <head>
        <title>Update Profile</title>
    </head>

    <body>
        <a href="<?=BASE?>Profile/index">Return</a>

        <form action="" method ="post">
            <label>Change First Name</label><input type="text" name="first_name"><br>
            <label>Change Middle Name</label><input type="text" name="middle_name"><br>
            <label>Change Last Name</label><input type="text" name="last_name"> <br>

            <!-- <label>Change Password</label><input type="text" name="password"><br>
            <label>Enter New Password Again</label><input type="text" name="password_2"> <br> -->

            <input type="submit" name='action' value='Update Profile'>
        </form>
    </body>
</html>