<html>
    <head>
        <title>Create a Profile</title>
    </head>

    <body>
        <a href="<?=BASE?>Profile/index">Return</a>

        <form action="" method ="post">
            <label>Enter First Name</label><input type="text" name="first_name"><br>
            <label>Enter Middle Name</label><input type="text" name="middle_name"><br>
            <label>Enter Last Name</label><input type="text" name="last_name"> <br>
            <input type="submit" name='action' value='Create Profile'>
        </form>
    </body>
</html>