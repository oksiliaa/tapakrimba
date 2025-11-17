<?php
session_start();
include 'config.php';

// Cek login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dari tabel devices
$result = $conn->query("SELECT * FROM devices ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="asset/foto.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            color: white;
            overflow-x: hidden;
            background: linear-gradient(270deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
            background-size: 800% 800%;
            animation: gradientMove 12s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Efek bokeh */
        .bokeh {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            animation: float 10s infinite ease-in-out;
        }

        .circle:nth-child(1) { width: 200px; height: 200px; top: 10%; left: 20%; animation-delay: 0s; }
        .circle:nth-child(2) { width: 150px; height: 150px; bottom: 20%; right: 15%; animation-delay: 3s; }
        .circle:nth-child(3) { width: 250px; height: 250px; top: 60%; left: 60%; animation-delay: 6s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
            50% { transform: translateY(-40px) scale(1.1); opacity: 0.9; }
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        .btn {
            transition: 0.2s ease;
        }
        .btn:hover {
            transform: scale(1.05);
        }

        .card-table {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            animation: fadeIn 0.8s ease-in-out;
        }

        table {
            width: 100%;
            color: white;
            border-radius: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        thead {
            background: rgba(255,255,255,0.15);
        }

        tbody tr {
            animation: fadeUp 0.6s ease-in-out forwards;
            opacity: 0;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f7971e, #ffd200);
            border: none;
            color: black;
        }

        .btn-danger {
            background: linear-gradient(135deg, #e52d27, #b31217);
            border: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        @keyframes fadeUp {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        footer {
            text-align: center;
            color: rgba(255,255,255,0.7);
            margin-top: 40px;
            font-size: 0.9rem;
        }

        /* Input pencarian */
        #search {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            border-radius: 10px;
        }
        #search::placeholder {
            color: #e0e0e0;
        }
        #search:focus {
            background: rgba(255,255,255,0.25);
            box-shadow: none;
            outline: none;
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="bokeh">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <nav class="navbar navbar-dark p-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
               <img src="asset/foto.png" alt="Logo" width="39" height="40">
                <span class="navbar-brand">Inventaris Hardware</span> 
            </div>
            <div>
                <a href="add_device.php" class="btn btn-light btn-sm me-2">
                    <i class="bi bi-plus-circle"></i> Tambah Perangkat
                </a>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card-table">
            <h3 class="text-center mb-4">Daftar Hardware</h3>

            <input type="text" id="search" class="form-control mb-3" placeholder="🔍 Cari perangkat...">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                         <th class="text-center">No</th>
                         <th class="text-center">Nama</th>
                         <th class="text-center">Merek</th>
                         <th class="text-center">IP Address</th>
                         <th class="text-center">Lokasi</th>
                         <th class="text-center">Jenis</th>
                         <th class="text-center">Status</th>
                         <th class="text-center">Tanggal Pasang</th>
                         <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            // Badge warna status
                            $status = $row['status'];
                            $badge = "<span class='badge ";
                            if ($status == "Aktif") $badge .= "bg-success";
                            elseif ($status == "Nonaktif") $badge .= "bg-secondary";
                            else $badge .= "bg-warning text-dark";
                            $badge .= "'>$status</span>";

                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['brand']}</td>
                                    <td>{$row['ip_address']}</td>
                                    <td>{$row['location']}</td>
                                    <td>{$row['type']}</td>
                                    <td>{$badge}</td>
                                    <td>{$row['installed_date']}</td>
                                    <td>
                                        <a href='edit_device.php?id={$row['id']}' class='btn btn-warning btn-sm me-1'>
                                            <i class='bi bi-pencil-square'></i> Ubah
                                        </a>
                                        <a href='delete_device.php?id={$row['id']}' class='btn btn-danger btn-sm' 
                                        onclick=\"return confirm('Yakin ingin menghapus perangkat ini?')\">
                                        <i class='bi bi-trash3'></i> Hapus
                                        </a>
                                    </td>
                                  </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <footer>
            © <?= date('Y') ?> Inventaris Hardware
        </footer>
    </div>

    <script>
        // Fitur pencarian cepat
        document.getElementById("search").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("tbody tr");
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>
