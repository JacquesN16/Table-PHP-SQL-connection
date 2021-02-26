<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Fiche-commande</title>
</head>
<body>


<?php 
    $user = 'root';
    $pass='';

    $dbh = new PDO('mysql:host=localhost;dbname=classicmodels',$user, $pass);
       $maRequeteClient = $dbh->prepare("SELECT customerName,contactLastName,contactFirstName,addressLine1,customers.customerNumber 
       FROM customers 
       INNER JOIN orders 
       ON orders.customerNumber=customers.customerNumber 
       WHERE orderNumber= " .implode($_GET) );
       $maRequeteClient->execute();
       $resultatsClient = $maRequeteClient->fetchAll();

       $maRequeteProduit=$dbh->prepare("SELECT orderdetails.orderNumber, orderdetails.productCode,priceEach, productName,quantityOrdered, priceEach*quantityOrdered AS priceTotal 
       FROM `orderdetails`
       INNER JOIN products ON products.productCode=orderdetails.productCode
       INNER JOIN orders ON orders.orderNumber = orderdetails.orderNumber
       WHERE orderdetails.orderNumber = ".implode($_GET) );
       $maRequeteProduit->execute();
       $resultatsProduit = $maRequeteProduit->fetchALL();


?>       
<section style="margin: 2em 0 0">
    <h2>Bon de commande n° <?=implode($_GET); ?></h2>
    
    <hr>
    <p><a href="tableau.php">Retourne à l'acceuil </a></p>
</section>
<?php



foreach ($resultatsClient as $resultatClient):
    ?>
    <div style="margin-left:80%; width:20%,">
    <h2><?= $resultatClient['customerName']; ?></h2>
    <p><?= $resultatClient['contactLastName']; ?> <span><?= $resultatClient['contactFirstName']; ?></span></p>
    
    <p><?= $resultatClient['addressLine1']; ?></p>
    </div>
<?php 
endforeach;
?>

<table class="table">
        <tr class="table-primary">
            <th>Produit</th>
            <th>P.U</th>
            <th>Quantité</th>
            <th>Prix Total</th>
        </tr>

<?php
    foreach($resultatsProduit as $resultatProduit):
        echo "<tr>";
?>
<td><?= $resultatProduit['productName']; ?></td>
<td><?= $resultatProduit['priceEach'];?> </td>
<td><?= $resultatProduit['quantityOrdered']; ?></td>
<td><?= $resultatProduit['priceTotal']?></td>

<?php
echo "<tr>";
    endforeach;
    $ht=0;
    foreach($resultatsProduit as $detail){
        $ht+=$detail['priceTotal'];
    };

?>
        <tr>
            <td>Montant Total HT</td>
            <td><?= $ht; ?></td>
        </tr>
        <tr>
            <td>TVA 20%</td>
            <td><?php $tva = $ht*20/100;
                    echo $tva;
            ?></td>
        </tr>
        <tr>
            <td>Montant Total TTC</td>
            <td><?= $ht+$tva;?></td>
        </tr>
</table>
</body>
</html>