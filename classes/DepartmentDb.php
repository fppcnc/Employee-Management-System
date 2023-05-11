<?php

class DepartmentDb extends Department
{

    /**
     * @return DepartmentDb[]
     * @throws Exception
     */
    public
    function getAllAsObjects(): array|null
    {
        try {
            $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
            $sql = "SELECT * FROM departments";
            $result = $dbh->query($sql);
            $departments = [];
            while ($row = $result->fetchObject('DepartmentDb')) {
                $departments[] = $row;
            }
            $dbh = null;
        } catch (PDOException $d) {
            throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
        }
        return $departments;
    }


    /**
     * @param int $id
     * @return DepartmentDb
     * @throws Exception
     */
    public
    function getObjectById(int $id): DepartmentDb
    {
        try {
            $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWD);
            echo $id;
            $sql = "SELECT * FROM departments WHERE id=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $department = $stmt->fetchObject('DepartmentDb');
            $dbh = null;

        } catch (PDOException $d) {
            throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
        }
        return $department;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function updateObject(): void
    {
        try {
            $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
            $sql = "UPDATE departments SET name=:name WHERE id=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->execute();
            $id = $dbh->lastInsertId();
            $dbh = null;
        } catch
        (PDOException $d) {
            throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
        }
    }


    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        try {
            $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWD);
            $sql = "DELETE FROM departments WHERE id=:id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $department = $stmt->fetchObject('EmployeeDb');
            $dbh = null;
        } catch
        (PDOException $d) {
            throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
        }
    }

    /**
     * @param string $name *
     * @return DepartmentDb
     * @throws Exception
     */
    public function createNewObject(string $name): DepartmentDb
    {
        try {
            $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWD);
            $sql = "INSERT INTO departments (id, name) VALUES (NULL, :name)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $id = $dbh->lastInsertId();
            $dbh = null;
        } catch (PDOException $d) {
            throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
        }
        return new DepartmentDb($id, $name);
    }


}