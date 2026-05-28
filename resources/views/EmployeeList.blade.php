{{-- resources/views/employees/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employees — Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@600;700;800&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0f1117;
            --surface:   #181c27;
            --card:      #1e2232;
            --border:    #2a2f45;
            --accent:    #5b6af0;
            --accent2:   #9b59b6;
            --green:     #22c55e;
            --amber:     #f59e0b;
            --red:       #ef4444;
            --text:      #e0e0e7;
            --muted:     #4c4e53;
            --radius:    12px;
        }

        body {
            background: rgba(233, 233, 218, 0.23);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: black;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 28px 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 0 24px 28px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo span {
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-nav { padding: 20px 12px; flex: 1; }

        .nav-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--muted);
            padding: 0 12px;
            margin-bottom: 8px;
            margin-top: 16px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background .15s, color .15s;
            cursor: pointer;
        }

        .nav-item:hover { background: var(--card); color: var(--text); }
        .nav-item.active { background: rgba(91,106,240,.15); color: var(--accent); }

        .nav-icon { width: 18px; text-align: center; }

        /* ── Main ── */
        .main {
            flex: 1;
            min-width: 0;
            padding: 36px 40px;
            overflow-y: auto;
        }

        /* ── Page header ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .page-sub { color: var(--muted); font-size: 0.875rem; margin-top: 4px; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: opacity .15s, transform .1s;
            text-decoration: none;
        }
        .btn:active { transform: scale(.97); }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { opacity: .88; }
        .btn-ghost { background: var(--card); color: var(--text); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--border); }
        .btn-danger { background: rgba(239,68,68,.15); color: var(--red); border: 1px solid rgba(239,68,68,.25); }
        .btn-danger:hover { background: rgba(239,68,68,.25); }
        .btn-sm { padding: 6px 14px; font-size: 0.8rem; }

        /* ── Stat cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: black;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }
        .stat-card.c-total::before  { background: white; }
        .stat-card.c-active::before { background: var(--green); }
        .stat-card.c-leave::before  { background: var(--amber); }
        .stat-card.c-inactive::before { background: var(--red); }

        .stat-label { font-size: 0.75rem; color: white; font-weight: 500; text-transform: uppercase; letter-spacing: .8px; }
        .stat-value { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 700; margin-top: 6px; }
        .stat-card.c-active .stat-value  { color: var(--green); }
        .stat-card.c-leave .stat-value   { color: var(--amber); }
        .stat-card.c-inactive .stat-value { color: var(--red); }

        /* ── Filters ── */
        .filters-bar {
            background: black;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .search-wrap { position: relative; flex: 1; min-width: 200px; }
        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            pointer-events: none;
        }

        input[type="text"],
        select {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            padding: 9px 14px;
            outline: none;
            transition: border-color .15s;
            width: 100%;
        }
        input[type="text"] { padding-left: 38px; }
        input[type="text"]:focus,
        select:focus { border-color: var(--accent); }
        select option { background: var(--surface); }

        .filter-group { display: flex; gap: 10px; }

        /* ── Flash message ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 8px;
            background: rgba(34,197,94,.1);
            border: 1px solid rgba(34,197,94,.25);
            color: var(--green);
            font-size: 0.875rem;
            margin-bottom: 20px;
        }

        /* ── Table ── */
        .table-wrap {
            background: black;
            border: 1px solid black;
            border-radius: var(--radius);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }

        thead { background: black; }

        th {
            padding: 13px 18px;
            text-align: left;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: white;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        th a {
            color: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color .15s;
        }
        th a:hover { color: var(--text); }
        th a.sorted { color: var(--accent); }

        td {
            padding: 14px 18px;
            font-size: 0.875rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,.02); }

        /* employee cell */
        .emp-cell { display: flex; align-items: center; gap: 12px; }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .emp-name { font-weight: 600; }
        .emp-email { font-size: 0.78rem; color: var(--muted); margin-top: 1px; }

        /* badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-active   { background: rgba(34,197,94,.15);  color: var(--green); }
        .badge-inactive { background: rgba(239,68,68,.15);  color: var(--red); }
        .badge-leave    { background: rgba(245,158,11,.15); color: var(--amber); }

        .dept-tag {
            display: inline-block;
            background: rgba(91,106,240,.12);
            color:white;
            border-radius: 6px;
            padding: 3px 9px;
            font-size: 0.76rem;
            font-weight: 500;
        }

        /* actions */
        .actions { display: flex; gap: 8px; }

        /* empty state */
        .empty-state {
            text-align: center;
            padding: 60px 24px;
            color: var(--muted);
        }
        .empty-state svg { margin-bottom: 12px; opacity: .35; }
        .empty-state p { font-size: 0.9rem; }

        /* pagination */
        .pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            font-size: 0.8rem;
            color: var(--muted);
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination { display: flex; gap: 4px; }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border-radius: 6px;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
            text-decoration: none;
            font-size: 0.8rem;
            transition: background .15s, border-color .15s;
        }
        .page-link:hover        { background: var(--border); }
        .page-link.active       { background: var(--accent); border-color: var(--accent); color: #fff; }
        .page-link.disabled     { opacity: .35; pointer-events: none; }

        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { padding: 24px 20px; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

{{-- ── Sidebar ── --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <span>staffflow
</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main</div>
        <a class="nav-item" href="{{ route('dashboard') }}">
            <span class="nav-icon">⊞</span> Dashboard
        </a>
        <a class="nav-item active" href="{{ route('employees.index') }}">
            <span class="nav-icon">👥</span> Employees
        </a>




    </nav>
</aside>

{{-- ── Main content ── --}}
<main class="main">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Employees</h1>
            <p class="page-sub">Manage your workforce — {{ $stats['total'] }} total records</p>
        </div>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Employee
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="flash">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card c-total">
            <div class="stat-label">Total Employees</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card c-active">
            <div class="stat-label">Active</div>
            <div class="stat-value">{{ $stats['active'] }}</div>
        </div>
        <div class="stat-card c-leave">
            <div class="stat-label">On Leave</div>
            <div class="stat-value">{{ $stats['on_leave'] }}</div>
        </div>
        <div class="stat-card c-inactive">
            <div class="stat-label">Inactive</div>
            <div class="stat-value">{{ $stats['inactive'] }}</div>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('employees.index') }}">
        <div class="filters-bar">
            {{-- Search --}}
            <div class="search-wrap">
                <span class="search-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </span>
                <input type="text" name="search" placeholder="Search by name, email or position…"
                       value="{{ request('search') }}" />
            </div>

            <div class="filter-group">
                {{-- Department filter --}}
                <select name="department" style="width:160px">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" @selected(request('department') === $dept)>{{ $dept }}</option>
                    @endforeach
                </select>

                {{-- Status filter --}}
                <select name="status" style="width:140px">
                    <option value="">All Statuses</option>
                    <option value="active"   @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                    <option value="on_leave" @selected(request('status') === 'on_leave')>On Leave</option>
                </select>

                <button type="submit" class="btn btn-ghost">Filter</button>

                @if(request()->hasAny(['search','department','status']))
                    <a href="{{ route('employees.index') }}" class="btn btn-ghost">Clear</a>
                @endif
            </div>
        </div>

        {{-- Pass sort state through filter submissions --}}
        <input type="hidden" name="sort_by"  value="{{ request('sort_by',  'name') }}" />
        <input type="hidden" name="sort_dir" value="{{ request('sort_dir', 'asc') }}" />
    </form>

    {{-- Table --}}
    <div class="table-wrap">
        @if($employees->isEmpty())
            <div class="empty-state">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <p>No employees found matching your criteria.</p>
            </div>
        @else
            @php
                $sortBy  = request('sort_by',  'name');
                $sortDir = request('sort_dir', 'asc');
                $params  = request()->only(['search','department','status']);
                function sortLink(string $col, string $current, string $dir, array $params): string {
                    $newDir = ($current === $col && $dir === 'asc') ? 'desc' : 'asc';
                    $arrow  = ($current === $col) ? ($dir === 'asc' ? ' ↑' : ' ↓') : ' ↕';
                    $qs     = http_build_query(array_merge($params, ['sort_by' => $col, 'sort_dir' => $newDir]));
                    return "?" . $qs . $arrow;
                }
            @endphp

            <table>
                <thead>
                    <tr>
                        <th>
                            <a href="{{ sortLink('name', $sortBy, $sortDir, $params) }}"
                               class="{{ $sortBy === 'name' ? 'sorted' : '' }}">Employee</a>
                        </th>
                        <th>
                            <a href="{{ sortLink('department', $sortBy, $sortDir, $params) }}"
                               class="{{ $sortBy === 'department' ? 'sorted' : '' }}">Department</a>
                        </th>
                        <th>
                            <a href="{{ sortLink('position', $sortBy, $sortDir, $params) }}"
                               class="{{ $sortBy === 'position' ? 'sorted' : '' }}">Position</a>
                        </th>
                        <th>
                            <a href="{{ sortLink('hired_at', $sortBy, $sortDir, $params) }}"
                               class="{{ $sortBy === 'hired_at' ? 'sorted' : '' }}">Hired Date</a>
                        </th>
                        <th>
                            <a href="{{ sortLink('status', $sortBy, $sortDir, $params) }}"
                               class="{{ $sortBy === 'status' ? 'sorted' : '' }}">Status</a>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>
                                <div class="emp-cell">
                                    @if($employee->avatar)
                                        <img src="{{ asset('storage/' . $employee->avatar) }}"
                                             class="avatar" alt="{{ $employee->name }}" />
                                    @else
                                        <div class="avatar">{{ $employee->getInitials() }}</div>
                                    @endif
                                    <div>
                                        <div class="emp-name">{{ $employee->name }}</div>
                                        <div class="emp-email">{{ $employee->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="dept-tag">{{ $employee->department }}</span></td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->hired_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge {{ $employee->getStatusBadgeClass() }}">
                                    {{ $employee->getStatusLabel() }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('employees.show', $employee) }}" class="btn btn-ghost btn-sm">View</a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-ghost btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                                          onsubmit="return confirm('Remove {{ addslashes($employee->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="pagination-wrap">
                <span>
                    Showing {{ $employees->firstItem() }}–{{ $employees->lastItem() }}
                    of {{ $employees->total() }} employees
                </span>

                <div class="pagination">
                    {{-- Previous --}}
                    @if($employees->onFirstPage())
                        <span class="page-link disabled">‹</span>
                    @else
                        <a class="page-link" href="{{ $employees->previousPageUrl() }}">‹</a>
                    @endif

                    {{-- Pages --}}
                    @foreach($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                        @if($page == $employees->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($employees->hasMorePages())
                        <a class="page-link" href="{{ $employees->nextPageUrl() }}">›</a>
                    @else
                        <span class="page-link disabled">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</main>
</body>
</html>