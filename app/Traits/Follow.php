<?php

namespace App\Traits;

use App\Friendship;

trait Follow {

	/**
	 * Add Friend
	 * @param [int] $user_requested_id [User will receive the add friend request]
	 */
	public function add_follow($user_requested_id) {

		if($this->id === $user_requested_id) {

			return 0;

		}

		if($this->is_following($user_requested_id)) {

			return 'already followed';

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

	public function followings() {

		$followings = array();

		$f = Friendship::where('requester', $this->id)->get();

		foreach ($f as $friendship) {
			array_push($followings, \App\User::find($friendship->user_requested));
		}
		
		return $followings;

	}

	public function followers() {
		$followers = array();

		$f = Friendship::where('user_requested', $this->id)->get();

		foreach ($f as $friendship) {
			array_push($followers, \App\User::find($friendship->requester));
		}
		
		return $followers;
	}

	public function following_ids() {

		return collect($this->followings())->pluck('id')->toArray();

	}

	public function is_following($user_id) {

		if(in_array($user_id, $this->following_ids())) {
			return 1;
		} else {
			return 0;
		}

	}

	public function remove_follow($user_id) {

		$friendship = Friendship::where('user_requested', $user_id)
									->where('requester', $this->id)
									->first();
		if($friendship) {
			$friendship->delete();
			return 1;
		}

		return 0;

	}

}