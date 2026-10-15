<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Yueli Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --ink: #0c0d0f;
            --graphite: #16181c;
            --slate: #1e2228;
            --edge: #2a2f38;
            --mist: #9aa3b2;
            --paper: #e8eaed;
            --accent: #c8a96e;
            --danger: #c45c5c;
            --ok: #5a9a6e;
        }
        body { font-family: 'Syne', system-ui, sans-serif; }
        .font-display { font-family: 'Syne', system-ui, sans-serif; }
        .admin-input {
            width: 100%;
            background: var(--ink);
            border: 1px solid var(--edge);
            color: var(--paper);
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
        .admin-input:focus {
            outline: none;
            border-color: var(--accent);
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
            background: var(--accent);
            color: var(--ink);
            font-weight: 700;
            font-size: 0.8125rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }
        .admin-btn:hover { filter: brightness(1.08); }
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
            padding: 0.625rem 0.875rem;
            border-radius: 0.375rem;
            color: var(--mist);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
        }
        .nav-link:hover { background: var(--slate); color: var(--paper); }
        .nav-link.active { background: var(--slate); color: var(--accent); }
        .nav-link i, .nav-link [data-lucide] { width: 1rem; height: 1rem; flex-shrink: 0; }
    </style>
</head>
<body
    class="bg-[var(--ink)] text-[var(--paper)] antialiased"
    x-data="{ sidebarOpen: false }"
>
    <div class="min-h-screen flex">
        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-30 bg-black/60 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 bg-[var(--graphite)] border-r border-[var(--edge)] flex flex-col transform transition-transform duration-200 lg:translate-x-0 lg:static"
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
            <header class="h-14 bg-[var(--graphite)] border-b border-[var(--edge)] flex items-center justify-between px-4 lg:px-6 shrink-0">
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
