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
 * Japanese language strings.
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
$string['settings_pageheading'] = '{$a} 設定';
$string['settings_page_other_settings'] = 'その他のオプション';
$string['settings_page_application'] = 'IdPおよび認証';
$string['settings_page_application_wizard'] = 'アプリケーション設定ウィザード';
$string['settings_page_binding_username_claim'] = 'バインディングユーザ名クレーム';
$string['settings_page_change_binding_username_claim_tool'] = 'バインディングユーザ名クレーム変更ツール';
$string['settings_page_cleanup_oidc_tokens'] = 'OpenID Connectトークンをクリーンアップする';
$string['settings_page_clear_user_tokens'] = 'ユーザトークンをクリアする';
$string['settings_page_field_mapping'] = 'フィールドマッピング';
$string['heading_additional_options'] = '追加オプション';
$string['heading_additional_options_desc'] = '';
$string['heading_stateredirect'] = 'ログイン状態エラーページ';
$string['heading_stateredirect_desc'] = 'デフォルトでは、ユーザがIDプロバイダでのログイン完了に時間がかかりすぎ (例えば、多要素認証のプロンプトを承認している間など)、保存されたログイン状態がその間にクリーンアップされた場合、Moodleは汎用のエラーページを表示します。以下の設定により、ログイン状態を保持する期間を延長したり、汎用のエラーページの代わりにわかりやすいカスタマイズ可能なメッセージを表示して、ユーザを自動的にログインページへリダイレクトしたりできます。';
$string['heading_user_restrictions'] = 'ユーザ制限';
$string['heading_user_restrictions_desc'] = '';
$string['heading_sign_out'] = 'サインアウト統合';
$string['heading_sign_out_desc'] = '';
$string['heading_display'] = '表示';
$string['heading_display_desc'] = '';
$string['heading_debugging'] = 'デバッグ';
$string['heading_debugging_desc'] = '';
$string['heading_tools'] = 'ツール';
$string['microsoftcloud'] = 'Microsoftクラウド';
$string['microsoftcloud_help'] = 'あなたのMicrosoft Entraテナントが属するMicrosoftクラウドを選択してください。これはMicrosoft Entra IDおよびMicrosoft identity platformのIdPタイプに適用されます。<br/>
あなたの組織が21Vianetによって提供されるMicrosoft 365を使用している場合、「Microsoft 365 operated by 21Vianet (China)」を選択してください。その場合、プラグインが行うリクエストにはそのクラウドのサインインサービスおよびMicrosoft Graphエンドポイントが使用され、以下のエンドポイントおよびリソースのデフォルト値もそれに従います。エンドポイント、リソースおよびログアウトエンドポイントに既に保存されている値は変更されないため、グローバルクラウドのエンドポイントが設定されたままの場合は更新してください。';
$string['microsoftcloud_global'] = 'Microsoft 365 (グローバル)';
$string['microsoftcloud_china'] = 'Microsoft 365 operated by 21Vianet (China)';
$string['idptype'] = 'IDプロバイダ (IdP) タイプ';
$string['idptype_help'] = '現在、3種類のIdPがサポートされています:
<ul>
<li><b>Microsoft Entra ID (v1.0)</b>: oauth2 v1.0エンドポイントを使用するMicrosoft Entra ID。例: https://login.microsoftonline.com/organizations/oauth2/authorize.</li>
<li><b>Microsoft identity platform (v2.0)</b>: oauth2 v2.0エンドポイントを使用するMicrosoft Entra ID。例: https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize.</li>
<li><b>その他</b>: Microsoft以外の任意のIdP。</li>
</ul>
<b>Microsoft Entra ID (v1.0)</b>オプションと<b>Microsoft identity platform (v2.0)</b>オプションの違いについては、<a href="https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison">https://docs.microsoft.com/en-us/azure/active-directory/azuread-dev/azure-ad-endpoint-comparison</a> をご覧ください。<br/>
特に、<b>Microsoft identity platform (v2.0)</b> IdPを使用する場合、設定されたアプリケーションは認証に<b>シークレット</b>だけでなく<b>証明書</b>も使用できます。<br/>
認可エンドポイントおよびトークンエンドポイントは、設定されたIdPタイプに応じて設定する必要があります。';
$string['idp_type_microsoft_entra_id'] = 'Microsoft Entra ID (v1.0)';
$string['idp_type_microsoft_identity_platform'] = 'Microsoft identity platform (v2.0)';
$string['idp_type_other'] = 'その他';
$string['settings_application_wizard_desc'] = 'ステップバイステップの説明と入力検証付きのガイド付きフォームを使用してこれらを設定するには、<a href="{$a}">アプリケーション設定ウィザード</a>を使用してください。';
$string['authendpoint'] = '認可エンドポイント';
$string['authendpoint_help'] = '使用するIdPの認可エンドポイントのURIです。<br/>
他のテナントのユーザによるアクセスを許可するようサイトを設定する場合、テナント固有の認可エンドポイントは使用できないことに留意してください。';
$string['clientid'] = 'アプリケーションID';
$string['clientid_help'] = 'IdPに登録されたアプリケーション / クライアントIDです。';
$string['clientauthmethod'] = 'クライアント認証方法';
$string['clientauthmethod_help'] = '<ul>
<li>すべてのタイプのIdPで「<b>シークレット</b>」認証方法を使用できます。</li>
<li><b>Microsoft identity platform (v2.0)</b> タイプのIdPでは、さらに<b>証明書</b>認証方法を使用できます。</li>
</ul>';
$string['auth_method_secret'] = 'シークレット';
$string['auth_method_certificate'] = '証明書';
$string['clientsecret'] = 'クライアントシークレット';
$string['clientsecret_help'] = '<b>シークレット</b>認証方法を使用する場合、これはIdP上のクライアントシークレットです。プロバイダによっては「キー」とも呼ばれます。';
$string['clientprivatekey'] = 'クライアント証明書の秘密鍵';
$string['clientprivatekey_help'] = '<b>証明書</b>認証方法および<b>プレーンテキスト</b>証明書ソースを使用する場合、これはIdPでの認証に使用する証明書の秘密鍵です。';
$string['clientcert'] = 'クライアント証明書の公開鍵';
$string['clientcert_help'] = '<b>証明書</b>認証方法および<b>プレーンテキスト</b>証明書ソースを使用する場合、これはIdPでの認証に使用する公開鍵または証明書です。';
$string['clientcertsource'] = '証明書ソース';
$string['clientcertsource_help'] = '<b>証明書</b>認証方法を使用する場合、証明書の取得元を定義するために使用します。
<ul>
<li><b>プレーンテキスト</b>ソースでは、証明書/秘密鍵ファイルの内容を後続のテキストエリア設定に入力する必要があります。</li>
<li><b>ファイル名</b>ソースでは、証明書/秘密鍵ファイルがMoodleデータフォルダ内の<b>microsoft_certs</b>フォルダに存在する必要があります。</li>
</ul>';
$string['cert_source_text'] = 'プレーンテキスト';
$string['cert_source_path'] = 'ファイル名';
$string['clientprivatekeyfile'] = 'クライアント証明書の秘密鍵のファイル名';
$string['clientprivatekeyfile_help'] = '<b>証明書</b>認証方法および<b>ファイル名</b>証明書ソースを使用する場合、これはIdPでの認証に使用する秘密鍵のファイル名です。ファイルはMoodleデータフォルダ内の<b>microsoft_certs</b>フォルダに存在する必要があります。';
$string['clientcertfile'] = 'クライアント証明書の公開鍵のファイル名';
$string['clientcertfile_help'] = '<b>証明書</b>認証方法および<b>ファイル名</b>証明書ソースを使用する場合、これはIdPでの認証に使用する公開鍵または証明書のファイル名です。ファイルはMoodleデータフォルダ内の<b>microsoft_certs</b>フォルダに存在する必要があります。';
$string['clientcertpassphrase'] = 'クライアント証明書のパスフレーズ';
$string['clientcertpassphrase_help'] = 'クライアント証明書の秘密鍵が暗号化されている場合、これはそれを復号するためのパスフレーズです。';
$string['change_client_secret'] = 'クライアントシークレットを変更する';
$string['change_client_secret_desc'] = 'クライアントシークレットを更新するには、このボックスをチェックしてください。セキュリティのため、既存のシークレットはマスクされ、最初の2文字のみが表示されます。';
$string['change_cert_passphrase'] = '証明書のパスフレーズを変更する';
$string['change_cert_passphrase_desc'] = '証明書のパスフレーズを更新するには、このボックスをチェックしてください。セキュリティのため、既存のパスフレーズはマスクされ、最初の2文字のみが表示されます。';
$string['cfg_usepkce_key'] = 'PKCEを使用する';
$string['cfg_usepkce_desc'] = '<b>認可コード</b>ログインフローを使用する場合、認可リクエストでS256メソッドによるPKCE (RFC 7636) の「code_challenge」を送信し、認可コードの交換時に対応する「code_verifier」を送信します。Microsoft Entra IDはこれをサポートしています。その他のプロバイダの場合、一部のプロバイダは認識できないパラメータを含む認可リクエストを拒否するため、プロバイダがPKCEをサポートしている場合にのみ有効にしてください。';
$string['cfg_domainhint_key'] = 'ドメインヒント';
$string['cfg_domainhint_desc'] = '<b>認可コード</b>ログインフローを使用する場合、この値を「domain_hint」パラメータとして渡します。「domain_hint」は、一部のOpenID Connect IdPでユーザのログインプロセスを容易にするために使用されます。このパラメータがサポートされているかどうか、プロバイダに確認してください。';
$string['cfg_forceselectaccount_key'] = '常にアカウント選択を表示する';
$string['cfg_forceselectaccount_desc'] = '有効にした場合、ユーザはブラウザでアクティブなアカウントで自動的にサインインされるのではなく、どのアカウントでサインインするか常に選択を求められます。ユーザが複数のアカウント (例えば学生用アカウントと管理者用アカウント) を持っている場合に便利です。<br/>
サイレントログインモードが優先されます: サイレントログインモードが有効な間、サイレントにサインインする際にはアカウント選択は強制されません。';
$string['cfg_forceredirect_key'] = 'リダイレクトを強制する';
$string['cfg_forceredirect_desc'] = '有効にした場合、ログインインデックスページをスキップしてOpenID Connectページにリダイレクトします。?noredirect=1 URLパラメータで回避できます。';
$string['cfg_stateexpiry_key'] = 'ログイン状態の有効期限 (分)';
$string['cfg_stateexpiry_desc'] = 'スケジュールされたクリーンアップタスクによって削除されるまで、ログイン状態レコードが保持される期間です。ユーザがIDプロバイダでのログイン完了にこれより長くかかることが頻繁にある場合 (例えば、多要素認証のプロンプトによって)、この値を増やしてください。';
$string['error_stateexpiry_min'] = 'ログイン状態の有効期限は1分以上である必要があります。0以下の値を設定すると、現在進行中のログインが失敗します。';
$string['cfg_stateredirect_enabled_key'] = 'わかりやすいエラーページを表示する';
$string['cfg_stateredirect_enabled_desc'] = '有効にした場合、IDプロバイダでのログイン完了に時間がかかりすぎた (その結果、保存されたログイン状態がクリーンアップされた) ユーザには、Moodleの汎用エラーページの代わりに以下のカスタマイズ可能なメッセージが表示され、自動的にログインページへリダイレクトされます。';
$string['cfg_stateredirect_message_key'] = 'メッセージ';
$string['cfg_stateredirect_message_desc'] = 'わかりやすいエラーページでユーザに表示するメッセージです。';
$string['cfg_stateredirect_message_default'] = 'ログイン時に問題が発生しました。おそらく、ログインの完了に時間がかかりすぎたことが原因です (例えば、多要素認証のプロンプトを承認している間など)。再度お試しいただけるよう、自動的にログインページへリダイレクトされます。';
$string['cfg_stateredirect_delay_key'] = 'リダイレクトの遅延 (秒)';
$string['cfg_stateredirect_delay_desc'] = 'ユーザを自動的にログインページへリダイレクトする前に、上記のメッセージを表示する秒数です。';
$string['cfg_set_pix_key'] = 'ログインページにアイコンを表示する';
$string['cfg_set_pix_desc'] = '有効にした場合、ログインページでプロバイダ名の横にアイコンを表示します。';
$string['cfg_icon_key'] = 'アイコン';
$string['cfg_icon_desc'] = 'ログインページでプロバイダ名の横に表示されるアイコンです。';
$string['cfg_iconalt_o365'] = 'Office 365アイコン';
$string['cfg_iconalt_microsoft365'] = 'Microsoft 365ロゴ';
$string['cfg_iconalt_openid'] = 'OpenIDアイコン';
$string['cfg_iconalt_keycloak'] = 'Keycloakアイコン';
$string['cfg_customicon_key'] = 'カスタムアイコン';
$string['cfg_customicon_desc'] = '独自のアイコンを使用する場合は、ここにアップロードしてください。これにより、上記で選択したアイコンは上書きされます。<br /><br /><b>カスタムアイコンを使用する際の注意:</b><ul><li>アップロードされたファイルはサイズ変更されません。ログインページでは24x24ピクセルの固定サイズで表示され、ブラウザによって収まるように拡大縮小されるため、歪みを避けるために正方形の画像をアップロードすることをお勧めします。</li><li>カスタムアイコンをアップロードした後で標準のアイコンに戻す場合は、上のボックスのカスタムアイコンをクリックし、次に「削除」、「OK」をクリックし、最後にこのフォームの下部にある「変更を保存する」をクリックしてください。これにより、選択した標準アイコンがMoodleログインページに表示されます。</li></ul>';
$string['cfg_debugmode_key'] = 'デバッグメッセージを記録する';
$string['cfg_debugmode_desc'] = '有効にすると、Moodleログに情報が記録されます。これは問題を特定するのに役立つことがあります。';
$string['cfg_silentloginmode_key'] = 'サイレントログインモード';
$string['cfg_silentloginmode_desc'] = '有効にした場合、Moodleは設定された認可エンドポイントで認証済みのユーザのアクティブなセッションを使用して、ユーザのログインを試みます。<br/>
この機能を使用するには、以下の設定が必要です:
<ul>
<li><a href="{$a}" target="_blank">サイトポリシーセクション</a>の<b>ユーザにログインを強制する</b> (forcelogin) が有効になっていること。</li>
<li>上記の<b>リダイレクトを強制する</b> (auth_oidc/forceredirect) 設定が有効になっていること。</li>
</ul>
Moodleが個人アカウントや他のテナントのアカウントを使用してログインしようとすることを避けるため、「common」や「organizations」などのパスを使用する汎用エンドポイントではなく、テナント固有のエンドポイントを使用することもお勧めします。<br/>
<br/>
MicrosoftのIdPの場合、ユーザエクスペリエンスは以下のとおりです:
<ul>
<li>アクティブなユーザセッションが見つからない場合、Moodleのログインページが表示されます。</li>
<li>アクティブなユーザセッションが1つだけ見つかり、そのユーザがEntra IDアプリにアクセスできる場合 (すなわち、ユーザが同じテナントのユーザであるか、テナントのゲストユーザである場合)、ユーザはSSOを使用して自動的にMoodleにログインします。</li>
<li>アクティブなユーザセッションが1つだけ見つかったものの、そのユーザがEntra IDアプリにアクセスできない場合 (例えば、ユーザが別のテナントのユーザである場合や、アプリがユーザの割り当てを必要とし、ユーザが割り当てられていない場合)、Moodleのログインページが表示されます。</li>
<li>Entra IDアプリにアクセスできるアクティブなユーザセッションが複数ある場合、ログインに使用するアカウントをユーザが選択できるページが表示されます。</li>
</ul>';
$string['oidcresource'] = 'リソース';
$string['oidcresource_help'] = 'リクエストを送信する対象のOpenID Connectリソースです。<br/>
<b>注意:</b> このパラメータは<b>Microsoft identity platform (v2.0)</b> IdPタイプではサポートされていません。';
$string['oidcscope'] = 'スコープ';
$string['oidcscope_help'] = '使用するOIDCスコープです。';
$string['customclaims'] = 'カスタムクレーム';
$string['customclaims_help'] = 'IDプロバイダのトークンに含まれるカスタムクレーム名のスペース区切りリストです。<br/>
<b>重要:</b>
<ul>
<li>クレームはIdPのトークン設定に存在している必要があります (例: Keycloakのプロトコルマッパー、Microsoft Entra IDのオプション/カスタムクレーム)</li>
<li>クレームがトークンに存在しない場合、フィールドマッピングではそのクレームが通知なくスキップされます - エラーは表示されません</li>
<li>クレーム名では大文字と小文字が区別され、英数字、ハイフンおよびアンダースコアのみを使用できます</li>
<li>クレーム名には、標準のJWT/OpenID Connectクレーム (例: <code>sub</code>、<code>email</code>)、Microsoft Entra ID固有のクレーム (例: <code>oid</code>、<code>upn</code>)、Keycloak固有のクレーム (例: <code>realm_access</code>、<code>resource_access</code>)、または既存のフィールドマッピングオプションなどの予約名を使用できません</li>
<li><code>roles</code>クレーム (Microsoft Entra IDトークン内のアプリロール) および<code>groups</code>クレーム (グループID) は使用できます。これらはフィールドマッピングで「roles (トークンクレーム)」および「groups (トークンクレーム)」として表示され、Microsoft GraphからMicrosoft Entraのディレクトリロールおよびグループ名をマッピングする組み込みの「ロール」および「グループ」オプションとは区別されます。複数の値のリストを含むクレームは、カンマ区切りのリストとして保存されます</li>
<li>例: <code>employee_type badge_number costCenter custom_role</code></li>
<li>ログイン時、Microsoft Graphも使用されているかどうかにかかわらず、カスタムクレームは常にトークンから読み取られます。スケジュールされたユーザ同期タスクの実行中は読み取るユーザトークンが存在しないため、カスタムクレームは、その名前がたまたま選択可能なMicrosoft Graphのユーザプロパティ (ディレクトリ拡張属性など。例: <code>extension_d7b7d16e4a70ac2c5fa01ddc3d4ab596_jobCode</code>) でもある場合にのみ同期されます。Microsoft Graphによって拒否されたカスタムクレームは、同期全体を失敗させるのではなく、その同期実行ではスキップされ、タスクログに警告が記録されます。</li>
</ul>';
$string['secretexpiryrecipients'] = 'シークレット有効期限通知の受信者';
$string['secretexpiryrecipients_help'] = 'シークレット有効期限通知の送信先となるメールアドレスのカンマ区切りリストです。<br/>
メールアドレスが入力されていない場合、メインのサイト管理者に通知されます。<br/>
デフォルトでは、有効期限の4週間前からシークレットが更新されるまで、毎日通知が送信されます。';
$string['cfg_showbutton_key'] = 'ログインボタンを表示する';
$string['cfg_showbutton_desc'] = '無効にした場合、ログインページにプロバイダのログインボタンが表示されません。ユーザはこのプロバイダのログインURLに直接アクセスすることで、引き続きこのプロバイダ経由で認証できます。';
$string['cfg_opname_key'] = 'プロバイダ表示名';
$string['cfg_opname_desc'] = 'これはユーザがログインするために使用する必要がある認証情報の種類を識別するラベルで、エンドユーザに表示されます。このラベルはプロバイダを識別するために、このプラグインのユーザに表示されるすべての部分で使用されます。';
$string['cfg_redirecturi_key'] = 'リダイレクトURI';
$string['cfg_redirecturi_desc'] = 'これは「リダイレクトURI」として登録するURIです。OpenID Connectアイデンティティプロバイダは、クライアントとしてMoodleを登録するときにこれを要求します。<br /><b>注意:</b> これは、ここに表示されているとおり「正確」にOpenID Connectプロバイダに入力する必要があります。違いがあると、OpenID Connectを使用してログインできません。';
$string['tokenendpoint'] = 'トークンエンドポイント';
$string['tokenendpoint_help'] = '使用するIdPのトークンエンドポイントのURIです。<br/>
他のテナントのユーザによるアクセスを許可するようサイトを設定する場合、テナント固有のトークンエンドポイントは使用できないことに留意してください。';
$string['cfg_userrestrictions_key'] = 'ユーザ制限';
$string['cfg_userrestrictions_desc'] = '特定の制限を満たすユーザのみログインを許可します。<br /><b>ユーザ制限の使用方法: </b> <ul><li>許可するユーザのユーザ名に一致する<a href="https://en.wikipedia.org/wiki/Regular_expression">正規表現</a>パターンを入力してください。</li><li>1行に1つのパターンを入力してください。</li><li>複数のパターンを入力した場合、いずれかのパターンに一致するユーザが許可されます。</li><li>文字「/」は「\\」でエスケープする必要があります。</li><li>上記に制限を入力しない場合、OpenID Connect IdPにログインできるすべてのユーザがMoodleに受け入れられます。</li><li>入力されたパターンのいずれにも一致しないユーザは、OpenID Connectを使用してログインできなくなります。</li></ul>';
$string['cfg_userrestrictionscasesensitive_key'] = 'ユーザ制限で大文字と小文字を区別する';
$string['cfg_userrestrictionscasesensitive_desc'] = 'ユーザ制限の照合において、正規表現の「/i」オプションを使用するかどうかを制御します。<br/>有効にした場合、すべてのユーザ制限チェックで大文字と小文字が区別されます。無効にした場合、パターン内の大文字と小文字の違いは無視されることに留意してください。';
$string['heading_dummy_email'] = 'プレースホルダメールアドレス';
$string['heading_dummy_email_desc'] = 'Moodleではすべてのユーザアカウントにメールアドレスが必要ですが、Microsoft Entra IDのアカウントにはメールアドレスは必須ではありません。以下の設定により、IdPから使用可能なメールアドレスを取得できないユーザに対して、メールアドレスを空のままにする代わりに、配信不可能なプレースホルダアドレスをMoodleで生成できます。';
$string['cfg_generatedummyemail_key'] = 'プレースホルダメールアドレスを生成する';
$string['cfg_generatedummyemail_desc'] = '有効にした場合、ユーザがIdPからメールアドレスもメール形式の使用可能なユーザプリンシパル名も取得できないとき、Moodleはメールアドレスを空のままにする代わりに、ユーザのMicrosoftユーザプリンシパル名 (ユーザプリンシパル名が利用できない場合はオブジェクトID) と以下で設定したドメインを使用してプレースホルダメールアドレスを生成します。これは、ユーザがログインしたときと、ユーザ同期タスクによってユーザがプロビジョニングされたときの両方に適用されます。';
$string['cfg_dummyemaildomain_key'] = 'プレースホルダメールドメイン';
$string['cfg_dummyemaildomain_desc'] = 'プレースホルダメールアドレスを生成する際に使用するドメインです (例: 「example.test」)。生成されたアドレスが実在する配信可能なアドレスと誤認されることがないよう、メールを受信できないドメインを使用してください。';
$string['cfg_signoffintegration_key'] = 'シングルサインアウト (MoodleからIdPへ)';
$string['cfg_signoffintegration_desc'] = 'このオプションを有効にした場合、設定されたIdPに接続されたMoodleユーザがMoodleからログアウトすると、統合機能により以下のログアウトエンドポイントへのリクエストがトリガーされ、ユーザをIdPからもログオフさせようとします。<br/>
Microsoft Entra IDとの統合の場合、MoodleとMicrosoft 365の統合用に作成されたMicrosoft Entra IDアプリに、MoodleサイトのURL ({$a}) をリダイレクトURIとして追加する必要があることに留意してください。';
$string['cfg_logoutendpoint_key'] = 'IdPログアウトエンドポイント';
$string['cfg_logoutendpoint_desc'] = '使用するIdPのログアウトエンドポイントのURIです。';
$string['cfg_frontchannellogouturl_key'] = 'フロントチャネルログアウトURL';
$string['cfg_frontchannellogouturl_desc'] = 'これは、IdPがユーザをMoodleからログアウトさせようとする際にトリガーする必要があるURLです。<br/>
Microsoft Entra ID / Microsoft identity platformの場合、この設定は「Front-channel logout URL」と呼ばれ、Microsoft Entra IDアプリで設定できます。';
$string['cfg_field_mapping_desc'] = 'ユーザプロファイルデータをOpenID Connect IdPからMoodleにマッピングできます。マッピングに使用できるリモートフィールドは、IdPタイプに大きく依存します。<br/>
<ul>
<li>一部の基本的なプロファイルフィールドは、すべてのIdPタイプでアクセストークンおよびIDトークンのクレームから利用できます。</li>
<li>MicrosoftのIdPタイプ (v1.0またはv2.0) が設定されている場合、<a href="https://moodle.org/plugins/local_o365">Microsoft 365統合プラグイン (local_o365)</a> をインストールして設定することで、Graph API呼び出しを介して追加のプロファイルデータを利用できるようになります。</li>
<li>local_o365プラグインでSDSプロファイル同期機能が有効になっている場合、特定のプロファイルフィールドをSDSからMoodleに同期できます。これはスケジュールされたタスク「SDSと同期する」の実行時にのみ行われ、スケジュールされたタスク「ユーザをMicrosoft Entra IDから同期する」の実行時やユーザのログイン時には行われません。</li>
</ul>

IDトークンおよびアクセストークンから利用できるクレームはIdPタイプによって異なりますが、ほとんどのIdPではクレームをある程度カスタマイズできます。MicrosoftのIdPに関するドキュメントへのリンクは以下のとおりです:
<ul>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/access-token-claims-reference">アクセストークンのクレーム</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/id-token-claims-reference">IDトークンのクレーム</a></li>
<li><a target="_blank" href="https://learn.microsoft.com/en-us/entra/identity-platform/optional-claims-reference">オプションクレームの設定</a>: Microsoft Entra ID (v1.0) IdPタイプでは「Email」はオプションクレームであることに留意してください。</li>
</ul>';

$string['cfg_cleanupoidctokens_key'] = 'OpenID Connectトークンをクリーンアップする';
$string['cfg_cleanupoidctokens_desc'] = 'ユーザがMicrosoft 365アカウントを使用したログインで問題が発生している場合、OpenID Connectトークンのクリーンアップをお試しください。これにより、エラーの原因となる可能性のある不要なトークンや不完全なトークンが削除されます。警告: 進行中のログインが中断される可能性があるため、ダウンタイム中に実行することをお勧めします。';
$string['settings_section_basic'] = '基本設定';
$string['settings_section_authentication'] = '認証';
$string['settings_section_endpoints'] = 'エンドポイント';
$string['settings_section_other_params'] = 'その他のパラメータ';
$string['settings_section_secret_expiry_notification'] = 'シークレット有効期限通知';
$string['application_updated'] = 'OpenID Connectアプリケーション設定が更新されました。';
$string['application_updated_microsoft'] = 'OpenID Connectアプリケーション設定が更新されました。<br/>
<span class="warning" style="color: red;">「IDプロバイダ (IdP) タイプ」または「クライアント認証方法」の設定が更新された場合、Microsoft Entra IDの管理者がMicrosoft 365統合の設定ページで再度<b>管理者の同意を与える</b>および<b>設定を確認する</b>を実行する必要があります。</span>';
$string['application_updated_microsoft_notify'] = 'OpenID Connectアプリケーション設定が更新されました。<br/>
<span class="warning" style="color: red;">「IDプロバイダ (IdP) タイプ」または「クライアント認証方法」の設定が更新された場合、Microsoft Entra IDの管理者が<a href="{$a}">Microsoft 365統合の設定ページ</a>で再度<b>管理者の同意を与える</b>および<b>設定を確認する</b>を実行する必要があります。</span>';
$string['application_not_changed'] = 'OpenID Connectアプリケーション設定は変更されませんでした。';

$string['event_debug'] = 'デバッグメッセージ';

$string['task_cleanup_oidc_state_and_token'] = 'OIDCの状態および無効なトークンをクリーンアップする';
$string['task_cleanup_oidc_sid'] = 'OIDC SIDレコードをクリーンアップする';

$string['errorauthdisconnectemptypassword'] = 'パスワードは空白にできません。';
$string['errorauthdisconnectemptyusername'] = 'ユーザ名は空白にできません。';
$string['errorauthdisconnectusernameexists'] = 'このユーザ名は既に使用されています。別のユーザ名を選択してください。';
$string['errorauthdisconnectnewmethod'] = 'ログイン方法を使用する';
$string['errorauthdisconnectinvalidmethod'] = '無効なログイン方法を受信しました。';
$string['errorauthdisconnectifmanual'] = '手動によるログインを利用する場合は、以下に認証情報を入力します。';
$string['errorauthgeneral'] = 'ログイン時に問題が発生しました。サポートについては管理者にお問い合わせください。';
$string['errorauthinvalididtoken'] = '無効なid_tokenを受信しました。';
$string['errorauthloginfailednouser'] = '無効なログイン: あなたは「{$a}」としてサインインしましたが、このサイトには一致するアカウントがなく、新しいアカウントを自動的に作成することもできません。サポートについてはサイト管理者にお問い合わせください。複数のアカウントをお持ちの場合は、「続ける」を選択して別のアカウントでサインインしてください。';
$string['errorauthloginfaileddupemail'] = '無効なログイン: 作成しようとしているアカウントと同じメールアドレスを持つ既存のアカウントがこのMoodleに存在し、「同一メールのアカウントを許可する」 (allowaccountssameemail) 設定が無効になっています。';
$string['errorauthmfarequired'] = 'ログインを完了するためにMicrosoftが多要素認証を要求していますが、完了できませんでした。もう一度お試しいただくか、新しいブラウザセッションでMicrosoft 365にサインインして多要素認証のプロンプトを完了してください。';
$string['errorauthnoauthcode'] = 'IDサーバから認可コードを受信しませんでした。エラーログに詳細な情報が記録されている場合があります。';
$string['errorauthnocredsandendpoints'] = 'OpenID Connectのクライアント認証情報およびエンドポイントを設定してください。';
$string['errorauthnoidtoken'] = 'OpenID Connectのid_tokenを受信していません。';
$string['errorauthnoaccesstoken'] = 'アクセストークンを受信していません。';
$string['errorauthunknownstate'] = '不明な状態です。';
$string['errorauthuseralreadyconnected'] = '既に別のOpenID Connectユーザに接続しています。';
$string['errorauthuserconnectedtodifferent'] = '認証したOpenID Connectユーザは既にMoodleユーザに接続されています。';
$string['errorbadloginflow'] = '無効な認証タイプが指定されました。注: インストールまたはアップグレードを最近行った後にこのメッセージが表示される場合は、Moodleキャッシュをクリアしてください。';
$string['errorjwtbadpayload'] = 'JWTペイロードを読み取れませんでした。';
$string['errorjwtcouldnotreadheader'] = 'JWTヘッダを読み取れませんでした';
$string['errorjwtempty'] = '空のJWT、または文字列以外のJWTを受信しました。';
$string['errorjwtinvalidheader'] = '無効なJWTヘッダ';
$string['errorjwtmalformed'] = '無効な形式のJWTを受信しました。';
$string['errorjwtunsupportedalg'] = 'JWS AlgまたはJWEがサポートされていません';
$string['erroroidcnotenabled'] = 'OpenID Connect認証プラグインが有効になっていません。';
$string['errornodisconnectionauthmethod'] = 'フォールバックする有効な認証プラグインがないため、切断できません (ユーザの以前のログイン方法または手動ログイン方法)。';
$string['erroroidcclientinvalidendpoint'] = '無効なエンドポイントURIを受信しました。';
$string['erroroidcclientnocreds'] = 'setcredsを使用してクライアント認証情報を設定してください';
$string['erroroidcclientnoauthendpoint'] = '認可エンドポイントが設定されていません。$this->setendpointsを使用して設定してください。';
$string['erroroidcclientnotokenendpoint'] = 'トークンエンドポイントが設定されていません。$this->setendpointsを使用して設定してください。';
$string['errorrestricted'] = 'このサイトでは、OpenID Connectでログインできるユーザに制限が設けられています。現在、これらの制限によりこのログインを完了できません。';
$string['errorucpinvalidaction'] = '無効なアクションを受信しました。';
$string['erroroidccall'] = 'OpenID Connectでエラーが発生しました。詳細については、ログを確認してください。';
$string['erroroidccall_message'] = 'OpenID Connectのエラー: {$a}';
$string['errorinvalidredirect_message'] = 'リダイレクトしようとしているURLは存在しません。';
$string['errorinvalidcertificatesource'] = '無効な証明書ソース';
$string['error_invalid_client_authentication_method'] = '無効なクライアント認証方法';
$string['error_empty_client_secret'] = '「シークレット」認証方法を使用する場合、クライアントシークレットを空にすることはできません';
$string['error_empty_client_private_key'] = '「証明書」認証方法を使用する場合、クライアント証明書の秘密鍵を空にすることはできません';
$string['error_empty_client_cert'] = '「証明書」認証方法を使用する場合、クライアント証明書の公開鍵を空にすることはできません';
$string['error_empty_client_private_key_file'] = '「証明書」認証方法を使用する場合、クライアント証明書の秘密鍵ファイルを空にすることはできません';
$string['error_empty_client_cert_file'] = '「証明書」認証方法を使用する場合、クライアント証明書の公開鍵ファイルを空にすることはできません';
$string['error_endpoint_mismatch_auth_endpoint'] = '設定された認可エンドポイントが、設定されたIdPタイプと一致しません。「Microsoft Entra ID (v1.0)」の場合はv1.0エンドポイントを使用してください (例: https://login.microsoftonline.com/organizations/oauth2/authorize). 「Microsoft identity platform (v2.0)」の場合はv2.0エンドポイントを使用してください (例: https://login.microsoftonline.com/organizations/oauth2/v2.0/authorize).';
$string['error_endpoint_mismatch_token_endpoint'] = '設定されたトークンエンドポイントが、設定されたIdPタイプと一致しません。「Microsoft Entra ID (v1.0)」の場合はv1.0エンドポイントを使用してください (例: https://login.microsoftonline.com/organizations/oauth2/token). 「Microsoft identity platform (v2.0)」の場合はv2.0エンドポイントを使用してください (例: https://login.microsoftonline.com/organizations/oauth2/v2.0/token).';
$string['error_tenant_specific_endpoint_required'] = '「Microsoft identity platform (v2.0)」IdPタイプおよび「証明書」認証方法を使用する場合、テナント固有のエンドポイント (すなわち、common/organizations/consumers以外) が必要です。';
$string['error_empty_oidcresource'] = 'Microsoft Entra ID (v1.0) またはその他のタイプのIdPを使用する場合、リソースを空にすることはできません。';
$string['error_invalid_custom_claim'] = '無効なカスタムクレーム名: {$a}。カスタムクレーム名には英数字、ハイフンおよびアンダースコアのみを使用でき、予約されたクレーム名 (例: 標準のJWT/OpenID Connectクレーム、またはMicrosoft Entra IDやKeycloak固有のクレーム) や既存のフィールドマッピングオプションは使用できません。';
$string['error_masked_secret_not_changed'] = '新しい値を入力するか、現在の値を保持する場合は「変更」チェックボックスのチェックを外してください。';
$string['error_secretexpiryrecipients_invalid'] = '以下のシークレット有効期限通知の受信者は有効なメールアドレスではありません: {$a}';
$string['auth_settings_validation_error'] = '無効な認証設定が検出されました。認証を正常に行うために、以下の設定の問題を解決する必要があります:';
$string['errorupnchangeisnotsupported'] = 'あなたのMicrosoftアカウントのUPNが変更されました。Moodleアカウントを更新するには、管理者にお問い合わせください。';
$string['erroruserwithusernamealreadyexists'] = 'あなたのMoodleアカウントの名前を変更しようとしたときにエラーが発生しました。新しいユーザ名を持つMoodleユーザが既に存在します。まずこの問題を解決するよう、サイト管理者に依頼してください。';
$string['error_no_response_available'] = '利用可能なレスポンスはありません。';

$string['eventuserauthed'] = 'ユーザがOpenID Connectで認可されました';
$string['eventusercreated'] = 'ユーザをOpenID Connectで作成しました';
$string['eventuserconnected'] = 'ユーザをOpenID Connectに接続しました';
$string['eventuserloggedin'] = 'ユーザがOpenID Connectでログインしました';
$string['eventuserdisconnected'] = 'ユーザはOpenID Connectから切断されました';
$string['eventuserrenameattempt'] = 'auth_oidcプラグインがユーザ名の変更を試みました';

$string['oidc:manageconnection'] = 'OpenID Connectの接続および切断を許可する';
$string['oidc:manageconnectionconnect'] = 'OpenID Connectの接続を許可する';
$string['oidc:manageconnectiondisconnect'] = 'OpenID Connectの切断を許可する';

$string['privacy:metadata:auth_oidc'] = 'OpenID Connect認証';
$string['privacy:metadata:auth_oidc_prevlogin'] = 'Microsoft 365接続を元に戻すための以前のログイン方法';
$string['privacy:metadata:auth_oidc_prevlogin:userid'] = 'MoodleユーザのID';
$string['privacy:metadata:auth_oidc_prevlogin:method'] = '以前のログイン方法';
$string['privacy:metadata:auth_oidc_prevlogin:password'] = '以前の (暗号化された) ユーザパスワードフィールドです。';
$string['privacy:metadata:auth_oidc_token'] = 'OpenID Connectトークン';
$string['privacy:metadata:auth_oidc_token:oidcuniqid'] = 'OIDCの一意のユーザ識別子です。';
$string['privacy:metadata:auth_oidc_token:username'] = 'Moodleユーザのユーザ名';
$string['privacy:metadata:auth_oidc_token:userid'] = 'MoodleユーザのユーザID';
$string['privacy:metadata:auth_oidc_token:oidcusername'] = 'OIDCユーザのユーザ名';
$string['privacy:metadata:auth_oidc_token:useridentifier'] = 'OIDCユーザのユーザ識別子';
$string['privacy:metadata:auth_oidc_token:scope'] = 'トークンのスコープ';
$string['privacy:metadata:auth_oidc_token:tokenresource'] = 'トークンのリソース';
$string['privacy:metadata:auth_oidc_token:authcode'] = 'トークンの認可コード';
$string['privacy:metadata:auth_oidc_token:token'] = 'トークン';
$string['privacy:metadata:auth_oidc_token:expiry'] = 'トークンの有効期限';
$string['privacy:metadata:auth_oidc_token:refreshtoken'] = 'リフレッシュトークン';
$string['privacy:metadata:auth_oidc_token:idtoken'] = 'IDトークン';
$string['privacy:metadata:auth_oidc_sid'] = 'IdPからSLOがトリガーされた際に、接続されたMoodleユーザを特定するために使用されるIdPセッション識別子 (sid)';
$string['privacy:metadata:auth_oidc_sid:userid'] = 'MoodleユーザのID';
$string['privacy:metadata:auth_oidc_sid:sid'] = 'IdPセッション識別子 (sid)';
$string['privacy:metadata:auth_oidc_sid:timecreated'] = 'マッピングが作成された日時';
$string['privacy:metadata:auth_oidc_sid:sessionid'] = 'マッピングが作成された時点でアクティブだったMoodleセッションID';
$string['privacy:metadata:auth_oidc_sid:iss'] = 'マッピングの作成元となったid_tokenの発行者 (issクレーム)';

// In the following strings, $a refers to a customizable name for the identity manager. For example, this could be
// "Microsoft 365", "OpenID Connect", etc.
$string['ucp_general_intro'] = 'ここでは、{$a} への接続を管理できます。有効にした場合、個別のユーザ名とパスワードを使用する代わりに、{$a} アカウントを使用してMoodleにログインできます。接続後は、Moodleのユーザ名とパスワードを覚えておく必要がなくなります。すべてのログインは {$a} が処理します。';
$string['ucp_login_start'] = '{$a} を使用してMoodleへのログインを開始する';
$string['ucp_login_start_desc'] = 'アカウントが {$a} を使用してMoodleにログインするよう切り替わります。有効にした場合、{$a} の認証情報を使用してログインするようになります。現在のMoodleユーザ名とパスワードは機能しなくなります。いつでもアカウントの接続を解除し、通常のログイン方法に戻ることができます。';
$string['ucp_login_stop'] = '{$a} を使用したMoodleへのログインを停止する';
$string['ucp_login_stop_desc'] = '現在 {$a} を使用してMoodleにログインしています。「{$a} を使用したMoodleへのログインを停止する」をクリックすると、Moodleアカウントが {$a} から切断されます。{$a} アカウントを使用してMoodleにログインできなくなります。ユーザ名とパスワードを作成するように求められます。その後は、Moodleに直接ログインできるようになります。';
$string['ucp_login_status'] = '{$a} ログインは :';
$string['ucp_status_enabled'] = '有効';
$string['ucp_status_disabled'] = '無効';
$string['ucp_disconnect_title'] = '{$a} 切断';
$string['ucp_disconnect_details'] = 'Moodleアカウントを {$a} から切断します。Moodleにログインするには、ユーザ名とパスワードを作成する必要があります。';
$string['ucp_title'] = '{$a} 管理';
$string['ucp_o365accountconnected'] = 'このMicrosoft 365アカウントは既に別のMoodleアカウントに接続されています。';

// Clean up OIDC tokens.
$string['cleanup_oidc_tokens'] = 'OpenID Connectトークンをクリーンアップする';
$string['unmatched'] = '未照合';
$string['delete_token'] = 'トークンを削除する';
$string['mismatched'] = '不一致';
$string['na'] = 'n/a';
$string['mismatched_details'] = 'トークンレコードにはユーザ名「{$a->tokenusername}」が含まれていますが、照合されたMoodleユーザのユーザ名は「{$a->moodleusername}」です。';
$string['delete_token_and_reference'] = 'トークンおよび参照を削除する';
$string['table_token_id'] = 'トークンレコードID';
$string['table_oidc_username'] = 'OIDCユーザ名';
$string['table_oidc_unique_identifier'] = 'OIDC一意識別子';
$string['table_token_unique_id'] = 'OIDC一意ID';
$string['table_matching_status'] = '照合ステータス';
$string['table_matching_details'] = '詳細';
$string['table_action'] = '操作';
$string['token_deleted'] = 'トークンが正常に削除されました';
$string['no_token_to_cleanup'] = 'クリーンアップするOIDCトークンはありません。';

$string['errorusermatched'] = 'Microsoft 365アカウント「{$a->entraidupn}」は既にMoodleユーザ「{$a->username}」と照合されています。接続を完了するには、まずそのMoodleユーザとしてログインし、Microsoftブロックの説明に従ってください。';

// User mapping options.
$string['update_oncreate_and_onlogin'] = '作成時およびログイン時毎回';
$string['update_oncreate_and_onlogin_and_usersync'] = '作成時、ログイン時毎回、およびユーザ同期タスク実行時毎回';
$string['update_oncreate_and_usersync'] = '作成時およびユーザ同期タスク実行時毎回';
$string['update_onlogin_and_usersync'] = 'ログイン時毎回およびユーザ同期タスク実行時毎回';
$string['upgradeoidcuniqidtoolong'] = 'アップグレードを続行できません: 一部のauth_oidc_tokenレコードのoidcuniqidが200文字を超えており、新しいカラム長では切り捨てられてしまいます。これらのトークンレコードを削除して、再度アップグレードを実行してください。';

// Remote fields.
$string['settings_fieldmap_feild_not_mapped'] = '(マッピングなし)';
$string['settings_fieldmap_field_bindingusernameclaim'] = 'バインディングユーザ名クレーム (ログイン時にのみマッピング可能)';
$string['settings_fieldmap_field_city'] = '都道府県';
$string['settings_fieldmap_field_companyName'] = '会社名';
$string['settings_fieldmap_field_objectId'] = 'オブジェクトID';
$string['settings_fieldmap_field_country'] = '国';
$string['settings_fieldmap_field_department'] = '部署';
$string['settings_fieldmap_field_displayName'] = '表示名';
$string['settings_fieldmap_field_surname'] = '姓';
$string['settings_fieldmap_field_faxNumber'] = 'FAX番号';
$string['settings_fieldmap_field_telephoneNumber'] = '電話番号';
$string['settings_fieldmap_field_givenName'] = '名';
$string['settings_fieldmap_field_jobTitle'] = '役職';
$string['settings_fieldmap_field_mail'] = 'メールアドレス';
$string['settings_fieldmap_field_mobile'] = '携帯電話';
$string['settings_fieldmap_field_postalCode'] = '郵便番号';
$string['settings_fieldmap_field_preferredLanguage'] = '言語';
$string['settings_fieldmap_field_state'] = '州';
$string['settings_fieldmap_field_streetAddress'] = '住所';
$string['settings_fieldmap_field_userPrincipalName'] = 'ユーザプリンシパル名';
$string['settings_fieldmap_field_employeeId'] = '従業員ID';
$string['settings_fieldmap_field_employeeType'] = '従業員の種類';
$string['settings_fieldmap_field_accountEnabled'] = 'アカウント有効';
$string['settings_fieldmap_field_businessPhones'] = '勤務先電話';
$string['settings_fieldmap_field_mobilePhone'] = '携帯電話番号';
$string['settings_fieldmap_field_officeLocation'] = 'オフィス';
$string['settings_fieldmap_field_preferredName'] = '優先名';
$string['settings_fieldmap_field_manager'] = 'マネージャ名';
$string['settings_fieldmap_field_manager_email'] = 'マネージャのメールアドレス';
$string['settings_fieldmap_field_teams'] = 'Teams';
$string['settings_fieldmap_field_groups'] = 'グループ';
$string['settings_fieldmap_field_roles'] = 'ロール';
$string['settings_fieldmap_field_tokenclaim'] = '{$a} (トークンクレーム)';
$string['settings_fieldmap_field_onPremisesSamAccountName'] = 'オンプレミスSAMアカウント名';
$string['settings_fieldmap_field_extensionattribute'] = '拡張属性 {$a}';
$string['settings_fieldmap_field_sds_school_id'] = 'SDS学校ID ({$a})';
$string['settings_fieldmap_field_sds_school_name'] = 'SDS学校名 ({$a})';
$string['settings_fieldmap_field_sds_school_role'] = 'SDS学校ロール (「Student」または「Teacher」)';
$string['settings_fieldmap_field_sds_student_externalId'] = 'SDS学生外部ID';
$string['settings_fieldmap_field_sds_student_birthDate'] = 'SDS学生生年月日';
$string['settings_fieldmap_field_sds_student_grade'] = 'SDS学生学年';
$string['settings_fieldmap_field_sds_student_graduationYear'] = 'SDS学生卒業年';
$string['settings_fieldmap_field_sds_student_studentNumber'] = 'SDS学生番号';
$string['settings_fieldmap_field_sds_teacher_externalId'] = 'SDS教師外部ID';
$string['settings_fieldmap_field_sds_teacher_teacherNumber'] = 'SDS教師番号';

// Binding username claim options.
$string['binding_username_claim_warning'] = 'これは高度な機能です。ほとんどの場合、「自動的に選択する」のままにしておく必要があります。誤った設定はユーザレコードに影響し、シングルサインオン (SSO) を妨げる可能性があります。';
$string['binding_username_auto'] = '自動的に選択する';
$string['binding_username_custom'] = 'カスタム';
$string['bindingusernameclaim'] = 'バインディングユーザ名クレーム';
$string['customclaimname'] = 'カスタムクレーム名';
$string['customclaimname_description'] = 'このフィールドは、<b>バインディングユーザ名クレーム</b>設定が<b>カスタム</b>に設定されている場合にのみ使用されます。';
$string['binding_username_claim_tool_link_desc'] = '既存ユーザのバインディングユーザ名クレームを更新するには、<a href="{$a}">バインディングユーザ名クレーム変更ツール</a>を使用してください。';
$string['cleanup_oidc_tokens_link_desc'] = '不要になったOpenID Connectトークンをクリーンアップするには、<a href="{$a}">OpenID Connectトークンをクリーンアップする</a>ツールを使用してください。';
$string['clear_user_tokens_link_desc'] = 'すべてのユーザまたは選択したユーザの保存済みトークンを削除するには、<a href="{$a}">ユーザトークンをクリアする</a>ツールを使用してください。';
$string['clear_user_tokens'] = 'ユーザトークンをクリアする';
$string['clear_user_tokens_desc'] = 'ユーザのために保存されているOpenID ConnectおよびMicrosoft 365のトークンを削除します。対象のユーザは、次回OpenID Connectを使用してログインするか、Microsoft 365に接続したときに新しいトークンを取得します。Microsoft 365アカウントとのリンクは保持されます。警告: 進行中のログインが中断される可能性があるため、ダウンタイム中に実行することをお勧めします。';
$string['clear_user_tokens_scope_selected'] = '選択したユーザ';
$string['clear_user_tokens_scope_all'] = 'すべてのユーザ';
$string['clear_user_tokens_users'] = 'ユーザ';
$string['clear_user_tokens_submit'] = 'トークンをクリアする';
$string['clear_user_tokens_no_name'] = '(名前なし)';
$string['clear_user_tokens_no_user_selected'] = '少なくとも1人のユーザを選択してください。';
$string['clear_user_tokens_confirm_all'] = '本当にすべてのユーザのトークンをクリアしてもよろしいですか? 現在 {$a} 人のユーザがトークンを持っています。';
$string['clear_user_tokens_confirm_selected'] = '本当に選択したユーザのトークンをクリアしてもよろしいですか? 選択したユーザのうち {$a} 人が現在トークンを持っています。';
$string['clear_user_tokens_success'] = '{$a} 件のトークンレコードをクリアしました。';
$string['binding_username_claim_help_ms_no_user_sync'] = 'ユーザ同期機能が有効になっていないMicrosoft IdPのオプションは以下のとおりです:
<ul>
<li><b>自動的に選択する</b>: 現在のロジックを使用し、IdPタイプによってトークンを決定し、クレームが見つからない場合は<b>sub</b>にフォールバックします。</li>
<li><b>preferred_username</b>: Microsoft identity platform (v2.0) IdPタイプのデフォルトです。<span class="not_support_user_sync">ユーザ同期はサポートされていません。</span></li>
<li><b>email</b>: Microsoft identity platform (v2.0) のフォールバックです。</li>
<li><b>upn</b>: Microsoft Entra ID (v1.0) およびその他のIdPタイプのデフォルトです。</li>
<li><b>unique_name</b>: Microsoft Entra ID (v1.0) およびその他のIdPタイプのフォールバックです。<span class="not_support_user_sync">ユーザ同期はサポートされていません。</span></li>
<li><b>oid</b>: 他のクレームが存在しない場合のフォールバックです。Microsoft IdPにのみ存在します。</li>
<li><b>sub</b>: 他のクレームが存在しない場合のフォールバックです。<span class="not_support_user_sync">ユーザ同期はサポートされていません。</span></li>
<li><b>samaccountname</b>: カスタムクレームです。</li>
<li><b>カスタム</b>: サイト管理者がカスタム値を入力できます。<span class="not_support_user_sync">ユーザ同期はサポートされていません。</span></li>
</ul>
一部のオプションはユーザ同期をサポートしていないことに留意してください。';
$string['binding_username_claim_help_ms_with_user_sync'] = 'ユーザ同期機能が有効になっているMicrosoft IdPのオプションは以下のとおりです:
<ul>
<li><b>自動的に選択する</b>: 現在のロジックを使用し、IdPタイプによってトークンを決定し、クレームが見つからない場合は<b>sub</b>にフォールバックします。</li>
<li><b>email</b>: Microsoft identity platform (v2.0) のフォールバックです。</li>
<li><b>upn</b>: Microsoft Entra ID (v1.0) およびその他のIdPタイプのデフォルトです。</li>
<li><b>oid</b>: 他のクレームが存在しない場合のフォールバックです。Microsoft IdPにのみ存在します。</li>
<li><b>samaccountname</b>: カスタムクレームです。</li>
</ul>';
$string['binding_username_claim_help_non_ms'] = 'Microsoft以外のIdPのオプションは以下のとおりです:
<ul>
<li><b>自動的に選択する</b>: 現在のロジックを使用し、IdPタイプによってトークンを決定し、クレームが見つからない場合は<b>sub</b>にフォールバックします。</li>
<li><b>preferred_username</b></li>
<li><b>email</b></li>
<li><b>unique_name</b></li>
<li><b>sub</b></li>
<li><b>samaccountname</b></li>
<li><b>custom</b>: カスタムクレームです。</li>
</ul>';
$string['warning_binding_username_claim_custom_unsupported'] = '「バインディングユーザ名クレーム」設定が現在「カスタム」に設定されていますが、これはユーザ同期が有効な状態の設定済みIdPタイプではサポートされていません。<a href="{$a}">バインディングユーザ名クレーム</a>の設定を確認してください。';
$string['examplecsv'] = 'アップロードファイル例';
$string['usernamefile'] = 'ファイル';
$string['csvdelimiter'] = 'CSV区切り文字';
$string['encoding'] = 'エンコーディング';
$string['rowpreviewnum'] = 'プレビュー行数';
$string['upload_usernames'] = 'バインディングユーザ名を更新する';
$string['update_stats_users_updated'] = '{$a} 人のユーザが更新されました';
$string['update_stats_users_errors'] = '{$a} 人のユーザでエラーが発生しました';
$string['update_error_incomplete_line'] = 'この行には必須フィールドが含まれていません。';
$string['update_error_user_not_found'] = 'ユーザ名に一致するユーザが見つかりません。手動で照合されたユーザの更新を試みます。';
$string['update_error_user_not_oidc'] = 'このユーザはOpenID Connect認証方法を使用していません。手動で照合されたユーザの更新を試みます。';
$string['update_error_invalid_new_username'] = '新しいユーザ名が無効です。';
$string['update_error_user_update_failed'] = 'ユーザの更新に失敗しました。';
$string['update_warning_email_match'] = 'メールアドレスが既存のユーザと一致します。';
$string['update_success_username'] = 'ユーザ名が正常に更新されました。';
$string['update_success_token'] = 'トークンが正常に更新されました。';
$string['update_success_o365'] = 'Microsoft 365接続レコードが正常に更新されました。';
$string['update_error_nothing_updated'] = '何も更新されませんでした。';
$string['error_invalid_upload_file'] = '無効なアップロードファイルです。';
$string['csvline'] = 'CSV行';
$string['change_binding_username_claim_tool_description'] = '<p class="warning_header">これは高度な機能です。誤った使用はユーザレコードに影響し、シングルサインオン (SSO) を妨げる可能性があります。</p>
<p>このツールを使用すると、サイト管理者は以下のレコードを一括更新できます:</p>
<ul>
<li>Moodleアカウントのユーザ名</li>
<li>保存されたOpenID Connect IDトークン内のバインディングユーザ名</li>
<li>MoodleアカウントとMicrosoftアカウントの接続レコード</li>
</ul>
<p>このツールは、<b>バインディングユーザ名クレーム</b>設定を変更する場合にのみ使用してください。</p>
<p>このツールは、2つのカラムを持つシンプルなCSVファイルを受け付けます:</p>
<ul>
<li><b><span class="auth_oidc_code">username</span></b>: 更新するMoodleアカウントの現在のユーザ名です。現在のユーザが手動で照合されている場合は、現在のバインディングクレームの値である必要があります。</li>
<li><b><span class="auth_oidc_code">new_username</span></b>: バインディングユーザ名クレームとして使用する新しいトークンクレームの値です (大文字と小文字を区別します)。ユーザが自動的に照合され、OpenID Connect認証タイプを使用している場合、この値を小文字にしたものがMoodleユーザ名として使用されます。</li>
</ul>
<p>ファイルがアップロードされると、このツールは以下の処理を実行します:</p>
<ol>
<li>指定された<span class="auth_oidc_code">username</span>をユーザ名またはメールアドレスとして持ち、OpenID Connect認証方法を使用している既存のMoodleユーザを検索し、見つかった場合はそのユーザのユーザ名を<span class="auth_oidc_code">new_username</span>の小文字に更新します。</li>
<li>OpenID Connectトークンレコードを更新します。
<ul>
<li>上記のステップ1でユーザが見つかった場合、<span class="auth_oidc_code">auth_oidc_token</span>テーブルでそのユーザのトークンレコードを検索し、<span class="auth_oidc_code">username</span>カラムを<span class="auth_oidc_code">new_username</span>の小文字に、<span class="auth_oidc_code">oidcusername</span>カラムを<span class="auth_oidc_code">new_username</span>と同じ値に更新します。</li>
<li>上記でレコードが見つからない場合、<span class="auth_oidc_code">auth_oidc_token</span>テーブルで<span class="auth_oidc_code">oidcusername</span>カラムが古い<span class="auth_oidc_code">username</span>と一致するレコードを検索し、<span class="auth_oidc_code">new_username</span>に更新します。</li>
</ul>
</li>
<li><span class="auth_oidc_code">local_o365</span>プラグインがインストールされている場合、ユーザ接続レコードを更新します。
<ul>
<li>上記のステップ1でユーザが見つかった場合、<span class="auth_oidc_code">local_o365_objects</span>テーブルでそのユーザの接続レコードを検索し、<span class="auth_oidc_code">o365name</span>カラムを<span class="auth_oidc_code">new_username</span>と同じ値に更新します。</li>
<li>ステップ1でユーザが見つからない場合、<span class="auth_oidc_code">local_o365_objects</span>テーブルで<span class="auth_oidc_code">o365name</span>が<span class="auth_oidc_code">username</span>の値と一致するユーザのレコードを検索し、<span class="auth_oidc_code">new_username</span>の値に更新します。</li>
</ul>
</li>
</ol>
<p>以下のファイル例では、バインディングユーザ名クレームを<span class="auth_oidc_code">upn</span>または<span class="auth_oidc_code">email</span>から<span class="auth_oidc_code">oid</span>に変更します。</p>';
$string['change_binding_username_claim_tool_result'] = '更新結果';
$string['update_username_results'] = 'ユーザ名の更新結果';
$string['new_username'] = '新しいユーザ名';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
