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
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @author Lai Wei <lai.wei@enovation.ie>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

defined('MOODLE_INTERNAL') || die();

// phpcs:disable moodle.Files.LangFilesOrdering.IncorrectOrder -- The strings are organised by features.
// phpcs:disable moodle.Files.LangFilesOrdering.UnexpectedComment -- The strings are organised by features.

$string['pluginname'] = 'Microsoft 365の統合';

// Settings - tabs.
$string['settings_pageheading'] = '{$a} 設定';
$string['settings_header_setup'] = '設定';
$string['settings_header_usersync'] = 'ユーザ同期';
$string['settings_header_coursesync'] = 'コース同期';
$string['settings_header_advanced'] = '詳細';
$string['settings_header_sds'] = 'SDS同期';
$string['settings_header_teams'] = 'Teams設定';
$string['settings_header_moodle_app'] = 'Teams Moodleアプリ';

// Setting sections in the "Setup" tab.
$string['settings_setup_step1'] = 'ステップ 1/2: MoodleをMicrosoft Entra IDに登録する';
$string['settings_setup_step1_desc'] = 'PowerShellを使用して、Moodle統合用の新しいMicrosoft Entra IDアプリを登録します:

<a href="{$a}/local/o365/scripts/Moodle-EntraID-PowerShell.zip" class="btn btn-primary" target="_blank">PowerShellスクリプトをダウンロードする</a>

<p style="margin-top:10px">スクリプトの実行手順については、<a href="{$a}/local/o365/scripts/README.md" target="_blank">こちらをクリック</a>してください。</p>
<p>入力を求められた場合、MoodleのURLとして次のリンクを使用してください:</p><h5><b>{$a}</b></h5>';
$string['settings_setup_step1clientcreds'] = '<br />スクリプトが正常に実行された後、スクリプトが返したアプリケーションIDとシークレットを<a href="{$a}">OpenID Connect認証プラグイン設定ページ</a>にコピーしてください。';
$string['settings_setup_step1_credentials_end'] = 'PowerShellでMicrosoft Entra IDアプリを設定できない場合、手動設定の手順について<a href="{$a}" target="_blank">こちらをクリック</a>してください。';
$string['settings_setup_step1_continue'] = '<b>アプリケーションIDとシークレットを入力した後、続けるにはページ下部の「変更を保存する」をクリックしてください。</b><br /><br /><br /><br /><br />';
$string['features_disabled_external_id'] = 'OpenID Connect認証プラグインのIdPタイプがMicrosoft Entra External IDに設定されている場合、Microsoft 365の機能は利用できません。Microsoft Entra External IDテナントは、Microsoft 365サービス（Exchange Online、Microsoft Teams、SharePoint/OneDrive、School Data Sync）のない顧客テナントであるため、このプラグインのすべての機能が無効になります。';
$string['task_skipped_external_id'] = 'タスクはスキップされました。OpenID Connect認証プラグインのIdPタイプがMicrosoft Entra External IDであるため、このプラグインのMicrosoft 365機能は無効になっています。';
$string['settings_setup_step1_existing_settings'] = '<h5>既存の設定</h5>';
$string['settings_setup_step2'] = 'ステップ 2/2: 管理者の同意 &amp; 追加情報';
$string['settings_setup_step2_desc'] = 'この最後のステップでは、一部のMicrosoft Entra IDアクセス権の使用に対して管理者の同意を与え、Microsoft 365環境に関する追加情報を収集します。<br /><br />';
$string['settings_setup_step3'] = '設定を確認する';
$string['settings_setup_step3_desc'] = '設定が完了しました。設定を確認するには、下の「更新」ボタンをクリックしてください。';

// Settings in "Step 2/2" section of the "Setup" tab.
$string['settings_adminconsent'] = '管理者の同意';
$string['settings_adminconsent_btn'] = '管理者の同意を与える';
$string['settings_adminconsent_details'] = '必要なアクセス権の一部へのアクセスを許可するには、管理者が管理者の同意を与える必要があります。このボタンをクリックし、Microsoft Entra ID管理者アカウントでログインして同意を与えてください。この操作は、Entra IDで「管理者」アクセス権を変更するたびに行う必要があります。';
$string['settings_entratenant'] = 'Microsoft Entraテナント';
$string['settings_entratenant_details'] = 'Microsoft内で組織を特定するために使用します。例: 「contoso.onmicrosoft.com」<br/>
この値を手動で確認するには:
<ul>
<li><a href="https://portal.azure.com" target="_blank">Azure Portal</a>にアクセスします。</li>
<li>管理者アカウントでサインインします。</li>
<li>検索バーに「Microsoft Entra ID」と入力し、「Microsoft Entra ID」ページに移動します。</li>
<li>「基本情報」セクションの<b>プライマリ ドメイン</b>フィールドの値を使用します。</li>
</ul>';
$string['settings_odburl'] = 'OneDrive for BusinessのURL';
$string['settings_odburl_details'] = 'OneDrive for Businessへのアクセスに使用するURLです。これは通常、Microsoft Entra IDテナントによって決定されます。たとえば、Microsoft Entra IDテナントが「contoso.onmicrosoft.com」の場合、通常は「contoso-my.sharepoint.com」になります。ドメイン名のみを入力し、http:// や https:// は含めないでください。';
$string['settings_odburl_error_graph'] = 'OneDrive for BusinessのURLを特定できませんでした。手動で入力してください。通常は、OneDriveへのアクセスに使用しているURLから特定できます。';
$string['settings_serviceresourceabstract_detect'] = '検出';
$string['settings_serviceresourceabstract_detecting'] = '検出しています...';
$string['settings_serviceresourceabstract_error'] = '設定の検出中にエラーが発生しました。手動で設定してください。';
$string['settings_serviceresourceabstract_valid'] = '{$a} は使用できます。';
$string['settings_serviceresourceabstract_invalid'] = 'この値は使用できない可能性があります。';
$string['settings_serviceresourceabstract_nocreds'] = '初めにアプリケーションの認証情報を設定してください。';
$string['settings_serviceresourceabstract_empty'] = '値を入力するか、[検出]をクリックして正しい値を検出します。';

// Settings in "Verify setup" section of the "Setup" tab.
$string['settings_verifysetup'] = '設定を確認する';
$string['settings_verifysetup_appdataheader'] = 'Microsoft Entra IDアプリ登録';
$string['settings_verifysetup_appdatadesc'] = 'Entra IDアプリに正しいパラメータが設定されていることを確認します。';
$string['settings_verifysetup_appdatareplyurlcorrect'] = '応答URLは正しいです';
$string['settings_verifysetup_appdatareplyurlincorrect'] = '応答URLが正しくありません';
$string['settings_verifysetup_appdatareplyurlgeneralerror'] = '応答URLを確認できませんでした。';
$string['settings_verifysetup_appdatasignonurlcorrect'] = 'サインオンURLは正しいです。';
$string['settings_verifysetup_appdatasignonurlincorrect'] = 'サインオンURLが正しくありません';
$string['settings_verifysetup_appdatasignonurlgeneralerror'] = 'サインオンURLを確認できませんでした。';
$string['settings_verifysetup_apppermscorrect'] = 'アプリケーションアクセス権は正しいです。';
$string['settings_verifysetup_details'] = 'このツールは、Microsoft Entra IDですべてが正しく設定されているかどうかを確認します。<br /><b>注:</b> Microsoft Entra IDアプリでの変更がここに反映されるまでに時間がかかる場合があります。Microsoft Entra IDアプリで変更を行ったにもかかわらずここに反映されない場合は、しばらく待ってから再度お試しください。';
$string['settings_verifysetup_correctval'] = '正しい値:';
$string['settings_verifysetup_detectedval'] = '検出された値:';
$string['settings_verifysetup_update'] = '更新';
$string['settings_verifysetup_checking'] = '確認しています...';
$string['settings_verifysetup_missingappperms'] = '不足しているアプリケーションアクセス権:';
$string['settings_verifysetup_notgranted'] = 'アプリケーションに追加されていますが、管理者の同意が与えられていません';
$string['settings_verifysetup_missingperms'] = '不足している委任アクセス権:';
$string['settings_verifysetup_permscorrect'] = '委任アクセス権は正しいです。';
$string['settings_verifysetup_errorcheck'] = '設定の確認中にエラーが発生しました。';
$string['settings_verifysetup_noinfo'] = 'Microsoft Entra IDアプリの設定に関する情報はまだありません。確認するには「更新」ボタンをクリックしてください。';
$string['settings_verifysetup_strunifiedpermerror'] = 'Microsoft Graph APIのアクセス権の確認中にエラーが発生しました。';
$string['settings_verifysetup_strtenanterror'] = 'Microsoft Entra IDアプリの設定を更新する前に、「検出」ボタンを使用してMicrosoft Entraテナントを設定してください。';
$string['settings_verifysetup_unifiedheader'] = 'Microsoft Graph API';
$string['settings_verifysetup_unifieddesc'] = 'Microsoft Graph APIにより、MoodleとMicrosoft 365間の通信が可能になります。';
$string['settings_verifysetup_unifiederror'] = 'Microsoft Graph APIサポートの確認中にエラーが発生しました。';
$string['settings_verifysetup_unifiedactive'] = 'Microsoft Graph APIがアクティブです。';
$string['settings_verifysetup_unifiedmissing'] = 'Microsoft Graph APIは、このアプリケーションで見つかりませんでした。';

// Additional settings in the "Verify setup" section of the "Setup" tab.
$string['settings_detectoidc_credsvalid'] = '認証情報が設定されました。';
$string['settings_detectoidc_credsvalid_link'] = '変更';
$string['settings_detectoidc_credsinvalid'] = '認証情報が設定されていないか、または不完全です。';
$string['settings_detectoidc_credsinvalid_link'] = '認証情報を設定する';
$string['settings_detectperms_nocreds'] = '初めにアプリケーションの認証情報を設定する必要があります。上記の設定を参照してください。';
$string['settings_detectperms_errorfix'] = 'アクセス権の修復中にエラーが発生しました。Microsoft Entra IDで手作業で修復してください。';
$string['settings_detectperms_fixperms'] = 'アクセス権を修復する';
$string['settings_detectperms_update'] = '更新';
$string['settings_detectperms_valid'] = 'アクセス権が設定されました。';
$string['settings_detectperms_invalid'] = 'Microsoft Entra IDのアクセス権をチェックする';

// Settings in "User sync" section of the "Sync settings" tab.
$string['settings_usersync_general'] = '一般的なユーザ同期';
$string['settings_usersync_suspension'] = 'Moodleアカウントの一時停止';
$string['settings_usersync_matching'] = 'ユーザマッチング';
$string['settings_usersync_photos'] = 'Microsoft 365のプロファイル写真をMoodleに同期する';
$string['settings_usersync_timezone'] = 'OutlookのタイムゾーンをMoodleに同期する';
$string['settings_usersync'] = 'ユーザをMicrosoft Entra IDから同期する';
$string['settings_usersync_details'] = 'この機能を有効にすると、Moodleは上記のオプションに従ってMicrosoft Entra IDからユーザを同期します。<br /><br /><b>注: </b>同期ジョブはMoodle cronで実行され、一度に1000ユーザを同期します。デフォルトでは、毎日、サーバのローカルタイムゾーンの午前1:00に1回実行されます。大量のユーザをより短時間で同期するには、<a href="{$a}">スケジュールタスク管理ページ</a>を使用して<b>ユーザをMicrosoft Entra IDから同期する</b>タスクの頻度を増やしてください。<br /><br />';
$string['settings_usersync_create'] = 'Microsoft Entra IDのユーザ向けにMoodleにアカウントを作成する';
$string['settings_usersync_update'] = 'Microsoft Entra IDのユーザについてMoodleのアカウントを更新する';
$string['settings_usersync_suspend'] = 'Microsoft Entra IDからアカウントが削除された場合、以前同期したMoodleのアカウントを一時停止する';
$string['settings_usersync_delete'] = 'Microsoft Entra IDからアカウントが削除された場合、以前同期したMoodleのアカウントを削除する';
$string['settings_usersync_reenable'] = 'Microsoft Entra IDのユーザについて一時停止されたアカウントを再度有効にする';
$string['settings_usersync_disabledsyncsuspend'] = 'Microsoft Entra IDで無効にされた場合、Moodleのアカウントを一時停止する';
$string['settings_usersync_disabledsyncreenable'] = 'Microsoft Entra IDで再度有効にされた場合、Moodleのアカウントを再度有効にする';
$string['settings_usersync_suspendnolink'] = 'Microsoftとのリンクが保存されていない接続済みアカウントを、Microsoft Entra IDから削除または無効にされた場合に一時停止する';
$string['settings_usersync_groupsyncsuspend'] = '設定されたユーザ同期グループに属していない場合、Moodleのアカウントを一時停止する';
$string['settings_usersync_match'] = '既存のMoodleユーザとMicrosoft Entra IDの同名のアカウントを一致させる';
$string['settings_usersync_matchswitchauth'] = '一致したユーザをMicrosoft 365 (OpenID Connect) 認証に切り替える';
$string['settings_usersync_appassign'] = '同期中にユーザをアプリケーションに割り当てる';
$string['settings_usersync_photosync'] = 'cronジョブでMicrosoft 365のプロファイル写真をMoodleに同期する';
$string['settings_usersync_photosynconlogin'] = 'ログイン時にMicrosoft 365のプロファイル写真をMoodleに同期する';
$string['settings_usersync_nodelta'] = '実行ごとに完全同期を実行する';
$string['settings_usersync_emailsync'] = '同期中、Microsoft Entra IDのユーザ名をMoodleのユーザ名ではなくMoodleのメールアドレスと照合する';
$string['settings_addsync_tzsync'] = 'cronジョブでOutlookのタイムゾーンをMoodleに同期する';
$string['settings_addsync_tzsynconlogin'] = 'ログイン時にOutlookのタイムゾーンをMoodleに同期する';
$string['settings_usersync_guestsync'] = 'ゲストユーザを同期する';
$string['settings_suspend_delete_running_time'] = 'ユーザ一時停止/削除の実行時刻';
$string['settings_suspend_delete_running_time_desc'] = 'このオプションを有効にした場合、ユーザ同期機能の一時停止/削除処理は、Moodleインスタンスのデフォルトタイムゾーンで設定された時刻に1日1回実行されます。';
$string['settings_usersync_delete_delay'] = '一時停止されたユーザを削除するまでの待機時間';
$string['settings_usersync_delete_delay_desc'] = 'ユーザ同期がアカウントを削除する前に、ユーザがMoodleで一時停止状態のままでなければならない最短期間です。この期間はMicrosoft Entra IDの論理削除の保持期間に加えて適用されるため、削除がそれより早く行われることはありません。Microsoft Entra IDの保持期間が終了した直後に削除するには、0に設定してください。この設定の導入前にすでに一時停止されていたユーザについては、そのユーザを最初に検出したユーザ同期の実行時点から計算されます。';
$string['settings_support_user_identifier_change'] = 'Microsoftアカウントのバインド用ユーザ名クレーム値の変更をサポートする';
$string['settings_support_user_identifier_change_desc'] = '有効にした場合、Moodleアカウントに接続されたMicrosoftアカウントのバインド用ユーザ名クレーム値 (通常はUPN) が変更されたときに、Moodleが対応を試みます。<br/>
<table class="flexible table table-striped table-hover generaltable generalbox table-sm">
    <tr>
        <th>ケースID</th>
        <th>旧ユーザ名のユーザがすでにログインしているか? (トークン作成済み)<br/>
        <span class="support_user_identifier_change_case_detail">auth_oidc_tokenテーブルにトークンが保存されているかどうか</span>
        </th>
        <th>UPN名変更後の最初のアクション<br/>
        <span class="support_user_identifier_change_case_detail">ログインまたはユーザ同期タスクの実行のいずれか</span>
        </th>
        <th>ユーザ名が重複する可能性があるか<br/>
        <span class="support_user_identifier_change_case_detail">名前変更によってMoodleでユーザ名の競合が発生するかどうか</span>
        </th>
        <th>想定される動作</th>
    </tr>
    <tr>
        <td>1</td>
        <td>はい</td>
        <td>ログイン</td>
        <td>いいえ</td>
        <td>
            <ol>
                <li>Moodleユーザの名前を変更します。</li>
                <li>auth_oidc_tokenの「username」および「oidcusername」フィールドの両方が新しい値で更新されます。</li>
                <li>local_o365_objectsのユーザ接続レコードの「o365name」フィールドが新しい値に更新されます。</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>はい</td>
        <td>ユーザ同期</td>
        <td>いいえ</td>
        <td>
            <ol>
                <li>Moodleユーザの名前を変更します。</li>
                <li>local_o365_objectsのユーザ接続レコードが更新されます。</li>
                <li>auth_oidc_tokenが更新されます。</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>いいえ</td>
        <td>ログイン</td>
        <td>いいえ</td>
        <td>
            <ol>
                <li>Moodleユーザの名前を変更します。</li>
                <li>local_o365_objectsのユーザ接続レコードが更新されます。</li>
                <li>auth_oidc_tokenが更新されます。</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>いいえ</td>
        <td>ユーザ同期</td>
        <td>いいえ</td>
        <td>
            <ol>
                <li>Moodleユーザの名前を変更します。</li>
                <li>local_o365_objectsのユーザ接続レコードが更新されます。</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>はい</td>
        <td>ログイン</td>
        <td>はい</td>
        <td>
            <ol>
                <li>例外をスローし、Moodleユーザの名前は変更しません。</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>はい</td>
        <td>ユーザ同期</td>
        <td>はい</td>
        <td>
            <ol>
                <li>ユーザ同期タスクの実行で、名前変更の試行に失敗したことを示すエラーメッセージを表示します。</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>いいえ</td>
        <td>ログイン</td>
        <td>はい</td>
        <td>
            <ol>
                <li>例外をスローし、Moodleユーザの名前は変更しません。</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>いいえ</td>
        <td>ユーザ同期</td>
        <td>はい</td>
        <td>
            <ol>
                <li>ユーザ同期タスクの実行で、名前変更の試行に失敗したことを示すエラーメッセージを表示します。</li>
            </ol>
        </td>
    </tr>
</table>
次の既知の問題があることにご注意ください。
<ol>
<li>MoodleとMicrosoft 365が「Microsoft identity platform (v2.0)」接続方式で接続されている</li>
<li>Microsoft Entraが「代替ログインIDとしてのメール」の使用を許可するよう設定されている</li>
<li>このオプションが有効になっている</li>
<li>Microsoftアカウントのユーザ名とメールアドレスが異なる</li>
<li>Microsoftユーザがユーザ名ではなくメールアドレスを使用してログインする</li>
</ol>
上記すべてに該当する場合、auth_oidcプラグインはメールアドレスをMicrosoftアカウントのユーザ名として扱い、Moodleのユーザ名を更新します。';

// User field mapping.
$string['settings_fieldmap'] = 'ユーザフィールドマッピング';
$string['settings_fieldmap_details'] = '<a href="{$a}">OpenID Connect認証プラグイン</a>で利用できます。';

// Settings in the "Course sync" section of the "Sync settings" tab.
$string['settings_secthead_coursesync'] = 'コース同期';
$string['settings_secthead_coursesync_desc'] = '以下の設定は、MoodleとMicrosoft Teams間のコース同期を制御します。';
$string['settings_coursesync'] = 'コース同期';
$string['settings_coursesync_details'] = '有効にした場合、Moodleサイトのコースに対するチームを作成および維持します (デフォルト: 無効)。cronの実行ごとに必要なチームを作成し、現在登録されているすべてのユーザを、ケイパビリティチェックに応じてチームの所有者またはメンバーとして追加します。その後は、Moodleコースへのユーザの登録または登録解除に合わせてチームのメンバーシップが維持されます。';
$string['acp_coursesynccustom_off'] = '無効<br />すべてのコースでチームの作成を無効にします。';
$string['acp_coursesynccustom_oncustom'] = 'カスタマイズ<br />権限のあるユーザが、チームを作成するコースを選択できるようにします。<br> <span id="adminsetting_coursesync" style="font-weight: bold"><a href="{$a}">コース同期をカスタマイズする</a></span>';
$string['acp_coursesynccustom_onall'] = 'すべての機能を有効にする<br />すべてのコースでチームの作成を有効にします。';
$string['settings_coursesync_sync_hidden_courses'] = '非表示コースを同期する';
$string['settings_coursesync_sync_hidden_courses_desc'] = 'デフォルトでは、コピー中またはリストア中のコースが同期されないよう、プラグインは非表示コースを無視します。非表示コースに対してもチームを強制的に作成するには、この設定を有効にしてください。';
$string['acp_coursesync_hidden_course_note'] = '注: 非表示コースはTeamsグループ作成の処理対象になりません。処理対象にするには、プラグイン設定で「非表示コースを同期する」設定を有効にする必要があります。';
$string['settings_coursesync_delete_group_on_course_deletion'] = '接続されたMoodleコースが削除された場合、Microsoft 365グループを削除する';
$string['settings_coursesync_delete_group_on_course_deletion_details'] = '有効にした場合、接続されたコースがMoodleから削除されると、MoodleはMicrosoft 365グループ (および関連するチーム) の削除を試みます。これはSDS同期で作成されたコースには適用されないことにご注意ください。';
$string['settings_coursesync_delete_group_on_course_sync_disabled'] = 'コース同期が無効にされた場合、Microsoft 365グループを削除する';
$string['settings_coursesync_delete_group_on_course_sync_disabled_details'] = '有効にした場合、Moodleコースのコース同期がオフにされると、Moodleは接続されたMicrosoft 365グループ (および関連するチーム) の削除を試みます。';
$string['settings_coursesync_courses_per_task'] = 'タスク実行ごとに同期するコース数';
$string['settings_coursesync_courses_per_task_details'] = '各タスク実行で、チーム/グループの同期ステータスを処理するコースの数です。';
$string['settings_coursesync_team_type'] = 'チームテンプレート';
$string['settings_coursesync_team_type_desc'] = 'Moodleコースからチームを作成する際に使用するMicrosoft Teamsテンプレートです。教育機関向けテンプレートには教育機関向けライセンスが必要です。<br><br><strong>重要:</strong> 設定されたテンプレートによって、グループとチームの作成方法が決まります:<br>
&bull; 標準テンプレートは、標準のグループとチームを作成します (すべてのテナントと互換性があります)。<br>
&bull; 教育機関向けテンプレートは、教育機関向けグループ/チームを作成します (教育機関向けテナントのみ。教育機関固有の機能が有効になります)。<br>
&bull; カスタムテンプレートは、標準グループを使用します (カスタムテンプレートの設計との互換性のため)。<br><br>
<strong>⚠️ 警告: 特定のテンプレートでチームが作成されると、そのテンプレートは変更できません。</strong> チームは元のテンプレートに関連付けられたままになります。この設定の変更は新しく作成されるチームにのみ影響し、既存のチームには影響しません。コース同期を有効にする前に、テンプレートの選択を慎重に計画してください。';
$string['settings_coursesync_team_type_standard'] = '標準';
$string['settings_coursesync_team_type_educationclass'] = '教育機関 - クラスチーム';
$string['settings_coursesync_team_type_educationstaff'] = '教育機関 - スタッフチーム';
$string['settings_coursesync_team_type_educationplc'] = '教育機関 - プロフェッショナル ラーニング コミュニティ (PLC)';
$string['settings_coursesync_team_type_custom'] = 'カスタムテンプレート';
$string['settings_coursesync_team_type_custom_id'] = 'カスタムテンプレートID';
$string['settings_coursesync_team_type_custom_id_desc'] = 'Teams管理センターで定義されたカスタムテンプレートの完全なIDです。上で「カスタムテンプレート」が選択されている場合にのみ使用されます。<br><br><strong>テンプレートIDはGUID形式である必要があります</strong> (例: e41de7bb-859a-4a0f-aa39-5725a0529c1c)。テンプレートIDは、Teams管理センターでカスタムテンプレートの詳細を表示すると確認できます。<br><br>
<strong>⚠️ Microsoft Entra IDの追加アクセス権が必要です:</strong> カスタムチームテンプレートの検証と使用には、Microsoft Entra IDアプリ登録に含まれていない可能性のある、追加のMicrosoft Graph APIアプリケーションアクセス権 (<strong>TeamTemplates.Read.All</strong>) が必要です。このアクセス権がない場合、検証ステップは失敗し、カスタムテンプレートIDを設定できません。検証がアクセス権エラーで失敗した場合は、Microsoft Entra ID管理者に連絡して、このアクセス権をアプリ登録に追加してもらってください。<br><br>
<strong>⚠️ 重要な制限事項:</strong> Microsoft Teamsフレームワークは現在、テンプレートに<strong>en-USロケール定義</strong>が含まれている場合にのみ、カスタムテンプレートからのチーム作成をサポートしています。en-USロケールをサポートしないカスタムテンプレートでは、チームの作成に失敗します。Teams管理センターで、カスタムテンプレートにen-USロケールが定義されていることを確認してください。<br><br>
<strong>⚠️ 警告: このカスタムテンプレートを使用してチームが作成されると、そのテンプレートは変更できません。</strong> 新しいチームに別のカスタムテンプレートを使用する必要がある場合は、この設定を空のままにするか、次のチーム作成の前に変更する必要があります。既存のチームは引き続き元のテンプレートを使用します。<br><br>
誤ったテンプレートIDが設定されている場合、チームは正しく作成されません。コース同期を実行する前に、「カスタムテンプレートIDを検証する」ボタンを使用してテンプレートIDを検証してください。';
$string['error_custom_template_id_required'] = '「カスタムテンプレート」オプションを使用する場合、カスタムテンプレートIDは必須です。有効なテンプレートIDを入力してください。';
$string['error_custom_template_id_not_found'] = 'カスタムテンプレートID「{$a}」が見つかりません。テンプレートIDがTeams管理センターに存在することを確認してください。';
$string['error_custom_template_id_validation_failed'] = 'カスタムテンプレートIDの検証に失敗しました。テンプレートが直接のチーム作成をサポートしていないか、設定に問題がある可能性があります。Teams管理センターでテンプレートIDを確認してください。';
$string['settings_team_type_custom_id_test_button'] = 'カスタムテンプレートIDを検証する';
$string['settings_team_type_custom_id_validating'] = '🔄 検証しています...';
$string['settings_team_type_custom_id_error_empty'] = '⚠️ 最初にテンプレートIDを入力してください。';
$string['settings_team_type_custom_id_error_not_found'] = '✗ テンプレートが見つかりません。テンプレートID「{$a}」は存在しません。Teams管理センターで確認してください。';
$string['settings_team_type_custom_id_error_validation'] = '✗ 検証エラー。{$a}';
$string['settings_team_type_custom_id_error_default'] = 'テンプレートの検証に失敗しました。再度お試しいただくか、管理者に連絡してください。';
$string['settings_team_type_custom_id_error_timeout'] = '✗ 検証がタイムアウトしました。リクエストに10秒以上かかりました。再度お試しください。';
$string['settings_team_type_custom_id_error_network'] = '✗ ネットワークエラー。検証サービスに接続できません。インターネット接続を確認して、再度お試しください。';
$string['settings_team_type_custom_id_error_parsererror'] = '✗ サーバ応答エラー。検証サービスが無効なデータを返しました。Microsoft 365統合を確認してください。';
$string['settings_team_type_custom_id_error_http'] = '✗ 検証エラー (HTTP {$a})。再度お試しいただくか、管理者に連絡してください。';
$string['settings_coursesync_group_channels'] = 'Moodleグループごとにチャネルを作成する';
$string['settings_coursesync_group_channels_details'] = 'Moodleコースの各グループに対して、接続されたMicrosoftチームにプライベートチャネルを作成し、各チャネルのメンバーをMoodleグループのメンバーと一致させます。Microsoft 365にも接続されているグループメンバーは、グループに追加または削除されると、チャネルにも追加または削除されます。Microsoft Teamsでチャネルに追加されたMoodleグループのメンバーではないユーザは、再び削除されます。まだアクティブ化されていない教育機関向けクラスチームでは、学生をチャネルに入れることはできません。所有者のみが追加され、所有者がMicrosoft Teamsでチームをアクティブ化した後に、スケジュールタスク「Moodleグループ用のTeamsチャネルを作成してメンバーを同期する」によって学生が自動的に追加されます。Moodleグループの名前が変更または削除されても、チャネルの名前変更や削除は行われません。チャネルのメンバーシップは常にMoodleからTeamsへの方向にのみ同期され、「コースユーザ同期の動作」が「TeamsからMoodleへ」に設定されている場合、この設定は何も行いません。Microsoft Teamsでは、1つのチームに最大1,000個のチャネルを作成できます (プライベートチャネルおよび過去30日以内に削除されたチャネルを含みます)。<br /><br /><b>この設定には、2つの追加のMicrosoft Graphアプリケーションアクセス権が必要です:</b><ul><li><b>Channel.Create</b> - チャネルを作成するため。</li><li><b>ChannelMember.ReadWrite.All</b> - チャネルにメンバーを追加および削除するため。</li></ul>どちらも、Moodleが使用するMicrosoft Entra IDアプリケーションに追加し、管理者の同意を与える必要があります。「設定」タブのPowerShellスクリプトは、新しいアプリケーションを登録する際にこれらをすでに含めています。既存のアプリケーションの場合は、[アプリの登録] &gt; アプリケーション &gt; [API のアクセス許可] &gt; [アクセス許可の追加] &gt; [Microsoft Graph] &gt; [アプリケーションの許可] で手動で追加し、管理者の同意を与えてください。この設定が有効な間、「設定」タブの「設定を確認する」では、これらのアクセス権が付与されるまで不足として報告されます。';
$string['settings_coursesync_sync_direction'] = 'コースユーザ同期の動作';
$string['settings_coursesync_sync_direction_details'] = 'MoodleとMicrosoft Teams間でユーザを同期する方向を選択してください。';
$string['settings_coursesync_sync_moodle_to_teams'] = 'MoodleからTeamsへ';
$string['settings_coursesync_sync_teams_to_moodle'] = 'TeamsからMoodleへ';
$string['settings_coursesync_sync_both'] = 'TeamsとMoodleの両方を更新する';
$string['settings_coursesync_enrolment_owner_role'] = 'チーム所有者ロール';
$string['settings_coursesync_enrolment_owner_role_desc'] = '同期中にチーム所有者に割り当てられるロールです。';
$string['settings_coursesync_enrolment_member_role'] = 'チームメンバーロール';
$string['settings_coursesync_enrolment_member_role_desc'] = '同期中にチームメンバーに割り当てられるロールです。';

// Settings in the "Course sync customization" page in the "Course sync" section of the "Sync settings" tab.
$string['acp_coursesynccustom'] = 'コース同期のカスタマイズ';
$string['acp_coursesynccustom_enabled'] = '有効';
$string['acp_coursesynccustom_enable_all'] = 'すべてのコースでコース同期を有効にする';
$string['acp_coursesynccustom_disable_all'] = 'すべてのコースでコース同期を無効にする';
$string['acp_coursesynccustom_bulk'] = '一括操作';
$string['acp_coursesynccustom_bulk_enable'] = 'このページのコースでコース同期を有効にする';
$string['acp_coursesynccustom_bulk_disable'] = 'このページのコースでコース同期を無効にする';
$string['acp_coursesynccustom_settings_header'] = '同期オプション';
$string['acp_coursesynccustom_new_course'] = '新しいコースではデフォルトで有効にする';
$string['acp_coursesynccustom_new_course_desc'] = '有効にした場合、新しく作成されるすべてのコースで、デフォルトで同期が有効になります。';
$string['acp_coursesynccustom_controlled_per_course'] = 'コース内でのコース同期の設定を許可する';
$string['acp_coursesynccustom_controlled_per_course_desc'] = '有効にした場合、Moodleコースに登録されているユーザのうち、チーム所有者として行動する資格のあるユーザ (「チーム所有者」 [local/o365:teamowner] ケイパビリティを持つユーザ) は、コース内のMicrosoftブロックからコース同期を制御できるようになります。';
$string['acp_coursesynccustom_savemessage'] = '変更が保存されました。';
$string['acp_coursesynccustom_regex_search'] = '正規表現検索';
$string['acp_coursesynccustom_regex_search_title'] = 'チェックした場合、上の検索ボックスはプレーンテキスト検索ではなく、PCRE正規表現 (区切り文字なし) として長いコース名、短いコース名およびIDナンバーに対して照合されます。';
$string['acp_coursesynccustom_confirm_all_action'] = '本当にすべてのコースの同期ステータスを変更してもよろしいですか? この操作は元に戻せません。';
$string['acp_coursesynccustom_sds_course'] = 'SDSコースのためロック';
$string['acp_coursesynccustom_all_enabled_notice'] = '現在、すべてのコースでコース同期が有効になっています。「すべての機能を有効にする」モードがアクティブなため、個別のコースのカスタマイズは無効です。';
$string['acp_coursesynccustom_disabled_notice'] = '現在、コース同期はグローバルに無効になっています。「無効」モードがアクティブなため、個別のコースのカスタマイズは無効です。';
$string['acp_coursesynccustom_categories_header'] = 'コースカテゴリによる同期';
$string['acp_coursesynccustom_categories_desc'] = '1つ以上のコースカテゴリを選択すると、それらのカテゴリ (サブカテゴリを含む) 内のすべてのコースでコース同期が自動的に有効になります。これは、後で選択したカテゴリに追加されるコースにも適用されます。複数のカテゴリを選択するにはCtrl (MacではCmd) を押したままにし、選択を解除するにはそのキーを押したまま再度クリックしてください。';
$string['acp_coursesynccustom_category_course'] = 'ロック: コースカテゴリにより有効';

// Settings in the "Cohort sync" section of the "Sync settings" tab.
$string['settings_secthead_cohortsync'] = 'コーホート同期';
$string['settings_secthead_cohortsync_desc'] = 'この機能により、Microsoft 365グループとMoodleコーホート間の同期が可能になります。';
$string['settings_cohortsync'] = 'コーホート同期';
$string['settings_cohortsync_linktext'] = 'コーホート同期を管理する';
$string['settings_cohortsync_details'] = 'MoodleコーホートとMicrosoft 365グループ間の同期を確認および管理します。';
$string['settings_cohortsync_title'] = 'コーホート同期';
$string['settings_cohortsync_excludeowners'] = 'グループ所有者をコーホート同期から除外する';
$string['settings_cohortsync_excludeowners_desc'] = '有効にした場合、グループ所有者は、グループメンバーでもある場合であっても、Moodleコーホートに同期されません。すでにコーホートに含まれている所有者は、次回の同期実行時に削除されます。';

// Settings in the "Team / group names" section of the "Sync settings" tab.
$string['settings_secthead_team_group_name'] = 'チーム / グループ名';
$string['settings_secthead_team_group_name_desc'] = 'コースが同期対象に設定されている場合、チームとグループの名前は次のように構成されます。<br/>
<ul>
<li>グループのメールエイリアスとチームの表示名を定義できます。</li>
<li>最初に、設定されたグループのmailNicknameとチーム表示名を使用してMicrosoft 365グループが作成され、そのグループからチームが作成されます。</li>
<li>Microsoft 365グループに対してMicrosoft Entra IDの名前付けポリシーが使用されている場合、設定に従って作成された表示名がポリシーに一致しないと、グループは作成されません。</li>
<li>ここでの変更は今後のチーム作成にのみ影響し、既存のチームには影響しません。</li>
<li>グループのメールエイリアスからはすべてのスペースが削除されます。</li>
<li>グループのメールエイリアスには、英大文字・小文字、数字、- および _ のみ使用できます。</li>
<li>グループのメールエイリアスは、プレフィックスとサフィックスを含めて64文字を超えることはできません。</li>
<li>グループのメールエイリアスは一意である必要があります。一意でない場合は、一意性を確保するためにランダムな4桁の数字が付加されます。</li>
</ul>';
$string['settings_team_name_prefix'] = 'チーム名のプレフィックス';
$string['settings_team_name_prefix_desc'] = '';
$string['settings_team_name_course'] = 'チーム名のコース部分';
$string['settings_team_name_course_desc'] = '';
$string['settings_team_name_suffix'] = 'チーム名のサフィックス';
$string['settings_team_name_suffix_desc'] = '';
$string['settings_group_mail_alias_prefix'] = 'グループのメールエイリアスのプレフィックス';
$string['settings_group_mail_alias_prefix_desc'] = '';
$string['settings_group_mail_alias_course'] = 'グループのメールエイリアスのコース部分';
$string['settings_group_mail_alias_course_desc'] = '';
$string['settings_group_mail_alias_suffix'] = 'グループのメールエイリアスのサフィックス';
$string['settings_group_mail_alias_suffix_desc'] = '';
$string['settings_team_name_sample'] = 'コースが次のとおりであると仮定します:
<ul>
<li>長いコース名: <b>Sample course</b></li>
<li>短いコース名: <b>sample 15</b></li>
<li>Moodleが作成したID: <b>2</b></li>
<li>IDナンバー: <b>Sample ID 15</b></li>
</ul>
現在の設定では、メールエイリアス「<b>{$a->mailalias}</b>」を使用したグループと、名前「<b>{$a->teamname}</b>」を使用したチームが作成されます。<br/>
設定によってこれがどのように変わるかを確認するには、下の「変更を保存する」ボタンをクリックしてください。';
$string['settings_main_name_option_full_name'] = '長いコース名';
$string['settings_main_name_option_short_name'] = '短いコース名';
$string['settings_main_name_option_id'] = 'Moodleが作成したID';
$string['settings_main_name_option_id_number'] = 'IDナンバー';
$string['settings_team_name_sync'] = 'コース更新時にチーム名を更新する';
$string['settings_team_name_sync_desc'] = '有効にした場合、Moodleコースが更新されると、最新のTeams名設定に従ってチーム名が更新されます。';

// Settings in the "Course request" section of the "Sync settings" tab.
$string['settings_secthead_course_request'] = 'コースリクエスト';
$string['settings_secthead_course_request_desc'] = 'Teamsからのコースリクエスト機能におけるロールマッピングの設定です。';
$string['settings_course_request_enrolment_owner_role'] = 'チーム所有者ロール';
$string['settings_course_request_enrolment_owner_role_desc'] = 'コースリクエストが承認された場合に、チーム所有者に割り当てられるロールです。';
$string['settings_course_request_enrolment_member_role'] = 'チームメンバーロール';
$string['settings_course_request_enrolment_member_role_desc'] = 'コースリクエストが承認された場合に、チームメンバーに割り当てられるロールです。';

// Settings section headings of the "Advanced" tab.
$string['settings_header_tools'] = 'ツール';
$string['settings_secthead_calsync'] = 'カレンダー同期';
$string['settings_calsyncsubscribemode'] = 'カレンダー同期の購読';
$string['settings_calsyncsubscribemode_details'] = 'ユーザが自分でOutlookカレンダー同期をオンにする必要があるかどうかを制御します。<ul><li><b>オプトイン</b>: ユーザは、カレンダー同期設定ページでカレンダー同期を有効にし、同期するカレンダーにチェックを入れます。</li><li><b>オプトアウト</b>: Microsoft 365に接続されたユーザは、カレンダー同期が自動的に有効になり、以下で選択したカレンダー (コースの場合は、現在および将来登録されるすべてのコース) が購読され、MoodleからプライマリOutlookカレンダーへ同期されます。ユーザは引き続きカレンダー同期設定ページでこれを変更またはオフにでき、カレンダー同期をオフにしたユーザが再度購読されることはありません。</li></ul>「オプトイン」に戻しても、既存の購読は削除されません。';
$string['settings_calsyncsubscribetypes'] = 'ユーザを自動的に購読させるカレンダー';
$string['settings_calsyncsubscribetypes_details'] = '「オプトアウト」の場合にのみ適用されます。接続されたユーザを自動的に購読させるMoodleカレンダーを選択してください。全員をサイトカレンダーに購読させると、すべてのユーザが各サイトイベントの出席者として追加されるため、デフォルトでは選択されていません。';
$string['settings_calsyncsubscribetypes_site'] = 'サイトカレンダー';
$string['settings_calsyncsubscribetypes_user'] = '個人カレンダー';
$string['settings_calsyncsubscribetypes_course'] = 'コースカレンダー (ユーザが登録されているすべてのコース)';
$string['settings_calsyncsubscribemode_optin'] = 'オプトイン (ユーザが自分でカレンダー同期を有効にする)';
$string['settings_calsyncsubscribemode_optout'] = 'オプトアウト (接続されたすべてのユーザに対してカレンダー同期を自動的に有効にする)';
$string['settings_secthead_advanced'] = '詳細設定';
$string['settings_secthead_advanced_desc'] = 'これらの設定は、プラグインスイートのその他の機能を制御します。ご注意ください! 意図しない影響が生じる可能性があります。';

// Settings in the "Tools" section of the "Advanced" tab.
$string['settings_tools_tenants'] = 'テナント';
$string['settings_tools_tenants_linktext'] = '追加テナントを設定する';
$string['settings_tools_tenants_details'] = '追加のMicrosoft Entraテナントへのアクセスを管理します。';
$string['settings_healthcheck'] = '状態チェック';
$string['settings_healthcheck_details'] = '何かが正しく機能していない場合、状態チェックを実行することで通常は問題を特定し、解決策を提示できます。';
$string['settings_healthcheck_linktext'] = '状態チェックを実行する';
$string['settings_userconnections'] = 'ユーザ接続';
$string['settings_userconnections_linktext'] = 'ユーザ接続を管理する';
$string['settings_userconnections_details'] = 'MoodleユーザとMicrosoft 365ユーザ間の接続を確認および管理します。';
$string['settings_teamconnections'] = 'チーム接続';
$string['settings_teamconnections_linktext'] = 'チーム接続を管理する';
$string['settings_teamconnections_details'] = 'MoodleコースとMicrosoft Teams間の接続を確認および管理します。';
$string['settings_usermatch'] = 'ユーザマッチング';
$string['settings_usermatch_details'] = 'このツールを使用すると、アップロードしたカスタムデータファイルに基づいて、MoodleユーザとMicrosoft 365ユーザを照合できます。';
$string['settings_usersyncgroupfilter'] = 'ユーザ同期グループフィルタ';
$string['settings_usersyncgroupfilter_details'] = 'ここにグループオブジェクトID (GUID) を入力した場合、完全ユーザ同期はそのMicrosoft 365グループのメンバーと所有者に制限されます。テナント内のライセンスが付与されたすべてのユーザを同期するには、空白のままにしてください。<br><br>
<strong>注意: これは高度な設定です。設定を誤ると、データ同期に重大な問題が発生する可能性があります。</strong><br><br>
<strong>設定した場合、次のことが適用されます:</strong><br>
(1) プロファイルの更新、タイムゾーンの更新、写真の更新は、グループのメンバーまたは所有者であるユーザにのみ適用されます<br>
(2) 新しいMoodleアカウントは、グループのメンバーまたは所有者であるユーザに対してのみ作成されます<br>
(3) メンバーではないユーザのMoodleアカウントは更新されなくなり、Microsoft 365と同期されない状態になる可能性があります<br>
(4) Microsoft 365で無効にされたユーザは、グループフィルタリングとは独立して実行される有効状態の同期によって、引き続きMoodleで一時停止されます<br>
(5) ユーザをグループから削除すると、そのアカウントの今後の同期は停止されます。Moodleアカウントは削除されず、「設定されたユーザ同期グループに属していない場合、Moodleのアカウントを一時停止する」オプションが有効な場合にのみ一時停止されます。このオプションは、過去にグループに属していたかどうかにかかわらず、グループに属していないすべての同期済みユーザを一時停止します<br><br>
<strong>増分 (差分) 同期の制限:</strong> Microsoft Graphは、グループメンバーシップのエンドポイントに対する差分クエリをサポートしていません。この設定が設定されている場合、差分同期は増分更新の代わりにグループメンバーの完全同期を実行します。これは正しい動作ですが、通常の差分同期よりも遅くなる場合があります。<br><br>
保存する前にグループオブジェクトIDを検証してください。グループオブジェクトID (GUID) を入力してください。';
$string['settings_usersyncgroupfilter_validation_error'] = 'グループIDの形式が無効です。グループIDは有効なGUIDである必要があります (例: 550e8400-e29b-41d4-a716-446655440000)。';
$string['settings_usersynccreationrestriction'] = 'ユーザ作成の制限';
$string['settings_usersynccreationrestriction_details'] = '有効にした場合、ユーザ同期中には条件に一致するMicrosoft Entra IDユーザのみが作成されます。Microsoft 365グループメンバーシップ (グループオブジェクトID) の場合は、1つのグループオブジェクトID、またはカンマで区切った複数のグループオブジェクトIDを入力してください。';
$string['settings_usersynccreationrestriction_fieldval'] = 'フィールド値';
$string['settings_usersynccreationrestriction_o365group'] = 'Microsoft 365グループメンバーシップ (グループ名)';
$string['settings_usersynccreationrestriction_o365groupid'] = 'Microsoft 365グループメンバーシップ (グループオブジェクトID)';
$string['settings_usersynccreationrestriction_invalidgroupid'] = 'Microsoft 365グループオブジェクトID「{$a}」が見つかりませんでした。IDを確認して再度お試しください。';
$string['settings_usersynccreationrestriction_groupvalidationerror'] = 'Microsoft 365グループオブジェクトIDを検証できませんでした。IDとMicrosoft Graphの設定を確認してから、再度お試しください。';
$string['settings_usersynccreationrestriction_regex'] = '値は正規表現です';
$string['settings_maintenance'] = 'メンテナンス';
$string['settings_maintenance_details'] = 'いくつかの一般的な問題を解決するために、さまざまなメンテナンスタスクを利用できます。';
$string['settings_maintenance_linktext'] = 'メンテナンスツールを表示する';

// Settings in "Configure additional tenants" feature of the "Advanced" tab.
$string['acp_tenants_title'] = 'マルチテナンシー';
$string['acp_tenants_title_desc'] = 'このページでは、Microsoft 365からMoodleへのマルチテナントアクセスを設定できます。';
$string['acp_tenants_add'] = '新しいテナントを追加する';
$string['acp_tenants_errornotsetup'] = '追加のテナントを追加する前に、プラグインの設定プロセスを完了してください。';
$string['acp_tenants_hosttenant'] = 'ホストテナント: {$a}';
$string['acp_tenants_intro'] = '<b>マルチテナンシーの仕組み:</b><br />マルチテナンシーにより、複数のMicrosoft EntraテナントがあなたのMoodleサイトにアクセスできるようになります。<br /><br />
    設定方法は次のとおりです:
    <ol>
        <li>OpenID Connect認証プラグインを使用していないサイト管理者ユーザとしてMoodleにログインします。</li>
        <li>OpenID Connect認証プラグインの<b>認可エンドポイント</b>および<b>トークンエンドポイント</b>設定が、テナント固有ではないデフォルト設定を使用していることを確認します。</li>
        <li>MoodleでOpenID Connect認証プラグインを無効にします。(<a href="{$a}/admin/settings.php?section=manageauths">認証プラグインの管理ページ</a>を使用します。)</li>
        <li>Microsoft Entra IDに移動し、Moodle用に設定したアプリケーションを見つけます。</li>
        <li>Microsoft Entra IDアプリでマルチテナンシーを有効にし、変更を保存します。</li>
        <li>次のGraph委任アクセス権の少なくとも1つをアプリに付与します: <b>Directory.Read.All</b>、<b>Domain.Read.All</b>、または<b>Domain.ReadWrite.All</b>。組織に対する管理者の同意は必要ありません。</li>
        <li>追加テナントのMicrosoftアカウントですでにサインインしている場合は、完全にログアウトしてから再度ログインします。</li>
        <li>有効にするテナントごとに「新しいテナントを追加する」をクリックし、有効にするテナントの管理者アカウントでログインします。</li>
        <li>必要なすべてのテナントを追加したら、MoodleでOpenID Connect認証プラグインを再度有効にします。</li>
        <li>これで完了です! 今後テナントを追加するには、「新しいテナントを追加する」ボタンをクリックし、そのテナントの管理者アカウントでログインするだけです。</li>
    </ol>
    <b>重要な注意:</b> Microsoft Entra IDアプリでマルチテナンシーを有効にすると、すべてのMicrosoft Entraテナントがアプリケーションにアクセスできるようになります。ここにテナントを追加することで、Moodleへのアクセスを設定したテナントに制限できます。<b>Microsoft Entra IDアプリでマルチテナンシーを無効にする前にこのリストからすべてのテナントを削除した場合、またはリストが空の状態でMoodleのOpenID Connect認証を有効にした場合、あなたのMoodleサイトはすべてのMicrosoft Entraテナントに公開されます。</b>';
$string['acp_tenants_none'] = 'テナントが設定されていません。Microsoft Entra IDアプリでマルチテナンシーを有効にしている場合、あなたのMoodleサイトはすべてのMicrosoft 365ユーザに公開されている可能性があります。';
$string['acp_tenants_revokeaccess'] = 'アクセスを取り消す';
$string['acp_tenants_tenant'] = 'テナント';
$string['acp_tenants_actions'] = '操作';
$string['acp_tenants_delete'] = '削除';
$string['acp_tenantsadd_desc'] = '追加のテナントにアクセスを許可するには、下のボタンをクリックし、新しいテナントの管理者アカウントを使用してMicrosoft 365にログインしてください。追加テナントのリストに戻り、そこに新しいテナントが表示されます。その後、新しいテナントでMoodleを使用できるようになります。';
$string['acp_tenantsadd_linktext'] = 'Microsoft 365ログインページに進む';
$string['acp_tenants_legacy_tenants'] = 'レガシーテナント (対応が必要です)';
$string['acp_tenants_legacy_tenants_help'] = '以前に追加された以下の追加テナントは、更新されたマルチテナンシーのワークフローでは動作しない可能性があり、修正する必要があります。<br/>
上の「新しいテナントを追加する」ボタンを使用して再度追加してください。';

// Settings in the "Health check" feature of the "Advanced" tab.
$string['acp_healthcheck'] = '状態チェック';
$string['healthcheck_fixlink'] = '問題を修復するにはここをクリックしてください。';
$string['healthcheck_ratelimit_title'] = 'APIスロットリング';
$string['healthcheck_ratelimit_result_notice'] = 'Moodleサイトの負荷増加に対処するため、軽度のスロットリングが有効になりました。<br /><br />Microsoft 365のすべての機能は動作しています。これは、Microsoft 365サービスの中断を防ぐためにリクエストの間隔をわずかに空けるだけです。Moodleのアクティビティが減少すると、すべて通常に戻ります。<br />(レベル {$a->level} / 開始 {$a->timestart})';
$string['healthcheck_ratelimit_result_warning'] = 'Moodleサイトの大幅な負荷に対処するため、強化されたスロットリングが有効になりました。<br /><br />Microsoft 365のすべての機能は引き続き動作していますが、Microsoft 365へのリクエストの完了に時間がかかる場合があります。Moodleサイトのアクティビティが減少すると、すべて通常に戻ります。<br />(レベル {$a->level} / 開始 {$a->timestart})';
$string['healthcheck_ratelimit_result_disabled'] = 'レート制限機能は無効になっています。';
$string['healthcheck_ratelimit_result_passed'] = 'Microsoft 365 API呼び出しはフルスピードで実行されています。';

// Settings in the "Manage User Connections" feature of the "Advanced" tab.
$string['acp_userconnections'] = 'ユーザ接続を管理する';
$string['acp_userconnections_column_muser'] = 'Moodleユーザ';
$string['acp_userconnections_column_o365user'] = 'Microsoft 365ユーザ';
$string['acp_userconnections_column_status'] = '接続ステータス';
$string['acp_userconnections_column_actions'] = '操作';
$string['acp_userconnections_column_usinglogin'] = 'ログインを使用';
$string['acp_userconnections_column_status_help'] = '接続ステータスは、MoodleアカウントがMicrosoft 365 (Microsoft Entra ID) アカウントにどのようにリンクされているかを示します。

* **接続済み** – ユーザがMicrosoft 365アカウントでMoodleにログインして接続を完了したか、管理者がアカウントを能動的に接続しました。カレンダー同期やOneDriveなどの機能がこのユーザで動作します。
* **一致済み** – 管理者 (または一括ユーザマッチングツール) が、このMoodleユーザがどのMicrosoft 365アカウントに属するかを記録しましたが、接続はまだアクティブではありません。ユーザが初めてMicrosoft 365でログインしたときに完了します。ユーザが一致済みの状態の間は、何も同期されません。
* **同期済み** – Moodleアカウントはユーザ同期タスクによってMicrosoft Entra IDから作成されましたが、ユーザはまだログインしていません。アカウントは初回ログイン時にアクティブになります。
* **接続なし** – MoodleアカウントはどのMicrosoft 365アカウントにもリンクされていません。';
$string['acp_userconnections_column_actions_help'] = '行で利用可能な操作は、その接続ステータスによって異なります。

* **切断** – MoodleアカウントとMicrosoft 365アカウント間のリンクを削除します。ユーザはMoodleアカウントを保持しますが、再度接続するまでMicrosoft 365の機能を使用したり、Microsoft 365でログインしたりできなくなります。接続済みユーザに表示されます。
* **再同期** – スケジュールタスクを待たずに、このユーザのMicrosoft 365データ同期 (プロファイルフィールド、写真、カレンダーなど) をすぐに実行し、結果を表示します。接続済みおよび同期済みユーザに表示されます。
* **一致** – このMoodleユーザがどのMicrosoft 365アカウントに属するかを記録します。ユーザがMicrosoft 365でログインするまで、接続はアクティブになりません。接続なしのユーザに表示されます。
* **一致解除** – まだ完了していない一致を削除します。一致済みユーザに表示されます。';
$string['acp_userconnections_accountstatus_active'] = 'アクティブ';
$string['acp_userconnections_accountstatus_suspended'] = '一時停止';
$string['acp_userconnections_connectionstatus_connected'] = '接続済み';
$string['acp_userconnections_connectionstatus_matched'] = '一致済み';
$string['acp_userconnections_connectionstatus_noconnection'] = '接続なし';
$string['acp_userconnections_connectionstatus_synced'] = '同期済み';
$string['acp_userconnections_filtering_accountstatus'] = 'アカウントステータス';
$string['acp_userconnections_filtering_connectionstatus'] = '接続ステータス';
$string['acp_userconnections_filtering_muserfullname'] = 'Moodleユーザのフルネーム';
$string['acp_userconnections_filtering_musername'] = 'Moodleユーザ名';
$string['acp_userconnections_filtering_o365username'] = 'Microsoft 365ユーザ名';
$string['acp_userconnections_manualmatch_title'] = '手動ユーザマッチング';
$string['acp_userconnections_manualmatch_details'] = 'このページでは、1人のMoodleユーザを1人のMicrosoft 365ユーザと一致させることができます。';
$string['acp_userconnections_manualmatch_musername'] = 'Moodleユーザ';
$string['acp_userconnections_manualmatch_uselogin'] = 'Microsoft 365でログインする';
$string['acp_userconnections_manualmatch_o365username'] = 'Microsoft 365ユーザ名';
$string['acp_userconnections_manualmatch_error_muserconnected'] = 'このMoodleユーザは、すでにMicrosoft 365ユーザに接続されています。';
$string['acp_userconnections_manualmatch_error_muserconnected2'] = 'このMoodleユーザは、すでにMicrosoft 365ユーザに接続されています (2)';
$string['acp_userconnections_manualmatch_error_musermatched'] = 'このMoodleユーザは、すでにMicrosoft 365ユーザと一致しています';
$string['acp_userconnections_manualmatch_error_o365usermatched'] = 'このMicrosoft 365ユーザは、すでに別のMoodleユーザと一致しています';
$string['acp_userconnections_manualmatch_error_o365userconnected'] = 'このMicrosoft 365ユーザは、すでに別のMoodleユーザに接続されています';
$string['acp_userconnections_resync_nodata'] = 'このユーザに関して保存されたMicrosoft 365の情報が見つかりませんでした。';
$string['acp_userconnections_resync_notfound'] = 'データは同期されませんでした。アカウント「{$a->username}」はMicrosoft Entra IDオブジェクト {$a->objectid} にリンクされていますが、そのオブジェクトが見つかりませんでした。ユーザがMicrosoft 365で削除または無効にされたか、保存されているオブジェクトIDが古い可能性があります。';
$string['acp_userconnections_resync_nooutput'] = '再同期は変更を報告せずに終了しました。';
$string['acp_userconnections_table_disconnect'] = '切断';
$string['acp_userconnections_table_disconnect_confirmmsg'] = 'Moodleユーザ「{$a}」をMicrosoft 365から切断します。続けるには下のリンクをクリックしてください。';
$string['acp_userconnections_table_match'] = '一致';
$string['acp_userconnections_table_resync'] = '再同期';
$string['acp_userconnections_table_unmatch'] = '一致解除';
$string['acp_userconnections_table_unmatch_confirmmsg'] = 'Moodleユーザ「{$a}」とMicrosoft 365の一致を解除します。続けるには下のリンクをクリックしてください。';

// Settings in the "Manage Team Connections" feature of the "Advanced" tab.
$string['acp_teamconnections'] = 'チーム接続を管理する';
$string['acp_teamconnection'] = 'チーム接続を管理する';
$string['acp_teamconnections_actions'] = '操作';
$string['acp_teamconnections_cache_last_updated'] = 'Teamsキャッシュの最終更新日時は {$a->lastupdated} です。キャッシュを更新するには<a href="{$a->updateurl}">ここ</a>をクリックしてください。';
$string['acp_teamconnections_cache_never_updated'] = 'Teamsキャッシュは一度も更新されていません。更新するには<a href="{$a->updateurl}">ここ</a>をクリックしてください。';
$string['acp_teamconnections_connected_team'] = '接続済みチーム';
$string['acp_teamconnections_course_connected'] = 'コースはチームに正常に接続されました。';
$string['acp_teamconnections_course_disconnected'] = 'コースはチームから切断されました。';
$string['acp_teamconnections_team_linked'] = 'コースはチームにリンクされました。';
$string['acp_teamconnections_current_connection'] = '現在の接続';
$string['acp_teamconnections_exception_course_not_exist'] = '接続するコースが存在しません。';
$string['acp_teamconnections_exception_invalid_team_id'] = '無効なチームID';
$string['acp_teamconnections_exception_not_configured'] = 'Microsoft 365が完全には設定されていません。';
$string['acp_teamconnections_exception_team_already_connected'] = 'このチームはすでに別のコースに接続されています';
$string['acp_teamconnections_form_connect_course'] = 'コース {$a} のチーム接続を管理する';
$string['acp_teamconnections_form_sds_warning'] = '注: Student Data Sync (SDS) によって作成されたチームは、SDS同期と競合するため、ここで手動で接続することはできません。これらのチームは以下の検索結果から除外されています。';
$string['acp_teamconnections_form_team'] = 'チームを選択する';
$string['acp_teamconnections_form_team_noselection'] = 'チームを検索する...';
$string['acp_teamconnections_no_teams_found'] = '「{$a}」に該当するチームは見つかりませんでした';
$string['acp_teamconnections_group_only'] = ' (グループのみ)';
$string['acp_teamconnections_team_missing'] = '(チームなし)';
$string['acp_teamconnections_not_connected'] = '未接続';
$string['acp_teamconnections_sync_disabled'] = 'チーム接続を管理する前に、コース同期を有効にする必要があります。';
$string['acp_teamconnections_table_connect'] = '接続';
$string['acp_teamconnections_table_connect_to_different_team'] = '別のチームに接続する';
$string['acp_teamconnections_table_cannot_create_team_from_group'] = 'グループからチームを作成できません - 所有者がいません';
$string['acp_teamconnections_table_link_team'] = 'チーム「{$a}」へのリンク';
$string['acp_teamconnections_table_missing_team'] = 'コースは存在しないチームに接続されています。これは、次回のコース同期スケジュールタスクの実行時にクリーンアップされます。';
$string['acp_teamconnections_table_resync'] = '再同期';
$string['acp_teamconnections_table_update'] = '更新';
$string['acp_teamconnections_teams_cache_updated'] = 'Teamsキャッシュが正常に更新されました。';
$string['acp_teamconnections_no_owner'] = 'Teamsに接続するには所有者を追加してください。';
$string['acp_teamconnections_resync'] = 'チーム所有者 / メンバーを再同期する';
$string['acp_teamconnections_resync_title'] = 'コース {$a} のチーム所有者 / メンバーを再同期する';
$string['acp_teamconnections_resync_desc'] = 'コースの登録ユーザを、接続されたMicrosoft 365グループ/チームの所有者およびメンバーと比較し、不足しているユーザを追加します。チームに属しているがMoodleコースに登録されていないユーザも削除するかどうかを選択してください。';
$string['acp_teamconnections_resync_keep'] = '再同期 (追加のチームメンバーを保持する)';
$string['acp_teamconnections_resync_keep_desc'] = 'Moodleコースに登録されていて、チームに含まれていないユーザが追加されます。Moodleコースに登録されていない既存のチーム所有者 / メンバーは変更されません。';
$string['acp_teamconnections_resync_remove'] = '再同期して追加のチームメンバーを削除する';
$string['acp_teamconnections_resync_remove_desc'] = '警告: Moodleコースに登録されていないチーム所有者またはメンバーは、Microsoft Teamsで直接追加された場合であっても、チームから削除されます。';
$string['acp_teamconnections_resync_completed'] = 'チーム所有者 / メンバーが再同期されました。';
$string['acp_teamconnections_resync_failed'] = 'チーム所有者 / メンバーを再同期できませんでした。詳細は上の出力を参照してください。';
$string['acp_teamconnections_last_resync'] = '最終再同期: {$a}';
$string['acp_teamconnections_never_resynced'] = '再同期されたことはありません';

// Settings in the "User matching" feature of the "Advanced" tab.
$string['acp_usermatch'] = 'ユーザマッチング';
$string['acp_usermatch_desc'] = 'このツールを使用すると、MoodleユーザをMicrosoft 365ユーザと一致させることができます。Moodleユーザと関連するMicrosoft 365ユーザを含むファイルをアップロードすると、cronタスクがデータを検証して一致を設定します。';
$string['acp_usermatch_upload'] = 'ステップ 1: 新しい一致をアップロードする';
$string['acp_usermatch_upload_desc'] = 'MoodleユーザをMicrosoft 365ユーザと一致させるには、MoodleおよびMicrosoft 365のユーザ名を含むデータファイルをアップロードしてください。<br />
<br />
このファイルは、1行に3つの項目を含むシンプルなプレーンテキストのCSVファイルである必要があります:
<ul>
<li>Moodleユーザ名</li>
<li>Microsoft 365ユーザ名</li>
<li>1または0 (1はユーザの認証方法をOpenID Connectに変更すること、0は既存の認証方法を維持してリンクされたアカウントとして使用することを意味します)</li>
</ul>
ヘッダや追加データは含めないでください。<br />
例: <pre>moodleuser1,bob.smith@example.onmicrosoft.com,1<br />moodleuser2,john.doe@example.onmicrosoft.com,0</pre>';
$string['acp_usermatch_upload_err_badmime'] = 'タイプ {$a} はサポートされていません。プレーンテキストのCSVをアップロードしてください。';
$string['acp_usermatch_upload_err_data'] = '{$a} 行目に無効なデータが含まれていました。CSVファイルの各行には、少なくとも2つの項目 (Moodleユーザ名とMicrosoft 365ユーザ名) が必要です。';
$string['acp_usermatch_upload_err_fileopen'] = '処理するファイルを開けませんでした。Moodledataディレクトリのパーミッションは正しいですか?';
$string['acp_usermatch_upload_err_nofile'] = 'キューに追加するファイルを受信しませんでした。';
$string['acp_usermatch_upload_submit'] = 'データファイルをマッチングキューに追加する';
$string['acp_usermatch_matchqueue'] = 'ステップ 2: マッチングキュー';
$string['acp_usermatch_matchqueue_clearall'] = 'すべてクリアする';
$string['acp_usermatch_matchqueue_clearerrors'] = 'エラーをクリアする';
$string['acp_usermatch_matchqueue_clearqueued'] = 'キュー待ちをクリアする';
$string['acp_usermatch_matchqueue_clearsuccess'] = '成功をクリアする';
$string['acp_usermatch_matchqueue_column_muser'] = 'Moodleユーザ名';
$string['acp_usermatch_matchqueue_column_o365user'] = 'Microsoft 365ユーザ名';
$string['acp_usermatch_matchqueue_column_openidconnect'] = 'OpenID Connect';
$string['acp_usermatch_matchqueue_column_status'] = 'ステータス';
$string['acp_usermatch_matchqueue_desc'] = 'この表は、マッチング処理の現在のステータスを示します。<b>マッチングキューを処理する</b>スケジュールタスクが実行されるたびに、以下のユーザの一部が一括で処理されます。<br /><b>注:</b> このページは動的には更新されません。現在のステータスを表示するには、このページを再読み込みしてください。';
$string['acp_usermatch_matchqueue_empty'] = 'マッチングキューは現在空です。キューにユーザを追加するには、上のファイルピッカを使用してデータファイルをアップロードしてください。';
$string['acp_usermatch_matchqueue_status_error'] = 'エラー: {$a}';
$string['acp_usermatch_matchqueue_status_queued'] = 'キュー待ち';
$string['acp_usermatch_matchqueue_status_success'] = '成功';

// Settings in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance'] = 'メンテナンスツール';
$string['acp_maintenance_desc'] = 'これらのツールは、いくつかの一般的な問題の解決に役立ちます。';
$string['acp_maintenance_warning'] = '警告: これらは高度なツールです。内容を理解している場合にのみ使用してください。';
$string['acp_maintenance_resyncgroupusers'] = 'コースのMicrosoft 365グループのユーザを再同期する';
$string['acp_maintenance_resyncgroupusers_desc'] = 'すべてのMoodleコースに対して作成されたすべてのMicrosoft 365グループのユーザメンバーシップを再同期します。これにより、Moodleコースに登録されているすべてのユーザ、およびそのユーザのみがMicrosoft 365グループに含まれるようになります。<br /><b>注:</b> 関連するMoodleコースに登録されていないユーザをMicrosoft 365グループに追加している場合、それらのユーザは削除されます。';
$string['acp_maintenance_recreatedeletedgroups'] = '削除されたMicrosoft 365グループを再作成する';
$string['acp_maintenance_recreatedeletedgroups_desc'] = 'Moodleコースに接続されたMicrosoft 365グループのうち、手動で削除された可能性のあるものを確認し、再作成します。';
$string['acp_maintenance_debugdata'] = 'デバッグデータパッケージを生成する';
$string['acp_maintenance_debugdata_desc'] = '開発者が問題を解決するのに役立つよう、MoodleおよびMicrosoft 365環境に関するさまざまな情報を含むパッケージを生成します。開発者から依頼された場合は、このツールを実行し、ダウンロードされたファイルを送付してください。注: このパッケージには機密性の高いトークンデータは含まれていませんが、このファイルを公開したり、信頼できない第三者に送付したりしないでください。';
$string['acp_maintenance_cleandeltatoken'] = 'ユーザ同期差分トークンをクリーンアップする';
$string['acp_maintenance_cleandeltatoken_desc'] = 'ユーザ同期設定を更新した後にユーザ同期が完全に機能しない場合、古い差分同期トークンが原因である可能性があります。トークンをクリーンアップすると、次回ユーザ同期が実行されるときに完全な再同期が強制されます。';
$string['acp_maintenance_cleanapptokens'] = 'アプリケーショントークンをクリーンアップする';
$string['acp_maintenance_cleanapptokens_desc'] = '保存されているアプリケーショントークンを削除します。アプリケーショントークンは、ユーザとして実行されないMicrosoft APIの呼び出しにプラグインが使用するものです。新しいアプリケーショントークンは次に必要になったときに自動的に要求され、「設定」タブでの最後の「設定を確認する」チェックの結果はクリアされます。アプリケーションアクセス権で行われた呼び出しが認証エラーで失敗する場合 (たとえば、Microsoft Entra IDアプリケーションのアクセス権またはその認証情報が変更された後など)、トークンをクリーンアップすると解決する場合があります。ユーザのトークンには影響しません。';

// Settings in the "Resync users in Microsoft 365 groups for courses" feature in the "Maintenance Tools" feature of the
// "Advanced" tab.
$string['acp_maintenance_resyncgroupusers_course_output'] = '再同期の出力';
$string['acp_maintenance_resyncgroupusers_no_course'] = 'Microsoft 365に接続されたコースはありません';
$string['acp_maintenance_coursesync_disabled'] = 'このツールは、コース同期が有効な場合にのみ利用できます。<a href="{$a}">コース同期を管理する</a>。';

// Settings in the "Recreate deleted Microsoft 365 groups" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_recreatedeletedgroups_group_type'] = 'Moodleオブジェクトタイプ';
$string['acp_maintenance_recreatedeletedgroups_group_type_course'] = 'コース';
$string['acp_maintenance_recreatedeletedgroups_group_type_course_group'] = 'コースグループ';
$string['acp_maintenance_recreatedeletedgroups_course'] = 'コース';
$string['acp_maintenance_recreatedeletedgroups_course_group'] = 'コースグループ';
$string['acp_maintenance_recreatedeletedgroups_status'] = 'ステータス';
$string['acp_maintenance_recreatedeletedgroups_status_sync_disabled'] = 'コース同期は無効です';
$string['acp_maintenance_recreatedeletedgroups_status_created_success'] = 'グループが再作成されました';
$string['acp_maintenance_recreatedeletedgroups_status_created_fail'] = 'グループの再作成に失敗しました';
$string['acp_maintenance_recreatedeletedgroups_all_groups_exist'] = 'Moodleコースおよびコースグループに接続されたすべてのグループが存在します。';

// Settings in the "Cleanup User Sync Delta Tokens" feature in the "Maintenance Tools" feature of the "Advanced" tab.
$string['acp_maintenance_cleandeltatoken_completed'] = 'ユーザ同期の差分トークンおよびスキップ差分トークンがクリーンアップされました。';
$string['acp_maintenance_cleanapptokens_confirm'] = '本当にアプリケーショントークンをクリーンアップしてもよろしいですか? 現在 {$a} 個のアプリケーショントークンが保存されています。';
$string['acp_maintenance_cleanapptokens_completed'] = 'アプリケーショントークンおよび最後の「設定を確認する」の結果がクリーンアップされました。';

// Settings "Advanced settings" section of the "Advanced" tab.
$string['settings_course_reset_teams'] = 'コースリセット時のチーム/グループ操作';
$string['settings_course_reset_teams_details'] = 'コースがリセットされた場合に、コースに接続されたチームまたはグループに対して実行する操作です。';
$string['settings_course_reset_teams_option_do_nothing'] = '何もしない<br/>チームまたはグループはコースに接続されたままです。ユーザの登録解除により、ユーザのチームまたはグループのメンバーシップが削除されます。';
$string['settings_course_reset_teams_option_per_course'] = 'コースごとの設定を許可する<br/>コースにMicrosoftブロックを追加する必要があります。コースをリセットするケイパビリティを持つユーザは、コースリセット時に行う操作をブロックで選択できます。';
$string['settings_course_reset_teams_option_force_archive'] = 'コースをチームまたはグループから切断し、新しいものを作成する<br/>コースに接続されている既存のチームまたはグループは、設定に従って名前が変更されます。チームが接続されている場合は、アーカイブされます。新しいチームまたはグループが作成され、コースに接続されます。';
$string['settings_course_reset_teams_option_archive_only'] = 'コースをチームまたはグループから切断するのみ<br />コースに接続されている既存のチームまたはグループは、設定に従って名前が変更されます。チームが接続されている場合は、アーカイブされます。新しいチームまたはグループは作成されません。';
$string['settings_reset_team_name_prefix'] = 'リセット時のチーム名プレフィックス';
$string['settings_reset_team_name_prefix_details'] = 'チームに接続されたコースをリセットする場合、接続されている既存のチームの名前の前にこれが付加されます。';
$string['settings_reset_group_name_prefix'] = 'リセット時のグループ名プレフィックス';
$string['settings_reset_group_name_prefix_details'] = 'グループに接続されたコースをリセットする場合、既存のグループの名前の前にこれが付加されます。';
$string['settings_calsync_courseeventmode'] = 'コースカレンダーイベントのOutlookイベント';
$string['settings_calsync_courseeventmode_details'] = 'コースカレンダーを購読しているユーザに対して、MoodleのコースカレンダーイベントをOutlookでどのように作成するかを制御します。
<ul>
<li><strong>コースユーザを出席者とする1つの共有イベント:</strong> Moodleイベントを作成したユーザのOutlookカレンダー (コースがグループにリンクされている場合はコースのMicrosoft 365グループカレンダー) に1つのイベントが作成され、コースユーザが出席者として追加されます。</li>
<li><strong>ユーザごとに1つの個別イベント:</strong> 購読している各ユーザ自身のOutlookカレンダーに、個別のイベントが直接作成されます。共有イベントや出席者リストはなく、Microsoft 365グループカレンダーにも何も追加されません。</li>
</ul>
この設定の変更は、変更後に同期されるイベントにのみ影響します。すでにOutlookにあるイベントは変換されません。';
$string['settings_calsync_courseeventmode_shared'] = 'コースユーザを出席者とする1つの共有イベント';
$string['settings_calsync_courseeventmode_individual'] = 'ユーザごとに1つの個別イベント';
$string['settings_debugmode'] = 'デバッグメッセージを記録する';
$string['settings_debugmode_details'] = 'この機能を有効にすると、問題の特定に役立つ情報がMoodleログに記録されます。<a href="{$a}">記録されたログメッセージを表示する。</a>';
$string['settings_switchauthminupnsplit0'] = 'Microsoft 365に切り替える不完全一致ユーザ名の最小長';
$string['settings_switchauthminupnsplit0_details'] = '「一致したユーザをMicrosoft 365 (OpenID Connect) 認証に切り替える」設定を有効にした場合、この設定は、切り替え対象となるテナント部分 (@example.onmicrosoft.com の部分) を除いたユーザ名の最小長を設定します。これにより、「admin」のような、MoodleとMicrosoft Entra IDで必ずしも同一とは限らない汎用的な名前のアカウントの切り替えを回避できます。ユーザ名の長さに関係なく一致したユーザを切り替えるには、0に設定してください。この設定のために認証方法が切り替えられなかったユーザは、同期タスクの出力に 「Matched user, but the username is not an exact match to the Microsoft Entra ID UPN and does not meet the exact-match requirements for switching to OIDC...」 と記録され、「ユーザ接続を管理する」ページでは 「Matched with existing user - Awaiting completion」 と表示されます。';
$string['settings_customtheme'] = 'カスタムテーマ (詳細)';
$string['settings_customtheme_desc'] = '推奨テーマは「boost_o365teams」です。ただし、Teamsタブで使用するよう調整されたカスタムテーマがある場合は、別のテーマを選択できます。<br/>
コースまたはカテゴリレベルで設定されたカスタムテーマは、ここでの設定より優先されることにご注意ください。つまり、Teams内のMoodleアプリでは、デフォルトでコースまたはカテゴリのテーマが使用されます。これは、config.phpの$CFG->themeorderを "array(\'session\', \'course\', \'category\', \'user\', \'cohort\', \'site\');" に更新することで修正できます。';

// Settings in the "SDS sync" tab.
$string['settings_sds_intro_previewwarning'] = '<div class="alert"><b>これはプレビュー機能です</b><br />プレビュー機能は、意図したとおりに動作しなかったり、予告なく動作しなくなったりする場合があります。慎重に進めてください。</div>';
$string['settings_sds_intro_desc'] = 'Microsoft School Data Sync (「SDS」) は、外部のSISから名簿を読み取り、Microsoft 365にクラスとグループを作成することで、Microsoft 365でのクラス管理を簡素化します。<a href="https://sds.microsoft.com/" target="_blank">詳細はこちら</a><br/>
<br/>
SDS同期機能は、クラス、教師、学生を含む名簿データをSDSからMoodleに同期できます。<br/>
<br/>
SDS同期機能を使用するには、統合に使用するMicrosoft Entra IDアプリに、<b>EduRoster.Read.All</b>および<b>Member.Read.Hidden</b>のMicrosoft Graphアプリケーションアクセス権があることを確認してください。これらはデフォルトの設定では自動的に追加されません。これらに対しても管理者の同意を与える必要があります。<br/>
<br/>
デフォルトでは、SDS同期処理はMoodle cronで毎日サーバ時刻の午前3時に実行されます。このスケジュールを変更するには、<a href="{$a}">スケジュールタスク管理ページ</a>にアクセスしてください。<br/><br/>';
$string['settings_sds_coursecreation'] = 'クラスからコースへの同期';
$string['settings_sds_coursecreation_desc'] = 'これらのオプションは、SDSの学校クラスに基づくMoodleコースの作成を制御します。';
$string['settings_sds_coursecreation_enabled'] = '同期する学校';
$string['settings_sds_coursecreation_enabled_desc'] = 'これらの学校のクラスに対してコースを作成します。';
$string['settings_sds_teams_enabled'] = 'SDSクラスにはすでにチームがありますか?';
$string['settings_sds_teams_enabled_desc'] = 'SDSの設定によってSDSクラスのチームがすでに作成されている場合は、これをチェックしてください。チェックした場合、競合を避けるため、MoodleはSDSクラスから作成されたMoodleコースからチームを作成しません。';
$string['settings_sds_courseenrolsync'] = 'コース登録同期';
$string['settings_sds_courseenrolsync_desc'] = 'これらのオプションは、SDSの学校クラスからのコース登録の同期を制御します。';
$string['settings_sds_enrolment_enabled'] = 'SDSからMoodleに登録を同期する';
$string['settings_sds_enrolment_enabled_desc'] = '有効にした場合、SDS同期スケジュールタスクは、SDSクラスの教師と学生を対応するMoodleコースに登録し、SDSクラスに含まれなくなったユーザを削除します。<b>MoodleでのSDSクラス教師ロール</b>および<b>MoodleでのSDSクラス学生ロール</b>を設定する必要があります。';
$string['settings_sds_sync_enrolment_to_sds'] = 'MoodleからSDSに登録を同期する';
$string['settings_sds_sync_enrolment_to_sds_desc'] = '有効にした場合、SDSクラスに接続されたMoodleコースで行われた登録の変更が、SDSクラスに同期されます。SDSにおけるユーザの所有者 / メンバーのステータスは、コースコンテキストにおける「local/o365:teamowner」および「local/o365:teammember」ケイパビリティによって決まります。';
$string['settings_sds_suspend_enrolment'] = '登録解除の代わりにユーザ登録を一時停止する';
$string['settings_sds_suspend_enrolment_desc'] = 'このオプションを有効にした場合、SDSクラスから削除されたユーザは、完全に登録解除されるのではなく、接続されたMoodleコースでの登録が一時停止されます。これにより、評点、提出、活動完了などのユーザデータが保持されます。ユーザがSDSクラスに再度追加されると、登録は自動的に再開されます。<br />
<b>注:</b> 教師がSDS同期によって登録の一時停止または登録解除されることはありません。この設定は学生にのみ影響します。';
$string['settings_sds_enable_course_sync'] = '双方向のコース同期を有効にする';
$string['settings_sds_enable_course_sync_desc'] = '有効にした場合、SDSクラスから作成された各MoodleコースはデータベースでそのMicrosoft 365グループにリンクされ、そのコースに対してMicrosoft 365コース同期の完全な統合 (Teams、ファイル、カレンダーなど) が有効になります。SDSクラスにすでにチームがある場合は、Teamsの関連付けレコードも作成されます。';
$string['settings_sds_course_field_mailnickname'] = 'メールニックネーム (mailNickname)';
$string['settings_sds_course_field_displayname'] = '表示名 (displayName)';
$string['settings_sds_course_field_classcode'] = 'クラスコード (classCode)';
$string['settings_sds_course_field_externalname'] = '外部名 (externalName)';
$string['settings_sds_course_shortname_field'] = '短いコース名のソース';
$string['settings_sds_course_shortname_field_desc'] = '新しく作成されるMoodleコースの短いコース名として使用されるSDSクラスのプロパティです。Moodleでは短いコース名が一意である必要があります。選択したプロパティが空の場合、またはその値が別のSDSクラスにリンクされたコースですでに使用されている場合は、代わりにメールニックネームが使用されます。この設定を変更しても、すでに作成されたコースの名前は変更されません。';
$string['settings_sds_course_fullname_field'] = '長いコース名のソース';
$string['settings_sds_course_fullname_field_desc'] = '新しく作成されるMoodleコースの長いコース名として使用されるSDSクラスのプロパティです。選択したプロパティが空の場合は、代わりに表示名が使用されます。この設定を変更しても、すでに作成されたコースの名前は変更されません。';
$string['settings_sds_categorize_by_subject'] = 'コースを教科別に分類する';
$string['settings_sds_categorize_by_subject_desc'] = '有効にした場合、コースは各学校カテゴリ内の教科ベースのカテゴリに整理されます。教科名はSDSのクラス情報から抽出されます。無効にした場合、すべてのコースは学校カテゴリに直接配置されます。';
$string['settings_sds_ignore_past_courses'] = '期限切れ/過去のクラスを無視する';
$string['settings_sds_ignore_past_courses_desc'] = '有効にした場合、期限切れまたは終了したクラスは同期中にスキップされます。これには次のものが含まれます:<br />
<ul>
<li>名前に設定された期限切れプレフィックス (デフォルト: 「Exp」) が付いているクラス</li>
<li>終了日が過去のクラス</li>
</ul>
これにより、古いクラスやアーカイブされたクラスに対してコースが作成されず、コースカタログを整理された状態に保つことができます。';
$string['settings_sds_expired_course_prefix'] = '期限切れクラス名のプレフィックス';
$string['settings_sds_expired_course_prefix_desc'] = 'このプレフィックスで始まるクラス名は期限切れとみなされ、同期中にスキップされます (「期限切れ/過去のクラスを無視する」が有効な場合)。デフォルト: 「Exp」';
$string['settings_sds_cohortsync'] = 'コーホート同期';
$string['settings_sds_cohortsync_desc'] = 'これらのオプションは、SDSクラスからのコーホートの作成と同期を制御します。コーホートは、サイト全体の登録やその他のMoodle機能に使用できる、ユーザをグループ化する別の方法を提供します。';
$string['settings_sds_create_cohorts'] = 'SDSクラスからコーホートを作成する';
$string['settings_sds_create_cohorts_desc'] = '有効にした場合、SDSクラスごとにコーホートが作成され、メンバーシップはSDSクラスと同期された状態に保たれます。コーホートは、コースカテゴリ (分類の設定に応じて学校または教科のカテゴリ) のコンテキストで作成されます。<br />
<b>注:</b> コーホートはコースの代わりではなく、コースに加えて作成されます。これにより、SDSと同期したコースを維持しながら、サイト全体の登録やグループ化にコーホートを使用できます。';
$string['settings_sds_cohort_include_teachers'] = 'コーホートに教師を含める';
$string['settings_sds_cohort_include_teachers_desc'] = '有効にした場合、SDSクラスの教師が学生とともにコーホートに追加されます。無効にした場合、学生のみがコーホートに追加されます。';
$string['settings_sds_enrolment_teacher_role'] = 'MoodleでのSDSクラス教師ロール';
$string['settings_sds_enrolment_teacher_role_desc'] = '「SDSからMoodleに登録を同期する」が有効な場合、SDSクラスの教師は、このロールで接続されたMoodleコースに登録されます。';
$string['settings_sds_enrolment_student_role'] = 'MoodleでのSDSクラス学生ロール';
$string['settings_sds_enrolment_student_role_desc'] = '「SDSからMoodleに登録を同期する」が有効な場合、SDSクラスの学生は、このロールで接続されたMoodleコースに登録されます。';
$string['settings_sds_profilesync_header'] = 'ユーザプロファイル同期';
$string['settings_sds_profilesync_header_desc'] = '各SDS学校は、学校の教師およびメンバーのユーザプロファイルを保存している場合があります。このフィールドは学校固有です。つまり、同じユーザの同じフィールドでも、学校によって値が異なる場合があります。<br/>
このセクションで学校が選択されている場合、SDSユーザプロファイルフィールドをユーザフィールドマッピングで設定できます。
<ul>
<li>SDSフィールドの同期は「SDSと同期する」スケジュールタスクの実行時にのみ行われ、「ユーザをMicrosoft Entra IDから同期する」スケジュールタスクの実行時やユーザのログイン時には行われないことにご注意ください。</li>
<li>この機能で使用されるMicrosoft Graph APIには、特定の学生および教師の学校プロファイルフィールドが返されないという既知の問題があり、そのため設定されていても同期できないことにご注意ください。</li>
</ul>
';
$string['settings_sds_profilesync_disabled'] = '無効';
$string['settings_sds_profilesync'] = '学校からプロファイルデータを同期する';
$string['settings_sds_profilesync_desc'] = 'MoodleがSDS固有のプロファイルデータを同期するSDS学校を選択してください。';
$string['settings_sds_noschools'] = '<div class="alert alert-info">SDSで利用可能な学校がありません。</div>';
$string['settings_sds_get_schools_error'] = '<div class="alert alert-info error">SDSの学校の取得に失敗しました。Microsoft Entra IDアプリに必要なアクセス権があることを確認してください。</div>';
$string['settings_sds_school_disabled_action'] = '学校同期無効時の操作';
$string['settings_sds_school_disabled_action_desc'] = 'SDS学校で同期が無効にされた場合に、すでに接続されているMoodleコースに対して行う操作です。';
$string['settings_sds_school_disabled_action_keep_connected'] = 'Moodleコースをチームに接続したままにする';
$string['settings_sds_school_disabled_action_disconnect'] = 'Moodleコースをチームから切断する';
$string['settings_sds_school_unavailable'] = '{$a} (SDSの学校リストは現在利用できません)';

// Settings in the "Teams Settings" tab.
$string['settings_teams_banner'] = '<a href="https://aka.ms/MoodleLearnTeams" target="_blank">Microsoft Teams</a>用Moodleアプリを使用すると、Teams内でMoodleコースに簡単にアクセスし、コラボレーションできます。';
$string['settings_teams_moodle_setup_heading'] = '<h4 class="local_o365_settings_teams_h4_spacer">Microsoft Teams用Moodleアプリを設定する</h4>';
$string['settings_moodlesettingssetup'] = 'Moodleを設定する';
$string['settings_check_moodle_settings'] = 'Moodle設定を確認する';
$string['settings_moodlesetup_checking'] = '確認しています...';
$string['settings_notice_cookiesecureenabled'] = 'セキュアクッキーのみが正常に有効にされました';
$string['settings_notice_cookiesecurealreadyenabled'] = 'セキュアクッキーのみはすでに有効でした';
$string['settings_notice_oidcenabled'] = 'OpenID Connectが正常に有効にされました';
$string['settings_notice_oidcnotenabled'] = 'OpenID Connectを有効にできませんでした';
$string['settings_notice_oidcalreadyenabled'] = 'OpenID Connectはすでに有効でした';
$string['settings_notice_webservicesframealreadyenabled'] = 'ウェブサービスはすでに有効で、フレーム埋め込みも許可されています';
$string['settings_notice_webservicesframeenabled'] = 'ウェブサービスが正常に有効にされ、フレーム埋め込みも許可されるようになりました';
$string['settings_notice_restenabled'] = 'RESTプロトコルが正常に有効にされました';
$string['settings_notice_restnotenabled'] = 'RESTプロトコルを有効にできませんでした';
$string['settings_notice_restalreadyenabled'] = 'RESTプロトコルはすでに有効でした';
$string['settings_notice_o365serviceenabled'] = 'Microsoft 365ウェブサービスが正常に有効にされました';
$string['settings_notice_o365servicealreadyenabled'] = 'Microsoft 365ウェブサービスはすでに有効でした';
$string['settings_notice_createtokenallowed'] = 'ウェブサービストークンを作成するパーミッションが付与されました';
$string['settings_notice_createtokenalreadyallowed'] = 'ウェブサービストークンを作成するパーミッションはすでに付与されていました';
$string['settings_notice_createtokennotallowed'] = 'ウェブサービストークンを作成するパーミッションの付与中に問題が発生しました';
$string['settings_notice_restusageallowed'] = 'RESTプロトコルを使用するパーミッションが付与されました';
$string['settings_notice_restusagealreadyallowed'] = 'RESTプロトコルを使用するパーミッションはすでに付与されていました';
$string['settings_notice_restusagenotallowed'] = 'RESTプロトコルを使用するパーミッションの付与中に問題が発生しました';
$string['settings_moodlesettingssetup_details'] = 'これにより、次のことが確認されます:
<ul class="local_o365_settings_teams_horizontal_spacer">
<li>セキュアクッキーのみが有効になっている。</li>
<li>OpenID Connectが有効になっている。</li>
<li>フレーム埋め込みが有効になっている。</li>
<li>ウェブサービスが有効になっている。</li>
<li>RESTプロトコルが有効になっている。</li>
<li>Microsoft 365ウェブサービスが有効になっている。</li>
<li>認証済みユーザがウェブサービストークンを作成するパーミッションを持っている。</li>
<li>認証済みユーザがRESTプロトコルを使用するパーミッションを持っている。</li>
</ul>';
$string['settings_teams_moodle_app_external_id'] = 'Moodle Teamsアプリ用のMicrosoftアプリID';
$string['settings_teams_moodle_app_external_id_desc'] = 'テナント内で異なるMoodleサイトに接続するために複数のMoodle Teamsアプリが必要な場合を除き、これはデフォルト値に設定してください。';
$string['settings_teams_moodle_app_short_name'] = 'Teamsアプリ名';
$string['settings_teams_moodle_app_short_name_desc'] = 'テナント内で異なるMoodleサイトに接続するために複数のMoodle Teamsアプリが必要な場合を除き、これはデフォルトのままで構いません。';
$string['settings_download_teams_tab_app_manifest'] = 'マニフェストファイルをダウンロードする';
$string['settings_download_teams_tab_app_manifest_reminder'] = 'マニフェストをダウンロードする前に、すべての変更を保存してください。';
$string['settings_publish_manifest_instruction'] = 'ダウンロードしたMoodleアプリのマニフェストファイルをTeamsのすべてのユーザに公開する方法については、<a href="https://learn.microsoft.com/en-us/microsoftteams/platform/concepts/apps/apps-upload" target="_blank">こちらをクリック</a>してください。';
$string['settings_teams_moodle_tab_name'] = 'TeamsでのMoodleタブ名';
$string['settings_teams_moodle_tab_name_desc'] = 'これはTeamsでのMoodleタブの名前です。';

// Settings in the "Teams Moodle app" tab.
$string['settings_moodle_app_id'] = 'MoodleアプリID';
$string['settings_moodle_app_id_desc'] = 'TeamsアプリカタログにアップロードされたMoodleアプリのIDです。<br/>
設定した場合、Moodleは、作成/接続されたチームの「一般」チャネルに、MoodleコースにリンクするMoodleタブの作成を試みます。';
$string['settings_moodle_app_id_desc_auto_id'] = '<br/>
自動的に検出された値は「<span class="local_o365_settings_moodle_app_id">{$a}</span>」です。';
$string['settings_set_moodle_app_id_instruction'] = 'MoodleアプリIDを手動で確認するには、次の手順に従ってください:
<ol>
<li>ダウンロードしたマニフェストファイルを、テナントのTeamsアプリカタログにアップロードします。</li>
<li>Teamsアプリカタログで、アプリを見つけます。</li>
<li>アプリの画像の右上隅にある、アプリのオプションアイコンをクリックします。</li>
<li>「リンクをコピー」をクリックします。</li>
<li>テキストエディタに、コピーした内容を貼り付けます。次のようなURLが含まれているはずです: https://teams.microsoft.com/l/app/00112233-4455-6677-8899-aabbccddeeff.</li>
</ol>
URLの最後の部分、つまり<span class="local_o365_settings_moodle_app_id">00112233-4455-6677-8899-aabbccddeeff</span>がアプリIDです。';

// Settings for calendar subscriptions.
$string['calendar_setting'] = 'Outlookカレンダー同期を有効にする';
$string['calendar_user'] = 'パーソナル (ユーザ) カレンダー';
$string['calendar_site'] = 'サイト全体のカレンダー';
$string['personal_calendar'] = 'パーソナル';
$string['calendar_event'] = '詳細を表示する';
$string['eventcalendarsubscribed'] = 'ユーザはカレンダーに登録しました';
$string['eventcalendarunsubscribed'] = 'ユーザはカレンダーへの登録を解除しました';

// Errors.
$string['erroracpauthoidcnotconfig'] = '初めにauth_oidcにアプリケーションの認証情報を設定してください。';
$string['errorhttpclientbadtempfileloc'] = 'ファイルを保存するための一時的な場所を開けませんでした。';
$string['errorhttpclientnofileinput'] = 'httpclient::putにファイルパラメータが指定されていません';
$string['errorcouldnotrefreshtoken'] = 'トークンを更新できませんでした';
$string['errormfarequired'] = 'MoodleがあなたのMicrosoft 365アカウントにアクセスする前に、Microsoftは多要素認証を要求しています。Moodleからログアウトし、Microsoft 365アカウントを使用して再度ログインして、多要素認証のプロンプトを完了してください。';
$string['errorgetapplicationtoken'] = 'アプリケーショントークンを取得できませんでした。統合の設定を確認してください。';
$string['erroracpapcantgettenant'] = 'Microsoft Entraテナントを取得できませんでした。手動で入力してください。';
$string['erroracpcantgettenant'] = 'OneDriveのURLを取得できませんでした。手動で入力してください。';
$string['errorprovisioningapp'] = 'チームにMoodleアプリをプロビジョニングできませんでした。';
$string['erroro365apibadcall'] = 'API呼び出しエラー。';
$string['erroro365apibadcall_message'] = 'API呼び出しエラー: {$a}';
$string['erroro365apiinvalidtoken'] = '無効または期限切れのトークン。';
$string['erroro365apiinvalidmethod'] = '無効なhttpmethodがapicallに渡されました';
$string['erroro365apinotimplemented'] = 'これは上書きする必要があります。';
$string['erroro365apinotoken'] = '所定のリソースまたはユーザのトークンがなく、取得もできませんでした。ユーザのリフレッシュトークンの有効期限が切れていませんか？';
$string['errorusermatched'] = 'Microsoft 365アカウント「{$a->entraidupn}」は、すでにMoodleユーザ「{$a->username}」と一致しています。接続を完了するには、最初にそのMoodleユーザとしてログインし、Microsoftブロックの手順に従ってください。';
$string['errornodirectaccess'] = 'このページへの直接アクセスは禁止されています';
$string['eventapifail'] = 'APIの失敗';
$string['errorunabletofindgraphapi'] = 'アプリケーションでMicrosoft Graph APIが見つかりません。';
$string['erroremptyjwt'] = '空のJWTトークンが提供されました';
$string['errornocachedjwks'] = 'キャッシュされたJWKSが見つかりません';
$string['errorfetchjwks'] = 'MicrosoftからのJWKSの取得に失敗しました';
$string['errorinvalidjwks'] = 'Microsoftから無効な形式のJWKSを受信しました';
$string['errorjwtvalidation'] = 'JWTの検証に失敗しました';
$string['errorjwtinvalidissuer'] = 'JWTの発行者の検証に失敗しました';
$string['errorcannotgettoken'] = 'アプリまたはシステムのトークンを取得できませんでした。';
$string['errornotokenforsysmemuser'] = 'システムユーザのトークンがありません。local_o365の状態チェックを実行してください。';
$string['errornotoken'] = 'ユーザ #{$a} のトークンがありません';
$string['errornotokenforusersync'] = 'ユーザ同期用のトークンがありません。';
$string['errornoapifound'] = '識別子 {$a} のAPIが見つかりません。';
$string['errornoresponsesavailable'] = '利用可能な応答がありません。';
$string['erroro365badphoto'] = 'Microsoft 365から無効なプロファイル写真を受信しました。';
$string['erroro365nophoto'] = 'このユーザにはMicrosoft 365の写真がありません。';
$string['errorcannotgetapiclient'] = 'Graph APIクライアントを取得できません。';
$string['errorfailedtogetsecrets'] = 'シークレットの取得に失敗しました。';
$string['errorfailedtosendnotification'] = '1人以上の受信者への通知メールの送信に失敗しました。';
$string['errorsecretexpiryrecipientundeliverable'] = '設定されたシークレット有効期限通知の受信者のうち、1人以上がメールを受信できません (無効なアドレス、またはMX/Aレコードのないドメイン): {$a}。OpenID Connect設定で通知の受信者を更新してください。';

// Privacy API.
$string['privacy:metadata:local_o365'] = 'Microsoft 365ローカルプラグイン';
$string['privacy:metadata:local_o365_calidmap'] = 'Microsoft 365カレンダーイベントとMoodleカレンダーイベント間のリンクに関する情報です。';
$string['privacy:metadata:local_o365_calidmap:userid'] = 'イベントを所有するユーザのIDです。';
$string['privacy:metadata:local_o365_calidmap:origin'] = 'イベントの発生元です。MoodleまたはMicrosoft 365のいずれかです。';
$string['privacy:metadata:local_o365_calidmap:outlookeventid'] = 'OutlookでのイベントのIDです。';
$string['privacy:metadata:local_o365_calidmap:eventid'] = 'MoodleでのイベントのIDです。';
$string['privacy:metadata:local_o365_calsub'] = 'MoodleとOutlookカレンダー間の同期購読に関する情報です。';
$string['privacy:metadata:local_o365_calsub:user_id'] = '購読対象のMoodleユーザのID';
$string['privacy:metadata:local_o365_calsub:caltype'] = 'Moodleカレンダーのタイプ (サイト、コース、ユーザ)';
$string['privacy:metadata:local_o365_calsub:caltypeid'] = 'Moodleカレンダーに関連付けられたID';
$string['privacy:metadata:local_o365_calsub:o365calid'] = 'Microsoft 365カレンダーのID';
$string['privacy:metadata:local_o365_calsub:isprimary'] = 'これがプライマリカレンダーかどうか';
$string['privacy:metadata:local_o365_calsub:syncbehav'] = '同期の動作 (MoodleからOutlook、またはOutlookからMoodle)';
$string['privacy:metadata:local_o365_calsub:timecreated'] = '購読が作成された時刻です。';
$string['privacy:metadata:local_o365_connections'] = 'まだ確認されていない、MoodleとMicrosoft 365ユーザ間の接続に関する情報';
$string['privacy:metadata:local_o365_connections:muserid'] = 'MoodleユーザのID';
$string['privacy:metadata:local_o365_connections:entraidupn'] = 'Microsoft Entra IDユーザのUPNです。';
$string['privacy:metadata:local_o365_connections:uselogin'] = '完了時にユーザの認証方法を切り替えるかどうかです。';
$string['privacy:metadata:local_o365_token'] = 'ユーザのMicrosoft 365 APIトークンに関する情報';
$string['privacy:metadata:local_o365_token:user_id'] = 'MoodleユーザのID';
$string['privacy:metadata:local_o365_token:scope'] = 'トークンのスコープです。';
$string['privacy:metadata:local_o365_token:tokenresource'] = 'トークンのリソースです。';
$string['privacy:metadata:local_o365_token:token'] = 'トークンです。';
$string['privacy:metadata:local_o365_token:expiry'] = 'トークンの有効期限です。';
$string['privacy:metadata:local_o365_token:refreshtoken'] = 'リフレッシュトークンです。';
$string['privacy:metadata:local_o365_objects'] = 'MoodleとMicrosoft 365オブジェクト間の関係に関する情報';
$string['privacy:metadata:local_o365_objects:type'] = 'オブジェクトのタイプ (グループ、ユーザ、コースなど)';
$string['privacy:metadata:local_o365_objects:subtype'] = 'オブジェクトのサブタイプです。';
$string['privacy:metadata:local_o365_objects:objectid'] = 'Microsoft 365のオブジェクトID';
$string['privacy:metadata:local_o365_objects:moodleid'] = 'MoodleでのオブジェクトのID';
$string['privacy:metadata:local_o365_objects:o365name'] = 'Microsoft 365でのオブジェクトの人間が読める名前';
$string['privacy:metadata:local_o365_objects:tenant'] = 'オブジェクトが属するテナント (マルチテナンシー環境)';
$string['privacy:metadata:local_o365_objects:metadata'] = '関連するメタデータ';
$string['privacy:metadata:local_o365_objects:timecreated'] = 'レコードが作成された時刻です。';
$string['privacy:metadata:local_o365_objects:timemodified'] = 'レコードが変更された時刻です。';
$string['privacy:metadata:local_o365_appassign'] = 'Microsoft 365アプリロールの割り当てに関する情報';
$string['privacy:metadata:local_o365_appassign:muserid'] = 'MoodleユーザのID';
$string['privacy:metadata:local_o365_appassign:assigned'] = 'ユーザがアプリに割り当てられているかどうか';
$string['privacy:metadata:local_o365_appassign:photoid'] = 'Microsoft 365でのユーザの写真のID';
$string['privacy:metadata:local_o365_appassign:photohash'] = 'ユーザのプロファイル写真のバイトのSHA-256ハッシュ。画像全体を再取得せずに写真の変更を検出するために保存されます';
$string['privacy:metadata:local_o365_appassign:photoupdated'] = 'Microsoft 365からユーザの写真が最後に更新された日時';
$string['privacy:metadata:local_o365_matchqueue'] = 'MoodleユーザとMicrosoft 365ユーザのマッチングに関する情報';
$string['privacy:metadata:local_o365_matchqueue:musername'] = 'Moodleユーザのユーザ名です。';
$string['privacy:metadata:local_o365_matchqueue:o365username'] = 'Microsoft 365ユーザのユーザ名です。';
$string['privacy:metadata:local_o365_matchqueue:openidconnect'] = '一致が行われたときにユーザをOpenID Connect認証に切り替えるかどうか';
$string['privacy:metadata:local_o365_matchqueue:completed'] = 'レコードが処理されたかどうか';
$string['privacy:metadata:local_o365_matchqueue:errormessage'] = 'エラーメッセージ (ある場合)';
$string['privacy:metadata:preference:suspendedtime'] = '一致するMicrosoft Entra IDアカウントが削除されたか無効にされたことにより、ユーザ同期によってユーザが一時停止された時刻です。';
$string['privacy:metadata:local_o365_calsettings'] = 'カレンダー同期設定に関する情報';
$string['privacy:metadata:local_o365_calsettings:user_id'] = 'MoodleユーザのID';
$string['privacy:metadata:local_o365_calsettings:o365calid'] = 'Microsoft 365でのカレンダーのID';
$string['privacy:metadata:local_o365_calsettings:timecreated'] = 'レコードが作成された時刻です。';
$string['privacy:metadata:preference:calsync_initialised'] = 'ユーザのOutlookカレンダー同期の選択が初期化されたかどうか。これにより、自動的に再度有効になることはありません。';

// Page "Microsoft 365 / Moodle Control Panel" in the Microsoft block.
$string['ucp_title'] = 'Microsoft 365 / Moodleコントロールパネル';
$string['ucp_general_intro'] = 'ここでMicrosoft 365への接続を管理できます。';
$string['ucp_calsync_availcal'] = '利用可能なMoodleカレンダー';
$string['ucp_calsync_title'] = 'Outlookカレンダーの同期';
$string['ucp_calsync_desc'] = 'カレンダーをチェックすると、MoodleからOutlookカレンダーに同期されます。';
$string['ucp_connection_options'] = '接続オプション:';
$string['ucp_connection_desc'] = 'ここでは、Microsoft 365への接続方法を設定できます。Microsoft 365の機能を使用するには、Microsoft 365アカウントに接続されている必要があります。これは、以下に説明する方法で行えます。';
$string['ucp_connection_entraidlogin'] = 'Microsoft 365の認証情報を使用してMoodleにログインする<br />';
$string['ucp_connection_entraidlogin_desc_authcode'] = 'Moodleのログインページでユーザ名とパスワードを入力する代わりに、ログインページに「{$a} のアカウントを使用してログイン」というセクションが表示されます。そのリンクをクリックすると、Microsoft 365にリダイレクトされてログインします。Microsoft 365へのログインに成功すると、Moodleに戻り、あなたのアカウントでログインされます。';
$string['ucp_connection_entraidlogin_start'] = 'Microsoft 365を使用してMoodleにログインし始める。';
$string['ucp_connection_entraidlogin_stop'] = 'Microsoft 365を使用してMoodleにログインするのをやめる。';
$string['ucp_connection_entraidlogin_active'] = 'Microsoft 365アカウント「{$a}」を使用してMoodleにログインしています。';
$string['ucp_connection_linked'] = 'MoodleアカウントとMicrosoft 365アカウントをリンクする';
$string['ucp_connection_linked_desc'] = 'MoodleアカウントとMicrosoft 365アカウントをリンクすると、Moodleへのログイン方法を変更することなく、Microsoft 365のMoodle機能を使用できます。<br />以下のリンクをクリックすると、Microsoft 365に移動して一度だけログインを行い、その後ここに戻ります。Moodleアカウントに他の変更を加えることなく、すべてのMicrosoft 365機能を使用できます。これまでどおりMoodleにログインします。';
$string['ucp_connection_linked_active'] = 'Microsoft 365アカウント「{$a}」にリンクされています。';
$string['ucp_connection_linked_start'] = 'MoodleアカウントをMicrosoft 365アカウントにリンクする。';
$string['ucp_connection_linked_migrate'] = 'リンクされたアカウントに切り替える。';
$string['ucp_connection_linked_stop'] = 'MoodleアカウントとMicrosoft 365アカウントのリンクを解除する。';
$string['ucp_connection_disconnected'] = 'Microsoft 365に接続されていません。';
$string['ucp_features'] = 'Microsoft 365の機能';
$string['ucp_features_intro'] = '以下は、Microsoft 365でMoodleを機能強化する際に使用できる機能のリストです。';
$string['ucp_features_intro_notconnected'] = ' 一部の機能は、Microsoft 365に接続するまで使用できない可能性があります。';
$string['ucp_general_intro_notconnected_nopermissions'] = 'Microsoft 365に接続するには、サイト管理者に連絡する必要があります。';
$string['ucp_index_calendar_title'] = 'Outlookカレンダーの同期';
$string['ucp_index_calendar_desc'] = 'ここでは、MoodleとOutlook間のカレンダーの同期を設定できます。MoodleカレンダーのイベントをOutlookにエクスポートしたり、OutlookのイベントをMoodleに取り込んだりできます。';
$string['ucp_index_connection_title'] = 'Microsoft 365接続設定';
$string['ucp_index_connection_desc'] = 'Microsoft 365への接続方法を設定します。';
$string['ucp_index_connectionstatus_title'] = '接続ステータス';
$string['ucp_index_connectionstatus_login'] = 'ログインするにはここをクリックしてください。';
$string['ucp_index_connectionstatus_usinglogin'] = '現在、Microsoft 365を使用してMoodleにログインしています。';
$string['ucp_index_connectionstatus_usinglinked'] = 'Microsoft 365アカウントにリンクされています。';
$string['ucp_index_connectionstatus_manage'] = '接続を管理する';
$string['ucp_index_connectionstatus_reconnect'] = '接続を更新する';
$string['ucp_index_connectionstatus_connected'] = '現在Microsoft 365に接続されています';
$string['ucp_index_connectionstatus_matched'] = 'Microsoft 365ユーザ<small>「{$a}」</small>と一致しました。この接続を完了するには、以下のリンクをクリックしてMicrosoft 365にログインしてください。';
$string['ucp_index_connectionstatus_notconnected'] = '現在Microsoft 365に接続されていません';
$string['ucp_notconnected'] = 'ここにアクセスする前に、Microsoft 365に接続してください。';
$string['ucp_status_enabled'] = 'アクティブ';
$string['ucp_status_disabled'] = '未接続';
$string['ucp_syncwith_title'] = '同期するOutlookカレンダーの名前:';
$string['ucp_syncdir_title'] = '同期の動作:';
$string['ucp_syncdir_out'] = 'MoodleからOutlookへ';
$string['ucp_syncdir_in'] = 'OutlookからMoodleへ';
$string['ucp_syncdir_both'] = 'OutlookとMoodleを両方更新する';
$string['ucp_o365accountconnected'] = 'このMicrosoft 365アカウントは、すでに別のMoodleアカウントに接続されています。';

// Tasks.
$string['task_calendarsyncin'] = 'Microsoft 365のイベントをMoodleに同期する';
$string['task_coursesync'] = 'MoodleコースをMicrosoft Teamsに同期する';
$string['task_coursemembershipsync'] = 'Microsoft Teamsの所有者とメンバーをMoodleコースに同期する';
$string['task_groupmembershipsync'] = 'Moodleコースの所有者とメンバーをMicrosoft 365グループに同期する';
$string['task_sds_sync'] = 'SDSと同期する';
$string['task_syncusers'] = 'ユーザをMicrosoft Entra IDから同期する';
$string['task_syncusersphotostimezones'] = 'ユーザの写真とタイムゾーンをMicrosoft Entra IDから同期する';
$string['task_calsyncautosubscribe'] = '接続されたユーザのカレンダー同期を自動的に有効にする';
$string['task_groupchannelsync'] = 'Moodleグループ用のTeamsチャネルを作成してメンバーを同期する';
$string['task_groupchannelsyncgroup'] = 'MoodleグループのTeamsチャネルを作成してメンバーを同期する';
$string['task_userenabledstatussync'] = 'Microsoft Entra IDのステータスに基づいてユーザを一時停止/再有効化/削除する';
$string['task_processmatchqueue'] = 'マッチングキューを処理する';
$string['task_notifysecretexpiry'] = 'Microsoft Entra IDアプリのシークレットの有効期限についてサイト管理者に通知する';
$string['task_checkinvalidconfiglog'] = '無効な設定ログレコードを確認してクリーンアップする';
$string['task_usergroupmembershipsync'] = 'ユーザのコースグループメンバーシップをMicrosoft 365に同期する';
$string['task_processmatchqueue_err_museralreadymatched'] = 'このMoodleユーザは、すでにMicrosoft 365ユーザと一致しています。';
$string['task_processmatchqueue_err_museralreadyo365'] = 'このMoodleユーザは、すでにMicrosoft 365に接続されています。';
$string['task_processmatchqueue_err_nomuser'] = 'このユーザ名のMoodleユーザが見つかりません。';
$string['task_processmatchqueue_err_noo365user'] = 'このユーザ名のMicrosoft 365ユーザが見つかりません。';
$string['task_processmatchqueue_err_o365useralreadymatched'] = 'このMicrosoft 365ユーザは、すでにMoodleユーザと一致しています。';
$string['task_processmatchqueue_err_o365useralreadyconnected'] = 'このMicrosoft 365ユーザは、すでにMoodleユーザに接続されています。';

// Capabilities.
$string['o365:manageconnectionlink'] = '接続リンクを管理する';
$string['o365:manageconnectionunlink'] = '接続リンク解除を管理する';
$string['o365:managecoursesync'] = 'ウェブサービス経由でコースのTeams同期を有効または無効にする';
$string['o365:viewgroups'] = '同期が有効なコースで、MicrosoftブロックのMicrosoft 365サービスへのリンクを表示する';
$string['o365:managegroups'] = '同期が有効なコースで、MicrosoftブロックのMicrosoft 365サービスへのリンクと管理オプションを表示する';
$string['o365:teammember'] = 'チームメンバー';
$string['o365:teamowner'] = 'チーム所有者';

// Cache Stores.
$string['cachedef_groups'] = 'Microsoft 365グループのデータを保存します';
$string['cachedef_jwks'] = 'MicrosoftのJWKSキーを保存します';

// Web service errors.
$string['webservices_error_assignnotfound'] = '受信したモジュールの課題レコードが見つかりませんでした。';
$string['webservices_error_invalidassignment'] = '受信した課題IDは、このウェブサービス関数では使用できません。';
$string['webservices_error_modulenotfound'] = '受信したモジュールIDが見つかりませんでした。';
$string['webservices_error_sectionnotfound'] = 'コースセクションが見つかりませんでした。';
$string['webservices_error_couldnotsavegrade'] = '評点を保存できませんでした。';

// User sync task help text.
$string['help_user_create'] = 'アカウント作成のヘルプ';
$string['help_user_create_help'] = 'リンクされたMicrosoft Entra IDの各ユーザについて、Moodleにユーザを作成します。現在Moodleアカウントを持っていないユーザに対してのみ、アカウントが作成されます。新しいアカウントは、Microsoft Entra IDプロファイルを使用してOpenID Connect認証方法で設定され、すべてのMicrosoft 365/Moodle統合機能を使用できるようになります。';
$string['help_user_update'] = 'すべてのアカウントの更新のヘルプ';
$string['help_user_update_help'] = 'リンクされたMicrosoft Entra IDの各ユーザについて、Moodleのすべてのユーザを更新します。';
$string['help_user_suspend'] = 'アカウント一時停止のヘルプ';
$string['help_user_suspend_help'] = 'Microsoft Entra IDで削除済みとしてマークされているユーザを、Moodleで一時停止します。';
$string['help_user_delete'] = 'アカウント削除のヘルプ';
$string['help_user_delete_help'] = 'Microsoft Entra IDで削除済みとしてマークされているユーザを、Moodleから削除します。これは、ユーザの一時停止オプションが有効な場合にのみ機能します。Moodleアカウントは削除され、関連するすべてのユーザ情報がMoodleから削除されます。ご注意ください! 注: デフォルトでは、Entra IDの論理削除の保持期間のため、削除はMicrosoft Entra IDでアカウントが削除されてから30日後に行われます (この期間中はアカウントを復元できます)。一時停止から削除までの待機期間をさらに長くするには、「一時停止されたユーザを削除するまでの待機時間」設定で設定できます。';
$string['help_user_reenable'] = 'アカウント再有効化のヘルプ';
$string['help_user_reenable_help'] = 'Microsoft Entra IDから返され、サインインが許可されている場合、一時停止されたMoodleアカウントを再度有効にします。Microsoft Entra IDでサインインがブロックされている (無効な) アカウントは、一時停止されたままになります。';
$string['help_user_disabledsyncsuspend'] = '無効化時のアカウント一時停止のヘルプ';
$string['help_user_disabledsyncsuspend_help'] = 'Microsoft Entra IDで接続されたアカウントのログインが禁止されている (無効) 場合に、Moodleでユーザを一時停止します。Microsoft Entra IDアカウントが再度有効になった場合に自動的に再度有効にするかどうかは変わりません。それを個別に制御するには、以下の「Microsoft Entra IDで再度有効にされた場合、Moodleのアカウントを再度有効にする」オプションを使用してください。';
$string['help_user_groupsyncsuspend'] = '同期グループに属さないアカウントの一時停止のヘルプ';
$string['help_user_groupsyncsuspend_help'] = 'Microsoft Entra IDではまだアクティブだが、「ユーザ同期グループフィルタ」設定で設定されたグループのメンバーまたは所有者ではないユーザを、Moodleで一時停止します。このチェックは現在のメンバーシップのみを対象とします。グループを離れたユーザだけでなく、一度もグループに属していなかった既存の同期済みユーザも一時停止されるため、このオプションを有効にする前にグループを確認してください。このオプションは、ユーザ同期グループフィルタが設定されている場合にのみ利用できます。大量の一時停止を避けるため、グループが空であることが判明した場合やメンバーを取得できない場合は、何も一時停止されません。一時停止されたユーザは、グループに属していない間は再度有効になりません。';
$string['help_user_disabledsyncreenable'] = '有効化時のアカウント再有効化のヘルプ';
$string['help_user_disabledsyncreenable_help'] = 'Microsoft Entra IDで接続されたアカウントが再びログインを許可された (有効) 場合に、Moodleで一時停止されているユーザの一時停止を解除します。';
$string['help_user_suspendnolink'] = 'Microsoftリンクのないアカウントの一時停止のヘルプ';
$string['help_user_suspendnolink_help'] = '通常、上記の一時停止/無効化オプションは、保存されたMicrosoft Entra IDオブジェクトレコード (アカウントが同期または接続されたときに作成されます) があるアカウントにのみ作用します。一部のOpenID Connectアカウントにはこのようなレコードがありません。たとえば、Microsoft Graph APIが設定される前に接続した場合や、切断または「一致したユーザのクリア」操作によってレコードが削除された場合などです。このオプションにより、ステータスタスクはこれらのアカウントも確認し、Moodleのユーザ名をEntra IDで設定されたバインド用ユーザ名クレーム値と照合します。

Entra IDに存在しない、または無効になっている一致したアカウントは、<strong>一時停止のみ</strong>されます。削除されることはなく (保存されたオブジェクトIDがないため、Entra IDの論理削除の保持期間を確認できません)、自動的に再度有効になることもありません。ゲストアカウントはスキップされます。

このオプションは、OpenID Connectのバインド用ユーザ名クレームが、Entra IDで検索できる特定のフィールド (「upn」、「oid」、「email」または「samaccountname」) に設定されている場合にのみ機能します。「auto」 (有効なクレームがログインごとに選択され、ユーザによって異なる場合がある) またはその他のクレームでは、Moodleのユーザ名を単一のアカウントと確実に照合できないため、このオプションは何も行いません。

最初の実行後に、一時停止されたユーザを確認してください。この認証方法に手動で切り替えられた、実際にはEntra IDユーザではなかったアカウントは、このオプションによって一時停止されます。';
$string['help_user_match'] = 'アカウントのマッチングのヘルプ';
$string['help_user_match_help'] = 'リンクされたMicrosoft Entra IDの各ユーザを確認し、Moodleのユーザとの一致を試みます。この一致は、Microsoft Entra IDのUPNとMoodleのユーザ名に基づきます。一致では大文字と小文字を区別せず、Microsoft Entra IDのUPNのドメイン部分は無視されます。たとえば、Moodleの「BoB.SmiTh」は「bob.smith@example.onmicrosoft.com」と一致します。一致したユーザは、MoodleアカウントとMicrosoft Entra IDアカウントが接続され、すべてのMicrosoft 365およびMoodle統合機能を使用できるようになります。ユーザの認証方法は、以下の設定が有効にならない限り、変更されません。';
$string['help_user_matchswitchauth'] = '一致したアカウントの切り替えのヘルプ';
$string['help_user_matchswitchauth_help'] = 'これには、上の「既存のMoodleユーザとMicrosoft Entra IDの同名のアカウントを一致させる」設定が有効である必要があります。ユーザが一致した場合、この設定を有効にすると、認証方法がOpenID Connectに切り替わります。その後、Microsoft 365の認証情報を使用してMoodleにログインできるようになります。注: この設定を使用する場合は、OpenID Connect認証プラグインが有効であることを確認してください。警告: Moodleのユーザ名が、Microsoft Entra IDのUPN全体ではなく「@」より前の部分とのみ一致する場合、詳細設定の「Microsoft 365に切り替える不完全一致ユーザ名の最小長」により、ユーザ名の短いユーザの認証方法が切り替えられない場合があります。';
$string['help_user_appassign'] = 'ユーザのアプリケーションへの割り当てのヘルプ';
$string['help_user_appassign_help'] = '一致するMoodleアカウントを持つすべてのMicrosoft Entra IDアカウントを、まだ割り当てられていない場合に、このMoodleインストール用に作成されたMicrosoft Entra IDアプリに割り当てます。';
$string['help_user_photosync'] = 'Microsoft 365プロファイル写真の同期 (cron) のヘルプ';
$string['help_user_photosync_help'] = 'すべてのユーザのMoodleプロファイル写真を、Microsoft 365のプロファイル写真と同期します。';
$string['help_user_photosynconlogin'] = 'Microsoft 365プロファイル写真の同期 (ログイン) のヘルプ';
$string['help_user_photosynconlogin_help'] = 'ユーザがログインしたときに、そのユーザのMoodleプロファイル写真をMicrosoft 365のプロファイル写真と同期します。これには、ユーザがMoodleでMicrosoftブロックを含むページにアクセスする必要があることにご注意ください。';
$string['help_user_nodelta'] = '完全同期の実行のヘルプ';
$string['help_user_nodelta_help'] = 'デフォルトでは、ユーザ同期は、前回の同期の実行以降にMicrosoft Entra IDで行われた変更のみを同期します。このオプションをチェックすると、毎回完全なユーザ同期が強制されます。';
$string['help_user_emailsync'] = 'Microsoft Entra IDのユーザ名とMoodleのメールアドレスの同期のヘルプ';
$string['help_user_emailsync_help'] = 'このオプションを有効にすると、Microsoft Entra IDのユーザ名とMoodleのユーザ名を照合するデフォルトの動作ではなく、Microsoft Entra IDのユーザ名とMoodleのメールアドレスが照合されます。';
$string['help_user_tzsync'] = 'Outlookタイムゾーンの同期 (cron) のヘルプ';
$string['help_user_tzsync_help'] = 'すべてのユーザのMoodleタイムゾーンを、Outlookのタイムゾーン設定と同期します。';
$string['help_user_tzsynconlogin'] = 'Outlookタイムゾーンの同期 (ログイン) のヘルプ';
$string['help_user_tzsynconlogin_help'] = 'ユーザのMoodleタイムゾーンを、Outlookのタイムゾーン設定と同期します。これには、ユーザがMoodleでMicrosoftブロックを含むページにアクセスする必要があることにご注意ください。';
$string['help_user_guestsync'] = 'ゲストユーザの同期のヘルプ';
$string['help_user_guestsync_help'] = '有効にした場合、Microsoft Entra IDのゲストユーザは、ユーザ同期タスクでMoodleに同期されます。';

// Cohort sync feature.
$string['cohortsync_title'] = 'コーホート同期';
$string['cohortsync_taskname'] = 'コーホート同期';
$string['cohortsync_mappingadded'] = '新しい接続が正常に追加されました';
$string['cohortsync_mappingdeleted'] = '接続が正常に削除されました';
$string['cohortsync_addmapping'] = '接続を追加する';
$string['cohortsync_deletemapping'] = '接続を削除する';
$string['cohortsync_desc'] = 'このページでは、システムレベルのコンテキストで、Microsoft 365グループからMoodleコーホートへの一方向の同期を行えます。新しい接続を追加すると同期処理が開始され、選択したMicrosoft 365グループのユーザのうちMicrosoftに接続されているユーザが、選択したMoodleコーホートに追加されます。';
$string['cohortsync_tabledesc'] = 'Microsoft 365グループとMoodleコーホート間の現在の接続';
$string['cohortsync_typetosearch'] = '入力してMicrosoft 365グループを検索する';
$string['cohortsync_typetosearch_cohort'] = '入力してMoodleコーホートを検索する';
$string['cohortsync_emptymatchings'] = '接続が見つかりません';
$string['cohortsync_select_cohort'] = 'Moodleコーホート';
$string['cohortsync_select_group'] = 'Microsoft 365グループ';
$string['cohortsync_tablehead_group'] = 'Microsoft 365グループ';
$string['cohortsync_tablehead_cohort'] = 'Moodleコーホート';
$string['cohortsync_tablehead_actions'] = '操作';
$string['cohortsync_search'] = '検索';
$string['cohortsync_load_more'] = 'さらに読み込む...';
$string['cohortsync_no_groups_found'] = '「{$a}」に該当するMicrosoft 365グループは見つかりませんでした';
$string['cohortsync_no_cohorts_found'] = '「{$a}」に該当するMoodleコーホートは見つかりませんでした';
$string['cohortsync_error_no_group'] = 'Microsoft 365グループを選択してください。';
$string['cohortsync_error_no_cohort'] = 'Moodleコーホートを選択してください。';
$string['cohortsync_mappingfailed'] = 'コーホートとグループの接続の追加中にエラーが発生しました。考えられる原因: グループまたはコーホートが存在しない、グループがすでに別のコーホートに接続されている、グループがすでにこのコーホートに接続されている。';
$string['cohortsync_connectionnotfound'] = '無効なリクエスト: 接続が見つかりません。';
$string['cohortsync_connectionnotcohortsync'] = '無効なリクエスト: 接続タイプが一致しません。';
$string['cohortsync_unifiedapierror'] = 'Microsoftからのグループのリストの取得中にエラーが発生しました。';

// Course request.
$string['courserequest_teams'] = 'Microsoftチーム';
$string['courserequest_teams_help'] = 'コースに接続するMicrosoftチームを選択してください。既存のチーム所有者とメンバーは、コースリクエストが承認されると、作成されたコースに登録されます。';
$string['courserequest_emptyteams'] = '利用可能なMicrosoftチームがありません';
$string['courserequest_title'] = 'Teamsからコースをリクエストする';
$string['courserequest_updatecourserequeststatus_taskname'] = 'コースリクエストのステータスを更新する';
$string['courserequest_customrequestnote'] = '
| このリクエストはMicrosoft Teamsのコースリクエストページから行われたもので、承認時にチーム「{$a->name}」(URL: {$a->url}) に接続されます。';
$string['courserequest_graphapi_disabled'] = 'Microsoft Teamsへの接続は利用できません。サイト管理者に連絡してください。';
$string['courserequest_invalid_team'] = 'コースリクエストで無効なチームが使用されました。';
$string['courserequest_duplicate'] = '同じチームからの保留中または承認済みのコースリクエストがすでに存在します。';

// Teams page.
$string['teams_no_course'] = '追加できるコースがありません。';
$string['tab_name'] = 'タブ名';
$string['sso_login'] = 'Microsoft 365にログインする';
$string['other_login'] = '手動でログインする';
$string['course_selector_label'] = '既存のコースを選択する';

// Notifications to site admin about Microsoft Entra ID app secret.
$string['notification_subject_secret_expired'] = '対応が必要です: Microsoft Entra IDアプリのシークレットの有効期限が切れました';
$string['notification_content_secret_expired'] = 'サイト管理者様

MoodleとMicrosoft 365の統合で使用されているMicrosoft Entra IDアプリのシークレットの有効期限が切れました。
統合を復旧するには、Microsoft Entra IDで新しいシークレットを作成し、統合の設定で更新してください。';
$string['notification_subject_secret_almost_expired'] = '対応が必要です: Microsoft Entra IDアプリのシークレットの有効期限がまもなく切れます';
$string['notification_content_secret_almost_expired'] = 'サイト管理者様

MoodleとMicrosoft 365の統合で使用されているMicrosoft Entra IDアプリのシークレットは、{$a}後に有効期限が切れます。
統合の中断を避けるため、Microsoft Entra IDで新しいシークレットを作成し、統合の設定で更新してください。';
$string['notification_days_less_than_one_day'] = '1日未満';
$string['notification_days_one_day'] = '1日';
$string['notification_days_days'] = '{$a}日';
$string['notification_subject_invalid_secret'] = '対応が必要です: 無効なMicrosoft Entra IDアプリのシークレットが見つかりました';
$string['notification_content_invalid_secret'] = 'サイト管理者様

MoodleとMicrosoft 365の統合で使用されているMicrosoft Entra IDアプリのシークレットが無効であるようです。シークレットの有効期限が切れたか、削除されたことが原因である可能性があります。
統合が期待どおりに動作するよう、シークレットを確認してください。';

// Async operations.
$string['teamsasyncfailed'] = 'チーム作成の非同期操作に失敗しました: {$a}';
$string['unknownasyncstate'] = '不明な非同期操作の状態: {$a}';

// Template ID validation.
$string['error_template_id_empty'] = 'テンプレートIDを空にすることはできません。';
$string['error_not_connected'] = 'Microsoft 365に接続されていません。最初にMicrosoft 365統合を設定してください。';
$string['error_graph_client_not_available'] = 'Microsoft Graph APIに接続できません。Microsoft 365統合の設定を確認してください。';
$string['success_template_id_valid'] = '✓ テンプレートID「{$a}」は有効で、アクセス可能です。';
$string['error_template_id_not_found'] = '✗ テンプレートID「{$a}」が見つかりませんでした。Teams管理センターでテンプレートIDを確認してください。';
$string['error_template_validation_failed'] = '✗ テンプレートの検証に失敗しました: {$a}';
$string['error_template_validation_error'] = '✗ テンプレートの検証中にエラーが発生しました。再度お試しいただくか、管理者に連絡してください。';

// phpcs:enable moodle.Files.LangFilesOrdering.IncorrectOrder
// phpcs:enable moodle.Files.LangFilesOrdering.UnexpectedComment
