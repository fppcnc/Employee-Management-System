<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Department Editing</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="wrapper">
    <h1>
        <?php
        if (isset($_GET['id'])) {
            ?>
            Edit Department
            <?php
        } else {
            ?>
            Create Department
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

            <div class="row header blue">
                <div class="cell">
                    ID
                </div>
                <div class="cell">
                    Department Name
                </div>
                <div class="cell">
                    Action
                </div>
            </div>
            <div class="row">
                <div class="cell" data-title="ID">
                    <!--                Solution 1-->
                    <!--                <input type="number" class="ID" name="id" readonly value="-->
                    <?php //if (isset($department)) echo $department->getId(); ?><!--">-->
                    <!--                Solution 2-->
                    <?php
                    if (isset($department)) {
                        ?>
                        <input type="number" name="id" readonly
                               value="<?php if (isset($department)) echo $department->getId(); ?>">
                        <?php
                    }
                    ?>
                </div>
                <div class="cell" data-title="DepartmentName">
                    <input type="text" class="DepartmentName" name="name" required
                           value="<?php if (isset($department)) echo $department->getName(); ?>">
                </div>
                <div class="cell" data-title="Save">
                    <button type="submit" class="Save">Save</button>
                    <button type="reset" class="Reset">Reset</button>
                </div>
            </div>
            <div>
                <!--            for Error Report-->
            </div>

        </form>
    </div>
</div>
</body>
</html>