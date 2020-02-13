<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vote;

class VoteController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');

    // }
    // public function index()
    // {
    //     $games = Vote::all();
    //     return view('votes.index', ['votes' => $votes]);
    // }
        /**
     * Get a validator for an incoming vote request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator()
    {
        return Validator::make($data, [
            'vote' => ['required', 'integer', 'digits_between:0,3'],
            'name' => ['string', 'max:255', 'unique:users'],
            'school' => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new vote instance after a valid request.
     *
     * @param  array  $data
     * @return \App\Vote
     */
    protected function create(array $data)
    {
        dd(request($data));
        // return Vote::create([
        //     'user_id' => $data['user_id'],
        //     'vote' => $data['vote'],
        //     'guest_name' => $data['guest_name'],
        //     'guest_school' => $data['guest_school'],
        //     'school' => $data['school'],
        //     'vote' => $data['vote'],
        // ]);
    }

    /**
     * Store the vote.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store()
    {
        //test 
        //return request()->all();

        $vote = new Vote();

        $vote->user_id = request('user_id');
        $vote->name = request('name');
        $vote->school = request('school');
        $vote->vote = request('vote');
        
        $vote->save();

        return redirect('/votes/show');
        //return view('results');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('votes.create');
        // return view('results');
    }
}
