<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>

        body {
            background-color: #f5f4f0;
            min-height: 100vh;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e2e0d9;
            box-shadow: 0 2px 24px 0 rgba(30, 28, 22, 0.07);
        }

        .input-field {
            background: #fafaf8;
            border: 1px solid #dddbd3;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-field:focus {
            outline: none;
            border-color: #1e1c16;
            box-shadow: 0 0 0 3px rgba(30, 28, 22, 0.08);
            background: #fff;
        }

        .btn-primary {
            background: #1e1c16;
            color: #fff;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-primary:hover {
            background: #3a3828;
        }
        .btn-primary:active {
            transform: scale(0.99);
        }

        .divider {
            height: 1px;
            background: #e2e0d9;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .fade-in {
            animation: fadeIn 0.4s ease both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .label-tag {
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 600;
            color: #6b6960;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-md fade-in">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="brand text-3xl text-[#1e1c16] mb-1">Espace Admin</h1>
            <p class="text-sm text-[#6b6960]">Connectez-vous pour accéder au tableau de bord</p>
        </div>

        {{-- Card --}}
        <div class="card rounded-2xl p-8">

            {{-- Erreurs --}}
            @if ($errors->any())
                <div class="alert-error rounded-lg px-4 py-3 mb-6 text-sm">
                    <p class="font-medium mb-1">Identifiants incorrects</p>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="label-tag block mb-2">Adresse email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="admin@example.com"
                        required
                        autocomplete="email"
                        class="input-field w-full rounded-lg px-4 py-3 text-sm text-[#1e1c16] placeholder-[#b0ae a7]"
                    >
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label for="password" class="label-tag block mb-2">Mot de passe</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                            class="input-field w-full rounded-lg px-4 py-3 text-sm text-[#1e1c16] pr-11"
                        >
                        <button type="button" onclick="togglePassword('password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9b9890] hover:text-[#1e1c16] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 rounded border-[#dddbd3] text-[#1e1c16] cursor-pointer">
                    <label for="remember" class="text-sm text-[#6b6960] cursor-pointer select-none">
                        Rester connecté
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full rounded-lg py-3 text-sm font-medium mt-2">
                    Se connecter
                </button>
            </form>

            <div class="divider my-6"></div>
            <p class="text-center text-sm text-[#6b6960]">
                Vous n'avez pas de compte ? Contactez l'administrateur.
            </p>
        </div>

        <p class="text-center text-xs text-[#b0aea7] mt-6">
            Accès réservé aux administrateurs autorisés
        </p>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.querySelector('svg').style.opacity = isPassword ? '0.4' : '1';
        }
    </script>
</body>
</html>
