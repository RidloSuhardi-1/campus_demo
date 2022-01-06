<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
    <a href="<?= base_url('/mahasiswa'); ?>" class="btn btn-sm btn-outline-secondary">Kembali ke Mahasiswa</a>
</div>

<h2>Ubah Mahasiswa</h2>
<?php if (session()->has('pesan')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= session()->get('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form action="<?= base_url('/mahasiswa/update/' . $mahasiswa['no_induk']); ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field(); ?>
    <input type="hidden" value="<?= $mahasiswa['foto_pribadi']; ?>" name="foto_pribadi_old">
    <input type="hidden" value="<?= $mahasiswa['foto_ktp']; ?>" name="foto_ktp_old">
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="no_induk" class="form-label">No Induk</label>
            <input type="number" class="form-control <?= ($validation->hasError('no_induk')) ? 'is-invalid' : '' ?>" id="no_induk" placeholder="" value="<?= old('no_induk', $mahasiswa['no_induk']); ?>" name="no_induk" required>
            <div class="invalid-feedback">
                <?= $validation->getError('no_induk'); ?>
            </div>
        </div>

        <div class="col-sm-6">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" placeholder="" value="<?= old('nama', $mahasiswa['nama']); ?>" name="nama" required>
            <div class="invalid-feedback">
                <?= $validation->getError('nama'); ?>
            </div>
        </div>

        <div class="col-12">
            <label for="foto_pribadi" class="form-label">Foto Pribadi</label>
            <div class="row">
                <div class="col-8">
                    <input type="file" class="form-control form-control-sm <?= ($validation->hasError('foto_pribadi')) ? 'is-invalid' : '' ?>" id="foto_pribadi" name="foto_pribadi">
                    <div class="invalid-feedback">
                        <?= $validation->getError('foto_pribadi'); ?>
                    </div>
                </div>
                <div class="col-4">
                    <img src="<?= base_url('upload/images/profile/' . $mahasiswa['foto_pribadi']); ?>" alt="" class="img-thumbnail" width="100">
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="foto_ktp" class="form-label">Foto KTP</label>
            <div class="row">
                <div class="col-8">
                    <input type="file" class="form-control form-control-sm <?= ($validation->hasError('foto_ktp')) ? 'is-invalid' : '' ?>" id="foto_ktp" name="foto_ktp">
                    <div class="invalid-feedback">
                        <?= $validation->getError('foto_ktp'); ?>
                    </div>
                </div>
                <div class="col-4">
                    <img src="<?= base_url('upload/images/identity_card/' . $mahasiswa['foto_ktp']); ?>" alt="" class="img-thumbnail" width="100">
                </div>
            </div>
        </div>

        <hr class="my-3">

        <button class="w-100 btn btn-primary" type="submit">Ubah</button>
</form>

<?= $this->endSection(); ?>