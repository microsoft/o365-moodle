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
 * @package auth_oidc
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment

$string['pluginname'] = 'OpenID Connect';

// Configuration pages.
$string['settings_pageheading'] = 'Configuração de {$a}';
$string['settings_page_other_settings'] = 'Outras opções';
$string['settings_page_application'] = 'IdP e autenticação';
$string['settings_page_application_wizard'] = 'Assistente de configuração do aplicativo';
$string['settings_page_binding_username_claim'] = 'Declaração de vinculação do nome de usuário';
$string['settings_page_change_binding_username_claim_tool'] = 'Ferramenta de alteração da declaração de vinculação do nome de usuário';
$string['settings_page_cleanup_oidc_tokens'] = 'Limpar tokens do OpenID Connect';
$string['settings_page_clear_user_tokens'] = 'Limpar tokens de usuário';
$string['settings_page_field_mapping'] = 'Mapeamentos de campos';
$string['heading_additional_options'] = 'Opções adicionais';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'Página de erro de estado de login';
$string['heading_stateredirect_desc'] = 'Por padrão, se um usuário demorar demais para concluir o login no provedor de identidade (por exemplo, ao aprovar uma solicitação de autenticação multifator) e o estado de login armazenado já tiver sido limpo, o Moodle exibe sua página de erro genérica. As configurações abaixo permitem estender por quanto tempo o estado de login é mantido e exibir uma mensagem mais amigável e personalizável no lugar da página de erro genérica, redirecionando automaticamente o usuário de volta à página de login.';
$string['heading_user_restrictions'] = 'Restrições de usuário';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'Integração de saída';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = 'Exibição';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'Depuração';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'Ferramentas';
$string['microsoftcloud'] = 'Nuvem da Microsoft';
$string['microsoftcloud_help'] = 'Selecione a nuvem da Microsoft à qual seu locatário do Microsoft Entra pertence. Ela se aplica aos tipos de IdP Microsoft Entra ID e Microsoft identity platform.<br/>
Selecione "Microsoft 365 operado pela 21Vianet (China)" se sua organização usa o Microsoft 365 fornecido pela 21Vianet. O serviço de login e os endpoints do Microsoft Graph dessa nuvem passam a ser usados nas solicitações feitas pelos plugins, e os valores padrão dos endpoints e do recurso abaixo a seguem. Os valores já salvos para os endpoints, o recurso e o endpoint de logout não são alterados; atualize-os caso ainda estejam definidos com os endpoints da nuvem global.';
$string['microsoftcloud_global'] = 'Microsoft 365 (global)';
$string['microsoftcloud_china'] = 'Microsoft 365 operado pela 21Vianet (China)';
$string['idptype'] = 'Tipo de provedor de identidade (IdP)';
$string['idptype_help'] = 'Atualmente, três tipos de IdP são suportados:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: Microsoft Entra ID com endpoints oauth2 v1.0, por exemplo https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: Microsoft Entra ID com endpoints oauth2 v2.0, por exemplo https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>Outro</b>: qualquer IdP que não seja da Microsoft.</li>
</ul>
As diferenças entre as opções <b>Microsoft Entra ID (v1.0)</b> e <b>Microsoft identity platform (v2.0)</b> podem ser encontradas em <a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a>.<br/>
Em particular, o aplicativo configurado pode usar <b>certificado</b> além de <b>segredo</b> para autenticação ao usar o IdP <b>Microsoft identity platform (v2.0)</b>.<br/>
Os endpoints de autorização e de token precisam ser configurados de acordo com o tipo de IdP configurado.';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'Outro';
$string['settings_application_wizard_desc'] = 'Para configurar estas definições usando um formulário guiado com instruções passo a passo e validação de entrada, use o <a href="{$a}">Assistente de configuração do aplicativo</a>.';
$string['authendpoint'] = 'Endpoint de autorização';
$string['authendpoint_help'] = 'O URI do endpoint de autorização do seu IdP a ser usado.<br/>
Observe que, se o site for configurado para permitir o acesso de usuários de outros locatários, não é possível usar um endpoint de autorização específico de um locatário.';
$string['clientid'] = 'ID do aplicativo';
$string['clientid_help'] = 'O ID do aplicativo / cliente registrado no IdP.';
$string['clientauthmethod'] = 'Método de autenticação do cliente';
$string['clientauthmethod_help'] = '<ul>
<li>O IdP de todos os tipos pode usar o método de autenticação "<b>Segredo</b>".</li>
<li>O IdP do tipo <b>Microsoft identity platform (v2.0)</b> também pode usar o método de autenticação <b>Certificado</b>.</li>
</ul>';
$string['auth_method_secret'] = 'Segredo';
$string['auth_method_certificate'] = 'Certificado';
$string['clientsecret'] = 'Segredo do cliente';
$string['clientsecret_help'] = 'Ao usar o método de autenticação <b>segredo</b>, este é o segredo do cliente no IdP. Em alguns provedores, ele também é chamado de chave.';
$string['clientprivatekey'] = 'Chave privada do certificado do cliente';
$string['clientprivatekey_help'] = 'Ao usar o método de autenticação <b>certificado</b> e a origem de certificado <b>Texto simples</b>, esta é a chave privada do certificado usado para autenticar com o IdP.';
$string['clientcert'] = 'Chave pública do certificado do cliente';
$string['clientcert_help'] = 'Ao usar o método de autenticação <b>certificado</b> e a origem de certificado <b>Texto simples</b>, esta é a chave pública, ou certificado, usada para autenticar com o IdP.';
$string['clientcertsource'] = 'Origem do certificado';
$string['clientcertsource_help'] = 'Ao usar o método de autenticação <b>certificado</b>, define de onde o certificado será obtido.
<ul>
<li>A origem <b>Texto simples</b> exige que o conteúdo do arquivo de certificado/chave privada seja informado nas configurações de área de texto seguintes.</li>
<li>A origem <b>Nome do arquivo</b> exige que os arquivos de certificado/chave privada existam em uma pasta <b>microsoft_certs</b> na pasta de dados do Moodle.</li>
</ul>';
$string['cert_source_text'] = 'Texto simples';
$string['cert_source_path'] = 'Nome do arquivo';
$string['clientprivatekeyfile'] = 'Nome do arquivo da chave privada do certificado do cliente';
$string['clientprivatekeyfile_help'] = 'Ao usar o método de autenticação <b>certificado</b> e a origem de certificado <b>Nome do arquivo</b>, este é o nome do arquivo da chave privada usada para autenticar com o IdP. O arquivo precisa estar presente em uma pasta <b>microsoft_certs</b> na pasta de dados do Moodle.';
$string['clientcertfile'] = 'Nome do arquivo da chave pública do certificado do cliente';
$string['clientcertfile_help'] = 'Ao usar o método de autenticação <b>certificado</b> e a origem de certificado <b>Nome do arquivo</b>, este é o nome do arquivo da chave pública, ou certificado, usada para autenticar com o IdP. O arquivo precisa estar presente em uma pasta <b>microsoft_certs</b> na pasta de dados do Moodle.';
$string['clientcertpassphrase'] = 'Senha da chave do certificado do cliente';
$string['clientcertpassphrase_help'] = 'Se a chave privada do certificado do cliente estiver criptografada, esta é a senha para descriptografá-la.';
$string['change_client_secret'] = 'Alterar segredo do cliente';
$string['change_client_secret_desc'] = 'Marque esta caixa para atualizar o segredo do cliente. Por segurança, os segredos existentes ficam ocultos e apenas os 2 primeiros caracteres são exibidos.';
$string['change_cert_passphrase'] = 'Alterar senha da chave do certificado';
$string['change_cert_passphrase_desc'] = 'Marque esta caixa para atualizar a senha da chave do certificado. Por segurança, as senhas existentes ficam ocultas e apenas os 2 primeiros caracteres são exibidos.';
$string['cfg_usepkce_key'] = 'Usar PKCE';
$string['cfg_usepkce_desc'] = 'Ao usar o fluxo de login <b>Código de autorização</b>, envia um "code_challenge" PKCE (RFC 7636) com o método S256 na solicitação de autorização e o "code_verifier" correspondente ao trocar o código de autorização. O Microsoft Entra ID oferece suporte a isso. Para outros provedores, ative esta opção somente se o seu provedor oferecer suporte a PKCE, pois alguns provedores rejeitam solicitações de autorização com parâmetros que não reconhecem.';
$string['cfg_domainhint_key'] = 'Dica de domínio';
$string['cfg_domainhint_desc'] = 'Ao usar o fluxo de login <b>Código de autorização</b>, passa este valor como o parâmetro "domain_hint". O "domain_hint" é usado por alguns IdPs OpenID Connect para facilitar o processo de login dos usuários. Consulte seu provedor para saber se ele oferece suporte a esse parâmetro.';
$string['cfg_forceselectaccount_key'] = 'Sempre mostrar a seleção de conta';
$string['cfg_forceselectaccount_desc'] = 'Se ativado, os usuários sempre são solicitados a escolher com qual conta fazer login, em vez de fazerem login automaticamente com a conta ativa no navegador. Útil quando os usuários têm várias contas, por exemplo, uma conta de estudante e uma de administrador.<br/>
O modo de login silencioso tem precedência: enquanto estiver ativado, a seleção de conta não é forçada durante o login silencioso.';
$string['cfg_forceredirect_key'] = 'Forçar redirecionamento';
$string['cfg_forceredirect_desc'] = 'Se ativado, ignora a página de índice de login e redireciona para a página do OpenID Connect. Pode ser contornado com o parâmetro de URL ?noredirect=1';
$string['cfg_stateexpiry_key'] = 'Expiração do estado de login (minutos)';
$string['cfg_stateexpiry_desc'] = 'Por quanto tempo um registro de estado de login é mantido antes de a tarefa agendada de limpeza removê-lo. Aumente este valor se os usuários costumam levar mais tempo que isso para concluir o login no provedor de identidade (por exemplo, devido a solicitações de autenticação multifator).';
$string['error_stateexpiry_min'] = 'A expiração do estado de login deve ser de pelo menos 1 minuto. Um valor igual ou inferior a zero faria com que os logins em andamento falhassem.';
$string['cfg_stateredirect_enabled_key'] = 'Mostrar página de erro amigável';
$string['cfg_stateredirect_enabled_desc'] = 'Se ativado, um usuário que demorar demais para concluir o login no provedor de identidade (de modo que o estado de login armazenado já tenha sido limpo) verá a mensagem personalizável abaixo e será redirecionado automaticamente de volta à página de login, em vez da página de erro genérica do Moodle.';
$string['cfg_stateredirect_message_key'] = 'Mensagem';
$string['cfg_stateredirect_message_desc'] = 'A mensagem a ser exibida ao usuário na página de erro amigável.';
$string['cfg_stateredirect_message_default'] = 'Ocorreu um problema ao fazer seu login. Isso provavelmente aconteceu porque o login demorou demais para ser concluído (por exemplo, ao aprovar uma solicitação de autenticação multifator). Você será redirecionado automaticamente para a página de login para tentar novamente.';
$string['cfg_stateredirect_delay_key'] = 'Atraso do redirecionamento (segundos)';
$string['cfg_stateredirect_delay_desc'] = 'O número de segundos durante os quais a mensagem acima é exibida antes de redirecionar automaticamente o usuário de volta à página de login.';
$string['cfg_set_pix_key'] = 'Mostrar ícone na página de login';
$string['cfg_set_pix_desc'] = 'Se ativado, exibe um ícone ao lado do nome do provedor na página de login.';
$string['cfg_icon_key'] = 'Ícone';
$string['cfg_icon_desc'] = 'Um ícone a ser exibido ao lado do nome do provedor na página de login.';
$string['cfg_iconalt_o365'] = 'Ícone do Office 365';
$string['cfg_iconalt_microsoft365'] = 'Logotipo do Microsoft 365';
$string['cfg_iconalt_openid'] = 'Ícone do OpenID';
$string['cfg_iconalt_keycloak'] = 'Ícone do Keycloak';
$string['cfg_customicon_key'] = 'Ícone personalizado';
$string['cfg_customicon_desc'] = 'Se você quiser usar seu próprio ícone, faça o upload dele aqui. Isso substituirá qualquer ícone escolhido acima. <br /><br /><b>Observações sobre o uso de ícones personalizados:</b><ul><li>O arquivo enviado não é redimensionado. Ele será exibido na página de login em um tamanho fixo de 24x24 pixels, com o navegador ajustando a escala, portanto recomendamos o upload de uma imagem quadrada para evitar distorções.</li><li>Caso você tenha feito o upload de um ícone personalizado e queira voltar a usar um dos ícones padrão, clique no ícone personalizado na caixa acima, em "Excluir", em "OK" e depois clique em "Salvar alterações" na parte inferior deste formulário. Agora o ícone padrão selecionado será exibido na página de login do Moodle.</li></ul>';
$string['cfg_debugmode_key'] = 'Registrar mensagens de depuração';
$string['cfg_debugmode_desc'] = 'Se essa configuração estiver ativada, informações que podem ajudar a identificar problemas serão registradas no log do Moodle.';
$string['cfg_silentloginmode_key'] = 'Modo de login silencioso';
$string['cfg_silentloginmode_desc'] = 'Se ativado, o Moodle tentará usar a sessão ativa de um usuário autenticado no endpoint de autorização configurado para fazer o login do usuário.<br/>
Para usar este recurso, as seguintes configurações são necessárias:
<ul>
<li><b>Forçar usuários a fazer login</b> (forcelogin) na <a href="{$a}" target="_blank">seção Políticas do site</a> está ativado.</li>
<li>A configuração <b>Forçar redirecionamento</b> (auth_oidc/forceredirect) acima está ativada.</li>
</ul>
Para evitar que o Moodle tente usar contas pessoais ou contas de outros locatários para fazer login, também é recomendável usar endpoints específicos do locatário, em vez de endpoints genéricos com caminhos como "common" ou "organizations".<br/>
<br/>
Para IdPs da Microsoft, a experiência do usuário é a seguinte:
<ul>
<li>Se nenhuma sessão de usuário ativa for encontrada, a página de login do Moodle será exibida.</li>
<li>Se apenas uma sessão de usuário ativa for encontrada e o usuário tiver acesso ao aplicativo do Entra ID (ou seja, o usuário é do mesmo locatário ou é um usuário convidado do locatário), o usuário será conectado ao Moodle automaticamente usando SSO.</li>
<li>Se apenas uma sessão de usuário ativa for encontrada, mas o usuário não tiver acesso ao aplicativo do Entra ID (por exemplo, o usuário é de outro locatário, ou o aplicativo exige atribuição de usuários e o usuário não foi atribuído), a página de login do Moodle será exibida.</li>
<li>Se houver várias sessões de usuário ativas com acesso ao aplicativo do Entra ID, uma página será exibida para que o usuário selecione a conta com a qual fazer login.</li>
</ul>';
$string['oidcresource'] = 'Recurso';
$string['oidcresource_help'] = 'O recurso do OpenID Connect para o qual a solicitação será enviada.<br/>
<b>Observação:</b> este parâmetro não é suportado no tipo de IdP <b>Microsoft identity platform (v2.0)</b>.';
$string['oidcscope'] = 'Escopo';
$string['oidcscope_help'] = 'O escopo OIDC a ser usado.';
$string['customclaims'] = 'Declarações personalizadas';
$string['customclaims_help'] = 'Lista, separada por espaços, de nomes de declarações personalizadas dos tokens do seu provedor de identidade.<br/>
<b>Importante:</b>
<ul>
<li>As declarações devem existir na configuração de token do seu IdP (por exemplo, mapeadores de protocolo do Keycloak, declarações opcionais/personalizadas do Microsoft Entra ID)</li>
<li>Se uma declaração não existir no token, o mapeamento de campos a ignorará silenciosamente, sem exibir nenhum erro</li>
<li>Os nomes de declarações diferenciam maiúsculas de minúsculas e podem conter apenas caracteres alfanuméricos, hifens e sublinhados</li>
<li>O nome de uma declaração não pode ser um nome reservado, como uma declaração padrão de JWT/OpenID Connect (por exemplo, <code>sub</code>, <code>email</code>), uma específica do Microsoft Entra ID (por exemplo, <code>oid</code>, <code>upn</code>) ou do Keycloak (por exemplo, <code>realm_access</code>, <code>resource_access</code>), ou uma opção de mapeamento de campo existente</li>
<li>A declaração <code>roles</code> (funções de aplicativo nos tokens do Microsoft Entra ID) e a declaração <code>groups</code> (IDs de grupos) são permitidas. Elas são listadas como "roles (declaração do token)" e "groups (declaração do token)" no mapeamento de campos, separadamente das opções internas "Roles" e "Groups", que mapeiam funções de diretório do Microsoft Entra e nomes de grupos do Microsoft Graph. As declarações que contêm uma lista de valores são armazenadas como uma lista separada por vírgulas</li>
<li>Exemplos: <code>employee_type badge_number costCenter custom_role</code></li>
<li>No login, as declarações personalizadas são sempre lidas do token, independentemente de o Microsoft Graph também ser usado. Durante a tarefa agendada de sincronização de usuários, não há token de usuário para leitura, portanto uma declaração personalizada só é sincronizada quando seu nome também for uma propriedade de usuário selecionável do Microsoft Graph, como um atributo de extensão de diretório (por exemplo, <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>). Uma declaração personalizada rejeitada pelo Microsoft Graph é ignorada naquela execução de sincronização, com um aviso no log da tarefa, em vez de fazer toda a sincronização falhar.</li>
</ul>';
$string['secretexpiryrecipients'] = 'Destinatários da notificação de expiração do segredo';
$string['secretexpiryrecipients_help'] = 'Uma lista, separada por vírgulas, de endereços de e-mail para os quais enviar as notificações de expiração do segredo.<br/>
Se nenhum endereço de e-mail for informado, o administrador principal do site será notificado.<br/>
Por padrão, as notificações são enviadas diariamente a partir de quatro semanas antes da expiração até que o segredo seja renovado.';
$string['cfg_showbutton_key'] = 'Mostrar botão de login';
$string['cfg_showbutton_desc'] = 'Se desativado, o botão de login do provedor não é exibido na página de login. Os usuários ainda podem se autenticar por este provedor acessando diretamente o URL de login dele.';
$string['cfg_opname_key'] = 'Nome do provedor';
$string['cfg_opname_desc'] = 'Esse é um rótulo visível para o usuário que identifica o tipo de credenciais que devem ser utilizadas pelo usuário no login. Esse rótulo é usado em todas as partes visíveis para o usuário deste plugin para a identificação do seu provedor.';
$string['cfg_redirecturi_key'] = 'URI de redirecionamento';
$string['cfg_redirecturi_desc'] = 'Esse é o URI a ser registrado como o "URI de redirecionamento". Seu provedor de identidade do OpenID Connect deve solicitá-lo ao registrar o Moodle como cliente. <br /><b>OBSERVAÇÃO:</b> é necessário inserir essa informação no seu provedor do OpenID Connect EXATAMENTE como ela é exibida aqui. Qualquer diferença impedirá que logins sejam efetuados usando o OpenID Connect.';
$string['tokenendpoint'] = 'Endpoint de token';
$string['tokenendpoint_help'] = 'O URI do endpoint de token do seu IdP a ser usado.<br/>
Observe que, se o site for configurado para permitir o acesso de usuários de outros locatários, não é possível usar um endpoint de token específico de um locatário.';
$string['cfg_userrestrictions_key'] = 'Restrições de usuário';
$string['cfg_userrestrictions_desc'] = 'Permitir o login apenas de usuários que atendam a determinadas restrições. <br /><b>Como usar as restrições de usuário: </b> <ul><li>Informe um padrão de <a href="https://en.wikipedia.org/wiki/Regular_expression">expressão regular</a> que corresponda aos nomes de usuário que você deseja permitir.</li><li>Informe um padrão por linha</li><li>Se você informar vários padrões, o usuário será permitido se corresponder a QUALQUER um dos padrões.</li><li>O caractere "/" deve ser escapado com "\\".</li><li>Se você não informar nenhuma restrição acima, todos os usuários que podem fazer login no IdP do OpenID Connect serão aceitos pelo Moodle.</li><li>Qualquer usuário que não corresponda a nenhum dos padrões informados será impedido de fazer login usando o OpenID Connect.</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'Restrições de usuário com diferenciação de maiúsculas e minúsculas';
$string['cfg_userrestrictionscasesensitive_desc'] = 'Controla se a opção "/i" da expressão regular é usada na correspondência das restrições de usuário.<br/>Se ativado, todas as verificações de restrição de usuário diferenciarão maiúsculas de minúsculas. Observe que, se estiver desativado, qualquer padrão baseado em maiúsculas e minúsculas será ignorado.';
$string['heading_dummy_email'] = 'Endereços de e-mail provisórios';
$string['heading_dummy_email_desc'] = 'O Moodle exige que toda conta de usuário tenha um endereço de e-mail, mas as contas do Microsoft Entra ID não são obrigadas a ter um. As configurações abaixo permitem que o Moodle gere um endereço provisório e não entregável para os usuários que não têm um endereço de e-mail utilizável vindo do IdP, em vez de deixar o endereço de e-mail em branco.';
$string['cfg_generatedummyemail_key'] = 'Gerar endereços de e-mail provisórios';
$string['cfg_generatedummyemail_desc'] = 'Se ativado, quando um usuário não tiver endereço de e-mail nem um nome principal de usuário utilizável no formato de e-mail vindo do IdP, o Moodle gerará um endereço de e-mail provisório para ele, usando o nome principal de usuário da Microsoft (ou o ID do objeto, se não houver nome principal de usuário) e o domínio configurado abaixo, em vez de deixar o endereço de e-mail em branco. Isso se aplica tanto quando o usuário faz login quanto quando é provisionado pela tarefa de sincronização de usuários.';
$string['cfg_dummyemaildomain_key'] = 'Domínio de e-mail provisório';
$string['cfg_dummyemaildomain_desc'] = 'O domínio a ser usado ao gerar endereços de e-mail provisórios, por exemplo "example.test". Use um domínio que não possa receber e-mails, para que os endereços gerados nunca sejam confundidos com um endereço real e entregável.';
$string['cfg_signoffintegration_key'] = 'Logout único (do Moodle para o IdP)';
$string['cfg_signoffintegration_desc'] = 'Se a opção estiver ativada, quando um usuário do Moodle conectado ao IdP configurado sair do Moodle, a integração acionará uma solicitação no endpoint de logout abaixo, tentando desconectar o usuário também do IdP.<br/>
Observe que, para a integração com o Microsoft Entra ID, o URL do site Moodle ({$a}) precisa ser adicionado como URI de redirecionamento no aplicativo do Microsoft Entra ID criado para a integração entre o Moodle e o Microsoft 365.';
$string['cfg_logoutendpoint_key'] = 'Endpoint de logout do IdP';
$string['cfg_logoutendpoint_desc'] = 'O URI do endpoint de logout do seu IdP a ser usado.';
$string['cfg_frontchannellogouturl_key'] = 'URL de logout por front-channel';
$string['cfg_frontchannellogouturl_desc'] = 'Este é o URL que o seu IdP precisa acionar ao tentar desconectar usuários do Moodle.<br/>
Para o Microsoft Entra ID / Microsoft identity platform, a configuração se chama "Front-channel logout URL" e pode ser definida no aplicativo do Microsoft Entra ID.';
$string['cfg_field_mapping_desc'] = 'Os dados do perfil do usuário podem ser mapeados do IdP do OpenID Connect para o Moodle. Os campos remotos disponíveis para mapeamento dependem muito do tipo de IdP.<br/>
<ul>
<li>Alguns campos básicos de perfil estão disponíveis nas declarações do token de acesso e do token de ID em todos os tipos de IdP.</li>
<li>Se um tipo de IdP da Microsoft estiver configurado (v1.0 ou v2.0), dados adicionais de perfil podem ser disponibilizados por meio de chamadas à API do Graph, instalando e configurando o <a href="https://moodle.org/plugins/local_o365">plugin de integração com o Microsoft 365 (local_o365)</a>.</li>
<li>Se o recurso de sincronização de perfis do SDS estiver ativado no plugin local_o365, determinados campos de perfil podem ser sincronizados do SDS para o Moodle. Isso só acontece ao executar a tarefa agendada "Sincronizar com o SDS", e não acontece ao executar a tarefa agendada "Sincronizar usuários do Microsoft Entra ID" nem quando um usuário faz login.</li>
</ul>

As declarações disponíveis nos tokens de ID e de acesso variam conforme o tipo de IdP, mas a maioria dos IdPs permite algum nível de personalização das declarações. A documentação sobre os IdPs da Microsoft está indicada abaixo:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">Declarações do token de acesso</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">Declarações do token de ID</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">Configuração de declarações opcionais</a>: observe que "Email" é uma declaração opcional no tipo de IdP Microsoft Entra ID (v1.0).</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'Limpar tokens do OpenID Connect';
$string['cfg_cleanupoidctokens_desc'] = 'Se os seus usuários estiverem com problemas para fazer login usando a conta do Microsoft 365, tente limpar os tokens do OpenID Connect. Isso remove tokens perdidos e incompletos que podem causar erros. ATENÇÃO: isso pode interromper logins em andamento, portanto é melhor fazê-lo durante um período de inatividade.';
$string['settings_section_basic'] = 'Configurações básicas';
$string['settings_section_authentication'] = 'Autenticação';
$string['settings_section_endpoints'] = 'Endpoints';
$string['settings_section_other_params'] = 'Outros parâmetros';
$string['settings_section_secret_expiry_notification'] = 'Notificação de expiração do segredo';
$string['application_updated'] = 'As configurações do aplicativo OpenID Connect foram atualizadas.';
$string['application_updated_microsoft'] = 'A configuração do aplicativo OpenID Connect foi atualizada.<br/>
<span class="warning" style="color: red;">Um administrador do Microsoft Entra ID precisará <b>Fornecer consentimento do administrador</b> e <b>Verificar configuração</b> novamente na página de configuração da integração com o Microsoft 365 se as configurações "Tipo de provedor de identidade (IdP)" ou "Método de autenticação do cliente" forem atualizadas.</span>';
$string['application_updated_microsoft_notify'] = 'A configuração do aplicativo OpenID Connect foi atualizada.<br/>
<span class="warning" style="color: red;">Um administrador do Microsoft Entra ID precisará <b>Fornecer consentimento do administrador</b> e <b>Verificar configuração</b> novamente na <a href="{$a}">página de configuração da integração com o Microsoft 365</a> se as configurações "Tipo de provedor de identidade (IdP)" ou "Método de autenticação do cliente" forem atualizadas.</span>';
$string['application_not_changed'] = 'A configuração do aplicativo OpenID Connect não foi alterada.';

$string['event_debug'] = 'Mensagem de depuração';

$string['task_cleanup_oidc_state_and_token'] = 'Limpar estado OIDC e token inválido';
$string['task_cleanup_oidc_sid'] = 'Limpar registros de SID do OIDC';

$string['errorauthdisconnectemptypassword'] = 'A senha não pode ficar em branco';
$string['errorauthdisconnectemptyusername'] = 'O nome de usuário não pode ficar em branco';
$string['errorauthdisconnectusernameexists'] = 'Esse nome de usuário já está em uso. Escolha outro nome.';
$string['errorauthdisconnectnewmethod'] = 'Usar método de login';
$string['errorauthdisconnectinvalidmethod'] = 'Método de login inválido recebido.';
$string['errorauthdisconnectifmanual'] = 'Se estiver usando o método de login manual, insira as credenciais abaixo.';
$string['errorauthgeneral'] = 'Ocorreu um problema ao fazer seu login. Entre em contato com o administrador para obter ajuda.';
$string['errorauthinvalididtoken'] = 'id_token inválido recebido.';
$string['errorauthloginfailednouser'] = 'Login inválido: você fez login como "{$a}", mas não há uma conta correspondente neste site e novas contas não podem ser criadas automaticamente. Entre em contato com o administrador do site para obter ajuda. Se você tiver mais de uma conta, selecione Continuar para fazer login com outra.';
$string['errorauthloginfaileddupemail'] = 'Login inválido: uma conta existente neste Moodle tem o mesmo endereço de e-mail da conta que você está tentando criar, e a configuração "Permitir contas diferentes com o mesmo e-mail" (allowaccountssameemail) está desativada.';
$string['errorauthmfarequired'] = 'A Microsoft exige autenticação multifator para concluir seu login, mas ela não pôde ser concluída. Tente novamente ou faça login no Microsoft 365 em uma nova sessão do navegador e conclua a solicitação de autenticação multifator.';
$string['errorauthnoauthcode'] = 'Nenhum código de autorização foi recebido do servidor de identidade. Os logs de erro podem ter mais informações.';
$string['errorauthnocredsandendpoints'] = 'Configure as credenciais do cliente e os endpoints do OpenID Connect.';
$string['errorauthnoidtoken'] = 'O id_token do OpenID Connect não foi recebido.';
$string['errorauthnoaccesstoken'] = 'Token de acesso não recebido.';
$string['errorauthunknownstate'] = 'Estado desconhecido.';
$string['errorauthuseralreadyconnected'] = 'Você já está conectado a um usuário diferente do OpenID Connect.';
$string['errorauthuserconnectedtodifferent'] = 'O usuário do OpenID Connect que realizou a autenticação já está conectado a um usuário do Moodle.';
$string['errorbadloginflow'] = 'Tipo de autenticação inválido especificado. Observação: se você recebeu esta mensagem após uma instalação ou atualização recente, limpe seu cache do Moodle.';
$string['errorjwtbadpayload'] = 'Não foi possível ler o conteúdo de JWT.';
$string['errorjwtcouldnotreadheader'] = 'Não foi possível ler o cabeçalho de JWT.';
$string['errorjwtempty'] = 'Cadeia de caracteres vazia ou inválida de JWT recebida.';
$string['errorjwtinvalidheader'] = 'Cabeçalho de JWT inválido';
$string['errorjwtmalformed'] = 'JWT malformado recebido.';
$string['errorjwtunsupportedalg'] = 'JWS Alg ou JWE não compatível';
$string['erroroidcnotenabled'] = 'O plugin de autenticação do OpenID Connect não está ativado.';
$string['errornodisconnectionauthmethod'] = 'Não é possível se desconectar, pois não há plugin de autenticação ativado ao qual retornar (o método de login anterior do usuário ou o método de login manual).';
$string['erroroidcclientinvalidendpoint'] = 'URI de endpoint inválido recebido.';
$string['erroroidcclientnocreds'] = 'Defina as credenciais de cliente com setcreds';
$string['erroroidcclientnoauthendpoint'] = 'Nenhum endpoint de autorização definido. Defina-o com $this->setendpoints';
$string['erroroidcclientnotokenendpoint'] = 'Nenhum endpoint de token definido. Defina-o com $this->setendpoints';
$string['errorrestricted'] = 'Este site tem restrições aplicadas aos usuários que podem fazer login com o OpenID Connect. Atualmente, essas restrições impedem que você conclua esta tentativa de login.';
$string['errorucpinvalidaction'] = 'Ação inválida recebida.';
$string['erroroidccall'] = 'Erro no OpenID Connect. Verifique os logs para obter mais informações.';
$string['erroroidccall_message'] = 'Erro no OpenID Connect: {$a}';
$string['errorinvalidredirect_message'] = 'O URL para o qual você está tentando ser redirecionado não existe.';
$string['errorinvalidcertificatesource'] = 'Origem de certificado inválida';
$string['error_invalid_client_authentication_method'] = 'Método de autenticação do cliente inválido';
$string['error_empty_client_secret'] = 'O segredo do cliente não pode ficar em branco ao usar o método de autenticação "segredo"';
$string['error_empty_client_private_key'] = 'A chave privada do certificado do cliente não pode ficar em branco ao usar o método de autenticação "certificado"';
$string['error_empty_client_cert'] = 'A chave pública do certificado do cliente não pode ficar em branco ao usar o método de autenticação "certificado"';
$string['error_empty_client_private_key_file'] = 'O arquivo da chave privada do certificado do cliente não pode ficar em branco ao usar o método de autenticação "certificado"';
$string['error_empty_client_cert_file'] = 'O arquivo da chave pública do certificado do cliente não pode ficar em branco ao usar o método de autenticação "certificado"';
$string['error_endpoint_mismatch_auth_endpoint'] = 'O endpoint de autorização configurado não corresponde ao tipo de IdP configurado. Para "Microsoft Entra ID (v1.0)", use um endpoint v1.0 (por exemplo, https://login.microsoftonline.com/organizations/oauth2/authorize). Para "Microsoft identity platform (v2.0)", use um endpoint v2.0 (por exemplo, https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = 'O endpoint de token configurado não corresponde ao tipo de IdP configurado. Para "Microsoft Entra ID (v1.0)", use um endpoint v1.0 (por exemplo, https://login.microsoftonline.com/organizations/oauth2/token). Para "Microsoft identity platform (v2.0)", use um endpoint v2.0 (por exemplo, https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = 'Ao usar o tipo de IdP "Microsoft identity platform (v2.0)" e o método de autenticação "Certificado", é necessário um endpoint específico do locatário (ou seja, que não seja common/organizations/consumers).';
$string['error_empty_oidcresource'] = 'O recurso não pode ficar em branco ao usar o Microsoft Entra ID (v1.0) ou outros tipos de IdP.';
$string['error_invalid_custom_claim'] = 'Nome(s) de declaração personalizada inválido(s): {$a}. Os nomes de declarações personalizadas podem conter apenas caracteres alfanuméricos, hifens e sublinhados, e não podem ser um nome de declaração reservado (por exemplo, uma declaração padrão de JWT/OpenID Connect ou uma específica do Microsoft Entra ID ou do Keycloak) nem uma opção de mapeamento de campo existente.';
$string['error_masked_secret_not_changed'] = 'Informe um novo valor ou desmarque a caixa "Alterar" para manter o valor atual.';
$string['error_secretexpiryrecipients_invalid'] = 'Os seguintes destinatários da notificação de expiração do segredo não são endereços de e-mail válidos: {$a}';
$string['auth_settings_validation_error'] = 'Foram detectadas configurações de autenticação inválidas. Os seguintes problemas de configuração precisam ser resolvidos para garantir uma autenticação bem-sucedida:';
$string['errorupnchangeisnotsupported'] = 'O UPN da sua conta Microsoft foi alterado. Entre em contato com o administrador para atualizar sua conta do Moodle.';
$string['erroruserwithusernamealreadyexists'] = 'Ocorreu um erro ao tentar renomear sua conta do Moodle. Já existe um usuário do Moodle com o novo nome de usuário. Peça ao administrador do site que resolva isso primeiro.';
$string['error_no_response_available'] = 'Nenhuma resposta disponível.';

$string['eventuserauthed'] = 'Usuário autorizado com o OpenID Connect';
$string['eventusercreated'] = 'Usuário criado com o OpenID Connect';
$string['eventuserconnected'] = 'Usuário conectado ao OpenID Connect';
$string['eventuserloggedin'] = 'Usuário com login efetuado no OpenID Connect';
$string['eventuserdisconnected'] = 'Usuário desconectado do OpenID Connect';
$string['eventuserrenameattempt'] = 'O plugin auth_oidc tentou renomear um usuário';

$string['oidc:manageconnection'] = 'Permitir a conexão e a desconexão do OpenID Connect';
$string['oidc:manageconnectionconnect'] = 'Permitir a conexão do OpenID Connect';
$string['oidc:manageconnectiondisconnect'] = 'Permitir a desconexão do OpenID Connect';

$string['privacy:metadata:auth_oidc'] = 'Autenticação OpenID Connect';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Métodos de login anteriores para desfazer conexões com o Microsoft 365';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = 'O método de login anterior';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = 'O campo de senha anterior do usuário (criptografado).';
$string['privacy:metadata:auth_oidc_token'] = 'Tokens do OpenID Connect';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'O identificador exclusivo do usuário no OIDC.';
$string['privacy:metadata:auth_oidc_token:username'] = 'O nome de usuário do usuário do Moodle';
$string['privacy:metadata:auth_oidc_token:userid'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'O nome de usuário do usuário do OIDC';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'O identificador do usuário do OIDC';
$string['privacy:metadata:auth_oidc_token:scope'] = 'O escopo do token';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'O recurso do token';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'O código de autorização do token';
$string['privacy:metadata:auth_oidc_token:token'] = 'O token';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'A expiração do token';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'O token de atualização';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'O token de ID';
$string['privacy:metadata:auth_oidc_sid'] = 'Identificadores de sessão do IdP (sid) usados para localizar os usuários do Moodle conectados quando o SLO é acionado a partir do IdP';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'O ID do usuário do Moodle';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'O identificador de sessão do IdP (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'O momento em que o mapeamento foi criado';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'O ID da sessão do Moodle ativa no momento em que o mapeamento foi criado';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'O emissor (declaração iss) do id_token a partir do qual o mapeamento foi criado';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'Aqui você pode gerenciar sua conexão ao {$a}. Se essa configuração estiver ativada, você poderá usar sua conta do {$a} para fazer login no Moodle em vez de precisar de nome de usuário e senha separados. Depois que estiver conectado, você não precisará mais se lembrar de um nome de usuário e uma senha para o Moodle, pois todos os logins serão administrados pelo {$a}.';
$string['ucp_login_start'] = 'Começar a usar o {$a} para fazer login no Moodle';
$string['ucp_login_start_desc'] = 'Essa configuração fará uma alteração na sua conta, que passará a usar o {$a} para fazer login no Moodle. Depois de ativada, você fará login usando suas credenciais do {$a}; seu nome de usuário e sua senha do Moodle não serão aceitos. Você pode desconectar sua conta quando quiser e voltar a fazer login como antes.';
$string['ucp_login_stop'] = 'Parar de usar o {$a} para fazer login no Moodle';
$string['ucp_login_stop_desc'] = 'No momento, você está usando o {$a} para fazer login no Moodle. Ao clicar em "Parar de usar o {$a} para fazer login no Moodle", você desconectará sua conta do Moodle do {$a}. Você não poderá mais fazer login no Moodle com sua conta do {$a} e precisará criar um nome de usuário e uma senha para poder fazer login diretamente no Moodle.';
$string['ucp_login_status'] = 'O login via {$a} está:';
$string['ucp_status_enabled'] = 'Ativado';
$string['ucp_status_disabled'] = 'Desativado';
$string['ucp_disconnect_title'] = 'Desconexão do {$a}';
$string['ucp_disconnect_details'] = 'Essa ação desconectará sua conta do Moodle do {$a}. Você precisará criar um nome de usuário e uma senha para fazer login no Moodle.';
$string['ucp_title'] = 'Gerenciamento do {$a}';
$string['ucp_o365accountconnected'] = 'Esta conta do Microsoft 365 já está conectada a outra conta do Moodle.';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'Limpar tokens do OpenID Connect';
$string['unmatched'] = 'Sem correspondência';
$string['delete_token'] = 'Excluir token';
$string['mismatched'] = 'Correspondência divergente';
$string['na'] = 'n/d';
$string['mismatched_details'] = 'O registro do token contém o nome de usuário "{$a->tokenusername}"; o usuário do Moodle correspondente tem o nome de usuário "{$a->moodleusername}".';
$string['delete_token_and_reference'] = 'Excluir token e referência';
$string['table_token_id'] = 'ID do registro do token';
$string['table_oidc_username'] = 'Nome de usuário do OIDC';
$string['table_oidc_unique_identifier'] = 'Identificador exclusivo do OIDC';
$string['table_token_unique_id'] = 'ID exclusivo do OIDC';
$string['table_matching_status'] = 'Status da correspondência';
$string['table_matching_details'] = 'Detalhes';
$string['table_action'] = 'Ação';
$string['token_deleted'] = 'O token foi excluído com sucesso';
$string['no_token_to_cleanup'] = 'Não há tokens do OIDC para limpar.';

$string['errorusermatched'] = 'A conta do Microsoft 365 "{$a->entraidupn}" já corresponde ao usuário do Moodle "{$a->username}". Para concluir a conexão, faça login primeiro como esse usuário do Moodle e siga as instruções no bloco Microsoft.';

// User mapping options.
$string['update_oncreate_and_onlogin'] = 'Na criação e em todo login';
$string['update_oncreate_and_onlogin_and_usersync'] = 'Na criação, em todo login e em toda execução da tarefa de sincronização de usuários';
$string['update_oncreate_and_usersync'] = 'Na criação e em toda execução da tarefa de sincronização de usuários';
$string['update_onlogin_and_usersync'] = 'Em todo login e em toda execução da tarefa de sincronização de usuários';
$string['upgradeoidcuniqidtoolong'] = 'A atualização não pode continuar: alguns registros de auth_oidc_token têm um oidcuniqid com mais de 200 caracteres, que seria truncado pelo novo tamanho da coluna. Exclua esses registros de token e execute a atualização novamente.';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(não mapeado)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'Declaração de vinculação do nome de usuário (só pode ser mapeada durante o login)';
$string['settings_fieldmap_field_city'] = 'Cidade';
$string['settings_fieldmap_field_companyName'] = 'Nome da empresa';
$string['settings_fieldmap_field_objectId'] = 'ID do objeto';
$string['settings_fieldmap_field_country'] = 'País';
$string['settings_fieldmap_field_department'] = 'Departamento';
$string['settings_fieldmap_field_displayName'] = 'Nome de exibição';
$string['settings_fieldmap_field_surname'] = 'Sobrenome';
$string['settings_fieldmap_field_faxNumber'] = 'Número de fax';
$string['settings_fieldmap_field_telephoneNumber'] = 'Número de telefone';
$string['settings_fieldmap_field_givenName'] = 'Nome';
$string['settings_fieldmap_field_jobTitle'] = 'Cargo';
$string['settings_fieldmap_field_mail'] = 'E-mail';
$string['settings_fieldmap_field_mobile'] = 'Celular';
$string['settings_fieldmap_field_postalCode'] = 'CEP';
$string['settings_fieldmap_field_preferredLanguage'] = 'Idioma';
$string['settings_fieldmap_field_state'] = 'Estado';
$string['settings_fieldmap_field_streetAddress'] = 'Endereço';
$string['settings_fieldmap_field_userPrincipalName'] = 'Nome principal de usuário';
$string['settings_fieldmap_field_employeeId'] = 'ID do funcionário';
$string['settings_fieldmap_field_employeeType'] = 'Tipo de funcionário';
$string['settings_fieldmap_field_accountEnabled'] = 'Conta ativada';
$string['settings_fieldmap_field_businessPhones'] = 'Telefone comercial';
$string['settings_fieldmap_field_mobilePhone'] = 'Telefone celular';
$string['settings_fieldmap_field_officeLocation'] = 'Escritório';
$string['settings_fieldmap_field_preferredName'] = 'Nome preferido';
$string['settings_fieldmap_field_manager'] = 'Nome do gerente';
$string['settings_fieldmap_field_manager_email'] = 'E-mail do gerente';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'Grupos';
$string['settings_fieldmap_field_roles'] = 'Funções';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (declaração do token)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'Nome da conta SAM local';
$string['settings_fieldmap_field_extensionattribute'] = 'Atributo de extensão {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'ID da escola no SDS ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'Nome da escola no SDS ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'Função escolar no SDS ("Student" ou "Teacher")';
$string['settings_fieldmap_field_sds_student_externalId'] = 'ID externo do estudante no SDS';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'Data de nascimento do estudante no SDS';
$string['settings_fieldmap_field_sds_student_grade'] = 'Série do estudante no SDS';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'Ano de formatura do estudante no SDS';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'Número do estudante no SDS';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'ID externo do professor no SDS';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'Número do professor no SDS';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'Este é um recurso avançado. Na maioria dos casos, ele deve permanecer definido como "Escolher automaticamente"; uma configuração incorreta pode afetar os registros de usuários e interromper o login único (SSO).';
$string['binding_username_auto'] = 'Escolher automaticamente';
$string['binding_username_custom'] = 'Personalizada';
$string['bindingusernameclaim'] = 'Declaração de vinculação do nome de usuário';
$string['customclaimname'] = 'Nome da declaração personalizada';
$string['customclaimname_description'] = 'Este campo é usado somente quando a configuração <b>declaração de vinculação do nome de usuário</b> está definida como <b>Personalizada</b>.';
$string['binding_username_claim_tool_link_desc'] = 'Para atualizar a declaração de vinculação do nome de usuário dos usuários existentes, use a <a href="{$a}">Ferramenta de alteração da declaração de vinculação do nome de usuário</a>.';
$string['cleanup_oidc_tokens_link_desc'] = 'Para limpar tokens obsoletos do OpenID Connect, use a ferramenta <a href="{$a}">Limpar tokens do OpenID Connect</a>.';
$string['clear_user_tokens_link_desc'] = 'Para remover os tokens armazenados de todos os usuários ou de usuários selecionados, use a ferramenta <a href="{$a}">Limpar tokens de usuário</a>.';
$string['clear_user_tokens'] = 'Limpar tokens de usuário';
$string['clear_user_tokens_desc'] = 'Remove os tokens do OpenID Connect e do Microsoft 365 armazenados para os usuários. Os usuários afetados receberão novos tokens na próxima vez que fizerem login usando o OpenID Connect ou se conectarem ao Microsoft 365. Os vínculos deles com contas do Microsoft 365 são mantidos. ATENÇÃO: isso pode interromper logins em andamento, portanto é melhor fazê-lo durante um período de inatividade.';
$string['clear_user_tokens_scope_selected'] = 'Usuários selecionados';
$string['clear_user_tokens_scope_all'] = 'Todos os usuários';
$string['clear_user_tokens_users'] = 'Usuários';
$string['clear_user_tokens_submit'] = 'Limpar tokens';
$string['clear_user_tokens_no_name'] = '(sem nome)';
$string['clear_user_tokens_no_user_selected'] = 'Selecione pelo menos um usuário.';
$string['clear_user_tokens_confirm_all'] = 'Tem certeza de que deseja limpar os tokens de todos os usuários? {$a} usuário(s) têm tokens no momento.';
$string['clear_user_tokens_confirm_selected'] = 'Tem certeza de que deseja limpar os tokens dos usuários selecionados? {$a} dos usuários selecionados têm tokens no momento.';
$string['clear_user_tokens_success'] = '{$a} registro(s) de token limpo(s).';
$string['binding_username_claim_help_ms_no_user_sync'] = 'As opções para o IdP da Microsoft sem o recurso de sincronização de usuários ativado incluem:
<ul>
<li><b>Escolher automaticamente</b>: usa a lógica atual, determinando o token pelo tipo de IdP e recorrendo a <b>sub</b> se nenhuma declaração for encontrada.</li>
<li><b>preferred_username</b>: padrão para o tipo de IdP Microsoft identity platform (v2.0). <span class="not_support_user_sync">Não oferece suporte à sincronização de usuários.</span></li>
<li><b>email</b>: alternativa para o Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: padrão para os tipos de IdP Microsoft Entra ID (v1.0) e outros.</li>
<li><b>unique_name</b>: alternativa para os tipos de IdP Microsoft Entra ID (v1.0) e outros. <span class="not_support_user_sync">Não oferece suporte à sincronização de usuários.</span></li>
<li><b>oid</b>: alternativa se nenhuma outra declaração estiver presente. Presente apenas no IdP da Microsoft.</li>
<li><b>sub</b>: alternativa se nenhuma outra declaração estiver presente. <span class="not_support_user_sync">Não oferece suporte à sincronização de usuários.</span></li>
<li><b>samaccountname</b>: declaração personalizada.</li>
<li><b>Personalizada</b>: permite que o administrador do site informe um valor personalizado. <span class="not_support_user_sync">Não oferece suporte à sincronização de usuários.</span></li>
</ul>
Observe que algumas opções não oferecem suporte à sincronização de usuários.';
$string['binding_username_claim_help_ms_with_user_sync'] = 'As opções para o IdP da Microsoft com o recurso de sincronização de usuários ativado incluem:
<ul>
<li><b>Escolher automaticamente</b>: usa a lógica atual, determinando o token pelo tipo de IdP e recorrendo a <b>sub</b> se nenhuma declaração for encontrada.</li>
<li><b>email</b>: alternativa para o Microsoft identity platform (v2.0).</li>
<li><b>upn</b>: padrão para os tipos de IdP Microsoft Entra ID (v1.0) e outros.</li>
<li><b>oid</b>: alternativa se nenhuma outra declaração estiver presente. Presente apenas no IdP da Microsoft.</li>
<li><b>samaccountname</b>: declaração personalizada.</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'As opções para IdPs que não são da Microsoft incluem:
<ul>
<li><b>Escolher automaticamente</b>: usa a lógica atual, determinando o token pelo tipo de IdP e recorrendo a <b>sub</b> se nenhuma declaração for encontrada.</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: declaração personalizada.</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = 'A configuração "Declaração de vinculação do nome de usuário" está definida como "Personalizada", o que não é suportado para o tipo de IdP configurado com a sincronização de usuários ativada. Revise as configurações da <a href="{$a}">Declaração de vinculação do nome de usuário</a>.';
$string['examplecsv'] = 'Arquivo de upload de exemplo';
$string['usernamefile'] = 'Arquivo';
$string['csvdelimiter'] = 'Separador de CSV';
$string['encoding'] = 'Codificação';
$string['rowpreviewnum'] = 'Linhas de pré-visualização';
$string['upload_usernames'] = 'Atualizar nomes de usuário de vinculação';
$string['update_stats_users_updated'] = '{$a} usuários foram atualizados';
$string['update_stats_users_errors'] = '{$a} usuários tiveram erros';
$string['update_error_incomplete_line'] = 'A linha não contém os campos obrigatórios.';
$string['update_error_user_not_found'] = 'Nenhum usuário encontrado correspondente ao nome de usuário. Será feita uma tentativa de atualizar o usuário correspondido manualmente.';
$string['update_error_user_not_oidc'] = 'O usuário não está usando o método de autenticação OpenID Connect. Será feita uma tentativa de atualizar o usuário correspondido manualmente.';
$string['update_error_invalid_new_username'] = 'O novo nome de usuário é inválido.';
$string['update_error_user_update_failed'] = 'Falha ao atualizar o usuário.';
$string['update_warning_email_match'] = 'O e-mail corresponde a um usuário existente.';
$string['update_success_username'] = 'Nome de usuário atualizado com sucesso.';
$string['update_success_token'] = 'Token atualizado com sucesso.';
$string['update_success_o365'] = 'Registro de conexão do Microsoft 365 atualizado com sucesso.';
$string['update_error_nothing_updated'] = 'Nada foi atualizado.';
$string['error_invalid_upload_file'] = 'Arquivo de upload inválido.';
$string['csvline'] = 'Linha do CSV';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">Este é um recurso avançado. O uso incorreto pode afetar os registros de usuários e interromper o login único (SSO).</p>
<p>Esta ferramenta permite que os administradores do site atualizem em massa os seguintes registros:</p>
<ul>
<li>Nomes de usuário das contas do Moodle,</li>
<li>Nomes de usuário de vinculação nos tokens de ID do OpenID Connect armazenados,</li>
<li>Registros de conexão entre contas do Moodle e da Microsoft.</li>
</ul>
<p>Ela só deve ser usada ao alterar as configurações de <b>Declaração de vinculação do nome de usuário</b>.</p>
<p>A ferramenta aceita um arquivo CSV simples com duas colunas:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: o nome de usuário atual da conta do Moodle a ser atualizada ou, se o usuário atual for correspondido manualmente, o valor atual da declaração de vinculação.</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: o valor, com diferenciação de maiúsculas e minúsculas, da nova declaração do token a ser usada como declaração de vinculação do nome de usuário. Se o usuário for correspondido automaticamente e usar o tipo de autenticação OpenID Connect, o valor em letras minúsculas será usado como nome de usuário do Moodle.</li>
</ul>
<p>Quando o arquivo for enviado, a ferramenta executará as seguintes ações:</p>
<ol>
<li>Localizar um usuário existente do Moodle com o <span class="auth_oidc_code">username</span> informado como nome de usuário ou endereço de e-mail, que use o método de autenticação OpenID Connect e, se encontrado, atualizar o nome de usuário para o valor de <span class="auth_oidc_code">new_username</span> em letras minúsculas.</li>
<li>Atualizar o registro de token do OpenID Connect.
<ul>
<li>Se um usuário for encontrado no passo 1 acima, localizar o registro de token do usuário na tabela <span class="auth_oidc_code">auth_oidc_token</span> e atualizar a coluna <span class="auth_oidc_code">username</span> para o valor de <span class="auth_oidc_code">new_username</span> em letras minúsculas e a coluna <span class="auth_oidc_code">oidcusername</span> para o mesmo valor de <span class="auth_oidc_code">new_username</span>.</li>
<li>Se nenhum registro for encontrado acima, tentar localizar na tabela <span class="auth_oidc_code">auth_oidc_token</span> um registro com a coluna <span class="auth_oidc_code">oidcusername</span> correspondente ao <span class="auth_oidc_code">username</span> antigo e atualizá-lo para <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
<li>Desde que o plugin <span class="auth_oidc_code">local_o365</span> esteja instalado, atualizar o registro de conexão do usuário.
<ul>
<li>Se um usuário for encontrado no passo 1 acima, localizar o registro de conexão do usuário na tabela <span class="auth_oidc_code">local_o365_objects</span> e atualizar a coluna <span class="auth_oidc_code">o365name</span> para o mesmo valor de <span class="auth_oidc_code">new_username</span>.</li>
<li>Se nenhum usuário for encontrado no passo 1, tentar localizar na tabela <span class="auth_oidc_code">local_o365_objects</span> um registro de usuário com a coluna <span class="auth_oidc_code">o365name</span> correspondente ao valor de <span class="auth_oidc_code">username</span> e atualizá-lo para o valor de <span class="auth_oidc_code">new_username</span>.</li>
</ul>
</li>
</ol>
<p>O arquivo de exemplo abaixo alteraria a declaração de vinculação do nome de usuário de <span class="auth_oidc_code">upn</span> ou <span class="auth_oidc_code">email</span> para <span class="auth_oidc_code">oid</span>.</p>';
$string['change_binding_username_claim_tool_result'] = 'Resultados da atualização';
$string['update_username_results'] = 'Resultados da atualização de nomes de usuário';
$string['new_username'] = 'Novo nome de usuário';

// Role sync.
$string['settings_page_role_sync'] = 'Sincronização de papéis';
$string['settings_role_sync_intro'] = 'Atribui automaticamente papéis do sistema do Moodle (por exemplo, Gerente ou Criador de curso) aos usuários com base em uma declaração (claim) do token de ID OIDC. A declaração é avaliada sempre que um usuário faz login com OIDC e funciona com qualquer provedor de identidade OIDC. Este recurso remove apenas os papéis que ele mesmo atribuiu; papéis atribuídos manualmente nunca são alterados.';
$string['settings_role_sync_claimmap'] = 'Mapeamento de valor da declaração para papel';
$string['settings_role_sync_claimmap_details'] = 'Um mapeamento por linha, no formato <code>declaração|valor=nome curto do papel</code>, por exemplo <code>roles|moodle-managers=manager</code>, ou <code>groups|ID do objeto do grupo=coursecreator</code> ao usar a declaração groups do Entra ID. Vários papéis podem ser separados por vírgulas. Linhas diferentes podem usar declarações diferentes, e o usuário recebe os papéis de todas as linhas correspondentes. Os valores são comparados sem diferenciar maiúsculas de minúsculas, e linhas que começam com # são ignoradas. As declarações devem estar presentes no token de ID emitido pelo seu provedor de identidade; no Microsoft Entra ID, configure a declaração opcional groups ou os papéis de aplicativo no registro do aplicativo. Se o Entra ID omitir a declaração groups porque o usuário pertence a grupos demais, os papéis desse usuário permanecem inalterados. Os papéis são aplicados no contexto do sistema quando o usuário faz login.';
$string['settings_role_sync_revoke'] = 'Remover papéis que não correspondem mais';
$string['settings_role_sync_revoke_details'] = 'Quando ativado, os papéis atribuídos anteriormente por este recurso são removidos de um usuário no próximo login quando a declaração não contiver mais um valor mapeado. Papéis atribuídos manualmente ou de outra forma nunca são removidos.';
$string['settings_role_sync_error_format'] = 'Linha de mapeamento inválida "{$a}". Use o formato declaração|valor=nomecurto[,nomecurto].';
$string['settings_role_sync_error_role'] = 'Nome curto de papel desconhecido ou não suportado "{$a}". Somente papéis que podem ser atribuídos no contexto do sistema podem ser usados.';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
