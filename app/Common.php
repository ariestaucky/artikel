<?php

namespace App;

function notif() 
{
    $auth_id = Auth()->user()->id;
    $notif = Message::where('messages.receiver', $auth_id)
                ->whereNull('messages.receiver_delete')
                ->where('messages.receiver_mark', 0)
                ->join('users', 'users.id', '=', 'messages.sender_id')
                ->select('users.*', 'messages.*', 'messages.created_at as message_created', 'users.id as user_id')
                ->get();
    return $notif;
}

SELECT users.id as id,
	users.fname as fname,
	users.lname as lname,
	users.username as username,
	followables.relation as relation,
	posts.body as post,
	comments.body as comment
FROM users
JOIN followables ON followables.user_id = users.id
JOIN comments ON comments.user_id = users.id
JOIN posts ON posts.id = comments.post_id
WHERE (posts.user_id = 1 and comments.user_id != 1) AND (followables.user_id != 1 and followables.notify = 1)

SELECT users.id as id,
	users.fname as fname,
	users.lname as lname,
	users.username as username,
	followables.relation as relation,
	null as post,
	null as comment
FROM users
JOIN followables ON followables.user_id = users.id
WHERE followables.user_id != 1 and followables.notify = 1
UNION
SELECT users.id as id,
	users.fname as fname,
	users.lname as lname,
	users.username as username,
	null as relation,
	posts.body as post,
	comments.body as comment
FROM users
JOIN comments ON comments.user_id = users.id
JOIN posts ON posts.id = comments.post_id
WHERE (posts.user_id = 1 and comments.user_id != 1)