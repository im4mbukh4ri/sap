<?php
namespace App\Helpers\Ppob;

use App\BlocklistNumber;
use App\Helpers\Deposit\Deposit;
use App\Helpers\Point\Point;
use App\Helpers\SipPpob;
use App\PpobBpjs;
use App\PpobCommission;
use App\PpobFinance;
use App\PpobPdam;
use App\PpobPdamPenalty;
use App\PpobPhone;
use App\PpobPlnPasca;
use App\PpobPlnPra;
use App\PpobService;
use App\PpobTagMonth;
use App\PpobCreditCard;
use App\PpobTransactionNumber;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PpobTransaction
{
    protected $request;
    protected $userId;
    protected $response;
    protected $nra;
    protected $markup;
    protected $rqid;
    protected $mmid;
    private $ppobTransaction;
    private $status;
    private $pulsaCommission;
    private $user;
    private $percentPusat;
    private $percentBv;
    private $percentMember;
    private $product;
    private $detailTransaction;

    public function setRequest($request)
    {
        $this->$request = $request;
    }
    public function getRequest()
    {
        return $this->request;
    }

    public function get()
    {
        return $this->response;
    }
    public function toJson()
    {
        $this->response = json_encode($this->response);
        return $this->response;
    }
    protected function createData()
    {
        $this->user = User::find($this->userId);
        $arrRequest = json_decode($this->getRequest(), true);
        $time = time();
        $arrRequest['number'] = str_replace(' ', '', $arrRequest['number']);
        $isBlock = BlocklistNumber::find($arrRequest['number']);
        if($isBlock){
            return $this->response = [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => array('Process failed. Please try again later.'),
                ],
            ];
        }
        $historyTransaction = \App\PpobTransaction::where('user_id', '=', $this->userId)->whereBetween(
            'created_at',
            [date('Y-m-d 00:00:00', $time), date('Y-m-d 23:59:59', $time)]
        )
            ->where('number', '=', $arrRequest['number'])->where('ppob_service_id', '=', $arrRequest['code'])->whereIn('status', ['PROCESS', 'PENDING', 'SUCCESS'])
            ->orderBy('id', 'desc')->first(['created_at']);
        if ($historyTransaction) {
            $lastTime = strtotime($historyTransaction->created_at);
            $diffTime = $time - $lastTime;
            if ($diffTime <= 3600) {
                $confirmTime = 60 - ceil($diffTime / 60);
                return $this->response = [
                    'status' => [
                        'code' => 400,
                        'confirm' => 'failed',
                        'message' => array('Maaf transaksi Anda gagal. Telah ditemukan data yang sama, silahkan ulang kembali dalam ' . $confirmTime . ' menit'),
                    ],
                ];
            }
        }
        if (isset($arrRequest['commission'])) {
            $check = Deposit::check($this->userId, $arrRequest['price'] - $arrRequest['commission'])->get();
        } else {
            $check = Deposit::check($this->userId, $arrRequest['price'])->get();
        }
        if ($check) {
            DB::beginTransaction();
            try {
                $idTransaction = ''; // $this->getTransactionId();
                $this->product = PpobService::find($arrRequest['code']);
                $this->ppobTransaction = new \App\PpobTransaction();
                $this->ppobTransaction->id_transaction = $idTransaction;
                $this->ppobTransaction->user_id = $this->userId;
                $this->ppobTransaction->service = $arrRequest['service_id'];
                $this->ppobTransaction->ppob_service_id = $arrRequest['code'];
                $this->ppobTransaction->number = $arrRequest['number'];
                $this->ppobTransaction->pr = $arrRequest['pr'];
                if (isset($arrRequest['paxpaid'])) {
                    $this->ppobTransaction->paxpaid = $arrRequest['paxpaid'];
                } else {
                    $this->ppobTransaction->paxpaid = $arrRequest['price'];
                }
                if (isset($arrRequest['markup'])) {
                    $this->ppobTransaction->markup = $arrRequest['markup'];
                }
                if (isset($arrRequest['bv_markup'])) {
                    $this->ppobTransaction->bv_markup = $arrRequest['bv_markup'];
                }
                $this->ppobTransaction->status = "PROCESS";
                if (isset($arrRequest['device'])) {
                    $this->ppobTransaction->device = $arrRequest['device'];
                } else {
                    $this->ppobTransaction->device = 'undefined';
                }
                $this->ppobTransaction->save();
                $this->ppobTransaction->id_transaction = $this->ppobTransaction->id;
                $this->ppobTransaction->save();
                DB::commit();
                $debit = Deposit::debit($this->userId, $arrRequest['price'], 'ppob|' . $this->ppobTransaction->id . "|Payment " .
                    $this->product->name . " - " .
                    $this->ppobTransaction->number . "")->get();
                if ($debit['status']['code'] == 200) {
                    if (isset($arrRequest['point'])) {
                        Point::debit($this->userId, (int)$arrRequest['point'], 'ppob|' . $this->ppobTransaction->id . "|Payment " .
                            $this->product->name . " - " .
                            $this->ppobTransaction->number . "")->get();
                    }
                    $product = getService($arrRequest['service_id']);
                    switch ($arrRequest['service_id']) {
                        case 2:
                            $productCode = PpobService::find($arrRequest['service_id'])->code;
                            break;
                        case 3:
                            $productCode = PpobService::find($arrRequest['service_id'])->code;
                            break;
                        default:
                            $productCode = PpobService::find($arrRequest['code'])->code;
                            break;
                    }
                    $param = [
                        'rqid' => $this->rqid,
                        'app' => 'transaction',
                        'action' => 'trx_ppob',
                        'mmid' => $this->mmid,
                        'product' => $product,
                        'product_code' => $productCode,
                    ];
                    if ($this->userId == 1327) {
                        $param['mmid'] = "retross_01";
                    }
                    if ($arrRequest['service_id'] == 2) {
                        $param['voucher'] = PpobService::find($arrRequest['code'])->code;
                    }
                    if ($arrRequest['service_id'] == 348) {
                        $param['nominal'] = $arrRequest['nominal'];
                    }
                    if ($arrRequest['service_id'] != 1 && $arrRequest['service_id'] != 2 && $arrRequest['service_id'] != 3 && $arrRequest['service_id'] != 9 && $arrRequest['service_id'] != 18 && $arrRequest['service_id'] != 348) {
                        $param['reff'] = $arrRequest['reff'];
                    }
                    if ($product == 'PUL') {
                        $param['nohp'] = $this->ppobTransaction->number;
                    } else {
                        $param['noid'] = $this->ppobTransaction->number;
                    }
                } else {
                    Log::info("GAGAL DEBIT SALDO PPOB id : " . $this->ppobTransaction->id);
                    $this->ppobTransaction->status = "FAILED";
                    $this->ppobTransaction->save();
                    DB::commit();
                    return $this->response = [
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => array('Gagal debit saldo. Silahkan ulangi kembali transaksi Anda'),
                        ],
                    ];
                }
            } catch (\Exception $e) {
                DB::rollback();
                return $this->response = [
                    'status' => [
                        'code' => 400,
                        'confirm' => 'failed',
                        'message' => array('Transaksi gagal. Error : ' . $e),
                    ],
                ];
            }
            DB::commit();
            $attributes = json_encode($param);
            $result = SipPpob::transaction($attributes)->get();
            if ($result['error_code'] == "000") {
                $this->ppobTransaction->transaction_number()->save(new PpobTransactionNumber([
                    'transaction_number' => $result['notrx'],
                ]));
                if ($this->user->role != 'free') {
                    $this->percentPusat = $this->user->type_user->pusat_ppob->commission;
                    $this->percentBv = $this->user->type_user->bv_ppob->commission;
                    $this->percentMember = $this->user->type_user->member_ppob->commission;
                } else {
                    $this->percentPusat = $this->user->parent->type_user->pusat_ppob->commission;
                    $this->percentBv = $this->user->parent->type_user->bv_ppob->commission;
                    $this->percentMember = $this->user->parent->type_user->member_ppob->commission;
                }
                $nta = 0;
                if (isset($result['nra'])) {
                    $this->nra = $result['nra'];
                    $nta = $result['total'] - $result['nra'];
                }
                switch ($arrRequest['service_id']) {
                    case 1:
                        //                        if($this->user->username=='member_silver'||$this->user->username=='member_gold'||$this->user->username=='member_platinum'||$this->user->username=='member_free'||$this->user->username=='trialdev'){
                        $this->ppobTransaction->nta = (int)$result['total'];
                        $this->ppobTransaction->nra = $arrRequest['nra'];
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $arrRequest['nra'],
                            'komisi' => $arrRequest['nra'],
                            'free' => $arrRequest['free'],
                            'pusat' => $arrRequest['pusat'],
                            'bv' => $arrRequest['bv'],
                            'member' => $arrRequest['commission'],
                            'upline' => $arrRequest['upline'],
                        ]));
                        //                        }else{
                        //                            if($this->user->role!='free'){
                        //                                $nra=$this->nra;
                        //                                $komisi=abs($nra);
                        //                                $free=0;
                        //                                $upline=0;
                        //                            }else{
                        //                                $nra = $this->nra+$this->markup;
                        //                                $komisi=$this->nra;
                        //                                $free=$this->markup;
                        //                                $upline=0;
                        //                            }
                        //                            $pusat = intval(($komisi * $this->percentPusat)/100);
                        //                            $bv = intval(($komisi * $this->percentBv)/100);
                        //                            $member= intval(($komisi * $this->percentMember)/100);
                        //                            $this->ppobTransaction->nta=(int)$arrRequest['paxpaid']-(int)$nra;
                        //                            $this->ppobTransaction->nra=$nra;
                        //                            $this->ppobTransaction->status=$result['status'];
                        //                            $this->ppobTransaction->save();
                        //                            $this->ppobTransaction->transaction_commission()->save( new PpobCommission([
                        //                                'nra'=>$nra,
                        //                                'komisi'=>$komisi,
                        //                                'free'=>$free,
                        //                                'pusat'=>$pusat,
                        //                                'bv'=>$bv,
                        //                                'member'=>$member,
                        //                                'upline'=>$upline
                        //                            ]));
                        //                        }
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, $arrRequest['upline'], 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 2:
                        $this->ppobTransaction->nta = $arrRequest['paxpaid'] - $this->nra;
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->pln_pra()->save($this->detailTransaction = new PpobPlnPra([
                            'customer_name' => $result['nama'],
                            'kwh' => $result['kwh'],
                            'golongan_daya' => $result['tarif'],
                            'nominal' => $result['nominal'],
                            'rp_token' => $result['rptoken'],
                            'admin' => $result['admin'],
                            'ppn' => $result['ppn'],
                            'ppj' => $result['ppj'],
                            'materai' => $result['materai'],
                            'token' => $result['token'],
                            'reff' => $result['reff'],
                        ]));
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->name . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 3:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save($this->detailTransaction = new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->pln_pasca()->save($this->detailTransaction = new PpobPlnPasca([
                            'customer_name' => $result['nama'],
                            'golongan_daya' => $result['tarif'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'stand_meter' => $result['stand_meter'],
                            'period' => $result['periode'],
                        ]));
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 4:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->qty = $result['bill_qty'];
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->phone()->save($this->detailTransaction = new PpobPhone([
                            'customer_name' => $result['nama'],
                            'period' => $result['periode'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'ref' => $result['reff'],
                        ]));
                        for ($i = 1; $i <= intval($result['bill_qty']); $i++) {
                            $this->ppobTransaction->tag_months()->save(new PpobTagMonth([
                                'month' => $i,
                                'bill' => $result['tagbln' . $i],
                            ]));
                        }

                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 5:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->qty = $result['bill_qty'];
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->phone()->save($this->detailTransaction = new PpobPhone([
                            'customer_name' => $result['nama'],
                            'period' => $result['periode'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'ref' => $result['reff'],
                        ]));
                        for ($i = 1; $i <= intval($result['bill_qty']); $i++) {
                            $this->ppobTransaction->tag_months()->save(new PpobTagMonth([
                                'month' => $i,
                                'bill' => $result['tagbln' . $i],
                            ]));
                        }
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 6:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->qty = $result['bill_qty'];
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->phone()->save($this->detailTransaction = new PpobPhone([
                            'customer_name' => $result['nama'],
                            'period' => $result['periode'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'ref' => $result['reff'],
                        ]));
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 7:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->qty = $result['bill_qty'];
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->finance()->save($this->detailTransaction = new PpobFinance([
                            'customer_name' => $result['nama'],
                            'period' => $result['tempo'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'ref' => $result['reff'],
                            'tenor' => $result['tenor'],
                            'no_polisi' => $result['no_polisi'],
                        ]));
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 8:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->qty = $result['bill_qty'];
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->pdam()->save($this->detailTransaction = new PpobPdam([
                            'customer_name' => $result['nama'],
                            'pdam_name' => $result['pdam_name'],
                            'period' => $result['periode'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'ref' => $result['reff'],
                        ]));
                        for ($i = 1; $i <= intval($result['bill_qty']); $i++) {
                            $this->ppobTransaction->tag_months()->save(new PpobTagMonth([
                                'month' => $i,
                                'bill' => $result['tagbln' . $i],
                            ]));
                        }
                        for ($i = 1; $i <= intval($result['bill_qty']); $i++) {
                            $this->ppobTransaction->pdam_penalties()->save(new PpobPdamPenalty([
                                'month' => $i,
                                'first_meter_read' => $result['first_meter' . $i],
                                'last_meter_read' => $result['last_meter' . $i],
                                'penalty' => intval($result['penalty' . $i]),
                                'misc_amount' => intval($result['misc_amount' . $i]),
                            ]));
                        }
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 9:
                        $this->ppobTransaction->nta = $result['total'] - $this->nra;
                        $this->ppobTransaction->qty = $result['bill_qty'];
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->bpjs()->save($this->detailTransaction = new PpobBpjs([
                            'customer_name' => $result['nama'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'ref' => $result['reff'],
                            'kode_cabang' => $result['kdcabang'],
                            'nama_cabang' => $result['nmcabang'],
                        ]));
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, (int)$upline, 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 18:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->qty = 1;
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->nta = (int)$result['total'];
                        $this->ppobTransaction->nra = $nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, $arrRequest['upline'], 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                    case 348:
                        $this->ppobTransaction->nta = $nta;
                        $this->ppobTransaction->qty = 1;
                        $this->ppobTransaction->nra = $this->nra;
                        $this->ppobTransaction->status = $result['status'];
                        $this->ppobTransaction->save();
                        $nra = $this->nra;
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $free = (int)$nra - (int)$komisi;
                        $pusat = ((int)$komisi * (int)$this->percentPusat) / 100;
                        $bv = ((int)$komisi * (int)$this->percentBv) / 100;
                        $member = ((int)$komisi * (int)$this->percentMember) / 100;
                        $upline = 0;
                        if ($this->user->role == 'free') {
                            $feeMember = ($member * $this->user->type_user->member_ppob->commission) / 100;
                            $feePusat = ($member * $this->user->type_user->pusat_ppob->commission) / 100;
                            $upline = $member - $feeMember - $feePusat;
                            $member = $feeMember;
                            $pusat = $pusat + $feePusat;
                        }
                        $this->ppobTransaction->transaction_commission()->save(new PpobCommission([
                            'nra' => $nra,
                            'komisi' => $komisi,
                            'free' => $free,
                            'pusat' => ceil($pusat),
                            'bv' => floor($bv),
                            'member' => floor($member),
                            'upline' => floor($upline),
                        ]));
                        $this->ppobTransaction->credit_card()->save($this->detailTransaction = new PpobCreditCard([
                            'customer_name' => $result['nama'],
                            'nominal' => $result['nominal'],
                            'admin' => $result['admin'],
                            'ref' => $result['reff'],
                        ]));
                        if ($result['status'] == "SUCCESS") {
                            if ($this->user->role == 'free') {
                                Deposit::credit($this->user->parent->id, $arrRequest['upline'], 'ppob|' . $this->ppobTransaction->id . "|Kredit Smart Cash Referal ( " . $this->user->username . " )" .
                                    $this->product->name . " - " .
                                    $this->ppobTransaction->number . "");
                            }
                        }
                        break;
                }
                return $this->response = [
                    'status' => [
                        'code' => 200,
                        'confirm' => 'success',
                        'message' => array('Berhasil payment ' . $this->product->name . ' - ' . $this->ppobTransaction->id),
                    ],
                    'details' => [
                        'transaction' => $this->ppobTransaction,
                        'detail_transaction' => $this->detailTransaction,
                    ],
                ];
            }
            $this->ppobTransaction->status = "FAILED";
            $this->ppobTransaction->save();
            Deposit::credit($this->userId, $arrRequest['price'], 'ppob|' . $this->ppobTransaction->id . "|Refund " .
                $this->product->name . " - " .
                $arrRequest['number'] . "");
            if (isset($arrRequest['point'])) {
                Point::credit($this->userId, (int)$arrRequest['point'], 'ppob|' . $this->ppobTransaction->id . "|Refund " .
                    $this->product->name . " - " .
                    $arrRequest['number'] . "")->get();
            }
            DB::commit();
            return $this->response = [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => array($result['error_msg']),
                ],
            ];
        }
        return $this->response = [
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => array('Saldo tidak cukup'),
            ],
        ];
    }

    private function getTransactionId()
    {
        $i = 1;
        $transactionId = null;
        while (true) {
            $transactionId = $i . '02' . substr("" . time(), -5);
            if (\App\PpobTransaction::where('id_transaction', '=', $transactionId)->first() === null) {
                break;
            }
            $i++;
        }
        return $transactionId;
    }
}
