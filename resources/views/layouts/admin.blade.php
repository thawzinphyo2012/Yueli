<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <script>
        (function () {
            var saved = localStorage.getItem('yueli-admin-theme');
            var theme = saved === 'dark' || saved === 'light'
                ? saved
                : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Yueli Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html[data-theme="light"] {
            --ink: #f6eef4;
            --graphite: #ffffff;
            --slate: #f8eef5;
            --edge: #ead8e4;
            --mist: #7d6876;
            --paper: #24131f;
            --accent: #e23d86;
            --danger: #c23b4a;
            --ok: #1b8a55;
            --shadow: rgba(176, 72, 122, 0.28);
            --sheen: rgba(255, 255, 255, 0.92);
            --stage-a: #fff8fc;
            --stage-b: #f4cfe2;
            --stage-c: #efe4ff;
        }
        html[data-theme="dark"] {
            --ink: #110e16;
            --graphite: #1c1724;
            --slate: #2a2436;
            --edge: #3d344c;
            --mist: #b8a8c0;
            --paper: #f8f2f6;
            --accent: #fe70a3;
            --danger: #ff8088;
            --ok: #6dcea0;
            --shadow: rgba(0, 0, 0, 0.55);
            --sheen: rgba(255, 255, 255, 0.08);
            --stage-a: #16111e;
            --stage-b: #3a1630;
            --stage-c: #1a1430;
        }
        html { font-size: 14.5px; }
        body { font-family: 'Syne', system-ui, sans-serif; }
        .admin-stage {
            background:
                radial-gradient(900px 420px at 12% -10%, color-mix(in srgb, var(--accent) 28%, transparent), transparent 60%),
                radial-gradient(700px 380px at 100% 0%, color-mix(in srgb, var(--stage-c) 80%, transparent), transparent 55%),
                linear-gradient(165deg, var(--stage-a), var(--stage-b) 48%, var(--ink));
        }
        .admin-sidebar {
            background: linear-gradient(180deg, color-mix(in srgb, var(--graphite) 78%, white), var(--graphite));
            box-shadow:
                inset 1px 1px 0 var(--sheen),
                16px 0 36px -22px var(--shadow);
        }
        .admin-topbar {
            background: color-mix(in srgb, var(--graphite) 86%, transparent);
            backdrop-filter: blur(14px);
            box-shadow: 0 10px 24px -18px var(--shadow), inset 0 1px 0 var(--sheen);
        }
        .admin-shell [class*="bg-[var(--graphite)]"] {
            background: linear-gradient(160deg, color-mix(in srgb, var(--graphite) 82%, white), var(--graphite)) !important;
            border-color: color-mix(in srgb, var(--edge) 80%, white) !important;
            border-radius: 1.15rem !important;
            box-shadow:
                inset 0 1px 0 var(--sheen),
                0 18px 0 -14px color-mix(in srgb, var(--accent) 18%, transparent),
                0 22px 36px -22px var(--shadow);
            transform: translateZ(0);
        }
        .admin-shell [class*="bg-[var(--graphite)]"]:hover {
            transform: translateY(-2px);
        }
        .font-display { font-family: 'Syne', system-ui, sans-serif; }
        .admin-input {
            width: 100%;
            background: color-mix(in srgb, var(--ink) 72%, var(--graphite));
            border: 1px solid var(--edge);
            color: var(--paper);
            border-radius: 0.75rem;
            padding: 0.55rem 0.8rem;
            font-size: 0.875rem;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.08), inset 0 1px 0 var(--sheen);
        }
        .admin-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.08), 0 0 0 3px color-mix(in srgb, var(--accent) 28%, transparent);
        }
        .admin-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--mist);
            margin-bottom: 0.375rem;
        }
        .admin-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(180deg, color-mix(in srgb, var(--accent) 78%, white), var(--accent));
            color: #fff;
            font-weight: 700;
            font-size: 0.8125rem;
            padding: 0.55rem 1rem;
            border-radius: 0.85rem;
            border: none;
            cursor: pointer;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.45), 0 8px 0 -4px color-mix(in srgb, var(--accent) 55%, #5a1030), 0 14px 22px -12px var(--shadow);
        }
        .admin-btn:hover { transform: translateY(-1px); }
        .admin-btn:active { transform: translateY(1px); box-shadow: inset 0 2px 4px rgba(0,0,0,0.15); }
        .admin-btn-ghost {
            background: transparent;
            color: var(--mist);
            border: 1px solid var(--edge);
        }
        .admin-btn-ghost:hover { color: var(--paper); border-color: var(--mist); }
        .admin-btn-danger {
            background: transparent;
            color: var(--danger);
            border: 1px solid var(--danger);
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }
        .admin-table th {
            text-align: left;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--mist);
            padding: 0.625rem 0.75rem;
            border-bottom: 1px solid var(--edge);
            white-space: nowrap;
        }
        .admin-table td {
            padding: 0.625rem 0.75rem;
            border-bottom: 1px solid var(--edge);
            color: var(--paper);
            vertical-align: middle;
        }
        .admin-table tr:hover td { background: rgba(255,255,255,0.02); }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.9rem;
            border-radius: 0.9rem;
            color: var(--mist);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
        }
        .nav-link:hover { background: var(--slate); color: var(--paper); }
        .nav-link.active {
            background: linear-gradient(180deg, color-mix(in srgb, var(--accent) 18%, var(--slate)), var(--slate));
            color: var(--accent);
            box-shadow: inset 0 1px 0 var(--sheen), 0 10px 16px -12px var(--shadow);
        }
        .theme-toggle {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.8rem;
            border: 1px solid var(--edge);
            background: linear-gradient(180deg, color-mix(in srgb, var(--graphite) 70%, white), var(--graphite));
            color: var(--paper);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: inset 0 1px 0 var(--sheen), 0 8px 14px -10px var(--shadow);
        }
        [x-cloak] { display: none !important; }
        .nav-link i, .nav-link [data-lucide] { width: 1rem; height: 1rem; flex-shrink: 0; }
    </style>
</head>
<body
    class="admin-stage text-[var(--paper)] antialiased"
    x-data="{
        sidebarOpen: false,
        theme: document.documentElement.getAttribute('data-theme') || 'light',
        toggleTheme() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', this.theme);
            localStorage.setItem('yueli-admin-theme', this.theme);
        }
    }"
>
    <div class="admin-shell min-h-screen flex">
        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-30 bg-black/60 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        {{-- Sidebar --}}
        <aside
            class="admin-sidebar fixed inset-y-0 left-0 z-40 w-64 border-r border-[var(--edge)] flex flex-col transform transition-transform duration-200 lg:translate-x-0 lg:static lg:m-3 lg:rounded-[1.4rem] lg:border"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="h-14 px-5 flex items-center border-b border-[var(--edge)] shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-lg font-extrabold tracking-tight text-[var(--paper)]">
                    Yueli <span class="text-[var(--accent)]">Admin</span>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto p-3 space-y-0.5">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i> Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i data-lucide="shirt"></i> Products
                </a>
                <a href="{{ route('admin.collections.index') }}" class="nav-link {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}">
                    <i data-lucide="layers"></i> Collections
                </a>
                <a href="{{ route('admin.lookbooks.index') }}" class="nav-link {{ request()->routeIs('admin.lookbooks.*') ? 'active' : '' }}">
                    <i data-lucide="camera"></i> Lookbooks
                </a>
                <a href="{{ route('admin.portfolio.index') }}" class="nav-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">
                    <i data-lucide="briefcase"></i> Portfolio
                </a>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i data-lucide="shopping-bag"></i> Orders
                </a>
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i> Customers
                </a>
                <a href="{{ route('admin.content.index') }}" class="nav-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                    <i data-lucide="file-text"></i> Content
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i data-lucide="settings"></i> Settings
                </a>
            </nav>

            <div class="p-3 border-t border-[var(--edge)] text-xs text-[var(--mist)]">
                Yueli Studio
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="admin-topbar h-16 mx-3 mt-3 rounded-[1.2rem] border border-[var(--edge)] flex items-center justify-between px-4 lg:px-6 shrink-0">
                <button
                    type="button"
                    class="lg:hidden p-2 rounded text-[var(--mist)] hover:text-[var(--paper)] hover:bg-[var(--slate)]"
                    @click="sidebarOpen = !sidebarOpen"
                    aria-label="Toggle sidebar"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <div class="hidden lg:block text-sm text-[var(--mist)]">
                    @yield('heading', 'Admin')
                </div>

                <div class="flex items-center gap-3 ml-auto">
                    <button type="button" class="theme-toggle" @click="toggleTheme()" :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'">
                        <span x-show="theme === 'dark'" x-cloak class="inline-flex"><i data-lucide="sun" class="w-4 h-4"></i></span>
                        <span x-show="theme !== 'dark'" class="inline-flex"><i data-lucide="moon" class="w-4 h-4"></i></span>
                    </button>
                    <a href="{{ route('home') }}" target="_blank" class="text-xs text-[var(--mist)] hover:text-[var(--accent)] inline-flex items-center gap-1.5">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Storefront
                    </a>
                    <span class="text-sm text-[var(--paper)] truncate max-w-[10rem]">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-[var(--mist)] hover:text-[var(--danger)] inline-flex items-center gap-1">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-6 overflow-x-auto">
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 rounded border border-[var(--ok)]/40 bg-[var(--ok)]/10 text-[var(--ok)] text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 px-4 py-3 rounded border border-[var(--danger)]/40 bg-[var(--danger)]/10 text-[var(--danger)] text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 rounded border border-[var(--danger)]/40 bg-[var(--danger)]/10 text-[var(--danger)] text-sm">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
