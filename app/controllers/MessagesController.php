<?php

class MessagesController extends \BaseController {

	protected $layout = 'layouts.main';

	protected $user;
	protected $activity;
	protected $message;

	public function __construct(
		User $user, 
		Activity $activity, 
		Message $message)
	{
		$this->user 	= $user;
		$this->activity = $activity;
		$this->message 	= $message;
	}

	public function index()
	{
		$threads = $this->message->threads(Auth::user())->get();

		$this->layout->content = View::make('messages.index', ['threads' => $threads]);
	}

	public function send($id)
	{
		$recipient = $this->user->find($id);
		
		if( !$recipient )
		{
			return Redirect::back()
			->with(
				'error',
				'Sorry, this user cannot be found'
			);
		}

		if( $recipient->id == Auth::user()->id )
		{
			return Redirect::back()
			->with(
				'error',
				'Sorry, you cannot send messages to yourself'
			);	
		}

		$validation = new Services\Validators\Message;

		if( !$validation->passes() )
		{
			return Redirect::back()
			->withInput()
			->withErrors($validation->errors);
		}

		$input = Input::all();

		$thread_id = isset($input['thread_id']) ? $input['thread_id'] : 0;

		$message = $this->message->create([
			'content' 		=> $input['content'],
			'recipient_id' 	=> $recipient->id,
			'sender_id' 	=> Auth::user()->id,
			'thread_id'		=> $thread_id
		]);

		return Redirect::back()
		->with('success', 'Your message has been sent!');
	}

	public function getThread()
	{
		$id = Input::get('id');

		$message = $this->message->find($id);

		if( !$message )
		{
			return Response::json([
				'error' => 'Message not found'
			]);
		}

		$messages = $this->message->with('sender')
									->with('recipient')
									->with('children')
									->where('id', '=', $id)
									->get();

		return Response::json([
			'messages' => $messages
		]);
	}

	/*_______________ API FUNCTIONS ______________*/

	public function apiThreads()
	{
		return $this->message->theads(Auth::user()->get());
	}

	public function apiThread($id)
	{
		return $this->message->thread($id)->get();
	}

	public function apiSend($id)
	{
		$recipient = $this->user->find($id);

		if( !$recipient )
		{
			return Response::json([
				'errors' => [['Sorry, this user cannot be found']]
			]);
		}

		if( $recipient->id == Auth::user()->id )
		{
			return Response::json([
				'errors' => [['Sorry, you cannot send messages to yourself']]
			]);
		}

		$validation = new Services\Validators\Message;

		if( !$validation->passes() )
		{
			return Response::json([
				'errors' => $validation->errors
			]);
		}

		$input = Input::all();

		$message = $this->message->create([
			'content' 		=> $input['content'],
			'recipient_id' 	=> $recipient->id,
			'sender_id' 	=> Auth::user()->id,
			'thread_id'		=> $input['thread_id']
		]);

		$message = $this->message->whereId($message->id)->with('sender')->with('recipient')->get();

		return Response::json([
			'message' => $message
		]);
	}

	public function findRecipient($id)
	{
		$thread 	= $this->message->find($id);
		$sender 	= $thread->sender_id;
		$recipient 	= $thread->recipient_id;

		return Auth::user()->id == $sender ? $recipient : $sender;
	}

}