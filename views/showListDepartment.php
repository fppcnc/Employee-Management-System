<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<link rel="stylesheet" href="css/style.css">
<div class="wrapper">
    <h1>Abteilung Liste

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
                Abteilungsname
            </div>
            <div class="cell">
                Löschen
            </div>
            <div class="cell">
                Ändern
            </div>
            <div class="cell">
                Zugehörige Mitarbeiter
            </div>

        </div>
        <?php foreach ($departments as $department) {
            ?>
            <div class="row">
                <div class="cell" data-title="Id">
                    <?php echo $department->getId(); ?>
                </div>
                <div class="cell" data-title="Abteilungsname">
                    <?php echo $department->getName(); ?>
                </div>
                <div class="cell" data-title="Löschen">
                    <a href='index.php?action=delete&&area=department&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="delete">Löschen</button>
                    </a>
                </div>
                <div class="cell" data-title="Ändern">
                    <a href='index.php?action=showUpdate&area=department&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="update">Ändern</button>
                    </a>
                </div>
                <div class="cell" data-title="Zugehörige Mitarbeiter">
                    <a href='index.php?action=employeesToDepartment&area=employee&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="zugehoerigeMitarbeiter">Zugehörige Mitarbeiter</button>
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
