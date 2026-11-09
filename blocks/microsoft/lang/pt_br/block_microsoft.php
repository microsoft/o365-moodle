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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = 'Entre em contato com o administrador para obter mais informações.';
$string['error_nomoodlenotebook'] = 'Não foi possível encontrar o seu bloco de anotações do Moodle.';
$string['error_urlrequiredwhenenabled'] = 'Esta URL deve ser configurada, pois a opção "Mostrar" acima está ativada.';
$string['linkonedrive'] = 'Meu OneDrive';
$string['linkonenote'] = 'Meu bloco de anotações do OneNote';
$string['linksways'] = 'Meus Sways';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (clássico)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'Meu e-mail';
$string['linkonenote_unavailable'] = 'OneNote indisponível';
$string['linksharepoint'] = 'Site do SharePoint do curso';
$string['linkoutlook'] = 'Configurações de sincronização do Calendário do Outlook';
$string['linkprefs'] = 'Editar configurações';
$string['linkconnection'] = 'Configurações de conexão do Microsoft 365';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = 'Adicionar um novo bloco Microsoft';
$string['microsoft:myaddinstance'] = 'Adicionar um novo bloco Microsoft à página Meu Moodle';
// Do not change this value. It is the title of the notebook in the user's OneNote account and is used to find that notebook,
// so changing it makes existing notebooks unrecognisable and creates duplicate notebooks.
$string['notebookname'] = 'Bloco de anotações do Moodle';
$string['workonthis'] = 'Trabalhar nisso';
$string['o365matched_title'] = 'Você está <span style="color: #960">quase</span> conectado ao Microsoft 365';
$string['o365matched_desc'] = 'Você foi associado ao usuário do Microsoft 365 <b>"{$a}"</b>';
$string['o365matched_complete_authreq'] = 'Para concluir a conexão, clique no link abaixo e faça login nesta conta do Microsoft 365.';
$string['o365connected'] = '{$a->firstname}, você está atualmente <span class="notifysuccess">conectado</span> ao Microsoft 365';
$string['notconnected'] = 'Você <span class="notifyproblem">não está conectado</span> a nenhum serviço da Microsoft.';
$string['course_connected_to_team'] = 'O curso está <span class="notifysuccess">conectado</span> a um <b>Team</b>.';
$string['course_connected_to_team_pending'] = 'O curso está configurado para ser conectado a um <b>Team</b>, mas a criação do Team está <span class="notifyproblem">pendente</span>.';
$string['course_connected_to_group_pending'] = 'O curso está configurado para ser conectado a um <b>Team</b>, mas a criação do grupo está <span class="notifyproblem">pendente</span>.';
$string['course_not_connected'] = 'O curso <span class="notifyproblem">não está conectado</span> a nenhum serviço da Microsoft.';
$string['cachedef_onenotenotebook'] = 'Armazena o bloco de anotações do OneNote.';
$string['logintoo365'] = 'Fazer login no Microsoft 365';
$string['connecttoo365'] = 'Conectar ao Microsoft 365';
$string['install_office'] = 'Instalar o Office';

// Microsoft 365 and Viva apps.
$string['linkword'] = 'Word';
$string['linkexcel'] = 'Excel';
$string['linkpowerpoint'] = 'PowerPoint';
$string['linkvivaengage'] = 'Viva Engage';
$string['linkvivaamplify'] = 'Viva Amplify';
$string['linkvivaconnections'] = 'Viva Connections';
$string['linkvivaglint'] = 'Viva Glint';
$string['linkvivagoals'] = 'Viva Goals';
$string['linkvivainsights'] = 'Viva Insights';
$string['linkvivalearning'] = 'Viva Learning';
$string['linkvivapulse'] = 'Viva Pulse';
$string['linklinkedin'] = 'LinkedIn';

// Configuration settings.
$string['settings_showemail'] = 'Mostrar "Meu e-mail"';
$string['settings_showemail_desc'] = 'Ativa ou desativa o link "Meu e-mail" no bloco.';
$string['settings_showmydelve'] = 'Mostrar "Meu Delve"';
$string['settings_showmydelve_desc'] = 'Ativa ou desativa o link "Meu Delve" no bloco.';
$string['settings_showmyforms'] = 'Mostrar "Meu Forms"';
$string['settings_showmyforms_desc'] = 'Ativa ou desativa o link "Meu Forms" no bloco.';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = 'Mostrar "Instalar o Office"';
$string['settings_showo365download_desc'] = 'Ativa ou desativa o link "Instalar o Office" no bloco.';
$string['settings_showsways'] = 'Mostrar "Meus Sways"';
$string['settings_showsways_desc'] = 'Ativa ou desativa o link "Meus Sways" no bloco.';
$string['settings_showmsstream'] = 'Mostrar "Microsoft Stream (no SharePoint)"';
$string['settings_showmsstream_desc'] = 'Ativa ou desativa o link "Microsoft Stream (no SharePoint)" no bloco.';
$string['settings_showmsstreamclassic'] = 'Mostrar "Microsoft Stream (clássico)"';
$string['settings_showmsstreamclassic_desc'] = 'Ativa ou desativa o link "Microsoft Stream (clássico)" no bloco.';
$string['settings_showmsteams'] = 'Mostrar "Microsoft Teams"';
$string['settings_showmsteams_desc'] = 'Ativa ou desativa o link "Microsoft Teams" no bloco.';
$string['settings_showonedrive'] = 'Mostrar "Meu OneDrive"';
$string['settings_showonedrive_desc'] = 'Ativa ou desativa o link "Meu OneDrive" no bloco.';
$string['settings_showonenotenotebook'] = 'Mostrar "Meu bloco de anotações do OneNote"';
$string['settings_showonenotenotebook_desc'] = 'Ativa ou desativa o link "Meu bloco de anotações do OneNote" no bloco.';
$string['settings_showoutlooksync'] = 'Mostrar "Configurações de sincronização do Calendário do Outlook"';
$string['settings_showoutlooksync_desc'] = 'Ativa ou desativa o link "Configurações de sincronização do Calendário do Outlook" no bloco.';
$string['settings_showpreferences'] = 'Mostrar "Editar configurações"';
$string['settings_showpreferences_desc'] = 'Ativa ou desativa o link "Editar configurações" no bloco.';
$string['settings_showo365connect'] = 'Mostrar "Conectar ao Microsoft 365"';
$string['settings_showo365connect_desc'] = 'Ativa ou desativa o link "Conectar ao Microsoft 365" no bloco. <br /><b>Nota:</b> Ele é exibido para usuários que não estão conectados ao Microsoft 365 e os leva à página que permite configurar uma conexão.';
$string['settings_showmanageo365conection'] = 'Mostrar "Configurações de conexão do Microsoft 365"';
$string['settings_showmanageo365conection_desc'] = 'Ativa ou desativa o link "Configurações de conexão do Microsoft 365" no bloco. <br /><b>Nota:</b> Ele é exibido para usuários conectados ao Microsoft 365 e os leva à página de gerenciamento da conexão.';
$string['settings_showcoursespsite'] = 'Mostrar "Site do SharePoint do curso"';
$string['settings_showcoursespsite_desc'] = 'Ativa ou desativa o link "Site do SharePoint do curso" no bloco. <br /><b>Nota:</b> Ele é exibido no bloco ao visualizar um curso que possui um site do SharePoint associado.';
$string['settings_showcourselinks'] = 'Mostrar links do curso';
$string['settings_showcourselinks_desc'] = 'Ativa ou desativa toda a seção do curso do bloco exibida ao visualizar um curso, incluindo o título de status do curso e todos os links do curso. <br /><b>Nota:</b> Quando desativada, as configurações individuais de links do curso abaixo são ignoradas.';
$string['settings_showcourseconfiguresync'] = 'Mostrar "Configurar sincronização do curso"';
$string['settings_showcourseconfiguresync_desc'] = 'Ativa ou desativa o link "Configurar sincronização do curso" na seção do curso do bloco.';
$string['settings_showcourseteam'] = 'Mostrar "Team"';
$string['settings_showcourseteam_desc'] = 'Ativa ou desativa o link "Team" na seção do curso do bloco.';
$string['settings_showcourseconversations'] = 'Mostrar "Conversas do Outlook"';
$string['settings_showcourseconversations_desc'] = 'Ativa ou desativa o link "Conversas do Outlook" na seção do curso do bloco.';
$string['settings_showcourseonedrive'] = 'Mostrar "Arquivos do OneDrive"';
$string['settings_showcourseonedrive_desc'] = 'Ativa ou desativa o link "Arquivos do OneDrive" na seção do curso do bloco.';
$string['settings_showcoursecalendar'] = 'Mostrar "Calendário do Outlook"';
$string['settings_showcoursecalendar_desc'] = 'Ativa ou desativa o link "Calendário do Outlook" na seção do curso do bloco.';
$string['settings_showcoursenotebook'] = 'Mostrar "Bloco de anotações da turma"';
$string['settings_showcoursenotebook_desc'] = 'Ativa ou desativa o link "Bloco de anotações da turma" na seção do curso do bloco.';
$string['settings_showcoursereset'] = 'Mostrar "Opções de reconfiguração do curso"';
$string['settings_showcoursereset_desc'] = 'Ativa ou desativa o link "Opções de reconfiguração do curso" na seção do curso do bloco.';
$string['settings_geto365link'] = 'URL de download do Instalar o Office';
$string['settings_geto365link_desc'] = 'A URL a ser usada para o link "Instalar o Office".';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = 'Mostrar "Word"';
$string['settings_showword_desc'] = 'Ativa ou desativa o link "Word" no bloco.';
$string['settings_showexcel'] = 'Mostrar "Excel"';
$string['settings_showexcel_desc'] = 'Ativa ou desativa o link "Excel" no bloco.';
$string['settings_showpowerpoint'] = 'Mostrar "PowerPoint"';
$string['settings_showpowerpoint_desc'] = 'Ativa ou desativa o link "PowerPoint" no bloco.';
$string['settings_showvivaengage'] = 'Mostrar "Viva Engage"';
$string['settings_showvivaengage_desc'] = 'Ativa ou desativa o link "Viva Engage" no bloco.';
$string['settings_showvivaamplify'] = 'Mostrar "Viva Amplify"';
$string['settings_showvivaamplify_desc'] = 'Ativa ou desativa o link "Viva Amplify" no bloco. <br /><b>Nota:</b> A URL do Viva Amplify abaixo também deve ser configurada para que o link seja exibido.';
$string['settings_vivaamplifyurl'] = 'URL do Viva Amplify';
$string['settings_vivaamplifyurl_desc'] = 'A URL da experiência do Viva Amplify da sua organização, conforme configurada pelo administrador do locatário do Microsoft 365, por exemplo, https://amplify.microsoft.com/. Somente URLs em um domínio amplify.microsoft.com ou amplify.cloud.microsoft são aceitas.';
$string['settings_showvivaconnections'] = 'Mostrar "Viva Connections"';
$string['settings_showvivaconnections_desc'] = 'Ativa ou desativa o link "Viva Connections" no bloco. <br /><b>Nota:</b> A URL do Viva Connections abaixo também deve ser configurada para que o link seja exibido.';
$string['settings_vivaconnectionsurl'] = 'URL do Viva Connections';
$string['settings_vivaconnectionsurl_desc'] = 'A URL da experiência do Viva Connections da sua organização, conforme configurada pelo administrador do locatário do Microsoft 365. Normalmente, é o seu site inicial do SharePoint, por exemplo, https://yourtenant.sharepoint.com/sites/yourhomesite. Somente URLs em um domínio *.sharepoint.com (ou equivalente de nuvem soberana) são aceitas.';
$string['settings_showvivaglint'] = 'Mostrar "Viva Glint"';
$string['settings_showvivaglint_desc'] = 'Ativa ou desativa o link "Viva Glint" no bloco.';
$string['settings_showvivagoals'] = 'Mostrar "Viva Goals"';
$string['settings_showvivagoals_desc'] = 'Ativa ou desativa o link "Viva Goals" no bloco.';
$string['settings_showvivainsights'] = 'Mostrar "Viva Insights"';
$string['settings_showvivainsights_desc'] = 'Ativa ou desativa o link "Viva Insights" no bloco.';
$string['settings_showvivalearning'] = 'Mostrar "Viva Learning"';
$string['settings_showvivalearning_desc'] = 'Ativa ou desativa o link "Viva Learning" no bloco. <br /><b>Nota:</b> A URL do Viva Learning abaixo também deve ser configurada para que o link seja exibido.';
$string['settings_vivalearningurl'] = 'URL do Viva Learning';
$string['settings_vivalearningurl_desc'] = 'A URL da experiência do Viva Learning da sua organização, conforme configurada pelo administrador do locatário do Microsoft 365, por exemplo, https://web.viva.microsoft.com/learning. Somente URLs em um domínio viva.microsoft.com ou cloud.microsoft são aceitas.';
$string['settings_showvivapulse'] = 'Mostrar "Viva Pulse"';
$string['settings_showvivapulse_desc'] = 'Ativa ou desativa o link "Viva Pulse" no bloco.';
$string['settings_showlinkedin'] = 'Mostrar "LinkedIn"';
$string['settings_showlinkedin_desc'] = 'Ativa ou desativa o link "LinkedIn" no bloco.';

$string['linkmydelve'] = 'Meu Delve';
$string['linkmyforms'] = 'Meu Forms';
$string['privacy:metadata'] = 'O bloco Microsoft apenas exibe links para vários recursos e serviços.';

// Course sync features.
$string['course_feature_team'] = 'Team';
$string['course_feature_conversations'] = 'Conversas do Outlook';
$string['course_feature_onedrive'] = 'Arquivos do OneDrive';
$string['course_feature_calendar'] = 'Calendário do Outlook';
$string['course_feature_notebook'] = 'Bloco de anotações da turma';

// Course sync settings.
$string['configure_sync'] = 'Configurar sincronização do curso';
$string['error_course_sync_not_configurable_per_course'] = 'A sincronização do curso não pode ser configurada por curso.';
$string['sync_page_heading'] = 'Sincronizar o curso {$a} com o Microsoft Teams';
$string['configure_course_sync'] = 'Configurar sincronização do curso com o Microsoft Teams';
$string['course_sync_option'] = 'Opção de sincronização';
$string['course_sync_option_disabled'] = 'Desativada';
$string['course_sync_option_enabled'] = 'Ativada';
$string['sync_setting_saved'] = 'A opção de sincronização do curso foi salva';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'Quando o curso for reconfigurado, o Team conectado ao curso será renomeado conforme configurado e arquivado. Um novo Team será criado e conectado ao curso.';
$string['course_reset_do_nothing'] = 'Quando o curso for reconfigurado, a conexão entre o curso e o Team será mantida. Todas as alterações de usuários feitas no curso serão sincronizadas com o Team.';
$string['course_reset_disconnect_only'] = 'Quando o curso for reconfigurado, o Team conectado ao curso será renomeado conforme configurado e arquivado. Nenhum novo Team será criado.';
$string['configure_reset'] = 'Escolher a ação do Microsoft Teams ao reconfigurar o curso';

// Course reset settings page.
$string['reset_page_heading'] = 'Ação de reconfiguração do curso para {$a}';
$string['configure_course_reset'] = 'Configurar a reconfiguração do curso';
$string['course_reset_option'] = 'Ação para o Team ao reconfigurar o curso';
$string['reset_option_do_nothing'] = 'Não fazer nada.<br/>O Team continuará conectado ao curso. O cancelamento da inscrição de usuários resultará na remoção da propriedade/associação do usuário no Team.';
$string['reset_option_disconnect_and_create_new'] = 'Desconectar e criar um novo Team.<br/>O Team existente conectado ao curso será renomeado conforme configurado e arquivado. Um novo Team será criado e conectado ao curso.';
$string['reset_option_disconnect_only'] = 'Apenas desconectar.<br/>O Team existente conectado ao curso será renomeado conforme configurado e arquivado. Nenhum novo Team será criado.';
$string['reset_setting_saved'] = 'A configuração de reconfiguração do curso foi salva.';
$string['error_site_course_sync_disabled'] = 'A sincronização do curso não está ativada';
$string['error_reset_setting_not_managed_per_course'] = 'A configuração da ação de reconfiguração é gerenciada centralmente pelos administradores do site.';
$string['error_connected_team_missing'] = 'O curso está configurado para ser sincronizado, mas o Team não pode ser encontrado.';
$string['error_course_sync_disabled'] = 'O curso não está configurado para ser sincronizado.';

// Course request.
$string['linkcourserequest'] = 'Solicitar curso do Teams';
$string['settings_courserequest'] = 'Solicitar curso do Teams';
$string['settings_courserequest_desc'] = 'Solicite um novo curso do Microsoft Teams. Após a aprovação, o curso será criado e conectado a um Team. Os membros do Team serão inscritos no curso.';

$string['customlinks'] = 'Links personalizados';
$string['customlink_addanother'] = 'Adicionar outro link';
$string['customlink_delete'] = 'Excluir este link';
$string['customlink_error_url'] = 'Insira uma URL válida começando com http:// ou https://';
$string['customlink_icon'] = 'Ícone';
$string['customlink_name'] = 'Nome';
$string['customlink_nochanges'] = 'Nenhum link personalizado foi inserido, portanto não há nada para salvar.';
$string['customlink_showall'] = 'Mostrar também para usuários que não estão conectados ao Microsoft 365';
$string['customlink_target'] = 'Abrir link em';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = 'Visibilidade';
$string['settings_header_general'] = 'Geral';
$string['settings_pageheading'] = 'Configuração do bloco Microsoft';
$string['settings_customlinkheading'] = 'Link {$a}';
$string['settings_customlinktarget_blank'] = 'Nova janela ou guia';
$string['settings_customlinktarget_self'] = 'Mesma janela';
$string['settings_customlinks_desc'] = 'Adicione seus próprios links (por exemplo, um chatbot interno ou um site de intranet) ao bloco. O nome, a URL e o ícone de cada link são obrigatórios. Para remover um link, marque "Excluir este link" e salve.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
