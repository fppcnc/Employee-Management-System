<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mitarbeiter Bearbeiten</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>
    <?php
    if (isset($_GET['id'])) {
        ?>
        Mitarbeiter editieren
        <?php
    } else {
        ?>
        Mitarbeiter erstellen
        <?php
    }
    ?>
</h1>
    <div class="wrapper">
    <nav>
        <a href="index.php?action=showList">
            <button>Zurück zur Liste</button>
        </a>
    </nav>
    <div class="table">
        <form method="post" action="index.php">
            <input type="hidden" name="action" value="<?php echo (isset($employee)) ? 'update' : 'create';?>">
<!--//        shorthand for ->:-->
<!--//            if (isset($employee)) {-->
<!--//                echo 'update';-->
<!--//            } else {-->
<!--//                echo 'create';-->
<!--//            };-->

            <div class="row header blue">
                <div class="cell">
                    ID
                </div>
                <div class="cell">
                    Vorname
                </div>
                <div class="cell">
                    Nachname
                </div>
                <div class="cell">
                    AbteilungID
                </div>
                <div class="cell">
                    Aktion
                </div>
            </div>
            <div class="row">
                <div class="cell" data-title="ID">
                    <!--                Möglichkeit 1-->
                    <!--                <input type="number" class="ID" name="id" readonly value="-->
                    <?php //if (isset($employee)) echo $employee->getId(); ?><!--">-->
                    <!--                Möglichkeit 2-->
                    <?php
                    if (isset($employee)) {
                        ?>
                        <input type="hidden" name="id" value="<?php if (isset($employee)) echo $employee->getId(); ?>">
                    <?php
                    }
                    ?>
                </div>
                <div class="cell" data-title="Vorname">
                    <input type="text" class="Vorname" name="firstName" required
                           value="<?php if (isset($employee)) echo $employee->getFirstName(); ?>">
                </div>
                <div class="cell" data-title="Nachname">
                    <input type="text" class="Nachname" name="lastName" required
                           value="<?php if (isset($employee)) echo $employee->getLastName(); ?>">
                </div>
                <div class="cell" data-title="AbteilungId">
                    <input type="number" class="AbteilungId" name="departmentId" required
                           value="<?php if (isset($employee)) echo $employee->getDepartmentId(); ?>">
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
