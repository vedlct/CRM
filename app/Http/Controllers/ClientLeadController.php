<?php

namespace App\Http\Controllers;

use App\Lead;
use App\NewFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ClientLeadController extends Controller
{
    public function index(){
//        $newFiles=NewFile::select(DB::raw('distinct(leadId)'))->where('userId',Auth::user()->id)
//            ->get();
//
//        $leads=Lead::whereIn('leadId',$newFiles)->get();

        $leadsWithFiles=Lead::select('leads.leadId','leads.companyName',DB::raw('sum(new_file.fileCount) as total'))
            ->leftJoin('new_file','new_file.leadId','leads.leadId')
            ->where('new_file.userId',Auth::user()->id)
            ->groupBy('leads.leadId')
            ->get();

//        return $leadsWithFiles;

        return view('client.index',compact('leadsWithFiles'));


    }

    public function edit(Request $r){
        $newFiles=NewFile::select('new_file.*','leads.companyName')
            ->where('new_file.leadId',$r->id)
            ->leftJoin('leads','leads.leadId','new_file.leadId')
            ->get();

        return view('client.edit',compact('newFiles'));
    }

    public function add(Request $r){
        $lead=Lead::findOrFail($r->id);
//        return $lead;
        return view('client.add',compact('lead'));
    }

    public function insert(Request $r){

        $newFile=new NewFile();
        $newFile->leadId=$r->id;
        $newFile->fileCount=$r->files123;
        $newFile->userId=Auth::user()->id;
        $newFile->save();



        return back();
    }
}
