<?php

namespace App\Traits;

use App\Friendship;


trait Friendable {

	/**
	 * Add Friend
	 * @param [int] $user_requested_id [User will receive the add friend request]
	 */
	public function add_friend($user_requested_id) {

		if($this->id === $user_requested_id) {

			return 0;

		}

		if($this->has_pending_friend_request_sent_to($user_requested_id)) {

			return 'already sent a friend request';

		}

		if($this->is_friend_with($user_requested_id) === 1) {

			return 'already friend';

		}

		if($this->has_pending_friend_request_from($user_requested_id)) {

			return $this->accept_friend($user_requested_id);

		}

		$friendship = Friendship::create([
			'requester' => $this->id,
			'user_requested' => $user_requested_id
		]);

		if($friendship) {
			return 1;
		}

		return 0;

	}

	/**
	 * Accept Friend
	 * @param  [int] $requester [User sent friend request]
	 * @return [json]            [Done or Not]
	 */
	public function accept_friend($requester) {

		if($this->has_pending_friend_request_from($requester) === 0) {

			return 0;

		}

		$friendship = Friendship::where('requester', $requester)
								->where('user_requested', $this->id)
								->first();

		if($friendship) {

			$friendship->update([
				'status' => 1
			]);

			return 1;

		}

		return 0;

	}

	/**
	 * friends List Friend
	 * @return [array] [List Friend]
	 */
	public function friends() {

		$friends = array();

		// Sent
		
		$f1 = Friendship::where('status', 1)
						->where('requester', $this->id)
						->get();

		foreach($f1 as $friendship) {
			array_push($friends, \App\User::find($friendship->user_requested));
		}

		// Received

		$friends2 = array();
		
		$f2 = Friendship::where('status', 1)
						->where('user_requested', $this->id)
						->get();

		foreach ($f2 as $friendship) {
			array_push($friends2, \App\User::find($friendship->requester));
		}

		// Merge Array Friend
		return array_merge($friends, $friends2);
	}

	/**
	 * Received And Waiting Accept List User
	 * @return [array] [List Pending Friend]
	 */
	public function pending_friend_requests() {

		$users = array();

		$friendships = Friendship::where('status', 0)
								 ->where('user_requested', $this->id)
								 ->get();

		foreach($friendships as $friendship) {
			array_push($users, \App\User::find($friendship->requester));
		}

		return $users;

	}

	/**
	 * List id of friends
	 * @return [array] [List id]
	 */
	public function friend_ids() {

		return collect($this->friends())->pluck('id')->toArray();

	}

	/**
	 * Check Friendship
	 * @param  [int]  $user_id [Id of Friend check]
	 * @return boolean          [Friend or not]
	 */
	public function is_friend_with($user_id) {

		if(in_array($user_id, $this->friend_ids())) {

			return 1;

		} else {

			return 0;

		}

	}

	/**
	 * Received And Waiting Accept List ID
	 * @return [array] [List ID]
	 */
	public function pending_friend_requests_ids() {

		return collect($this->pending_friend_requests())->pluck('id')->toArray();

	}

	/**
	 * Sent And Waiting Accept List User
	 * @return [array] [List User]
	 */
	public function pending_friend_request_sent() {

		$users = array();

		$friendships = Friendship::where('status', 0)
								 ->where('requester', $this->id)
								 ->get();

		foreach ($friendships as $friendship) {
			
			array_push($users, \App\User::find($friendship->user_requested));

		}

		return $users;

	}

	/**
	 * Sent And Waiting Accept List ID
	 * @return [array] [List ID]
	 */
	public function pending_friend_request_sent_ids() {

		return collect($this->pending_friend_request_sent())->pluck('id')->toArray();

	}

	/**
	 * Check Received From User
	 * @param  [int]  $user_id [User ID check Received]
	 * @return boolean          [Received or Not]
	 */
	public function has_pending_friend_request_from($user_id) {

		if(in_array($user_id, $this->pending_friend_requests_ids())) {

			return 1;

		} else {

			return 0;

		}

	}

	/**
	 * Check Sent To User
	 * @param  [int]  $user_id [User ID check Sent]
	 * @return boolean          [Sent or Not]
	 */
	public function has_pending_friend_request_sent_to($user_id) {

		if(in_array($user_id, $this->pending_friend_request_sent_ids())) {

			return 1;

		} else {

			return 0;

		}

	}

	public function remove_friend($user_id) {

		$friendship1 = Friendship::where('user_requested', $user_id)
									->where('requester', $this->id)
									->first();
		$friendship2 = Friendship::where('requester', $user_id)
									->where('user_requested', $this->id)
									->first();
		if($friendship1) {
			$friendship1->delete();
			return 1;
		}
		if($friendship2) {
			$friendship2->delete();
			return 1;
		}
		return 0;
	}

}