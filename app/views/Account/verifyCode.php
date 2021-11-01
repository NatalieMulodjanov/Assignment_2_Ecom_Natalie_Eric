<html>

<head>
    <title>Verify code</title>
</head>

<?php 
    if (isset($data)){
        echo $data;
    }
?>

<body>
    <label for="Please enter your code"></label>
    <form method="post" action="">
        <label>Current code:<input type="text" name="currentCode" /></label>
        <input type="submit" name="action" value="Verify code" />
    </form>
</body>

</html>