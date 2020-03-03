<?php

namespace App\Http\Controllers;

use App\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class questionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $question = Questions::where('user_id', Auth::user()->id)->first();
        return view('questions.index', compact('question'));
    }

    public function create()
    {
        return view('questions.create');
    }
    public function store()
    {
        $constant_price = 10;
        $data = request()->validate([
            'level' => 'required',
            'subject' => 'required',
            'title' => 'required',
            'details' => '',
            'pages' => 'required',
           // 'price' => 0,
        ]);

        $price = \request('pages')*$constant_price;

        auth()->user()->questions()->create([
            'level' => $data['level'],
            'subject' => $data['subject'],
            'title' => $data['title'],
            'details' => $data['details'],
            'pages' => $data['pages'],
            'price' => $price
        ]);
        //dd(\request()->all());
        //Log::info($data);
        return redirect('/question');


        //$constant_price = 10;
        /*
        $question = new Questions([
            'level' => $request->get('level'),
            'subject' => $request->get('subject'),
            'title' => $request->get('title'),
            'details' => $request->get('details'),
            'pages' => $request->get('pages'),
            'price' => $request->get('pages')*$constant_price
        ]);

        $question->save();
        */
       // return redirect('/questions');


    }
}
