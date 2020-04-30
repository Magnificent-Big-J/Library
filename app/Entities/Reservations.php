<?php

namespace App\Entities;


use App\User;

trait Reservations{
    public function checkout(User $user)
    {
        $this->reservations()->create([
            'check_out_at' => now(),
            'user_id' => $user->id
        ]);
    }
    public function checkin($user)
    {
        $reservation = $this->reservations()
            ->where('user_id', $user->id)
            ->whereNotNull('check_out_at')
            ->whereNull('check_in_at')
            ->first();
        if (is_null($user)){
            throw new \Exception();
        }
        $reservation->update([
            'check_in_at' => now()
        ]);
    }
}
