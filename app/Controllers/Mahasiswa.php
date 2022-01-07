<?php

namespace App\Controllers;

class Mahasiswa extends BaseController
{
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->mahasiswaModel = new \App\Models\MahasiswaModel();
    }

    public function index()
    {
        session();
        $data = [
            'title' => 'Mahasiswa',
            'mahasiswa' => $this->mahasiswaModel->getMahasiswa()
        ];

        return view('mahasiswa/mahasiswa_list', $data);
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Detail Mahasiswa',
            'mahasiswa' => $this->mahasiswaModel->getMahasiswa($id)
        ];

        return view('mahasiswa/mahasiswa_detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Mahasiswa',
            'validation' => \Config\Services::validation()
        ];

        return view('mahasiswa/mahasiswa_add', $data);
    }

    public function save()
    {
        // validasi request
        if (!$this->validate([
            'no_induk' => [
                'rules' => 'required|integer|is_unique[mahasiswa.no_induk]|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah terdaftar',
                    'min_length' => 'Panjang minimal {field} adalah 5 karakter'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'foto_pribadi' => [
                'rules' => 'uploaded[foto_pribadi]|max_size[foto_pribadi,1024]|is_image[foto_pribadi]|mime_in[foto_pribadi,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Anda diwajibkan untuk mengisi {field}',
                    'max_size' => 'Ukuran gambar terlalu besar (maks: 1 MB)',
                    'is_image' => 'Format gambar tidak diizinkan',
                    'mime_in' => 'Format gambar tidak diizinkan'
                ],
            ],
            'foto_ktp' => [
                'rules' => 'uploaded[foto_ktp]|max_size[foto_ktp,1024]|is_image[foto_ktp]|mime_in[foto_ktp,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Anda diwajibkan untuk mengisi {field}',
                    'max_size' => 'Ukuran gambar terlalu besar (maks: 1 MB)',
                    'is_image' => 'Format gambar tidak diizinkan',
                    'mime_in' => 'Format gambar tidak diizinkan'
                ],
            ]
        ])) {
            session()->setFlashdata('pesan', 'Terdapat isian yang tidak sesuai, mohon dikoreksi!');
            return redirect()->to('/mahasiswa/create')->withInput();
        }

        // mendapatkan file request
        $fileFotoPribadi = $this->request->getFile('foto_pribadi');
        $fileFotoKtp = $this->request->getFile('foto_ktp');

        // mengubah nama asli file
        $nameFotoPribadi = $fileFotoPribadi->getRandomName();
        $nameFotoKtp = $fileFotoKtp->getRandomName();

        // pindah ke direktori public
        $fileFotoPribadi->move('upload/images/profile/', $nameFotoPribadi);
        $fileFotoKtp->move('upload/images/identity_card/', $nameFotoKtp);

        $this->mahasiswaModel->save([
            'no_induk' => $this->request->getVar('no_induk'),
            'nama' => $this->request->getVar('nama'),
            'foto_pribadi' => $nameFotoPribadi, // simpan sebagai nama baru dari foto
            'foto_ktp' => $nameFotoKtp
        ]);

        session()->setFlashdata('pesan', 'Mahasiswa berhasil disimpan');
        return redirect()->to('/mahasiswa');
    }

    public function edit($id)
    {
        session();
        $data = [
            'title' => 'Mahasiswa',
            'validation' => \Config\Services::validation(),
            'mahasiswa' => $this->mahasiswaModel->getMahasiswa($id)
        ];

        return view('mahasiswa/mahasiswa_edit', $data);
    }

    public function update($id)
    {
        // cek ketersediaan index mahasiswa
        $getAllMahasiswa = $this->mahasiswaModel->getMahasiswa();
        $available = false;

        $oldInduk = $this->request->getVar('no_induk_old');
        $currentInduk = $this->request->getVar('no_induk');

        // masih sama? skip aja..
        if ($oldInduk == $currentInduk) {
            $available = true;
        } else {
            // oh beda, kira-kira ada yang samaan ga ?
            foreach ($getAllMahasiswa as $m) {
                if ($m['no_induk'] == $currentInduk) {
                    $available = false;
                    break;
                } else {
                    $available = true;
                }
            }
        }

        // dapatkan id dari mahasiswa
        $mahasiswa = $this->mahasiswaModel->getMahasiswa($id);

        if ($available) {
            $rules = 'required|integer|min_length[5]';
        } else {
            $rules = 'required|is_unique[mahasiswa.no_induk]|integer|min_length[5]';
        }

        // validasi request
        if (!$this->validate([
            'no_induk' => [
                'rules' => $rules,
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah terdaftar',
                    'min_length' => 'Panjang minimal {field} adalah 5 karakter'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'foto_pribadi' => [
                'rules' => 'max_size[foto_pribadi,1024]|is_image[foto_pribadi]|mime_in[foto_pribadi,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar (maks: 1 MB)',
                    'is_image' => 'Format gambar tidak diizinkan',
                    'mime_in' => 'Format gambar tidak diizinkan'
                ],
            ],
            'foto_ktp' => [
                'rules' => 'max_size[foto_ktp,1024]|is_image[foto_ktp]|mime_in[foto_ktp,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar (maks: 1 MB)',
                    'is_image' => 'Format gambar tidak diizinkan',
                    'mime_in' => 'Format gambar tidak diizinkan'
                ],
            ]
        ])) {
            session()->setFlashdata('pesan', 'Terdapat isian yang tidak sesuai, mohon dikoreksi!');
            return redirect()->to('/mahasiswa/edit/' . $mahasiswa['no_induk'])->withInput();
        }

        $fileFotoPribadi = $this->request->getFile('foto_pribadi');
        $fileFotoKtp = $this->request->getFile('foto_ktp');

        // dd($fileFotoPribadi);

        // cek apakah gambar profil diganti
        if ($fileFotoPribadi->getError() == 4) {
            $nameFotoPribadi = $this->request->getVar('foto_pribadi_old');
        } else {
            $nameFotoPribadi = $fileFotoPribadi->getRandomName();
            $fileFotoPribadi->move('upload/images/profile', $nameFotoPribadi);

            unlink('upload/images/profile/' . $this->request->getVar('foto_pribadi_old'));
        }

        // cek apakah gambar ktp diganti
        if ($fileFotoKtp->getError() == 4) {
            $nameFotoKtp = $this->request->getVar('foto_ktp_old');
        } else {
            $nameFotoKtp = $fileFotoKtp->getRandomName();
            $fileFotoKtp->move('upload/images/identity_card/', $nameFotoKtp);

            unlink('upload/images/identity_card/' . $this->request->getVar('foto_ktp_old'));
        }

        $this->mahasiswaModel->save([
            'id' => $mahasiswa['id'],
            'no_induk' => $this->request->getVar('no_induk'),
            'nama' => $this->request->getVar('nama'),
            'foto_pribadi' => $nameFotoPribadi,
            'foto_ktp' => $nameFotoKtp
        ]);

        session()->setFlashdata('pesan', 'Mahasiswa berhasil diubah');
        return redirect()->to('/mahasiswa');
    }

    public function delete($induk)
    {
        $mahasiswa = $this->mahasiswaModel->getMahasiswa($induk);

        unlink('upload/images/profile/' . $mahasiswa['foto_pribadi']);
        unlink('upload/images/identity_card/' . $mahasiswa['foto_ktp']);

        $this->mahasiswaModel->delete($mahasiswa['id']);

        session()->setFlashdata('pesan', 'Mahasiswa berhasil dihapus');
        return redirect()->to('/mahasiswa');
    }
}
