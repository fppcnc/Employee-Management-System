<?php
include 'config.php';
//lädt Klassen, die benötigt werden, automatisch aus dem Ordner classes nach
//spl_autoload_register(function ($class) {
//    include 'classes/' . '.php';
//});

include 'classes/Saveable.php';
include 'classes/Employee.php';
include 'classes/Department.php';
include 'classes/HtmlHelper.php';

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
$name = $_POST['name'] ?? '';
$idDepartment = $_POST['idDepartment'] ?? '';

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
            } else if ($area === 'department'){
                $departments = (new Department())->getAllAsObjects();
            }
            $view = $action;
            break;
        case 'showUpdate':
            if ($area === 'employee') {
                $e = new Employee();
                $employee = $e->getObjectById($id);
            } else if ($area === 'department') {
                $d = new Department();
                $department = $d->getObjectById($id);
            }
        case 'showCreate':
//            if ($area === 'employee') {
//                // showCreate und showUpdate haben gleiche Oberfläche
//            } else if ($area === 'department')
            $departments = (new Department())->getAllAsObjects();
            $view = 'showUpdateAndCreate';
            break;
        case 'delete':
            if ($area === 'employee') {
                (new Employee())->delete($id);
                $employees = (new Employee())->getAllAsObjects();
                $view = 'showList';
            } else if ($area === 'department'){
                (new Department())->delete($id);
                $departments = (new Department())->getAllAsObjects();
                $view = 'showList';
            }
            break;
        case 'update':
            if ($area === 'employee') {
                $employee = new Employee($id, $firstName, $lastName, $departmentId);
                $employee->updateObject();
                $employees = (new Employee())->getAllAsObjects();
                $view = 'showList';
            } elseif ($area === 'department'){
                $department = new Department($id, $name);
                $department->updateObject();
                $departments = (new Department())->getAllAsObjects();
                $view = 'showList';
            }
            break;
        case 'create':
            if ($area === 'employee') {
                (new Employee())->createNewObject($firstName, $lastName, $departmentId);
                $employees = (new Employee())->getAllAsObjects();
                $view = 'showList';
                break;
            } else if ($area === 'department'){
                (new Department())->createNewObject($name);
                $departments = (new Department())->getAllAsObjects();
                $view = 'showList';
                break;
            }
        default :
            // falls nicht erwarteter Wert für $action übergeben wird
            $employees = (new Employee())->getAllAsObjects();
            $view = 'showList';
            break;
    }
} catch (Exception $e) {
    $view = 'error';
    $area = '';
}


include 'views/' . $view . ucfirst($area). '.php';

