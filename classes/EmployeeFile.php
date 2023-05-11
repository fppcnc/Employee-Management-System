<?php

class EmployeeFile extends Employee
{

    /**
     * @return EmployeeFile[]
     * @throws Exception
     */
    public function getAllAsObjects(): array|null
    {

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
        //alle employees laden
        $employees = $this->getAllAsObjects();
        foreach ($employees as $key => $employee) {
            if ($employee->getId() === $id) {
                // zu löschenden Employee aus array $employees entfernen
                unset($employees[$key]);
            }
        }
        $this->storeInFile($employees);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function updateObject(): void
    {
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
        // wir brauchen eine (auto-increment-)Id für dieses Employee-Objekt
        // dazu schreiben wir immer die nächste id in eine static Variable in Klasse Employee

        if (!is_file(CSV_PATH_ID_EMPLOYEE_COUNTER)) {
            file_put_contents(CSV_PATH_ID_EMPLOYEE_COUNTER, 1);
        }
        //nächste freie ID auslesen
        $id = file_get_contents(CSV_PATH_ID_EMPLOYEE_COUNTER);
        $e = new EmployeeFile ($id, $firstName, $lastName, $departmentId);
        $employees = $e->getAllAsObjects();
        $employees[] = $e; // den neuen Employee den vorherigen Employees hinzufügen
        $e->storeInFile($employees);
        //die nächste freie id in die Datei schreiben
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

}