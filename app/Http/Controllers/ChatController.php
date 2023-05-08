<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\ChatTopic;
use App\Models\CsChat;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    /**
     * Show the form for managing existing resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewManage()
    {
        $datas = ChatTopic::orderBy('id','DESC')->get();
//        return $datas;
        return view('cs.manage_new')->with(compact('datas'));
    }

    public function viewUpdate($id,Request $request)
    {
        $data = ChatTopic::findOrFail($id);
        $chats = CsChat::where("topic_id",'=',$id)->get();
        $com = compact('data','chats');

//        return $com;
        return view('cs.reply_chat')->with($com);
    }

    public function storeAdmin(Request $request,$id){
//        return $request->all();
        $topic = ChatTopic::findOrFail($id);
        $data = new CsChat();
        $data->topic_id = $topic->id;
        $data->sender_id = 1;
        $data->recepient_id = $topic->belongs_to;
        $data->type = $request->type;
        $data->message = $request->message;
        $data->is_read = 0;

        if ($request->photo != null) {
            $image = $request->photo_requested;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = "chat_" .time(). $topic . '.' . 'png';

            $savePathDB = "/web_files/chat/$imageName";
            $path = public_path() . $savePathDB;
            \File::put($path, base64_decode($image));
            $photoPath = $savePathDB;
            $data->photo = $photoPath;
            $data->type = 7;
        }

        return $this->SaveData($data, $request);
    }


    public function getByUser(Request $request, $id)
    {
        $userId = $request->id;
        $topic = ChatTopic::where("belongs_to", '=', $id)->first();

        if ($topic != null) {
            $topicId = $topic->id;
            $data = CsChat::where("topic_id", '=', $topicId)->get();
            return RazkyFeb::responseSuccessWithData(
                200, 1, 1, "Success", "Success", $data);
        } else {
            $topicId = "p";
            $data = CsChat::where("topic_id", '=', $topicId)->get();
            return RazkyFeb::responseErrorWithData(202, 0, 0,
                "Tidak Ada Data", "Tidak Ada Data", $data);
        }

    }

    public function getByTopic(Request $request, $id)
    {
        $topicId = $request->id;

        $data = CsChat::where("topic_id", '=', $topicId)->get();
        return RazkyFeb::responseSuccessWithData(
            200, 1, 1, "Success", "Success", $data);
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $userId = $request->user_id;
        $user = User::find($userId);
        $topic_id = null;

        // if this a user, then create a new topic
        if ($user->role == 3) {


            $find = ChatTopic::where("belongs_to", '=', $userId)->count();

            if ($find == 0) {
                // if chat topic doesnt exist
                $topic = new ChatTopic();
                $topic->belongs_to = $request->user_id;
                $topic->is_finished = false;

                if ($topic->save()) {
                    $topic_id = $topic->id;

                    $data = new CsChat();
                    $data->topic_id = $topic_id;
                    $data->sender_id = $request->user_id;
                    $data->recepient_id = $request->recepient_id;
                    $data->type = $request->type;
                    $data->message = $request->message_chat;
                    $data->is_read = 0;

                    if ($request->photo != null) {
                        $image = $request->photo_requested;  // your base64 encoded
                        $image = str_replace('data:image/png;base64,', '', $image);
                        $image = str_replace(' ', '+', $image);
                        $imageName = "chat_" . $userId . '.' . 'png';

                        $savePathDB = "/web_files/chat/$imageName";
                        $path = public_path() . $savePathDB;
                        \File::put($path, base64_decode($image));
                        $photoPath = $savePathDB;
                        $data->photo = $photoPath;
                        $data->type = 7;
                    }

                    return $this->SaveData($data, $request);
                }
            } else {
                $topic = ChatTopic::where("belongs_to", '=', $userId)->first();
                $data = new CsChat();
                $data->topic_id = $topic->id;
                $data->sender_id = $request->user_id;
                $data->recepient_id = $request->recepient_id;
                $data->type = $request->type;
                $data->message = $request->message_chat;
                $data->is_read = 0;

                if ($request->photo != null) {
                    $image = $request->photo_requested;  // your base64 encoded
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = "chat_" . $userId . '.' . 'png';

                    $savePathDB = "/web_files/chat/$imageName";
                    $path = public_path() . $savePathDB;
                    \File::put($path, base64_decode($image));
                    $photoPath = $savePathDB;
                    $data->photo = $photoPath;
                    $data->type = 7;
                }

                return $this->SaveData($data, $request);
            }
        }

    }

    /**
     * @param News $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public
    function SaveData(CsChat $data, Request $request)
    {
        if ($data->save()) {
            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Menyimpan Data",
                    "Success",
                    $data,
                );

            return back()->with(["success" => "Berhasil Menyimpan Data"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Berhasil Menginput Data",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Menyimpan Data"]);
        }
    }
}
