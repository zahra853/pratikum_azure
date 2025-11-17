<?php
// index.php - Simple PHP website for "Skincare Zahra"
// Place this file in your PHP server root (e.g., htdocs for XAMPP) and open http://localhost/index.php

// Sample product data
$products = [
    [
        'id' => 1,
        'name' => 'Zahra Glow Cleanser',
        'price' => 75000,
        'desc' => 'Pembersih lembut untuk semua jenis kulit, membersihkan tanpa membuat kering.'
    ],
    [
        'id' => 2,
        'name' => 'Zahra Rose Toner',
        'price' => 85000,
        'desc' => 'Toner pelembap dengan ekstrak mawar untuk menenangkan kulit.'
    ],
    [
        'id' => 3,
        'name' => 'Zahra Night Serum',
        'price' => 150000,
        'desc' => 'Serum malam yang memperbaiki tekstur kulit dan mengurangi garis halus.'
    ],
];

// Simple contact form handling: save to contacts.txt
$contact_saved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
    $name = strip_tags(trim($_POST['name'] ?? '')); 
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST['message'] ?? ''));
    if ($name && $email && $message) {
        $line = date('Y-m-d H:i:s') . " | $name | $email | $message
";
        file_put_contents(__DIR__ . '/contacts.txt', $line, FILE_APPEND | LOCK_EX);
        $contact_saved = true;
    }
}

// Helper to format price
function rupiah($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

// If product detail requested
$detail = null;
if (isset($_GET['product'])) {
    $id = (int)$_GET['product'];
    foreach ($products as $p) {
        if ($p['id'] === $id) { $detail = $p; break; }
    }
}

?><!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Skincare Zahra</title>
    <style>
        :root{
            --bg:#2b1720;
            --card:#3a2130;
            --accent:#c68aa0;
            --muted:#b88a98;
            --text:#f3e8ea;
        }
        *{box-sizing:border-box}
        body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;background:linear-gradient(135deg,var(--bg),#2f2330);color:var(--text);min-height:100vh}
        header{padding:28px 24px;text-align:center;background:linear-gradient(180deg, rgba(255,255,255,0.02), transparent);backdrop-filter: blur(2px)}
        .brand{font-size:28px;font-weight:700;letter-spacing:1px;color:var(--accent)}
        .tag{font-size:13px;color:var(--muted);margin-top:6px}
        .container{max-width:1000px;margin:28px auto;padding:0 18px}
        .grid{display:grid;grid-template-columns:2fr 1fr;gap:20px}
        .card{background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(0,0,0,0.02));padding:18px;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,0.45);border:1px solid rgba(255,255,255,0.03)}
        .products{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px}
        .product{padding:14px;border-radius:12px;background:linear-gradient(180deg,var(--card), rgba(255,255,255,0.01));}
        .product h3{margin:0 0 8px 0;color:var(--accent)}
        .price{font-weight:700;margin-top:10px}
        .btn{display:inline-block;padding:8px 12px;border-radius:10px;background:linear-gradient(180deg,var(--accent),#b4708a);color:var(--text);text-decoration:none}
        aside h4{margin-top:0;color:var(--accent)}
        .contact input,.contact textarea{width:100%;padding:10px;margin:8px 0;border-radius:8px;border:1px solid rgba(255,255,255,0.05);background:transparent;color:var(--text)}
        footer{text-align:center;padding:18px;color:var(--muted);font-size:14px}
        .hero{display:flex;gap:16px;align-items:center;justify-content:center;padding:18px;border-radius:12px;background:linear-gradient(135deg, rgba(198,138,160,0.06), rgba(0,0,0,0.02));}
        .hero .logo{width:110px;height:110px;border-radius:16px;background:linear-gradient(135deg,var(--accent),#a86b82);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:28px;color:var(--text);box-shadow:0 10px 30px rgba(0,0,0,0.45)}
        .small{font-size:13px;color:var(--muted)}
        .note{font-size:13px;color:var(--muted);margin-top:8px}
        a {color:inherit}
        .backlink{font-size:13px;display:inline-block;margin-top:12px;color:var(--muted)}
    </style>
</head>
<body>
    <header>
        <div class="brand">Skincare Zahra</div>
        <div class="tag">Natural · Gentle · Glow</div>
    </header>

    <main class="container">
        <div class="grid">
            <section class="card">
                <div class="hero">
                    <div class="logo">SZ</div>
                    <div>
                        <h2 style="margin:0;color:var(--text)">Perawatan kulit yang lembut dan efektif</h2>
                        <p class="small">Rangkaian produk buatan lokal untuk kebutuhan harianmu — bersih, lembap, dan bercahaya.</p>
                    </div>
                </div>

                <?php if ($detail): ?>
                    <div style="margin-top:16px">
                        <a class="backlink" href="index.php">← Kembali ke daftar produk</a>
                        <div class="product" style="margin-top:12px">
                            <h3><?=htmlspecialchars($detail['name'])?></h3>
                            <div class="note"><?=htmlspecialchars($detail['desc'])?></div>
                            <div class="price"><?=rupiah($detail['price'])?></div>
                            <p style="margin-top:12px">Stok: tersedia</p>
                            <a class="btn" href="index.php">Beli Sekarang</a>
                        </div>
                    </div>
                <?php else: ?>
                    <h3 style="margin-top:16px;color:var(--accent)">Produk Kami</h3>
                    <div class="products" style="margin-top:12px">
                        <?php foreach ($products as $p): ?>
                            <div class="product">
                                <h3><?=htmlspecialchars($p['name'])?></h3>
                                <div class="note"><?=htmlspecialchars($p['desc'])?></div>
                                <div class="price"><?=rupiah($p['price'])?></div>
                                <div style="margin-top:10px">
                                    <a class="btn" href="?product=<?=$p['id']?>>">Lihat</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </section>

            <aside class="card">
                <h4>Tentang Zahra</h4>
                <p class="small">Skincare Zahra fokus pada formula sederhana dengan bahan berkualitas. Cocok untuk kulit sensitif yang butuh perhatian ekstra.</p>

                <hr style="border:none;height:1px;background:rgba(255,255,255,0.03);margin:12px 0">

                <h4>Kontak</h4>
                <?php if ($contact_saved): ?>
                    <div class="note">Terima kasih — pesanmu telah kami terima.</div>
                <?php endif; ?>
                <form class="contact" method="post">
                    <input type="hidden" name="contact" value="1">
                    <input name="name" placeholder="Nama" required>
                    <input name="email" type="email" placeholder="Email" required>
                    <textarea name="message" rows="4" placeholder="Pesan" required></textarea>
                    <button class="btn" type="submit">Kirim</button>
                </form>

                <hr style="border:none;height:1px;background:rgba(255,255,255,0.03);margin:12px 0">

                <h4>Jam Operasional</h4>
                <div class="small">Senin — Jumat: 09:00 — 17:00<br>Sabtu: 09:00 — 13:00</div>

            </aside>
        </div>
    </main>

    <footer>
        &copy; <?=date('Y')?> Skincare Zahra — dibuat sederhana dengan nuansa pink gloomy
    </footer>
</body>
</html>
