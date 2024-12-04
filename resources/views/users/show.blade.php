<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu RFID Siswa Sekolah</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
            /* Tambahkan opsi cetak warna */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card-layout {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 20px;
            width: 100%;
        }

        .card-container {
            width: 325px;
            height: 205px;
            position: relative;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            page-break-inside: avoid;
            display: flex;
            flex-direction: row;
            gap: 10px; /* Tambahkan jarak antara kartu depan dan belakang */
        }

        .card-front, .card-back {
            width: 325px; /* Pastikan ukuran sama */
            height: 205px; /* Pastikan ukuran sama */
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0; /* Mencegah perubahan ukuran */
        }

        .card-front {
            background: linear-gradient(135deg, #3498db, #2ecc71);
            color: white;
            display: flex;
            flex-direction: column;
        }

        .front-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .school-logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 3px;
        }

        .school-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .school-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .school-name {
            font-size: 16px;
            font-weight: bold;
        }

        .student-photo {
            width: 80px;
            height: 100px;
            border-radius: 5px;
            align-self: center;
            overflow: hidden;
        }

        .student-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-info {
            text-align: center;
        }

        .student-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .student-details {
            font-size: 10px;
        }

        .card-back {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 8px;
        }

        .qr-code-back {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            overflow: hidden;
            margin: 5px 0;
        }

        .terms-section {
            text-align: center;
            margin-top: 5px;
            font-size: 6px;
            line-height: 1.2;
            padding: 0 10px;
        }

        .contact-info {
            font-size: 8px;
            margin-top: 5px;
        }

        @media print {
            body {
                display: flex;
                flex-wrap: wrap;
            }

            .card-layout {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
            }

            .card-container {
                page-break-inside: avoid;
                margin-bottom: 20px;
            }

            /* Tambahkan pengaturan cetak warna */
            .card-front {
                background: linear-gradient(135deg, #3498db, #2ecc71) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .card-back {
                background: linear-gradient(135deg, #34495e, #2c3e50) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <div class="card-layout">
        <!-- Card 1 -->
        <div class="card-container">
            <div class="card-front">
                <div class="front-header">
                    <div class="school-logo-container">
                        <div class="school-logo">
                            <img src="{{ asset('logo.png') }}" alt="Logo Sekolah">
                        </div>
                        <div class="school-name">SMK WIYATA MANDALA</div>
                    </div>
                </div>
                <div class="student-photo">
                    <img src="{{ asset('aku.jpg') }}" alt="Foto Siswa">
                </div>
                <div class="student-info">
                    <div class="student-name">{{ $user->name }}</div>
                    <div class="student-details">
                        NISN: 1234567890<br>
                        Kelas: XII IPA 1
                    </div>
                </div>
            </div>
            <div class="card-back">
                <h3 style="font-size: 10px;">KARTU IDENTITAS SISWA</h3>
                <div class="qr-code-back">
                    {!! $user->qr_code !!}
                </div>
                <div class="contact-info">
                    SMK WIYATA MANDALA<br>
                    Jl. Pare Kandangan No.10, Kemirahan, Damarwulan, Kec. Kepung, Kabupaten Kediri, Jawa Timur<br>
                    Telepon: (0354) 328631
                </div>
                <div class="terms-section">
                    SYARAT DAN KETENTUAN:
                    Kartu ini adalah milik SMK Wiyata Mandala. Kartu harus selalu dibawa dan tidak boleh dipinjamkan 
                    kepada pihak lain. Jika hilang, segera lapor ke pihak sekolah. Kartu ini berlaku selama 
                    siswa terdaftar di sekolah. Penyalahgunaan kartu akan dikenakan sanksi sesuai peraturan sekolah.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optional: Auto print when loaded
        window.onload = function() {
            // window.print(); // Uncomment if you want auto-print
        }
    </script>
</body>
</html>