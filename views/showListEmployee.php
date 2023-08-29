<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee List</title>
</head>
<body>


<div class="wrapper">
    <h1>
        List Employee
        <link rel="stylesheet" href="css/style.css">
    </h1>
    <?php
    include 'views/navigation.php';
    ?>
    <div class="tableFixHead">
        <table>
            <thead>
            <tr>
                <th>
                    Id
                </th>

                <th>
                    First Name
                </th>
                <th>
                    Last Name
                </th>
                <th>
                    ID - Department
                </th>
                <th>
                    Delete
                </th>
                <th>
                    Edit
                </th>
            </tr>
            </thead>
            <?php foreach ($employees

            as $employee) {
            ?>
            <tr>
                <td data-title="Id">
                    <?php echo $employee->getId(); ?>
                </td>
                <td data-title="FirstName">
                    <?php echo $employee->getFirstName(); ?>
                </td>
                <td data-title="LastName">
                    <?php echo $employee->getLastName(); ?>
                </td>
                <td data-title="DepartmentID">
                    <?php echo $employee->getDepartmentId() . ' - ' . $employee->printDepartmentNameFromEmployeeDepartmentId(); ?>
                </td>
                <td data-title="Delete">
                    <a href='index.php?action=delete&&area=employee&id=<?php echo $employee->getId(); ?>'>
                        <button type="button" class="delete">Delete</button>
                    </a>
                </td>
                <td data-title="Edit">
                    <a href='index.php?action=showUpdate&area=employee&id=<?php echo $employee->getId(); ?>'>
                        <button type="button" class="update">Edit</button>
                    </a>
                </td>
                </tr>
                <?php
                }
                //        echo '<pre>';
                //        print_r($_POST);
                //        echo '</pre>';
                ?>
        </table>
    </div>
    </div>
</body>
</html>
