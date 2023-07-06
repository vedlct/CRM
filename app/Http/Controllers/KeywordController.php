<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keyword;
use App\Activities;

use Session;
use DataTables;


class KeywordController extends Controller
{
    
    public function index()
    {

        $keywords = Keyword::select('keywords.*')->get();


        return view('mining.keywords')->with('keywords', $keywords);
    }


    public function updateKeyword(Request $r)
    {

        $this->validate($r,[
            'english' => 'required',

        ]);

        $keyword = Keyword::findOrFail($r->keywordId);
        $keyword->english = $r->english;
        $keyword->german = $r->german;
        $keyword->italy = $r->italy;
        $keyword->spain = $r->spain;
        $keyword->netherlands = $r->netherlands;
        $keyword->denmark = $r->denmark;
        $keyword->sweden = $r->sweden;
        $keyword->save();
    
        Session::flash('success', 'Keyword is updated');
    
        $keywords = Keyword::select('keywords.*')->get();
    
        return view('mining.keywords', ['keywords' => $keywords]);
    }
    



}
