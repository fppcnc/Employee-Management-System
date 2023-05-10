<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abteilung Bearbeiten</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="wrapper">
    <h1>
        <?php
        if (isset($_GET['id'])) {
            ?>
            Abteilung editieren
            <?php
        } else {
            ?>
            Abteilung erstellen
            <?php
        }
        ?>
    </h1>
    <?php
    include 'views/navigation.php';
    ?>
    <div class="table">
        <form method="post" action="index.php">
            <input type="hidden" name="area" value="department">
            <input type="hidden" name="action" value="<?php echo (isset($department)) ? 'update' : 'create'; ?>">
            <!--//        shorthand for ->:-->
            <!--//            if (isset($department)) {-->
            <!--//                echo 'update';-->
            <!--//            } else {-->
            <!--//                echo 'create';-->
            <!--//            };-->

            <div class="row header blue">
                <div class="cell">
                    ID
                </div>
                <div class="cell">
                    Abteilungsname
                </div>
                <div class="cell">
                    Aktion
                </div>
            </div>
            <div class="row">
                <div class="cell" data-title="ID">
                    <!--                Möglichkeit 1-->
                    <!--                <input type="number" class="ID" name="id" readonly value="-->
                    <?php //if (isset($department)) echo $department->getId(); ?><!--">-->
                    <!--                Möglichkeit 2-->
                    <?php
                    if (isset($department)) {
                        ?>
                        <input type="number" name="id" readonly
                               value="<?php if (isset($department)) echo $department->getId(); ?>">
                        <?php
                    }
                    ?>
                </div>
                <div class="cell" data-title="Abteilungsname">
                    <input type="text" class="Abteilungsname" name="name" required
                           value="<?php if (isset($department)) echo $department->getName(); ?>">
                </div>
                <div class="cell" data-title="Speichern">
                    <button type="submit" class="Save">Speichern</button>
                    <button type="reset" class="Reset">Reset</button>
                </div>
            </div>
            <div>
                <!--            für Fehlermeldung-->
            </div>

        </form>
    </div>
</div>
</body>
</html>