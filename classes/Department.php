<?php

class Department implements Saveable

{
    private int $id;
    private string $name;

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(int|null $id = null, string|null $name = null)
    {
        if (isset($id) && isset($name)) {
            $this->id = $id;
            $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     * @throws Exception
     */
    public
    function getAllAsObjects(): array
    {
        if (PERSISTENCY === 'file') {
            try {
                if (!is_file(CSV_PATH_DEPARTMENT)) {
                    fopen(CSV_PATH_DEPARTMENT, 'w');
                }
                $handle = fopen(CSV_PATH_DEPARTMENT, 'r');
                $departments = [];
                while ($content = fgetcsv($handle, null, ',')) {
                    $departments[] = new Department($content[0], $content[1]);
                }
                fclose($handle);
            } catch (Error $d) {
                throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
            }
        } else {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
                $sql = "SELECT * FROM departments";
                $result = $dbh->query($sql);
                $departments = [];
                while ($row = $result->fetchObject('Department')) {
                    $departments[] = $row;
                }

                $dbh = null;
            } catch (PDOException $d) {
                throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
            }
        }
        return $departments;

    }

    /**
     * @param int $id
     * @return Department
     * @throws Exception
     */
    public
    function getObjectById(int $id): Department
    {
        if (PERSISTENCY === 'file') {
            $departments = $this->getAllAsObjects();
            $department = new Department();
            foreach ($departments as $d) {
                if ($d->getId() === $id) {
                    $department = $d;
                }
            }
        } else {
            try {
                $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWD);
                echo $id;
                $sql = "SELECT * FROM departments WHERE id=:id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $department = $stmt->fetchObject('Department');

                $dbh = null;
            } catch (PDOException $d) {
                throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());
            }
        }
        return $department;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function updateObject(): void
    {
        if (PERSISTENCY === 'file') {
            $departments = $this->getAllAsObjects();
            foreach ($departments as $key => $department) {
                if ($department->getId() === $this->id) {
                    $departments[$key] = $this;
                    break;
                }
            }
            $this->storeInFile($departments);
        } else {
            try {
                $dbh = new PDO (DB_DNS, DB_USER, DB_PASSWD);
                $sql = "UPDATE departments SET name=:name WHERE id=:id";
                echo $sql;
                $this->id = 8;
                $this->name = 'Asvbfb';
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
    }

    /**
     * @param array $departments
     * @return void
     * @throws Exception
     */
    private function storeInFile(array $departments): void
    {
        try {
            unlink(CSV_PATH_DEPARTMENT);
            $handle = fopen(CSV_PATH_DEPARTMENT, 'w');
            foreach ($departments as $department) {
                $depAssoArray = (array)$department;
                $depNumArray = array_values($depAssoArray);
                fputcsv($handle, $depNumArray, ',');
            }
            fclose($handle);
        } catch (Error $d) {
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
        if (PERSISTENCY === 'file') {
            $departments = $this->getAllAsObjects();
            foreach ($departments as $key => $department) {
                if ($department->getId() === $id) {
                    unset($departments[$key]);
                }
            }
            $this->storeInFile($departments);
        } else {
            try {
                $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWD);
                $sql = "DELETE FROM departments WHERE id=:id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $department = $stmt->fetchObject('Employee');
                $dbh = null;
            } catch (PDOException $d) {
                throw new Exception($d->getMessage() . ' ' . $d->getFile() . ' ' . $d->getCode() . ' ' . $d->getLine());


            }

        }
    }

    /**
     * @param string $name
     *
     * @return Department
     * @throws Exception
     */
    public function createNewObject(string $name): Department
    {
        if (PERSISTENCY === 'file') {
            if (!is_file(CSV_PATH_ID_DEPARTMENT_COUNTER)) {
                file_put_contents(CSV_PATH_ID_DEPARTMENT_COUNTER, 1);
            }
            $id = file_get_contents(CSV_PATH_ID_DEPARTMENT_COUNTER);
            $d = new Department($id, $name);
            $departments = $d->getAllAsObjects();
            $departments[] = $d;
            $d->storeInFile($departments);
            file_put_contents(CSV_PATH_ID_DEPARTMENT_COUNTER, $id + 1);
            return new Department();
        } else {
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
        }
        return new Department($id, $name);
    }

}
