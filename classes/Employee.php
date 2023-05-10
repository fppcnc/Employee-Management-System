<?php

// 0p3
class Employee implements Saveable
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private int $departmentId;

    /**
     * @param int|null $id
     * @param string|null $firstName
     * @param string|null $lastName
     * @param int|null $departmentId
     */
    public function __construct(int|null $id = null, string|null $firstName = null, string|null $lastName = null, int|null $departmentId = null)
    {
        if (isset($id) && isset($firstName) && isset($lastName) && isset($departmentId)) {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->departmentId = $departmentId;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function getAllAsObjects(): array|null
    {
        if (PERSISTENCY === 'file') {
            // try versucht den Block zwischen den Klammern auszuführen
            // wenn dies misslingt, gibt es entweder einen Error oder eine Exception
            // dieses muss mit einem catch-Teil aufgefangen werden
            // dieser catch-Teil wiederum muss anschließend geschrieben werden
            // und/oder in der aufrufenden Funktion
            try {
                if (!is_file(CSV_PATH_EMPLOYEE)) {
                    fopen(CSV_PATH_EMPLOYEE, 'w');
//            die(CSV_PATH . 'existiert nicht');
                }
                $handle = fopen(CSV_PATH_EMPLOYEE, 'r');
                $employees = [];
                while ($content = fgetcsv($handle)) {
                    $employees[] = new Employee($content[0], $content[1], $content[2], $content[3]);
                }
                fclose($handle);
            } catch (Error $e) {
                throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
            }
        } else {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
                $sql = 'SELECT * FROM employee';
                $result = $dbh->query($sql);
                $employees = [];
                while ($row = $result->fetchObject('Employee')) {
                    $employees[] = $row;
                }
                $dbh = null;
            } catch (PDOException $e) {
//                print "Error!: " . $e->getMessage() . "<br/>";
//                die();
                throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
            }
        }
        return $employees;
    }


    /**
     * @param int $id
     * @return Employee|false
     * @throws Exception
     */
    public function getObjectById(int $id): Employee|false
    {
        if (PERSISTENCY === 'file') {
            $employees = $this->getAllAsObjects();
            $employee = new Employee();
            foreach ($employees as $e) {
                if ($e->getId() === $id) {
                    $employee = $e;
                }
            }
            return $employee;
        } else {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);

//                Version ohne Prepared Statement
//                $sql = "SELECT * FROM employee WHERE id=$id";
//                $result = $dbh->query($sql);
//                $employee = $result->fetchObject('Employee');

//                Version mit Prepared Statement
//                nur variable Werte werden mit :... gekennzeichnet
                $sql = "SELECT * FROM employee WHERE id=:id";
//                sql wird an die SQL-Datenbank geschickt und es wird eine Syntaxüberprüfung durchgeführt
                $stmt = $dbh->prepare($sql);
//                die Werte für die Platzhalter :... werden auf Datentyp Überprüft und dann in das sql-Statement eingesetzt
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//                das vollständige statement wird in der Datenbank ausgeführt
                $stmt->execute();
//                die zurückgegebenen Daten werden ausgelassen
                $employee = $stmt->fetchObject('Employee');

                $dbh = null;
            } catch (PDOException $e) {
                throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
            }
            return $employee;
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if (PERSISTENCY === 'file') {
            //alle employees laden
            $employees = $this->getAllAsObjects();
            foreach ($employees as $key => $employee) {
                if ($employee->getId() === $id) {
                    // zu löschenden Employee aus array $employees entfernen
                    unset($employees[$key]);
                }
            }
            $this->storeInFile($employees);
        } else {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
                $sql = "DELETE FROM employee WHERE id=:id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $employee = $stmt->fetchObject('Employee');
                $dbh = null;
            } catch (PDOException $e) {
                throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
            }
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function updateObject(): void
    {
        if (PERSISTENCY === 'file') {
            // alle employees laden
            $employees = $this->getAllAsObjects();
            foreach ($employees as $key => $employee) {
                if ($employee->getId() === $this->id) {
                    // zu ändernden Employee im array $employees ändern
                    $employees[$key] = $this;
                    break;
                }
            }
            $this->storeInFile($employees);
        } else {

            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
                $sql = "UPDATE employee SET firstName=:firstName, lastName=:lastName, departmentId=:departmentId WHERE id=:id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                $stmt->bindParam(':firstName', $this->firstName, PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $this->lastName, PDO::PARAM_STR);
                $stmt->bindParam(':departmentId', $this->departmentId, PDO::PARAM_INT);
                $stmt->execute();
                $id = $dbh->lastInsertId();
                $dbh = null;
            } catch (PDOException $e) {
                throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
            }
        }
    }


    /**
     * @param array $employees
     * @return void
     * @throws Exception
     */
    private function storeInFile(array $employees): void
    {
        try {
            // Datei employee.csv löschen
            unlink(CSV_PATH_EMPLOYEE);
            // Datei mit verkleinertem Array $employees neu schreiben
            $handle = fopen(CSV_PATH_EMPLOYEE, 'w');
            foreach ($employees as $employee) {
                // jedes Objekt in ein Array überführen
                $empAssoArray = (array)$employee;
                // das assoziative Array in ein numerischen umformen
                $empNumArray = array_values($empAssoArray);
                // jedes Array in die Datei schreiben
                fputcsv($handle, $empNumArray, ',');
                // obige 3 Befehle in einer Zeile
                //fputcsv($handle, array_values((array)$employee), ',');
            }
            fclose($handle);
        } catch (Error $e) {
            throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
        }
    }

    public function createNewObject(string $firstName, string $lastName, int $departmentId): Employee
    {
        if (PERSISTENCY === 'file') {
            // wir brauchen eine (auto-increment-)Id für dieses Employee-Objekt
            // dazu schreiben wir immer die nächste id in eine static Variable in Klasse Employee

            if (!is_file(CSV_PATH_ID_EMPLOYEE_COUNTER)) {
                file_put_contents(CSV_PATH_ID_EMPLOYEE_COUNTER, 1);
            }
            //nächste freie ID auslesen
            $id = file_get_contents(CSV_PATH_ID_EMPLOYEE_COUNTER);
            $e = new Employee ($id, $firstName, $lastName, $departmentId);
            $employees = $e->getAllAsObjects();
            $employees[] = $e; // den neuen Employee den vorherigen Employees hinzufügen
            $e->storeInFile($employees);
            //die nächste freie id in die Datei schreiben
            file_put_contents(CSV_PATH_ID_EMPLOYEE_COUNTER, $id + 1);
            return new Employee();
        } else {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
//                Version mit prepared statement und benannten Platzhaltern
//                $sql = "INSERT INTO employee (id, firstName, lastName, departmentId) VALUES (NULL, :firstName, :lastName, :departmentId)";
//                Version mit prepared statement und aufgezählten Platzhaltern
                $sql = "INSERT INTO employee(id, firstName, lastName, departmentId) VALUES (NULL, ?, ?, ?)"
                $stmt = $dbh->prepare($sql);
//                $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
//                $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
//                $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
//                $stmt->execute();
//                Version mit platzhaltern
                $stmt->execute([$firstName, $lastName, $departmentId]);
                $id = $dbh->lastInsertId();
                $dbh = null;
            } catch (PDOException $e) {
                throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
            }
        }
        return new Employee($id, $firstName, $lastName, $departmentId);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function printDepartmentNameFromEmployeeDepartmentId(): string
    {
        // create an instance of class Department inside Employee
        $departments = (new Department())->getAllAsObjects();
        // compare EmpDepID with all DepID. when there´s a match, print it
        foreach ($departments as $department) {
            if ($this->getDepartmentId() === $department->getID()) {
                return $department->getName();
            }
        }
        return 'Abteilung nicht gefunden';
    }

    public function getDepartmentName(): string
    {
        return ((new Department())->getObjectById($this->departmentId))->$this->getDepartmentName();
    }

}