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
 * @package block_microsoft
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft';
$string['contactadmin'] = '詳細については管理者にお問い合わせください。';
$string['error_nomoodlenotebook'] = 'Moodleノートブックが見つかりませんでした。';
$string['error_urlrequiredwhenenabled'] = '上記の「表示」オプションが有効になっているため、このURLを設定する必要があります。';
$string['linkonedrive'] = 'マイOneDrive';
$string['linkonenote'] = 'マイOneNoteノートブック';
$string['linksways'] = 'マイSway';
$string['linkmsstream'] = 'Microsoft Stream';
$string['linkmsstreamclassic'] = 'Microsoft Stream (クラシック)';
$string['linkmsteams'] = 'Microsoft Teams';
$string['linkemail'] = 'マイメール';
$string['linkonenote_unavailable'] = 'OneNoteは利用できません';
$string['linksharepoint'] = 'コースのSharePointサイト';
$string['linkoutlook'] = 'Outlookカレンダー同期設定';
$string['linkprefs'] = '設定を編集';
$string['linkconnection'] = 'Microsoft 365接続設定';
$string['microsoft'] = 'Microsoft';
$string['microsoft:addinstance'] = '新しいMicrosoftブロックを追加する';
$string['microsoft:myaddinstance'] = 'マイページに新しいMicrosoftブロックを追加する';
$string['workonthis'] = 'これに取り組む';
$string['o365matched_title'] = 'Microsoft 365に<span style="color: #960">ほぼ</span>接続されています';
$string['o365matched_desc'] = 'Microsoft 365ユーザ<b>「{$a}」</b>と照合されました';
$string['o365matched_complete_authreq'] = '接続を完了するには、下のリンクをクリックして、このMicrosoft 365アカウントにログインしてください。';
$string['o365connected'] = '{$a->firstname}さん、現在Microsoft 365に<span class="notifysuccess">接続されています</span>';
$string['notconnected'] = 'どのMicrosoftサービスにも<span class="notifyproblem">接続されていません</span>。';
$string['course_connected_to_team'] = 'コースは<b>チーム</b>に<span class="notifysuccess">接続されています</span>。';
$string['course_connected_to_team_pending'] = 'コースは<b>チーム</b>に接続するよう設定されていますが、チームの作成は<span class="notifyproblem">保留中</span>です。';
$string['course_connected_to_group_pending'] = 'コースは<b>チーム</b>に接続するよう設定されていますが、グループの作成は<span class="notifyproblem">保留中</span>です。';
$string['course_not_connected'] = 'コースはどのMicrosoftサービスにも<span class="notifyproblem">接続されていません</span>。';
$string['cachedef_onenotenotebook'] = 'OneNoteノートブックを保存します。';
$string['logintoo365'] = 'Microsoft 365にログイン';
$string['connecttoo365'] = 'Microsoft 365に接続';
$string['install_office'] = 'Officeをインストール';

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
$string['settings_showemail'] = '「マイメール」を表示';
$string['settings_showemail_desc'] = 'ブロック内の「マイメール」リンクを有効または無効にします。';
$string['settings_showmydelve'] = '「マイDelve」を表示';
$string['settings_showmydelve_desc'] = 'ブロック内の「マイDelve」リンクを有効または無効にします。';
$string['settings_showmyforms'] = '「マイForms」を表示';
$string['settings_showmyforms_desc'] = 'ブロック内の「マイForms」リンクを有効または無効にします。';
$string['settings_showmyforms_default'] = 'https://forms.office.com/Pages/DesignPage.aspx#';
$string['settings_showo365download'] = '「Officeをインストール」を表示';
$string['settings_showo365download_desc'] = 'ブロック内の「Officeをインストール」リンクを有効または無効にします。';
$string['settings_showsways'] = '「マイSway」を表示';
$string['settings_showsways_desc'] = 'ブロック内の「マイSway」リンクを有効または無効にします。';
$string['settings_showmsstream'] = '「Microsoft Stream (SharePoint上)」を表示';
$string['settings_showmsstream_desc'] = 'ブロック内の「Microsoft Stream (SharePoint上)」リンクを有効または無効にします。';
$string['settings_showmsstreamclassic'] = '「Microsoft Stream (クラシック)」を表示';
$string['settings_showmsstreamclassic_desc'] = 'ブロック内の「Microsoft Stream (クラシック)」リンクを有効または無効にします。';
$string['settings_showmsteams'] = '「Microsoft Teams」を表示';
$string['settings_showmsteams_desc'] = 'ブロック内の「Microsoft Teams」リンクを有効または無効にします。';
$string['settings_showonedrive'] = '「マイOneDrive」を表示';
$string['settings_showonedrive_desc'] = 'ブロック内の「マイOneDrive」リンクを有効または無効にします。';
$string['settings_showonenotenotebook'] = '「マイOneNoteノートブック」を表示';
$string['settings_showonenotenotebook_desc'] = 'ブロック内の「マイOneNoteノートブック」リンクを有効または無効にします。';
$string['settings_showoutlooksync'] = '「Outlookカレンダー同期設定」を表示';
$string['settings_showoutlooksync_desc'] = 'ブロック内の「Outlookカレンダー同期設定」リンクを有効または無効にします。';
$string['settings_showpreferences'] = '「設定を編集」を表示';
$string['settings_showpreferences_desc'] = 'ブロック内の「設定を編集」リンクを有効または無効にします。';
$string['settings_showo365connect'] = '「Microsoft 365に接続」を表示';
$string['settings_showo365connect_desc'] = 'ブロック内の「Microsoft 365に接続」リンクを有効または無効にします。<br /><b>注意:</b> このリンクはMicrosoft 365に接続していないユーザに表示され、接続を設定するページに移動します。';
$string['settings_showmanageo365conection'] = '「Microsoft 365接続設定」を表示';
$string['settings_showmanageo365conection_desc'] = 'ブロック内の「Microsoft 365接続設定」リンクを有効または無効にします。<br /><b>注意:</b> このリンクはMicrosoft 365に接続しているユーザに表示され、接続の管理ページに移動します。';
$string['settings_showcoursespsite'] = '「コースのSharePointサイト」を表示';
$string['settings_showcoursespsite_desc'] = 'ブロック内の「コースのSharePointサイト」リンクを有効または無効にします。<br /><b>注意:</b> このリンクは、関連付けられたSharePointサイトを持つコースを表示しているときにブロックに表示されます。';
$string['settings_showcourselinks'] = 'コースリンクを表示';
$string['settings_showcourselinks_desc'] = 'コース表示時にブロックに表示されるコースセクション全体 (コースのステータス見出しとすべてのコースリンクを含む) を有効または無効にします。<br /><b>注意:</b> 無効にすると、以下の個別のコースリンク設定は無視されます。';
$string['settings_showcourseconfiguresync'] = '「コース同期を設定」を表示';
$string['settings_showcourseconfiguresync_desc'] = 'ブロックのコースセクション内の「コース同期を設定」リンクを有効または無効にします。';
$string['settings_showcourseteam'] = '「チーム」を表示';
$string['settings_showcourseteam_desc'] = 'ブロックのコースセクション内の「チーム」リンクを有効または無効にします。';
$string['settings_showcourseconversations'] = '「Outlook会話」を表示';
$string['settings_showcourseconversations_desc'] = 'ブロックのコースセクション内の「Outlook会話」リンクを有効または無効にします。';
$string['settings_showcourseonedrive'] = '「OneDriveファイル」を表示';
$string['settings_showcourseonedrive_desc'] = 'ブロックのコースセクション内の「OneDriveファイル」リンクを有効または無効にします。';
$string['settings_showcoursecalendar'] = '「Outlookカレンダー」を表示';
$string['settings_showcoursecalendar_desc'] = 'ブロックのコースセクション内の「Outlookカレンダー」リンクを有効または無効にします。';
$string['settings_showcoursenotebook'] = '「クラスノートブック」を表示';
$string['settings_showcoursenotebook_desc'] = 'ブロックのコースセクション内の「クラスノートブック」リンクを有効または無効にします。';
$string['settings_showcoursereset'] = '「コースのリセットオプション」を表示';
$string['settings_showcoursereset_desc'] = 'ブロックのコースセクション内の「コースのリセットオプション」リンクを有効または無効にします。';
$string['settings_geto365link'] = 'OfficeインストールのダウンロードURL';
$string['settings_geto365link_desc'] = '「Officeをインストール」リンクに使用するURLです。';
$string['settings_geto365link_default'] = 'https://portal.office.com/OLS/MySoftware.aspx';
$string['settings_showword'] = '「Word」を表示';
$string['settings_showword_desc'] = 'ブロック内の「Word」リンクを有効または無効にします。';
$string['settings_showexcel'] = '「Excel」を表示';
$string['settings_showexcel_desc'] = 'ブロック内の「Excel」リンクを有効または無効にします。';
$string['settings_showpowerpoint'] = '「PowerPoint」を表示';
$string['settings_showpowerpoint_desc'] = 'ブロック内の「PowerPoint」リンクを有効または無効にします。';
$string['settings_showvivaengage'] = '「Viva Engage」を表示';
$string['settings_showvivaengage_desc'] = 'ブロック内の「Viva Engage」リンクを有効または無効にします。';
$string['settings_showvivaamplify'] = '「Viva Amplify」を表示';
$string['settings_showvivaamplify_desc'] = 'ブロック内の「Viva Amplify」リンクを有効または無効にします。<br /><b>注意:</b> リンクを表示するには、以下のViva Amplify URLも設定する必要があります。';
$string['settings_vivaamplifyurl'] = 'Viva Amplify URL';
$string['settings_vivaamplifyurl_desc'] = 'Microsoft 365テナント管理者が設定した、組織のViva AmplifyエクスペリエンスのURLです。amplify.microsoft.com または amplify.cloud.microsoft ドメイン上のURLのみ使用できます。例: https://amplify.microsoft.com/.';
$string['settings_showvivaconnections'] = '「Viva Connections」を表示';
$string['settings_showvivaconnections_desc'] = 'ブロック内の「Viva Connections」リンクを有効または無効にします。<br /><b>注意:</b> リンクを表示するには、以下のViva Connections URLも設定する必要があります。';
$string['settings_vivaconnectionsurl'] = 'Viva Connections URL';
$string['settings_vivaconnectionsurl_desc'] = 'Microsoft 365テナント管理者が設定した、組織のViva ConnectionsエクスペリエンスのURLです。通常はSharePointのホームサイトです。*.sharepoint.com ドメイン (またはソブリンクラウドの同等のドメイン) 上のURLのみ使用できます。例: https://yourtenant.sharepoint.com/sites/yourhomesite.';
$string['settings_showvivaglint'] = '「Viva Glint」を表示';
$string['settings_showvivaglint_desc'] = 'ブロック内の「Viva Glint」リンクを有効または無効にします。';
$string['settings_showvivagoals'] = '「Viva Goals」を表示';
$string['settings_showvivagoals_desc'] = 'ブロック内の「Viva Goals」リンクを有効または無効にします。';
$string['settings_showvivainsights'] = '「Viva Insights」を表示';
$string['settings_showvivainsights_desc'] = 'ブロック内の「Viva Insights」リンクを有効または無効にします。';
$string['settings_showvivalearning'] = '「Viva Learning」を表示';
$string['settings_showvivalearning_desc'] = 'ブロック内の「Viva Learning」リンクを有効または無効にします。<br /><b>注意:</b> リンクを表示するには、以下のViva Learning URLも設定する必要があります。';
$string['settings_vivalearningurl'] = 'Viva Learning URL';
$string['settings_vivalearningurl_desc'] = 'Microsoft 365テナント管理者が設定した、組織のViva LearningエクスペリエンスのURLです。viva.microsoft.com または cloud.microsoft ドメイン上のURLのみ使用できます。例: https://web.viva.microsoft.com/learning.';
$string['settings_showvivapulse'] = '「Viva Pulse」を表示';
$string['settings_showvivapulse_desc'] = 'ブロック内の「Viva Pulse」リンクを有効または無効にします。';
$string['settings_showlinkedin'] = '「LinkedIn」を表示';
$string['settings_showlinkedin_desc'] = 'ブロック内の「LinkedIn」リンクを有効または無効にします。';

$string['linkmydelve'] = 'マイDelve';
$string['linkmyforms'] = 'マイForms';
$string['privacy:metadata'] = 'Microsoftブロックは、さまざまな機能やサービスへのリンクを表示するだけです。';

// Course sync features.
$string['course_feature_team'] = 'チーム';
$string['course_feature_conversations'] = 'Outlook会話';
$string['course_feature_onedrive'] = 'OneDriveファイル';
$string['course_feature_calendar'] = 'Outlookカレンダー';
$string['course_feature_notebook'] = 'クラスノートブック';

// Course sync settings.
$string['configure_sync'] = 'コース同期を設定';
$string['error_course_sync_not_configurable_per_course'] = 'コース同期はコースごとに設定できません。';
$string['sync_page_heading'] = 'コース{$a}をMicrosoft Teamsに同期';
$string['configure_course_sync'] = 'Microsoft Teamsへのコース同期を設定';
$string['course_sync_option'] = '同期オプション';
$string['course_sync_option_disabled'] = '無効';
$string['course_sync_option_enabled'] = '有効';
$string['sync_setting_saved'] = 'コース同期オプションを保存しました';

// Course reset status.
$string['course_reset_disconnect_and_create_new'] = 'コースがリセットされると、コースに接続されているチームは設定どおりに名前が変更され、アーカイブされます。新しいチームが作成され、コースに接続されます。';
$string['course_reset_do_nothing'] = 'コースがリセットされても、コースとチームの接続は維持されます。コースに対するユーザの変更はすべてチームに同期されます。';
$string['course_reset_disconnect_only'] = 'コースがリセットされると、コースに接続されているチームは設定どおりに名前が変更され、アーカイブされます。新しいチームは作成されません。';
$string['configure_reset'] = 'コースのリセット時のMicrosoft Teamsの動作を選択';

// Course reset settings page.
$string['reset_page_heading'] = '{$a}のコースリセット時の動作';
$string['configure_course_reset'] = 'コースのリセット設定を構成';
$string['course_reset_option'] = 'コースのリセット時のチームに対する動作';
$string['reset_option_do_nothing'] = '何もしない。<br/>チームはコースに接続されたままになります。ユーザの登録解除により、チームの所有者/メンバーから削除されます。';
$string['reset_option_disconnect_and_create_new'] = '切断して新しいチームを作成する。<br/>コースに接続されている既存のチームは設定どおりに名前が変更され、アーカイブされます。新しいチームが作成され、コースに接続されます。';
$string['reset_option_disconnect_only'] = '切断のみ行う。<br/>コースに接続されている既存のチームは設定どおりに名前が変更され、アーカイブされます。新しいチームは作成されません。';
$string['reset_setting_saved'] = 'コースのリセット設定を保存しました。';
$string['error_site_course_sync_disabled'] = 'コース同期は有効になっていません';
$string['error_reset_setting_not_managed_per_course'] = 'リセット動作の設定は、サイト管理者が一括管理しています。';
$string['error_connected_team_missing'] = 'コースは同期するよう設定されていますが、チームが見つかりません。';
$string['error_course_sync_disabled'] = 'コースは同期するよう設定されていません。';

// Course request.
$string['linkcourserequest'] = 'Teamsからコースをリクエスト';
$string['settings_courserequest'] = 'Teamsからコースをリクエスト';
$string['settings_courserequest_desc'] = 'Microsoft Teamsから新しいコースをリクエストします。承認後、コースが作成されてチームに接続されます。チームのメンバーはコースに登録されます。';

$string['customlinks'] = 'カスタムリンク';
$string['customlink_addanother'] = '別のリンクを追加';
$string['customlink_delete'] = 'このリンクを削除';
$string['customlink_error_url'] = 'http:// または https:// で始まる有効なURLを入力してください';
$string['customlink_icon'] = 'アイコン';
$string['customlink_name'] = '名前';
$string['customlink_nochanges'] = 'カスタムリンクが入力されていないため、保存する内容がありません。';
$string['customlink_showall'] = 'Microsoft 365に接続していないユーザにも表示する';
$string['customlink_target'] = 'リンクを開く場所';
$string['customlink_url'] = 'URL';
$string['customlink_visibility'] = '表示対象';
$string['settings_header_general'] = '一般';
$string['settings_pageheading'] = 'Microsoftブロックの設定';
$string['settings_customlinkheading'] = 'リンク{$a}';
$string['settings_customlinktarget_blank'] = '新しいウィンドウまたはタブ';
$string['settings_customlinktarget_self'] = '同じウィンドウ';
$string['settings_customlinks_desc'] = '独自のリンク (例: 社内チャットボットやイントラネットサイト) をブロックに追加します。各リンクの名前、URL、アイコンは必須です。リンクを削除するには、「このリンクを削除」にチェックを入れて保存してください。';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
