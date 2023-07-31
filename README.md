# NoobMVC
Prosty Framework dla podstawowych aplikacji oraz początkujących programistów.

## Spis treści
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

## Technologie
* PHP: >= 7.1
* SMARTY: ^4.3.2

## Struktura plików
```
- /
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
  - vendor/
    - ...
    - autoload.php
  - Views/
    - ErrorPages/
      - 404.tpl
      - 500.tpl
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

## Pliki konfiguracyjne
Ustawienia aplikacji znajdują się w katalogu Configs. Każdy z plików odpowiada za inny element aplikacji.
1. Database.php - Ustawienia połączenia z bazą danych.
2. Debuging.php - Ustawienia debugowania aplikacji.
3. Init.php - Tutaj znajduje się zapis dotyczący domyślnego kontrolera dla aplikacji.
4. Locale.php - Ustawienia dotyczące języka, zapisu daty oraz czasu.
5. System.php - Ustawienia dotyczące adresu aplikacji, wersji oraz ścieżek dostępowych.

## Kontrolery
Kontrolery zawierają definicje metod, które są uruchomiane po wywołaniu danej podstrony. Działa to w prosty sposób, po uruchomieniu skryptu /index.php zostaje wywołana metoda `start()` z domyślnego kontrolera (plik `/Configs/Init.php`) lub kontroler zostaje wskazany poprzez parametr `page` przekazany metodą GET (przez pasek adresu, np. `twojastrona.pl/?page=kontroler` lub `twojastrona.pl/Kontroler`). Aby wywołać inną metodę niż metoda `start()`, należy użyć drugiego parametru GET o nazwie `action` (`twojastrona.pl/?page=Kontroler&action=wybranaMetoda` lub `twojastrona.pl/Kontroler/metoda`). Ważne jest, aby nazwy klas były takie same jak nazwy pliku z dodaniem `.class.php` oraz zdefiniowanie przestrzeni nazw Controllers (`namespace Controllers;` na początku pliku).

## Modele
Aby ułatwić pracę z bazą danych framework wykorzystuje modele. Model zawiera odzwierciedlenie struktury tabeli w bazie danych. Nazwy klasy modelu musi być taka sama jak nazwa pliku oraz znajdować się w przestrzeni nazw Models (`namespace Models;`). Bardzo ważne są pola `id` oraz `table`. Pole id powinno by publiczne (`public $id;`), a `table` prywatnym statycznym polem (`private static $table = 'nazwa_tabeli'`). Klasy będące modelem powinny być rozszerzeniem klasy `Core\Models`.
Przykład modelu tabeli:
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

### Konstruktor oraz .get()
Aby pobrać użytkownika z bazy danych wystarczy teraz utworzyć nowy obiekt i podać id użytkownika jako argument metody konstruktora:

```php
// ...
use Models\User;
// ...
$User = new User($id);
// ...
```
Lub możemy użyć metody `.get()`:
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
#### Nowy rekord
Aby utworzyć nowy rekord użyjemy metody `.save()` dla obiektu, w którym pole id jest równe `NULL` lub `0` (domyślnie nowy obiekt posiada pole `ID = NULL`):
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
#### Aktualizacja rekordu
Podobnie wygląda aktualizacja rekordu z tą różnicą, że zostanie zaktualizowany rekord o zdefiniowanym id:
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
### .del()
Dla usuwania rekordów używamy metody `.del()`
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
### Własne metody
Model możemy rozszerzyć o własne metody:
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
```php
// ...
use Models\\User;
// ...
$all_Users = User::getAll();
$Kowalscy - Users::getAll(array('surname' => "Kowalski"));
// ...
```
## Klasa Response oraz system szablonów
Skrypt korzysta z biblioteki SMARTY do kompilacji szablonów. Pliki szablonów znajdują się w katalogu `Views`. Cache biblioteki znajduje się w katalogu `tmp\` do którego ścieżka jest ustalona w pliku `Configs\System.php`.

Więcej na temat korzystania z biblioteki SMARTY znajdziesz:
1. [Wiki](https://pl.wikibooks.org/wiki/PHP/Smarty)
2. [Oficjalna dokumentacja](https://www.smarty.net/documentation)

Klasa `Core\Response` pozwala na szybkie wyświetlanie odpowiednich szablonów lub zwracać dane w postaci JSON.
Aby przypisać dane do widoku należy użyć metody `.assign($nazwa, $wartosc)`, tak przekazane dane będą dostępne w szablonie lub zostaną zwrócone w formacie JSON. Wyświetlanie szablonu następuje po wywołaniu metody `.displayPage('nazwa_szablonu.tpl')`. Dane w formacie JSON możemy zwrócić poprzez metodę `.getJSON()`.

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

## Obsługa tablic
Postawiłem na bardzo prostą obsługę tablic. Klasa `Core\Tables` zawiera trzy metody `GET()`, `POST()` oraz `COOKIES()`. Ich użycie jest naprawdę proste jako argument podajemy nazwę pola w tablicy GET, POST czy COOKIES. Wewnątrz metod znajduje się sprawdzenie czy podane pole w danej tablicy istnie jeśli nie, otrzymamy wartość `false` zamiast komunikatu o błędzie.

## Debugowanie
W pliku konfiguracyjnym `Configs/Debuging` mamy możliwość włączenia lub wyłączenia informowania o błędach. Możemy także włączy debugowanie zapytań SQL. Po włączeniu tej opcji listę zapytań wraz z opisem błędów mamy dostępną w zmiennej globalnej `$SQL_DEBUG_ARRAY`. Klasa `Core\Debuging` posiada metodą zwracającą listę zapytań oraz błędów postaci kodu HTML, dzięki czemu możemy bardzo łatwo wyświetli sobie błędy w widoku smarty wstawiając przed znacznikiem `</body>` ten fragment kodu `{$SQL_DEBUG_HTML|unescape:'html'}`.

## Walidacja danych
Do walidacji danych otrzymanych na przykład z formularza na stronie została stworzona klasa `Core/Validation` autorstwa [davidecesarano](https://github.com/davidecesarano).
### Przykład użycia
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
## Pluginy
Framework obsługi pluginy. Pluginy należy umieszczać w katalogu `/Plugins`. Dostępne pluginy znajdują się na [moim GitHubie](https://github,com/kurzejapatryk)
