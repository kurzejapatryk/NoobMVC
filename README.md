# SphereFramework
Prosty Framework dla podstawowych aplikacji oraz początkujących programistow.

# Struktura plikow
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

# Pliki konfiguracyjne
Ustawienia aplikacji znajdują się w katalogu Configs. Każdy z plikow odpowada za inny element aplikacji.
1. Database.php - Ustawienia połączenia z bazą danych.
2. Debuging.php - Ustawienia debugowania plikacji.
3. Init.php - Tutaj znajduje się zapis dotyczący kontrolera domyślnego dla aplikacji.
4. Locale.php - Ustawienia dotyczące języka oraz zapisu daty oraz czasu.
5. System.php - Ustawienia dotyczące adresu aplikacji, wersji oraz sciezek dostepowych do niektorych katalogow.

# Kontrolery
Kontrolery zawieraja definicje metod, ktore sa uruchomiane na danej podstronie. Działa to w prosty sposob, po uruchomieniu skryptu /index.php zostaje wywołana metoda `start()` z dymyślnego kontrolera (plik `/Configs/Init.php`) lub kontroler zostaje wskazany poprzez parametr `page` przegazany metodą GET (przez pasek adresu, np. `twojastrona.pl/?page=kontroler` lub `twojastrona.pl/Kontroler`). Aby wywołac inną metodę niż metoda `start()`, należy użyc drugiego parametru GET o nazwie `action` (`twojastrona.pl/?page=Kontroler&action=wybranaMetoda` lub `twojastrona.pl/Kontroler/metoda`). Ważne jest aby nazwy klas były takie same jak nazwy pliku z dodaniem `.class.php` oraz zdefiniowanie przestrzeni nazw Controllers (`namespace Controllers;` na poczatku pliku).

# Modele
Aby ułatwic pracę z bazą danych framework wykorzystuje modele. Model zawiera odzwierciedlenie stuktury tabeli w bazie danych. Nazwy klasy modelu musi byc taka sama jak nazwa pliku oraz znajodwac się w przestrzeni nazw Models (`namespace Models;`), Bardzo ważne są pola `id` oraz `table`. Pole id powinno by publiczne (`public $id;`) a table prywatnym statycznym polem (`private staic $table = 'nazwa_tabeli'`). Klasy będące modelm powinny byc rozszerzeniem klasy `Core\\Models`.
Przykład modelu tabeli użytkownikow:
```
<?php
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
Aby pobrac uzytkownika z bazy danych wystarczy teraz utworzyc nowy objekt i podac id uzytkownika jako argument metody konstruktora:
```
// ...
use Models\\User;
// ...
$User = new User($id);
// ...
```
Lub możemy użyc metody `.get()`:
```
// ...
use Models\\User;
// ...
$User = new User();
$User->id = $id;
$User->get();
// ...
```
Aby utworzyc nowy rekord uzyjemy metody `.save()` dla obiektu w ktrym pole id jest rowne `NULL` lub `0` (domyślnie nowy objekt posiada tak zdefiniowane pole ID):
```
// ...
use Models\\User;
// ...
$User = new User();
$User->name = "Jan";
$User->surname = "Kowalski";
$User->password = md5('haslo123');
$User->email = 'jan.kowslaki@domena.pl';
$User->save();
// ...
```
Podobnie wygląda aktualizacja rekordu z tą roznicą, że zostatnie zaaktualizowany rekord o zdefinioiwanym id:
```
// ...
use Models\\User;
// ...
$User = new User($id);
$User->name = "Piotr";
$User->save();
// ...
```
W ten sposb zmienione zostało tylko imie użytkownika w juz ustniejacym rekordzie.
Dla usuwania rekordow uzywame metody `.del()`
```
// ...
use Models\\User;
// ...
$User = new User($id);
$User->del();
// ...
```

Istnieje także motedo pozwalająca wyszukac pojedynczy rekord. Jest to metoda `.search()`. Wykorzystuje ona pale zawierające wartosc. Jeśli jednak więcej rekordw spełnia podane kryteria zostanie zwrocny tylko jeden!
```
// ...
use Models\\User;
// ...
$User = new User();
$User->name = 'Jan';
$User->surname-> "Kowalski";
$User->search();
// ...
```
Model możemy rozszezyc o własne metody:
```
<?php
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
Sam model posiada dodatkowe statyczną metodą `getAll($where = array())`, ktra zwraca listę wszystkich obiektow z bazy danych lub tylko wybranych po przekazaniu w argumencie tablicy kryteriow.
```
// ...
use Models\\User;
// ...
$all_Users = User::getAll();
$Kowalscy - Users::getAll(array('surname' => "Kowalski"));
// ...
```
