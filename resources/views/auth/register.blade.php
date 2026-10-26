<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bandeng Samudera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #0d233a;
            overflow-x: hidden;
        }
        
        .auth-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: linear-gradient(rgba(13, 35, 58, 0.65), rgba(13, 35, 58, 0.65)), url('{{ asset('image/Daftar_Akun.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto; 
            padding: 20px 0;
        }
    </style>
</head>
<body>

<div class="auth-bg container-fluid">
    
    <div class="row w-100 align-items-center justify-content-center px-3 my-auto" style="max-width: 1100px;">
        
        <div class="col-md-6 text-center text-white mb-4 mb-md-0">
            
            <div class="d-flex flex-column align-items-center justify-content-center">
                
                <div style="width: 100%; max-width: 600px; margin-bottom: -170px; z-index: 2;">
                    <svg viewBox="0 0 500 160" style="width: 100%; height: auto; overflow: visible;">
                        <defs>
                            <filter id="shadowWelcome" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="2" dy="4" stdDeviation="4" flood-color="#888080" flood-opacity="0.4" />
                            </filter>
                            <linearGradient id="welcomeGrad" x1="-5%" y1="-5%" x2="-5%" y2="80%">
                                <stop offset="0%" stop-color="#f9ec7d" />
                                <stop offset="50%" stop-color="#e19729" />
                                <stop offset="100%" stop-color="#d06f0d" />
                            </linearGradient>
                            <path id="curvePath" d="M 20,115 A 240,200 0 0,1 480,115" fill="none" />
                        </defs>

                        <text font-size="80" 
                              font-weight="900" 
                              font-family="'Arial Black', 'Montserrat', sans-serif" 
                              fill="url(#welcomeGrad)" 
                              stroke="rgba(236, 229, 229, 0.4)" 
                              stroke-width="1.5" 
                              letter-spacing="3" 
                              filter="url(#shadowWelcome)">
                            <textPath href="#curvePath" startOffset="50%" text-anchor="middle">
                                WELCOME
                            </textPath>
                        </text>
                    </svg>
                </div>

                <div style="position: relative; display: inline-block; width: 250px;" class="my-2">
                    <div style="position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); width: 320px; height: 320px; background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, rgba(64, 158, 155, 0.2) 50%, rgba(0, 0, 0, 0) 75%); border-radius: 50%; filter: blur(25px); pointer-events: none; z-index: 1;"></div>
                    
                    <img src="{{ asset('image/Logo_Bandeng.png') }}" alt="Icon Bandeng" style="width: 100%; height: auto; position: relative; z-index: 2;" class="img-fluid">
                    <img src="{{ asset('image/Nama_Logo.png') }}" alt="Teks Bandeng Samudera" style="position: absolute; top: 46%; left: 49%; transform: translate(-54%, -54%); width: 110%; height: auto; z-index: 3; pointer-events: none;">
                </div>

                <div class="mt-1 text-center">
                    <h2 class="fw-black mb-0" style="font-family: 'Arial Black', sans-serif; font-weight: 900; font-size: 2.2rem; text-shadow: 2px 3px 4px rgba(0, 0, 0, 0.4);">
                        <span class="text-white" style="letter-spacing: -0.5px;">Bandeng</span> 
                        <span style="background: linear-gradient(180deg, #ffb74d 0%, #f57c00 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Samudra</span>
                    </h2>
                    <h3 class="fw-black text-white mb-2" style="font-family: 'Arial Black', sans-serif; font-weight: 900; font-size: 1.9rem; letter-spacing: 0.5px; text-shadow: 2px 3px 6px rgba(0, 0, 0, 0.8);">Temanggung</h3>
                    <p class="text-white-50 mt-1 fs-6 mb-0" style="font-weight: 500; letter-spacing: 0.5px;">
                        Lezatnya Tradisi, Segarnya Alami
                    </p>
                </div>
            </div>

        </div>

        <div class="col-md-6 col-lg-5">
            <div class="p-3 p-md-4 shadow-lg mx-auto" style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 18px; border: 1px solid rgba(255, 255, 255, 0.25); max-width: 400px;">
                
                <h3 class="fw-bold text-white text-center mb-1 fs-4">Daftar Akun</h3>
                <p class="text-white-50 text-center mb-3" style="font-size: 0.75rem;">Lezatnya Tradisi, Segarnya Alami</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-1 px-2 mb-2 small" style="border-radius: 6px; font-size: 0.75rem;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.proses') }}" method="POST">
                    @csrf
                    
                    <div class="mb-2">
                        <label class="form-label text-white mb-1" style="font-size: 0.8rem;">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm text-white py-2" placeholder="Masukan nama Anda" value="{{ old('nama') }}" style="background: #182845; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; font-size: 0.85rem;" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-white mb-1" style="font-size: 0.8rem;">Username</label>
                        <input type="text" name="username" class="form-control form-control-sm text-white py-2" placeholder="Masukan username Unik" value="{{ old('username') }}" style="background: #182845; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; font-size: 0.85rem;" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-white mb-1" style="font-size: 0.8rem;">Email</label>
                        <input type="email" name="email" class="form-control form-control-sm text-white py-2" placeholder="Contoh@gmail.com" value="{{ old('email') }}" style="background: #182845; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; font-size: 0.85rem;" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white mb-1" style="font-size: 0.8rem;">Password</label>
                        <input type="password" name="password" class="form-control form-control-sm text-white py-2" placeholder="••••••••" style="background: #182845; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; font-size: 0.85rem;" required>
                    </div>

                    <button type="submit" class="btn w-100 fw-bold text-white shadow-sm mb-2 py-2" style="background: linear-gradient(135deg, #2b6cb0, #4299e1); border-radius: 8px; font-size: 0.85rem;">
                        Daftar Sekarang
                    </button>

                    <div class="text-center">
                        <span class="text-white-50" style="font-size: 0.75rem;">Sudah punya Akun? </span>
                        <a href="{{ route('login') }}" class="text-white fw-semibold text-decoration-underline" style="font-size: 0.75rem;">Masuk Sini</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>