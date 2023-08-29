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
    <div class="table">
        <div class="row header">
            <div class="cell">
                Id
            </div>
            <div class="cell">
                First Name
            </div>
            <div class="cell">
                Last Name
            </div>
            <div class="cell">
                Department
            </div>
            <div class="cell">
                Delete
            </div>
            <div class="cell">
                Edit
            </div>
        </div>
        <?php foreach ($employees as $employee) {
            ?>
            <div class="row">
                <div class="cell" data-title="Id">
                    <?php echo $employee->getId(); ?>
                </div>
                <div class="cell" data-title="FirstName">
                    <?php echo $employee->getFirstName(); ?>
                </div>
                <div class="cell" data-title="LastName">
                    <?php echo $employee->getLastName(); ?>
                </div>
                <div class="cell" data-title="DepartmentID">
                    <?php echo $employee->getDepartmentId() . ' - ' . $employee->printDepartmentNameFromEmployeeDepartmentId(); ?>
                </div>
                <div class="cell" data-title="Delete">
                    <a href='index.php?action=delete&&area=employee&id=<?php echo $employee->getId(); ?>'>
                        <button type="button" class="delete">Delete</button>
                    </a>
                </div>
                <div class="cell" data-title="Edit">
                    <a href='index.php?action=showUpdate&area=employee&id=<?php echo $employee->getId(); ?>'>
                        <button type="button" class="update">Edit</button>
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
