<?php

class EmployeeFile extends Employee
{

    /**
     * @return EmployeeFile[]
     * @throws Exception
     */
    public function getAllAsObjects(): array|null
    {

// try tries to execute the block between the brackets.
        // if this fails, there is either an error or an exception
        // this must be caught with a catch-part
        // this catch part in turn must be written afterwards
        // and/or in the calling function
        try {
            if (!is_file(CSV_PATH_EMPLOYEE)) {
                fopen(CSV_PATH_EMPLOYEE, 'w');
//            die(CSV_PATH . 'existiert nicht');
            }
            $handle = fopen(CSV_PATH_EMPLOYEE, 'r');
            $employees = [];
            while ($content = fgetcsv($handle)) {
                $employees[] = new EmployeeFile($content[0], $content[1], $content[2], $content[3]);
            }
            fclose($handle);
        } catch (Error $e) {
            throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
        }
        return $employees;
    }


    /**
     * @param int $id
     * @return EmployeeFile|false
     * @throws Exception
     */
    public function getObjectById(int $id): EmployeeFile|false
    {

        $employees = $this->getAllAsObjects();
        $employee = new EmployeeFile();
        foreach ($employees as $e) {
            if ($e->getId() === $id) {
                $employee = $e;
            }
        }
        return $employee;
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        try {
            //load all employees
            $employees = $this->getAllAsObjects();
            foreach ($employees as $key => $employee) {
                if ($employee->getId() === $id) {
                    // remove employee to be deleted from $employees array
                    unset($employees[$key]);
                }
            }
            $this->storeInFile($employees);
        } catch (Error $e) {
            throw new Exception('Fehler in delete: ' . $e->getMessage());
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function updateObject(): void
    {
        try {
            // load all employees
            $employees = $this->getAllAsObjects();
            foreach ($employees as $key => $employee) {
                if ($employee->getId() === $this->id) {
                    // change the employee to be changed in the $employees array
                    $employees[$key] = $this;
                    break;
                }
            }
            $this->storeInFile($employees);
        } catch (Error $e) {
            throw new Exception('Fehler in store(): ' . $e->getMessage());
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
            // File employee.csv deleted
            unlink(CSV_PATH_EMPLOYEE);
            // Rewrite file with reduced array $employees
            $handle = fopen(CSV_PATH_EMPLOYEE, 'w');
            foreach ($employees as $employee) {
                // transform each object into an array
                $empAssoArray = (array)$employee;
                // transform the associative array into a numeric one
                $empNumArray = array_values($empAssoArray);
                // write each array to the file
                fputcsv($handle, $empNumArray, ',');
                // above 3 commands in one line
//                fputcsv($handle, array_values((array)$employee), ',');
            }
            fclose($handle);
        } catch (Error $e) {
            throw new Exception($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getCode() . ' ' . $e->getLine());
        }
    }

    public function createNewObject(string $firstName, string $lastName, int $departmentId): Employee
    {
// we need an (auto-increment) id for this employee object
        // for this we always write the next id into a static variable in class Employee

        if (!is_file(CSV_PATH_ID_EMPLOYEE_COUNTER)) {
            file_put_contents(CSV_PATH_ID_EMPLOYEE_COUNTER, 1);
        }
        // readnext free id
        $id = file_get_contents(CSV_PATH_ID_EMPLOYEE_COUNTER);
        $e = new EmployeeFile ($id, $firstName, $lastName, $departmentId);
        $employees = $e->getAllAsObjects();
        $employees[] = $e; // add the new employee to the previous employees
        $e->storeInFile($employees);
        //write the next free id into the file
        file_put_contents(CSV_PATH_ID_EMPLOYEE_COUNTER, $id + 1);
        return new EmployeeFile();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function printDepartmentNameFromEmployeeDepartmentId(): string
    {
        // create an instance of class Department inside Employee
        $departments = (new DepartmentFile())->getAllAsObjects();
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
        return ((new DepartmentFile())->getObjectById($this->departmentId))->$this->getName();
    }

    public function getAllEmployeesByDepartment(Department $department): array|null
    {
        {
            try {
                $employees = (new EmployeeFile())->getAllAsObjects();
                $empByDepartment = [];
                foreach ($employees as $employee) {
                    if ($department->getId() === $employee->getDepartmentId()) {
                        $empByDepartment[] = $employee;
                    }
                }
            } catch (Error $e) {
                throw new Exception($e->getMessage());
            }
            return $empByDepartment;
        }
    }

}