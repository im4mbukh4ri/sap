<?php

namespace App\Http\Controllers\Admin;

use App\Charity;
use App\CharityTransaction;
use App\HistoryDeposit;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use JavaScript;
use Log;

class CharitiesController extends Controller {
	public function __construct() {
		$this->middleware(['auth', 'csrf']);
	}

	public function index() {
		if(auth()->user()->username != 'mastersip') {
			return redirect()->back();
		}
		$charites = Charity::all();
		return view('admin.charitis.index', compact('charites'));
	}
	public function create(Request $request) {
		$this->validate($request, [
			'title' => 'required',
		]);
		$fileName = null;
		// dd($request->all());
		if (request()->hasFile('file')) {
			// dd();
			$this->validate($request, [
				'file' => 'mimes:jpeg,bmp,png,jpg',
			]);
			$file = $request->file('file');
			$name = time() . '.' . $file->guessExtension();
			$destinationPath = base_path() . '/public/images/charities';
			$request->file('file')->move($destinationPath, $name);
			$url_image = url('images/charities/' . $name);
		} else {
			$url_image = 0;
		}
		if ($request->has('id_charity')) {
			$update = Charity::find($request->id_charity);
			$filename = $update->url_image;
			$update->title = $request->title;
			$update->content = $request->content;
			// dd($request->all());
			$update->status = $request->status;
			if ($url_image !== 0) {
				$explode = explode('/', $request->filename);
				$filename = $explode[5];
				$this->deletePicture($filename);
				$update->url_image = $url_image;
			}
			$update->update();
			flash()->overlay('Charity Berhasil diUpdate.', 'INFO');
			return redirect(route('admin.operational_charitis'));
		} else {
			DB::beginTransaction();
			try {

				Charity::create([
					'title' => request()->get('title'),
					'content' => request()->get('content'),
					'status' => '1',
					'url_image' => $url_image,
				]);

			} catch (\Exception $e) {
				DB::rollback();
				Log::info('Failed create announcement, error:' . $e->getMessage());
				flash()->overlay('Terjadi kesalahan, Chariti gagal diposting.', 'INFO');
				return redirect(route('admin.operational_charitis'));
			}
			DB::commit();
			flash()->overlay('Berita Chariti diposting.', 'INFO');
			return redirect(route('admin.operational_charitis'));
		}
	}
	protected function deletePicture($filename) {
		$path = public_path() . DIRECTORY_SEPARATOR . 'images'
			. DIRECTORY_SEPARATOR . 'charities' . DIRECTORY_SEPARATOR . $filename;
		return File::delete($path);
	}
	public function datacharity(Request $request) {
		$from = date("Y-m-d", time());
		$until = date("Y-m-d", time());
		if ($request->has('from') && $request->has('until')) {
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$charities = CharityTransaction::whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->where('charity_id', 'like', '%' . $request->charity_id . '%')->get();
			$request->flash();
			JavaScript::put([
				'request' => [
					'from' => $from,
					'until' => $until,
				],
			]);
			$request->flash();
		} else {
			$date = date('Y-m-d');
			$charities = CharityTransaction::whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->get();
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		return view('admin.charitis.report', compact('charities', 'from', 'until', 'charity_id'));
	}
	public function saldo(Request $request) {
		$from = date('Y-m-d', time());
		$until = $from;
		$saldoses = array();
		if ($request->has('from') && $request->has('until')) {
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			if (daysDifference($until, $from) < 31) {
				$saldoses = HistoryDeposit::where('user_id', 1)
					->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('id');
				$request->flash();
			} else {
				flash()->overlay('History deposit yang bisa Anda cek maksimal 31 hari.', 'INFO');
				return redirect()->back();
			}
		} else {
			$saldoses = HistoryDeposit::where('user_id', 1)
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('id');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		return view('admin.charitis.saldo', compact('saldoses'));
	}
	public function edit($id) {
		$datas = Charity::find($id);
		return view('admin.charitis.edit', compact('datas'));
	}

	// public function open($id) {
	// 	$data = Charity::find($id);
	// 	$data->status = 1;
	// 	$data->update();
	// 	flash()->overlay('Charity Berhasil Dibuka.', 'INFO');
	// 	return redirect(route('admin.operational_charitis'));
	// }

	// public function close($id) {
	// 	$data = Charity::find($id);
	// 	flash()->overlay('Charity Berhasil Ditutup.', 'INFO');
	// 	return redirect(route('admin.operational_charitis'));
	// }

	public function status(Request $request) {
		// dd();
		$data = Charity::find($request->id);
		$data->status = $request->status;

		if($request->status == 1){
			$data->status = $request->status;
			flash()->overlay('Charity Berhasil Dibuka.', 'INFO');
		} else {
			$data->status = $request->status;
			flash()->overlay('Charity Berhasil Ditutup.', 'INFO');
		}
		$data->update();
		return redirect(route('admin.operational_charitis'));
	}
}
