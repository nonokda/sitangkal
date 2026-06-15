<?php
$pageTitle  = 'Peta Sebaran Pohon';
$activePage = 'map';
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
?>
<!-- ======= PAGE HEADING ======= -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">Peta Sebaran Pohon</h4>
        <p class="text-muted mb-0" style="font-size:0.8rem;">Kelola semua data pohon Kota Cimahi</p>
    </div>
    
</div>

<!-- ======= SEARCH & TABLE ======= -->
<div class="card">
    <iframe src="http://localhost:8888/sitangkal/map.php" title="Peta sebaran pohon" width="100%" height="700" loading="lazy" sandbox="allow-scripts allow-same-origin"></iframe>
</div>


<?php require_once 'layouts/footer.php'; ?>