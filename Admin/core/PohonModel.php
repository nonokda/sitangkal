<?php

/**
 * PohonModel
 * Kelas model untuk semua operasi CRUD pada tabel `pohon`.
 * Menggunakan PDO Prepared Statements untuk keamanan SQL Injection.
 */
class PohonModel
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    /**
     * Ambil semua data pohon, diurutkan dari terbaru.
     */
    public function getAll(): array
    {
        $stmt = $this->conn->query("SELECT * FROM pohon ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil satu data pohon berdasarkan ID.
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->conn->prepare("SELECT * FROM pohon WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cari data pohon berdasarkan nama pohon atau lokasi.
     */
    public function search(string $keyword): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM pohon
             WHERE nama_lokal LIKE ? OR nama_jalan LIKE ? OR kesehatan LIKE ?
             ORDER BY id DESC"
        );
        $like = "%{$keyword}%";
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil N data pohon terbaru untuk tampilan dashboard.
     */
    public function getLatest(int $limit = 10): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM pohon ORDER BY id DESC LIMIT ?"
        );
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tambah data pohon baru.
     */
    public function create(
        string $nama_pohon,
        string $jenis_pohon,
        string $kondisi_pohon,
        string $lokasi,
        string $keterangan
    ): bool {
        $sql = "INSERT INTO pohon (nama_pohon, jenis_pohon, kondisi_pohon, lokasi, keterangan)
                VALUES (:nama_pohon, :jenis_pohon, :kondisi_pohon, :lokasi, :keterangan)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nama_pohon'   => $nama_pohon,
            ':jenis_pohon'  => $jenis_pohon,
            ':kondisi_pohon'=> $kondisi_pohon,
            ':lokasi'       => $lokasi,
            ':keterangan'   => $keterangan,
        ]);
    }

    /**
     * Update data pohon secara lengkap.
     */
    public function update(
        int    $id,
        string $nama_pohon,
        string $jenis_pohon,
        string $kondisi_pohon,
        string $lokasi,
        string $keterangan
    ): bool {
        $sql = "UPDATE pohon SET
                    nama_pohon    = :nama_pohon,
                    jenis_pohon   = :jenis_pohon,
                    kondisi_pohon = :kondisi_pohon,
                    lokasi        = :lokasi,
                    keterangan    = :keterangan
                WHERE id_pohon = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nama_pohon'    => $nama_pohon,
            ':jenis_pohon'   => $jenis_pohon,
            ':kondisi_pohon' => $kondisi_pohon,
            ':lokasi'        => $lokasi,
            ':keterangan'    => $keterangan,
            ':id'            => $id,
        ]);
    }

    /**
     * Hapus data pohon berdasarkan ID.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM pohon WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Hitung jumlah pohon berdasarkan kondisi.
     * @param string $kondisi 'Sehat' | 'Kurang Baik' | 'MATI'
     */
    public function countByKondisi(string $kondisi): int
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM pohon WHERE kesehatan = ?"
        );
        $stmt->execute([$kondisi]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Hitung total seluruh pohon.
     */
    public function countAll(): int
    {
        return (int) $this->conn->query("SELECT COUNT(*) FROM pohon")->fetchColumn();
    }
}
