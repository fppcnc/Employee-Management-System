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
    <div class="table">
        <div class="row header">
            <div class="cell">
                Id
            </div>
            <div class="cell">
                Department Name
            </div>
            <div class="cell">
                Delete
            </div>
            <div class="cell">
                Edit
            </div>
            <div class="cell">
                Associated employees
            </div>

        </div>
        <?php foreach ($departments as $department) {
            ?>
            <div class="row">
                <div class="cell" data-title="Id">
                    <?php echo $department->getId(); ?>
                </div>
                <div class="cell" data-title="DepartmentName">
                    <?php echo $department->getName(); ?>
                </div>
                <div class="cell" data-title="Delete">
                    <a href='index.php?action=delete&&area=department&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="delete">Delete</button>
                    </a>
                </div>
                <div class="cell" data-title="Edit">
                    <a href='index.php?action=showUpdate&area=department&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="update">Edit</button>
                    </a>
                </div>
                <div class="cell" data-title="Associated employees">
                    <a href='index.php?action=employeesToDepartment&area=employee&id=<?php echo $department->getId(); ?>'>
                        <button type="button" class="associatedEmployees">Associated employees</button>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
</body>
</html>
