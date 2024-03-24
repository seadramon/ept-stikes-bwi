<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredential;

use Hash;
use Log;

class UsersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $password = generateRandomString(6, '0123456789');

        /*Mail::send(new UserCredential([
            'recipient' => $row[2],
            'name' => $row[1],
            'password' => $password
        ]));*/

        return User::updateOrCreate(
            [
                'email'    => $row[2],
                'nomor_induk'  => $row[0]
            ],
            [
                'name'     => $row[1],
                'phone'    => $row[3], 
                'instansi'    => $row[4], 
                'jenis_kelamin'    => $row[5], 
                'role' => 'peserta',
                'password' => Hash::make($password),
            ]
        );
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
