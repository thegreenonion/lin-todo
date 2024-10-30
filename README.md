# TODO-Datenbank Projekt im Rahmen des Leistungskurses Informatik 2024, Humboldt-Gymnasium Berlin
Projekt von skeund89, leg0batman und thegreenonion
## Struktur der Datenbank
### Relationales Schema
darf_sehen(dlid, dbid)

user(BID, Passwort, salt)

liste(LID, Name, IBID)

item(IID, content, due, is_done, ILID)

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
