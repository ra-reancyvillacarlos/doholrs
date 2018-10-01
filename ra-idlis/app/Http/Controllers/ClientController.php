<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Str;

class ClientController extends Controller {
	public function __index(Request $request) {
		$uData = Session::get('uData'); $bAds = DB::table('barangay')->select('*')->get(); $cAds = DB::table('city_muni')->select('*')->get(); $pAds = DB::table('province')->select('*')->get(); $rAds = DB::table('region')->select('*')->get(); $hAds = DB::table('facilitytyp')->select('*')->get();
		if($request->isMethod('get')){
			if($uData != null) {
				return redirect()->route('client.home');
			} else {
				$sLg = array('cmpLoc'=>['bAds'=>$bAds, 'cAds'=>$cAds, 'pAds'=>$pAds, 'rAds'=>$rAds, 'hAds'=>$hAds]);
				if((Session::has('errMsg') && Session::has('errAlt'))) {
					$sLg = ['errMsg'=>Session::get('errMsg'), 'errAlt'=>Session::get('errAlt'), 'cmpLoc'=>['bAds'=>$bAds, 'cAds'=>$cAds, 'pAds'=>$pAds, 'rAds'=>$rAds, 'hAds'=>$hAds]];
					if((Session::has('locHref'))) {
						$sLg = ['errMsg'=>Session::get('errMsg'), 'errAlt'=>Session::get('errAlt'), 'locHref'=>Session::get('locHref'), 'cmpLoc'=>['bAds'=>$bAds, 'cAds'=>$cAds, 'pAds'=>$pAds, 'rAds'=>$rAds, 'hAds'=>$hAds]];
						Session::forget('locHref');
					}
					Session::forget('errMsg'); Session::forget('errAlt');
				}
				return view('client.login', $sLg);
			}
		} else {
			$arrSave = array(); $arrStr = array();
			$arrData = ['uid', 'pwd', 'facilityname', 'facility_type', 'bed_capacity', 'authorizedsignature', 'email', 'contactperson', 'contactpersonno', 'houseno', 'streetname', 'barangay', 'city_muni', 'province', 'zipcode', 'rgnid_address', 'rgnid', 'grpid', 'mapcoordinate', 'ipaddress', 't_date', 't_time', 'fname', 'mname', 'lname', 'contact', 'position', 'def_faci', 'isActive', 'team', 'isAddedBy', 'token'];
			for($i = 0; $i < count($arrData); $i++) {
				$objStr = 'text'.$i;
				if(isset($request->$objStr)) {
					array_push($arrSave, (($i != 1) ? $request->$objStr : Hash::make($request->$objStr)));
					array_push($arrStr, $arrData[$i]);
				}
			}
			if($arrData[0] != $arrStr[0]) {
				return view('client.login', ['errMsg'=>'Some information(s) are missing!', 'errAlt'=>'danger', 'cmpLoc'=>['bAds'=>$bAds, 'cAds'=>$cAds, 'pAds'=>$pAds, 'rAds'=>$rAds, 'hAds'=>$hAds]]);
			} else {
				$chkQry = DB::table('x08')->where('uid', '=', $arrSave[0])->select('uid')->get();
				if(count($chkQry) > 0) {
					return view('client.login', ['errMsg'=>'User already exists!', 'errAlt'=>'warning', 'cmpLoc'=>['bAds'=>$bAds, 'cAds'=>$cAds, 'pAds'=>$pAds, 'rAds'=>$rAds, 'hAds'=>$hAds]]);
				} else {
					$sData = array('name'=>$request->text2,'token'=>$request->text31);
					self::sMailVer($sData, $request);
					if(DB::table('x08')->insert(array_combine($arrStr, $arrSave))) {
						return view('client.login', ['errMsg'=>'Successfully saved entry', 'errAlt'=>'success', 'cmpLoc'=>['bAds'=>$bAds, 'cAds'=>$cAds, 'pAds'=>$pAds, 'rAds'=>$rAds, 'hAds'=>$hAds]]);
					} else {
						return view('client.login', ['errMsg'=>'Error on saving entry', 'errAlt'=>'danger', 'cmpLoc'=>['bAds'=>$bAds, 'cAds'=>$cAds, 'pAds'=>$pAds, 'rAds'=>$rAds, 'hAds'=>$hAds]]);
					}
				}
			}
		}
	}
	public function __login(Request $request) {
		$uData = Session::get('uData');
		if($request->isMethod('get')) {
			if($uData != null) {
				return redirect()->route('client.home');
			} else {
				return redirect()->route('client.login');
			}
		} else {
			$chkQry = DB::table('x08')->where('uid', '=', $request->uid)->select('*')->first();
			if($chkQry != null) {
				$bol_stat = Hash::check($request->pwd, $chkQry->pwd);
				if($bol_stat == true) {
					if($chkQry->token != null) {
						Session::put('errMsg', 'Account not verified. To resend verification, click');
						Session::put('errAlt', 'warning');
						Session::put('locHref', $chkQry->uid);
						return redirect()->route('client.login');
					} else {
						Session::put('uData', $chkQry);
						return redirect()->route('client.home');
					}
				} else {
					Session::put('errMsg', 'Incorrect password.');
					Session::put('errAlt', 'danger');
					return redirect()->route('client.login');
				}
			} else {
				Session::put('errMsg', 'Incorrect username.');
				Session::put('errAlt', 'danger');
				return redirect()->route('client.login');
			}
		}
	}
	public function __logout(Request $request) {
		$uData = Session::get('uData');
		if($uData != null) {
			if($request->isMethod('get')) {
				Session::forget('uData');
				return redirect()->route('client.login');
			} else {

			}
		} else {
			return redirect()->route('client.login');
		}
	}
	public function __home(Request $request) {
		$uData = Session::get('uData');
		if($request->isMethod('get')) {
			if($uData != null) {
				$_retData = ['curUser'=>$uData, 'curPage'=>'home', 'lsApl'=>DB::table('appform')->where('uid', '=', $uData->uid)->select('*')->orderBy('t_date', 'desc')->first()];
				if((Session::has('errMsg') && Session::has('errAlt'))) {
					$errMsg = Session::get('errMsg'); $errAlt = Session::get('errAlt');
					Session::forget('errMsg'); Session::forget('errAlt');
					$_retData = ['curUser'=>$uData, 'curPage'=>'home', 'lsApl'=>DB::table('appform')->where('uid', '=', $uData->uid)->select('*')->orderBy('t_date', 'desc')->first(), 'errMsg'=>$errMsg, 'errAlt'=>$errAlt];
				}
				return view('client.home', $_retData);
			} else {
				return redirect()->route('client.login');
			}
		} else {

		}
	}
	public function __rToken(Request $request, $token) {
		if($request->isMethod('get')) {
			$chkQry = DB::table('x08')->where('token', '=', $token)->select('*')->first();
			if($chkQry != null) {
				DB::table('x08')->where('token', '=', $token)->update(['token'=>NULL]);
				Session::put('errMsg', 'Successfully verified account.');
				Session::put('errAlt', 'success');
				return redirect()->route('client.login');
			} else {
				Session::put('errMsg', 'Error on verifying account. Token must be expired.');
				Session::put('errAlt', 'warning');
				// Session::put('locHref', $chkQry->uid);
				return redirect()->route('client.login');
			}
		} else {
			return redirect()->route('client.login');
		}
	}
	public function __rMail(Request $request, $uid) {
		if($request->isMethod('get')) {
			$nToken = Str::random(40);
			$chkQry = DB::table('x08')->where('uid', '=', $uid)->select('*')->first();
			if($chkQry != null) {
				$dRequest = new \stdClass();
				$dRequest->text2 = $chkQry->facilityname;
				$dRequest->text6 = $chkQry->email;
				$sData = array('name'=>$chkQry->facilityname,'token'=>$nToken);
				self::sMailVer($sData, $dRequest);
				DB::table('x08')->where('uid', '=', $uid)->update(['token'=>$nToken]);
				Session::put('errMsg', 'Successfully sent verification to your account.');
				Session::put('errAlt', 'success');
				return redirect()->route('client.login');
			}
		} else {
			return redirect()->route('client.login');
		}
	}
	public function sMailVer($sData, $request) {
		Mail::send('client.mail', $sData, function($message) use ($request) {
           	$message->to($request->text6, $request->text2)->subject('Verify Email Account');
           	$message->from('doholrs@gmail.com','DOH ySupport');
        });
	}

	// apply
	public function __applyForm(Request $request) {
		$apdForm = []; $uData = Session::get('uData');
		if($uData != null) {
			if($request->isMethod('get')) {
				Session::forget('apHfd');
				$hfserQry = "SELECT h.hfser_id, h.hfser_desc, a.aptid, a.aptdesc, a.trns_desc FROM hfaci_serv_type h LEFT JOIN (SELECT a.hfser_id, a.uid, t.trns_desc, ap.aptdesc, ap.aptid FROM (SELECT * FROM appform WHERE appid IN (SELECT a.appid FROM (SELECT hfser_id, MAX(t_date) AS t_date, uid, MAX(appid) AS appid FROM appform WHERE uid = '$uData->uid' GROUP BY hfser_id, uid) a)) a LEFT JOIN trans_status t ON a.status = t.trns_id LEFT JOIN apptype ap ON ap.aptid = a.aptid) a ON a.hfser_id = h.hfser_id ORDER BY h.seq_num ASC";
				$hfserTbl = DB::select($hfserQry);
				return view('client.apply', ['curUser'=>$uData, 'hfserTbl'=>$hfserTbl]);
			} else {
				if(isset($request->apBtn)) {
					Session::put('apHfd', $request->apHfd);
					$apHfd = $request->apHfd; $apApt = $request->apApt; $nApApt = (($apApt == NULL || $apApt == "") ? "SELECT aptid FROM apptype WHERE apt_reqid IS NULL" : "SELECT aptid FROM apptype WHERE COALESCE(apt_reqid, aptid) IN (SELECT aptid FROM apptype WHERE apt_seq <= (SELECT apt_seq FROM apptype WHERE aptid = '$apApt'))");
					$aptSql = "SELECT ap.*, _at.aptid AS _disabled FROM apptype ap LEFT JOIN ($nApApt) _at ON ap.aptid = _at.aptid ORDER BY ap.apt_seq ASC";
					$aHSql = "SELECT hf.hfser_desc, ap.aptdesc FROM (SELECT hfser_desc FROM hfaci_serv_type WHERE hfser_id = '$apHfd') hf LEFT JOIN (SELECT aptdesc FROM apptype WHERE aptid = '$apApt') ap ON 1=1";
					return view('client.apply', ['curUser'=>$uData, 'aptTbl'=>DB::select($aptSql), 'aHTbl'=>DB::select($aHSql)]);
				} elseif(isset($request->apFApt)) {
					$apHfd = Session::get('apHfd'); $apFTblC = DB::table('apptype')->where('aptid', '=', $request->apFApt)->select('*')->first(); $upApfTbl = []; 
					$upApfDSql = "SELECT u.* FROM `upload` u INNER JOIN (SELECT * FROM `facility_requirements` fr INNER JOIN (SELECT * FROM `type_facility` WHERE hfser_id = 'CON') tf ON fr.typ_id = tf.tyf_id) ru ON u.upid = ru.upid ORDER BY u.updesc ASC"; $upApfNSql = "$upApfDSql";
					if($apFTblC->apt_isUpdateTo != NULL) {
						$upApfSql = "SELECT * FROM appform WHERE appid IN (SELECT a.appid FROM (SELECT hfser_id, MAX(t_date) AS t_date, uid, MAX(appid) AS appid FROM appform WHERE uid = '$uData->uid' AND hfser_id = '$apHfd' AND aptid = '$apFTblC->apt_isUpdateTo' GROUP BY hfser_id, uid) a)";
						$upApfTbl = DB::select($upApfSql);
						$app_Id = $upApfTbl[0]->appid;
						$upApfNSql = "SELECT up.*, ap.filepath, ap.t_date, ap.t_time, ap.evaluation, ap.evaldate, ap.evaltime FROM ($upApfDSql) up LEFT JOIN (SELECT * FROM app_upload WHERE apup_id IN (SELECT aup.apup_id FROM (SELECT MAX(apup_id) AS apup_id, upid FROM app_upload WHERE app_id = '$app_Id' GROUP BY upid) aup)) ap ON up.upid = ap.upid";
					}
					$subUserSql = "SELECT barangay.brgyname, city_muni.cmname, province.provname, region.rgn_desc, facilitytyp.facname FROM x08 x8 LEFT JOIN barangay ON x8.barangay = barangay.brgyid LEFT JOIN city_muni ON city_muni.cmid = x8.city_muni LEFT JOIN province ON province.provid = x8.province LEFT JOIN region ON region.rgnid = x8.rgnid LEFT JOIN facilitytyp ON facilitytyp.facid = x8.facility_type WHERE x8.uid = '$uData->uid'";
					return view('client.apply', ['curUser'=>$uData, 'apFTbl'=>[$apFTblC, DB::table('hfaci_serv_type')->where('hfser_id', '=', $apHfd)->select('*')->first()], 'subUser'=>DB::select($subUserSql), 'clTbl'=>DB::table('class')->select('*')->get(), 'owTbl'=>DB::table('ownership')->select('*')->get(), 'upApfTbl'=>$upApfTbl, 'apUpApfTbl'=>DB::select($upApfNSql), 'isView'=>false]);
				}
			}
		} else {
			return redirect()->route('client.login');
		}
	}
	public function __applyView(Request $request, $form) {
		$uData = Session::get('uData');
		if($uData != null) {
			if($request->isMethod('get')) {
				
			} else {

			}
		} else {
			return redirect()->route('client.login');
		}
	}
	public function __applyNew(Request $request, $form) {
		$uData = Session::get('uData');
		if($uData != null) {
			if($request->isMethod('get')) {

			} else {

			}
		} else {
			return redirect()->route('client.login');
		}
	}

	//payment
	public function __gPayment(Request $request) {
		$uData = Session::get('uData');
		if($uData != null) {
			if($request->isMethod('get')) {
				Session::forget('pApt'); Session::forget('pApid'); Session::forget('pOop'); Session::forget('_fPChg'); Session::forget('_fPDesc'); Session::forget('_fPAmt');
				$appCurSql = "SELECT af.appid, af.uid, af.t_date, ts.canapply, ts.trns_desc, hf.hfser_desc, ap.aptdesc, ap.aptid FROM appform af LEFT JOIN hfaci_serv_type hf ON hf.hfser_id = af.hfser_id LEFT JOIN trans_status ts ON af.status = ts.trns_id LEFT JOIN apptype ap ON ap.aptid = af.aptid WHERE af.uid = '$uData->uid' AND ts.allowedpayment NOT IN (0)";
				return view('client.payment', ['curUser'=>$uData, 'appCur'=>DB::select($appCurSql)]);
			} else {
				if(isset($request->pAptBtn)) {
					Session::forget('pOop'); Session::forget('_fPChg'); Session::forget('_fPDesc'); Session::forget('_fPAmt'); Session::put('pApt', $request->pApt); Session::put('pApid', $request->pApid); $pApid = Session::get('pApid');
					$oopCurSql = "SELECT op.oop_id, op.oop_desc, ao.bool_stat FROM orderofpayment op LEFT JOIN (SELECT oop_id, true AS bool_stat FROM appform_orderofpayment WHERE appid = '$pApid') ao ON op.oop_id = ao.oop_id";
					return view('client.payment', ['curUser'=>$uData, 'oopCur'=>DB::select($oopCurSql)]);
				} elseif(isset($request->pOopBtn)) {
					Session::forget('_fPChg'); Session::forget('_fPDesc'); Session::forget('_fPAmt'); Session::put('pOop', $request->pOop);
					$pApt = Session::get('pApt'); $pOop = Session::get('pOop'); $pApid = Session::get('pApid');
					if($pApt != NULL && $pOop != NULL) {
						$oapCurSql = "SELECT ch.chg_code, ch.cat_id, ch.chg_desc, ch.chg_exp, ch.chg_rmks, ca.amt, ca.aptid, ca.oop_id, ca.chgapp_id FROM chg_app ca LEFT JOIN charges ch ON ch.chg_code = ca.chg_code WHERE (ca.aptid = '$pApt' AND ca.oop_id = '$pOop') ORDER BY chg_desc ASC";
						$oapTblSql = "SELECT op.oop_id, op.oop_desc, ao.oop_total FROM appform_orderofpayment ao LEFT JOIN orderofpayment op ON op.oop_id = ao.oop_id WHERE appid = '$pApid'";
						$oapNewSql = "SELECT op.oop_id, op.oop_desc, ca.amt FROM facoop fc LEFT JOIN orderofpayment op ON op.oop_id = fc.oop_id LEFT JOIN chg_app ca ON ca.chgapp_id = fc.chgapp_id WHERE (fc.facid = '$uData->facility_type' AND fc.oop_id = '$pOop' AND fc.aptid = '$pApt')";
						$usTblSql = "SELECT ts.trns_desc, ap.aptdesc, hf.hfser_desc, op.oop_desc FROM appform af LEFT JOIN trans_status ts ON ts.trns_id = af.status LEFT JOIN apptype ap ON ap.aptid = af.aptid LEFT JOIN hfaci_serv_type hf ON hf.hfser_id = af.hfser_id LEFT JOIN (SELECT oop_desc FROM orderofpayment WHERE oop_id = '$pOop') op ON 1=1 WHERE appid = '$pApid'";
						$catTblSql = "SELECT cat_id, cat_desc FROM category WHERE cat_id IN (SELECT ch.cat_id FROM chg_app ca LEFT JOIN charges ch ON ch.chg_code = ca.chg_code WHERE (ca.aptid = '$pApt' AND ca.oop_id = '$pOop') GROUP BY ch.cat_id ORDER BY chg_desc ASC) ORDER BY cat_id ASC";
						return view('client.payment', ['curUser'=>$uData, 'oapCur'=>DB::select($oapCurSql), 'oapTbl'=>((count(DB::select($oapTblSql)) > 0) ? DB::select($oapTblSql) : DB::select($oapNewSql)), 'usTbl'=>DB::select($usTblSql), 'catTbl'=>DB::select($catTblSql)]);
					}
				} elseif(isset($request->_fPSubBtn)) {
					Session::put('_fPChg', $request->chgapp_id); Session::put('_fPDesc', $request->desc); Session::put('_fPAmt', $request->amt);
					$_fPChg = Session::get('_fPChg'); $_fPDesc = Session::get('_fPDesc'); $_fPAmt = Session::get('_fPAmt');
					return view('client.payment', ['curUser'=>$uData, 'fPGo'=>['_fPChg'=>$_fPChg, '_fPDesc'=>$_fPDesc, '_fPAmt'=>$_fPAmt]]);
				}
			}
		} else {
			return redirect()->route('client.login');
		}
	}
	public function __pPayment(Request $request, $token, $pmt) {
		$uData = Session::get('uData'); $pApt = Session::get('pApt'); $pOop = Session::get('pOop'); $pApid = Session::get('pApid'); $_fPChg = Session::get('_fPChg'); $_fPDesc = Session::get('_fPDesc'); $_fPAmt = Session::get('_fPAmt'); $_today = Carbon::now();
		if($uData != null) {
            if($token != '' && $pmt != '') {
				if($request->isMethod('get')) {

				} else {
					if(isset($request->au_file)) {
						$_file = $request->au_file;
						$filename = $FileUploaded->getClientOriginalName(); 
		                $filenameOnly = pathinfo($filename,PATHINFO_FILENAME); 
		                $fileExtension = $_file->getClientOriginalExtension();
		                $fileNameToStore = $uData->uid.'_'.$newAsmt.'.'.$fileExtension;
		                $path = $_file->storeAs('public/uploaded', $fileNameToStore);
		                $fileSize = $_file->getClientSize();
						$arrData = ['app_id', 'upid', 'filepath', 'fileExten', 'fileSize', 't_date', 't_time', 'ipaddress'];
						$arrSave = [$pApid, NULL, $fileNameToStore, $fileExtension, $fileSize, $_today->toDateString(), $_today->toTimeString(), request()->ip()];
						DB::table('app_upload')->insert(array_combine($arrData, $arrSave));
					}
				}
            	$arrAll = [];
            	$arrData = ['chgapp_id', 'chg_num', 'appform_id', 'chgapp_id_pmt', 'au_id', 'au_date', 'reference', 'amount', 't_date', 't_time', 't_ipaddress', 'uid', 'sysdate', 'systime'];
            	$_nTotal = 0; $_nDesc = ((isset($request->au_ref)) ? $request->au_ref : "Payment");
            	for($i = 0; $i < count($_fPAmt); $i++) {
            		$_nChgApp = (($_fPChg[$i] != NULL) ? $_fPChg[$i] : $pmt);
            		$_chgNum = DB::table('chg_app')->where('chgapp_id', '=', $_nChgApp)->select('chg_num')->first();
            		$_nTotal = $_nTotal + intval($_fPAmt[$i]);
            		$curArr = array_combine($arrData, [$_nChgApp, $_chgNum->chg_num, $pApid, NULL, NULL, NULL, $_fPDesc[$i], $_fPAmt[$i], $_today->toDateString(), $_today->toTimeString(), request()->ip(), $uData->uid, $_today->toDateString(), $_today->toTimeString()]);
            		array_push($arrAll, $curArr);
            		DB::table('chg_app')->where('chgapp_id', '=', $_nChgApp)->update(['chg_num'=>(intval($_chgNum->chg_num) + 1)]);
            	}
            	if($_nTotal > 0) {
                	$_nChgNum = DB::table('chg_app')->where('chgapp_id', '=', $pmt)->select('chg_num')->first();
                	$nCurArr = array_combine($arrData, [$pmt, $_nChgNum->chg_num, $pApid, NULL, NULL, NULL, $_nDesc, (((isset($request->au_amount)) ? $request->au_amount : $_nTotal)*-1), $_today->toDateString(), $_today->toTimeString(), request()->ip(), $uData->uid, $_today->toDateString(), $_today->toTimeString()]);
            		array_push($arrAll, $nCurArr);
            	}
        		DB::table('chg_app')->where('chgapp_id', '=', $_nChgApp)->update(['chg_num'=>(intval($_chgNum->chg_num) + 1)]);
            	for($i = 0; $i < count($arrAll); $i++) {
            		DB::table('chgfil')->insert($arrAll[$i]);
            	}
            	DB::table('appform')->where('appid', '=', $pApid)->update(['status'=>'PP']);
            	Session::flash('errMsg', 'Successfully saved entry for payment.');
            	Session::flash('errAlt', 'success');                	
            	return redirect()->route('client.home');
            }
		} else {
			return redirect()->route('client.login');
		}
	}

	// evaluate
	public function __evaluate(Request $request) {
		$uData = Session::get('uData');
		if($uData != null) {
			if($request->isMethod('get')) {
				Session::forget('eApid'); Session::forget('eHfd');
				$evTblSql = "SELECT af.appid, af.uid, hf.hfser_id, hf.hfser_desc, ap.aptdesc FROM appform af LEFT JOIN hfaci_serv_type hf ON af.hfser_id = hf.hfser_id LEFT JOIN apptype ap ON ap.aptid = af.aptid WHERE af.uid = '$uData->uid' AND ap.apt_reqAst = 1 ORDER BY af.hfser_id ASC";
				return view('client.evaluate', ['curUser'=>$uData, 'evTbl'=>DB::select($evTblSql)]);
			} else {
				if(isset($request->eApid)) {
					Session::put('eApid', $request->eApid); Session::put('eHfd', $request->eHfd);
					$eApid = Session::get('eApid'); $eHfd = Session::get('eHfd');
					$eApTblSql = "SELECT up.upid, up.updesc, ap.app_id, ap.evaluation, ap.remarks FROM facility_requirements fr LEFT JOIN type_facility tr ON tr.tyf_id = fr.typ_id LEFT JOIN upload up ON up.upid = fr.upid LEFT JOIN (SELECT upid, app_id, evaluation, remarks FROM app_upload WHERE app_id = '$eApid') ap ON ap.upid = up.upid WHERE (tr.hfser_id = '$eHfd' AND tr.facid = '$uData->facility_type') ORDER BY updesc ASC";
					$eAfTblSql = "SELECT isrecommended, recommendeddate, recommendedtime FROM appform WHERE appid = '$eApid'";
					return view('client.evaluate', ['curUser'=>$uData, 'eApTbl'=>DB::select($eApTblSql), 'eAfTbl'=>DB::select($eAfTblSql)]);
				}
			}
		} else {
			return redirect()->route('client.login');
		}
	}
}