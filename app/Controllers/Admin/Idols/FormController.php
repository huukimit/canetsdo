<?php

namespace App\Controllers\Admin\Idols;

use App\Http\Controllers\BackendController;
use App\User;
use Input;
use URL;
use Mail;
use Config;
use Redirect;
use TCPDF;
use App\Models\Users\Users;
use App\Models\Zenigata\Members;
use App\Models\Zenigata\Gift;
use App\Models\Zenigata\HistoryUserPoint;

class FormController extends BackendController {

    function __construct() {
        parent::__construct();
    }

    /**
     *
     * @return Dashboard idol
     */
    public function dashBoardAction() {
        $this->website_info['title'] = 'トップ';
        $type_report = Input::get('type', 0);
        $idol = Users::find($this->id_idol);
        $userClick = HistoryUserPoint::getCountUserClickZeni($this->id_idol);
        $zeni = HistoryUserPoint::getSumZeniIdol($this->id_idol);
        $setting = Config::get('admin.percent_hiro');
        $amount = $zeni->zeni - ((30 * $zeni->zeni) / 100);
        $amount = $amount - ($amount * $setting) / 100;
        $arr = array('date', 'val');
        $hLine1 = '[';
        $hLine2 = '[';
        $line1 = array();
        $line2 = array();
        $total_plot1 = 0;
        $total_plot2 = 0;
        $listMonth = array();
        $lst = HistoryUserPoint::getListZeniReport($this->id_idol, $type_report, 'asc');
        foreach ($lst as $kl => $vl) {
            $date = $vl->date . " 09:00:00";
            $dateLine = strtotime($date);
            $line1[] = "[" . $dateLine . "000," . round($vl->amount) . "]";
            $caculate = $vl->amount - ($vl->amount * 30) / 100;
            $caculate = $caculate - ($caculate * $setting) / 100;
            $line2[] = "[" . $dateLine . "000," . round($caculate) . "]";
            $total_plot1 = $total_plot1 + $vl->amount;
            $total_plot2 = $total_plot2 + $caculate;
        }
        $hLine1 .= implode(',', $line1) . ']';
        $hLine2 .= implode(',', $line2) . ']';
        $idol->count_click_zeni = number_format(count($userClick), 0, '.', ',');
        $idol->zeni = number_format($zeni->zeni, 0, '.', ',');
        $idol->amount = number_format(round($amount), 0, '.', ',');
        $this->setData['plot1'] = $hLine1;
        $this->setData['plot2'] = $hLine2;
        $this->setData['total_plot1'] = number_format(round($total_plot1), 0, '.', ',');
        $this->setData['total_plot2'] = number_format(round($total_plot2), 0, '.', ',');
        $this->setData['type_report'] = $type_report;
        $this->setData['idol'] = $idol;
        return $this->ShowTemplate('idols.dashboard');
    }

    public function reportAction() {
        $this->website_info['title'] = 'アイドル情報管理';
        $time_report = Input::get('time_report', 0);
        $percent_hiro = Input::get('percent_hiro', '');
        $setting = $percent_hiro != '' ? $percent_hiro : Config::get('admin.percent_hiro');
        $idol = Users::find($this->id_idol);
        $userClick = HistoryUserPoint::getCountUserClickZeni($this->id_idol);
        $zeni = HistoryUserPoint::getSumZeniIdol($this->id_idol);
        $amount = $zeni->zeni - ((30 * $zeni->zeni) / 100);
        $amount = $amount - ($amount * $setting) / 100;
        $arr = array('date', 'val');
        $hLine1 = '[';
        $hLine2 = '[';
        $line1 = array();
        $line2 = array();
        $total_plot1 = 0;
        $total_plot2 = 0;
        $listMonth = array();
        $lstMonth = HistoryUserPoint::getAllListZeniReport($this->id_idol);
        foreach ($lstMonth as $vl_2) {
            if (!in_array(date("Y-m", strtotime($vl_2->date)), $listMonth)) {
                $listMonth[date("Y-m", strtotime($vl_2->date))] = date("Y", strtotime($vl_2->date)) . '年' . date("m", strtotime($vl_2->date)) . '月';
            }
        }
        $firstKey = date('Y-m');
        if (count($listMonth) > 0) {
            $keys = array_keys($listMonth);
            $firstKey = reset($keys);
        }
        $time_report = $time_report != 0 ? $time_report : $firstKey;
        $lst = HistoryUserPoint::getListZeniReportByMonth($this->id_idol, $time_report);
        foreach ($lst as $kl => $vl) {
            $date = $vl->date . " 09:00:00";
            $dateLine = strtotime($date);
            $line1[] = "[" . $dateLine . "000," . round($vl->amount) . "]";
            $caculate = $vl->amount - ($vl->amount * 30) / 100;
            $caculate = $caculate - ($caculate * $setting) / 100;
            $line2[] = "[" . $dateLine . "000," . round($caculate) . "]";
            $total_plot1 = $total_plot1 + $vl->amount;
            $total_plot2 = $total_plot2 + $caculate;
        }
        $hLine1 .= implode(',', $line1) . ']';
        $hLine2 .= implode(',', $line2) . ']';
        $percentDevices = HistoryUserPoint::getListUserClickZeniTypeDevice($this->id_idol, $time_report);
        $averageZeni = $percentDevices['total'] > 0 ? $total_plot1 / $percentDevices['total'] : 0;
        $averageAmount = $percentDevices['total'] > 0 ? $total_plot2 / $percentDevices['total'] : 0;
        $idol->count_click_zeni = number_format(count($userClick), 0, '.', ',');
        $idol->zeni = number_format($zeni->zeni, 0, '.', ',');
        $idol->amount = number_format(round($amount), 0, '.', ',');
        $this->setData['plot1'] = $hLine1;
        $this->setData['plot2'] = $hLine2;
        $this->setData['total_plot1'] = number_format(round($total_plot1), 0, '.', ',');
        $this->setData['total_plot2'] = number_format(round($total_plot2), 0, '.', ',');
        $this->setData['listMonth'] = $listMonth;
        $this->setData['setting'] = $setting;
        $this->setData['time_report'] = $time_report;
        $this->setData['percentDevices'] = $percentDevices;
        $this->setData['averageZeni'] = number_format(round($averageZeni), 2, '.', ',');
        $this->setData['averageAmount'] = number_format(round($averageAmount), 2, '.', ',');
        $this->setData['idol'] = $idol;
        return $this->ShowTemplate('idols.report');
    }

    public function PreviewExportAction() {
        $this->website_info['title'] = '売り上げレポート';
        $time_report = Input::get('time_report', 0);
        $percent_hiro = Input::get('percent_hiro', 0);
        $setting = $percent_hiro > 0 ? $percent_hiro : Config::get('admin.percent_hiro');
        $time_report = $time_report != 0 ? $time_report : date('Y-m');
        $percentDevices = HistoryUserPoint::getListUserClickZeniTypeDevice($this->id_idol, $time_report);
        $lst = HistoryUserPoint::getListZeniReportByMonth($this->id_idol, $time_report);
        //ket qua thong ke
        $arrZeni = array();
        $arrUser = array();
        $arrAmountZeni = array();
        $arrAverageZeni = array();
        $total_zeni = 0;
        $total_amout = 0;
        $total_user = 0;
        $total_average = 0;
        foreach ($lst as $kl => $vl) {
            $arrZeni[date('j', strtotime($vl->date))] = round($vl->amount);
            $caculate = $vl->amount - ($vl->amount * 30) / 100;
            $caculate = $caculate - ($caculate * $setting) / 100;
            $arrAmountZeni[date('j', strtotime($vl->date))] = round($caculate);
            $total_zeni = $total_zeni + round($vl->amount);
            $total_amout = $total_amout + round($caculate);
        }
        foreach ($arrZeni AS $k => $zeni) {
            $day = strlen($k) > 1 ? $k : '0' . $k;
            $date = $time_report . '-' . $day;
            $noUser = HistoryUserPoint::getListUserClickByDay($this->id_idol, $date);
            $arrUser[$k] = count($noUser);
            $avarage = number_format(round($zeni / count($noUser)), 2, '.', ',');
            $arrAverageZeni[$k] = $avarage;
            $total_average = $total_average + $avarage;
        }
        $lstTable = array();
        $m = date('n', strtotime($time_report));
        $y = date('Y', strtotime($time_report));
        $numDays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
        for ($i = 1; $i < $numDays + 1; $i++) {
            $lstTable[$i] = array(
                'date' => $y . '年' . $m . '月' . $i . '日',
                'zeni' => key_exists($i, $arrZeni) ? $arrZeni[$i] : 0,
                'count_user' => key_exists($i, $arrUser) ? $arrUser[$i] : 0,
                'average_zeni' => key_exists($i, $arrAverageZeni) ? $arrAverageZeni[$i] : 0,
                'amount' => key_exists($i, $arrAmountZeni) ? $arrAmountZeni[$i] : 0
            );
        }
        $this->setData['lstTable'] = $lstTable;
        $this->setData['percentDevices'] = $percentDevices;
        $this->setData['data_total'] = array(
            'total_zeni' => $total_zeni,
            'total_amout' => $total_amout,
            'total_average' => number_format($total_average, 2, '.', ',')
        );
        $this->setData['dateRange'] = array(
            'from' => $y . '年' . $m . '月1日',
            'to' => $y . '年' . $m . '月' . $numDays . '日',
        );
        $this->setData['id_idol'] = $this->id_idol;
        $this->setData['setting'] = $setting;
        $this->setData['time_report'] = $time_report;
        return $this->ShowTemplate('idols.preview_export');
    }

    public function exportPDFAction() {
        $time_report = Input::get('time_report', 0);
        $percent_hiro = Input::get('percent_hiro', 0);
        $setting = $percent_hiro > 0 ? $percent_hiro : Config::get('admin.percent_hiro');
        $time_report = $time_report != 0 ? $time_report : date('Y-m');
        $percentDevices = HistoryUserPoint::getListUserClickZeniTypeDevice($this->id_idol, $time_report);
        $lst = HistoryUserPoint::getListZeniReportByMonth($this->id_idol, $time_report);
        //ket qua thong ke
        $arrZeni = array();
        $arrUser = array();
        $arrAmountZeni = array();
        $arrAverageZeni = array();
        $total_zeni = 0;
        $total_amout = 0;
        $total_user = 0;
        $total_average = 0;
        foreach ($lst as $kl => $vl) {
            $arrZeni[date('j', strtotime($vl->date))] = round($vl->amount);
            $caculate = $vl->amount - ($vl->amount * 30) / 100;
            $caculate = $caculate - ($caculate * $setting) / 100;
            $arrAmountZeni[date('j', strtotime($vl->date))] = round($caculate);
            $total_zeni = $total_zeni + round($vl->amount);
            $total_amout = $total_amout + round($caculate);
        }
        foreach ($arrZeni AS $k => $zeni) {
            $day = strlen($k) > 1 ? $k : '0' . $k;
            $date = $time_report . '-' . $day;
            $noUser = HistoryUserPoint::getListUserClickByDay($this->id_idol, $date);
            $arrUser[$k] = count($noUser);
            $avarage = number_format(round($zeni / count($noUser)), 2, '.', ',');
            $arrAverageZeni[$k] = $avarage;
            $total_average = $total_average + $avarage;
        }
        $lstTable = array();
        $m = date('n', strtotime($time_report));
        $y = date('Y', strtotime($time_report));
        $numDays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
        for ($i = 1; $i < $numDays + 1; $i++) {
            $lstTable[$i] = array(
                'date' => $y . '年' . $m . '月' . $i . '日',
                'zeni' => key_exists($i, $arrZeni) ? $arrZeni[$i] : 0,
                'count_user' => key_exists($i, $arrUser) ? $arrUser[$i] : 0,
                'average_zeni' => key_exists($i, $arrAverageZeni) ? $arrAverageZeni[$i] : 0,
                'amount' => key_exists($i, $arrAmountZeni) ? $arrAmountZeni[$i] : 0
            );
        }
        $this->setData['percentDevices'] = $percentDevices;
        $this->setData['data_total'] = array(
            'total_zeni' => $total_zeni,
            'total_amout' => $total_amout,
            'total_average' => number_format($total_average, 2, '.', ',')
        );
        $this->setData['dateRange'] = array(
            'from' => $y . '年' . $m . '月1日',
            'to' => $y . '年' . $m . '月' . $numDays . '日',
        );

        /**
         * Export PDF
         *
         */
        // create new PDF documente
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set some language-dependent strings (optional)
// add a page
        $pdf->AddPage();
// set font
        $pdf->SetFont('cid0jp', '', 16);

        $pdf->Write(10, '売り上げレポート', 'B', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('cid0jp', '', 9);

        $pdf->Write(10, '期間：' . $y . '年' . $m . '月1日' . '〜' . $y . '年' . $m . '月' . $numDays . '日', 0, 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('cid0jp', '', 9);
        $tbl = '
        <table cellspacing="0" cellpadding="2" border="1">
                            <tbody><tr style="background-color:#1daea6;color:#FFFFFF;padding:10px">
                                <th align="center" width="16%">年月日</th>
                                <th align="center">獲得応援数</th>
                                <th align="center">応援人数</th>
                                <th align="center">平均応援数</th>
                                <th align="center">お客様収益</th>
                            </tr>
        ';
        foreach ($lstTable AS $d => $item) {
            $tbl .= '<tr>
                                <td align="left">' . $item['date'] . '</td>
                                <td align="right">' . $item['zeni'] . '</td>
                                <td align="right">' . $item['count_user'] . '</td>
                                <td align="right">' . $item['average_zeni'] . '</td>
                                <td align="right">' . $item['amount'] . '</td>
                            </tr>';
        }
        $tbl .= '<tr>
                                <td align="center">計</td>
                                <td align="right">' . $total_zeni . '</td>
                                <td align="right">' . $percentDevices['total'] . '</td>
                                <td align="right">' . $total_average . '</td>
                                <td align="right">' . $total_amout . '</td>
                            </tr></table>';

        $pdf->writeHTML($tbl, true, false, false, false, '');
        //Close and output PDF document
        $nameFile = 'report_' . time() . '.pdf';
        $out = $pdf->Output(storage_path() . '/report/' . $nameFile, 'F');
        return Redirect::to(URL::to('/') . '/storage/report/' . $nameFile);
    }

    /**
     *
     * @return Edit profile
     */
    public function editProfileAction() {
        $this->website_info['title'] = 'プロフィール情報';
        $idol = Users::find($this->id_idol);
        $this->setData['uinfo'] = $idol;
        return $this->ShowTemplate('idols.edit_profile');
    }

    /**
     *
     * @return Idol member
     */
    public function idolMemberAction() {
        $this->website_info['title'] = 'メンバー詳細';
        $members = Members::getListMemberOfTeamByUserID($this->id_idol);
        $this->setData['members'] = $members;
        $this->setData['id_idol'] = $this->id_idol;
        return $this->ShowTemplate('idols.member');
    }

    /**
     *
     * @return add new member for idol
     */
    public function addMemberAction() {
        $this->website_info['title'] = 'メンバーの追加';
        $this->setData['id_idol'] = $this->id_idol;
        return $this->ShowTemplate('idols.add_member');
    }

    /**
     *
     * @return edit member
     */
    public function editMemberAction() {
        $this->website_info['title'] = 'メンバー詳細';
        $members = Members::getListMemberOfTeamByUserID($this->id_idol);
        $this->setData['members'] = $members;
        $this->setData['id_idol'] = $this->id_idol;
        return $this->ShowTemplate('idols.edit_member');
    }

    /**
     *
     * @return delete member
     */
    public function deleteMemberAction() {
        $id = Input::get('id', 0);
        $delete = Members::destroy($id);
        return redirect()->to('admin/idols/editmember?id_idol=' . $this->id_idol)->with('message', 'メンバーが削除されました。');
    }

    /**
     *
     * @return list item waiting
     */
    public function ItemwaitingListAction() {
        $this->website_info['title'] = '待ち受け画像管理';
        $itemwaitings = Gift::getAllGiftByIdolIDAndType($this->id_idol, 2);
        $this->setData['itemwaitings'] = $itemwaitings;
        $this->setData['id_idol'] = $this->id_idol;
        return $this->ShowTemplate('idols.item_waiting_list');
    }

    /**
     *
     * @return edit item waiting
     */
    public function EditItemWaitingAction() {
        $id = Input::get('id', 0);
        if ($id > 0) {
            $this->website_info['title'] = '待ち受けの編集';
        } else {
            $this->website_info['title'] = '待ち受けの追加';
        }
        $item = Gift::getItemGiftByIDAndType($id, $this->id_idol, 2);
        if (!empty($item)) {
            $this->setData['item'] = $item;
        }
        $this->setData['id_idol'] = $this->id_idol;
        return $this->ShowTemplate('idols.edit_item_waiting');
    }

    /**
     *
     * @return List gift
     */
    public function GiftListAction() {
        $this->website_info['title'] = 'バッジ画像管理';
        $gifts = Gift::getAllGiftByIdolIDAndType($this->id_idol, 1);
        $this->setData['gifts'] = $gifts;
        $this->setData['id_idol'] = $this->id_idol;
        return $this->ShowTemplate('idols.gift_list');
    }

    /**
     *
     * @return edit gift
     */
    public function EditGiftAction() {
        $id = Input::get('id', 0);
        if ($id > 0) {
            $this->website_info['title'] = 'バッジの編集';
        } else {
            $this->website_info['title'] = 'バッジーの追加';
        }
        $item = Gift::getItemGiftByIDAndType($id, $this->id_idol, 1);
        if (!empty($item)) {
            $this->setData['item'] = $item;
        }
        $this->setData['id_idol'] = $this->id_idol;
        return $this->ShowTemplate('idols.edit_gift');
    }

    /**
     *
     * @return Delete gift
     */
    public function deleteGiftAction() {
        $id = Input::get('id', 0);
        $gift = Gift::find($id);
        if ($gift->is_default == 1) {
            //xoa anh overwrite
            $dataGift = array(
                'id' => $id,
                'image_overwirte' => ''
            );
            Gift::SaveData($dataGift);
        } else {
            $delete = Gift::destroy($id);
        }
        return redirect()->to('admin/idols/giftlist?id_idol=' . $this->id_idol)->with('message', 'バッジーが削除されました。');
    }

    /**
     *
     * @return delete idol
     */
    public function deleteIdolAction() {
        $id = Input::get('id', 0);
        Users::destroy($id);
        return redirect()->to('admin');
    }

    /**
     * Check exist email
     */
    public function remoteEmailAction() {
        $email = Input::get('email', '');
        $id = Input::get('id', 0);
        $uinfo = $id == 0 ? Users::hasUserByEmail(trim($email)) : Users::hasUserByEmailEdit(trim($email), $id);
        if (empty($uinfo)) {
            echo 'true';
        } else {
            echo 'false';
        }
        die();
    }

}
