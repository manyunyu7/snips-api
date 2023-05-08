<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\FCMToken;
use App\Models\SodaqoCategory;
use Goutte\Client as Goute;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Kutia\Larafirebase\Facades\Larafirebase;
use Illuminate\Http\Request;

class ColekController extends Controller
{

    public function saveFcmToken(Request $request)
    {
        $existingToken = FCMToken::where('token', $request->token)->first();
        if ($existingToken) {
            // Hapus token FCM yang sudah digunakan
            $existingToken->delete();
        }

        $data = new FCMToken();
        $data->user_id = $request->user_id;
        $data->token = $request->token;

        if ($data->save()) {
            return RazkyFeb::success(200, $data);
        } else {
            return RazkyFeb::success(400, $data);
        }

        return response()->json([
            'message' => 'Successfully added FCM token'
        ]);
    }

    public function fcm(Request $request)
    {
        $qotd = Inspiring::quote();
        try {
            $fcmTokens = "cAdm5xj8Noo:APA91bEQ3r7IoBq0bi5Vn0bY75WVZzdo-4lA9k1HoVIGqQbfuTM2m-YV1VLDwDSzNoBGW83hKW5nmnFkrzpG9eP4n7VyuMz9Q-3o8r1zSB6-r5_vQJ6PpwNqA1d1eg5nlYGplSAFg3pV";
//            return Larafirebase::withTitle('Test Title')
//                ->withBody($qotd)
////                ->withImage('https://firebase.google.com/images/social.png')
////                ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
//                ->withSound('default')
////                ->withClickAction('https://www.google.com')
//                ->withPriority('high')
////                ->withAdditionalData([
////                    'color' => '#rrggbb',
////                    'badge' => 0,
////                    'agus' => 0,
////                ])
//                ->sendNotification($fcmTokens);

            $payload = Larafirebase::withTitle('Test Title')->withBody($qotd)->sendMessage($fcmTokens);
            return $payload;
//            return 'Notification Sent Successfully!!';

        } catch (\Exception $e) {
            report($e);
            return $e;
        }
    }


    public function colek()
    {
        $qotd = Inspiring::quote();

        $message_id = "";
        $message_en = "";

        $changeLog = array();

        $response = [
            'http_response' => 200,
            'version' => "0.0.1",
            'quotes_of_the_day' => $qotd,
            'message_id' => $message_id,
            'message_en' => $message_en,
            'changeLog' => $changeLog,
        ];

        return response($response, 200);
    }

    public function bdm()
    {
        $client = new Goute();

        // Set the authorization header
        $website = $client->request('GET', 'https://stockbit.com/');

        return $website->html();
    }

    public function drop($schemeName)
    {
        Schema::dropIfExists("$schemeName");
    }
}
