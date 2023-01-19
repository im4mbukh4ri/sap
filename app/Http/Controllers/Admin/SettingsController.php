<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Http\Controllers\Controller;
use App\IdrCommission;
use App\IdrMarkup;
use App\IdrPrice;
use App\PointMax;
use App\PointReward;
use App\PointValue;
use App\PpobService;
use App\User;
use DB;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

	public function pulsa()
	{
		if (auth()->user()->username != 'mastersip') {
			return redirect()->back();
		}
		$operators = PpobService::where('parent_id', 1)->where('status', 1)->get();
		return view('admin.settings.price.pulsa.index', compact('operators'));
	}
	public function pulsaUpdate(Request $request, $id_operator)
	{
		// return $request->all();
		$operator = PpobService::find($id_operator);
		$messages = array();
		foreach ($operator->childs as $key => $nominal) {
			if ($nominal->pulsa_commission->first()->commission != trim($request->commission[$key])) {
				$commission = IdrCommission::firstOrCreate(['commission' => $request->commission[$key]]);
				//return $commission;
				DB::beginTransaction();
				try {
					$nominal->pulsa_commission()->detach();
					$nominal->pulsa_commission()->attach($commission);
				} catch (\Exception $e) {
					DB::rollback();
					$message[] = 'Gagal merubah komisi ' . $nominal->name . ', Error :' . $e->getMessage();
				}
				DB::commit();
				$messages[] = $nominal->name . ' update komisi menjadi ' . $request->commission[$key];
			}
			if ($nominal->pulsa_markup->first()->markup != trim($request->markup[$key])) {
				$markup = IdrMarkup::firstOrCreate(['markup' => $request->markup[$key]]);
				DB::beginTransaction();
				try {
					$nominal->pulsa_markup()->detach();
					$nominal->pulsa_markup()->attach($markup);
				} catch (\Exception $e) {
					DB::rollback();
					$message[] = 'Gagal merubah markup ' . $nominal->name . ', Error :' . $e->getMessage();
				}
				DB::commit();
				$messages[] = $nominal->name . ' update markup menjadi ' . $request->markup[$key];
			}
			if ($nominal->pulsa_bv_markup->first()->markup != trim($request->bv_markup[$key])) {
				$bvmarkup = IdrMarkup::firstOrCreate(['markup' => $request->bv_markup[$key]]);
				DB::beginTransaction();
				try {
					$nominal->pulsa_bv_markup()->detach();
					$nominal->pulsa_bv_markup()->attach($bvmarkup);
				} catch (\Exception $e) {
					DB::rollback();
					$message[] = 'Gagal merubah markup smart point' . $nominal->name . ', Error :' . $e->getMessage();
				}
				DB::commit();
				$messages[] = $nominal->name . ' update markup smart point menjadi ' . $request->bv_markup[$key];
			}
			if ($nominal->pulsa_price->first()->price != trim($request->price[$key])) {
				$price = IdrPrice::firstOrCreate(['price' => $request->price[$key]]);
				DB::beginTransaction();
				try {
					$nominal->pulsa_price()->detach();
					$nominal->pulsa_price()->attach($price);
				} catch (\Exception $e) {
					DB::rollback();
					$message[] = 'Gagal merubah harga ' . $nominal->name . ', Error :' . $e->getMessage();
				}
				DB::commit();
				$messages[] = $nominal->name . ' update harga menjadi ' . $request->price[$key];
			}
		}
		$message = '';
		foreach ($messages as $val) {
			$message .= $val . '<br>';
		}
		flash()->overlay('Berhasil update smart member / komisi / markup <br>' . $message, 'INFO');
		return redirect()->back();
	}
	public function point()
	{
		if (auth()->user()->username != 'mastersip') {
			return redirect()->back();
		}
		$point_reward = PointReward::find(1);
		$point_value = PointValue::find(1);
		$point_max = PointMax::find(1);
		$basic = PointValue::find(2);
		$advance = PointValue::find(3);
		$free = PointValue::find(5);
		return view('admin.settings.points.index', compact('point_reward', 'point_value', 'point_max', 'basic', 'advance', 'free'));
	}
	public function updatePoint(Request $request)
	{
		if ($request->limit = 1) {
			$basic = PointValue::find(2);
			$reqBasic = str_replace(',', '', $request->basic);
			$basic->idr = $reqBasic;
			$basic->update();
			$advance = PointValue::find(3);
			$reqAdvance = str_replace(',', '', $request->advance);
			$advance->idr = $reqAdvance;
			$advance->update();
			$free = PointValue::find(5);
			$reqFree = str_replace(',', '', $request->free);
			$free->idr = $reqFree;
			$free->update();
			flash()->overlay('Berhasil update setting Limit Deposit', 'INFO');
			return redirect()->back();
		}
		$point_reward = PointReward::find(1);
		$point_reward->point = $request->point_reward;
		$point_reward->save();
		$point_value = PointValue::find(1);
		$point_value->idr = $request->point_value;
		$point_value->save();
		$point_max = PointMax::find(1);
		$point_max->point = $request->point_max;
		$point_max->save();
		flash()->overlay('Berhasil update setting point', 'INFO');
		return redirect()->back();
	}
	public function administrator()
	{
		if (auth()->user()->username != 'mastersip') {
			return redirect()->back();
		}
		$administrators = User::where('type_user_id', '1')->get();
		//return $administrators;
		return view('admin.settings.administrators.index', compact('administrators'));
	}
	public function postadministrator(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'username' => 'required|unique:users,username',
			'member_phone' => 'required|unique:addresses,phone|numeric|min:10',
			'gender' => 'required',
			'email' => 'required|email|unique:users,email',
			'birth_date' => 'required',
			'role' => 'required',
			'password' => 'required',
		]);
		DB::beginTransaction();
		try {
			$member_address = Address::create([
				'detail' => '',
				'subdistrict_id' => 999999,
				'phone' => $request->member_phone,
			]);
			$member_address->user()->save($newUser = new User([
				'username' => trim($request->username),
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
				'role' => $request->role,
				'gender' => $request->gender,
				'birth_date' => date('Y-m-d', strtotime($request->birth_date)),
				'upline' => 1,
				'created_by' => 1,
				'actived' => 0,
				'type_user_id' => 1,
			]));
		} catch (\Exception $e) {
			DB::rollback();
			flash()->overlay('Terjadi kesalahan, Data gagal diposting.', 'INFO');
			return redirect(route('admin.administrator'));
		}
		DB::commit();
		flash()->overlay('Data berhasil di Simpan.', 'INFO');
		return redirect(route('admin.administrator'));
	}
}
