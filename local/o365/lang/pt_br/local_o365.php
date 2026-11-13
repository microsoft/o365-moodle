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
 *
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Integração ao Microsoft 365';

// Settings - tabs.
$string['settings_pageheading'] = 'Configuração de {$a}';
$string['settings_header_setup'] = 'Configuração';
$string['settings_header_usersync'] = 'Sincronização de usuários';
$string['settings_header_coursesync'] = 'Sincronização de cursos';
$string['settings_header_advanced'] = 'Avançado';
$string['settings_header_sds'] = 'Sincronização SDS';
$string['settings_header_teams'] = 'Configurações do Teams';
$string['settings_header_moodle_app'] = 'Aplicativo Moodle do Teams';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'Etapa 1/2: registrar o Moodle no Microsoft Entra ID';
$string['settings_setup_step1_desc'] = 'Registre um novo aplicativo do Microsoft Entra ID para a integração com o Moodle usando o PowerShell:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">Baixar script do PowerShell</a>

<p style="margin-top:10px"><a href="{$a}/local/o365/scripts/README.md" target="_blank">Clique aqui</a> para ler as instruções de execução do script.</p>
<p>Quando solicitado, use o link a seguir como URL do Moodle:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />Depois que o script for executado com sucesso, copie o ID do aplicativo e o segredo retornados pelo script para a <a href="{$a}">página de configuração do plugin de autenticação OpenID Connect</a>.';
$string['settings_setup_step1_credentials_end'] = 'Se não for possível configurar o aplicativo do Microsoft Entra ID via PowerShell, <a href="{$a}" target="_blank">clique aqui</a> para ver as instruções de configuração manual.';
$string['settings_setup_step1_continue'] = '<b>Depois de inserir o ID do aplicativo e o segredo, clique em "Salvar mudanças" na parte inferior da página para continuar.</b><br /><br /><br /><br /><br />';
$string['settings_setup_step1_existing_settings'] = '<h5>Configurações existentes</h5>';
$string['settings_setup_step2'] = 'Etapa 2/2: consentimento do administrador &amp; informações adicionais';
$string['settings_setup_step2_desc'] = 'Esta última etapa permite conceder o consentimento do administrador para o uso de algumas permissões do Microsoft Entra ID e coleta algumas informações adicionais sobre o seu ambiente do Microsoft 365.<br /><br />';
$string['settings_setup_step3'] = 'Verificar configuração';
$string['settings_setup_step3_desc'] = 'A configuração está concluída. Clique no botão "Atualizar" abaixo para verificar a sua configuração.';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = 'Consentimento do administrador';
$string['settings_adminconsent_btn'] = 'Fornecer consentimento do administrador';
$string['settings_adminconsent_details'] = 'Para permitir o acesso a algumas das permissões necessárias, um administrador precisará fornecer o consentimento do administrador. Clique neste botão e faça login com uma conta de administrador do Microsoft Entra ID para fornecer o consentimento. Isso precisará ser feito sempre que você alterar as permissões de "Administrador" no Entra ID.';
$string['settings_entratenant'] = 'Locatário do Microsoft Entra';
$string['settings_entratenant_details'] = 'Usado para identificar a sua organização na Microsoft. Por exemplo: "contoso.onmicrosoft.com".<br/>
Para encontrar este valor manualmente:
<ul>
<li>Acesse o <a href="https://portal.azure.com" target="_blank">Azure Portal</a>.</li>
<li>Faça login com a sua conta de administrador.</li>
<li>Na barra de pesquisa, digite "Microsoft Entra ID" e acesse a página "Microsoft Entra ID".</li>
<li>Use o valor do campo <b>Domínio primário</b> na seção "Informações básicas".</li>
</ul>';
$string['settings_odburl'] = 'URL do OneDrive for Business';
$string['settings_odburl_details'] = 'A URL usada para acessar o OneDrive for Business. Geralmente, ela pode ser determinada pelo seu locatário do Microsoft Entra. Por exemplo, se o seu locatário do Microsoft Entra for "contoso.onmicrosoft.com", a URL provavelmente será "contoso-my.sharepoint.com". Insira apenas o nome do domínio e não inclua http:// ou https://';
$string['settings_odburl_error_graph'] = 'Não foi possível determinar a URL do OneDrive for Business. Insira-a manualmente. Geralmente, ela pode ser determinada pela URL que você usa para acessar o OneDrive.';
$string['settings_serviceresourceabstract_detect'] = 'Detectar';
$string['settings_serviceresourceabstract_detecting'] = 'Detectando...';
$string['settings_serviceresourceabstract_error'] = 'Ocorreu um erro ao detectar a configuração. Defina-a manualmente.';
$string['settings_serviceresourceabstract_valid'] = '{$a} pode ser utilizado.';
$string['settings_serviceresourceabstract_invalid'] = 'Parece que não é possível utilizar esse valor.';
$string['settings_serviceresourceabstract_nocreds'] = 'Antes defina as credenciais do aplicativo.';
$string['settings_serviceresourceabstract_empty'] = 'Insira um valor ou clique em "Detectar" para tentar detectar o valor correto.';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = 'Verificar configuração';
$string['settings_verifysetup_appdataheader'] = 'Registro do aplicativo do Microsoft Entra ID';
$string['settings_verifysetup_appdatadesc'] = 'Verifica se os parâmetros corretos estão configurados no aplicativo do Entra ID.';
$string['settings_verifysetup_appdatareplyurlcorrect'] = 'URL de resposta correta';
$string['settings_verifysetup_appdatareplyurlincorrect'] = 'URL de resposta incorreta';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = 'Não foi possível verificar a URL de resposta.';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'URL de logon correta.';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'URL de logon incorreta';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'Não foi possível verificar a URL de logon.';
$string['settings_verifysetup_apppermscorrect'] = 'As permissões de aplicativo estão corretas.';
$string['settings_verifysetup_details'] = 'Esta ferramenta verifica com o Microsoft Entra ID se tudo está configurado corretamente. <br /><b>Observação:</b> as alterações no aplicativo do Microsoft Entra ID podem levar um momento para aparecer aqui. Se você fez uma alteração no aplicativo do Microsoft Entra ID e ela não aparece aqui, aguarde um momento e tente novamente.';
$string['settings_verifysetup_correctval'] = 'Valor correto:';
$string['settings_verifysetup_detectedval'] = 'Valor detectado:';
$string['settings_verifysetup_update'] = 'Atualizar';
$string['settings_verifysetup_checking'] = 'Verificando...';
$string['settings_verifysetup_missingappperms'] = 'Permissões de aplicativo ausentes:';
$string['settings_verifysetup_notgranted'] = 'adicionada ao aplicativo, mas o consentimento do administrador não foi concedido';
$string['settings_verifysetup_missingperms'] = 'Permissões delegadas ausentes:';
$string['settings_verifysetup_permscorrect'] = 'As permissões delegadas estão corretas.';
$string['settings_verifysetup_errorcheck'] = 'Ocorreu um erro ao tentar verificar a configuração.';
$string['settings_verifysetup_noinfo'] = 'Ainda não há informações sobre a configuração do seu aplicativo do Microsoft Entra ID. Clique no botão Atualizar para verificar.';
$string['settings_verifysetup_strunifiedpermerror'] = 'Ocorreu um erro ao verificar as permissões da API do Microsoft Graph.';
$string['settings_verifysetup_strtenanterror'] = 'Use o botão Detectar para definir o seu locatário do Microsoft Entra antes de atualizar a configuração do aplicativo do Microsoft Entra ID.';
$string['settings_verifysetup_unifiedheader'] = 'API do Microsoft Graph';
$string['settings_verifysetup_unifieddesc'] = 'A API do Microsoft Graph permite a comunicação entre o Moodle e o Microsoft 365.';
$string['settings_verifysetup_unifiederror'] = 'Ocorreu um erro ao verificar o suporte à API do Microsoft Graph.';
$string['settings_verifysetup_unifiedactive'] = 'API do Microsoft Graph ativa.';
$string['settings_verifysetup_unifiedmissing'] = 'A API do Microsoft Graph não foi encontrada neste aplicativo.';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = 'As credenciais foram definidas.';
$string['settings_detectoidc_credsvalid_link'] = 'Alterar';
$string['settings_detectoidc_credsinvalid'] = 'As credenciais não foram definidas ou estão incompletas.';
$string['settings_detectoidc_credsinvalid_link'] = 'Definir credenciais';
$string['settings_detectperms_nocreds'] = 'Antes é necessário definir as credenciais do aplicativo. Veja a configuração acima.';
$string['settings_detectperms_errorfix'] = 'Ocorreu um erro ao tentar corrigir as permissões. Corrija-as manualmente no Microsoft Entra ID.';
$string['settings_detectperms_fixperms'] = 'Corrigir permissões';
$string['settings_detectperms_update'] = 'Atualizar';
$string['settings_detectperms_valid'] = 'As permissões foram configuradas.';
$string['settings_detectperms_invalid'] = 'Verificar permissões no Microsoft Entra ID';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = 'Sincronização geral de usuários';
$string['settings_usersync_suspension'] = 'Suspensão de contas do Moodle';
$string['settings_usersync_matching'] = 'Correspondência de usuários';
$string['settings_usersync_photos'] = 'Sincronizar fotos de perfil do Microsoft 365 com o Moodle';
$string['settings_usersync_timezone'] = 'Sincronizar o fuso horário do Outlook com o Moodle';
$string['settings_usersync'] = 'Sincronizar usuários do Microsoft Entra ID';
$string['settings_usersync_details'] = 'Quando ativada, o Moodle sincroniza os usuários do Microsoft Entra ID de acordo com as opções acima.<br /><br /><b>Observação: </b>o trabalho de sincronização é executado no cron do Moodle e sincroniza 1000 usuários por vez. Por padrão, ele é executado uma vez ao dia, à 1h no fuso horário local do seu servidor. Para sincronizar grandes conjuntos de usuários com mais agilidade, você pode aumentar a frequência da tarefa <b>Sincronizar usuários do Microsoft Entra ID</b> usando a <a href="{$a}">página de gerenciamento de tarefas agendadas.</a><br /><br />';
$string['settings_usersync_create'] = 'Criar contas no Moodle para usuários do Microsoft Entra ID';
$string['settings_usersync_update'] = 'Atualizar contas no Moodle para usuários do Microsoft Entra ID';
$string['settings_usersync_suspend'] = 'Suspender contas sincronizadas anteriormente no Moodle quando forem excluídas do Microsoft Entra ID';
$string['settings_usersync_delete'] = 'Excluir contas sincronizadas anteriormente no Moodle quando forem excluídas do Microsoft Entra ID';
$string['settings_usersync_reenable'] = 'Reativar contas suspensas para usuários do Microsoft Entra ID';
$string['settings_usersync_disabledsyncsuspend'] = 'Suspender contas no Moodle quando desativadas no Microsoft Entra ID';
$string['settings_usersync_disabledsyncreenable'] = 'Reativar contas no Moodle quando reativadas no Microsoft Entra ID';
$string['settings_usersync_suspendnolink'] = 'Suspender contas conectadas que não têm vínculo com a Microsoft armazenado quando forem excluídas ou desativadas no Microsoft Entra ID';
$string['settings_usersync_groupsyncsuspend'] = 'Suspender contas no Moodle quando não estiverem no grupo de sincronização de usuários configurado';
$string['settings_usersync_match'] = 'Associar usuários pré-existentes do Moodle a contas de mesmo nome no Microsoft Entra ID';
$string['settings_usersync_matchswitchauth'] = 'Alterar a autenticação dos usuários associados para o Microsoft 365 (OpenID Connect)';
$string['settings_usersync_appassign'] = 'Atribuir usuários ao aplicativo durante a sincronização';
$string['settings_usersync_photosync'] = 'Sincronizar fotos de perfil do Microsoft 365 com o Moodle no cron';
$string['settings_usersync_photosynconlogin'] = 'Sincronizar fotos de perfil do Microsoft 365 com o Moodle no login';
$string['settings_usersync_nodelta'] = 'Executar uma sincronização completa a cada execução';
$string['settings_usersync_emailsync'] = 'Associar nomes de usuário do Microsoft Entra ID a e-mails do Moodle em vez de nomes de usuário do Moodle durante a sincronização';
$string['settings_addsync_tzsync'] = 'Sincronizar o fuso horário do Outlook com o Moodle no cron';
$string['settings_addsync_tzsynconlogin'] = 'Sincronizar o fuso horário do Outlook com o Moodle no login';
$string['settings_usersync_guestsync'] = 'Sincronizar usuários convidados';
$string['settings_suspend_delete_running_time'] = 'Horário de execução da suspensão/exclusão de usuários';
$string['settings_suspend_delete_running_time_desc'] = 'Se a opção estiver ativada, o recurso de suspensão/exclusão da sincronização de usuários será executado uma vez ao dia, no horário configurado no fuso horário padrão da instância do Moodle.';
$string['settings_usersync_delete_delay'] = 'Atraso antes de excluir usuários suspensos';
$string['settings_usersync_delete_delay_desc'] = 'O tempo mínimo que um usuário deve permanecer suspenso no Moodle antes que a sincronização de usuários exclua a conta. Isso se aplica além do período de retenção de exclusão reversível do Microsoft Entra ID, portanto a exclusão nunca ocorre antes dele. Defina como 0 para excluir assim que o período de retenção do Microsoft Entra ID terminar. Os usuários que já estavam suspensos antes da introdução desta configuração são contados a partir da primeira execução da sincronização de usuários que os encontrar.';
$string['settings_support_user_identifier_change'] = 'Oferecer suporte à alteração do valor da declaração de nome de usuário de vinculação da conta Microsoft';
$string['settings_support_user_identifier_change_desc'] = 'Se ativada, o Moodle tentará reagir quando o valor da declaração de nome de usuário de vinculação, que normalmente é o UPN, de uma conta Microsoft conectada a uma conta do Moodle for alterado.<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>ID do caso</th>
        <th>O usuário com o nome de usuário antigo já fez login? (token criado)<br/>
        <span class="support_user_identifier_change_case_detail">Se um token está salvo na tabela auth_oidc_token</span>
        </th>
        <th>Primeira ação após a renomeação do UPN<br/>
        <span class="support_user_identifier_change_case_detail">Login ou execução da tarefa de sincronização de usuários</span>
        </th>
        <th>Há possível nome de usuário duplicado<br/>
        <span class="support_user_identifier_change_case_detail">Se a renomeação causaria um conflito de nome de usuário no Moodle</span>
        </th>
        <th>Comportamentos esperados</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Sim</td>
        <td>Login</td>
        <td>Não</td>
        <td>
            <ol>
                <li>Renomear o usuário do Moodle.</li>
                <li>auth_oidc_token atualizado com novos valores para os campos "username" e "oidcusername".</li>
                <li>Campo "o365name" do registro de conexão de usuário em local_o365_objects atualizado para o novo valor.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Sim</td>
        <td>Sincronização de usuários</td>
        <td>Não</td>
        <td>
            <ol>
                <li>Renomear o usuário do Moodle.</li>
                <li>Registro de conexão de usuário em local_o365_objects atualizado.</li>
                <li>auth_oidc_token atualizado.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Não</td>
        <td>Login</td>
        <td>Não</td>
        <td>
            <ol>
                <li>Renomear o usuário do Moodle.</li>
                <li>Registro de conexão de usuário em local_o365_objects atualizado.</li>
                <li>auth_oidc_token atualizado.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Não</td>
        <td>Sincronização de usuários</td>
        <td>Não</td>
        <td>
            <ol>
                <li>Renomear o usuário do Moodle.</li>
                <li>Registro de conexão de usuário em local_o365_objects atualizado.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Sim</td>
        <td>Login</td>
        <td>Sim</td>
        <td>
            <ol>
                <li>Lançar exceção e não renomear o usuário do Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Sim</td>
        <td>Sincronização de usuários</td>
        <td>Sim</td>
        <td>
            <ol>
                <li>Exibir mensagem de erro informando que a tentativa de renomeação falhou na execução da tarefa de sincronização de usuários.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Não</td>
        <td>Login</td>
        <td>Sim</td>
        <td>
            <ol>
                <li>Lançar exceção e não renomear o usuário do Moodle.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Não</td>
        <td>Sincronização de usuários</td>
        <td>Sim</td>
        <td>
            <ol>
                <li>Exibir mensagem de erro informando que a tentativa de renomeação falhou na execução da tarefa de sincronização de usuários.</li>
            </ol>
        </td>
    </tr>
</table>
Observe que há um problema conhecido: se
<ol>
<li>o Moodle e o Microsoft 365 estiverem conectados usando o método de conexão "Plataforma de identidade da Microsoft (v2.0)", e</li>
<li>o Microsoft Entra estiver configurado para permitir o uso de "E-mail como ID de logon alternativa", e</li>
<li>esta opção estiver ativada, e</li>
<li>o nome de usuário e o endereço de e-mail da conta Microsoft forem diferentes, e</li>
<li>o usuário da Microsoft fizer login usando o endereço de e-mail em vez do nome de usuário</li>
</ol>
então o plugin auth_oidc tratará o endereço de e-mail como o nome de usuário da conta Microsoft e atualizará o nome de usuário do Moodle.';

// User field mapping.
$string['settings_fieldmap'] = 'Mapeamento de campos de usuário';
$string['settings_fieldmap_details'] = 'Disponível no <a href="{$a}">plugin de autenticação OpenID Connect</a>.';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'Sincronização de cursos';
$string['settings_secthead_coursesync_desc'] = 'As configurações a seguir controlam a sincronização de cursos entre o Moodle e o Microsoft Teams.';
$string['settings_coursesync'] = 'Sincronização de cursos';
$string['settings_coursesync_details'] = 'Se ativada, criará e manterá Teams para os cursos do site Moodle (padrão: desativada). Isso criará os Teams necessários a cada execução do cron e adicionará todos os usuários atualmente inscritos como proprietários ou membros do Team, dependendo da verificação de capacidade. Depois disso, a participação no Team será mantida conforme os usuários forem inscritos ou desinscritos dos cursos do Moodle.';
$string['acp_coursesynccustom_off'] = 'Desativado<br />Desativa a criação de Teams para todos os cursos.';
$string['acp_coursesynccustom_oncustom'] = 'Personalizar<br />Permite que usuários autorizados selecionem para quais cursos criar Teams.<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">Personalizar sincronização de cursos</a></span>';
$string['acp_coursesynccustom_onall'] = 'Todos os recursos ativados<br />Ativa a criação de Teams para todos os cursos.';
$string['settings_coursesync_sync_hidden_courses'] = 'Sincronizar cursos ocultos';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'Por padrão, o plugin ignora os cursos ocultos para evitar a sincronização de cursos que estão sendo copiados ou restaurados. Ative esta configuração para forçar a criação de Teams para cursos ocultos.';
$string['acp_coursesync_hidden_course_note'] = 'Observação: os cursos ocultos não serão processados para a criação de grupos do Teams. Para permitir isso, você deve ativar a configuração "Sincronizar cursos ocultos" na configuração do plugin.';
$string['settings_coursesync_delete_group_on_course_deletion'] = 'Excluir grupos do Microsoft 365 quando o curso do Moodle conectado for excluído';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = 'Se ativada, o Moodle tentará excluir o Grupo do Microsoft 365 (e o Team associado) quando o curso conectado for excluído do Moodle. Observe que isso não se aplica a cursos criados pela sincronização SDS.';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'Excluir grupos do Microsoft 365 quando a sincronização de cursos for desativada';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = 'Se ativada, o Moodle tentará excluir o Grupo do Microsoft 365 conectado (e o Team associado) quando a sincronização de cursos for desativada para um curso do Moodle.';
$string['settings_coursesync_courses_per_task'] = 'Cursos a sincronizar por execução da tarefa';
$string['settings_coursesync_courses_per_task_details'] = 'O número de cursos cujo status de sincronização de Team/grupo será processado a cada execução da tarefa.';
$string['settings_coursesync_team_type'] = 'Modelo de Team';
$string['settings_coursesync_team_type_desc'] = 'O modelo do Microsoft Teams a ser usado ao criar Teams a partir de cursos do Moodle. Os modelos educacionais exigem uma licença educacional. <br><br><strong>Importante:</strong> o modelo configurado determina como os grupos e os Teams são criados:<br>
&bull; O modelo Padrão cria grupos e Teams padrão (compatível com todos os locatários).<br>
&bull; Os modelos educacionais criam grupos/Teams educacionais (somente locatários educacionais; ativa recursos específicos para educação).<br>
&bull; Os modelos personalizados usam grupos padrão (para compatibilidade com o design do modelo personalizado).<br><br>
<strong>⚠️ AVISO: depois que um Team é criado com um modelo específico, o modelo não pode ser alterado.</strong> Os Teams permanecem associados ao modelo original. A alteração desta configuração afeta apenas os Teams recém-criados, não os existentes. Planeje cuidadosamente a seleção do modelo antes de ativar a sincronização de cursos.';
$string['settings_coursesync_team_type_standard'] = 'Padrão';
$string['settings_coursesync_team_type_educationclass'] = 'Educação - Team de turma';
$string['settings_coursesync_team_type_educationstaff'] = 'Educação - Team de funcionários';
$string['settings_coursesync_team_type_educationplc'] = 'Educação - Comunidade de aprendizagem profissional (PLC)';
$string['settings_coursesync_team_type_custom'] = 'Modelo personalizado';
$string['settings_coursesync_team_type_custom_id'] = 'ID do modelo personalizado';
$string['settings_coursesync_team_type_custom_id_desc'] = 'O ID completo de um modelo personalizado definido no centro de administração do Teams. Usado somente quando "Modelo personalizado" está selecionado acima. <br><br><strong>O ID do modelo deve estar no formato GUID</strong> (por exemplo, e41de7bb-859a-4a0f-aa39-5725a0529c1c). Você pode encontrar o ID do modelo no centro de administração do Teams ao visualizar os detalhes do seu modelo personalizado. <br><br>
<strong>⚠️ PERMISSÃO ADICIONAL DO MICROSOFT ENTRA ID NECESSÁRIA:</strong> validar e usar modelos de Team personalizados exige uma permissão de aplicativo adicional da API do Microsoft Graph (<strong>TeamTemplates.Read.All</strong>) que pode não estar presente no registro do seu aplicativo do Microsoft Entra ID. Sem essa permissão, a etapa de validação falhará e o ID do modelo personalizado não poderá ser definido. Se a validação falhar com um erro de permissão, entre em contato com o administrador do Microsoft Entra ID para adicionar essa permissão ao registro do seu aplicativo. <br><br>
<strong>⚠️ LIMITAÇÃO IMPORTANTE:</strong> atualmente, a estrutura do Microsoft Teams só oferece suporte à criação de Teams a partir de modelos personalizados quando o modelo inclui uma <strong>definição de localidade en-US</strong>. Modelos personalizados sem suporte à localidade en-US falharão ao criar Teams. Certifique-se de que seu modelo personalizado tenha uma localidade en-US definida no centro de administração do Teams. <br><br>
<strong>⚠️ AVISO: depois que um Team é criado usando este modelo personalizado, o modelo não pode ser alterado.</strong> Se você precisar usar um modelo personalizado diferente para novos Teams, deixe esta configuração vazia ou altere-a antes da próxima criação de Team. Os Teams existentes continuarão a usar o modelo original. <br><br>
Os Teams não serão criados corretamente se um ID de modelo incorreto estiver configurado. Use o botão "Validar ID do modelo personalizado" para validar o ID do modelo antes de executar a sincronização de cursos.';
$string['error_custom_template_id_required'] = 'O ID do modelo personalizado é obrigatório ao usar a opção "Modelo personalizado". Insira um ID de modelo válido.';
$string['error_custom_template_id_not_found'] = 'O ID de modelo personalizado "{$a}" não foi encontrado. Verifique se o ID do modelo existe no centro de administração do Teams.';
$string['error_custom_template_id_validation_failed'] = 'A validação do ID do modelo personalizado falhou. O modelo pode não oferecer suporte à criação direta de Teams ou pode haver um problema de configuração. Verifique o ID do modelo no centro de administração do Teams.';
$string['settings_team_type_custom_id_test_button'] = 'Validar ID do modelo personalizado';
$string['settings_team_type_custom_id_validating'] = '🔄 Validando...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ Insira primeiro um ID de modelo.';
$string['settings_team_type_custom_id_error_not_found'] = '✗ Modelo não encontrado. O ID de modelo "{$a}" não existe. Verifique-o no centro de administração do Teams.';
$string['settings_team_type_custom_id_error_validation'] = '✗ Erro de validação. {$a}';
$string['settings_team_type_custom_id_error_default'] = 'Falha ao validar o modelo. Tente novamente ou entre em contato com o administrador.';
$string['settings_team_type_custom_id_error_timeout'] = '✗ A validação expirou. A solicitação levou mais de 10 segundos. Tente novamente.';
$string['settings_team_type_custom_id_error_network'] = '✗ Erro de rede. Não foi possível acessar o serviço de validação. Verifique sua conexão com a internet e tente novamente.';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ Erro na resposta do servidor. O serviço de validação retornou dados inválidos. Verifique a sua integração ao Microsoft 365.';
$string['settings_team_type_custom_id_error_http'] = '✗ Erro de validação (HTTP {$a}). Tente novamente ou entre em contato com o administrador.';
$string['settings_coursesync_group_channels'] = 'Criar um canal para cada grupo do Moodle';
$string['settings_coursesync_group_channels_details'] = 'Cria um canal privado no Microsoft Team conectado para cada grupo do curso do Moodle e mantém os membros de cada canal alinhados com os membros do grupo do Moodle. Os membros do grupo que também estão conectados ao Microsoft 365 são adicionados ao canal ou removidos dele quando são adicionados ao grupo ou removidos dele. Qualquer pessoa adicionada a um canal no Microsoft Teams que não seja membro do grupo do Moodle é removida novamente. Em um Team de turma educacional que ainda não foi ativado, os estudantes não podem ser colocados em canais: somente os proprietários são, e os estudantes são adicionados automaticamente pela tarefa agendada "Criar canais do Teams para grupos do Moodle e sincronizar seus membros" depois que um proprietário ativa o Team no Microsoft Teams. Os canais não são renomeados nem excluídos quando um grupo do Moodle é renomeado ou excluído. A participação nos canais é sempre sincronizada apenas do Moodle para o Teams, e esta opção não faz nada se "Comportamento de sincronização de usuários do curso" estiver definido como "Do Teams para o Moodle". O Microsoft Teams permite até 1.000 canais em um Team, contando canais privados e canais excluídos nos últimos 30 dias.<br /><br /><b>Esta configuração precisa de duas permissões de aplicativo adicionais do Microsoft Graph:</b><ul><li><b>Channel.Create</b> - para criar os canais.</li><li><b>ChannelMember.ReadWrite.All</b> - para adicionar membros aos canais e removê-los deles.</li></ul>Ambas devem ser adicionadas ao aplicativo do Microsoft Entra ID usado pelo Moodle e receber o consentimento do administrador. O script do PowerShell na guia "Configuração" já as inclui ao registrar um novo aplicativo. Para um aplicativo que já existe, adicione-as manualmente em Registros de aplicativo &gt; seu aplicativo &gt; Permissões de API &gt; Adicionar uma permissão &gt; Microsoft Graph &gt; Permissões de aplicativo e, em seguida, conceda o consentimento do administrador. Enquanto esta configuração estiver ativada, "Verificar configuração" na guia "Configuração" informa que essas permissões estão ausentes até que sejam concedidas.';
$string['settings_coursesync_sync_direction'] = 'Comportamento de sincronização de usuários do curso';
$string['settings_coursesync_sync_direction_details'] = 'Selecione a direção em que você deseja que os usuários sejam sincronizados entre o Moodle e o Microsoft Teams.';
$string['settings_coursesync_sync_moodle_to_teams'] = 'Do Moodle para o Teams';
$string['settings_coursesync_sync_teams_to_moodle'] = 'Do Teams para o Moodle';
$string['settings_coursesync_sync_both'] = 'Atualizar o Teams e o Moodle';
$string['settings_coursesync_enrolment_owner_role'] = 'Papel de proprietário do Team';
$string['settings_coursesync_enrolment_owner_role_desc'] = 'O papel que será atribuído ao proprietário do Team durante a sincronização.';
$string['settings_coursesync_enrolment_member_role'] = 'Papel de membro do Team';
$string['settings_coursesync_enrolment_member_role_desc'] = 'O papel que será atribuído aos membros do Team durante a sincronização.';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'Personalização da sincronização de cursos';
$string['acp_coursesynccustom_enabled'] = 'Ativado';
$string['acp_coursesynccustom_enable_all'] = 'Ativar a sincronização de cursos em todos os cursos';
$string['acp_coursesynccustom_disable_all'] = 'Desativar a sincronização de cursos em todos os cursos';
$string['acp_coursesynccustom_bulk'] = 'Operações em massa';
$string['acp_coursesynccustom_bulk_enable'] = 'Ativar a sincronização de cursos nos cursos desta página';
$string['acp_coursesynccustom_bulk_disable'] = 'Desativar a sincronização de cursos nos cursos desta página';
$string['acp_coursesynccustom_settings_header'] = 'Opções de sincronização';
$string['acp_coursesynccustom_new_course'] = 'Ativada por padrão para novos cursos';
$string['acp_coursesynccustom_new_course_desc'] = 'Se ativada, todos os cursos recém-criados terão a sincronização ativada por padrão.';
$string['acp_coursesynccustom_controlled_per_course'] = 'Permitir configurar a sincronização de cursos nos cursos';
$string['acp_coursesynccustom_controlled_per_course_desc'] = 'Se ativada, os usuários inscritos em cursos do Moodle que podem atuar como proprietários do Team (com a capacidade "Proprietário do Team" [local/o365:teamowner]) poderão controlar a sincronização do curso pelo bloco Microsoft no curso.';
$string['acp_coursesynccustom_savemessage'] = 'Suas mudanças foram salvas.';
$string['acp_coursesynccustom_regex_search'] = 'Pesquisa com expressão regular';
$string['acp_coursesynccustom_regex_search_title'] = 'Quando marcada, a caixa de pesquisa acima é comparada como uma expressão regular PCRE (sem delimitadores) com o nome completo, o nome abreviado e o número de ID, em vez de uma pesquisa de texto simples.';
$string['acp_coursesynccustom_confirm_all_action'] = 'Tem certeza de que deseja alterar o status de sincronização de todos os cursos? A ação não pode ser desfeita.';
$string['acp_coursesynccustom_sds_course'] = 'Bloqueado para curso do SDS';
$string['acp_coursesynccustom_all_enabled_notice'] = 'A sincronização de cursos está atualmente ativada para todos os cursos. A personalização de cursos individuais está desativada porque o modo "Todos os recursos ativados" está ativo.';
$string['acp_coursesynccustom_disabled_notice'] = 'A sincronização de cursos está atualmente desativada globalmente. A personalização de cursos individuais está desativada porque o modo "Desativado" está ativo.';
$string['acp_coursesynccustom_categories_header'] = 'Sincronizar por categoria de curso';
$string['acp_coursesynccustom_categories_desc'] = 'Selecione uma ou mais categorias de curso para ativar automaticamente a sincronização de cursos para todos os cursos dessas categorias, incluindo suas subcategorias. Isso também se aplica a cursos adicionados posteriormente às categorias selecionadas. Mantenha Ctrl (Cmd no Mac) pressionado para selecionar várias categorias ou clique novamente enquanto o mantém pressionado para desmarcar.';
$string['acp_coursesynccustom_category_course'] = 'Bloqueado: ativado pela categoria do curso';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'Sincronização de coortes';
$string['settings_secthead_cohortsync_desc'] = 'Este recurso permite a sincronização entre grupos do Microsoft 365 e coortes do Moodle.';
$string['settings_cohortsync'] = 'Sincronização de coortes';
$string['settings_cohortsync_linktext'] = 'Gerenciar sincronização de coortes';
$string['settings_cohortsync_details'] = 'Revise e gerencie a sincronização entre coortes do Moodle e grupos do Microsoft 365.';
$string['settings_cohortsync_title'] = 'Sincronização de coortes';
$string['settings_cohortsync_excludeowners'] = 'Excluir proprietários de grupos da sincronização de coortes';
$string['settings_cohortsync_excludeowners_desc'] = 'Se ativada, os proprietários de grupos não são sincronizados com as coortes do Moodle, mesmo que também sejam membros do grupo. Os proprietários que já estão em uma coorte serão removidos na próxima execução da sincronização.';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'Nomes de Teams / grupos';
$string['settings_secthead_team_group_name_desc'] = 'Se um curso estiver configurado para ser sincronizado, o nome do Team e do grupo será construído da seguinte forma.<br/>
<ul>
<li>O alias de e-mail do grupo e os nomes de exibição do Team podem ser definidos.</li>
<li>O grupo do Microsoft 365 será criado primeiro usando o mailNickname do grupo e o nome de exibição do Team configurados primeiro, e um Team será criado a partir do grupo.</li>
<li>Se a política de nomenclatura do Microsoft Entra ID para grupos do Microsoft 365 for usada, os grupos não serão criados se o nome de exibição criado de acordo com a configuração não corresponder às políticas.</li>
<li>As alterações feitas aqui afetarão apenas a criação futura de Teams, e não os existentes.</li>
<li>Todos os espaços serão removidos do alias de e-mail do grupo.</li>
<li>Somente letras maiúsculas e minúsculas, números, - e _ são permitidos no alias de e-mail do grupo.</li>
<li>O alias de e-mail do grupo, incluindo prefixo e sufixo, não pode exceder 64 caracteres.</li>
<li>O alias de e-mail do grupo precisa ser exclusivo; caso contrário, um número aleatório de 4 dígitos será anexado para garantir a exclusividade.</li>
</ul>';
$string['settings_team_name_prefix'] = 'Prefixo do nome do Team';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'Parte do curso no nome do Team';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'Sufixo do nome do Team';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'Prefixo do alias de e-mail do grupo';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'Parte do curso no alias de e-mail do grupo';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'Sufixo do alias de e-mail do grupo';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'Suponha que um curso tenha:
<ul>
<li>Nome completo: <b>Curso de exemplo</b></li>
<li>Nome abreviado: <b>exemplo 15</b></li>
<li>ID criado pelo Moodle: <b>2</b></li>
<li>Número de ID: <b>ID de exemplo 15</b></li>
</ul>
Sua configuração atual criará um grupo usando o alias de e-mail "<b>{$a->mailalias}</b>" e um Team usando o nome "<b>{$a->teamname}</b>".<br/>
Clique no botão "Salvar mudanças" abaixo para ver como suas configurações alterarão isso.';
$string['settings_main_name_option_full_name'] = 'Nome completo';
$string['settings_main_name_option_short_name'] = 'Nome abreviado';
$string['settings_main_name_option_id'] = 'ID criado pelo Moodle';
$string['settings_main_name_option_id_number'] = 'Número de ID';
$string['settings_team_name_sync'] = 'Atualizar o nome do Team na atualização do curso';
$string['settings_team_name_sync_desc'] = 'Se ativada, quando o curso do Moodle for atualizado, o nome do Team será atualizado de acordo com as configurações de nome de Teams mais recentes.';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'Solicitação de curso';
$string['settings_secthead_course_request_desc'] = 'Configurações dos mapeamentos de papéis no recurso de solicitação de curso a partir do Teams.';
$string['settings_course_request_enrolment_owner_role'] = 'Papel de proprietário do Team';
$string['settings_course_request_enrolment_owner_role_desc'] = 'O papel que será atribuído ao proprietário do Team quando a solicitação de curso for aprovada.';
$string['settings_course_request_enrolment_member_role'] = 'Papel de membro do Team';
$string['settings_course_request_enrolment_member_role_desc'] = 'O papel que será atribuído aos membros do Team quando a solicitação de curso for aprovada.';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'Ferramentas';
$string['settings_secthead_calsync'] = 'Sincronização de calendário';
$string['settings_calsyncsubscribemode'] = 'Assinatura da sincronização de calendário';
$string['settings_calsyncsubscribemode_details'] = 'Controla se os usuários precisam ativar a sincronização do calendário do Outlook por conta própria.<ul><li><b>Adesão voluntária</b>: os usuários ativam a sincronização de calendário e marcam os calendários a sincronizar na página de configurações de sincronização de calendário.</li><li><b>Adesão automática</b>: os usuários conectados ao Microsoft 365 têm a sincronização de calendário ativada automaticamente e são inscritos nos calendários escolhidos abaixo (para cursos, todos os cursos em que estão inscritos, agora e no futuro), sincronizando do Moodle para o calendário principal do Outlook. Os usuários ainda podem alterar ou desativar isso na página de configurações de sincronização de calendário, e os usuários que desativam a sincronização de calendário não são inscritos novamente.</li></ul>Voltar para "Adesão voluntária" não remove as assinaturas existentes.';
$string['settings_calsyncsubscribetypes'] = 'Calendários nos quais inscrever os usuários automaticamente';
$string['settings_calsyncsubscribetypes_details'] = 'Aplica-se somente a "Adesão automática". Escolha em quais calendários do Moodle os usuários conectados são inscritos automaticamente. Inscrever todos no calendário do site adiciona cada usuário como participante de cada evento do site, portanto essa opção não é selecionada por padrão.';
$string['settings_calsyncsubscribetypes_site'] = 'Calendário do site';
$string['settings_calsyncsubscribetypes_user'] = 'Calendário pessoal';
$string['settings_calsyncsubscribetypes_course'] = 'Calendários de curso (todos os cursos em que o usuário está inscrito)';
$string['settings_calsyncsubscribemode_optin'] = 'Adesão voluntária (os usuários ativam a sincronização de calendário por conta própria)';
$string['settings_calsyncsubscribemode_optout'] = 'Adesão automática (ativar a sincronização de calendário automaticamente para todos os usuários conectados)';
$string['settings_secthead_advanced'] = 'Configurações avançadas';
$string['settings_secthead_advanced_desc'] = 'Estas configurações controlam outros recursos do conjunto de plugins. Tenha cuidado! Elas podem causar efeitos indesejados.';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'Locatários';
$string['settings_tools_tenants_linktext'] = 'Configurar locatários adicionais';
$string['settings_tools_tenants_details'] = 'Gerencie o acesso a locatários adicionais do Microsoft Entra.';
$string['settings_healthcheck'] = 'Verificação de integridade';
$string['settings_healthcheck_details'] = 'Se algo não estiver funcionando corretamente, a execução de uma verificação de integridade geralmente pode identificar o problema e sugerir soluções.';
$string['settings_healthcheck_linktext'] = 'Executar verificação de integridade';
$string['settings_userconnections'] = 'Conexões de usuários';
$string['settings_userconnections_linktext'] = 'Gerenciar conexões de usuários';
$string['settings_userconnections_details'] = 'Revise e gerencie as conexões entre usuários do Moodle e do Microsoft 365.';
$string['settings_teamconnections'] = 'Conexões de Teams';
$string['settings_teamconnections_linktext'] = 'Gerenciar conexões de Teams';
$string['settings_teamconnections_details'] = 'Revise e gerencie as conexões entre cursos do Moodle e o Microsoft Teams.';
$string['settings_usermatch'] = 'Correspondência de usuários';
$string['settings_usermatch_details'] = 'Esta ferramenta permite associar usuários do Moodle a usuários do Microsoft 365 com base em um arquivo de dados personalizado enviado.';
$string['settings_usersyncgroupfilter'] = 'Filtro de grupo da sincronização de usuários';
$string['settings_usersyncgroupfilter_details'] = 'Quando um ID de objeto de grupo (GUID) é inserido aqui, as sincronizações completas de usuários ficam restritas aos membros e proprietários desse grupo do Microsoft 365. Deixe em branco para sincronizar todos os usuários licenciados do seu locatário.<br><br>
<strong>ATENÇÃO: esta é uma configuração avançada. Uma configuração incorreta pode causar sérios problemas de sincronização de dados.</strong><br><br>
<strong>Quando configurada, aplica-se o seguinte:</strong><br>
(1) As atualizações de perfil, de fuso horário e de foto serão aplicadas somente a usuários que são membros ou proprietários do grupo<br>
(2) Novas contas do Moodle serão criadas somente para usuários que são membros ou proprietários do grupo<br>
(3) As contas do Moodle de usuários que não são membros deixarão de receber atualizações e podem ficar dessincronizadas em relação ao Microsoft 365<br>
(4) Os usuários desativados no Microsoft 365 ainda serão suspensos no Moodle pela sincronização do status de ativação, que é executada independentemente da filtragem por grupo<br>
(5) Remover um usuário do grupo interrompe as sincronizações futuras dessa conta. A conta do Moodle dele não é excluída e só é suspensa se a opção "Suspender contas no Moodle quando não estiverem no grupo de sincronização de usuários configurado" estiver ativada, o que suspende todos os usuários sincronizados que não estão no grupo, quer tenham estado nele ou não<br><br>
<strong>Limitação da sincronização incremental (delta):</strong> o Microsoft Graph não oferece suporte a consultas delta nos pontos de extremidade de associação a grupos. Quando esta configuração está definida, as sincronizações delta executarão uma sincronização completa dos membros do grupo em vez de uma atualização incremental. Esse é o comportamento correto, mas pode ser mais lento que uma sincronização delta normal.<br><br>
Valide o ID de objeto do grupo antes de salvar. Insira o ID de objeto do grupo (GUID).';
$string['settings_usersyncgroupfilter_validation_error'] = 'Formato de ID de grupo inválido. O ID do grupo deve ser um GUID válido (por exemplo, 550e8400-e29b-41d4-a716-446655440000).';
$string['settings_usersynccreationrestriction'] = 'Restrição de criação de usuários';
$string['settings_usersynccreationrestriction_details'] = 'Se ativada, somente os usuários do Microsoft Entra ID que correspondam à condição serão criados durante a sincronização de usuários. Para Associação a grupo do Microsoft 365 (ID de objeto do grupo), insira um ID de objeto de grupo ou vários IDs de objeto de grupo separados por vírgulas.';
$string['settings_usersynccreationrestriction_fieldval'] = 'Valor do campo';
$string['settings_usersynccreationrestriction_o365group'] = 'Associação a grupo do Microsoft 365 (nome do grupo)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Associação a grupo do Microsoft 365 (ID de objeto do grupo)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'O ID de objeto de grupo do Microsoft 365 "{$a}" não foi encontrado. Verifique o ID e tente novamente.';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'Não foi possível validar os IDs de objeto de grupo do Microsoft 365. Verifique os IDs e a configuração do Microsoft Graph e tente novamente.';
$string['settings_usersynccreationrestriction_regex'] = 'O valor é uma expressão regular';
$string['settings_maintenance'] = 'Manutenção';
$string['settings_maintenance_details'] = 'Várias tarefas de manutenção estão disponíveis para resolver alguns problemas comuns.';
$string['settings_maintenance_linktext'] = 'Ver ferramentas de manutenção';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'Multilocação';
$string['acp_tenants_title_desc'] = 'Esta página ajuda você a configurar o acesso multilocatário ao Moodle a partir do Microsoft 365.';
$string['acp_tenants_add'] = 'Adicionar novo locatário';
$string['acp_tenants_errornotsetup'] = 'Conclua o processo de configuração do plugin antes de adicionar locatários adicionais.';
$string['acp_tenants_hosttenant'] = 'Locatário host: {$a}';
$string['acp_tenants_intro'] = '<b>Como funciona a multilocação:</b><br />A multilocação permite que vários locatários do Microsoft Entra acessem o seu site Moodle. <br /><br />
    Veja como configurar:
    <ol>
        <li>Faça login no Moodle como um usuário administrador do site que não esteja usando o plugin de autenticação OpenID Connect.</li>
        <li>Verifique se as configurações <b>Ponto de extremidade de autorização</b> e <b>Ponto de extremidade de token</b> do plugin de autenticação OpenID Connect estão usando as configurações padrão, não específicas de locatário.</li>
        <li>Desative o plugin de autenticação OpenID Connect no Moodle. (Use <a href="{$a}/admin/settings.php?section=manageauths">a página de administração dos plugins de autenticação</a>.)</li>
        <li>Acesse o Microsoft Entra ID e localize o aplicativo que você configurou para o Moodle.</li>
        <li>Ative a multilocação no aplicativo do Microsoft Entra ID e salve as alterações.</li>
        <li>Conceda ao aplicativo pelo menos uma das seguintes permissões delegadas do Graph: <b>Directory.Read.All</b>, <b>Domain.Read.All</b> ou <b>Domain.ReadWrite.All</b>. O consentimento do administrador para a sua organização não é necessário.</li>
        <li>Se você já estiver conectado usando a sua conta Microsoft do locatário adicional, saia completamente e faça login novamente.</li>
        <li>Para cada locatário que você deseja ativar, clique em "Adicionar novo locatário" e faça login com uma conta de administrador do locatário que deseja ativar.</li>
        <li>Depois de adicionar todos os locatários desejados, reative o plugin de autenticação OpenID Connect no Moodle.</li>
        <li>Pronto! Para adicionar locatários adicionais no futuro, basta clicar no botão "Adicionar novo locatário" e fazer login com uma conta de administrador desse locatário.</li>
    </ol>
    <b>Observação importante:</b> ativar a multilocação no aplicativo do Microsoft Entra ID permite que todos os locatários do Microsoft Entra acessem o seu aplicativo enquanto ela estiver ativada. Adicionar os locatários aqui nos permite restringir o acesso ao Moodle aos locatários que você configurar. <b>Se você remover todos os locatários desta lista antes de desativar a multilocação no aplicativo do Microsoft Entra ID, ou ativar a autenticação OpenID Connect no Moodle com uma lista vazia, o seu site Moodle ficará aberto a todos os locatários do Microsoft Entra.</b>';
$string['acp_tenants_none'] = 'Você não configurou nenhum locatário. Se você ativou a multilocação no aplicativo do Microsoft Entra ID, o seu site Moodle pode estar aberto a todos os usuários do Microsoft 365.';
$string['acp_tenants_revokeaccess'] = 'Revogar acesso';
$string['acp_tenants_tenant'] = 'Locatário';
$string['acp_tenants_actions'] = 'Ações';
$string['acp_tenants_delete'] = 'Excluir';
$string['acp_tenantsadd_desc'] = 'Para conceder acesso a um locatário adicional, clique no botão abaixo e faça login no Microsoft 365 usando uma conta de administrador do novo locatário. Você retornará à lista de locatários adicionais, na qual o novo locatário será listado. Então você poderá usar o Moodle com o novo locatário.';
$string['acp_tenantsadd_linktext'] = 'Prosseguir para a página de login do Microsoft 365';
$string['acp_tenants_legacy_tenants'] = 'Locatários legados (ação necessária)';
$string['acp_tenants_legacy_tenants_help'] = 'Os locatários adicionais abaixo, adicionados anteriormente, podem não funcionar no fluxo de multilocação atualizado e precisam ser corrigidos.<br/>
Use o botão "Adicionar novo locatário" acima para adicioná-los novamente.';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = 'Verificação de integridade';
$string['healthcheck_fixlink'] = 'Clique aqui para corrigir.';
$string['healthcheck_ratelimit_title'] = 'Limitação de API';
$string['healthcheck_ratelimit_result_notice'] = 'Uma leve limitação foi ativada para lidar com o aumento da carga do site Moodle. <br /><br />Todos os recursos do Microsoft 365 estão funcionando; isso apenas espaça ligeiramente as solicitações para evitar a interrupção dos serviços do Microsoft 365. Quando a atividade do Moodle diminuir, tudo voltará ao normal. <br />(Nível {$a->level} / iniciada em {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Uma limitação maior foi ativada para lidar com a carga significativa do site Moodle. <br /><br />Todos os recursos do Microsoft 365 continuam funcionando, mas as solicitações ao Microsoft 365 podem levar mais tempo para serem concluídas. Quando a atividade do site Moodle diminuir, tudo voltará ao normal. <br />(Nível {$a->level} / iniciada em {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'Os recursos de limitação de taxa foram desativados.';
$string['healthcheck_ratelimit_result_passed'] = 'As chamadas de API do Microsoft 365 estão sendo executadas na velocidade máxima.';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'Gerenciar conexões de usuários';
$string['acp_userconnections_column_muser'] = 'Usuário do Moodle';
$string['acp_userconnections_column_o365user'] = 'Usuário do Microsoft 365';
$string['acp_userconnections_column_status'] = 'Status da conexão';
$string['acp_userconnections_column_actions'] = 'Ações';
$string['acp_userconnections_column_usinglogin'] = 'Usando login';
$string['acp_userconnections_column_status_help'] = 'O status da conexão mostra como uma conta do Moodle está vinculada a uma conta do Microsoft 365 (Microsoft Entra ID).

* **Conectado** – O usuário concluiu a conexão fazendo login no Moodle com a conta do Microsoft 365, ou um administrador conectou a conta ativamente. Recursos como a sincronização de calendário e o OneDrive funcionam para esse usuário.
* **Associado** – Um administrador (ou a ferramenta de correspondência de usuários em massa) registrou a qual conta do Microsoft 365 esse usuário do Moodle pertence, mas a conexão ainda não está ativa. Ela é concluída na primeira vez que o usuário fizer login com o Microsoft 365. Nada é sincronizado enquanto o usuário está apenas associado.
* **Sincronizado** – A conta do Moodle foi criada a partir do Microsoft Entra ID pela tarefa de sincronização de usuários, mas o usuário ainda não fez login. A conta é ativada no primeiro login.
* **Sem conexão** – A conta do Moodle não está vinculada a nenhuma conta do Microsoft 365.';
$string['acp_userconnections_column_actions_help'] = 'As ações disponíveis para uma linha dependem do status da conexão.

* **Desconectar** – Remove o vínculo entre a conta do Moodle e a conta do Microsoft 365. A pessoa mantém a conta do Moodle, mas não pode mais usar os recursos do Microsoft 365 nem fazer login com o Microsoft 365 até se conectar novamente. Exibida para usuários conectados.
* **Ressincronizar** – Executa imediatamente a sincronização de dados do Microsoft 365 para este usuário (campos de perfil, foto, calendário e assim por diante) em vez de aguardar a tarefa agendada, e mostra o resultado. Exibida para usuários conectados e sincronizados.
* **Associar** – Registra a qual conta do Microsoft 365 esse usuário do Moodle pertence. A conexão não fica ativa até que a pessoa faça login com o Microsoft 365. Exibida para usuários sem conexão.
* **Desassociar** – Remove uma associação que ainda não foi concluída. Exibida para usuários associados.';
$string['acp_userconnections_accountstatus_active'] = 'Ativa';
$string['acp_userconnections_accountstatus_suspended'] = 'Suspensa';
$string['acp_userconnections_connectionstatus_connected'] = 'Conectado';
$string['acp_userconnections_connectionstatus_matched'] = 'Associado';
$string['acp_userconnections_connectionstatus_noconnection'] = 'Sem conexão';
$string['acp_userconnections_connectionstatus_synced'] = 'Sincronizado';
$string['acp_userconnections_filtering_accountstatus'] = 'Status da conta';
$string['acp_userconnections_filtering_connectionstatus'] = 'Status da conexão';
$string['acp_userconnections_filtering_muserfullname'] = 'Nome completo do usuário do Moodle';
$string['acp_userconnections_filtering_musername'] = 'Nome de usuário do Moodle';
$string['acp_userconnections_filtering_o365username'] = 'Nome de usuário do Microsoft 365';
$string['acp_userconnections_manualmatch_title'] = 'Associação manual de usuário';
$string['acp_userconnections_manualmatch_details'] = 'Esta página permite associar um único usuário do Moodle a um único usuário do Microsoft 365.';
$string['acp_userconnections_manualmatch_musername'] = 'Usuário do Moodle';
$string['acp_userconnections_manualmatch_uselogin'] = 'Fazer login com o Microsoft 365';
$string['acp_userconnections_manualmatch_o365username'] = 'Nome de usuário do Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'O usuário do Moodle já está conectado a um usuário do Microsoft 365';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'O usuário do Moodle já está conectado a um usuário do Microsoft 365 (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'O usuário do Moodle já está associado a um usuário do Microsoft 365';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'O usuário do Microsoft 365 já está associado a outro usuário do Moodle';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'O usuário do Microsoft 365 já está conectado a outro usuário do Moodle';
$string['acp_userconnections_resync_nodata'] = 'Não foi possível encontrar informações armazenadas do Microsoft 365 para este usuário.';
$string['acp_userconnections_resync_notfound'] = 'Nenhum dado foi sincronizado. A conta "{$a->username}" está vinculada ao objeto {$a->objectid} do Microsoft Entra ID, mas esse objeto não foi encontrado. Muito provavelmente o usuário foi excluído ou desativado no Microsoft 365, ou o ID de objeto armazenado está desatualizado.';
$string['acp_userconnections_resync_nooutput'] = 'A ressincronização foi concluída sem relatar nenhuma alteração.';
$string['acp_userconnections_table_disconnect'] = 'Desconectar';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Isso desconectará o usuário do Moodle "{$a}" do Microsoft 365. Clique no link abaixo para continuar.';
$string['acp_userconnections_table_match'] = 'Associar';
$string['acp_userconnections_table_resync'] = 'Ressincronizar';
$string['acp_userconnections_table_unmatch'] = 'Desassociar';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Isso desassociará o usuário do Moodle "{$a}" do Microsoft 365. Clique no link abaixo para continuar.';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'Gerenciar conexões de Teams';
$string['acp_teamconnection'] = 'Gerenciar conexão de Team';
$string['acp_teamconnections_actions'] = 'Ações';
$string['acp_teamconnections_cache_last_updated'] = 'O cache do Teams foi atualizado pela última vez em {$a->lastupdated}. Clique <a href="{$a->updateurl}">aqui</a> para atualizar o cache.';
$string['acp_teamconnections_cache_never_updated'] = 'O cache do Teams nunca foi atualizado. Clique <a href="{$a->updateurl}">aqui</a> para atualizar.';
$string['acp_teamconnections_connected_team'] = 'Team conectado';
$string['acp_teamconnections_course_connected'] = 'O curso foi conectado ao Team com sucesso.';
$string['acp_teamconnections_course_disconnected'] = 'O curso foi desconectado do Team.';
$string['acp_teamconnections_team_linked'] = 'O curso foi vinculado ao Team.';
$string['acp_teamconnections_current_connection'] = 'CONEXÃO ATUAL';
$string['acp_teamconnections_exception_course_not_exist'] = 'O curso a ser conectado não existe.';
$string['acp_teamconnections_exception_invalid_team_id'] = 'ID de Team inválido';
$string['acp_teamconnections_exception_not_configured'] = 'O Microsoft 365 não está totalmente configurado.';
$string['acp_teamconnections_exception_team_already_connected'] = 'O Team já está conectado a outro curso';
$string['acp_teamconnections_form_connect_course'] = 'Gerenciar a conexão de Team do curso {$a}';
$string['acp_teamconnections_form_sds_warning'] = 'OBSERVAÇÃO: os Teams criados pelo Student Data Sync (SDS) não podem ser conectados manualmente aqui, pois isso entraria em conflito com a sincronização do SDS. Eles são excluídos dos resultados da pesquisa abaixo.';
$string['acp_teamconnections_form_team'] = 'Selecionar Team';
$string['acp_teamconnections_form_team_noselection'] = 'Pesquisar um Team...';
$string['acp_teamconnections_no_teams_found'] = 'Nenhum Team encontrado para "{$a}"';
$string['acp_teamconnections_group_only'] = ' (Somente grupo)';
$string['acp_teamconnections_team_missing'] = '(Team ausente)';
$string['acp_teamconnections_not_connected'] = 'Não conectado';
$string['acp_teamconnections_sync_disabled'] = 'A sincronização de cursos precisa ser ativada antes de gerenciar as conexões de Teams.';
$string['acp_teamconnections_table_connect'] = 'Conectar';
$string['acp_teamconnections_table_connect_to_different_team'] = 'Conectar a um Team diferente';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'Não é possível criar um Team a partir do grupo - sem proprietário';
$string['acp_teamconnections_table_link_team'] = 'Vincular ao Team "{$a}"';
$string['acp_teamconnections_table_missing_team'] = 'O curso está conectado a um Team inexistente. Isso será limpo na próxima execução da tarefa agendada de sincronização de cursos.';
$string['acp_teamconnections_table_resync'] = 'Ressincronizar';
$string['acp_teamconnections_table_update'] = 'Atualizar';
$string['acp_teamconnections_teams_cache_updated'] = 'Cache do Teams atualizado com sucesso.';
$string['acp_teamconnections_no_owner'] = 'Adicione um proprietário para conectar ao Teams.';
$string['acp_teamconnections_resync'] = 'Ressincronizar proprietários / membros do Team';
$string['acp_teamconnections_resync_title'] = 'Ressincronizar proprietários / membros do Team do curso {$a}';
$string['acp_teamconnections_resync_desc'] = 'Isso compara os usuários inscritos no curso com os proprietários e membros do grupo/Team do Microsoft 365 conectado e adiciona quem estiver faltando. Escolha se os usuários que estão no Team, mas não inscritos no curso do Moodle, também devem ser removidos.';
$string['acp_teamconnections_resync_keep'] = 'Ressincronizar (manter membros adicionais do Team)';
$string['acp_teamconnections_resync_keep_desc'] = 'Os usuários inscritos no curso do Moodle que estão ausentes do Team serão adicionados. Os proprietários / membros existentes do Team que não estão inscritos no curso do Moodle não serão alterados.';
$string['acp_teamconnections_resync_remove'] = 'Ressincronizar e remover membros adicionais do Team';
$string['acp_teamconnections_resync_remove_desc'] = 'Aviso: qualquer proprietário ou membro do Team que não esteja inscrito no curso do Moodle será removido do Team, mesmo que tenha sido adicionado diretamente no Microsoft Teams.';
$string['acp_teamconnections_resync_completed'] = 'Os proprietários / membros do Team foram ressincronizados.';
$string['acp_teamconnections_resync_failed'] = 'Não foi possível ressincronizar os proprietários / membros do Team. Veja a saída acima para obter detalhes.';
$string['acp_teamconnections_last_resync'] = 'Última ressincronização: {$a}';
$string['acp_teamconnections_never_resynced'] = 'Nunca ressincronizado';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'Correspondência de usuários';
$string['acp_usermatch_desc'] = 'Esta ferramenta permite associar usuários do Moodle a usuários do Microsoft 365. Você enviará um arquivo contendo usuários do Moodle e os usuários do Microsoft 365 associados, e uma tarefa do cron verificará os dados e configurará a associação.';
$string['acp_usermatch_upload'] = 'Etapa 1: enviar novas associações';
$string['acp_usermatch_upload_desc'] = 'Envie um arquivo de dados contendo nomes de usuário do Moodle e do Microsoft 365 para associar usuários do Moodle a usuários do Microsoft 365.<br />
<br />
Este arquivo deve ser um arquivo CSV de texto simples contendo três itens por linha:
<ul>
<li>o nome de usuário do Moodle,</li>
<li>o nome de usuário do Microsoft 365,</li>
<li>1 ou 0, em que 1 significa alterar o método de autenticação do usuário para OpenID Connect e 0 significa manter o método de autenticação existente e usá-lo como conta vinculada.</li>
</ul>
Não inclua cabeçalhos nem dados adicionais.<br />
Por exemplo: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'O tipo {$a} não é compatível. Envie um CSV de texto simples.';
$string['acp_usermatch_upload_err_data'] = 'A linha #{$a} continha dados inválidos. Cada linha do arquivo CSV deve ter pelo menos dois itens: o nome de usuário do Moodle e o nome de usuário do Microsoft 365.';
$string['acp_usermatch_upload_err_fileopen'] = 'Não foi possível abrir o arquivo para processamento. As permissões estão corretas no seu diretório moodledata?';
$string['acp_usermatch_upload_err_nofile'] = 'Nenhum arquivo foi recebido para adicionar à fila.';
$string['acp_usermatch_upload_submit'] = 'Adicionar arquivo de dados à fila de associação';
$string['acp_usermatch_matchqueue'] = 'Etapa 2: fila de associação';
$string['acp_usermatch_matchqueue_clearall'] = 'Limpar tudo';
$string['acp_usermatch_matchqueue_clearerrors'] = 'Limpar erros';
$string['acp_usermatch_matchqueue_clearqueued'] = 'Limpar enfileirados';
$string['acp_usermatch_matchqueue_clearsuccess'] = 'Limpar bem-sucedidos';
$string['acp_usermatch_matchqueue_column_muser'] = 'Nome de usuário do Moodle';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Nome de usuário do Microsoft 365';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'Status';
$string['acp_usermatch_matchqueue_desc'] = 'Esta tabela mostra o status atual da operação de associação. Sempre que a tarefa agendada <b>Processar fila de associação</b> for executada, um lote dos usuários a seguir será processado.<br /><b>Observação:</b> esta página não é atualizada dinamicamente; atualize a página para ver o status atual.';
$string['acp_usermatch_matchqueue_empty'] = 'A fila de associação está vazia no momento. Envie um arquivo de dados usando o seletor de arquivos acima para adicionar usuários à fila.';
$string['acp_usermatch_matchqueue_status_error'] = 'Erro: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'Enfileirado';
$string['acp_usermatch_matchqueue_status_success'] = 'Bem-sucedido';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'Ferramentas de manutenção';
$string['acp_maintenance_desc'] = 'Estas ferramentas podem ajudar você a resolver alguns problemas comuns.';
$string['acp_maintenance_warning'] = 'Aviso: estas são ferramentas avançadas. Use-as somente se você entender o que está fazendo.';
$string['acp_maintenance_resyncgroupusers'] = 'Ressincronizar usuários em grupos do Microsoft 365 para cursos';
$string['acp_maintenance_resyncgroupusers_desc'] = 'Isso ressincronizará a participação de usuários em todos os grupos do Microsoft 365 criados para todos os cursos do Moodle. Isso garantirá que todos os usuários inscritos no curso do Moodle, e somente eles, estejam no grupo do Microsoft 365. <br /><b>Observação:</b> se você adicionou a um Grupo do Microsoft 365 usuários adicionais que não estão inscritos no curso do Moodle associado, eles serão removidos.';
$string['acp_maintenance_recreatedeletedgroups'] = 'Recriar grupos do Microsoft 365 excluídos';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Isso verificará se há grupos do Microsoft 365 conectados a cursos do Moodle que possam ter sido excluídos manualmente e os recriará.';
$string['acp_maintenance_debugdata'] = 'Gerar pacote de dados de depuração';
$string['acp_maintenance_debugdata_desc'] = 'Isso gerará um pacote contendo várias informações sobre o seu ambiente do Moodle e do Microsoft 365 para ajudar os desenvolvedores a resolver quaisquer problemas que você possa ter. Se solicitado por um desenvolvedor, execute esta ferramenta e envie o arquivo resultante para download. Observação: embora este pacote não contenha dados confidenciais de tokens, pedimos que você não publique este arquivo nem o envie a uma parte não confiável.';
$string['acp_maintenance_cleandeltatoken'] = 'Limpar tokens delta da sincronização de usuários';
$string['acp_maintenance_cleandeltatoken_desc'] = 'Se a sincronização de usuários não estiver funcionando totalmente após a atualização de suas configurações, a causa pode ser um token de sincronização delta antigo. Limpar o token forçará uma nova sincronização completa na próxima vez que a sincronização de usuários for executada.';
$string['acp_maintenance_cleanapptokens'] = 'Limpar tokens de aplicativo';
$string['acp_maintenance_cleanapptokens_desc'] = 'Remove os tokens de aplicativo armazenados, que o plugin usa para chamadas a APIs da Microsoft que não são executadas como um usuário. Novos tokens de aplicativo são solicitados automaticamente quando forem necessários novamente, e os resultados da última verificação de "Verificar configuração" na guia Configuração são limpos. Se as chamadas feitas com permissões de aplicativo falharem com erros de autenticação, por exemplo, depois que as permissões do aplicativo do Microsoft Entra ID ou suas credenciais forem alteradas, limpar os tokens pode ajudar. Os tokens dos usuários não são afetados.';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = 'Saída da ressincronização';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Nenhum curso conectado ao Microsoft 365';
$string['acp_maintenance_coursesync_disabled'] = 'Esta ferramenta só está disponível quando a sincronização de cursos está ativada. <a href="{$a}">Gerenciar sincronização de cursos</a>.';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Tipo de objeto do Moodle';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'Curso';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'Grupo do curso';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'Curso';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'Grupo do curso';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'Status';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'A sincronização de cursos está desativada';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'O grupo foi recriado';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'Falha ao recriar o grupo';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Todos os grupos conectados a cursos e grupos de curso do Moodle existem.';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'O token delta e o token de ignorar delta da sincronização de usuários foram limpos.';
$string['acp_maintenance_cleanapptokens_confirm'] = 'Tem certeza de que deseja limpar os tokens de aplicativo? Atualmente há {$a} token(s) de aplicativo armazenado(s).';
$string['acp_maintenance_cleanapptokens_completed'] = 'Os tokens de aplicativo e os últimos resultados de "Verificar configuração" foram limpos.';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'Ações de Team/grupo na reconfiguração de curso';
$string['settings_course_reset_teams_details'] = 'Ações a serem executadas em um Team ou grupo conectado a um curso quando o curso for reconfigurado.';
$string['settings_course_reset_teams_option_do_nothing'] = 'Não fazer nada<br/>O Team ou grupo continua conectado ao curso. O cancelamento da inscrição de usuários resultará na remoção do usuário do Team ou grupo.';
$string['settings_course_reset_teams_option_per_course'] = 'Permitir configurações por curso<br/>Isso exige que o bloco Microsoft seja adicionado ao curso. Os usuários com a capacidade de reconfigurar o curso podem escolher no bloco o que fazer durante a reconfiguração do curso.';
$string['settings_course_reset_teams_option_force_archive'] = 'Desconectar o curso do Team ou grupo e criar um novo<br/>O Team ou grupo existente conectado ao curso será renomeado conforme configurado. Se um Team estiver conectado, ele será arquivado. Um novo Team ou grupo será criado e conectado ao curso.';
$string['settings_course_reset_teams_option_archive_only'] = 'Desconectar o curso apenas do Team ou grupo<br />O Team ou grupo existente conectado ao curso será renomeado conforme configurado. Se um Team estiver conectado, ele será arquivado. Nenhum novo Team ou grupo será criado.';
$string['settings_reset_team_name_prefix'] = 'Prefixo do nome do Team na reconfiguração';
$string['settings_reset_team_name_prefix_details'] = 'Ao reconfigurar um curso conectado a um Team, o nome do Team conectado existente receberá este prefixo.';
$string['settings_reset_group_name_prefix'] = 'Prefixo do nome do grupo na reconfiguração';
$string['settings_reset_group_name_prefix_details'] = 'Ao reconfigurar um curso conectado a um grupo, o nome do grupo existente receberá este prefixo.';
$string['settings_calsync_courseeventmode'] = 'Eventos do Outlook para eventos do calendário do curso';
$string['settings_calsync_courseeventmode_details'] = 'Controla como um evento do calendário do curso do Moodle é criado no Outlook para os usuários que se inscreveram no calendário do curso.
<ul>
<li><strong>Um evento compartilhado com os usuários do curso como participantes:</strong> um único evento é criado no calendário do Outlook do usuário que criou o evento do Moodle (ou no calendário do grupo do Microsoft 365 do curso, se o curso estiver vinculado a um grupo), e os usuários do curso são adicionados a ele como participantes.</li>
<li><strong>Um evento individual por usuário:</strong> um evento separado é criado diretamente no calendário do Outlook de cada usuário inscrito. Não há evento compartilhado, nem lista de participantes, e nada é adicionado ao calendário do grupo do Microsoft 365.</li>
</ul>
Alterar esta configuração afeta apenas os eventos sincronizados depois; os eventos que já estão no Outlook não são convertidos.';
$string['settings_calsync_courseeventmode_shared'] = 'Um evento compartilhado com os usuários do curso como participantes';
$string['settings_calsync_courseeventmode_individual'] = 'Um evento individual por usuário';
$string['settings_debugmode'] = 'Registrar mensagens de depuração';
$string['settings_debugmode_details'] = 'Se ativada, informações que podem ajudar a identificar problemas serão registradas no log do Moodle. <a href="{$a}">Ver mensagens de log registradas.</a>';
$string['settings_switchauthminupnsplit0'] = 'Tamanho mínimo de nome de usuário inexato para alternar para o Microsoft 365';
$string['settings_switchauthminupnsplit0_details'] = 'Se você ativar a configuração "Alterar a autenticação dos usuários associados para o Microsoft 365 (OpenID Connect)", ela define o tamanho mínimo dos nomes de usuário sem locatário (a parte @example.onmicrosoft.com) que serão alterados. Isso ajuda a evitar a alteração de contas com nomes genéricos, como "admin", que não são necessariamente as mesmas no Moodle e no Microsoft Entra ID. Defina como 0 para alterar os usuários associados independentemente do tamanho do nome de usuário. Os usuários cujo método de autenticação não foi alterado por causa desta configuração são registrados como "Matched user, but the username is not an exact match to the Microsoft Entra ID UPN and does not meet the exact-match requirements for switching to OIDC..." na saída da tarefa de sincronização e aparecem como "Matched with existing user - Awaiting completion" na página Gerenciar conexões de usuários.';
$string['settings_customtheme'] = 'Tema personalizado (avançado)';
$string['settings_customtheme_desc'] = 'O tema recomendado é "boost_o365teams". No entanto, você pode selecionar um tema diferente se tiver um tema personalizado adaptado para ser usado na guia do Teams.<br/>
Observe que um tema personalizado definido no nível do curso ou da categoria teria precedência sobre as configurações aqui, ou seja, um curso usaria por padrão o tema do curso ou da categoria no aplicativo Moodle no Teams. Isso pode ser corrigido atualizando $CFG->themeorder no config.php para "array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');".';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>Este é um recurso em versão preliminar</b><br />Os recursos em versão preliminar podem não funcionar como esperado ou deixar de funcionar sem aviso. Prossiga com cuidado.</div>';
$string['settings_sds_intro_desc'] = 'O Microsoft School Data Sync ("SDS") simplifica o gerenciamento de turmas no Microsoft 365, lendo listas de participantes de um SIS externo e criando turmas e grupos no Microsoft 365. <a href="https://sds.microsoft.com/" target="_blank">Saiba mais</a><br/>
<br/>
O recurso de sincronização do SDS é capaz de sincronizar dados de listas de participantes do SDS com o Moodle, incluindo turmas, professores e estudantes.<br/>
<br/>
Para usar o recurso de sincronização do SDS, verifique se o aplicativo do Microsoft Entra ID usado na integração tem as permissões de aplicativo do Microsoft Graph <b>EduRoster.Read.All</b> e <b>Member.Read.Hidden</b>, que não são adicionadas automaticamente pela configuração padrão. O consentimento do administrador também precisa ser concedido para elas.<br/>
<br/>
Por padrão, o processo de sincronização do SDS ocorre diariamente no cron do Moodle, às 3h no horário do servidor. Para alterar essa programação, acesse a <a href="{$a}">página de gerenciamento de tarefas agendadas.</a><br/><br/>';
$string['settings_sds_coursecreation'] = 'Sincronização de turma para curso';
$string['settings_sds_coursecreation_desc'] = 'Estas opções controlam a criação de cursos do Moodle com base nas turmas das escolas do SDS.';
$string['settings_sds_coursecreation_enabled'] = 'Escolas sincronizadas';
$string['settings_sds_coursecreation_enabled_desc'] = 'Criar cursos para as turmas destas escolas.';
$string['settings_sds_teams_enabled'] = 'As turmas do SDS já têm Teams?';
$string['settings_sds_teams_enabled_desc'] = 'Marque esta opção se as turmas do SDS já tiverem Teams criados pela configuração do SDS. Se marcada, o Moodle não tentará criar Teams a partir dos cursos do Moodle criados com base em turmas do SDS, para evitar conflitos.';
$string['settings_sds_courseenrolsync'] = 'Sincronização de inscrições em cursos';
$string['settings_sds_courseenrolsync_desc'] = 'Estas opções controlam a sincronização das inscrições em cursos a partir das turmas das escolas do SDS.';
$string['settings_sds_enrolment_enabled'] = 'Sincronizar inscrições do SDS para o Moodle';
$string['settings_sds_enrolment_enabled_desc'] = 'Quando ativada, a tarefa agendada de sincronização do SDS inscreverá professores e estudantes das turmas do SDS nos cursos correspondentes do Moodle e removerá os usuários que não estão mais na turma do SDS. Exige que <b>Papel de professor de turma do SDS no Moodle</b> e <b>Papel de estudante de turma do SDS no Moodle</b> estejam configurados.';
$string['settings_sds_sync_enrolment_to_sds'] = 'Sincronizar inscrições do Moodle para o SDS';
$string['settings_sds_sync_enrolment_to_sds_desc'] = 'Quando ativada, as alterações de inscrição feitas em cursos do Moodle conectados a turmas do SDS serão sincronizadas de volta com as turmas do SDS. O status de propriedade / participação do usuário no SDS dependerá das capacidades "local/o365:teamowner" e "local/o365:teammember" no contexto do curso.';
$string['settings_sds_suspend_enrolment'] = 'Suspender inscrições de usuários em vez de cancelar a inscrição deles';
$string['settings_sds_suspend_enrolment_desc'] = 'Quando esta opção está ativada, os usuários removidos de uma turma do SDS terão a inscrição suspensa no curso do Moodle conectado, em vez de terem a inscrição completamente cancelada. Isso preserva dados do usuário, como notas, envios e conclusão de atividades. Quando os usuários forem adicionados novamente à turma do SDS, a inscrição deles será reativada automaticamente.<br />
<b>Observação:</b> os professores nunca são suspensos nem têm a inscrição cancelada pela sincronização do SDS. Esta configuração afeta apenas os estudantes.';
$string['settings_sds_enable_course_sync'] = 'Ativar sincronização de cursos bidirecional';
$string['settings_sds_enable_course_sync_desc'] = 'Quando ativada, cada curso do Moodle criado a partir de uma turma do SDS será vinculado ao respectivo grupo do Microsoft 365 no banco de dados, ativando a integração completa de sincronização de cursos do Microsoft 365 (Teams, arquivos, calendário etc.) para esse curso. Se a turma do SDS já tiver um Team, um registro de associação ao Teams também será criado.';
$string['settings_sds_course_field_mailnickname'] = 'Apelido de e-mail (mailNickname)';
$string['settings_sds_course_field_displayname'] = 'Nome de exibição (displayName)';
$string['settings_sds_course_field_classcode'] = 'Código da turma (classCode)';
$string['settings_sds_course_field_externalname'] = 'Nome externo (externalName)';
$string['settings_sds_course_shortname_field'] = 'Origem do nome abreviado do curso';
$string['settings_sds_course_shortname_field_desc'] = 'A propriedade da turma do SDS usada como nome abreviado dos cursos do Moodle recém-criados. O Moodle exige que os nomes abreviados de curso sejam exclusivos. Se a propriedade escolhida estiver vazia ou se o valor dela já for usado por um curso vinculado a outra turma do SDS, o apelido de e-mail será usado. Alterar esta configuração não renomeia os cursos que já foram criados.';
$string['settings_sds_course_fullname_field'] = 'Origem do nome completo do curso';
$string['settings_sds_course_fullname_field_desc'] = 'A propriedade da turma do SDS usada como nome completo dos cursos do Moodle recém-criados. Se a propriedade escolhida estiver vazia, o nome de exibição será usado. Alterar esta configuração não renomeia os cursos que já foram criados.';
$string['settings_sds_categorize_by_subject'] = 'Categorizar cursos por disciplina';
$string['settings_sds_categorize_by_subject_desc'] = 'Quando ativada, os cursos serão organizados em categorias baseadas em disciplinas dentro de cada categoria de escola. O nome da disciplina é extraído das informações da turma no SDS. Quando desativada, todos os cursos são colocados diretamente na categoria da escola.';
$string['settings_sds_ignore_past_courses'] = 'Ignorar turmas expiradas/passadas';
$string['settings_sds_ignore_past_courses_desc'] = 'Quando ativada, as turmas que expiraram ou terminaram serão ignoradas durante a sincronização. Isso inclui:<br />
<ul>
<li>Turmas com o prefixo de expiração configurado no nome (padrão: "Exp")</li>
<li>Turmas com data de término no passado</li>
</ul>
Isso ajuda a manter o seu catálogo de cursos limpo, evitando criar cursos para turmas antigas ou arquivadas.';
$string['settings_sds_expired_course_prefix'] = 'Prefixo de nome de turma expirada';
$string['settings_sds_expired_course_prefix_desc'] = 'Os nomes de turma que começam com este prefixo serão considerados expirados e ignorados durante a sincronização (se "Ignorar turmas expiradas/passadas" estiver ativada). Padrão: "Exp"';
$string['settings_sds_cohortsync'] = 'Sincronização de coortes';
$string['settings_sds_cohortsync_desc'] = 'Estas opções controlam a criação e a sincronização de coortes a partir de turmas do SDS. As coortes oferecem uma forma alternativa de agrupar usuários, que pode ser usada para inscrição em todo o site ou outros recursos do Moodle.';
$string['settings_sds_create_cohorts'] = 'Criar coortes a partir de turmas do SDS';
$string['settings_sds_create_cohorts_desc'] = 'Quando ativada, uma coorte será criada para cada turma do SDS e a participação será mantida sincronizada com a turma do SDS. As coortes são criadas no contexto da categoria de curso (categoria de escola ou de disciplina, dependendo das configurações de categorização).<br />
<b>Observação:</b> as coortes são criadas além dos cursos, e não no lugar deles. Isso permite usar coortes para inscrição em todo o site ou agrupamento, mantendo os cursos sincronizados com o SDS.';
$string['settings_sds_cohort_include_teachers'] = 'Incluir professores nas coortes';
$string['settings_sds_cohort_include_teachers_desc'] = 'Quando ativada, os professores da turma do SDS serão adicionados à coorte junto com os estudantes. Quando desativada, somente os estudantes serão adicionados às coortes.';
$string['settings_sds_enrolment_teacher_role'] = 'Papel de professor de turma do SDS no Moodle';
$string['settings_sds_enrolment_teacher_role_desc'] = 'Se "Sincronizar inscrições do SDS para o Moodle" estiver ativada, os professores da turma do SDS serão inscritos no curso do Moodle conectado com este papel.';
$string['settings_sds_enrolment_student_role'] = 'Papel de estudante de turma do SDS no Moodle';
$string['settings_sds_enrolment_student_role_desc'] = 'Se "Sincronizar inscrições do SDS para o Moodle" estiver ativada, os estudantes da turma do SDS serão inscritos no curso do Moodle conectado com este papel.';
$string['settings_sds_profilesync_header'] = 'Sincronização de perfil de usuário';
$string['settings_sds_profilesync_header_desc'] = 'Cada escola do SDS pode armazenar o perfil de usuário de professores e membros da escola. O campo é específico da escola, ou seja, escolas diferentes podem ter valores diferentes no mesmo campo para o mesmo usuário.<br/>
Se uma escola for selecionada nesta seção, os campos de perfil de usuário do SDS poderão ser configurados no mapeamento de campos de usuário.
<ul>
<li>Observe que a sincronização dos campos do SDS ocorrerá somente ao executar a tarefa agendada "Sincronizar com o SDS", e não ao executar a tarefa agendada "Sincronizar usuários do Microsoft Entra ID" nem quando um usuário fizer login.</li>
<li>Observe que há um problema conhecido na API do Microsoft Graph usada por este recurso: determinados campos de perfil escolar de estudantes e professores não são retornados e, portanto, não estão disponíveis para sincronização, mesmo quando configurados.</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = 'Desativada';
$string['settings_sds_profilesync'] = 'Sincronizar dados de perfil da escola';
$string['settings_sds_profilesync_desc'] = 'Selecione a escola do SDS da qual o Moodle sincroniza os dados de perfil específicos do SDS.';
$string['settings_sds_noschools'] = '<div class="alert alert-info">Você não tem nenhuma escola disponível no SDS.</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">Falha ao obter as escolas do SDS. Verifique se o aplicativo do Microsoft Entra ID tem a permissão necessária.</div>';
$string['settings_sds_school_disabled_action'] = 'Ação de sincronização de escola desativada';
$string['settings_sds_school_disabled_action_desc'] = 'Ação a ser executada nos cursos do Moodle já conectados quando a sincronização é desativada em uma escola do SDS.';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Manter o curso do Moodle conectado ao Team';
$string['settings_sds_school_disabled_action_disconnect'] = 'Desconectar o curso do Moodle do Team';
$string['settings_sds_school_unavailable'] = '{$a} (lista de escolas do SDS indisponível no momento)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = 'O aplicativo Moodle para o <a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a> permite acessar e colaborar facilmente nos seus cursos do Moodle no Teams.';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Configure o seu aplicativo Moodle para o Microsoft Teams</h4>';
$string['settings_moodlesettingssetup'] = 'Configurar o Moodle';
$string['settings_check_moodle_settings'] = 'Verificar configurações do Moodle';
$string['settings_moodlesetup_checking'] = 'Verificando...';
$string['settings_notice_cookiesecureenabled'] = 'A opção Somente cookies seguros foi ativada com sucesso';
$string['settings_notice_cookiesecurealreadyenabled'] = 'A opção Somente cookies seguros já estava ativada';
$string['settings_notice_oidcenabled'] = 'OpenID Connect ativado com sucesso';
$string['settings_notice_oidcnotenabled'] = 'Não foi possível ativar o OpenID Connect';
$string['settings_notice_oidcalreadyenabled'] = 'O OpenID Connect já estava ativado';
$string['settings_notice_webservicesframealreadyenabled'] = 'Os serviços web já estavam ativados e a incorporação em frames também é permitida';
$string['settings_notice_webservicesframeenabled'] = 'Serviços web ativados com sucesso e a incorporação em frames também é permitida agora';
$string['settings_notice_restenabled'] = 'Protocolo REST ativado com sucesso';
$string['settings_notice_restnotenabled'] = 'Não foi possível ativar o protocolo REST';
$string['settings_notice_restalreadyenabled'] = 'O protocolo REST já estava ativado';
$string['settings_notice_o365serviceenabled'] = 'Serviços web do Microsoft 365 ativados com sucesso';
$string['settings_notice_o365servicealreadyenabled'] = 'Os serviços web do Microsoft 365 já estavam ativados';
$string['settings_notice_createtokenallowed'] = 'Permissão para criar um token de serviço web concedida';
$string['settings_notice_createtokenalreadyallowed'] = 'A permissão para criar um token de serviço web já havia sido concedida';
$string['settings_notice_createtokennotallowed'] = 'Ocorreu um problema ao conceder permissão para criar um token de serviço web';
$string['settings_notice_restusageallowed'] = 'Permissão para usar o protocolo REST concedida';
$string['settings_notice_restusagealreadyallowed'] = 'A permissão para usar o protocolo REST já havia sido concedida';
$string['settings_notice_restusagenotallowed'] = 'Ocorreu um problema ao conceder permissão para usar o protocolo REST';
$string['settings_moodlesettingssetup_details'] = 'Isso garantirá que:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>A opção Somente cookies seguros esteja ativada.</li>
<li>O OpenID Connect esteja ativado.</li>
<li>A incorporação em frames esteja ativada.</li>
<li>Os serviços web estejam ativados.</li>
<li>O protocolo REST esteja ativado.</li>
<li>Os serviços web do Microsoft 365 estejam ativados.</li>
<li>O usuário autenticado tenha permissão para criar um token de serviço web.</li>
<li>O usuário autenticado tenha permissão para usar o protocolo REST.</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'ID de aplicativo da Microsoft para o aplicativo Moodle do Teams';
$string['settings_teams_moodle_app_external_id_desc'] = 'Deve ser definido com o valor padrão, a menos que vários aplicativos Moodle do Teams sejam necessários no seu locatário para se conectar a diferentes sites Moodle.';
$string['settings_teams_moodle_app_short_name'] = 'Nome do aplicativo do Teams';
$string['settings_teams_moodle_app_short_name_desc'] = 'Pode ser definido como o padrão, a menos que vários aplicativos Moodle do Teams sejam necessários no seu locatário para se conectar a diferentes sites Moodle.';
$string['settings_download_teams_tab_app_manifest'] = 'Baixar arquivo de manifesto';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'Salve todas as suas alterações antes de baixar o manifesto.';
$string['settings_publish_manifest_instruction'] = '<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">Clique aqui</a> para saber como publicar o arquivo de manifesto do aplicativo Moodle baixado para todos os usuários do Teams.';
$string['settings_teams_moodle_tab_name'] = 'Nome da guia do Moodle no Teams';
$string['settings_teams_moodle_tab_name_desc'] = 'Este é o nome da guia do Moodle no Teams.';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'ID do aplicativo Moodle';
$string['settings_moodle_app_id_desc'] = 'ID do aplicativo Moodle enviado nos catálogos de aplicativos do Teams.<br/>
Se configurado, o Moodle tentará criar uma guia do Moodle com link para o curso do Moodle no canal "Geral" do Team criado/conectado.';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
O valor detectado automaticamente é "<span class="local_o365_settings_moodle_app_id">{$a}</span>".';
$string['settings_set_moodle_app_id_instruction'] = 'Para encontrar o ID do aplicativo Moodle manualmente, siga estas etapas:
<ol>
<li>Envie o arquivo de manifesto baixado para o catálogo de aplicativos do Teams do seu locatário.</li>
<li>No catálogo de aplicativos do Teams, localize o aplicativo.</li>
<li>Clique no ícone de opções do aplicativo, localizado no canto superior direito da imagem do aplicativo.</li>
<li>Clique em "Copiar link".</li>
<li>Em um editor de texto, cole o conteúdo copiado. Ele deve conter uma URL como https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
A última parte da URL, ou seja, <span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>, é o ID do aplicativo.';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Ativar sincronização do calendário do Outlook';
$string['calendar_user'] = 'Calendário pessoal (do usuário)';
$string['calendar_site'] = 'Calendário do site';
$string['personal_calendar'] = 'Pessoal';
$string['calendar_event'] = 'Ver detalhes';
$string['eventcalendarsubscribed'] = 'O usuário se inscreveu em um calendário';
$string['eventcalendarunsubscribed'] = 'O usuário cancelou a inscrição em um calendário';

// Errors.
$string['erroracpauthoidcnotconfig'] = 'Defina antes as credenciais do aplicativo em auth_oidc.';
$string['errorhttpclientbadtempfileloc'] = 'Não foi possível abrir o local temporário para armazenar o arquivo.';
$string['errorhttpclientnofileinput'] = 'Nenhum parâmetro de arquivo em httpclient::put';
$string['errorcouldnotrefreshtoken'] = 'Não foi possível atualizar o token';
$string['errormfarequired'] = 'A Microsoft exige autenticação multifator antes que o Moodle possa acessar a sua conta do Microsoft 365. Saia do Moodle, faça login novamente usando a sua conta do Microsoft 365 e conclua a solicitação de autenticação multifator.';
$string['errorgetapplicationtoken'] = 'Não foi possível obter o token do aplicativo. Verifique a configuração da sua integração.';
$string['erroracpapcantgettenant'] = 'Não foi possível obter o locatário do Microsoft Entra. Insira-o manualmente.';
$string['erroracpcantgettenant'] = 'Não foi possível obter a URL do OneDrive. Insira-a manualmente.';
$string['errorprovisioningapp'] = 'Não foi possível provisionar o aplicativo Moodle no Team.';
$string['erroro365apibadcall'] = 'Erro na chamada da API.';
$string['erroro365apibadcall_message'] = 'Erro na chamada da API: {$a}';
$string['erroro365apiinvalidtoken'] = 'Token inválido ou expirado.';
$string['erroro365apiinvalidmethod'] = 'httpmethod inválido transmitido para apicall';
$string['erroro365apinotimplemented'] = 'Isso deve ser substituído.';
$string['erroro365apinotoken'] = 'Não possuía um token disponível para o recurso e o usuário especificados e não foi possível obter um. O token de atualização do usuário está expirado?';
$string['errorusermatched'] = 'A conta do Microsoft 365 "{$a->entraidupn}" já está associada ao usuário do Moodle "{$a->username}". Para concluir a conexão, faça login primeiro como esse usuário do Moodle e siga as instruções no bloco Microsoft.';
$string['errornodirectaccess'] = 'O acesso direto à página é proibido';
$string['eventapifail'] = 'Falha na API';
$string['errorunabletofindgraphapi'] = 'Não foi possível encontrar a API do Microsoft Graph no aplicativo.';
$string['erroremptyjwt'] = 'Token JWT vazio fornecido';
$string['errornocachedjwks'] = 'Nenhum JWKS em cache encontrado';
$string['errorfetchjwks'] = 'Falha ao buscar o JWKS da Microsoft';
$string['errorinvalidjwks'] = 'Formato de JWKS inválido recebido da Microsoft';
$string['errorjwtvalidation'] = 'Falha na validação do JWT';
$string['errorjwtinvalidissuer'] = 'Falha na validação do emissor do JWT';
$string['errorcannotgettoken'] = 'Não foi possível obter o token do aplicativo ou do sistema.';
$string['errornotokenforsysmemuser'] = 'Nenhum token disponível para o usuário do sistema. Execute a verificação de integridade do local_o365.';
$string['errornotoken'] = 'Nenhum token disponível para o usuário #{$a}';
$string['errornotokenforusersync'] = 'Nenhum token disponível para a sincronização de usuários.';
$string['errornoapifound'] = 'Nenhuma API com o identificador {$a} foi encontrada.';
$string['errornoresponsesavailable'] = 'Nenhuma resposta disponível.';
$string['erroro365badphoto'] = 'Foto de perfil inválida recebida do Microsoft 365.';
$string['erroro365nophoto'] = 'Este usuário não tem uma foto no Microsoft 365.';
$string['errorcannotgetapiclient'] = 'Não foi possível obter o cliente da API do Graph.';
$string['errorfailedtogetsecrets'] = 'Falha ao obter os segredos.';
$string['errorfailedtosendnotification'] = 'Falha ao enviar o e-mail de notificação para um ou mais destinatários.';
$string['errorsecretexpiryrecipientundeliverable'] = 'Um ou mais destinatários configurados para a notificação de expiração de segredo não podem receber e-mails (endereço inválido ou domínio sem registro MX/A): {$a}. Atualize os destinatários da notificação nas configurações do OpenID Connect.';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Plugin local do Microsoft 365';
$string['privacy:metadata:local_o365_calidmap'] = 'Informações sobre os vínculos entre eventos de calendário do Microsoft 365 e eventos de calendário do Moodle.';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'O ID do usuário proprietário do evento.';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'A origem do evento. Moodle ou Microsoft 365.';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'O ID do evento no Outlook.';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'O ID do evento no Moodle.';
$string['privacy:metadata:local_o365_calsub'] = 'Informações sobre as assinaturas de sincronização entre calendários do Moodle e do Outlook';
$string['privacy:metadata:local_o365_calsub:user_id'] = 'O ID do usuário do Moodle ao qual a assinatura se destina';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'O tipo de calendário do Moodle (site, curso, usuário)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'O ID associado do calendário do Moodle';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'O ID do calendário do Microsoft 365';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'Se este é o calendário principal';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = 'O comportamento de sincronização (ou seja, do Moodle para o Outlook ou do Outlook para o Moodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = 'O momento em que a assinatura foi criada.';
$string['privacy:metadata:local_o365_connections'] = 'Informações sobre conexões entre usuários do Moodle e do Microsoft 365 que ainda não foram confirmadas';
$string['privacy:metadata:local_o365_connections:muserid'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'O UPN do usuário do Microsoft Entra ID.';
$string['privacy:metadata:local_o365_connections:uselogin'] = 'Se o método de autenticação do usuário deve ser alterado quando a conexão for concluída.';
$string['privacy:metadata:local_o365_token'] = 'Informações sobre os tokens de API do Microsoft 365 dos usuários';
$string['privacy:metadata:local_o365_token:user_id'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:local_o365_token:scope'] = 'O escopo do token.';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'O recurso do token.';
$string['privacy:metadata:local_o365_token:token'] = 'O token.';
$string['privacy:metadata:local_o365_token:expiry'] = 'O momento de expiração do token.';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'O token de atualização.';
$string['privacy:metadata:local_o365_objects'] = 'Informações sobre a relação entre objetos do Moodle e do Microsoft 365';
$string['privacy:metadata:local_o365_objects:type'] = 'O tipo de objeto (grupo, usuário, curso etc.)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'O subtipo do objeto.';
$string['privacy:metadata:local_o365_objects:objectid'] = 'O ID do objeto do Microsoft 365';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'O ID do objeto no Moodle';
$string['privacy:metadata:local_o365_objects:o365name'] = 'O nome legível do objeto no Microsoft 365';
$string['privacy:metadata:local_o365_objects:tenant'] = 'O locatário ao qual o objeto pertence (em ambientes multilocatário)';
$string['privacy:metadata:local_o365_objects:metadata'] = 'Quaisquer metadados associados';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'O momento em que o registro foi criado.';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'O momento em que o registro foi modificado.';
$string['privacy:metadata:local_o365_appassign'] = 'Informações sobre as atribuições de papéis de aplicativo do Microsoft 365';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'Se o usuário foi atribuído ao aplicativo';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'O ID da foto do usuário no Microsoft 365';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'Um hash SHA-256 dos bytes da foto de perfil do usuário, armazenado para detectar alterações na foto sem buscar novamente a imagem completa';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Quando a foto do usuário foi atualizada pela última vez a partir do Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue'] = 'Informações sobre a associação de usuários do Moodle a usuários do Microsoft 365';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'O nome de usuário do usuário do Moodle.';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'O nome de usuário do usuário do Microsoft 365.';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = 'Se o usuário deve ser alterado para a autenticação OpenID Connect quando a associação for feita';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'Se o registro foi processado';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'A mensagem de erro (se houver)';
$string['privacy:metadata:preference:suspendedtime'] = 'O momento em que o usuário foi suspenso pela sincronização de usuários, seja porque a conta correspondente do Microsoft Entra ID foi excluída, seja porque foi desativada.';
$string['privacy:metadata:local_o365_calsettings'] = 'Informações sobre as configurações de sincronização de calendário';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'O ID do calendário no Microsoft 365';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'O momento em que o registro foi criado.';
$string['privacy:metadata:preference:calsync_initialised'] = 'Se as escolhas de sincronização do calendário do Outlook do usuário foram inicializadas, para que não sejam ativadas automaticamente novamente.';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Painel de controle do Microsoft 365/Moodle';
$string['ucp_general_intro'] = 'Aqui você pode gerenciar sua conexão ao Microsoft 365.';
$string['ucp_calsync_availcal'] = 'Calendários do Moodle disponíveis';
$string['ucp_calsync_title'] = 'Configurações de sincronização do calendário do Outlook';
$string['ucp_calsync_desc'] = 'Os calendários marcados serão sincronizados a partir do Moodle com seu calendário do Outlook.';
$string['ucp_connection_options'] = 'Opções de conexão:';
$string['ucp_connection_desc'] = 'Aqui você pode configurar como se conecta ao Microsoft 365. Para usar os recursos do Microsoft 365, você deve estar conectado a uma conta do Microsoft 365. Isso pode ser feito conforme descrito abaixo.';
$string['ucp_connection_entraidlogin'] = 'Use suas credenciais do Microsoft 365 para fazer login no Moodle<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Em vez de inserir um nome de usuário e uma senha na página de login do Moodle, você verá na página de login uma seção com o texto "Fazer login usando sua conta em {$a}". Você clicará no link e será redirecionado ao Microsoft 365 para fazer login. Depois de fazer login com sucesso no Microsoft 365, você retornará ao Moodle e estará conectado à sua conta.';
$string['ucp_connection_entraidlogin_start'] = 'Começar a usar o Microsoft 365 para fazer login no Moodle.';
$string['ucp_connection_entraidlogin_stop'] = 'Parar de usar o Microsoft 365 para fazer login no Moodle.';
$string['ucp_connection_entraidlogin_active'] = 'Você está usando a conta do Microsoft 365 "{$a}" para fazer login no Moodle.';
$string['ucp_connection_linked'] = 'Vincule suas contas do Moodle e do Microsoft 365';
$string['ucp_connection_linked_desc'] = 'Vincular suas contas do Moodle e do Microsoft 365 permite usar os recursos do Microsoft 365 no Moodle sem alterar a forma como você faz login no Moodle. <br />Ao clicar no link abaixo, você será enviado ao Microsoft 365 para realizar um login único e depois retornará aqui. Você poderá usar todos os recursos do Microsoft 365 sem fazer nenhuma outra alteração na sua conta do Moodle - você fará login no Moodle como sempre fez.';
$string['ucp_connection_linked_active'] = 'Você está vinculado à conta do Microsoft 365 "{$a}".';
$string['ucp_connection_linked_start'] = 'Vincular sua conta do Moodle a uma conta do Microsoft 365.';
$string['ucp_connection_linked_migrate'] = 'Mudar para a conta vinculada.';
$string['ucp_connection_linked_stop'] = 'Desvincular sua conta do Moodle da conta do Microsoft 365.';
$string['ucp_connection_disconnected'] = 'Você não está conectado ao Microsoft 365.';
$string['ucp_features'] = 'Recursos do Microsoft 365';
$string['ucp_features_intro'] = 'Veja abaixo uma lista com os recursos que podem ser usados para aprimorar o Moodle com o Microsoft 365.';
$string['ucp_features_intro_notconnected'] = ' Alguns desses recursos podem ficar indisponíveis até que você se conecte ao Microsoft 365.';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Para se conectar ao Microsoft 365, você precisará entrar em contato com o administrador do site.';
$string['ucp_index_calendar_title'] = 'Configurações de sincronização do calendário do Outlook';
$string['ucp_index_calendar_desc'] = 'Aqui você pode configurar a sincronização entre seus calendários do Moodle e do Outlook. Você pode exportar eventos de calendários do Moodle para o Outlook ou adicionar eventos do Outlook ao Moodle.';
$string['ucp_index_connection_title'] = 'Configurações de conexão do Microsoft 365';
$string['ucp_index_connection_desc'] = 'Configure como você se conecta ao Microsoft 365.';
$string['ucp_index_connectionstatus_title'] = 'Status da conexão';
$string['ucp_index_connectionstatus_login'] = 'Clique aqui para fazer login.';
$string['ucp_index_connectionstatus_usinglogin'] = 'Você está usando o Microsoft 365 para fazer login no Moodle.';
$string['ucp_index_connectionstatus_usinglinked'] = 'Você está vinculado a uma conta do Microsoft 365.';
$string['ucp_index_connectionstatus_manage'] = 'Gerenciar conexão';
$string['ucp_index_connectionstatus_reconnect'] = 'Atualizar conexão';
$string['ucp_index_connectionstatus_connected'] = 'Você está conectado ao Microsoft 365';
$string['ucp_index_connectionstatus_matched'] = 'Sua conta foi associada ao usuário <small>"{$a}"</small> do Microsoft 365. Para concluir essa conexão, clique no link abaixo e faça login no Microsoft 365.';
$string['ucp_index_connectionstatus_notconnected'] = 'Você não está conectado ao Microsoft 365';
$string['ucp_notconnected'] = 'Conecte-se ao Microsoft 365 antes de acessar esta página.';
$string['ucp_status_enabled'] = 'Ativo';
$string['ucp_status_disabled'] = 'Não conectado';
$string['ucp_syncwith_title'] = 'Nome do calendário do Outlook com o qual sincronizar:';
$string['ucp_syncdir_title'] = 'Comportamento de sincronização:';
$string['ucp_syncdir_out'] = 'Do Moodle para o Outlook';
$string['ucp_syncdir_in'] = 'Do Outlook para o Moodle';
$string['ucp_syncdir_both'] = 'Atualizar tanto o Outlook quanto o Moodle';
$string['ucp_o365accountconnected'] = 'Esta conta do Microsoft 365 já está conectada a outra conta do Moodle.';

// Tasks.
$string['task_calendarsyncin'] = 'Sincronizar eventos do Microsoft 365 com o Moodle';
$string['task_coursesync'] = 'Sincronizar cursos do Moodle com o Microsoft Teams';
$string['task_coursemembershipsync'] = 'Sincronizar proprietários e membros do Microsoft Teams com os cursos do Moodle';
$string['task_groupmembershipsync'] = 'Sincronizar proprietários e membros de cursos do Moodle com grupos do Microsoft 365';
$string['task_sds_sync'] = 'Sincronizar com o SDS';
$string['task_syncusers'] = 'Sincronizar usuários do Microsoft Entra ID';
$string['task_syncusersphotostimezones'] = 'Sincronizar fotos e fusos horários de usuários do Microsoft Entra ID';
$string['task_calsyncautosubscribe'] = 'Ativar automaticamente a sincronização de calendário para usuários conectados';
$string['task_groupchannelsync'] = 'Criar canais do Teams para grupos do Moodle e sincronizar seus membros';
$string['task_groupchannelsyncgroup'] = 'Criar o canal do Teams de um grupo do Moodle e sincronizar seus membros';
$string['task_userenabledstatussync'] = 'Suspender/reativar/excluir usuários com base no status do Microsoft Entra ID';
$string['task_processmatchqueue'] = 'Processar fila de associação';
$string['task_notifysecretexpiry'] = 'Notificar o administrador do site sobre a expiração do segredo do aplicativo do Microsoft Entra ID';
$string['task_checkinvalidconfiglog'] = 'Verificar e limpar registros inválidos do log de configuração';
$string['task_usergroupmembershipsync'] = 'Sincronizar a participação de usuários em grupos de cursos com o Microsoft 365';
$string['task_processmatchqueue_err_museralreadymatched'] = 'O usuário do Moodle já está associado a um usuário do Microsoft 365.';
$string['task_processmatchqueue_err_museralreadyo365'] = 'O usuário do Moodle já está conectado ao Microsoft 365.';
$string['task_processmatchqueue_err_nomuser'] = 'Nenhum usuário do Moodle encontrado com este nome de usuário.';
$string['task_processmatchqueue_err_noo365user'] = 'Nenhum usuário do Microsoft 365 encontrado com este nome de usuário.';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'O usuário do Microsoft 365 já está associado a um usuário do Moodle.';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'O usuário do Microsoft 365 já está conectado a um usuário do Moodle.';

// Capabilities.
$string['o365:manageconnectionlink'] = 'Gerenciar vínculo de conexão';
$string['o365:manageconnectionunlink'] = 'Gerenciar desvinculação de conexão';
$string['o365:managecoursesync'] = 'Ativar ou desativar a sincronização do Teams para cursos via serviços web';
$string['o365:viewgroups'] = 'Ver links para serviços do Microsoft 365 no bloco Microsoft em cursos com a sincronização ativada';
$string['o365:managegroups'] = 'Ver links para serviços do Microsoft 365 e opções de gerenciamento no bloco Microsoft em cursos com a sincronização ativada';
$string['o365:teammember'] = 'Membro do Team';
$string['o365:teamowner'] = 'Proprietário do Team';

// Cache Stores.
$string['cachedef_groups'] = 'Armazena dados de grupos do Microsoft 365';
$string['cachedef_jwks'] = 'Armazena chaves JWKS da Microsoft';

// Web service errors.
$string['webservices_error_assignnotfound'] = 'Não foi possível encontrar o registro de tarefa do módulo recebido.';
$string['webservices_error_invalidassignment'] = 'O ID de tarefa recebido não pode ser usado com esta função de serviço web.';
$string['webservices_error_modulenotfound'] = 'Não foi possível encontrar o ID de módulo recebido.';
$string['webservices_error_sectionnotfound'] = 'Não foi possível encontrar a seção do curso.';
$string['webservices_error_couldnotsavegrade'] = 'Não foi possível salvar a nota.';

// User sync task help text.
$string['help_user_create'] = 'Ajuda sobre a criação de contas';
$string['help_user_create_help'] = 'Isso criará usuários no Moodle a partir de cada usuário do Microsoft Entra ID vinculado. Somente os usuários que ainda não têm contas no Moodle terão contas criadas. As novas contas serão configuradas com o método de autenticação OpenID Connect usando o perfil do Microsoft Entra ID e poderão usar todos os recursos de integração entre Microsoft 365 e Moodle.';
$string['help_user_update'] = 'Ajuda sobre a atualização de todas as contas';
$string['help_user_update_help'] = 'Isso atualizará todos os usuários no Moodle a partir de cada usuário do Microsoft Entra ID vinculado.';
$string['help_user_suspend'] = 'Ajuda sobre a suspensão de contas';
$string['help_user_suspend_help'] = 'Isso suspenderá usuários do Moodle se eles estiverem marcados como excluídos no Microsoft Entra ID.';
$string['help_user_delete'] = 'Ajuda sobre a exclusão de contas';
$string['help_user_delete_help'] = 'Isso excluirá usuários do Moodle se eles estiverem marcados como excluídos no Microsoft Entra ID. Isso só funcionará se a opção de suspender usuários estiver ativada. A conta do Moodle será excluída e todas as informações associadas ao usuário serão removidas do Moodle. Tenha cuidado! Observação: por padrão, a exclusão ocorre 30 dias depois que a conta foi excluída no Microsoft Entra ID, devido ao período de retenção de exclusão reversível do Entra ID (as contas podem ser restauradas durante esse período). Um atraso maior entre a suspensão e a exclusão pode ser configurado com a configuração "Atraso antes de excluir usuários suspensos".';
$string['help_user_reenable'] = 'Ajuda sobre a reativação de contas';
$string['help_user_reenable_help'] = 'Isso reativará contas suspensas do Moodle se elas forem retornadas pelo Microsoft Entra ID e tiverem permissão para fazer login. As contas que estão impedidas de fazer login (desativadas) no Microsoft Entra ID permanecerão suspensas.';
$string['help_user_disabledsyncsuspend'] = 'Ajuda sobre a suspensão de contas ao desativar';
$string['help_user_disabledsyncsuspend_help'] = 'Isso suspenderá usuários no Moodle se as contas conectadas deles no Microsoft Entra ID estiverem impedidas de fazer login (desativadas), sem alterar se eles são reativados automaticamente quando a conta do Microsoft Entra ID for ativada novamente. Use a opção "Reativar contas no Moodle quando reativadas no Microsoft Entra ID" abaixo para controlar isso separadamente.';
$string['help_user_groupsyncsuspend'] = 'Ajuda sobre a suspensão de contas fora do grupo de sincronização';
$string['help_user_groupsyncsuspend_help'] = 'Isso suspenderá usuários no Moodle se eles ainda estiverem ativos no Microsoft Entra ID, mas não forem membros nem proprietários do grupo configurado na configuração "Filtro de grupo da sincronização de usuários". A verificação considera apenas a participação atual: ela também suspende usuários sincronizados existentes que nunca estiveram no grupo, e não apenas os que saíram dele; portanto, revise o seu grupo antes de ativar esta opção. Esta opção só está disponível quando um filtro de grupo da sincronização de usuários está configurado. Para evitar suspensões em massa, nada é suspenso se o grupo estiver vazio ou se seus membros não puderem ser recuperados. Os usuários suspensos não são reativados enquanto não estiverem no grupo.';
$string['help_user_disabledsyncreenable'] = 'Ajuda sobre a reativação de contas ao ativar';
$string['help_user_disabledsyncreenable_help'] = 'Isso removerá a suspensão de usuários suspensos no Moodle se as contas conectadas deles no Microsoft Entra ID tiverem novamente permissão para fazer login (ativadas).';
$string['help_user_suspendnolink'] = 'Ajuda sobre a suspensão de contas sem vínculo com a Microsoft';
$string['help_user_suspendnolink_help'] = 'Normalmente, as opções de suspensão/desativação acima só agem em contas que têm um registro de objeto do Microsoft Entra ID armazenado (criado quando a conta foi sincronizada ou conectada). Algumas contas do OpenID Connect não têm esse registro - por exemplo, elas se conectaram antes de a API do Microsoft Graph ser configurada, ou o registro foi removido por uma desconexão ou por uma ação de "limpar usuários associados". Esta opção faz com que a tarefa de status também verifique essas contas, comparando o nome de usuário do Moodle com o valor da declaração de nome de usuário de vinculação configurada no Entra ID.

As contas associadas que estão ausentes do Entra ID, ou desativadas nele, são <strong>apenas suspensas</strong>: nunca são excluídas (sem um ID de objeto armazenado, o período de retenção de exclusão reversível do Entra ID não pode ser verificado) e nunca são reativadas automaticamente. As contas de convidado são ignoradas.

Esta opção só funciona quando a declaração de nome de usuário de vinculação do OpenID Connect está definida como um campo específico que pode ser consultado no Entra ID - "upn", "oid", "email" ou "samaccountname". Com "auto" (em que a declaração efetiva é escolhida a cada login e pode variar entre usuários) ou qualquer outra declaração, o nome de usuário do Moodle não pode ser associado de forma confiável a uma única conta, e esta opção não faz nada.

Revise os usuários suspensos após a primeira execução: uma conta alterada manualmente para este método de autenticação que nunca foi um usuário real do Entra ID será suspensa por esta opção.';
$string['help_user_match'] = 'Ajuda sobre a associação de contas';
$string['help_user_match_help'] = 'Isso analisará cada usuário do Microsoft Entra ID vinculado e tentará associá-lo a um usuário do Moodle. Essa associação é baseada no UPN do Microsoft Entra ID e no nome de usuário do Moodle. As correspondências não diferenciam letras maiúsculas de minúsculas e ignoram a parte de domínio do UPN do Microsoft Entra ID. Por exemplo, "BoB.SmiTh" no Moodle corresponderia a "bob.smith@example.onmicrosoft.com". Os usuários associados terão suas contas do Moodle e do Microsoft Entra ID conectadas e poderão usar todos os recursos de integração entre o Microsoft 365 e o Moodle. O método de autenticação do usuário não será alterado, a menos que a configuração abaixo esteja ativada.';
$string['help_user_matchswitchauth'] = 'Ajuda sobre a alteração de contas associadas';
$string['help_user_matchswitchauth_help'] = 'Isso exige que a configuração "Associar usuários pré-existentes do Moodle" acima esteja ativada. Quando um usuário é associado, a ativação desta configuração alterará o método de autenticação dele para OpenID Connect. Assim, ele poderá fazer login no Moodle com as credenciais do Microsoft 365. Observação: se você quiser usar esta configuração, certifique-se de que o plugin de autenticação OpenID Connect esteja ativado. Aviso: se um nome de usuário do Moodle corresponder apenas à parte do UPN do Microsoft Entra ID anterior ao "@" (e não ao UPN completo), a configuração avançada "Tamanho mínimo de nome de usuário inexato para alternar para o Microsoft 365" pode impedir que o método de autenticação seja alterado para usuários com nomes de usuário curtos.';
$string['help_user_appassign'] = 'Ajuda sobre a atribuição de usuários ao aplicativo';
$string['help_user_appassign_help'] = 'Isso fará com que todas as contas do Microsoft Entra ID com contas correspondentes no Moodle sejam atribuídas ao aplicativo do Microsoft Entra ID criado para esta instalação do Moodle, caso ainda não estejam atribuídas.';
$string['help_user_photosync'] = 'Ajuda sobre a sincronização de fotos de perfil do Microsoft 365 (cron)';
$string['help_user_photosync_help'] = 'Isso fará com que as fotos de perfil do Moodle de todos os usuários sejam sincronizadas com as fotos de perfil do Microsoft 365.';
$string['help_user_photosynconlogin'] = 'Ajuda sobre a sincronização de fotos de perfil do Microsoft 365 (login)';
$string['help_user_photosynconlogin_help'] = 'Isso fará com que a foto de perfil do Moodle de um usuário seja sincronizada com a foto de perfil do Microsoft 365 quando esse usuário fizer login. Observe que isso exige que o usuário visite uma página que contenha o bloco Microsoft no Moodle.';
$string['help_user_nodelta'] = 'Ajuda sobre a execução de uma sincronização completa';
$string['help_user_nodelta_help'] = 'Por padrão, a sincronização de usuários sincroniza apenas as alterações do Microsoft Entra ID desde a última execução da sincronização. Marcar esta opção forçará uma sincronização completa de usuários a cada vez.';
$string['help_user_emailsync'] = 'Ajuda sobre a sincronização de nomes de usuário do Microsoft Entra ID com e-mails do Moodle';
$string['help_user_emailsync_help'] = 'Ativar esta opção associará nomes de usuário do Microsoft Entra ID a e-mails do Moodle, em vez do comportamento padrão, que associa nomes de usuário do Microsoft Entra ID a nomes de usuário do Moodle.';
$string['help_user_tzsync'] = 'Ajuda sobre a sincronização do fuso horário do Outlook (cron)';
$string['help_user_tzsync_help'] = 'Isso fará com que o fuso horário do Moodle de todos os usuários seja sincronizado com a preferência de fuso horário do Outlook.';
$string['help_user_tzsynconlogin'] = 'Ajuda sobre a sincronização do fuso horário do Outlook (login)';
$string['help_user_tzsynconlogin_help'] = 'Isso fará com que o fuso horário do Moodle de um usuário seja sincronizado com a preferência de fuso horário do Outlook. Observe que isso exige que o usuário visite uma página que contenha o bloco Microsoft no Moodle.';
$string['help_user_guestsync'] = 'Ajuda sobre a sincronização de usuários convidados';
$string['help_user_guestsync_help'] = 'Se ativada, os usuários convidados do Microsoft Entra ID serão sincronizados com o Moodle na tarefa de sincronização de usuários.';

// Cohort sync feature.
$string['cohortsync_title'] = 'Sincronização de coortes';
$string['cohortsync_taskname'] = 'Sincronização de coortes';
$string['cohortsync_mappingadded'] = 'Nova conexão adicionada com sucesso';
$string['cohortsync_mappingdeleted'] = 'Conexão excluída com sucesso';
$string['cohortsync_addmapping'] = 'Adicionar conexão';
$string['cohortsync_deletemapping'] = 'Excluir conexão';
$string['cohortsync_desc'] = 'Esta página permite a sincronização unidirecional de grupos do Microsoft 365 para coortes do Moodle no contexto do sistema. Adicionar uma nova conexão iniciará o processo de sincronização - os usuários do Grupo do Microsoft 365 selecionado que estão conectados à Microsoft serão adicionados à coorte do Moodle selecionada.';
$string['cohortsync_tabledesc'] = 'Conexões atuais entre Grupos do Microsoft 365 e coortes do Moodle';
$string['cohortsync_typetosearch'] = 'Digite para pesquisar um Grupo do Microsoft 365';
$string['cohortsync_typetosearch_cohort'] = 'Digite para pesquisar uma coorte do Moodle';
$string['cohortsync_emptymatchings'] = 'Nenhuma conexão encontrada';
$string['cohortsync_select_cohort'] = 'Coorte do Moodle';
$string['cohortsync_select_group'] = 'Grupo do Microsoft 365';
$string['cohortsync_tablehead_group'] = 'Grupo do Microsoft 365';
$string['cohortsync_tablehead_cohort'] = 'Coorte do Moodle';
$string['cohortsync_tablehead_actions'] = 'Ações';
$string['cohortsync_search'] = 'Pesquisar';
$string['cohortsync_load_more'] = 'Carregar mais...';
$string['cohortsync_no_groups_found'] = 'Nenhum Grupo do Microsoft 365 encontrado para "{$a}"';
$string['cohortsync_no_cohorts_found'] = 'Nenhuma coorte do Moodle encontrada para "{$a}"';
$string['cohortsync_error_no_group'] = 'Selecione um Grupo do Microsoft 365.';
$string['cohortsync_error_no_cohort'] = 'Selecione uma coorte do Moodle.';
$string['cohortsync_mappingfailed'] = 'Erro ao adicionar a conexão entre coorte e grupo. Possíveis motivos: o grupo ou a coorte não existe, o grupo já está conectado a outra coorte, o grupo já está conectado a esta coorte.';
$string['cohortsync_connectionnotfound'] = 'Solicitação inválida: conexão não encontrada.';
$string['cohortsync_connectionnotcohortsync'] = 'Solicitação inválida: tipo de conexão incompatível.';
$string['cohortsync_unifiedapierror'] = 'Erro ao obter a lista de grupos da Microsoft.';

// Course request.
$string['courserequest_teams'] = 'Microsoft Team';
$string['courserequest_teams_help'] = 'Selecione o Microsoft Team que será conectado ao curso. Os proprietários e membros existentes do Team serão inscritos no curso criado assim que a solicitação de curso for aprovada.';
$string['courserequest_emptyteams'] = 'Nenhum Microsoft Team disponível';
$string['courserequest_title'] = 'Solicitar curso a partir do Teams';
$string['courserequest_updatecourserequeststatus_taskname'] = 'Atualizar status das solicitações de curso';
$string['courserequest_customrequestnote'] = '
| Esta solicitação é feita a partir da página de solicitação de curso do Microsoft Teams e será conectada, após a aprovação, ao Team: "{$a->name}" com a URL {$a->url}.';
$string['courserequest_graphapi_disabled'] = 'A conexão com o Microsoft Teams não está disponível. Entre em contato com o administrador do site.';
$string['courserequest_invalid_team'] = 'Team inválido usado na solicitação de curso.';
$string['courserequest_duplicate'] = 'Já existe uma solicitação de curso pendente ou aprovada do mesmo Team.';

// Teams page.
$string['teams_no_course'] = 'Você não tem nenhum curso para adicionar.';
$string['tab_name'] = 'Nome da guia';
$string['sso_login'] = 'Fazer login no Microsoft 365';
$string['other_login'] = 'Fazer login manualmente';
$string['course_selector_label'] = 'Selecionar curso existente';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = 'Ação necessária: o segredo do aplicativo do Microsoft Entra ID expirou';
$string['notification_content_secret_expired'] = 'Prezado administrador do site,

O segredo do aplicativo do Microsoft Entra ID usado na sua integração entre o Moodle e o Microsoft 365 expirou.
Crie um novo segredo no Microsoft Entra ID e atualize-o na configuração da integração para restaurar a integração.';
$string['notification_subject_secret_almost_expired'] = 'Ação necessária: o segredo do aplicativo do Microsoft Entra ID expirará em breve';
$string['notification_content_secret_almost_expired'] = 'Prezado administrador do site,

O segredo do aplicativo do Microsoft Entra ID usado na sua integração entre o Moodle e o Microsoft 365 expirará em {$a}.
Crie um novo segredo no Microsoft Entra ID e atualize-o na configuração da integração para evitar a interrupção da integração.';
$string['notification_days_less_than_one_day'] = 'menos de 1 dia';
$string['notification_days_one_day'] = '1 dia';
$string['notification_days_days'] = '{$a} dias';
$string['notification_subject_invalid_secret'] = 'Ação necessária: segredo inválido do aplicativo do Microsoft Entra ID encontrado';
$string['notification_content_invalid_secret'] = 'Prezado administrador do site,

O segredo do aplicativo do Microsoft Entra ID usado na sua integração entre o Moodle e o Microsoft 365 parece ser inválido. Isso pode ser causado por ele ter expirado ou ter sido excluído.
Revise o segredo para garantir que a integração funcione como esperado.';

// Async operations.
$string['teamsasyncfailed'] = 'A operação assíncrona de criação do Team falhou: {$a}';
$string['unknownasyncstate'] = 'Estado desconhecido da operação assíncrona: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'O ID do modelo não pode estar vazio.';
$string['error_not_connected'] = 'Não conectado ao Microsoft 365. Configure primeiro a integração ao Microsoft 365.';
$string['error_graph_client_not_available'] = 'Não é possível conectar-se à API do Microsoft Graph. Verifique a configuração da sua integração ao Microsoft 365.';
$string['success_template_id_valid'] = '✓ O ID de modelo "{$a}" é válido e acessível.';
$string['error_template_id_not_found'] = '✗ O ID de modelo "{$a}" não foi encontrado. Verifique o ID do modelo no centro de administração do Teams.';
$string['error_template_validation_failed'] = '✗ Falha na validação do modelo: {$a}';
$string['error_template_validation_error'] = '✗ Ocorreu um erro ao validar o modelo. Tente novamente ou entre em contato com o administrador.';

// Role sync feature.
$string['settings_header_rolesync'] = 'Sincronização de papéis';
$string['task_rolesync'] = 'Sincronizar papéis do sistema a partir de grupos do Microsoft 365';
$string['settings_rolesync_intro'] = 'Atribui automaticamente papéis do sistema do Moodle (por exemplo, Gerente ou Criador de curso) aos usuários com base na participação em grupos do Microsoft 365. Este recurso remove apenas os papéis que ele mesmo atribuiu; papéis atribuídos manualmente nunca são alterados. Para atribuir papéis a partir de uma declaração do token de ID OIDC, o que funciona com qualquer provedor de identidade, use a <a href="{$a}">página Sincronização de papéis do plugin de autenticação OpenID Connect</a>.';
$string['settings_rolesync_groupheading'] = 'Sincronização de papéis a partir de grupos do Microsoft 365';
$string['settings_rolesync_groupheading_desc'] = 'Executada pela tarefa agendada "Sincronizar papéis do sistema a partir de grupos do Microsoft 365" (a cada 15 minutos por padrão), independentemente da sincronização de usuários. Não é executada no login, portanto uma alteração na participação em grupos entra em vigor na próxima execução da tarefa. Somente usuários já conectados ao Microsoft 365 são processados.';
$string['settings_rolesync_groupmap'] = 'Mapeamento de grupo para papel';
$string['settings_rolesync_groupmap_details'] = 'Um mapeamento por linha, no formato <code>ID do objeto do grupo=nome curto do papel</code>. Vários papéis podem ser separados por vírgulas, por exemplo <code>550e8400-e29b-41d4-a716-446655440000=manager,coursecreator</code>. Os membros e proprietários do grupo, incluindo os membros de grupos aninhados, recebem os papéis no contexto do sistema. Somente usuários conectados ao Microsoft 365 são afetados. Linhas que começam com # são ignoradas.';
$string['settings_rolesync_revoke'] = 'Remover papéis que não correspondem mais';
$string['settings_rolesync_revoke_details'] = 'Quando ativado, os papéis atribuídos anteriormente pela sincronização de papéis por grupo são removidos de um usuário na próxima execução da tarefa agendada, quando ele deixa de pertencer a um grupo mapeado. Papéis atribuídos manualmente ou de outra forma nunca são removidos.';
$string['settings_rolesync_error_format'] = 'Linha de mapeamento inválida "{$a}". Use o formato origem=nomecurto[,nomecurto].';
$string['settings_rolesync_error_group'] = 'ID de objeto de grupo inválido "{$a}". Deve ser um GUID.';
$string['settings_rolesync_error_role'] = 'Nome curto de papel desconhecido ou não suportado "{$a}". Somente papéis que podem ser atribuídos no contexto do sistema podem ser usados.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
