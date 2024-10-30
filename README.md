# TODO-Datenbank Projekt
Projekt im Rahmen des Leistungskurses Informatik 2024, Humboldt-Gymnasium Berlin

## Inhaltsverzeichnis
1. [Beschreibung](#beschreibung)
2. [Struktur der Datenbank](#struktur-der-datenbank)
3. [Installation](#installation)
4. [Nutzung](#nutzung)
5. [Beitragen](#beitragen)
6. [Lizenz](#lizenz)
7. [Kontakt](#kontakt)

## Beschreibung
Die App stellt eine digitale Möglichkeit zur Organisation von Aufgaben bereit.
Alle Benutzereigenen Inhalte werden in einer Datenbank gespeichert, und diese bei Bedarf mittels PHP/PDO ausgelesen.
Jeder Benutzer kann sich eigene TODO-Listen erstellen, und Items zu diesen hinzufügen.
Alle Items einer Liste werden in Form einer Tabelle dargestellt.
Darüber hinaus besteht die Möglichkeit, eine Liste mit Items einem anderen Benutzer zur Ansicht freizugeben; dieser hat nun eine Sicht auf die Items, jedoch kann er ihren Status nicht ändern.

## Struktur der Datenbank
### Relationales Schema
```sql
darf_sehen(dlid, dbid)
user(BID, Passwort, salt)
liste(LID, Name, IBID)
item(IID, content, due, is_done, ILID)
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
Dazu wird auf der Seite in das Feldd
