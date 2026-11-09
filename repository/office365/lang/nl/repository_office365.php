<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Dutch language strings.
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Microsoft 365-opslagruimte - Uniforme map-ID\'s';
$string['cachedef_unifiedgroupfolderids'] = 'Microsoft 365-opslagruimte - Uniforme map-ID\'s voor groepen';
$string['configplugin'] = 'Microsoft 365-opslagruimte configureren';
$string['controlledsharelinkdesc'] = 'Gedeelde kopie (alleen leden van de organisatie)';
$string['copiedfile'] = 'Kopie van bestand';
$string['defaultgroupsfolder'] = 'Cursusbestanden';
$string['directlinkdesc'] = 'Directe link (bestaande rechten)';
$string['enableanonymousshare'] = 'Optie "{$a}" inschakelen';
$string['enableanonymousshare_help'] = 'Indien aangevinkt kunnen gebruikers ervoor kiezen een kopie van een bestand te maken en deze te delen met iedereen in de organisatie. De kopie wordt opgeslagen in de OneDrive van de gebruiker en gedeeld met alle leden van de organisatie.

**Hoe het werkt:**
* Er wordt een kopie van het geselecteerde bestand gemaakt met het achtervoegsel " - Shared".
* De kopie wordt opgeslagen in de OneDrive van de gebruiker (niet op de oorspronkelijke locatie).
* Voor de kopie wordt een deellink voor de organisatie aangemaakt.
* Het originele bestand blijft ongewijzigd met zijn bestaande rechten.

**Toegangscontrole:**
* Alleen leden van je Microsoft 365-organisatie hebben toegang tot het bestand.
* Iedereen in de organisatie met de link kan het bestand BEKIJKEN.
* Externe en anonieme gebruikers hebben GEEN toegang tot het bestand.
* De link verloopt niet automatisch.
* De eigenaar van het bestand kan het delen beheren of intrekken vanuit zijn OneDrive.

**Wanneer te gebruiken:**
* Je wilt een bestand delen met alle leden van de organisatie.
* Je wilt het originele bestand beschermen tegen onbedoelde wijzigingen.
* Opslagruimte in Moodle is een aandachtspunt.
* De inhoud van het bestand is geschikt voor toegang door de hele organisatie.

**Belangrijke opmerkingen:**
* De kopieerbewerking kan bij grote bestanden enkele seconden duren.
* Gebruikers moeten ervoor zorgen dat de inhoud van het bestand geschikt is om met de hele organisatie te delen.
* Het gekopieerde bestand verschijnt in de OneDrive van de gebruiker met het achtervoegsel " - Shared".
* Wijzigingen in het originele bestand worden NIET doorgevoerd in de gedeelde kopie, en omgekeerd.

**Deze optie is standaard uitgeschakeld vanwege beperkingen in de weergave en mogelijke verwarring. Vink dit vakje alleen aan als je gebruikers wilt toestaan om met de organisatie gedeelde kopieën te maken.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Opmerking:</strong> Bij gebruik van de optie "{$a}" wordt een kopie van het originele bestand gemaakt en gedeeld met alle leden van de organisatie. Het originele bestand blijft ongewijzigd. Gebruikers moeten ervoor zorgen dat de inhoud van het bestand geschikt is voor toegang door de hele organisatie.
<br><br><strong>Beperkingen in de weergave:</strong> Bestanden die met deze optie worden gedeeld hebben beperkingen, afhankelijk van het bestandstype en de weergaveoptie die in bronnen wordt gebruikt. Het gedrag verschilt als volgt:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Weergaveoptie</th>
<th>Afbeeldingen</th>
<th>Bestanden (bijv. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatisch</strong></td>
<td style="background-color: #ffdddd;">Werkt niet - er wordt niets getoond, verbinding geblokkeerd</td>
<td>Werkt - doorgestuurd naar OneDrive</td>
</tr>
<tr>
<td><strong>Ingebed In browser</strong></td>
<td>Werkt - afbeelding wordt ingesloten</td>
<td style="background-color: #ffdddd;">Werkt niet - iframe toont de fout "refused to connect"</td>
</tr>
<tr>
<td><strong>Download verplicht</strong></td>
<td colspan="2">Werkt - doorgestuurd naar OneDrive</td>
</tr>
<tr>
<td><strong>Open</strong></td>
<td colspan="2">Werkt - doorgestuurd naar OneDrive</td>
</tr>
<tr>
<td><strong>In pop-up</strong></td>
<td colspan="2">Werkt - geopend in pop-up</td>
</tr>
</tbody>
</table>
Voor de beste compatibiliteit met alle weergaveopties kun je overwegen het bestand in plaats daarvan naar Moodle te kopiëren.</div>';
$string['enablecoursegroup'] = 'Map Groepen (Cursussen) inschakelen in de bestandskiezer';
$string['enabledirectlink'] = 'Optie "{$a}" inschakelen';
$string['enabledirectlink_help'] = 'Indien aangevinkt kunnen gebruikers een directe link naar een bestand in hun OneDrive toevoegen in plaats van het naar Moodle te kopiëren. Het bestand blijft in OneDrive en Moodle slaat alleen een verwijzingslink op.

**Belangrijke overwegingen voor toegangscontrole:**
* De bestaande OneDrive-rechten van het bestand worden NIET gewijzigd.
* Gebruikers die de link openen moeten in OneDrive over de juiste rechten beschikken om het bestand te bekijken.
* De gebruiker die de link toevoegt is er verantwoordelijk voor dat de toegangsrechten juist zijn ingesteld.
* Als de OneDrive-rechten niet juist zijn ingesteld, hebben andere gebruikers mogelijk geen toegang tot het bestand.

**Wanneer deze optie te gebruiken:**
* Bestanden zijn in Microsoft 365 al gedeeld met het beoogde publiek.
* Je wilt in OneDrive één bron van waarheid behouden.
* Opslagruimte in Moodle is een aandachtspunt.
* Wijzigingen in het OneDrive-bestand moeten in Moodle zichtbaar zijn.

**Deze optie is standaard uitgeschakeld vanwege beperkingen in de weergave en complexiteit van de toegangscontrole. Vink dit vakje alleen aan als je gebruikers wilt toestaan om rechtstreeks vanuit OneDrive naar bestanden te linken.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Opmerking:</strong> Bij gebruik van de optie "{$a}" worden geen deelinstellingen van het OneDrive-bestand gewijzigd. Gebruikers die het bestand toevoegen moeten ervoor zorgen dat de bestandsrechten in OneDrive juist zijn ingesteld.
<br><br><strong>Beperkingen in de weergave:</strong> Bestanden die met deze optie zijn gelinkt hebben beperkingen, afhankelijk van het bestandstype en de weergaveoptie die in bronnen wordt gebruikt. Het gedrag verschilt als volgt:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Weergaveoptie</th>
<th>Afbeeldingen</th>
<th>Bestanden (bijv. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automatisch</strong></td>
<td style="background-color: #ffdddd;">Werkt niet - er wordt niets getoond, verbinding geblokkeerd</td>
<td>Doorgestuurd naar OneDrive, werkt als de gebruiker toegang heeft tot het OneDrive-bestand, anders wordt een pagina \'toegang geweigerd\' getoond</td>
</tr>
<tr>
<td><strong>Ingebed In browser</strong></td>
<td style="background-color: #ffdddd;">Werkt niet - er wordt niets getoond, verbinding geblokkeerd</td>
<td style="background-color: #ffdddd;">Werkt niet - de fout "refused to connect" wordt getoond in het ingesloten iframe</td>
</tr>
<tr>
<td><strong>Download verplicht</strong></td>
<td colspan="2">Doorgestuurd naar OneDrive, werkt als de gebruiker toegang heeft tot het OneDrive-bestand, anders wordt een pagina \'toegang geweigerd\' getoond</td>
</tr>
<tr>
<td><strong>Open</strong></td>
<td colspan="2">Doorgestuurd naar OneDrive, werkt als de gebruiker toegang heeft tot het OneDrive-bestand, anders wordt een pagina \'toegang geweigerd\' getoond</td>
</tr>
<tr>
<td><strong>In pop-up</strong></td>
<td colspan="2">Geopend in pop-up, werkt als de gebruiker toegang heeft tot het OneDrive-bestand, anders wordt een pagina \'toegang geweigerd\' getoond</td>
</tr>
</tbody>
</table>
Voor de beste compatibiliteit kun je overwegen het bestand naar Moodle te kopiëren in plaats van een directe link te gebruiken.</div>';
$string['enableinternal'] = 'Optie "{$a}" inschakelen';
$string['enableinternal_help'] = 'Indien aangevinkt (standaard) kunnen gebruikers ervoor kiezen een bestand uit OneDrive naar Moodle te kopiëren. Schakel dit uit en schakel de onderstaande opties "Link naar het bestand" en/of "Maak een link met toegangscontrole naar het bestand" in om gebruikers te dwingen naar bestanden te linken.

Minstens één van de drie opties voor het linken van bestanden moet zijn ingeschakeld.';
$string['enableonedrivegroup'] = 'Map Mijn OneDrive inschakelen in de bestandskiezer';
$string['enabletrendinggroup'] = 'Map Populair in mijn omgeving inschakelen in de bestandskiezer';

$string['errorauthoidcnotconfig'] = 'Configureer de OpenID Connect-authenticatieplugin voordat je de Microsoft 365-opslagruimte probeert te gebruiken.';
$string['errorbadclienttype'] = 'Ongeldig clienttype.';
$string['errorbadpath'] = 'Ongeldig pad';
$string['errorencodingreference'] = 'Het coderen van de bestandsverwijzing is mislukt';
$string['errornofilelinkoption'] = 'Minstens één optie voor het linken van bestanden moet zijn ingeschakeld.';
$string['erroro365required'] = 'Dit bestand is momenteel alleen beschikbaar voor Microsoft 365-gebruikers.';
$string['errorwhiledownload'] = 'Er is een fout opgetreden bij het downloaden van het bestand';
$string['errorwhilesharing'] = 'Er is een fout opgetreden bij het aanmaken van een deelbare link';

$string['file'] = 'Bestand';
$string['filelinkingheader'] = 'Opties voor het linken van bestanden';
$string['filereferencewarning'] = 'Er worden geen deelinstellingen van het OneDrive-bestand gewijzigd. Alleen mensen die in OneDrive al toegang hebben tot het bestand kunnen deze link openen.';
$string['groups'] = 'Groepen (Cursussen)';
$string['invalidfilereference'] = 'Ongeldige of onjuist opgebouwde bestandsverwijzing';
$string['myfiles'] = 'Mijn OneDrive';
$string['notconfigured'] = '<p class="error">Om deze plugin te gebruiken, moet je eerst de <a href="{$a}/admin/settings.php?section=local_o365">Microsoft 365-plugins</a> configureren</p>';
$string['office365:view'] = 'Microsoft 365-opslagruimte bekijken';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Deze plugin communiceert met de Microsoft Graph API (OneDrive) als de huidige gebruiker. Geüploade bestanden worden naar de externe server verzonden.';
$string['trendingaround'] = 'Populair in mijn omgeving';
$string['upload'] = 'Nieuw bestand uploaden';
