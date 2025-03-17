<?php 

    session_start()   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php include('layout/header.php') ?>



<h1>Selamat Datang <?php echo $_SESSION["username"] ?></h1>


<?php include('layout/footer.php') ?>



</body>
</html>