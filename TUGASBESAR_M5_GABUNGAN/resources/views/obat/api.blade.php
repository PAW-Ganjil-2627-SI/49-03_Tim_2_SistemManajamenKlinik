<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Farmasi (via API) - Klinik Rawat Jalan</title>
    <style>
        body { font-family: Arial, sans-serif; color: #2c3e50; max-width: 1100px; margin: 0 auto; padding: 24px; }
        h1 { margin-bottom: 4px; }
        .sub { color: #555; margin: 0 0 16px; }
        .toolbar { margin-bottom: 16px; }
        input[type=search] { padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; width: 280px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px 12px; text-align: left; }
        th { background: #f2f4f5; }
        .pager { margin-top: 16px; display: flex; gap: 8px; align-items: center; }
        button { padding: 8px 14px; border: 0; border-radius: 4px; background: #3aa655; color: #fff; cursor: pointer; }
        button:disabled { background: #b5c7ba; cursor: not-allowed; }
        .info { color: #555; }
        .error { color: #c0392b; }
        a { color: #2c3e50; }
    </style>
</head>
<body>
    <h1>Katalog Farmasi</h1>
    <p class="sub">Data dimuat lewat API <code>/api/obat</code></p>
    <p><a href="/obat">&larr; Kembali ke halaman Katalog Farmasi</a></p>

    <div class="toolbar">
        <input type="search" id="cari" placeholder="Cari nama obat...">
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kategori Obat</th>
                <th>Sediaan</th>
                <th>Pabrikan</th>
            </tr>
        </thead>
        <tbody id="isi"></tbody>
    </table>

    <div class="pager">
        <button id="sebelumnya" type="button">&laquo; Sebelumnya</button>
        <button id="berikutnya" type="button">Berikutnya &raquo;</button>
        <span id="info" class="info"></span>
    </div>

    <script>
        const isi = document.getElementById('isi');
        const info = document.getElementById('info');
        const cari = document.getElementById('cari');
        const btnPrev = document.getElementById('sebelumnya');
        const btnNext = document.getElementById('berikutnya');

        let halaman = 1;
        let timer = null;

        function buatSel(teks) {
            const td = document.createElement('td');
            td.textContent = teks ?? '';
            return td;
        }

        function tampilkan(daftar, mulai) {
            isi.innerHTML = '';

            if (daftar.length === 0) {
                const tr = document.createElement('tr');
                const td = buatSel('Data obat tidak ditemukan');
                td.colSpan = 5;
                tr.appendChild(td);
                isi.appendChild(tr);
                return;
            }

            daftar.forEach(function (obat, i) {
                const tr = document.createElement('tr');
                tr.appendChild(buatSel(mulai + i));
                tr.appendChild(buatSel(obat.nama_obat));
                tr.appendChild(buatSel(obat.kategori));
                tr.appendChild(buatSel(obat.sediaan));
                tr.appendChild(buatSel(obat.pabrikan));
                isi.appendChild(tr);
            });
        }

        async function muatData() {
            info.className = 'info';
            info.textContent = 'Memuat data...';

            const params = new URLSearchParams({ page: halaman, per_page: 10 });
            const kata = cari.value.trim();
            if (kata !== '') {
                params.set('search', kata);
            }

            try {
                const res = await fetch('/api/obat?' + params.toString(), {
                    headers: { 'Accept': 'application/json' }
                });

                if (!res.ok) {
                    throw new Error('Status ' + res.status);
                }

                const json = await res.json();
                const p = json.data;

                tampilkan(p.data, p.from || 1);

                btnPrev.disabled = !p.prev_page_url;
                btnNext.disabled = !p.next_page_url;
                info.textContent = 'Halaman ' + p.current_page + ' dari ' + p.last_page + ' (total ' + p.total + ' obat)';
            } catch (err) {
                isi.innerHTML = '';
                btnPrev.disabled = true;
                btnNext.disabled = true;
                info.className = 'error';
                info.textContent = 'Gagal memuat data dari API: ' + err.message;
            }
        }

        btnPrev.addEventListener('click', function () {
            if (halaman > 1) {
                halaman--;
                muatData();
            }
        });

        btnNext.addEventListener('click', function () {
            halaman++;
            muatData();
        });

        cari.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                halaman = 1;
                muatData();
            }, 300);
        });

        muatData();
    </script>
</body>
</html>
