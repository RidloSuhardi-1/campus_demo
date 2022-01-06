<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id';

    protected $useTimestamps = true;
    protected $allowedFields = ['no_induk', 'nama', 'foto_pribadi', 'foto_ktp'];

    public function getMahasiswa($no = false)
    {
        if ($no == false) {
            return $this->findAll();
        }

        return $this->where(['no_induk' => $no])->first();
    }
}
