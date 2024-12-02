{{-- <!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Kartu RFID Siswa Sekolah</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f0f2f5;
                font-family: 'Arial', sans-serif;
                perspective: 1000px;
            }

            .card-container {
                width: 325px;
                height: 205px;
                position: relative;
                transform-style: preserve-3d;
                transition: transform 0.8s;
            }

            .card-container:hover {
                transform: rotateY(180deg);
            }

            .card-front, .card-back {
                position: absolute;
                width: 100%;
                height: 100%;
                backface-visibility: hidden;
                border-radius: 10px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                overflow: hidden;
            }

            .card-front {
                background: linear-gradient(135deg, #3498db, #2ecc71);
                color: white;
                display: flex;
                flex-direction: column;
                padding: 15px;
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

            .qr-code {
                margin-left: auto;
                width: 45px;
                height: 45px;
                border-radius: 5px;
                overflow: hidden;
            }

            .qr-code img {
                width: auto;
                height: auto;
                object-fit: cover;
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
                transform: rotateY(180deg);
                color: white;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 15px;
                text-align: center;
                text-align: center;
                font-size: 8px;
            }

            .barcode {
                width: 180px;
                height: 40px;
                border-radius: 5px;
                overflow: hidden;
                margin: 10px 0;
            }

            .barcode img {
                width: 100%;
                height: 100%;
                object-fit: cover;
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

            /* Tombol untuk mengunggah gambar */
            .upload-btn {
                position: absolute;
                bottom: 5px;
                right: 5px;
                background-color: rgba(0,0,0,0.5);
                color: white;
                border: none;
                padding: 5px 10px;
                border-radius: 3px;
                cursor: pointer;
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <div class="card-container">
            <div class="card-front">
                <div class="front-header">
                    <div class="school-logo-container">
                        <div class="school-logo">
                            <img src="{{ asset('logo.png') }}" alt="Logo Sekolah">
                        </div>
                        <div class="school-name">SMK WIYATA MANDALA</div>
                    </div>
                    <div class="qr-code">
                        {!! $user->qr_code !!}
                    </div>
                </div>
                <div class="student-photo">
                    <img src="{{ asset('aku.jpg') }}" alt="Foto Siswa">
                </div>
                <div class="student-info">
                    <div class="student-name">{{ $user->name }}</div>
                    <div class="student-details">
                        NISN: {{ $user->nisn }}<br>
                        Kelas: XII IPA 1
                    </div>
                </div>
            </div>
            
            <div class="card-back">
                <h3 style="font-size: 14px;">KARTU IDENTITAS SISWA</h3>
                <div class="barcode">
                    <img src="barcode.png" alt="Barcode">
                </div>
                <div class="contact-info">
                    SMA NEGERI 1<br>
                    Alamat: Jl. Contoh No. 123<br>
                    Telepon: (021) 1234 5678
                </div>
                <div class="terms-section">
                    SYARAT DAN KETENTUAN:
                    Kartu ini adalah milik SMK Wiyata Mandala. Kartu harus selalu dibawa dan tidak boleh dipinjamkan 
                    kepada pihak lain. Jika hilang, segera lapor ke pihak sekolah. Kartu ini berlaku selama 
                    siswa terdaftar di sekolah. Penyalahgunaan kartu akan dikenakan sanksi sesuai peraturan sekolah.
                </div>
            </div>
        </div>
    </body>
</html> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu RFID Siswa Sekolah</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            perspective: 1000px;
            margin: 0;
        }

        .card-container {
            width: 325px;
            height: 205px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s;
        }

        .card-container:hover {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .card-front {
            background: linear-gradient(135deg, #3498db, #2ecc71);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 15px;
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

        .qr-code {
            margin-left: auto;
            width: 45px;
            height: 45px;
            border-radius: 5px;
            overflow: hidden;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            transform: rotateY(180deg);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            text-align: center;
            font-size: 8px;
        }

        .qr-code-back {
            width: auto;
            height: auto;
            border-radius: 5px;
            overflow: hidden;
            margin: 5px 0;
        }

        .qr-code-back img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
    </style>
</head>
<body>
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
                <div class="student-name">NAMA SISWA</div>
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
</body>
</html>