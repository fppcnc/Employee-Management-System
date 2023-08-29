<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Department List</title>
</head>
<body>

<link rel="stylesheet" href="css/style.css">
<div class="wrapper">
    <h1>
        Department List
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
                Department Name
            </th>
            <th>
                Delete
            </th>
            <th>
                Edit
            </th>
            <th>
                Associated employees
            </th>
        </tr>
        </thead>
        <?php foreach ($departments as $department) {
            ?>
            <tr>
                <td data-title="Id">
                    <?php echo $department->getId(); ?>
                </td>
                <td data-title="DepartmentName">
                    <?php echo $department->getName(); ?>
                </td>
                <td data-title="Delete">
                    <a href='index.php?action=delete&&area=department&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="delete">Delete</button>
                    </a>
                </td>
                <td data-title="Edit">
                    <a href='index.php?action=showUpdate&area=department&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="update">Edit</button>
                    </a>
                </td>
                <td data-title="Associated employees">
                    <a href='index.php?action=employeesToDepartment&area=employee&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="associatedEmployees">Associated employees</button>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
        </div>
        </div>
</body>
</html>
