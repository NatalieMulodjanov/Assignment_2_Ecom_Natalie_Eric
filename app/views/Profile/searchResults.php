<html>
    <head>
        <title>Search Results</title>
    </head>

    <body>
        <h1>Search Results</h1>

        <?php
            foreach($data as $profile){
                echo "<a href='" . BASE . "Profile/GoToProfile/".$profile->profile_id."'>$profile->first_name $profile->last_name</a>";
                echo "</br>";
            }
        ?>

    </body>
</html>