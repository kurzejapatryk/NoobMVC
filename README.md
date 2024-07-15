# NoobMVC
NoobMVC is a simple MVC framework created for beginner PHP developers. The main goal is to achieve maximum simplicity. The project was created in 2017 as a learning exercise and I decided to share it. It allows you to quickly create simple applications and get familiar with the OOP and MVC concepts. I do not recommend using it for professional purposes, if you do, you do it at your own risk!

## Table of contents
* [Technology](#technology)
* [Instalation](#instalation)
* [Configuration](#configuration)
* [Controllers](#controllers)
* [Models](#models)
* [Response Class and Template System](#response-class-and-template-system)
* [Array Handling](#array-handling)
* [Debugging](#debugging)
* [Data Validation](#data-validation)
* [Documentation](#documentation)

## Technology
* PHP: >= 7.4
* SMARTY: ^4.3.2

# Getting started

## Instalation
To install the framework, you need to execute the following command in the terminal:
```bash
composer create-project kurzejapatryk/noobmvc:dev-master you-project-name
```
or clone the repository and install the dependencies:
```bash
git clone git@github.com:kurzejapatryk/NoobMVC.git
composer install
```

## Configuration Files
Application settings are located in the Configs directory. Each file is responsible for a different aspect of the application.
1. Database.php - Database connection settings.
2. Debuging.php - Application debugging settings.
3. Init.php - Default controller settings for the application.
4. Locale.php - Language, date, and time settings.
5. Mailer.php - Email server settings for sending emails.
6. System.php - Application address, version, and access paths settings.

## Controllers
Controllers contain method definitions that are executed when a specific page is called. It works in a simple way, after running the /index.php script, the `start()` method from the default controller (file /Configs/Init.php) is called, or the controller is specified through the `page` parameter passed by the GET method (through the address bar, e.g., `yourwebsite.com/?page=controller` or `yourwebsite.com/Controller`). To call a method other than the `start()` method, use the second GET parameter named `action` (`yourwebsite.com/?page=Controller&action=selectedMethod` or `yourwebsite.com/Controller/method`). It is important that the class names are the same as the file names with the addition of `.class.php` and defining the namespace `Controllers` (`namespace Controllers;` at the beginning of the file).

## Models
To facilitate working with the database, the framework uses models. A model represents the structure of a database table. The model class name must be the same as the file name and be in the Models namespace (`namespace Models;`). The `id` and `table` fields are very important. The `id` field should be public (`public $id;`), the `table` field should be a private static field (`private static $table = 'table_name'`), and the `schema` field should be protected static and contain the table schema. Classes that are models should extend the `Core\Models` class. The model class can optionally include additional methods.
Example of a table model:

```php
namespace Models;

use Core\Model;

class User extends Model{

    private static $table = 'users';

    protected static $schema = array(
        'id' => "INT PRIMARY KEY AUTO_INCREMENT",
        'created_time' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'user_name' => "VARCHAR(100) NOT NULL UNIQUE",
        'name' => "VARCHAR(100)",
        'surname' => "VARCHAR(100)",
        'password' => "VARCHAR(255) NOT NULL",
        'email' => "VARCHAR(255) UNIQUE",
        'role' => "INT",
        'notes' => "TEXT",
    );

    public $id;
    public $user_name;
    public $name;
    public $surname;
    public $password;
    public $email;

    public function setPassword(string $password) : void
    {
        $this->password = md5($password.SALT);
    }
}
```

### Constructor and .get()
To retrieve a user from the database, simply create a new object and pass the user's id as an argument to the constructor method:

```php
// ...
use Models\User;
// ...
$User = new User($id);
// ...
```
Or we can use the `.get()` method:

```php
// ...
use Models\User;
// ...
$User = new User();
$User->id = $id;
$User->get();
// ...
```

### .save()
#### New record
To create a new record, we use the `.save()` method for an object where the id field is `NULL` or `0` (by default, a new object has `ID = NULL`):

```php
// ...
use Models\User;
// ...
$User = new User();
$User->name = "John";
$User->surname = "Doe";
$User->setPassword("password123");
$User->email = 'john.doe@example.com';
$User->save();
// ...
```

#### Updating a record
Updating a record is similar, but the record with the specified id will be updated:

```php
// ...
use Models\User;
// ...
$User = new User($id);
$User->name = "Peter";
$User->save();
// ...
```
In this way, only the user's name in the existing record has been changed.

### .delete()
To delete records, we use the `.delete()` method:

```php
// ...
use Models\User;
// ...
$User = new User($id);
$User->delete();
// ...
```

### .find()
There is also a method to search for a single record. It is the `.find()` method. It uses a field that contains a value. However, if multiple records meet the specified criteria, only one will be returned!

```php
// ...
use Models\User;
// ...
$User = new User();
$User->name = 'John';
$User->surname = "Doe";
$User->find();
// ...
```

### Custom methods
We can extend the model with our own methods:

```php
namespace Models;
use Core\Model;
use Core\Db;

class User extends Model{

    public $id;
    public $table = 'users';

    public $user_name;
    public $name;
    public $surname;
    public $password;
    public $email;


    public function getByUserName($user_name){
        $table = $this->table;
        if($user_name){
            $SQL = "SELECT * FROM ".$table." WHERE user_name = ? LIMIT 1";
            $params = Db::select($SQL, array($user_name), true);
            foreach($params as $key => $val){
                $this->{$key} = $val;
            }
        }
        return $this;
    }
}
```

### ::getAll()
The model itself has an additional static method `getAll($where = array(), $order = "id ASC")`, which returns a list of all objects from the database or only selected ones by passing an array of criteria as an argument.

```php
// ...
use Models\User;
// ...
$all_Users = User::getAll();
$KowalskiUsers = User::getAll(array('surname' => "Kowalski"));
$KowalskiUsers = User::getAll(array('surname' => "Kowalski", "name DESC"));
// ...
```

## Response Class and Template System
The script uses the SMARTY library to compile templates. Template files are located in the Views directory. The library cache is located in the tmp/ directory, the path of which is set in the Configs/System.php file.

More information on using the SMARTY library can be found at:
1. [Wiki](https://pl.wikibooks.org/wiki/PHP/Smarty)
2. [Official Documentation](https://www.smarty.net/documentation)

The `Core\Response` class allows for quick display of the appropriate templates or returning data in JSON format. To assign data to the view, use the `.assign($name, $value)` method. The assigned data will be available in the template or will be returned in JSON format. Displaying a template is done by calling the `.displayPage('template_name.tpl')` method.

```php
namespace Controllers;

use Core\Response;

class Home{

    // Method to display a page
    public static function start(){
        $resp = new Response();
        $resp->assign('lang', LANG);
        $resp->displayPage('Hello.tpl');
    }
}
```

## Array Handling
I have implemented a very simple array handling. The `Core\Tables` class contains three methods: `GET()`, `POST()`, `COOKIE()` and `SESSION()`. To use them, simply provide the field name in the GET, POST, or COOKIES array as an argument. Inside the methods, there is a check if the specified field exists in the given array. If it doesn't, instead of an error message, the value `false` will be returned.

## Debugging
In the Debuging.php configuration file, we have the option to enable or disable error reporting. We can also enable SQL query debugging. When this option is enabled, the list of queries along with error descriptions is available in the global variable `$SQL_DEBUG_ARRAY`. The `Core\Debuging` class has a method that returns a list of queries and errors in HTML code format, making it very easy to display errors in the Smarty view by inserting this code fragment before the `</body>` tag: `{$SQL_DEBUG_HTML|unescape:'html'}`.

## Data Validation
The `Core\Validation` class, created by [davidecesarano](https://github.com/davidecesarano), is used to validate data received, for example, from a form on a website.

### Example of Use
```php
use Core\Validation;
// ...
$email = 'example@email.com';
$username = 'admin';
$password = 'test';
$age = 29;

$val = new Validation();
$val->name('email')->value($email)->pattern('email')->required();
$val->name('username')->value($username)->pattern('alpha')->required();
$val->name('password')->value($password)->customPattern('[A-Za-z0-9-.;_!#@]{5,15}')->required();
$val->name('age')->value($age)->min(18)->max(40);

if($val->isSuccess()){
    echo "Validation ok!";
}else{
    echo "Validation error!";
        var_dump($val->getErrors());
}
```
The full documentation can be found here: [davidecesarano/Validation](https://github.com/davidecesarano/Validation). The email address validation has been modified in the function because the original code was not working correctly.

## Send email
To send an email, use the method `Mailer::send(string $to, string $subject, string $message, array $Attachment = [])`.
The arguments that the method accepts are:
* $to  - Recipient's email address
* $subject - Subject of the email
* $message - HTML content of the email
* $Attachment - (optional) list of strings containing the paths to files to be attached

The method returns `true` on success or `false` on failure.
Remember to configure the file `Configs/Mailer.php`.

Example:
```php
use Core\Mailer;

Mailer::send('test@test.com', 'Test message', '<h1>Test Message</h1><p>This is test message</p>');
```

## Documentation

You can find more information in the wiki on GitHub.

## Support
If you want to support my work, you can propose changes to the project or create your own code and generate a Pull Request. You can also drink to my health :)