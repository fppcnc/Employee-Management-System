<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Editing</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="wrapper">
    <h1>
        <?php
        if (isset($_GET['id'])) {
            ?>
            Edit Employee
            <?php
        } else {
            ?>
            Create Employee
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
                <input type="hidden" name="area" value="employee">
                <input type="hidden" name="action" value="<?php echo (isset($employee)) ? 'update' : 'create'; ?>">
                <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        First Name
                    </th>
                    <th>
                        Last Name
                    </th>
                    <th>
                        Department
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
                        <?php //if (isset($employee)) echo $employee->getId(); ?><!--">-->
                        <!--                Solution 2-->
                        <?php
                        if (isset($employee)) {
                            ?>
                            <input type="hidden" name="id"
                                   value="<?php if (isset($employee)) echo $employee->getId(); ?>">
                            <?php
                        }
                        ?>
                    </td>
                    <td data-title="FirstName">
                        <input type="text" class="FirstName" name="firstName" required
                               value="<?php if (isset($employee)) echo $employee->getFirstName(); ?>">
                    </td>
                    <td data-title="LastName">
                        <input type="text" class="LastName" name="lastName" required
                               value="<?php if (isset($employee)) echo $employee->getLastName(); ?>">
                    </td>
                    <td data-title="DepartmentID">
                        <?php $preselected = (isset($employee)) ? $employee->getDepartmentId() : null;
                        echo HtmlHelper::buildSelectOption($departments, 'departmentId', $preselected) ?>
                    </td>
                    <td data-title="Save">
                        <button type="submit" class="Save">Save</button>
                        <button type="reset" class="Reset">Reset</button>
                    </td>
                </tr>
                <div>
                    <!--            for Error report-->
                </div>

            </form>
        </table>
        </div>
        </div>
</body>
</html>
