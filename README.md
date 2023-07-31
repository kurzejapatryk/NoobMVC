# NoobMVC
NoobMVC to prosty framework w modelu MVC stworzyny dla początkujących programistów PHP. Głównym założeniem jest maksymalna prostatota. Projekt został stworzyny w 2017 roku w ramach nauki i postanowiłem się nim podzielić. Pozwala szybko tworzyć proste aplikacje i oswoić z koncepcją OOP oraz MVC. Raczej odradzam zastosowanie w celach profesjonalych, jeśli to robisz to tylko na własne ryzyko!

NoobMVC is a simple MVC framework created for beginner PHP developers. The main goal is to achieve maximum simplicity. The project was created in 2017 as a learning exercise and I decided to share it. It allows you to quickly create simple applications and get familiar with the OOP and MVC concepts. I do not recommend using it for professional purposes, if you do, you do it at your own risk!

## Spis treści - Table of contents
* [Technologie](#technologie)
* [Struktura plików](#struktura-plików)
* [Konfiguracja](#konfiguracja)
* [Kontrolery](#kontrolery)
* [Modele](#modele)
* [Klasa Response oraz system szablonów](#Klasa-Response-oraz-system-szablonów)
* [Obsługa tablic](#Obsługa-tablic)
* [Debugowanie](#Debugowanie)
* [Walidacja danych](#Walidacja-danych)
* [Pluginy](#Pluginy)
* [Dodatkowa informacja](#Dodatkowa-inforacja)

## Technologie - Technology
* PHP: >= 7.2
* SMARTY: ^4.3.2

## Struktura plików - File structure
```
- /
  - Assets/
    - Core/
    - css/
      - err.css
    -fonts/
      - Poppins-Regular.ttf
  - Configs/
    - Database.php
    - Debuging.php
    - Init.php
    - Locale.php
    - System.php
    - index.php
  - Controllers/
    - ErrorPages.class.php
    - Home.class.php
    - index.php
  - Core/
    - Db.class.php
    - Debuging.class.php
    - Model.class.php
    - Response.class.php
    - Tables.class.php
    - Validation.class.php
    - index.php
  - Language/
    - en.php
    - pl.php
    - index.php
  - Models/
    - index.php
  - Plugins/
    - Authentication/
      - Models/
        - Session.class.php
        - User.class.php
        - index.php
      index.php
    index.php
  - vendor/
    - ...
    - autoload.php
  - Views/
    - ErrorPages/
      - err.tpl
      - index.php
    - Hello.tpl
    - index.php
  - .htaccess
  - composer.json
  - composer.lock
  - helpers.php
  - index.php
  - LICENSE
  - README.md
```

## Pliki konfiguracyjne - Config files
Ustawienia aplikacji znajdują się w katalogu Configs. Każdy z plików odpowiada za inny element aplikacji.
1. Database.php - Ustawienia połączenia z bazą danych.
2. Debuging.php - Ustawienia debugowania aplikacji.
3. Init.php - Tutaj znajduje się zapis dotyczący domyślnego kontrolera dla aplikacji.
4. Locale.php - Ustawienia dotyczące języka, zapisu daty oraz czasu.
5. System.php - Ustawienia dotyczące adresu aplikacji, wersji oraz ścieżek dostępowych.

The application settings are located in the Configs directory. Each file corresponds to a different element of the application.
1. Database.php - Database connection settings.
2. Debuging.php - Application debugging settings.
3. Init.php - Here is the record concerning the default controller for the application.
4. Locale.php - Settings related to language, date and time format.
5. System.php - Settings related to the application address, version and access paths.

## Kontrolery - Controllers
Kontrolery zawierają definicje metod, które są uruchomiane po wywołaniu danej podstrony. Działa to w prosty sposób, po uruchomieniu skryptu /index.php zostaje wywołana metoda `start()` z domyślnego kontrolera (plik `/Configs/Init.php`) lub kontroler zostaje wskazany poprzez parametr `page` przekazany metodą GET (przez pasek adresu, np. `twojastrona.pl/?page=kontroler` lub `twojastrona.pl/Kontroler`). Aby wywołać inną metodę niż metoda `start()`, należy użyć drugiego parametru GET o nazwie `action` (`twojastrona.pl/?page=Kontroler&action=wybranaMetoda` lub `twojastrona.pl/Kontroler/metoda`). Ważne jest, aby nazwy klas były takie same jak nazwy pliku z dodaniem `.class.php` oraz zdefiniowanie przestrzeni nazw `Controllers` (`namespace Controllers;` na początku pliku).

Controllers contain definitions of methods that are executed after calling a given subpage. It works in a simple way, after running the /index.php script, the `start()` method from the default controller (file `/Configs/Init.php`) is called or the controller is indicated by the `page` parameter passed by the GET method (through the address bar, e.g. `yourpage.com/?page=controller` or `yourpage.com/Controller`). To call a method other than the `start()` method, use the second GET parameter named `action` (`yourpage.com/?page=Controller&action=selectedMethod` or `yourpage.com/Controller/method`). It is important that class names are the same as file names with `.class.php` added and that the namespace `Controllers` is defined (`namespace Controllers;` at the beginning of the file).

## Modele - Models
Aby ułatwić pracę z bazą danych framework wykorzystuje modele. Model zawiera odzwierciedlenie struktury tabeli w bazie danych. Nazwy klasy modelu musi być taka sama jak nazwa pliku oraz znajdować się w przestrzeni nazw Models (`namespace Models;`). Bardzo ważne są pola `id` oraz `table`. Pole id powinno by publiczne (`public $id;`), a `table` prywatnym statycznym polem (`private static $table = 'nazwa_tabeli'`). Klasy będące modelem powinny być rozszerzeniem klasy `Core\Models`.
Przykład modelu tabeli:

To make working with the database easier, the framework uses models. The model contains a reflection of the table structure in the database. The class name of the model must be the same as the file name and be in the Models namespace (`namespace Models;`). The `id` and `table` fields are very important. The id field should be public (`public $id;`) and table should be a private static field (`private static $table = 'table_name';`). Classes that are models should extend the `Core\Models` class.

Example of a table model:
```php
namespace Models;

use Core\Model;


class User extends Model{

  public $id;
  private static $table = 'users';

  public $user_name;
  public $name;
  public $surname;
  public $password;
  public $email;
}
```

### Konstruktor oraz .get() - Constructor and .get()
Aby pobrać użytkownika z bazy danych wystarczy utworzyć nowy obiekt i podać id użytkownika jako argument metody konstruktora:

To download a user from the database, simply create a new object and pass the user ID as an argument to the constructor method:

```php
// ...
use Models\User;
// ...
$User = new User($id);
// ...
```
Lub możemy użyć metody `.get()`:

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
#### Nowy rekord - New record
Aby utworzyć nowy rekord użyjemy metody `.save()` dla obiektu, w którym pole id jest równe `NULL` lub `0` (domyślnie nowy obiekt posiada pole `ID = NULL`):

To create a new record, we will use the `.save()` method for an object in which the id field is equal to NULL or 0 (by default, a new object has the field `ID = NULL`):
```php
// ...
use Models\User;
// ...
$User = new User();
$User->name = "Jan";
$User->surname = "Kowalski";
$User->password = md5('haslo123');
$User->email = 'jan.kowslaki@domena.pl';
$User->save();
// ...
```
#### Aktualizacja rekordu - Updating a record
Podobnie wygląda aktualizacja rekordu z tą różnicą, że zostanie zaktualizowany rekord o zdefiniowanym id:

Updating a record looks similar except that the record with the defined id will be updated:
```php
// ...
use Models\User;
// ...
$User = new User($id);
$User->name = "Piotr";
$User->save();
// ...
```
W ten sposób zmienione zostało tylko imię użytkownika w już istniejącym rekordzie.

In this way, only the user’s name was changed in an existing record.
### .del()
Dla usuwania rekordów używamy metody `.del()`

We use the `.del()` method to delete records.
```php
// ...
use Models\User;
// ...
$User = new User($id);
$User->del();
// ...
```
### .search()
Istnieje także metoda pozwalająca wyszukać pojedynczy rekord. Jest to metoda `.search()`. Wykorzystuje ona pole zawierające wartość. Jeśli jednak więcej rekordów spełnia podane kryteria zostanie zwrócony tylko jeden!

There is also a method that allows you to search for a single record. This is the `.search()` method. It uses a field containing a value. However, if more records meet the specified criteria, only one will be returned!
```php
// ...
use Models\\User;
// ...
$User = new User();
$User->name = 'Jan';
$User->surname-> "Kowalski";
$User->search();
// ...
```
### Własne metody - Custom methods
Model możemy rozszerzyć o własne metody:

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
Sam model posiada dodatkowe statyczną metodą `getAll($where = array())`, która zwraca listę wszystkich obiektów z bazy danych lub tylko wybranych po przekazaniu w argumencie tablicy kryteriów.

The model itself has an additional static method `getAll($where = array())`, which returns a list of all objects from the database or only selected ones by passing criteria in the argument array.
```php
// ...
use Models\\User;
// ...
$all_Users = User::getAll();
$Kowalscy - Users::getAll(array('surname' => "Kowalski"));
// ...
```
## Klasa Response oraz system szablonów - Response class and template system
Skrypt korzysta z biblioteki SMARTY do kompilacji szablonów. Pliki szablonów znajdują się w katalogu `Views`. Cache biblioteki znajduje się w katalogu `tmp\` do którego ścieżka jest ustalona w pliku `Configs\System.php`.

Więcej na temat korzystania z biblioteki SMARTY znajdziesz:
1. [Wiki](https://pl.wikibooks.org/wiki/PHP/Smarty)
2. [Oficjalna dokumentacja](https://www.smarty.net/documentation)

Klasa `Core\Response` pozwala na szybkie wyświetlanie odpowiednich szablonów lub zwracać dane w postaci JSON.
Aby przypisać dane do widoku należy użyć metody `.assign($nazwa, $wartosc)`, tak przekazane dane będą dostępne w szablonie lub zostaną zwrócone w formacie JSON. Wyświetlanie szablonu następuje po wywołaniu metody `.displayPage('nazwa_szablonu.tpl')`. Dane w formacie JSON możemy zwrócić poprzez metodę `.getJSON()`.

The script uses the SMARTY library to compile templates. Template files are located in the `Views` directory. The library cache is located in the `tmp\` directory, the path of which is set in the `Configs\System.php` file.

You can find more information about using the SMARTY library at:

1. [Wiki](https://pl.wikibooks.org/wiki/PHP/Smarty)
2. [Official documentation](https://www.smarty.net/documentation)

The Core\Response class allows you to quickly display the appropriate templates or return data in JSON format. To assign data to a view, use the `.assign($name, $value)` method. Data passed this way will be available in the template or returned in JSON format. The template is displayed after calling the `.displayPage('template_name.tpl')` method. We can return data in JSON format using the `.getJSON()` method.

```php
namespace Controllers;

use Core\Response;

class Home{

  // Metoda wyświatlająca strone
  public static function start(){
    $resp = new Response();
    $resp->assign('lang', LANG);
    $resp->displayPage('Hello.tpl');
  }

  //metoda wyświetlająca dane w formacie json
  public static function getHello(){
    $resp = new Response();
    $resp->assign('hello', 'Hello World !');
    $resp->getJSON();
  }

}
```

## Obsługa tablic - Array handling
Postawiłem na bardzo prostą obsługę tablic. Klasa `Core\Tables` zawiera trzy metody `GET()`, `POST()` oraz `COOKIES()`. Ich użycie jest naprawdę proste jako argument podajemy nazwę pola w tablicy GET, POST czy COOKIES. Wewnątrz metod znajduje się sprawdzenie czy podane pole w danej tablicy istnie jeśli nie, otrzymamy wartość `false` zamiast komunikatu o błędzie.

I opted for a very simple array handling. The `Core\Tables` class contains three methods: `GET()`, `POST()`, and `COOKIES()`. Using them is really simple - we pass the name of the field in the GET, POST or COOKIES array as an argument. Inside the methods, there is a check whether the given field exists in the given array. If it doesn’t, we will receive a value of `false` instead of an error message.

## Debugowanie - Debugging
W pliku konfiguracyjnym `Configs/Debuging` mamy możliwość włączenia lub wyłączenia informowania o błędach. Możemy także włączy debugowanie zapytań SQL. Po włączeniu tej opcji listę zapytań wraz z opisem błędów mamy dostępną w zmiennej globalnej `$SQL_DEBUG_ARRAY`. Klasa `Core\Debuging` posiada metodą zwracającą listę zapytań oraz błędów postaci kodu HTML, dzięki czemu możemy bardzo łatwo wyświetli sobie błędy w widoku smarty wstawiając przed znacznikiem `</body>` ten fragment kodu `{$SQL_DEBUG_HTML|unescape:'html'}`.

In the configuration file `Configs/Debuging`, we have the option to turn on or off error reporting. We can also enable SQL query debugging. After enabling this option, we have a list of queries along with error descriptions available in the global variable `$SQL_DEBUG_ARRAY`. The `Core\Debuging` class has a method that returns a list of queries and errors in HTML code format, so we can easily display errors in the Smarty view by inserting this code fragment before the `</body>` tag: `{$SQL_DEBUG_HTML|unescape:'html'}`.

## Walidacja danych - Data validation
Do walidacji danych otrzymanych na przykład z formularza na stronie została stworzona klasa `Core/Validation` autorstwa [davidecesarano](https://github.com/davidecesarano).

The Core/Validation class created by [davidecesarano](https://github.com/davidecesarano) is used to validate data received from a form on a website.
### Przykład użycia - Example of use
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
Pełna dokumentacja znajduje się tutaj: [davidecesarano/Validation](https://github.com/davidecesarano/Validation). W funkcji została jedynie zmieniona walidacja adresu email, ponieważ ta w oryginalnym kodzie działała niepoprawnie.

The full documentation can be found here: [davidecesarano/Validation](https://github.com/davidecesarano/Validation). Only the email address validation was changed in the function because the original code did not work correctly. 
## Pluginy - Plugins
Już niedługo...

Coming soon…
