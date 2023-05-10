<?php

class EmployeeDb implements Saveable
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

        return $employees;
    }


    /**
     * @param int $id
     * @return Employee|false
     * @throws Exception
     */
    public function getObjectById(int $id): Employee|false
    {
        {
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
        {
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
        {

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


    public function createNewObject(string $firstName, string $lastName, int $departmentId): Employee
    {
        {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
//                Version mit prepared statement und benannten Platzhaltern
                $sql = "INSERT INTO employee (id, firstName, lastName, departmentId) VALUES (NULL, :firstName, :lastName, :departmentId)";
//                Version mit prepared statement und aufgezählten Platzhaltern
//                $sql = "INSERT INTO employee(id, firstName, lastName, departmentId) VALUES (NULL, ?, ?, ?)";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
                $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
                $stmt->execute();
//                Version mit platzhaltern
//                $stmt->execute([$firstName, $lastName, $departmentId]);
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
        return ((new Department())->getObjectById($this->departmentId))->$this->getName();
    }

}

{

}