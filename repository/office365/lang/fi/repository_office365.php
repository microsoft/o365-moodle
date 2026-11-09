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
 * Finnish language strings.
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Microsoft 365 -tiedostopankki – yhdistettyjen kansioiden tunnukset';
$string['cachedef_unifiedgroupfolderids'] = 'Microsoft 365 -tiedostopankki – ryhmien yhdistettyjen kansioiden tunnukset';
$string['configplugin'] = 'Määritä Microsoft 365 -tiedostopankki';
$string['controlledsharelinkdesc'] = 'Jaettu kopio (vain organisaation jäsenille)';
$string['copiedfile'] = 'Tiedoston kopio';
$string['defaultgroupsfolder'] = 'Kurssin tiedostot';
$string['directlinkdesc'] = 'Suora linkki (nykyiset käyttöoikeudet)';
$string['enableanonymousshare'] = 'Ota käyttöön "{$a}" -vaihtoehto';
$string['enableanonymousshare_help'] = 'Kun tämä on valittuna, käyttäjät voivat luoda tiedostosta kopion ja jakaa sen kaikille organisaation jäsenille. Kopio tallennetaan käyttäjän OneDriveen ja jaetaan kaikille organisaation jäsenille.

**Miten se toimii:**
* Valitusta tiedostosta luodaan kopio, jonka nimeen lisätään pääte " - Shared".
* Kopio tallennetaan käyttäjän OneDriveen (ei alkuperäiseen sijaintiin).
* Kopiolle luodaan organisaation laajuinen jakolinkki.
* Alkuperäinen tiedosto säilyy muuttumattomana nykyisine käyttöoikeuksineen.

**Käyttöoikeuksien hallinta:**
* Vain Microsoft 365 -organisaatiosi jäsenet voivat käyttää tiedostoa.
* Kuka tahansa organisaatiossa, jolla on linkki, voi TARKASTELLA tiedostoa.
* Ulkoiset käyttäjät ja anonyymit käyttäjät EIVÄT voi käyttää tiedostoa.
* Linkki ei vanhene automaattisesti.
* Tiedoston omistaja voi hallita jakamista tai peruuttaa sen OneDrivessaan.

**Milloin käyttää:**
* Haluat jakaa tiedoston kaikille organisaation jäsenille.
* Haluat suojata alkuperäisen tiedoston vahingossa tehdyiltä muutoksilta.
* Moodlen tallennustila on huolenaihe.
* Tiedoston sisältö sopii koko organisaation nähtäväksi.

**Tärkeitä huomioita:**
* Kopiointi voi kestää muutaman sekunnin suurilla tiedostoilla.
* Käyttäjien tulee varmistaa, että tiedoston sisältö sopii jaettavaksi koko organisaatiolle.
* Kopioitu tiedosto näkyy käyttäjän OneDrivessa päätteellä " - Shared".
* Alkuperäiseen tiedostoon tehdyt muutokset EIVÄT näy jaetussa kopiossa, eivätkä jaettuun kopioon tehdyt muutokset alkuperäisessä.

**Tämä vaihtoehto on oletuksena pois käytöstä näyttörajoitusten ja mahdollisten sekaannusten vuoksi. Valitse tämä ruutu vain, jos haluat sallia käyttäjien luoda organisaation kesken jaettuja kopioita.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Huomautus:</strong> Kun käytetään "{$a}" -vaihtoehtoa, alkuperäisestä tiedostosta luodaan kopio, joka jaetaan kaikille organisaation jäsenille. Alkuperäinen tiedosto säilyy muuttumattomana. Käyttäjien tulee varmistaa, että tiedoston sisältö sopii koko organisaation nähtäväksi.
<br><br><strong>Näyttörajoitukset:</strong> Tällä vaihtoehdolla jaetuilla tiedostoilla on rajoituksia, jotka riippuvat tiedostotyypistä ja aineistoissa käytetystä näyttötavasta. Toiminta vaihtelee seuraavasti:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Näyttötapa</th>
<th>Kuvat</th>
<th>Tiedostot (esim. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automaattinen</strong></td>
<td style="background-color: #ffdddd;">Ei toimi – mitään ei näytetä, yhteys estetään</td>
<td>Toimii – ohjataan OneDriveen</td>
</tr>
<tr>
<td><strong>Upotettu</strong></td>
<td>Toimii – kuva upotetaan</td>
<td style="background-color: #ffdddd;">Ei toimi – iframe näyttää virheen "yhdistäminen estettiin"</td>
</tr>
<tr>
<td><strong>Pakota lataus</strong></td>
<td colspan="2">Toimii – ohjataan OneDriveen</td>
</tr>
<tr>
<td><strong>Avaa</strong></td>
<td colspan="2">Toimii – ohjataan OneDriveen</td>
</tr>
<tr>
<td><strong>Ponnahdusikkunassa</strong></td>
<td colspan="2">Toimii – avataan ponnahdusikkunassa</td>
</tr>
</tbody>
</table>
Parhaan yhteensopivuuden saavuttamiseksi kaikkien näyttötapojen kanssa harkitse tiedoston kopioimista Moodleen.</div>';
$string['enablecoursegroup'] = 'Ota käyttöön Ryhmät (kurssit) -kansio tiedostonvalitsimessa';
$string['enabledirectlink'] = 'Ota käyttöön "{$a}" -vaihtoehto';
$string['enabledirectlink_help'] = 'Kun tämä on valittuna, käyttäjät voivat lisätä suoran linkin OneDrivessa olevaan tiedostoon sen sijaan, että kopioisivat tiedoston Moodleen. Tiedosto pysyy OneDrivessa, ja Moodle tallentaa vain viitelinkin.

**Tärkeitä käyttöoikeuksiin liittyviä huomioita:**
* Tiedoston nykyisiä OneDrive-käyttöoikeuksia EI muuteta.
* Linkkiä käyttävillä käyttäjillä on oltava asianmukaiset käyttöoikeudet OneDrivessa tiedoston tarkastelemiseen.
* Linkin lisäävä käyttäjä vastaa siitä, että käyttöoikeudet ovat asianmukaiset.
* Jos OneDrive-käyttöoikeuksia ei ole määritetty oikein, muut käyttäjät eivät ehkä pääse tiedostoon.

**Milloin käyttää tätä vaihtoehtoa:**
* Tiedostot on jo jaettu Microsoft 365:ssä aiotulle yleisölle.
* Haluat säilyttää yhden ajantasaisen lähteen OneDrivessa.
* Moodlen tallennustila on huolenaihe.
* OneDrive-tiedostoon tehtyjen muutosten tulee näkyä Moodlessa.

**Tämä vaihtoehto on oletuksena pois käytöstä näyttörajoitusten ja käyttöoikeuksien hallinnan monimutkaisuuden vuoksi. Valitse tämä ruutu vain, jos haluat sallia käyttäjien linkittää tiedostoja suoraan OneDrivesta.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Huomautus:</strong> Kun käytetään "{$a}" -vaihtoehtoa, OneDrive-tiedoston jakoasetuksiin ei tehdä muutoksia. Tiedoston lisäävien käyttäjien on varmistettava, että tiedoston käyttöoikeudet on määritetty oikein OneDrivessa.
<br><br><strong>Näyttörajoitukset:</strong> Tällä vaihtoehdolla linkitetyillä tiedostoilla on rajoituksia, jotka riippuvat tiedostotyypistä ja aineistoissa käytetystä näyttötavasta. Toiminta vaihtelee seuraavasti:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Näyttötapa</th>
<th>Kuvat</th>
<th>Tiedostot (esim. .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automaattinen</strong></td>
<td style="background-color: #ffdddd;">Ei toimi – mitään ei näytetä, yhteys estetään</td>
<td>Ohjataan OneDriveen; toimii, jos käyttäjällä on oikeus käyttää OneDrive-tiedostoa, muuten näytetään käyttö estetty -sivu</td>
</tr>
<tr>
<td><strong>Upotettu</strong></td>
<td style="background-color: #ffdddd;">Ei toimi – mitään ei näytetä, yhteys estetään</td>
<td style="background-color: #ffdddd;">Ei toimi – upotetussa iframessa näytetään virhe "yhdistäminen estettiin"</td>
</tr>
<tr>
<td><strong>Pakota lataus</strong></td>
<td colspan="2">Ohjataan OneDriveen; toimii, jos käyttäjällä on oikeus käyttää OneDrive-tiedostoa, muuten näytetään käyttö estetty -sivu</td>
</tr>
<tr>
<td><strong>Avaa</strong></td>
<td colspan="2">Ohjataan OneDriveen; toimii, jos käyttäjällä on oikeus käyttää OneDrive-tiedostoa, muuten näytetään käyttö estetty -sivu</td>
</tr>
<tr>
<td><strong>Ponnahdusikkunassa</strong></td>
<td colspan="2">Avataan ponnahdusikkunassa; toimii, jos käyttäjällä on oikeus käyttää OneDrive-tiedostoa, muuten näytetään käyttö estetty -sivu</td>
</tr>
</tbody>
</table>
Parhaan yhteensopivuuden saavuttamiseksi harkitse tiedoston kopioimista Moodleen suoran linkin käyttämisen sijaan.</div>';
$string['enableinternal'] = 'Ota käyttöön "{$a}" -vaihtoehto';
$string['enableinternal_help'] = 'Kun tämä on valittuna (oletus), käyttäjät voivat kopioida tiedoston OneDrivesta Moodleen. Poista valinta ja ota käyttöön alla olevat vaihtoehdot "Linkitä tiedostoon" ja/tai "Luo pääsyohjattu linkki tiedostoon", jos haluat pakottaa käyttäjät linkittämään tiedostoihin.

Vähintään yhden kolmesta tiedostojen linkitysvaihtoehdosta on oltava käytössä.';
$string['enableonedrivegroup'] = 'Ota käyttöön Oma OneDrive -kansio tiedostonvalitsimessa';
$string['enabletrendinggroup'] = 'Ota käyttöön Ympärilläni suositut tiedostot -kansio tiedostonvalitsimessa';

$string['errorauthoidcnotconfig'] = 'Määritä OpenID Connect -tunnistautumislisäosa ennen kuin yrität käyttää Microsoft 365 -tiedostopankkia.';
$string['errorbadclienttype'] = 'Virheellinen asiakastyyppi.';
$string['errorbadpath'] = 'Virheellinen polku';
$string['errorencodingreference'] = 'Tiedostoviitteen koodaus epäonnistui';
$string['errornofilelinkoption'] = 'Vähintään yhden tiedostojen linkitysvaihtoehdon on oltava käytössä.';
$string['erroro365required'] = 'Tämä tiedosto on tällä hetkellä vain Microsoft 365 -käyttäjien saatavilla.';
$string['errorwhiledownload'] = 'Tiedoston lataamisessa tapahtui virhe';
$string['errorwhilesharing'] = 'Jaettavan linkin luomisessa tapahtui virhe';

$string['file'] = 'Tiedosto';
$string['filelinkingheader'] = 'Tiedostojen linkitysvaihtoehdot';
$string['filereferencewarning'] = 'OneDrive-tiedoston jakoasetuksiin ei tehdä muutoksia. Vain henkilöt, joilla on jo pääsy tiedostoon OneDrivessa, voivat avata tämän linkin.';
$string['groups'] = 'Ryhmät (kurssit)';
$string['invalidfilereference'] = 'Virheellinen tai väärin muotoiltu tiedostoviite';
$string['myfiles'] = 'Oma OneDrive';
$string['notconfigured'] = '<p class="error">Jotta voit käyttää tätä lisäosaa, sinun on ensin määritettävä <a href="{$a}/admin/settings.php?section=local_o365">Microsoft 365 -lisäosat</a></p>';
$string['office365:view'] = 'Näytä Microsoft 365 -tiedostopankki';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Tämä lisäosa viestii Microsoft Graph API:n (OneDrive) kanssa nykyisenä käyttäjänä. Kaikki lähetetyt tiedostot lähetetään etäpalvelimelle.';
$string['trendingaround'] = 'Ympärilläni suositut tiedostot';
$string['upload'] = 'Lähetä uusi tiedosto';
