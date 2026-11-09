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
 * Portuguese (Brazil) language strings.
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Repositório Microsoft 365 - IDs de pastas unificadas';
$string['cachedef_unifiedgroupfolderids'] = 'Repositório Microsoft 365 - IDs de pastas unificadas para grupos';
$string['configplugin'] = 'Configurar o repositório Microsoft 365';
$string['controlledsharelinkdesc'] = 'Cópia compartilhada (somente membros da organização)';
$string['copiedfile'] = 'Cópia do arquivo';
$string['defaultgroupsfolder'] = 'Arquivos do curso';
$string['directlinkdesc'] = 'Link direto (permissões existentes)';
$string['enableanonymousshare'] = 'Ativar a opção "{$a}"';
$string['enableanonymousshare_help'] = 'Quando marcada, os usuários podem optar por criar uma cópia de um arquivo e compartilhá-la com todos na organização. A cópia é armazenada no OneDrive do usuário e compartilhada com todos os membros da organização.

**Como funciona:**
* Cria uma cópia do arquivo selecionado com o sufixo " - Shared".
* A cópia é salva no OneDrive do usuário (não no local original).
* Um link de compartilhamento com escopo da organização é criado para a cópia.
* O arquivo original permanece inalterado, com suas permissões existentes.

**Controle de acesso:**
* Somente membros da sua organização do Microsoft 365 podem acessar o arquivo.
* Qualquer pessoa na organização com o link pode VISUALIZAR o arquivo.
* Usuários externos e usuários anônimos NÃO podem acessar o arquivo.
* O link não expira automaticamente.
* O proprietário do arquivo pode gerenciar ou revogar o compartilhamento a partir do seu OneDrive.

**Quando usar:**
* Você deseja compartilhar um arquivo com todos os membros da organização.
* Você deseja proteger o arquivo original contra alterações acidentais.
* O espaço de armazenamento no Moodle é uma preocupação.
* O conteúdo do arquivo é apropriado para acesso em toda a organização.

**Notas importantes:**
* A operação de cópia pode levar alguns segundos para arquivos grandes.
* Os usuários devem garantir que o conteúdo do arquivo seja apropriado para compartilhamento em toda a organização.
* O arquivo copiado aparecerá no OneDrive do usuário com o sufixo " - Shared".
* As alterações feitas no arquivo original NÃO serão refletidas na cópia compartilhada, e vice-versa.

**Esta opção está desativada por padrão devido a limitações de exibição e possível confusão. Marque esta caixa somente se quiser permitir que os usuários criem cópias compartilhadas com a organização.**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>Nota:</strong> Ao usar a opção "{$a}", uma cópia do arquivo original é criada e compartilhada com todos os membros da organização. O arquivo original permanece inalterado. Os usuários devem garantir que o conteúdo do arquivo seja apropriado para acesso em toda a organização.
<br><br><strong>Limitações de exibição:</strong> Os arquivos compartilhados com esta opção têm limitações dependendo do tipo de arquivo e da opção de exibição usada nos recursos. O comportamento varia da seguinte forma:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opção de exibição</th>
<th>Imagens</th>
<th>Arquivos (por exemplo, .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automático</strong></td>
<td style="background-color: #ffdddd;">Não funciona - nada é exibido, conexão bloqueada</td>
<td>Funciona - redirecionado para o OneDrive</td>
</tr>
<tr>
<td><strong>Incorporar</strong></td>
<td>Funciona - a imagem é incorporada</td>
<td style="background-color: #ffdddd;">Não funciona - iframe exibindo o erro "recusou-se a conectar"</td>
</tr>
<tr>
<td><strong>Forçar o download</strong></td>
<td colspan="2">Funciona - redirecionado para o OneDrive</td>
</tr>
<tr>
<td><strong>Abrir</strong></td>
<td colspan="2">Funciona - redirecionado para o OneDrive</td>
</tr>
<tr>
<td><strong>Em uma janela pop-up</strong></td>
<td colspan="2">Funciona - aberto em pop-up</td>
</tr>
</tbody>
</table>
Para melhor compatibilidade com todas as opções de exibição, considere copiar o arquivo para o Moodle.</div>';
$string['enablecoursegroup'] = 'Ativar a pasta Grupos (cursos) no seletor de arquivos';
$string['enabledirectlink'] = 'Ativar a opção "{$a}"';
$string['enabledirectlink_help'] = 'Quando marcada, os usuários podem adicionar um link direto para um arquivo no seu OneDrive em vez de copiá-lo para o Moodle. O arquivo permanece no OneDrive e o Moodle armazena apenas um link de referência.

**Considerações importantes sobre controle de acesso:**
* As permissões existentes do arquivo no OneDrive NÃO são alteradas.
* Os usuários que acessarem o link devem ter as permissões apropriadas no OneDrive para visualizar o arquivo.
* É responsabilidade do usuário que adiciona o link garantir as permissões de acesso adequadas.
* Se as permissões do OneDrive não estiverem definidas corretamente, outros usuários poderão não conseguir acessar o arquivo.

**Quando usar esta opção:**
* Os arquivos já estão compartilhados com o público pretendido no Microsoft 365.
* Você deseja manter uma única fonte de verdade no OneDrive.
* O espaço de armazenamento no Moodle é uma preocupação.
* As edições no arquivo do OneDrive devem ser refletidas no Moodle.

**Esta opção está desativada por padrão devido a limitações de exibição e complexidades de controle de acesso. Marque esta caixa somente se quiser permitir que os usuários vinculem arquivos diretamente do OneDrive.**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>Nota:</strong> Ao usar a opção "{$a}", nenhuma alteração de compartilhamento é feita no arquivo do OneDrive. Os usuários que adicionam o arquivo devem garantir que as permissões do arquivo no OneDrive estejam definidas corretamente.
<br><br><strong>Limitações de exibição:</strong> Os arquivos vinculados com esta opção têm limitações dependendo do tipo de arquivo e da opção de exibição usada nos recursos. O comportamento varia da seguinte forma:
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>Opção de exibição</th>
<th>Imagens</th>
<th>Arquivos (por exemplo, .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Automático</strong></td>
<td style="background-color: #ffdddd;">Não funciona - nada é exibido, conexão bloqueada</td>
<td>Redirecionado para o OneDrive, funciona se o usuário tiver permissão para acessar o arquivo do OneDrive; caso contrário, exibe a página de permissão negada</td>
</tr>
<tr>
<td><strong>Incorporar</strong></td>
<td style="background-color: #ffdddd;">Não funciona - nada é exibido, conexão bloqueada</td>
<td style="background-color: #ffdddd;">Não funciona - erro de recusa de conexão exibido no iframe incorporado</td>
</tr>
<tr>
<td><strong>Forçar o download</strong></td>
<td colspan="2">Redirecionado para o OneDrive, funciona se o usuário tiver permissão para acessar o arquivo do OneDrive; caso contrário, exibe a página de permissão negada</td>
</tr>
<tr>
<td><strong>Abrir</strong></td>
<td colspan="2">Redirecionado para o OneDrive, funciona se o usuário tiver permissão para acessar o arquivo do OneDrive; caso contrário, exibe a página de permissão negada</td>
</tr>
<tr>
<td><strong>Em uma janela pop-up</strong></td>
<td colspan="2">Aberto em pop-up, funciona se o usuário tiver permissão para acessar o arquivo do OneDrive; caso contrário, exibe a página de permissão negada</td>
</tr>
</tbody>
</table>
Para melhor compatibilidade, considere copiar o arquivo para o Moodle em vez de usar um link direto.</div>';
$string['enableinternal'] = 'Ativar a opção "{$a}"';
$string['enableinternal_help'] = 'Quando marcada (o padrão), os usuários podem optar por copiar um arquivo do OneDrive para o Moodle. Desmarque esta opção e ative as opções "Criar um link para este arquivo" e/ou "Criar um link de acesso controlado ao arquivo" abaixo para forçar os usuários a vincular os arquivos.

Pelo menos uma das três opções de vinculação de arquivos deve estar ativada.';
$string['enableonedrivegroup'] = 'Ativar a pasta Meu OneDrive no seletor de arquivos';
$string['enabletrendinggroup'] = 'Ativar a pasta Arquivos em alta ao meu redor no seletor de arquivos';

$string['errorauthoidcnotconfig'] = 'Configure o plugin de autenticação OpenID Connect antes de tentar usar o repositório Microsoft 365.';
$string['errorbadclienttype'] = 'Tipo inválido de cliente.';
$string['errorbadpath'] = 'Caminho inválido';
$string['errorencodingreference'] = 'Falha ao codificar a referência do arquivo';
$string['errornofilelinkoption'] = 'Pelo menos uma opção de vinculação de arquivos deve estar ativada.';
$string['erroro365required'] = 'Este arquivo está atualmente disponível apenas para usuários do Microsoft 365.';
$string['errorwhiledownload'] = 'Ocorreu um erro durante o download do arquivo';
$string['errorwhilesharing'] = 'Ocorreu um erro ao criar um link compartilhável';

$string['file'] = 'Arquivo';
$string['filelinkingheader'] = 'Opções de vinculação de arquivos';
$string['filereferencewarning'] = 'Nenhuma alteração de compartilhamento é feita no arquivo do OneDrive. Somente as pessoas que já têm acesso ao arquivo no OneDrive podem abrir este link.';
$string['groups'] = 'Grupos (cursos)';
$string['invalidfilereference'] = 'Referência de arquivo inválida ou malformada';
$string['myfiles'] = 'Meu OneDrive';
$string['notconfigured'] = '<p class="error">Para usar este plugin, você deve primeiro configurar os <a href="{$a}/admin/settings.php?section=local_o365">plugins do Microsoft 365</a></p>';
$string['office365:view'] = 'Visualizar o repositório Microsoft 365';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'Este plugin se comunica com a API do Microsoft Graph (OneDrive) como o usuário atual. Todos os arquivos enviados serão transmitidos ao servidor remoto.';
$string['trendingaround'] = 'Arquivos em alta ao meu redor';
$string['upload'] = 'Fazer upload de novo arquivo';
