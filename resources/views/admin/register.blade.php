<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .brand { font-family: 'DM Serif Display', serif; }

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
        .input-field.error {
            border-color: #f87171;
        }

        .btn-primary {
            background: #1e1c16;
            color: #fff;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-primary:hover { background: #3a3828; }
        .btn-primary:active { transform: scale(0.99); }

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

        .strength-bar {
            height: 3px;
            border-radius: 2px;
            background: #e2e0d9;
            overflow: hidden;
            transition: all 0.3s;
        }
        .strength-fill {
            height: 100%;
            border-radius: 2px;
            transition: width 0.3s, background 0.3s;
        }

        .field-error {
            font-size: 0.75rem;
            color: #dc2626;
            margin-top: 4px;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 py-12">

    <div class="w-full max-w-md fade-in">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#1e1c16] mb-5">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <h1 class="brand text-3xl text-[#1e1c16] mb-1">Créer un compte</h1>
            <p class="text-sm text-[#6b6960]">Remplissez les informations pour créer un compte administrateur</p>
        </div>

        {{-- Card --}}
        <div class="card rounded-2xl p-8">

            {{-- Erreurs globales --}}
            @if ($errors->any())
                <div class="alert-error rounded-lg px-4 py-3 mb-6 text-sm">
                    <p class="font-medium mb-1">Veuillez corriger les erreurs suivantes :</p>
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.register.submit') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nom --}}
                <div>
                    <label for="name" class="label-tag block mb-2">Nom complet</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Jean Dupont"
                        required
                        autocomplete="name"
                        class="input-field w-full rounded-lg px-4 py-3 text-sm text-[#1e1c16] {{ $errors->has('name') ? 'error' : '' }}"
                    >
                    @error('name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

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
                        class="input-field w-full rounded-lg px-4 py-3 text-sm text-[#1e1c16] {{ $errors->has('email') ? 'error' : '' }}"
                    >
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
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
                            autocomplete="new-password"
                            oninput="checkStrength(this.value)"
                            class="input-field w-full rounded-lg px-4 py-3 text-sm text-[#1e1c16] pr-11 {{ $errors->has('password') ? 'error' : '' }}"
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

                    {{-- Barre de force --}}
                    <div class="mt-2 space-y-1">
                        <div class="flex gap-1">
                            <div class="strength-bar flex-1"><div id="bar1" class="strength-fill w-0"></div></div>
                            <div class="strength-bar flex-1"><div id="bar2" class="strength-fill w-0"></div></div>
                            <div class="strength-bar flex-1"><div id="bar3" class="strength-fill w-0"></div></div>
                            <div class="strength-bar flex-1"><div id="bar4" class="strength-fill w-0"></div></div>
                        </div>
                        <p id="strength-label" class="text-xs text-[#9b9890]"></p>
                    </div>

                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation mot de passe --}}
                <div>
                    <label for="password_confirmation" class="label-tag block mb-2">Confirmer le mot de passe</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="••••••••"
                            required
                            autocomplete="new-password"
                            class="input-field w-full rounded-lg px-4 py-3 text-sm text-[#1e1c16] pr-11"
                        >
                        <button type="button" onclick="togglePassword('password_confirmation', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9b9890] hover:text-[#1e1c16] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Clé secrète admin --}}
                <div>
                    <label for="admin_key" class="label-tag block mb-2">Clé d'accès administrateur</label>
                    <input
                        type="password"
                        name="admin_key"
                        id="admin_key"
                        placeholder="Clé fournie par votre responsable"
                        required
                        class="input-field w-full rounded-lg px-4 py-3 text-sm text-[#1e1c16] {{ $errors->has('admin_key') ? 'error' : '' }}"
                    >
                    @error('admin_key')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-[#9b9890] mt-1">Une clé secrète est requise pour créer un compte administrateur.</p>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full rounded-lg py-3 text-sm font-medium mt-2">
                    Créer le compte
                </button>
            </form>

            <div class="divider my-6"></div>

            <p class="text-center text-sm text-[#6b6960]">
                Déjà un compte ?
                <a href="{{ route('admin.login') }}" class="text-[#1e1c16] font-medium underline underline-offset-2 hover:text-[#3a3828]">
                    Se connecter
                </a>
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

        function checkStrength(value) {
            const bars = [
                document.getElementById('bar1'),
                document.getElementById('bar2'),
                document.getElementById('bar3'),
                document.getElementById('bar4'),
            ];
            const label = document.getElementById('strength-label');

            const checks = [
                value.length >= 8,
                /[A-Z]/.test(value),
                /[0-9]/.test(value),
                /[^A-Za-z0-9]/.test(value),
            ];
            const score = checks.filter(Boolean).length;

            const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
            const labels = ['Très faible', 'Faible', 'Moyen', 'Fort'];

            bars.forEach((bar, i) => {
                if (i < score) {
                    bar.style.width = '100%';
                    bar.style.background = colors[score - 1];
                } else {
                    bar.style.width = '0%';
                }
            });

            label.textContent = value.length > 0 ? labels[score - 1] ?? '' : '';
            label.style.color = value.length > 0 ? colors[score - 1] : '#9b9890';
        }
    </script>
</body>
</html>
