<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso — FerroStock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,500;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: #e8e0d4;
            position: relative;
            overflow-x: hidden;
        }

        /* ── PEGBOARD background ── */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle, #c4b9a8 1.2px, transparent 1.2px);
            background-size: 26px 26px;
            opacity: .45;
            pointer-events: none;
            z-index: 0;
        }

        /* ── CAUTION TAPE top strip ── */
        .tape {
            position: fixed; top: 0; left: 0; right: 0;
            height: 7px; z-index: 100;
            background: repeating-linear-gradient(
                -55deg,
                #d97706, #d97706 10px,
                #292524 10px, #292524 20px
            );
        }

        /* ── PAGE LAYOUT ── */
        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── LEFT: IDENTITY ── */
        .side-brand {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 52px 60px 64px;
            position: relative;
        }

        /* Oversized watermark letter */
        .watermark {
            position: absolute;
            right: -30px;
            bottom: -40px;
            font-family: 'Space Mono', monospace;
            font-size: 340px;
            font-weight: 700;
            line-height: 1;
            color: rgba(0,0,0,.04);
            pointer-events: none;
            user-select: none;
        }

        /* Stamp-style logo */
        .stamp {
            display: inline-block;
            border: 3px solid #292524;
            border-radius: 3px;
            padding: 8px 16px 7px;
            transform: rotate(-2.5deg);
            margin-bottom: 38px;
            position: relative;
        }
        .stamp::after {
            content: '';
            position: absolute; inset: 3px;
            border: 1px solid #292524;
            border-radius: 1px;
            pointer-events: none;
        }
        .stamp-text {
            font-family: 'Space Mono', monospace;
            font-size: 22px;
            font-weight: 700;
            color: #292524;
            letter-spacing: 3px;
            text-transform: uppercase;
            line-height: 1;
        }
        .stamp-text span { color: #b45309; }

        .tagline {
            font-size: 13px;
            color: #78716c;
            letter-spacing: .3px;
            margin-bottom: 48px;
            line-height: 1.7;
            max-width: 340px;
            border-left: 3px solid #d97706;
            padding-left: 16px;
        }

        /* Data panel: looks like spec sheet */
        .spec-sheet {
            background: #faf8f5;
            border: 1px solid #d6cfc4;
            border-left: 4px solid #292524;
            padding: 0;
            max-width: 320px;
        }
        .spec-title {
            font-family: 'Space Mono', monospace;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #a8a29e;
            padding: 10px 16px;
            border-bottom: 1px solid #e7e0d6;
            background: #f5f0ea;
        }
        .spec-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 16px;
            font-size: 12px;
            border-bottom: 1px dashed #e7e0d6;
        }
        .spec-row:last-child { border-bottom: none; }
        .spec-key { color: #78716c; font-weight: 500; }
        .spec-val { color: #292524; font-weight: 700; font-family: 'Space Mono', monospace; font-size: 11px; }
        .spec-val.active { color: #15803d; }

        /* Footer on brand side */
        .brand-foot {
            position: absolute;
            bottom: 32px;
            left: 64px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-foot-line {
            width: 28px;
            height: 2px;
            background: #d97706;
        }
        .brand-foot-txt {
            font-size: 10px;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            color: #a8a29e;
            font-weight: 500;
        }

        /* ── RIGHT: LOGIN ── */
        .side-login {
            background: #292524;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
        }

        /* Corner brackets (engineering drawing marks) */
        .side-login::before,
        .side-login::after {
            content: '';
            position: absolute;
            width: 32px;
            height: 32px;
            border-color: #d97706;
            border-style: solid;
            pointer-events: none;
        }
        .side-login::before {
            top: 28px; left: 28px;
            border-width: 2px 0 0 2px;
        }
        .side-login::after {
            bottom: 28px; right: 28px;
            border-width: 0 2px 2px 0;
        }

        /* Extra two corners via child pseudo */
        .corner-tr, .corner-bl {
            position: absolute;
            width: 32px;
            height: 32px;
            border-color: rgba(215,151,6,.25);
            border-style: solid;
            pointer-events: none;
        }
        .corner-tr { top: 28px; right: 28px; border-width: 2px 2px 0 0; }
        .corner-bl { bottom: 28px; left: 28px; border-width: 0 0 2px 2px; }

        /* Diagonal mesh on login side */
        .side-login-bg {
            position: absolute; inset: 0;
            background-image:
                repeating-linear-gradient(
                    135deg,
                    transparent,
                    transparent 40px,
                    rgba(255,255,255,.012) 40px,
                    rgba(255,255,255,.012) 41px
                );
            pointer-events: none;
        }

        .login-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 370px;
            z-index: 10;
        }

        /* Hex bolt decorative element */
        .hex-bolt {
            width: 42px; height: 42px;
            margin-bottom: 26px;
            position: relative;
        }
        .hex-bolt svg {
            width: 100%;
            height: 100%;
        }

        .login-title {
            font-size: 20px;
            font-weight: 700;
            color: #faf8f5;
            letter-spacing: -.3px;
            margin-bottom: 3px;
        }
        .login-sub {
            font-size: 12.5px;
            color: #78716c;
            margin-bottom: 30px;
        }

        /* Error */
        .alert-err {
            background: rgba(220,38,38,.1);
            border: 1px solid rgba(220,38,38,.25);
            border-left: 3px solid #dc2626;
            color: #fca5a5;
            font-size: 12.5px;
            padding: 10px 14px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .alert-err-icon {
            width: 16px; height: 16px;
            background: #dc2626;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 10px;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }

        /* Form */
        .fg { margin-bottom: 20px; }
        .fg-label {
            display: block;
            margin-bottom: 8px;
            font-size: 11px;
            font-family: var(--font-mono);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #d1d5db; /* Increased brightness from #a8a29e */
        }
        .fg-label-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px; height: 16px;
            background: #d97706;
            color: #292524;
            font-size: 9px;
            font-weight: 700;
            font-family: 'Space Mono', monospace;
            line-height: 1;
        }

        .fg-field { position: relative; }

        .fg-input {
            width: 100%;
            padding: 13px 14px 13px 44px;
            background: #1c1917;
            border: 1.5px solid #6b6661; /* Significantly increased brightness from #44403c */
            border-radius: 2px;
            color: #faf8f5;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .25s, box-shadow .25s;
        }
        .fg-input::placeholder {
            color: #57534e;
            font-size: 13px;
        }
        .fg-input:focus {
            border-color: #d97706;
            box-shadow: 0 0 0 3px rgba(217,119,6,.15);
        }

        .fg-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            display: flex;
        }
        .fg-icon svg {
            width: 16px; height: 16px;
            stroke: #78716c;
            fill: none;
            stroke-width: 1.75;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: stroke .25s;
        }
        .fg-field:focus-within .fg-icon svg {
            stroke: #d97706;
        }

        .btn-toggle-pw {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; display: flex;
            padding: 3px;
        }
        .btn-toggle-pw svg {
            width: 15px; height: 15px;
            stroke: #57534e;
            fill: none;
            stroke-width: 1.75;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: stroke .2s;
        }
        .btn-toggle-pw:hover svg { stroke: #d97706; }

        /* Checkbox */
        .opt-row {
            display: flex;
            align-items: center;
            margin-bottom: 26px;
        }
        .chk {
            display: flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
        }
        .chk input {
            appearance: none;
            width: 14px; height: 14px;
            border: 1.5px solid #57534e;
            border-radius: 1px;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            flex-shrink: 0;
        }
        .chk input:checked {
            background: #d97706;
            border-color: #d97706;
        }
        .chk input:checked::after {
            content: '';
            position: absolute;
            left: 2px; top: 0;
            width: 7px; height: 4px;
            border-left: 1.5px solid #292524;
            border-bottom: 1.5px solid #292524;
            transform: rotate(-45deg);
        }
        .chk-txt { font-size: 12px; color: #78716c; }

        /* Submit button — heavy duty style */
        .btn-go {
            width: 100%;
            padding: 14px;
            background: #d97706;
            border: none;
            border-radius: 2px;
            color: #292524;
            font-family: 'Space Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            transition: background .2s, transform .1s;
        }
        .btn-go::before {
            content: '';
            position: absolute;
            left: 0; top: 0;
            width: 4px;
            height: 100%;
            background: #92400e;
        }
        .btn-go:hover {
            background: #b45309;
        }
        .btn-go:active {
            transform: translateY(1px);
        }

        /* Divider */
        .login-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 28px;
        }
        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #44403c;
        }
        .login-divider-txt {
            font-size: 10px;
            color: #57534e;
            letter-spacing: 1px;
            font-family: 'Space Mono', monospace;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* Footer */
        .login-foot {
            margin-top: 14px;
            text-align: center;
            font-size: 11.5px;
            color: #57534e;
            line-height: 1.6;
        }
        .login-foot strong {
            color: #d97706;
            font-weight: 500;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 860px) {
            .page {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
            }
            .side-brand {
                padding: 40px 28px 32px;
            }
            .watermark { display: none; }
            .spec-sheet { display: none; }
            .brand-foot { display: none; }
            .side-login { padding: 32px 20px; }
            .side-login::before,
            .side-login::after,
            .corner-tr, .corner-bl { display: none; }
        }
    </style>
</head>
<body>

    <div class="tape"></div>

    <div class="page">

        <!-- ── LEFT: BRAND IDENTITY ── -->
        <div class="side-brand">
            <span class="watermark">F</span>

            <div class="stamp">
                <span class="stamp-text">FERRO<span>STOCK</span></span>
            </div>

            <p class="tagline">
                Sistema de gestión de inventario<br>
                diseñado para ferreterías,<br>
                distribuidoras y almacenes industriales.
            </p>

            <div class="spec-sheet">
                <div class="spec-title">Ficha del Sistema</div>
                <div class="spec-row">
                    <span class="spec-key">Módulo</span>
                    <span class="spec-val">Inventario General</span>
                </div>
                <div class="spec-row">
                    <span class="spec-key">Versión</span>
                    <span class="spec-val">2.1.0</span>
                </div>
                <div class="spec-row">
                    <span class="spec-key">Estado</span>
                    <span class="spec-val active">● Operativo</span>
                </div>
                <div class="spec-row">
                    <span class="spec-key">Últ. actualización</span>
                    <span class="spec-val"><?php echo date('d/m/Y') ?></span>
                </div>
            </div>

            <div class="brand-foot">
                <span class="brand-foot-line"></span>
                <span class="brand-foot-txt">&copy; <?php echo date('Y') ?> FerroStock</span>
            </div>
        </div>

        <!-- ── RIGHT: LOGIN ── -->
        <div class="side-login">
            <div class="side-login-bg"></div>
            <span class="corner-tr"></span>
            <span class="corner-bl"></span>

            <div class="login-card">

                <!-- Hex bolt icon -->
                <div class="hex-bolt">
                    <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="25,2 45,14 45,36 25,48 5,36 5,14" fill="none" stroke="#d97706" stroke-width="2"/>
                        <polygon points="25,12 35,18 35,32 25,38 15,32 15,18" fill="none" stroke="#d97706" stroke-width="1.2" opacity=".4"/>
                        <circle cx="25" cy="25" r="4" fill="#d97706"/>
                    </svg>
                </div>

                <h1 class="login-title">Acceso al Sistema</h1>
                <p class="login-sub">Ingresa tus credenciales autorizadas</p>

                <?php if (isset($_GET['error']) && $_GET['error'] === '1'): ?>
                <div class="alert-err" role="alert">
                    <span class="alert-err-icon">!</span>
                    Credenciales incorrectas. Verifica e intenta de nuevo.
                </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL ?>index.php?route=login" autocomplete="off">

                    <div class="fg">
                        <label class="fg-label" for="email">
                            <span class="fg-label-num">1</span>
                            Correo
                        </label>
                        <div class="fg-field">
                            <span class="fg-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="fg-input"
                                placeholder="usuario@ferreteria.com"
                                value="admin@ferrestock.com"
                                required
                                autocomplete="username"
                            >
                        </div>
                    </div>

                    <div class="fg">
                        <label class="fg-label" for="password">
                            <span class="fg-label-num">2</span>
                            Contraseña
                        </label>
                        <div class="fg-field">
                            <span class="fg-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="fg-input"
                                placeholder="••••••••"
                                value="admin123"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="btn-toggle-pw" onclick="togglePwd()" aria-label="Mostrar contraseña">
                                <svg id="eye-svg" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="opt-row">
                        <label class="chk">
                            <input type="checkbox" name="remember">
                            <span class="chk-txt">Mantener sesión activa</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-go">Ingresar &rarr;</button>

                </form>

                <div class="login-divider">
                    <span class="login-divider-txt">Acceso restringido</span>
                </div>
                <p class="login-foot">
                    ¿Sin acceso? Contacte al <strong>administrador</strong>.
                </p>

            </div>
        </div>

    </div>

    <script>
        function togglePwd() {
            const i = document.getElementById('password');
            const s = document.getElementById('eye-svg');
            if (i.type === 'password') {
                i.type = 'text';
                s.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                i.type = 'password';
                s.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>

</body>
</html>