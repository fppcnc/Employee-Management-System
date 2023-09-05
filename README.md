# Employee Management System (EMS)

## Overview

![company](https://github.com/fppcnc/Employee-Management-System/blob/master/preview/company.png?raw=true)

This repository contains the code for an Employee Management System (EMS) that supports operations on employees and departments. The system allows you to view, update, create, and delete employee and department data. Users can opt to store the data either in a database (`db`) or as a file.csv (`file`), making it versatile and adaptable to various storage preferences.

preview at : https://companymanagementapplication.000webhostapp.com/

## Features:

- **Dynamic Data Persistence**: Easily switch between database storage and file storage through the `PERSISTENCY` configuration.
  
- **CRUD Operations**:
  - **Employee**: View all employees, view employees by department, update employee details, create new employees, and delete employees.
  - **Department**: View all departments, update department details, create new departments, and delete departments.

- **Autoload Classes**: The system utilizes PHP's `spl_autoload_register` function to automatically include classes as needed.

## File Structure:

- **config.php**: Contains configuration settings.
  
- **classes/**: Directory containing the classes needed for the EMS system.
  
- **views/**: Directory that houses the view templates.

## Prerequisites

1. PHP 7.4+.
2. Configured database if using the `db` option for `PERSISTENCY`.
3. Write permissions on the server if using the `file` option for `PERSISTENCY`.

## Installation

1. Clone this repository: 
```
git clone https://github.com/fppcnc/company
```
2. Navigate to the project directory:
```
cd company
```
3. Configure the `config.php` file as per your requirements.

4. If using the `db` option, ensure that your database is set up and the connection credentials are updated in `config.php`. 
   4a. You can create and populate a db for this application running the code-example inside the folder `sql`.

5. If using the `file` option, ensure that the server has necessary permissions to read/write files.

## Usage

Simply access the main PHP file in your web browser and use the frontend interface to perform CRUD operations on employees and departments.

## Contributing

Pull requests are welcome. Please ensure your code follows the existing code style.

For major changes, please open an issue first to discuss what you would like to change.

## License

This project is licensed under the MIT License.
