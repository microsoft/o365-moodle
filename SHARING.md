# Microsoft 365 Sharing Feature - Dokumentation

## Überblick
Das Sharing-Feature ist Teil der Microsoft 365-Integration für Moodle (local/o365) und ermöglicht das automatische Erstellen und Verwalten von Freigabelinks für Dateien, die in Moodle-Kursen gespeichert und mit Microsoft 365 verknüpft sind.

## Funktionsweise

### Hauptmerkmale

1. **Automatische Erstellung von Freigabelinks**: 
   - Wenn ein Kursmodul sichtbar gemacht wird, werden für zugehörige Microsoft 365-Dateien automatisch Freigabelinks erstellt
   - Diese Links werden in der Datenbanktabelle `local_o365_sharing` gespeichert
   
2. **Sichtbarkeitsabhängige Verwaltung**:
   - Freigabelinks werden nur für sichtbare Module/Abschnitte erstellt
   - Bei Änderung der Sichtbarkeit eines Moduls oder Kursabschnitts werden entsprechende Links erstellt oder gelöscht

3. **Integration mit Microsoft Graph API**:
   - Verwendet die Microsoft Graph API, um "organization"-Freigabelinks zu erstellen
   - Ermöglicht die nahtlose Integration mit Microsoft Teams und OneDrive

### Technische Implementierung

Die Hauptfunktionalität wird durch die folgenden Klassen bereitgestellt:

- `\local_o365\feature\sharing\main`: Zentrale Klasse zur Verwaltung der Freigabelinks
- `\local_o365\feature\sharing\observers`: Event-Observer, die auf Kursmodul- und Abschnittsänderungen reagieren

Die folgenden Methoden sind besonders wichtig:

- `create_sharing_links_for_module`: Erstellt Freigabelinks für ein Kursmodul
- `delete_sharing_links_for_module`: Löscht Freigabelinks für ein Kursmodul
- `is_course_sync_enabled`: Prüft, ob die Kurssynchronisierung für einen bestimmten Kurs aktiviert ist

## Datenbankstruktur

Das Feature nutzt die Tabelle `local_o365_sharing` mit folgenden Feldern:
- `id`: Eindeutige ID
- `moduleid`: ID des Kursmoduls
- `fileid`: Microsoft 365 Datei-ID
- `filename`: Name der Datei
- `sharelink`: URL des Freigabelinks
- `timecreated`: Erstellungszeitpunkt
- `timemodified`: Zeitpunkt der letzten Änderung

## Voraussetzungen

Damit das Sharing-Feature funktioniert, müssen folgende Bedingungen erfüllt sein:
1. Microsoft 365-Integration muss konfiguriert sein
2. Kurssynchronisierung muss aktiviert sein (`coursesync` nicht auf "off")
3. Der Kurs muss mit einer Microsoft 365-Gruppe verknüpft sein
4. Die Module/Abschnitte müssen sichtbar sein

## Event-Handling

Das System reagiert auf folgende Moodle-Events:
- `\core\event\course_section_updated`: Aktualisierung eines Kursabschnitts
- `\core\event\course_module_updated`: Aktualisierung eines Kursmoduls

Bei Änderung der Sichtbarkeit werden entsprechende Aktionen ausgelöst:
- Wenn ein Element sichtbar gemacht wird: Erstellung von Freigabelinks
- Wenn ein Element unsichtbar gemacht wird: Löschung von Freigabelinks

## Integration mit anderen Funktionen

Das Sharing-Feature arbeitet eng mit anderen Microsoft 365-Integrationsfunktionen zusammen:
- Kurssynchronisierung für Teams/Gruppen
- OneDrive/SharePoint-Dateispeicherung
- Microsoft Graph API für Dateifreigabe

## Workflow-Beispiel

1. Ein Dozent aktiviert die Sichtbarkeit eines Kursmoduls mit Microsoft 365-Dateien
2. Das System erkennt die Änderung durch den Event-Observer
3. Für jede Microsoft 365-Datei in diesem Modul wird ein Freigabelink erstellt
4. Die Links werden in der Datenbank gespeichert und sind für Kursteilnehmer verfügbar
5. Wenn das Modul später versteckt wird, werden die Freigabelinks automatisch gelöscht

## Fehlerbehebung

Bei Problemen mit dem Sharing-Feature sollten folgende Punkte überprüft werden:
- Ist die Microsoft 365-Integration korrekt konfiguriert?
- Ist die Kurssynchronisierung aktiviert?
- Ist der Kurs mit einer Microsoft 365-Gruppe verknüpft?
- Funktionieren andere Microsoft 365-Integrationsfunktionen?

## Zusammenfassung

Das Sharing-Feature bietet eine automatisierte Lösung für die Freigabe von in Moodle gespeicherten Microsoft 365-Dateien. Durch die nahtlose Integration mit der Microsoft Graph API können Benutzer einfach auf freigegebene Inhalte zugreifen, ohne separate Freigaben in Microsoft 365 einrichten zu müssen.
