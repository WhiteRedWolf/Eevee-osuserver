<?php
    session_start();
    include "../config.php";
    ;
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_POST["username"], hash("md5",$_POST["pass"]));

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows === 0){
        echo "wrong password";
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_POST["username"]);
    $response = $connection->query($check_privledge);

    if($response->num_rows > 0){
        while($row = $response->fetch_assoc()){
            if($row["privledge"] === "all"){
                all_privledges();
            } else if($row["privledge"] == "bat"){
                bat_privledges();
            } else if($row["privledge"] == "com"){
                com_privledges();
            }
        }
    }else {
        echo "no access, get away now";
    }
    function all_privledges(){
        echo "Welcome to this barebones admin panel <br/><br/> You have all Possible Privledges, you can: <br/><br/>";
        echo "Rank/Unrank Beatmaps, Ban Users, Add Staff <br/><br/><br/>";
        echo "<a href='rankingpanel.php?username=".''.$_POST["username"].''.'&pass='.hash("md5",$_POST["pass"]).''."'>Rank Beatmaps</a><br/>";
        echo "<a href='banpanel.php?username=".''.$_POST["username"].''.'&pass='.hash("md5",$_POST["pass"]).''."'>Ban Users</a><br/>";
        echo "<a href='staffadd.php?username=".''.$_POST["username"].''.'&pass='.hash("md5",$_POST["pass"]).''."'>Add Staff</a><br/>";
        echo "<br><a href='recalc.php?username=".''.$_POST["username"].''.'&pass='.hash("md5",$_POST["pass"]).''."'>Recalculate Scores for All Users</a><br/>";
    }
    function bat_privledges(){
        echo "Welcome to this barebones admin panel <br/><br/> You have BAT Privledges, you can: <br/><br/>";
        echo "Rank/Unrank Beatmaps<br/><br/><br/>";
        echo "<a href='rankingpanel.php?username=".''.$_POST["username"].''.'&pass='.hash("md5",$_POST["pass"]).''."'>Rank Beatmaps</a><br/>";

    }
    function com_privledges(){
        echo "Welcome to this barebones admin panel <br/><br/> You have COM Privledges, you can: <br/><br/>";
        echo "Ban Users<br/><br/><br/>";
        echo "<a href='banpanel.php?username=".''.$_POST["username"].''.'&pass='.hash("md5",$_POST["pass"]).''."'>Ban Users</a><br/>";

    }
?>