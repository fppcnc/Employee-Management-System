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
    <div class="tableFixHead">
        <table>
            <form method="post" action="index.php">
                <input type="hidden" name="area" value="department">
                <input type="hidden" name="action" value="<?php echo (isset($department)) ? 'update' : 'create'; ?>">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Department Name
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                </thead>
                <tr>
                    <td data-title="ID">
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
                    </td>
                    <td data-title="DepartmentName">
                        <input type="text" class="DepartmentName" name="name" required
                               value="<?php if (isset($department)) echo $department->getName(); ?>">
                    </td>
                    <td data-title="Save">
                        <button type="submit" class="Save">Save</button>
                        <button type="reset" class="Reset">Reset</button>
                    </td>
                </tr>
                <div>
                    <!--            for Error Report-->
                </div>

            </form>
        </table>
    </div>
</div>
</body>
</html>