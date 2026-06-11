{{--
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
--}}
    <!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - CRM Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-card animate-fade-in">
                <div class="login-header">

                    <h1>{{ getFunction("site") }}</h1>
                    <p>Hesabınıza giriş yapın</p>
                </div>
                @if(session('error'))
                    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">E-posta Adresi</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-group-icon"></i>
                            <input type="email" class="form-input" name="email" placeholder="ornek@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Şifre</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-group-icon"></i>
                            <input type="password" class="form-input" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-between align-center">
                        <label class="form-check">
                            <input type="checkbox" name="remember"> Beni hatırla
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                        <i class="fas fa-sign-in-alt"></i> Giriş Yap
                    </button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
