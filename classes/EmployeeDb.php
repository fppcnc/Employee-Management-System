<?php

class EmployeeDb extends Employee
{
    /**
     * @var array
     */
    private array $employees;

    /**
     * @return EmployeeDb[]
     * @throws Exception
     */
    public function getAllAsObjects(Department $department = null): array|null
    {
        try {
            $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
            if (!isset($department)) {
                $sql = 'SELECT * FROM employee';
                $result = $dbh->query($sql);
            } else {
                $sql = "SELECT * from employee WHERE departmentId = :departmentId";
                $stmt = $dbh->prepare($sql);
                $id = $department->getId();
                $stmt->bindParam('departmentId', $id);
                $stmt->execute();
                $result = $stmt;
            }
            $employees = [];
            while ($row = $result->fetchObject('EmployeeDb')) {
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
     * @return EmployeeDb|false
     * @throws Exception
     */
    public function getObjectById(int $id): Employee|false
    {
        {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);

//                Version without Prepared Statement
//                $sql = "SELECT * FROM employee WHERE id=$id";
//                $result = $dbh->query($sql);
//                $employee = $result->fetchObject('Employee');

//                Version with Prepared Statement
//                only variable values are marked with :... marked
                $sql = "SELECT * FROM employee WHERE id=:id";
                // sql is sent to the SQL database and a syntax check is performed
                $stmt = $dbh->prepare($sql);
                // the values for the placeholders :... are checked for data type and then inserted into the sql statement
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                // the complete statement is executed in the database
                $stmt->execute();
                // the returned data will be omitted
                $employee = $stmt->fetchObject('EmployeeDb');

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

    /**
     * @param string $firstName
     * @param string $lastName
     * @param int $departmentId
     * @return EmployeeDb
     * @throws Exception
     */
    public function createNewObject(string $firstName, string $lastName, int $departmentId): EmployeeDb
    {

        try {
            $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
// Version with prepared statement and named placeholders
            $sql = "INSERT INTO employee (id, firstName, lastName, departmentId) VALUES (NULL, :firstName, :lastName, :departmentId)";
// Version with prepared statement and enumerated placeholders
//                $sql = "INSERT INTO employee(id, firstName, lastName, departmentId) VALUES (NULL, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
            $stmt->execute();
//                Version with placeholders
//                $stmt->execute([$firstName, $lastName, $departmentId]);
            $id = $dbh->lastInsertId();
            $dbh = null;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());

        }
        return new EmployeeDb($id, $firstName, $lastName, $departmentId);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function printDepartmentNameFromEmployeeDepartmentId(): string
    {
        // create an instance of class Department inside Employee
        $departments = (new DepartmentDb())->getAllAsObjects();
        // compare EmpDepID with all DepID. when there´s a match, print it
        foreach ($departments as $department) {
            if ($this->getDepartmentId() === $department->getID()) {
                return $department->getName();
            }
        }
        return 'Abteilung nicht gefunden';
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDepartmentName(): string
    {
        return ((new DepartmentDb())->getObjectById($this->departmentId))->$this->getName();
    }


    public function getAllEmployeesByDepartment(Department $department): array|null
    {
        return $this->getAllAsObjects($department);
    }
}

