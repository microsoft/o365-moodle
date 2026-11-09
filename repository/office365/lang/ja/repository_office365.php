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
 * @package repository_office365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Microsoft, Inc. (http://microsoft.com/)
 */

$string['cachedef_unifiedfolderids'] = 'Microsoft 365リポジトリ - 統合フォルダID';
$string['cachedef_unifiedgroupfolderids'] = 'Microsoft 365リポジトリ - グループ用の統合フォルダID';
$string['configplugin'] = 'Microsoft 365リポジトリを設定する';
$string['controlledsharelinkdesc'] = '共有コピー (組織のメンバーのみ)';
$string['copiedfile'] = 'ファイルのコピー';
$string['defaultgroupsfolder'] = 'コースファイル';
$string['directlinkdesc'] = '直接リンク (既存の権限)';
$string['enableanonymousshare'] = '「{$a}」オプションを有効にする';
$string['enableanonymousshare_help'] = 'チェックすると、ユーザはファイルのコピーを作成して組織内の全員と共有することを選択できます。コピーはユーザのOneDriveに保存され、組織のすべてのメンバーと共有されます。

**動作:**
* 選択したファイルのコピーを、末尾に「 - Shared」を付けて作成します。
* コピーは (元の場所ではなく) ユーザのOneDriveに保存されます。
* コピーに対して、組織スコープの共有リンクが作成されます。
* 元のファイルは変更されず、既存の権限が維持されます。

**アクセス制御:**
* Microsoft 365組織のメンバーのみがファイルにアクセスできます。
* リンクを持つ組織内のすべてのユーザがファイルを閲覧できます。
* 外部ユーザおよび匿名ユーザはファイルにアクセスできません。
* リンクは自動的には期限切れになりません。
* ファイルの所有者は、自分のOneDriveから共有を管理または取り消すことができます。

**使用する場合:**
* 組織のすべてのメンバーとファイルを共有したい。
* 元のファイルを誤った変更から保護したい。
* Moodleのストレージ容量が懸念される。
* ファイルの内容が組織全体からのアクセスに適している。

**重要な注意事項:**
* 大きなファイルの場合、コピー処理に数秒かかることがあります。
* ユーザは、ファイルの内容が組織全体での共有に適していることを確認する必要があります。
* コピーされたファイルは、ユーザのOneDriveに末尾「 - Shared」付きで表示されます。
* 元のファイルへの変更は共有コピーには反映されず、その逆も同様です。

**表示上の制限や混乱の可能性があるため、このオプションはデフォルトで無効になっています。ユーザが組織共有のコピーを作成できるようにする場合にのみ、このチェックボックスをオンにしてください。**';
$string['enableanonymoussharewarning'] = '<div class="alert alert-info"><strong>注意:</strong> 「{$a}」オプションを使用すると、元のファイルのコピーが作成され、組織のすべてのメンバーと共有されます。元のファイルは変更されません。ユーザは、ファイルの内容が組織全体からのアクセスに適していることを確認する必要があります。
<br><br><strong>表示上の制限:</strong> このオプションを使用して共有されたファイルには、ファイルの種類やリソースで使用される表示オプションに応じた制限があります。動作は次のとおりです。
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>表示オプション</th>
<th>画像</th>
<th>ファイル (例: .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>自動</strong></td>
<td style="background-color: #ffdddd;">動作しません - 何も表示されず、接続がブロックされます</td>
<td>動作します - OneDriveにリダイレクトされます</td>
</tr>
<tr>
<td><strong>埋め込み</strong></td>
<td>動作します - 画像が埋め込まれます</td>
<td style="background-color: #ffdddd;">動作しません - iframeに「接続が拒否されました」エラーが表示されます</td>
</tr>
<tr>
<td><strong>強制的にダウンロードする</strong></td>
<td colspan="2">動作します - OneDriveにリダイレクトされます</td>
</tr>
<tr>
<td><strong>オープン</strong></td>
<td colspan="2">動作します - OneDriveにリダイレクトされます</td>
</tr>
<tr>
<td><strong>ポップアップ</strong></td>
<td colspan="2">動作します - ポップアップで開きます</td>
</tr>
</tbody>
</table>
すべての表示オプションで最高の互換性を得るには、代わりにファイルをMoodleにコピーすることを検討してください。</div>';
$string['enablecoursegroup'] = 'ファイルピッカでグループ (コース) フォルダを有効にする';
$string['enabledirectlink'] = '「{$a}」オプションを有効にする';
$string['enabledirectlink_help'] = 'チェックすると、ユーザはファイルをMoodleにコピーする代わりに、自分のOneDrive内のファイルへの直接リンクを追加できます。ファイルはOneDriveに残り、Moodleには参照リンクのみが保存されます。

**アクセス制御に関する重要な考慮事項:**
* ファイルの既存のOneDrive権限は変更されません。
* リンクにアクセスするユーザは、ファイルを閲覧するためのOneDriveでの適切な権限を持っている必要があります。
* 適切なアクセス権限を確保する責任は、リンクを追加するユーザにあります。
* OneDriveの権限が正しく設定されていない場合、他のユーザがファイルにアクセスできないことがあります。

**このオプションを使用する場合:**
* ファイルがすでにMicrosoft 365で対象ユーザと共有されている。
* OneDriveを唯一の情報源として維持したい。
* Moodleのストレージ容量が懸念される。
* OneDriveのファイルへの編集をMoodleに反映させたい。

**表示上の制限やアクセス制御の複雑さのため、このオプションはデフォルトで無効になっています。ユーザがOneDriveから直接ファイルをリンクできるようにする場合にのみ、このチェックボックスをオンにしてください。**';
$string['enabledirectlinkwarning'] = '<div class="alert alert-info"><strong>注意:</strong> 「{$a}」オプションを使用しても、OneDriveファイルの共有設定は変更されません。ファイルを追加するユーザは、OneDriveのファイル権限が正しく設定されていることを確認する必要があります。
<br><br><strong>表示上の制限:</strong> このオプションを使用してリンクされたファイルには、ファイルの種類やリソースで使用される表示オプションに応じた制限があります。動作は次のとおりです。
<table class="table table-sm table-bordered">
<thead>
<tr>
<th>表示オプション</th>
<th>画像</th>
<th>ファイル (例: .docx)</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>自動</strong></td>
<td style="background-color: #ffdddd;">動作しません - 何も表示されず、接続がブロックされます</td>
<td>OneDriveにリダイレクトされます。ユーザがOneDriveファイルへのアクセス権限を持っていれば動作し、そうでない場合は権限拒否ページが表示されます</td>
</tr>
<tr>
<td><strong>埋め込み</strong></td>
<td style="background-color: #ffdddd;">動作しません - 何も表示されず、接続がブロックされます</td>
<td style="background-color: #ffdddd;">動作しません - 埋め込まれたiframeに接続拒否エラーが表示されます</td>
</tr>
<tr>
<td><strong>強制的にダウンロードする</strong></td>
<td colspan="2">OneDriveにリダイレクトされます。ユーザがOneDriveファイルへのアクセス権限を持っていれば動作し、そうでない場合は権限拒否ページが表示されます</td>
</tr>
<tr>
<td><strong>オープン</strong></td>
<td colspan="2">OneDriveにリダイレクトされます。ユーザがOneDriveファイルへのアクセス権限を持っていれば動作し、そうでない場合は権限拒否ページが表示されます</td>
</tr>
<tr>
<td><strong>ポップアップ</strong></td>
<td colspan="2">ポップアップで開きます。ユーザがOneDriveファイルへのアクセス権限を持っていれば動作し、そうでない場合は権限拒否ページが表示されます</td>
</tr>
</tbody>
</table>
最高の互換性を得るには、直接リンクを使用する代わりに、ファイルをMoodleにコピーすることを検討してください。</div>';
$string['enableinternal'] = '「{$a}」オプションを有効にする';
$string['enableinternal_help'] = 'チェックすると (デフォルト)、ユーザはOneDriveからMoodleにファイルをコピーすることを選択できます。このチェックを外し、下の「ファイルにリンクする」または「ファイルのアクセスコントロールリンクを作成する」オプション (あるいはその両方) を有効にすると、ユーザはファイルにリンクすることが強制されます。

3つのファイルリンクオプションのうち、少なくとも1つを有効にする必要があります。';
$string['enableonedrivegroup'] = 'ファイルピッカでマイOneDriveフォルダを有効にする';
$string['enabletrendinggroup'] = 'ファイルピッカで「自分の周りのトレンドファイル」フォルダを有効にする';

$string['errorauthoidcnotconfig'] = 'Microsoft 365リポジトリを使用する前に、OpenID Connect認証プラグインを設定してください。';
$string['errorbadclienttype'] = '無効なクライアントタイプです。';
$string['errorbadpath'] = '不正なパス';
$string['errorencodingreference'] = 'ファイル参照のエンコードに失敗しました';
$string['errornofilelinkoption'] = '少なくとも1つのファイルリンクオプションを有効にする必要があります。';
$string['erroro365required'] = 'このファイルは現在、Microsoft 365ユーザのみが利用できます。';
$string['errorwhiledownload'] = 'ファイルのダウンロード中にエラーが発生しました';
$string['errorwhilesharing'] = '共有可能なリンクの作成中にエラーが発生しました';

$string['file'] = 'ファイル';
$string['filelinkingheader'] = 'ファイルリンクオプション';
$string['filereferencewarning'] = 'OneDriveファイルの共有設定は変更されません。OneDrive内のファイルにすでにアクセスできるユーザのみが、このリンクを開くことができます。';
$string['groups'] = 'グループ (コース)';
$string['invalidfilereference'] = 'ファイル参照が無効または不正な形式です';
$string['myfiles'] = 'マイOneDrive';
$string['notconfigured'] = '<p class="error">このプラグインを使用するには、最初に<a href="{$a}/admin/settings.php?section=local_o365">Microsoft 365プラグイン</a>を設定する必要があります</p>';
$string['office365:view'] = 'Microsoft 365リポジトリを表示する';
$string['pluginname'] = 'Microsoft 365';
$string['privacy:metadata'] = 'このプラグインは、現在のユーザとしてMicrosoft Graph API (OneDrive) と通信します。アップロードされたファイルは、リモートサーバに送信されます。';
$string['trendingaround'] = '自分の周りのトレンドファイル';
$string['upload'] = '新しいファイルをアップロードする';
