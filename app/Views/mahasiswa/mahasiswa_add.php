<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
    <a href="<?= base_url('/mahasiswa'); ?>" class="btn btn-sm btn-outline-secondary">Kembali ke Mahasiswa</a>
</div>

<h2>Mahasiswa Baru</h2>
<?php if (session()->has('pesan')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= session()->get('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form action="<?= base_url('/mahasiswa/save'); ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field(); ?>
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="no_induk" class="form-label">No Induk</label>
            <input type="number" name="no_induk" class="form-control <?= ($validation->hasError('no_induk')) ? 'is-invalid' : '' ?>" id="no_induk" placeholder="" value="<?= old('no_induk'); ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('no_induk'); ?>
            </div>
        </div>

        <div class="col-sm-6">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" placeholder="" value="<?= old('nama'); ?>" required>
            <div class="invalid-feedback">
                <?= $validation->getError('nama'); ?>
            </div>
        </div>

        <div class="col-12">
            <label for="foto_pribadi" class="form-label">Foto Pribadi</label>
            <input name="foto_pribadi" class="form-control form-control-sm <?= ($validation->hasError('foto_pribadi')) ? 'is-invalid' : '' ?>" id="foto_pribadi" type="file">
            <div class="invalid-feedback">
                <?= $validation->getError('foto_pribadi'); ?>
            </div>
        </div>

        <div class="col-12">
            <label for="foto_ktp" class="form-label">Foto KTP</label>
            <input name="foto_ktp" class="form-control form-control-sm <?= ($validation->hasError('foto_ktp')) ? 'is-invalid' : '' ?>" id="foto_ktp" type="file">
            <div class="invalid-feedback">
                <?= $validation->getError('foto_ktp'); ?>
            </div>
        </div>

        <hr class="my-3">

        <button class="w-100 btn btn-primary" type="submit">Simpan</button>
</form>

<?= $this->endSection(); ?>