<?php
include 'config.php';
include 'classes/Employee.php';

//echo '<pre>';
//print_r($_REQUEST);
//echo '</pre>';

// erstes Ziel: list.php anzeigen
$action = $_REQUEST['action'] ?? 'showList'; // showList as Standardvalue
$area = $_REQUEST['area'] ?? 'employee';
$id = $_REQUEST['id'] ?? '';

$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$departmentId = $_POST['departmentId'] ?? '';

// Übergabevariablen desinfizieren (sanitize)
// kleiner Ausflug XSS: in input-text-Felder javascript schreiben z.B.
// <script>alert('XYZ...');</script>
try {
    switch ($action) {
        case 'showList':
            //(new Employee()) erstellt ein unbenanntes Employeeobjekt, welches direkt benutzt wird
            // um Methoden  aufrufen zu können, vergl. mit showUpdate
            if ($area === 'employee') {
                $employees = (new Employee())->getAllAsObjects();
                $view = $action;
            }
            break;
        case 'showUpdate':
            $e = new Employee();
            $employee = $e->getEmployeeById($id);
        case 'showCreate':
            // showCreate und showUpdate haben gleiche Oberfläche
            $view = 'showUpdateAndCreate';
            break;
        case 'delete':
            (new Employee())->delete($id);
            $employees = (new Employee())->getAllAsObjects();
            $view = 'showList';
            break;
        case 'update':
            $employee = new Employee($id, $firstName, $lastName, $departmentId);
            $employee->store();
            $employees = (new Employee())->getAllAsObjects();
            $view = 'showList';
            break;
        case 'create':
            (new Employee())->createNewEmployee($firstName, $lastName, $departmentId);
            $employees = (new Employee())->getAllAsObjects();
        default :
            // falls nicht erwarteter Wert für $action übergeben wird
            $employees = (new Employee())->getAllAsObjects();
            $view = 'showList';
            break;
    }
} catch (Exception $e) {
    $view = 'error';
}


include 'views/' . $view . '.php';