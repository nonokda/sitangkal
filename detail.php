<?php
require 'config.php';
require_once './Admin/Pengajuan.php';

$pengajuan = new Pengajuan($config);

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];
$data = $pengajuan->getById($id);

if (!$data) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengajuan</title>
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Detail Data Pengajuan</h3>

    <table class="table table-bordered">
        <tr>
            <th>No Surat</th>
            <td><?= htmlspecialchars($data['No_Surat']); ?></td>
        </tr>
        <tr>
            <th>Nama Pemohon</th>
            <td><?= htmlspecialchars($data['Nama_Pemohon']); ?></td>
        </tr>
        <tr>
            <th>Lokasi Pohon</th>
            <td><?= htmlspecialchars($data['Lokasi_Pohon']); ?></td>
        </tr>
        <tr>
            <th>Disposisi Surat</th>
            <td><?= htmlspecialchars($data['Disposisi_Surat']); ?></td>
        </tr>
        <tr>
            <th>Survey Pohon</th>
            <td><?= htmlspecialchars($data['Survey_Pohon']); ?></td>
        </tr>
        <tr>
            <th>Tanggal Penanganan</th>
            <td><?= htmlspecialchars($data['Tanggal_Penanganan']); ?></td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>
                <?php if ($data['Keterangan'] == 'Sudah'): ?>
                    <span class="badge bg-success">Sudah</span>
                <?php else: ?>
                    <span class="badge bg-danger">Belum</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Dokumentasi</th>
            <td>
                <?php if (!empty($data['Dokumentasi'])): ?>
                    <img src="./images/<?= $data['Dokumentasi']; ?>" width="300">
                <?php else: ?>
                    Tidak ada gambar
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <a href="Pengajuan.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>
