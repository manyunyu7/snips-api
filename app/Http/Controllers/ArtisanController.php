<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ArtisanController extends Controller
{
   public function dropDonasi(){
       Schema::dropIfExists('donasis');
   }
   public function drop(){
       Schema::dropIfExists('chat_topics');
   }
}
