<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Tableau</title>

</head>
<body>
    
<!-- Create the method for the form -->    
<section style="margin:2em 0;">
    <h2>Liste de commandes</h2>
    <form method="POST" action="">
    <input type="text" id="recherche" name="recherche">
    <button type="submit">Recherche</button>
</section>
    </form>

    
        // Create connection with server php
        <?php
        $user = 'root';
        $pass='';
        
        $dbh = new PDO('mysql:host=localhost;dbname=classicmodels',$user, $pass);

        $maRequete = $dbh->prepare("SELECT orderNumber,customerName,shippedDate,status FROM orders INNER JOIN customers ON customers.customerNumber=orders.customerNumber ORDER BY orderNumber ASC LIMIT 20 ");
        $maRequete->execute();
        $resultats = $maRequete->fetchAll();
        ?>


        
        <table class="table">
        <tr class="table-primary">
            <th>Commande</th>
            <th>Client</th>
            <th>Date de livraison</th>
            <th>Status</th>
        </tr>
        
           <!-- LOOP to show result-->
        <?php
            foreach ($resultats as $resultat):
            echo "<tr>";
            //foreach($ligne as $donnee):
        ?>
        <td><a href="fiche-commande.php?uq=<?= $resultat['orderNumber'];?>"><?= $resultat['orderNumber']; ?></a></td>
        <td><?= $resultat['customerName']; ?></td>
        <td><?= $resultat['shippedDate'];?></td>
        <td><?= $resultat['status']; ?></td>
        <?php
            //endforeach;
            echo "</tr>";
            endforeach;
        ?>
    </table>

</body>
</html>
