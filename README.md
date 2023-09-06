## Laravel Petstore API Client

Laravel Petstore API Client to projekt stworzony w oparciu o framework Laravel, który umożliwia interakcję z API https://petstore.swagger.io. Dzięki temu narzędziu możesz dodawać, edytować, pobierać i usuwać zwierzęta w sklepie.

## Wymagania wstępne

Przed rozpoczęciem pracy nad projektem upewnij się, że masz zainstalowane następujące narzędzia:
- PHP (zalecana wersja 8.0 lub nowsza)
- Composer
  
## Instalacja
Sklonuj repozytorium do swojego lokalnego środowiska:

- https://github.com/daniel-jedrasiewicz/petstore.git

Zainstaluj zależności PHP za pomocą Composera:

- composer install

Skonfiguruj środowisko:

- Skopiuj plik .env.example i nazwij go .env. Następnie dostosuj zmienne środowiskowe

Uruchom serwer deweloperski:

  -php artisan serve


### Użycie

Aplikacja umożliwia interakcję z API petstore.swagger.io za pomocą prostego interfejsu użytkownika. W panelu administracyjnym można:

Dodawać nowe zwierzęta.
Edytować informacje o zwierzęciu.
Pobierać szczegóły zwierzęcia.
Usuwać zwierzęta z bazy danych.
Projekt wykorzystuje pakiet Guzzle do komunikacji z API

## Rozwój i dostosowanie

Projekt jest otwarty na rozwijanie i dostosowywanie do własnych potrzeb. Możesz dodać więcej funkcji, ulepszyć interfejs użytkownika lub rozbudować integrację z API petstore.swagger.io

## Autor

Napisane przez: Daniel Jędrasiewicz

## Licencja

Ten projekt jest dostępny na licencji MIT. 
