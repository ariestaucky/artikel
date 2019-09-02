<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use App\Message;
use App\Post;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function archive() 
    {
        $archive = DB::table('posts')
        ->select(DB::raw('count(*) as `post_count`'), DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name'))
        ->groupby('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();  

        return $archive;
    }

    public function notif() 
    {
        if(auth()->check()){
            $auth_id = auth()->user()->id;
            $notif = Message::notif($auth_id)
                            ->orderBy('message_created','desc')
                            ->get();
            return $notif;
        }
    }

    public function notify() 
    {
        if(Auth()->check()){
            $auth_id = auth()->user()->id;
            $notify = DB::select(DB::raw("SELECT users.id as id,
                                                users.name as name,
                                                users.username as username,
                                                followables.relation as relation,
                                                null as pid,
                                                null as reply,
                                                null as post,
                                                null as comment,
                                                followables.created_at as tgl
                                            FROM users
                                            JOIN followables ON followables.user_id = users.id
                                            WHERE followables.user_id != '$auth_id' and followables.notify = '$auth_id' and followables.followable_type = 'App\\\User' and followables.notify_mark = 0
                                            UNION ALL
                                            SELECT users.id as id,
                                                users.name as name,
                                                users.username as username,
                                                followables.relation as relation,
                                                posts.id as pid,
                                                null as reply,
                                                posts.title as post,
                                                null as comment,
                                                followables.created_at as tgl
                                            FROM users
                                            JOIN followables ON followables.user_id = users.id
                                            JOIN posts ON (CASE
                                                           WHEN followables.followable_type = 'App\\\Post' THEN posts.id = followables.followable_id END)
                                            WHERE followables.user_id != '$auth_id' and followables.notify = '$auth_id' and followables.notify_mark = 0
                                            UNION ALL
                                            SELECT users.id as id,
                                                users.name as name,
                                                users.username as username,
                                                null as relation,
                                                posts.id as pid,
                                                null as reply,
                                                posts.title as post,
                                                comments.body as comment,
                                                comments.created_at as tgl
                                            FROM users
                                            JOIN comments ON comments.user_id = users.id
                                            JOIN posts ON posts.id = comments.post_id
                                            WHERE posts.user_id = '$auth_id' and comments.user_id != '$auth_id' AND comments.parent_id is null AND comments.mark = 0
                                            UNION ALL
                                            SELECT u.id as id,
                                                users.name as name,
                                                u.username as username,
                                                null as relation,
                                                p.id as pid,
                                                c.parent_id as reply,
                                                p.title as post,
                                                c.body as comment,
                                                c.created_at as tgl
                                            FROM comments AS c 
                                            JOIN users AS u ON u.id = c.user_id 
                                            JOIN follow AS f On f.post_id = c.post_id 
                                            JOIN posts AS p ON p.id = f.post_id 
                                            WHERE (f.user_id = '$auth_id') AND (c.mark = 0) AND (c.user_id <> '$auth_id') AND c.parent_id in (select id from comments where user_id = '$auth_id')
                                            UNION ALL
                                            SELECT u.id as id,
                                                users.name as name,
                                                u.username as username,
                                                fol.relation as relation,
                                                p.id as pid,
                                                null as reply,
                                                p.title as post,
                                                null as comment,
                                                p.created_at as tgl
                                            FROM posts AS p 
                                            JOIN followables AS fol ON (CASE
                                                           WHEN fol.followable_type = 'App\\\User' THEN fol.notify = p.user_id END) 
                                            JOIN users AS u ON (CASE
                                                           WHEN fol.followable_type = 'App\\\User' THEN u.id = p.user_id END) 
                                            LEFT JOIN poster as pt on (pt.notifiable_id = fol.user_id AND pt.post_id = p.id)
                                            WHERE (fol.user_id = '$auth_id') AND p.created_at > fol.created_at AND (pt.post_id is null and pt.notifiable_id is null)
                                            ORDER BY tgl DESC") );

            return $notify;
        }

    }

    public function notified() 
    {
        if(Auth()->check()){
            $auth_id = auth()->user()->id;
            $history = DB::select(DB::raw("SELECT users.id as id,
                                                users.name as name,
                                                users.username as username,
                                                followables.relation as relation,
                                                null as pid,
                                                null as reply,
                                                null as post,
                                                null as comment,
                                                followables.created_at as tgl
                                            FROM users
                                            JOIN followables ON followables.user_id = users.id
                                            WHERE followables.user_id != '$auth_id' and followables.notify = '$auth_id' and followables.followable_type = 'App\\\User'
                                            UNION ALL
                                            SELECT users.id as id,
                                                users.name as name,
                                                users.username as username,
                                                followables.relation as relation,
                                                posts.id as pid,
                                                null as reply,
                                                posts.title as post,
                                                null as comment,
                                                followables.created_at as tgl
                                            FROM users
                                            JOIN followables ON followables.user_id = users.id
                                            JOIN posts ON (CASE
                                                           WHEN followables.followable_type = 'App\\\Post' THEN posts.id = followables.followable_id END)
                                            WHERE followables.user_id != '$auth_id' and followables.notify = '$auth_id'
                                            UNION ALL
                                            SELECT users.id as id,
                                                users.name as name,
                                                users.username as username,
                                                null as relation,
                                                posts.id as pid,
                                                null as reply,
                                                posts.title as post,
                                                comments.body as comment,
                                                comments.created_at as tgl
                                            FROM users
                                            JOIN comments ON comments.user_id = users.id
                                            JOIN posts ON posts.id = comments.post_id
                                            WHERE posts.user_id = '$auth_id' and comments.user_id != '$auth_id' AND comments.parent_id is null             
                                            UNION ALL
                                            SELECT u.id as id,
                                                users.name as name,
                                                u.username as username,
                                                null as relation,
                                                p.id as pid,
                                                c.parent_id as reply,
                                                p.title as post,
                                                c.body as comment,
                                                c.created_at as tgl
                                            FROM comments AS c 
                                            JOIN users AS u ON u.id = c.user_id 
                                            JOIN follow AS f On f.post_id = c.post_id 
                                            JOIN posts AS p ON p.id = f.post_id 
                                            WHERE (f.user_id = '$auth_id') AND (c.user_id <> '$auth_id') AND c.parent_id in (select id from comments where user_id = '$auth_id')
                                            UNION ALL
                                            SELECT u.id as id,
                                                users.name as name,
                                                u.username as username,
                                                fol.relation as relation,
                                                p.id as pid,
                                                null as reply,
                                                p.title as post,
                                                null as comment,
                                                p.created_at as tgl
                                            FROM posts AS p 
                                            JOIN followables AS fol ON (CASE
                                                           WHEN fol.followable_type = 'App\\\User' THEN fol.notify = p.user_id END) 
                                            JOIN users AS u ON (CASE
                                                           WHEN fol.followable_type = 'App\\\User' THEN u.id = p.user_id END) 
                                            WHERE (fol.user_id = '$auth_id') AND p.created_at > fol.created_at
                                            ORDER BY tgl DESC") );

            return $history;
        }

    }

    public function notification()
    {
        $notification = $this->notify();
        $counter = count($notification);

        return response()->json($counter);
    }

    public function msg_counter()
    {
        $msg_counter = $this->notif();
        $msg_notif_counter = count($msg_counter);

        return response()->json($msg_notif_counter);
    }
}

// SELECT users.id as id,
//     concat(users.fname, ' ', users.lname) as fullname,
//     users.username as username,
//     followables.relation as relation,
//     null as pid,
//     null as post,
//     null as comment,
//     followables.created_at as tgl
// FROM users
// JOIN followables ON followables.user_id = users.id
// WHERE followables.user_id != '$auth_id' and followables.notify = '$auth_id' and followables.followable_type = 'App\\\User' and followables.notify_mark = 0
// UNION ALL
// SELECT users.id as id,
//     concat(users.fname, ' ', users.lname) as fullname,
//     users.username as username,
//     followables.relation as relation,
//     posts.id as pid,
//     posts.title as post,
//     null as comment,
//     followables.created_at as tgl
// FROM users
// JOIN followables ON followables.user_id = users.id
// JOIN posts ON (CASE
//                 WHEN followables.followable_type = 'App\\\Post' THEN posts.id = followables.followable_id END)
// WHERE followables.user_id != '$auth_id' and followables.notify = '$auth_id' and followables.notify_mark = 0
// UNION ALL
// SELECT users.id as id,
//     concat(users.fname, ' ', users.lname) as fullname,
//     users.username as username,
//     null as relation,
//     posts.id as pid,
//     posts.title as post,
//     comments.body as comment,
//     comments.created_at as tgl
// FROM users
// JOIN comments ON comments.user_id = users.id
// JOIN posts ON posts.id = comments.post_id
// WHERE posts.user_id = '$auth_id' and comments.user_id != '$auth_id'
// UNION ALL
// SELECT u.id as id,
//     concat(u.fname, ' ', u.lname) as fullname,
//     u.username as username,
//     null as relation,
//     p.id as pid,
//     p.title as post,
//     c.body as comment,
//     c.created_at as tgl
// FROM comments AS c 
// JOIN users AS u ON u.id = c.user_id 
// JOIN follow AS f On f.post_id = c.post_id 
// JOIN posts AS p ON p.id = f.post_id 
// WHERE (f.user_id = '$auth_id') AND (f.status = 0) AND (c.user_id <> '$auth_id')
// ORDER BY tgl DESC
            
// SELECT users.id as id,
// concat(users.fname, ' ', users.lname) as fullname,
// users.username as username,
// null as relation,
// posts.id as pid,
// null as reply,
// posts.title as post,
// comments.body as comment,
// comments.created_at as tgl
// FROM users
// JOIN comments ON comments.user_id = users.id
// JOIN posts ON posts.id = comments.post_id
// WHERE posts.user_id = 3 and comments.user_id !=3 AND comments.parent_id is null AND comments.post_owner = 0
// UNION ALL
// SELECT u.id as id,
// concat(u.fname, ' ', u.lname) as fullname,
// u.username as username,
// null as relation,
// p.id as pid,
// f.comment_id as reply,
// p.title as post,
// c.body as comment,
// c.created_at as tgl
// FROM comments AS c 
// JOIN users AS u ON u.id = c.user_id 
// JOIN follow AS f On f.post_id = c.post_id 
// JOIN posts AS p ON p.id = f.post_id 
// WHERE f.user_id =3 AND f.status = 0 AND c.user_id <> 3 AND c.parent_id in (select id from comments where user_id = 3) 