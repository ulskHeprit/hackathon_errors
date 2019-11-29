<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = \App\Message::all();
        return view('message.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $message = new \App\Message();
        return view('message.create', compact('message'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //var_dump($request);
        // Проверка введенных данных
        // Если будут ошибки, то возникнет исключение
        $this->validate($request, [
            'user_id' => 'required',
            'message' => 'required',
        ]);

        $message = new \App\Message();

       // $message->fill($request->all());
        $message->user_id = $request->get('user_id');
        $message->message = $request->get('message');

        // При ошибках сохранения возникнет исключение
        $message->save();

        // Редирект на указанный маршрут с добавлением флеш сообщения
        \Session::flash('flash', 'article created');
        return redirect()
            ->route('messages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('message.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message = \App\Message::findOrFail($message);
        if($message) {
            $message->delete();
        }
        return redirect()->route('message.index');
    }
}
