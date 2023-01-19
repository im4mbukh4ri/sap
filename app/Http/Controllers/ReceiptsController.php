<?php

namespace App\Http\Controllers;

use App\AirlinesTransaction;
use App\PpobTransaction;
use App\TrainTransaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Dompdf\Dompdf;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Log;

class ReceiptsController extends Controller
{
    //
    public function activation(Request $request)
    {
        $user = User::where('password', $request->key)->first();
        if ($user) {
            if ($user->actived === 1) {
                $message = "Link sudah kadaluarsa.";
                //flash()->overlay($message,'INFO');
                return view('pages.email-activation', compact('message'));
            }
            $user->actived = 1;
            $user->save();
            // $point=\App\PointReward::find(1)->point;
            // $reward = Point::credit($user->upline,$point,'reward|'.$user->id.'|Point Reward dari '.$user->name)->get();
            $message = "<p>Aktivasi akun Anda berhasil.</p> <span id=\"linkAndroid\">Silahkan login <a href=\"market://details?id=com.droid.sip\" >disini</a></span><span id=\"linkIPhone\">Silahkan login <a href=\"market://details?id=com.droid.sip\" >iphone</a></span>";
            //flash()->overlay($message,'INFO');
            return view('pages.email-activation', compact('message'));
        }
        $message = "Link sudah kadaluarsa.";
        //flash()->overlay($message,'INFO');
        return view('pages.email-activation', compact('message'));
    }

    public function pulsa(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $data = PpobTransaction::find($id);
        $data->service_fee = $service_fee;
        if ($data) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('partials.receipts.pulsa.pulsa', ['data' => $data]);
            return $pdf->download('struk-' . $data->number . '.pdf');
        }
        return "not found";
    }

    public function pulsaReceipt(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $data = PpobTransaction::find($id);
        $data->service_fee = $service_fee;
        if ($data) {
            if ($request->action == 'view') {
                return view('partials.receipts.pulsa.pulsa-new', compact('data'));
            }
            $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('pulsa.receipt_download', ['id' => $id, 'action' => 'view']));
            $content = json_decode($content, true);
            return response()->download('/var/www/html/PhantomJs/public/' . $content['file_name'], 'struk-' . $id . '.jpg');
        }
        return "not found";
    }

    public function ppobReceipt(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $data = PpobTransaction::find($id);
        $data->service_fee = $service_fee;
        switch ($data->service) {
            case '2':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.pln-pra-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
            case '3':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.pln-pas-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
            case '4':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.telepon-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
            case '5':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.internet-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
            case '6':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.tv-cable-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
            case '7':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.multi-finance-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
            case '8':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.pdam-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
            case '9':
                if ($request->action == 'view') {
                    return view('partials.receipts.ppob.bpjs-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
            case '18':
                if ($request->action == 'view') {
                    return view('partials.receipts.pulsa.pulsa-new', compact('data'));
                }
                $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('ppob.receipt_download', ['id' => $id, 'action' => 'view']));
                $content = json_decode($content, true);
                break;
        }
        return response()->download('/var/www/html/PhantomJs/public/' . $content['file_name'], 'struk-' . $id . '.jpg');
    }

    public function ppob(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $data = PpobTransaction::find($id);
        $data->service_fee = $service_fee;
        $pdf = App::make('dompdf.wrapper');
        switch ($data->service) {
            case '2':
                $pdf->loadView('partials.receipts.ppob.pln-pra', ['data' => $data]);
                break;
            case '3':
                $pdf->loadView('partials.receipts.ppob.pln-pas', ['data' => $data]);
                break;
            case '4':
                $pdf->loadView('partials.receipts.ppob.telepon', ['data' => $data]);
                break;
            case '5':
                $pdf->loadView('partials.receipts.ppob.internet', ['data' => $data]);
                break;
            case '6':
                $pdf->loadView('partials.receipts.ppob.tv-cable', ['data' => $data]);
                break;
            case '7':
                $pdf->loadView('partials.receipts.ppob.multi-finance', ['data' => $data]);
                break;
            case '8':
                $pdf->loadView('partials.receipts.ppob.pdam', ['data' => $data]);
                break;
            case '9':
                $pdf->loadView('partials.receipts.ppob.bpjs', ['data' => $data]);
                break;
            case '18':
                $pdf->loadView('partials.receipts.pulsa.pulsa', ['data' => $data]);
                break;
            case '348':
                $pdf->loadView('partials.receipts.ppob.kk', ['data' => $data]);
                break;
        }
        return $pdf->download('struk-' . $data->number . '.pdf');
    }

    public function airlinesDeparture(Request $request, $id)
    {
        $serviceFee = 0;
        $showPrice = false;
        if ($request->has('service_fee')) {
            $serviceFee = (int)$request->service_fee;
        }

        if ($request->has('show_price') && $request->show_price == 1) {
            $showPrice = true;
        }
        if ($request->action == 'view') {
            $flight = 'Departure Flight';
            $transaction = AirlinesTransaction::find($id);
            $passengers = $transaction->passengers;
            $itineraries = $transaction->bookings()->first()->itineraries()->where('depart_return_id', '=', 'd')->get();
            return view('partials.receipts.airlines.e-ticket3', compact('flight', 'transaction', 'passengers', 'itineraries', 'serviceFee', 'showPrice'));
        }
        $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . urlencode(route('airlines.receipts_departure', ['id' => $id, 'action' => 'view', 'service_fee' => $serviceFee, 'show_price' => ($showPrice) ? 1 : 0])));
        $content = json_decode($content, true);
        return response()->download('/var/www/html/PhantomJs/public/' . $content['file_name'], 'eticket-departure-' . $id);
    }

    public function airlinesReturn(Request $request, $id)
    {
        $serviceFee = 0;
        $showPrice = false;
        if ($request->has('service_fee')) {
            $serviceFee = (int)$request->service_fee;
        }
        if ($request->has('show_price') && $request->show_price == 1) {
            $showPrice = true;
        }
        if ($request->action == 'view') {
            $flight = 'Return Flight';
            $transaction = AirlinesTransaction::find($id);
            $passengers = $transaction->passengers;
            $bookCount = count($transaction->bookings);
            if ($bookCount > 1) {
                $itineraries = $transaction->bookings()->orderBy('id', 'desc')->first()->itineraries()->where('depart_return_id', '=', 'r')->get();
            } else {
                $itineraries = $transaction->bookings()->first()->itineraries()->where('depart_return_id', '=', 'r')->get();
            }
            return view('partials.receipts.airlines.e-ticket3', compact('flight', 'transaction', 'passengers', 'itineraries', 'serviceFee', 'showPrice'));
        }
        $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . urlencode(route('airlines.receipts_return', ['id' => $id, 'action' => 'view', 'service_fee' => $serviceFee, 'show_price' => ($showPrice) ? 1 : 0])));
        $content = json_decode($content, true);
        return response()->download('/var/www/html/PhantomJs/public/' . $content['file_name'], 'eticket-return-' . $id);
    }

    public function airlines(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $transaction = AirlinesTransaction::find($id);
        $transaction->service_fee = $service_fee;
        //return view('partials.receipts.airlines.e-ticket',compact('transaction'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('partials.receipts.airlines.e-ticket2', ['transaction' => $transaction]);
        return $pdf->download('e-ticket-' . $id . '.pdf');
    }

    public function trainDeparture(Request $request, $id)
    {
        if ($request->action == 'view') {
            $trip = 'Departure';
            $service_fee = 0;
            if ($request->has('service_fee')) {
                $service_fee = $request->service_fee;
            }
            $transaction = TrainTransaction::find($id);
            $transaction->service_fee = $service_fee;
            $booking = $transaction->bookings()->where('depart_return_id', '=', 'd')->first();
            return view('partials.receipts.train.e-ticket-new', compact('trip', 'transaction', 'booking'));
        }
        $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('trains.receipts_departure', ['id' => $id, 'action' => 'view']));
        $content = json_decode($content, true);
        return response()->download('/var/www/html/PhantomJs/public/' . $content['file_name'], 'eticket-departure-' . $id);
    }

    public function trainReturn(Request $request, $id)
    {
        if ($request->action == 'view') {
            $trip = 'Return';
            $service_fee = 0;
            if ($request->has('service_fee')) {
                $service_fee = $request->service_fee;
            }
            $transaction = TrainTransaction::find($id);
            $transaction->service_fee = $service_fee;
            $booking = $transaction->bookings()->where('depart_return_id', '=', 'r')->first();
            return view('partials.receipts.train.e-ticket-new', compact('trip', 'transaction', 'booking'));
        }
        $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('trains.receipts_return', ['id' => $id, 'action' => 'view']));
        $content = json_decode($content, true);
        return response()->download('/var/www/html/PhantomJs/public/' . $content['file_name'], 'eticket-return-' . $id);
    }

    public function train(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $transaction = TrainTransaction::find($id);
        $transaction->service_fee = $service_fee;
        //return view('partials.receipts.airlines.e-ticket',compact('transaction'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('partials.receipts.train.e-ticket', ['transaction' => $transaction]);
        return $pdf->download('e-ticket-' . $id . '.pdf');
    }

    public function railink(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $transaction = TrainTransaction::find($id);
        $transaction->service_fee = $service_fee;
        //return view('partials.receipts.airlines.e-ticket',compact('transaction'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('partials.receipts.railink.e-ticket', ['transaction' => $transaction]);
        return $pdf->download('e-ticket-' . $id . '.pdf');
    }

    public function hotelReceipt(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $transaction = \App\HotelTransaction::find($id);
        if ($transaction) {
            $transaction->service_fee = $service_fee;
            if ($request->action == 'view') {
                return view('partials.receipts.hotel.voucher-new', compact('transaction'));
            }
            $content = file_get_contents('http://sippdf.local/index.php?action=create_jpg&url=' . route('hotels.receipt_download', ['id' => $id, 'action' => 'view']));
            $content = json_decode($content, true);
            Log::info('response', ['content' => $content]);
            return response()->download('/var/www/html/PhantomJs/public/' . $content['file_name'], 'voucher-' . $id . '.jpg');
        }
        return response('No data', 200);
    }

    public function hotel(Request $request, $id)
    {
        $service_fee = 0;
        if ($request->has('service_fee')) {
            $service_fee = $request->service_fee;
        }
        $transaction = \App\HotelTransaction::find($id);
        $transaction->service_fee = $service_fee;
        // return view('partials.receipts.hotel.voucher', ['transaction' => $transaction]);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('partials.receipts.hotel.voucher', ['transaction' => $transaction]);
        return $pdf->download('e-voucher-' . $id . '.pdf');
    }
}
