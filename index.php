<?php
require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);

function testInput($data)
{
    $data = trim($data);
    $data = strpslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["firstname"]) && isset($_POST["lastname"]))
    { // isset = si c'est validé
        if (empty($_POST["firstname"]) || empty($_POST["lastname"]))
        {
            echo "<p>Attention ce champ doit etre rempli</p>";
        }
        else {
            $firstname = testInput($_POST["firstname"]);
            $lastname = testInput($_POST["lastname"]);
            $query = "INSERT INTO friend (firstname, lastname)
            VALUES (:firstname, :lastname)";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':firstname', $firstname, PDO::PARAM_STR);
            $statement->bindValue(':lastname', $lastname, PDO::PARAM_STR);
            $statement->execute();
            header('Location: index.php');
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
</head>
<body>
    
    <form method="post">
        <div>
            <label for="firstname">Firstname</label>
            <input type="text" name="firstname" id="firstname"></input>
        </div>
        <div>
            <label for="lastname">Lastname</label>
            <input type="text" name="lastname" id="lastname"></input>
        </div>
        <div>
            <button type="Submit">Validate</button>
        </div>
    </form>
    <?php
    $query = "SELECT * FROM friend";
    $statement = $pdo->query($query);
    $friends = $statement->fetchAll();
    echo "<ul>";
    foreach($friends as $friend){
        echo "<li>Firstname: " . $friend['firstname'] . "/ Lastname: " . $friend['lastname'] . "</li><br>"; 
        }
        echo "</ul>";
    
    var_dump($friends);
    ?>
</body>
</html>



