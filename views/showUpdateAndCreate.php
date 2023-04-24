<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eingabe Formular</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1 style="color: white">Mitarbeiter ändern</h1>
<div class="wrapper">
    <a href="index.php?action=showList">
        <button>Liste</button>
    </a>
    <div class="table">
        <form method="post" action="index.php">
            <input type="hidden" name="action" value="<?php echo (isset($employee)) ? 'update' : 'create'; ?>">
            <!--            // shorthand für If - else-->
            <!--            -->
            <!--            if (isset($employee)) {-->
            <!--                echo 'update';-->
            <!--            } else {-->
            <!--                echo 'create';-->
            <!--            }-->

            <div class="row header">
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
                    <!-- Möglichkeit 1 -->
                    <!-- <input type="text" class="ID" name="id" readonly value="<?php if (isset($employee)) echo $employee->getId(); ?>"> -->
                    <!-- Möglichkeit 2 -->
                    <?php
                    if (isset($employee)) {
                        ?>
                        <input type="hidden" name="id" value="<?php echo $employee->getId(); ?>">
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
                <div class="cell" data-title="AbteilungID">
                    <input type="number" class="AbteilungID" name="departmentId" required
                           value="<?php if (isset($employee)) echo $employee->getDepartmentId(); ?>">
                </div>
                <div class="cell" data-title="Speichern">
                    <button type="submit" class="Save"><span style="color: #27ae60">✔</span></button>
                    <button type="reset" class="Reset"><span style="color: #27ae60">Reset</span></button>
                </div>
            </div>
        </form>
    </div>
    <div>
        <!-- für Fehlermeldung -->
    </div>
</div>
</body>
</html>
