<?php
$user = \Discord2\User::getUser();
if ($user == false || !isset($_POST['returnURL'])) {
	include("404.php");
} else {
	if ($_GET['action'] == 'rLike') {
		
		// Sanity check, make sure user doesn't already like...
	
		try {
			$a = \Ratings\Likes::loadBy(['glitchID'=>$_GET['id'],'userID'=>$user->user_id])[0];
			$a->Delete();
			redirect($_POST['returnURL']);
			die;

		} catch (\Exceptions\ItemNotFound $e) {}
		redirect($_POST['returnURL']);
		die;
	} else if ($_GET['action'] == 'like') {
		
		// Sanity check, make sure user doesn't already like...
	
		try {
			$a = \Ratings\Likes::loadBy(['glitchID'=>$_GET['id'],'userID'=>$user->user_id])[0];
		} catch (\Exceptions\ItemNotFound $e) {
			 $a = new \Ratings\Likes();
			 $a->userID = $user->user_id;
			 $a->glitchID = $_GET['id'];
			 $a->Save();
		}
		
		try {
			$a = \Ratings\Dislikes::loadBy(['glitchID'=>$_GET['id'],'userID'=>$user->user_id])[0];
			$a->Delete();

		} catch (\Exceptions\ItemNotFound $e) {}

		redirect($_POST['returnURL']);
		die;
	} else if ($_GET['action'] == 'dislike') {
		
		// Sanity check, make sure user doesn't already dislike...
	
		try {
			$a = \Ratings\Dislikes::loadBy(['glitchID'=>$_GET['id'],'userID'=>$user->user_id])[0];
		} catch (\Exceptions\ItemNotFound $e) {
			 $a = new \Ratings\Dislikes();
			 $a->userID = $user->user_id;
			 $a->glitchID = $_GET['id'];
			 $a->Save();
		}
		
		try {
			$a = \Ratings\Likes::loadBy(['glitchID'=>$_GET['id'],'userID'=>$user->user_id])[0];
			$a->Delete();

		} catch (\Exceptions\ItemNotFound $e) {}

		redirect($_POST['returnURL']);
		die;
	} else if ($_GET['action'] == 'rDislike') {
		
		// Sanity check, make sure user doesn't already like...
	
		try {
			$a = \Ratings\Dislikes::loadBy(['glitchID'=>$_GET['id'],'userID'=>$user->user_id])[0];
			$a->Delete();
			redirect($_POST['returnURL']);
			die;

		} catch (\Exceptions\ItemNotFound $e){}
		redirect($_POST['returnURL']);
		die;
	} else if ($_GET['action'] == 'uLike') {
		
		// Sanity check, make sure user doesn't already like...
	
		try {
			$a = \Ratings\UserLikes::loadBy(['creatorID'=>$_GET['id'],'userID'=>$user->user_id])[0];
			redirect($_POST['returnURL']);
			die;

		} catch (\Exceptions\ItemNotFound $e) {
			$a = new \Ratings\UserLikes();
			$a->creatorID = $_GET['id'];
			$a->userID = $user->user_id;
			$a->Save();
			redirect($_POST['returnURL']);
			die;
		}
		redirect($_POST['returnURL']);
		die;
	} else if ($_GET['action'] == 'uRLike') {
		
		// Sanity check, make sure user doesn't already like...
	
		try {
			$a = \Ratings\UserLikes::loadBy(['creatorID'=>$_GET['id'],'userID'=>$user->user_id])[0];
			$a->Delete();
			redirect($_POST['returnURL']);
			die;

		} catch (\Exceptions\ItemNotFound $e){}
		redirect($_POST['returnURL']);
		die;
	}
}
die("We shoulnd't be here..");
