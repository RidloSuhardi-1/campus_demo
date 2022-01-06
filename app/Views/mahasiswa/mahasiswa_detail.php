<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
    <a href="<?= base_url('/mahasiswa'); ?>" class="btn btn-sm btn-outline-secondary">Kembali ke mahasiswa</a>
</div>

<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="<?= ($mahasiswa['foto_pribadi'] == null) ? '/img/default.jpg' : base_url('/upload/images/profile/' . $mahasiswa['foto_pribadi']); ?>" class="img-fluid rounded-start" alt="<?= $mahasiswa['nama']; ?>">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= $mahasiswa['nama']; ?></h5>
                <p class="card-text"><b>No Induk : </b><?= $mahasiswa['no_induk']; ?></p>
                <p class="card-text"><small class="text-muted">Terdaftar sejak : <?= $mahasiswa['created_at']; ?></small></p>

                <h5 class="card-text">Kartu Identitas</h5>
                <a href="<?= ($mahasiswa['foto_ktp'] == null) ? '/img/default.jpg' : base_url('/upload/images/identity_card/' . $mahasiswa['foto_ktp']); ?>" class="link-primary" data-lightbox="<?= $mahasiswa['nama']; ?>" data-title="KTP <?= $mahasiswa['nama']; ?>">
                    <img src="<?= ($mahasiswa['foto_ktp'] == null) ? '/img/default.jpg' : base_url('/upload/images/identity_card/' . $mahasiswa['foto_ktp']); ?>" class="img-thumbnail rounded-start" width="150" alt="<?= $mahasiswa['nama']; ?>">
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>