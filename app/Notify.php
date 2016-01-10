<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Notify extends Model
{
    protected $fillable = ['user_id', 'body', 'type', 'to_all', 'is_system'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function notify($idArr = array(), $body, $type, $to_all = 0, $is_system = 0)
    {
        $currentId = auth()->id();
        if (!$currentId) return;
        $data = $notifiedUidArr = [];
        $now = \Carbon\Carbon::now();
        if($to_all){
            $data = [
                'user_id' => 0,
                'body' => $body,
                'type' => $type,
                'to_all' => $to_all,
                'is_system' => $is_system,
                'created_at' => $now,
                'updated_at' => $now
            ];
        } elseif (!empty($idArr)) {
            $idArr = array_unique($idArr);
            foreach ($idArr as $id) {
                if($id == $currentId) return;
                $data[] = [
                    'user_id' => $id,
                    'body' => $body,
                    'type' => $type,
                    'to_all' => $to_all,
                    'is_system' => $is_system,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
                $notifiedUidArr[] = $id;
            }
        }
        if (!empty($data)) {
            Notify::insert($data);
            if ($to_all) {
                \DB::table('users')->increment('notice_count');
            }elseif($notifiedUidArr){
                User::whereIn('id', $notifiedUidArr)->increment('notice_count');
            }
        }
    }
}
