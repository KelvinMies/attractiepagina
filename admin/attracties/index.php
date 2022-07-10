<?php
session_start();
require_once '../backend/config.php';
if(!isset($_SESSION['user_id']))
{
    $msg = "Je moet eerst inloggen!";
    header("Location: $base_url/admin/login.php?msg=$msg");
    exit;
}
?>

<!doctype html>
<html lang="nl">

<head>
    <title>Attractiepagina / Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/main.css">
    <link rel="icon" href="<?php echo $base_url; ?>/favicon.ico" type="image/x-icon" />
</head>

<body>

    <?php require_once '../../header.php'; ?>

    <div class="container">

        <a href="create.php">Nieuwe attractie maken &gt;</a>

        <?php
        if (empty($_GET['status'])) 
        {
            require_once '../backend/conn.php';
            $query = "SELECT * FROM rides";
            $statement = $conn->prepare($query);
            $statement->execute();
            
        }
        elseif (!empty($_GET['status']) && ($_GET['status'] == "min_length")) 
        {
            require_once '../backend/conn.php';
            $query = "SELECT * FROM rides ORDER BY min_length DESC";
            $statement = $conn->prepare($query);
            $statement->execute();
        }
        elseif (!empty($_GET['status']) && ($_GET['status'] == "themeland")) 
        {
            require_once '../backend/conn.php';
            $query = "SELECT * FROM rides ORDER BY themeland ASC";
            $statement = $conn->prepare($query);
            $statement->execute();
        }
        else 
        {
            require_once '../backend/conn.php';
            $query = "SELECT * FROM rides ORDER BY title DESC";
            $statement = $conn->prepare($query);
            $statement->execute();
            
        }
        $rides = $statement->fetchAll(PDO::FETCH_ASSOC);
         
        
        ?>
        <h1>Aantal attracties in deze lijst:<?php echo count($rides) ?></h1>

        <form action="" method="GET">
            <select name="status">
                <option value="">Kies status om te filteren</option>
                <option value="title">Titel</option>
                <option value="min_length">Minimale lengte</option>
                <option value="themeland">Themagebied</option>
            </select>      
            <input type="submit" value="filter">   
        </form>

        <table>
            <tr>
                <th>Titel</th>
                <th>Themagebied</th>
                <th>Min. lengte</th>
                <th>Fastpass</th>
            </tr>
            <?php foreach($rides as $ride): ?>
                <tr>
                    <td><?php echo $ride['title']; ?></td>
                    <td><?php echo $ride['themeland']; ?></td>
                    <td><?php echo $ride['min_length']; ?></td>
                    <td><?php echo $ride['fast_pass']; ?></td>
                    <td><a href="edit.php?id=<?php echo $ride['id']; ?>">aanpassen</a></td>
                </tr>
            <?php endforeach; ?>
        </table>


    </div>


    
</body>

</html>
