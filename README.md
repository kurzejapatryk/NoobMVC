# SphereFramework
Prosty Framework dla podstawowych aplikacji oraz początkujących programistow.

## Spis treści
* [Technologie](#technologie)
* [Struktura plikow](#struktura-plikow)
* [Konfiguracja](#konfiguracja)
* [Kontrolery](#kontrolery)
* [Modele](#modele)
* [Klasa Response oraz system szablonow](#Klasa-Response-oraz-system-szablonow)

## Technologie
* PHP: >= 5.5.24
* SMARTY: ^3.1

## Struktura plikow
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
Ustawienia aplikacji znajdują się w katalogu Configs. Każdy z plikow odpowada za inny element aplikacji.
1. Database.php - Ustawienia połączenia z bazą danych.
2. Debuging.php - Ustawienia debugowania plikacji.
3. Init.php - Tutaj znajduje się zapis dotyczący kontrolera domyślnego dla aplikacji.
4. Locale.php - Ustawienia dotyczące języka oraz zapisu daty oraz czasu.
5. System.php - Ustawienia dotyczące adresu aplikacji, wersji oraz sciezek dostepowych do niektorych katalogow.

## Kontrolery
Kontrolery zawieraja definicje metod, ktore sa uruchomiane na danej podstronie. Działa to w prosty sposob, po uruchomieniu skryptu /index.php zostaje wywołana metoda `start()` z dymyślnego kontrolera (plik `/Configs/Init.php`) lub kontroler zostaje wskazany poprzez parametr `page` przegazany metodą GET (przez pasek adresu, np. `twojastrona.pl/?page=kontroler` lub `twojastrona.pl/Kontroler`). Aby wywołac inną metodę niż metoda `start()`, należy użyc drugiego parametru GET o nazwie `action` (`twojastrona.pl/?page=Kontroler&action=wybranaMetoda` lub `twojastrona.pl/Kontroler/metoda`). Ważne jest aby nazwy klas były takie same jak nazwy pliku z dodaniem `.class.php` oraz zdefiniowanie przestrzeni nazw Controllers (`namespace Controllers;` na poczatku pliku).

## Modele
Aby ułatwic pracę z bazą danych framework wykorzystuje modele. Model zawiera odzwierciedlenie stuktury tabeli w bazie danych. Nazwy klasy modelu musi byc taka sama jak nazwa pliku oraz znajodwac się w przestrzeni nazw Models (`namespace Models;`), Bardzo ważne są pola `id` oraz `table`. Pole id powinno by publiczne (`public $id;`) a table prywatnym statycznym polem (`private staic $table = 'nazwa_tabeli'`). Klasy będące modelm powinny byc rozszerzeniem klasy `Core\\Models`.
Przykład modelu tabeli użytkownikow:
```php
namespace Models;

use Core\Model;


class User extends Model{

  public $id;
  public $table = 'users';

  public $user_name;
  public $name;
  public $surname;
  public $password;
  public $email;
}
```

### Konstruktor oraz .get()
Aby pobrac uzytkownika z bazy danych wystarczy teraz utworzyc nowy objekt i podac id uzytkownika jako argument metody konstruktora:

```php
// ...
use Models\User;
// ...
$User = new User($id);
// ...
```
Lub możemy użyc metody `.get()`:
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
Aby utworzyc nowy rekord uzyjemy metody `.save()` dla obiektu w ktrym pole id jest rowne `NULL` lub `0` (domyślnie nowy objekt posiada tak zdefiniowane pole ID):
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
Podobnie wygląda aktualizacja rekordu z tą roznicą, że zostatnie zaaktualizowany rekord o zdefinioiwanym id:
```php
// ...
use Models\User;
// ...
$User = new User($id);
$User->name = "Piotr";
$User->save();
// ...
```
W ten sposb zmienione zostało tylko imie użytkownika w juz ustniejacym rekordzie.
### .del()
Dla usuwania rekordow uzywame metody `.del()`
```php
// ...
use Models\User;
// ...
$User = new User($id);
$User->del();
// ...
```
### .search()
Istnieje także motedo pozwalająca wyszukac pojedynczy rekord. Jest to metoda `.search()`. Wykorzystuje ona pale zawierające wartosc. Jeśli jednak więcej rekordw spełnia podane kryteria zostanie zwrocny tylko jeden!
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
Model możemy rozszezyc o własne metody:
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
Sam model posiada dodatkowe statyczną metodą `getAll($where = array())`, ktra zwraca listę wszystkich obiektow z bazy danych lub tylko wybranych po przekazaniu w argumencie tablicy kryteriow.
```php
// ...
use Models\\User;
// ...
$all_Users = User::getAll();
$Kowalscy - Users::getAll(array('surname' => "Kowalski"));
// ...
```
## Klasa Response oraz system szablonow
Skrypt korzysta z biblioteki SMARTY do kompilacji szablonow. Pliki szablonow znajdują się w katalogu `Views`. Cache biblioteki znajduje się w katalogu `tmp\` do ktorego scieżka jest ustalona w pliku `Configs\System.php`.

Więcej na temat korzystania z biblioteki SMARTY znajdziesz:
1. [Wiki](https://pl.wikibooks.org/wiki/PHP/Smarty)
2. [Oficjalna dokumentacja](https://www.smarty.net/documentation)

Klasa `Core\Response` pozwala na szybkie wyświetalnie odpowiednich szablonow lub zwracac dane w postaci JSON.
Aby przypisac dane do widoku należu użyc metody `.assign($nazwa, $wartosc)`, tak przekazane dane będą dostępne w szablonie lub zostaną zwrocne w formacie JSON. Wyświetlanie szablonu następuje po wywołaniu metody `.displayPage('nazwa_szablonu.tpl')`. Dane w formacie JSON możemy zwrcic poprzez metode `.getJSON()`.

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

  //metoda wyświetlajaca dane w formacie json
  public static function getHello(){
    $resp = new Response();
    $resp->assign('hello', 'Hello World !');
    $resp->getJSON();
  }

}
```

## Obsługa tablic
Postawiłem na bardzo prostą obsługę tablic. Klasa `Core\Tables` zawiera trzy metody `GET()`, `POST()` oraz `COOKIES()`. Ich użycie jest naprawdę proste, jako argument podajemy nazwę pola w tablicy GET, POST czy COOKIES. Wewnątrz metod znjduje się sprawdzenie czy podane pole w danej tablicy istnije jeśli nie otrzymamy wrtośc `false` zamiast komunikatu o błędzie.

## Debugging
W pliku konfiguracyjnym `Configs/Debuging` mamy możliwośc właczenia lub wyłaczenia informaowania o błędach. Mozemy także włączy debugowanie zapytań SQL. Po włączeniu tej opcji listę zapytań wraz z opisem błędow mamy dostępną w zmiennej globalnej `$SQL_DEBUG_ARRAY`. Klasa `Core\Debuging` posiada metodą zwracjącą listę zapyatń oraz blędow postaci kodu HTML, dzięki czemu możemy bardzo łatwo wyświetli sobie błędy w widoku smarty wstawiając przed znacznikiem `</body>` ten fragment kodu `{$SQL_DEBUG_HTML|unescape:'html'}`.

## Walidacja danych
Do walidacji danych otrzymanych na przykład z formularza na stronie zostałą stworzona klasa `Core/Validation` autorstwa [davidecesarano](https://github.com/davidecesarano).
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
Pełna dumentacja znajduje się tutaj: [davidecesarano/Validation](https://github.com/davidecesarano/Validation). W funkcji została jedynie zmieniona walidacja adresu email, ponieważ ta w oryginalnym kodzie działała nie poprawnie.
## Pluginy
Framework obsługi pluginy. Pluginy nalyży umiszczac w katalogu `/Plugins`. Dostępne pluginy znajdują się na [moim Githubie](https://github,com/kurzejapatryk)
## Dodatkowa inforacja
Dokumentacja jest w wersji beta. W najbliższym czasie zostanie ulepszona i poprawiona pod kątem błędow.
