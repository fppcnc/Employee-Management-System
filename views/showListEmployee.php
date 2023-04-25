<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>

<?php

//echo '<pre>';
//print_r($employees);
//echo '</pre>';

?>
<div class="wrapper">
    <h1>
        <title>Mitarbeiter Liste</title>
        <link rel="stylesheet" href="css/style.css">
    </h1>
    <?php
    include 'views/navigation.php';
    ?>
    <div class="table">
        <div class="row header">
            <div class="cell">
                Id
            </div>
            <div class="cell">
                Vorname
            </div>
            <div class="cell">
                Nachname
            </div>
            <div class="cell">
                Abteilung
            </div>
            <div class="cell">
                Löschen
            </div>
            <div class="cell">
                Ändern
            </div>
        </div>
        <?php foreach ($employees as $employee) {
            ?>
            <div class="row">
                <div class="cell" data-title="Id">
                    <?php echo $employee->getId(); ?>
                </div>
                <div class="cell" data-title="Vorname">
                    <?php echo $employee->getFirstName(); ?>
                </div>
                <div class="cell" data-title="Nachname">
                    <?php echo $employee->getLastName(); ?>
                </div>
                <div class="cell" data-title="AbteilungId">
                    <?php echo $employee->getDepartmentId(); ?>
                </div>
                <div class="cell" data-title="Löschen">
                    <a href='index.php?action=delete&&area=employee&id=<?php echo $employee->getId(); ?>'>
                        <button type="button" class="delete">Löschen</button>
                    </a>
                </div>
                <div class="cell" data-title="Ändern">
                    <a href='index.php?action=showUpdate&area=employee&id=<?php echo $employee->getId(); ?>'>
                        <button type="button" class="update">Ändern</button>
                    </a>
                </div>
            </div>
            <?php
        }
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
        ?>
    </div>
</div>
</body>
</html>
