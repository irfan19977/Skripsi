<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu RFID Siswa Sekolah</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
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
            width: 340px;
            height: 227px;
            position: relative;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            page-break-inside: avoid;
            display: flex;
            flex-direction: row;
            gap: 10px;
        }

        .card-front, .card-back {
            width: 340px;
            height: 227px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .card-front {
            background: linear-gradient(135deg, #1E90FF, #4CAF50);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        .front-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            background-color: rgba(0,0,0,0.2);
            padding: 5px;
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
            /* border: 2px solid white; */
        }

        .school-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .school-name-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 10px;
        }

        .school-name {
            font-size: 16px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            margin-bottom: 3px;
            margin-top: 3px;
        }

        .school-address {
            font-size: 8px;
            opacity: 0.8;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .student-photo {
            width: 80px;
            height: 100px;
            border-radius: 5px;
            align-self: center;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .student-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-info {
            text-align: center;
            margin-top: 2px;
        }

        .student-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .student-details {
            font-size: 10px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .card-back {
            background: linear-gradient(135deg, #2C3E50, #34495E);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        .qr-code-back {
            width: 80px;
            height: 80px;
            overflow: hidden;
            margin: 5px 0;
            border: 2px solid white;
            border-radius: 5px;
        }

        .terms-section {
            text-align: center;
            margin-top: 5px;
            font-size: 6px;
            line-height: 1.2;
            padding: 0 10px;
            opacity: 0.8;
        }

        .contact-info {
            font-size: 8px;
            margin-top: 5px;
            opacity: 0.9;
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

            .card-front {
                background: linear-gradient(135deg, #1E90FF, #4CAF50) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .card-back {
                background: linear-gradient(135deg, #2C3E50, #34495E) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    @foreach ($students as $student)
        <div class="card-layout">
            <!-- Card 1 -->
            <div class="card-container">
                <div class="card-front">
                    <div class="front-header">
                        <div class="school-logo-container">
                            <div class="school-logo">
                                <img src="{{ asset('logo.png') }}" alt="Logo Sekolah">
                            </div>
                            <div class="school-name-container">
                                <div class="school-name">SMK WIYATA MANDALA</div>
                                <div class="school-address">
                                    Jl. Pare Kandangan No.10, Kemirahan, Damarwulan, Kec. Kepung <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="student-photo">
                        <img src="{{ asset('aku.jpg') }}" alt="Foto Siswa">
                    </div>
                    <div class="student-info">
                        <div class="student-name">{{ $student->name }}</div>
                        <div class="student-details">
                            NISN: {{ $student->nisn }}<br>
                            PRODI: {{ strtoupper($student->classRoom->first()->prodi ?? 'Belum ada Jueusan') }}
                        </div>
                    </div>
                </div>
                <div class="card-back">
                    <h3 style="font-size: 10px;">KARTU IDENTITAS SISWA</h3>
                    <div class="qr-code-back">
                        {!! $student->qr_code !!}
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
    @endforeach

    <script>
        // Auto print when loaded
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>