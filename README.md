# Projekt zaliczeniowy z przedmiotu: _**Aplikacje internetowe**_
# Temat projektu: Aplikacja obsługi sieci warsztatów blacharskich
## Skład grupy: Patryk Plizga, Krzysztof Przewoźnik
## Specyfikacja projektu
## Cel projektu :
Stworzenie interfejsu umożliwiającego obsługę sieci warsztatów blacharskich.<br/>

## Funkcjonalności:

Program posiadał będzie następujące funkcjonalności:<br/>
• Podgląd i zarządzanie informacjami o tabelach.<br/>
• Możliwość podglądu usterki przed i po naprawie.<br/>
• Dodawanie rekordów w danych tabelach, edytowanie, usuwanie.<br/>
• Dodawanie części t.j. tworzenie zamówienia.<br/>
• Generowanie faktury danej usługi oraz zamówienia w formacie PDF.<br/>
• Wyświetlanie wybranych wykresów statystycznych<br/>
• Wyświetlanie lokalizacji warsztatu za pomocą Google Maps.<br/>


## Proces uruchomienia aplikacji (krok po kroku)

### Zmiana danych w pliku connect
![image](https://user-images.githubusercontent.com/62017852/119684610-eee57200-be44-11eb-85b5-560802871c8d.png)

### Import Bazy Danych

[Backup Bazy Danych](https://github.com/UR-INF/20-21-ai-projekt-lab3-projekt-ai-przewoznik-plizga/blob/main/sql_BACKUP_24_05_21.sql)

## Baza danych

Baza danych służy do użytku przez sieć warsztatów blacharskich w której istnieją tabele do zapisu danych pracownika, klienta, pojazdu, warsztatu oraz tabela główna będąca zbiorem danych o wykonanych naprawach dla danych klientów, pojazdów w danym warsztacie przez danego pracownika.<br/>

###	Diagram ERD
![image](https://user-images.githubusercontent.com/59484767/117965278-9f2a8500-b333-11eb-83a2-4f3a482f66df.png)

## Wykorzystane technologie
HTML, CSS, JavaScript, PHP, Bootstrap, jQuery, Ajax, Oracle Database, PL/SQL, TCPDF, Google Developers<br/>

## Interfejs serwisu

### Logowanie
![image](https://user-images.githubusercontent.com/62017852/119494443-99846480-bd61-11eb-8d05-ef92957b0b7e.png)

### Rejestracja
![image](https://user-images.githubusercontent.com/62017852/119686069-3fa99a80-be46-11eb-9bf5-aa4399af7210.png)


### Strona Główna
![image](https://user-images.githubusercontent.com/62017852/119648091-52f63f00-be21-11eb-8256-3471d010fc74.png)


### Tabele z paginacją
![image](https://user-images.githubusercontent.com/62017852/119494537-b28d1580-bd61-11eb-9503-25e125eeb8a6.png)

### Tabela i edycja po zalogowaniu jako pracownik
![image](https://user-images.githubusercontent.com/62017852/119496523-dc473c00-bd63-11eb-9b58-def94327dfaa.png)
![image](https://user-images.githubusercontent.com/62017852/119496572-e701d100-bd63-11eb-86b2-22be83d15ba4.png)

### Dodawanie do tabel
![image](https://user-images.githubusercontent.com/62017852/119494601-c769a900-bd61-11eb-89fb-2d309c08f797.png)

### Edytowanie
![image](https://user-images.githubusercontent.com/62017852/119494649-d4869800-bd61-11eb-9687-f51901e87499.png)

### Usuwanie
![image](https://user-images.githubusercontent.com/62017852/119494736-ec5e1c00-bd61-11eb-88c2-51c2983bc30c.png)

### Tworzenie Faktury
![image](https://user-images.githubusercontent.com/62017852/119494817-026bdc80-bd62-11eb-8aba-a94af184fd4f.png)
![image](https://user-images.githubusercontent.com/62017852/119494852-0b5cae00-bd62-11eb-94be-9197559410a2.png)
![image](https://user-images.githubusercontent.com/62017852/119494928-22030500-bd62-11eb-83d3-92c71560b905.png)

### Częsci i zamówienia
![image](https://user-images.githubusercontent.com/62017852/119495006-3941f280-bd62-11eb-98aa-e9383cb47d53.png)
![image](https://user-images.githubusercontent.com/62017852/119495062-48c13b80-bd62-11eb-8801-9b41c9f5d367.png)
![image](https://user-images.githubusercontent.com/62017852/119495159-65f60a00-bd62-11eb-96b1-8b4186939206.png)
![image](https://user-images.githubusercontent.com/62017852/119495122-5971b180-bd62-11eb-94ea-5b09c974089e.png)

### Galeria
![image](https://user-images.githubusercontent.com/62017852/119495272-89b95000-bd62-11eb-83f2-b52632604d46.png)
![image](https://user-images.githubusercontent.com/62017852/119495308-9342b800-bd62-11eb-8253-73c515a9fc93.png)

### Mapy Warsztatów
![image](https://user-images.githubusercontent.com/62017852/119495401-abb2d280-bd62-11eb-98ec-47124b96948f.png)
![image](https://user-images.githubusercontent.com/62017852/119496342-b1f57e80-bd63-11eb-8871-ab6a2c463075.png)

## Potrzebne nazwy użytkowników do uruchomienia aplikacji
### Kierownik
Login: root<br>
Hasło: root<br>

### Pracownik
Login: awis<br>
Hasło: awis123
