<?php
@ob_start();
session_start();

// ===== AUTH CHECK =====
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header("Location: /sitangkal/login/");
    exit;
}

require_once '../config.php';
require_once 'core/PohonModel.php';

$model        = new PohonModel($config);
$statusUpdate = null;

// ===== CEK ID =====
if (!isset($_GET['id'])) {
    header("Location: pohon.php");
    exit;
}

$id   = (int) $_GET['id'];
$data = $model->getById($id);

if (!$data) {
    header("Location: pohon.php");
    exit;
}

// ===== PROSES UPDATE =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaPohon   = trim($_POST['nama_pohon']    ?? '');
    $jenisPohon  = trim($_POST['jenis_pohon']   ?? '');
    $kondisi     = trim($_POST['kondisi_pohon'] ?? '');
    $lokasi      = trim($_POST['lokasi']        ?? '');
    $keterangan  = trim($_POST['keterangan']    ?? '');

    $allowedKondisi = ['Sehat', 'Kurang Baik', 'MATI'];

    if ($namaPohon && $jenisPohon && in_array($kondisi, $allowedKondisi) && $lokasi) {
        $ok = $model->update($id, $namaPohon, $jenisPohon, $kondisi, $lokasi, $keterangan);
        $statusUpdate = $ok ? 'success' : 'error';
        if ($ok) {
            $data = $model->getById($id); // Refresh data
        }
    } else {
        $statusUpdate = 'error_validation';
    }
}

$pageTitle  = 'Edit Pohon';
$activePage = 'pohon';
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb" style="font-size:0.8rem;">
        <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="pohon.php" class="text-success">Kondisi Pohon</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-12 col-xl-8">

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square text-warning"></i>
                <strong>Edit Data Pohon</strong>
                <span class="badge bg-secondary ms-auto">#<?= $id ?></span>
            </div>
            <div class="card-body p-4">
                <form method="POST">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label" for="nama_pohon">Nama Lokal <span class="text-danger">*</span></label>
                            <input type="text" id="nama_lokal" name="nama_lokal" class="form-control"
                                   value="<?= htmlspecialchars($data['nama_lokal']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pohon">Jenis Latin </label>
                            <input type="text" id="nama_latin" name="nama_latin" class="form-control"
                                   value="<?= htmlspecialchars($data['nama_latin']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pohon">Family </label>
                            <input type="text" id="family" name="family" class="form-control"
                            value="<?= htmlspecialchars($data['family']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="kondisi_pohon">Kondisi <span class="text-danger">*</span></label>
                            <select id="kondisi_pohon" name="kondisi_pohon" class="form-select" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Sehat"        <?= ($data['kesehatan'] === 'Sehat')        ? 'selected' : '' ?>>Sehat</option>
                                <option value="Kurang Sehat" <?= ($data['kesehatan'] === 'Kurang Sehat') ? 'selected' : '' ?>>Kurang Sehat</option>
                                <option value="Sakit"        <?= ($data['kesehatan'] === 'Sakit')        ? 'selected' : '' ?>>Sakit</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pohon">Tahun Tanam </label>
                            <input type="text" id="tahun_tanam" name="tahun_tanam" class="form-control"
                                value="<?= htmlspecialchars($data['tahun_tanam']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pohon">Habitus </label>
                            <input type="text" id="habitus" name="habitus" class="form-control"
                                value="<?= htmlspecialchars($data['habitus']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pohon">Status Kelompok </label>
                            <input type="text" id="status_ke" name="status_kel" class="form-control"
                            value="<?= htmlspecialchars($data['status_kel']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pohon">Volume </label>
                            <input type="text" id="volume" name="volume" class="form-control"
                            value="<?= htmlspecialchars($data['volume']) ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="jenis_pohon">Kelas Awet </label>
                            <select id="kelas_awet" name="kelas_awet" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="I (Satu)" <?= ($data['kelas_awet'] === 'I (Satu)') ? 'selected' : '' ?>>I (Satu)</option>
                                <option value="II (Dua)" <?= ($data['kelas_awet'] === 'II (Dua)') ? 'selected' : '' ?>>II (Dua)</option>
                                <option value="III (Tiga)" <?= ($data['kelas_awet'] === 'III (Tiga)') ? 'selected' : '' ?>>III (Tiga)</option>
                                <option value="IV (Empat)" <?= ($data['kelas_awet'] === 'IV (Empat)') ? 'selected' : '' ?>>IV (Empat)</option>
                                <option value="V (Lima)" <?= ($data['kelas_awet'] === 'V (Lima)') ? 'selected' : '' ?>>V (Lima)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="jenis_pohon">Kelas Kuat </label>
                            <select id="kelas_kuat" name="kelas_kuat" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="I (Satu)" <?= ($data['kelas_kuat'] === 'I (Satu)') ? 'selected' : '' ?>>I (Satu)</option>
                                <option value="II (Dua)" <?= ($data['kelas_kuat'] === 'II (Dua)') ? 'selected' : '' ?>>II (Dua)</option>
                                <option value="III (Tiga)" <?= ($data['kelas_kuat'] === 'III (Tiga)') ? 'selected' : '' ?>>III (Tiga)</option>
                                <option value="IV (Empat)" <?= ($data['kelas_kuat'] === 'IV (Empat)') ? 'selected' : '' ?>>IV (Empat)</option>
                                <option value="V (Lima)" <?= ($data['kelas_kuat'] === 'V (Lima)') ? 'selected' : '' ?>>V (Lima)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="lokasi_pohon">Berat Jenis </label>
                            <input type="text" id="berat_jenis" name="berat_jenis" class="form-control"
                            value="<?= htmlspecialchars($data['berat_jenis']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="lokasi_pohon">Serapan CO2 </label>
                            <input type="text" id="serapan_co" name="serapan_co" class="form-control"
                            value="<?= htmlspecialchars($data['serapan_co']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="lokasi_pohon">Produksi O2 </label>
                            <input type="text" id="produksi_o" name="produksi_o" class="form-control"
                            value="<?= htmlspecialchars($data['produksi_o']) ?>">
                        </div>
                        <!--<div class="col-md-6">
                            <label class="form-label">Preview Kondisi</label>
                            <div id="kondisiBadgePreview" class="p-2 rounded-2" style="border:1px solid var(--border-color); background:#f8fafc; min-height:38px; display:flex; align-items:center;">
                                <?php
                                    $bc = match($data['kesehatan']) {
                                        'Sehat' => 'bg-success-subtle text-success',
                                        'Kurang Sehat' => 'bg-warning-subtle text-warning',
                                        'Sakit' => 'bg-danger-subtle text-danger',
                                        default => 'bg-secondary-subtle text-secondary'
                                    };
                                ?>
                                <span class="badge rounded-pill <?= $bc ?>" id="kondisiBadge">
                                    <?= htmlspecialchars($data['kesehatan']) ?>
                                </span>
                            </div>
                        </div>-->

                        <div class="col-12">
                            <label class="form-label" for="lokasi">Nama Jalan </label>
                            <input type="text" id="nama_jalan" name="nama_jalan" class="form-control"
                                   value="<?= htmlspecialchars($data['nama_jalan']) ?>">
                        </div>

                        <div class="col-6">
                            <label class="form-label" for="lokasi">Kecamatan </label>
                            <input type="text" id="kecamatan" name="kecamatan" class="form-control"
                                   value="<?= htmlspecialchars($data['kecamatan']) ?>">
                        </div>

                        <div class="col-6">
                            <label class="form-label" for="lokasi">Kelurahan </label>
                            <input type="text" id="kelurahan" name="kelurahan" class="form-control"
                                   value="<?= htmlspecialchars($data['kelurahan']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="lokasi_pohon">Latitude (x) <span class="text-danger">*</span></label>
                            <input type="text" id="latitide" name="latitude" class="form-control"
                            value="<?= htmlspecialchars($data['koordinat_x']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="lokasi_pohon">Longitude (y) <span class="text-danger">*</span></label>
                            <input type="text" id="longitude" name="longitude" class="form-control"
                            value="<?= htmlspecialchars($data['koordinat_y']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3"
                                      placeholder="Catatan tambahan..."><?= htmlspecialchars($data['keterangan'] ?? '') ?></textarea>
                        </div>

                    </div><!-- /.row -->

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="pohon.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
// Live badge preview saat kondisi berubah
document.getElementById('kondisi_pohon').addEventListener('change', function () {
    const badge = document.getElementById('kondisiBadge');
    const val   = this.value;

    badge.textContent = val || '—';
    badge.className   = 'badge rounded-pill ';

    if (val === 'Sehat')        badge.className += 'bg-success-subtle text-success';
    else if (val === 'Kurang Baik') badge.className += 'bg-warning-subtle text-warning';
    else if (val === 'MATI')   badge.className += 'bg-danger-subtle text-danger';
    else badge.className += 'bg-secondary-subtle text-secondary';
});

<?php if ($statusUpdate === 'success'): ?>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data pohon berhasil diperbarui.',
        confirmButtonColor: '#28a745',
        timer: 2500,
        timerProgressBar: true
    });
});
<?php elseif ($statusUpdate === 'error'): ?>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Terjadi kesalahan saat menyimpan data.',
        confirmButtonColor: '#dc3545'
    });
});
<?php elseif ($statusUpdate === 'error_validation'): ?>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'warning',
        title: 'Data Tidak Lengkap',
        text: 'Nama pohon, jenis, kondisi, dan lokasi wajib diisi.',
        confirmButtonColor: '#fd7e14'
    });
});
<?php endif; ?>
</script>

<?php require_once 'layouts/footer.php'; ?>
