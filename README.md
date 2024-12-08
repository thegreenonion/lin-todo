# TODO-Datenbank Projekt
Projekt im Rahmen des Leistungskurses Informatik 2024, Humboldt-Gymnasium Berlin

[![Push to SFTP](https://github.com/thegreenonion/lin-todo/actions/workflows/main.yml/badge.svg?branch=main)](https://github.com/thegreenonion/lin-todo/actions/workflows/main.yml)

## Inhaltsverzeichnis
1. [Beschreibung](#beschreibung)
2. [Struktur der Datenbank](#struktur-der-datenbank)
3. [Installation](#installation)
4. [Nutzung](#nutzung)
5. [Beitragen](#beitragen)
6. [Lizenz](#lizenz)
7. [Kontakt](#kontakt)
8. [Dank an](#dank-an)

## Beschreibung
Die App stellt eine digitale Möglichkeit zur Organisation von Aufgaben bereit.
Alle Benutzereigenen Inhalte werden in einer Datenbank gespeichert, und diese bei Bedarf mittels PHP/PDO ausgelesen.
Jeder Benutzer kann sich eigene TODO-Listen erstellen, und Items zu diesen hinzufügen.
Alle Items einer Liste werden in Form einer Tabelle dargestellt.
Darüber hinaus besteht die Möglichkeit, eine Liste mit Items einem anderen Benutzer zur Ansicht freizugeben; dieser hat nun eine Sicht auf die Items, jedoch kann er ihren Status nicht ändern.

## Struktur der Datenbank
### Relationales Schema
```sql
darfsehen(dLID::INT, dBID::INT)
users(BID::INT, username::VARCHAR, password::VARCHAR, salt::VARCHAR)
lists(LID::INT, name::VARCHAR, lBID::INT)
items(IID::INT, content::VARCHAR, due::DATETIME, is_done::BOOLEAN, iLID::INT)
```

## Installation
### Installation auf Server ohne GitHub Repository
1. Inhalt des Repositorys auf Server laden.
2. Leere Datenbank erstellen.
3. Datei `database_setup/db_setup.sql` in der Datenbank ausführen.
4. Folgende Dateien im Verzeichnis vars/ erstellen:
   - db.php: `<?php $db="<Datenbank-Name>";`
   - dbuser.php: `<?php $dbuser="<Datenbank-Benutzer>";`
   - dbpass.php: `<?php $dbpass="<Datenbank-Passwort>";`
5. Datei `main.php` im Browser aufrufen und TODO nutzen.
### Installation auf Server mit GitHub Repository
1. Repository forken.
2. Unter `Settings->Secrets and Variables->Actions` folgende Repository-Secrets setzen:
   - DB: Name der Datenbank
   - DBUSER: Datenbank-Benutzername
   - DBPASS: Datenbank-Passwort
   - DSERVER: Server-URL, auf dem das Projekt ausgeführt werden soll (z.B. mydomain.tld)
   - USERNAME: Benutzername für den FTP Server, auf dem das Projekt ausgeführt werden soll
   - PASSWORD: Passwort für den FTP Server, auf dem das Projekt ausgeführt werden soll
   - PATH: Dateipfad, auf dem der Inhalt des Repositorys auf dem Server abgelegt werden soll (z.B. /path/to/your/todo/app)
3. Unter `Actions` den Workflow `Push to SFTP` ausführen.
4. Datei `mydomain.tld/path/to/your/todo/app/main.php` ausführen und TODO benutzen.

## Nutzung
Um TODO benutzen zu können, muss der Benutzer einen Account anlegen. Dafür ist keine E-Mailadresse erforderlich, nur ein Benutzername und ein Passwort.
Die Anmeldedaten des Benutzers werden verschlüsselt in eine Datenbank eingefügt, die Administratoren haben also keinen Zugriff auf diese.
Im Anschluss stehen dem Benutzer folgende Aktionen zur Verfügung:
- Listen erstellen
- Aufgabe erstellen (Liste erforderlich)
- Listen freigeben (Liste erforderlich)
- Listen entziehen (Freigegebene Liste erforderlich)
- Logout

### Listenerstellung
Über das Menü "Neue Liste" gelangt der Benutzer zur Listenerstellung.
Dort muss ein Name für die Liste eingegeben werden, dann kann er sie mit einem Klick auf "Erstellen" erstellen.
Daraufhin erfolgt eine Weiterleitung zur Darstellung aller Listen des Benutzers

### Liste anzeigen
Über das Menü "Listen anzeigen" werden dem Benutzer alle Listen, sowohl eigene als auch geteilte, angezeigt.
Neben dem Namen der Liste wird auch die Anzahl der in der Liste enthaltenen Aufgaben sowie die Anzahl der unerledigten Aufgaben angezeigt.
In der Spalte "Geteilt mit" werden alle Accounts aufgelistet, die Leserechte auf diese Liste erhalten haben. Mit einem Klick auf "Verwalten" kann der Benutzer den Zugriff entfernen (siehe Abschnitt "Listenfreigabe entziehen").
Mit einem Klick auf den Namen einer Liste werden dem Benutzer alle in der Liste enthaltenen Items in einer Tabelle aufgelistet. Hier kann er den Status des Items bearbeiten oder es gänzlich löschen.

### Aufgaben erstellen
Um eine Aufgabe zu erstellen, ist eine Liste erforderlich.
Über das Menü "Neue Aufgabe" kann eine neue Aufgabe in einer Liste erstellt werden.
Auf der Seite muss der Inhalt der Aufgabe in das Feld "Name" eingegeben werden. Danach wird das Fälligkeitsdatum für die Aufgabe gesetzt.
Durch klicken auf das Dropdown-Menü "Liste" kann der Benuter auswählen, zu welcher Liste er die Aufgabe hinzufügen möchte.
Der Befehl wird abgeschickt mit dem Klicken auf "Hinzufügen".
Daraufhin wird der Benutzer zur Ansicht aller Items der Liste, zu der die neue Aufgabe hinzugefügt wurde, weitergeleitet.
Dort kann der Benutzer Aufgaben als erledigt markieren und diese bei Bedarf löschen.

### Listen freigeben
In diesem Menü kann der Benutzer eine Liste, die zuvor erstellt wurde, einem anderen Benutzer zur Ansicht freigeben.
Dazu wird auf der Seite in das Feld "Benutzername" der Benutzername des Accounts, mit dem die Liste geteilt werden soll, eingegeben.
Sobald Buchstaben in das Feld eingegeben wurden, schlägt TODO dem Benutzer die möglichen Accounts vor, die zu der Eingabe passen.
Nachdem ein Benutzer ausgewählt wurde, muss aus dem Dropdown-Menü eine eigene Liste ausgewählt werden, die geteilt werden soll.
Mit einem Klick auf "Liste freigeben" wird die Liste dem Benutzer freigegeben.

### Listenfreigabe entziehen
Über das Menü "Listen entziehen" kann der Benutzer den Lesezugriff von fremden Accounts auf die eigenen Listen verwalten.
Es muss zunächst eine der eigenen Listen, die Freigaben besitzt, ausgewählt werden.
Daraufhin wird dem Benutzer angezeigt, welche Benutzer Lesezugriff besitzen, und mit einem Klick auf "Entfernen" kann diesen der Zugriff entzogen werden.
Wenn der Benutzer keine Listen mit Freigaben besitzt, ist das Dropdown-Menü leer.

## Beitragen
In dem Abschnitt "Issues" des Repositorys können Bugs, Hilfeanfragen oder Featurevorschläge abgegeben bzw. gemeldet werden.
Wenn ein Featurevorschlag besteht, der von einem selbst umgesetzt werden kann, so bietet sich ein Fork des Repositorys an.
Die Änderungen können von der Person in diesem Fork vorgenommen werden. Wenn diese umfassend getestet wurden, kann eine Pull Request gestellt werden,
und nach Genehmigung von skeund89, leg0batman und thegreenonion wird die Pull Request gemergt und das Feature in die Orginialversion des Projektes implementiert.

Wir sind jederzeit offen für Verbesserungsvorschläge, offene Fragen, Meldungen von Fehlern im Programm etc.

## Bekannte Fehler
Zurzeit ist die Funktionalität, anderen Usern die eigenen Listen nicht mehr freizugeben, eingeschränkt.
Es wird an einem fix gearbeitet.

## Lizenz
Coming soon

## Kontakt

### Thegreenonion
E-Mail: greenoniondev@gmx-topmail.de

Kontakt via GitHub ist ebenfalls möglich.

### skeund89
tba

### leg0batman
tba

## Dank an
Thanks to

- @wlixcc für den push-to-sftp workflow
- @wlixcc for the push-to-sftp workflow
