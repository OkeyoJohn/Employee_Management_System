<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $employee->first_name }} {{ $employee->last_name }} — StaffFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=IBM+Plex+Mono:wght@400;500&family=Manrope:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:       #0e0c0a;
            --bg:        #f7f4f0;
            --paper:     #fdfcfa;
            --rule:      #e8e2d9;
            --accent:    #1a3a5c;
            --gold:      #b8924a;
            --gold-lt:   #f5edd8;
            --muted:     #8c8278;
            --label:     #4a4440;
            --danger:    #8b2020;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ─────────────────────────────────── */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: var(--ink);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
        }
        .sidebar-logo {
            padding: 32px 28px 28px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-logo span {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: #fff;
            letter-spacing: -0.3px;
        }
        .sidebar-logo span em { color: var(--gold); font-style: normal; }
        .sidebar-nav { padding: 24px 0; flex: 1; }
        .nav-sec { font-size: 0.58rem; letter-spacing: 0.16em; text-transform: uppercase; color: rgba(255,255,255,0.25); padding: 10px 28px 4px; font-weight: 600; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 28px;
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            font-size: 0.82rem; font-weight: 400;
            transition: all 0.15s;
        }
        .nav-item:hover { color: rgba(255,255,255,0.85); background: rgba(255,255,255,0.05); }
        .nav-item.active { color: #fff; background: rgba(255,255,255,0.08); border-right: 2px solid var(--gold); }
        .nav-item svg { width: 14px; height: 14px; flex-shrink: 0; }
        .sidebar-footer {
            padding: 20px 28px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .user-chip { display: flex; align-items: center; gap: 10px; }
        .u-avatar {
            width: 28px; height: 28px; border-radius: 5px;
            background: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif; font-size: 0.75rem; font-weight: 700;
            color: #fff;
        }
        .u-name { font-size: 0.75rem; color: rgba(255,255,255,0.5); }

        /* ── MAIN ────────────────────────────────────── */
        .main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }

        /* ── TOPBAR ──────────────────────────────────── */
        .topbar {
            height: 58px;
            background: var(--paper);
            border-bottom: 1px solid var(--rule);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px;
            position: sticky; top: 0; z-index: 50;
        }
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: var(--muted); }
        .breadcrumb a { color: var(--muted); text-decoration: none; transition: color 0.12s; }
        .breadcrumb a:hover { color: var(--ink); }
        .breadcrumb-sep { color: var(--rule); }
        .breadcrumb-current { color: var(--ink); font-weight: 600; }
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 7px 16px;
            border-radius: 5px;
            font-family: 'Manrope', sans-serif;
            font-size: 0.78rem; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: all 0.15s; border: none;
        }
        .btn svg { width: 13px; height: 13px; }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--rule);
            color: var(--muted);
        }
        .btn-outline:hover { border-color: var(--ink); color: var(--ink); }
        .btn-primary {
            background: var(--accent);
            color: #fff;
            border: 1px solid var(--accent);
            box-shadow: 0 2px 8px rgba(26,58,92,0.2);
        }
        .btn-primary:hover { background: #0f2540; box-shadow: 0 4px 16px rgba(26,58,92,0.3); }
        .btn-danger { background: transparent; border: 1px solid var(--rule); color: var(--danger); }
        .btn-danger:hover { background: #fff0f0; border-color: var(--danger); }

        /* ── PAGE ────────────────────────────────────── */
        .page { padding: 0; flex: 1; }

        /* ── HERO BAND ───────────────────────────────── */
        .hero {
            background: black;
            position: relative;
            overflow: hidden;
            padding: 52px 48px 0;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                repeating-linear-gradient(
                    90deg,
                    rgba(255,255,255,0.02) 0px,
                    rgba(255,255,255,0.02) 1px,
                    transparent 1px,
                    transparent 60px
                ),
                repeating-linear-gradient(
                    0deg,
                    rgba(255,255,255,0.02) 0px,
                    rgba(255,255,255,0.02) 1px,
                    transparent 1px,
                    transparent 60px
                );
            pointer-events: none;
        }
        .hero-inner {
            display: flex;
            align-items: flex-end;
            gap: 36px;
            position: relative;
            z-index: 1;
        }

        /* Photo */
        .hero-photo-wrap {
            flex-shrink: 0;
            position: relative;
            width: 140px;
        }
        .hero-photo {
            width: 140px;
            height: 160px;
            border-radius: 8px 8px 0 0;
            object-fit: cover;
            display: block;
            border: 3px solid rgba(255,255,255,0.15);
            border-bottom: none;
        }
        .hero-photo-initials {
            width: 140px;
            height: 160px;
            border-radius: 8px 8px 0 0;
            background: linear-gradient(145deg, rgba(255,255,255,0.12), rgba(255,255,255,0.04));
            border: 3px solid rgba(255,255,255,0.15);
            border-bottom: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 700;
            color: rgba(255,255,255,0.6);
            letter-spacing: -3px;
        }
        .hero-photo-badge {
            position: absolute;
            top: 10px; right: -10px;
            background: var(--gold);
            color: #fff;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 3px;
        }

        /* Hero text */
        .hero-info { flex: 1; padding-bottom: 28px; }
        .hero-dept {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.75);
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 3px;
            margin-bottom: 14px;
        }
        .hero-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }
        .hero-position {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
            font-weight: 300;
            margin-bottom: 20px;
        }
        .hero-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .hero-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.7);
            font-size: 0.76rem;
            padding: 5px 12px;
            border-radius: 4px;
        }
        .hero-chip svg { width: 12px; height: 12px; }

        /* ── CONTENT AREA ────────────────────────────── */
        .content {
            padding: 40px 48px 60px;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 28px;
            align-items: start;
        }

        /* ── DETAIL CARD ─────────────────────────────── */
        .card {
            background: var(--paper);
            border: 1px solid var(--rule);
            border-radius: 10px;
            overflow: hidden;
            animation: riseIn 0.4s ease both;
        }
        @keyframes riseIn { from { opacity:0; transform: translateY(14px); } to { opacity:1; transform: translateY(0); } }
        .card:nth-child(2) { animation-delay: 0.07s; }
        .card:nth-child(3) { animation-delay: 0.14s; }

        .card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid var(--rule);
            background: var(--bg);
        }
        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--ink);
            display: flex; align-items: center; gap: 10px;
        }
        .card-title svg { width: 15px; height: 15px; color: var(--gold); }
        .card-body { padding: 24px; }

        /* Detail rows */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
        .detail-item {
            padding: 16px 0;
            border-bottom: 1px solid var(--rule);
            display: flex; flex-direction: column; gap: 4px;
        }
        .detail-item:nth-last-child(-n+2) { border-bottom: none; }
        .detail-item.full { grid-column: 1 / -1; }
        .detail-label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.64rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 500;
        }
        .detail-value {
            font-size: 0.9rem;
            color: var(--ink);
            font-weight: 500;
        }
        .detail-value a {
            color: var(--accent);
            text-decoration: none;
        }
        .detail-value a:hover { text-decoration: underline; }
        .detail-value.mono {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.82rem;
        }
        .detail-value.salary {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: -0.5px;
        }

        /* Status badge */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }
        .status-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
        }
        .status-active { background: #e8f5ed; color: #1a6e35; }
        .status-active::before { background: #1a6e35; }
        .status-inactive { background: #f5e8e8; color: var(--danger); }
        .status-inactive::before { background: var(--danger); }

        /* Dept chip */
        .dept-chip {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--gold-lt);
            color: var(--gold);
            border: 1px solid rgba(184,146,74,0.2);
        }

        /* ── SIDEBAR RIGHT ───────────────────────────── */
        .right-col { display: flex; flex-direction: column; gap: 20px; }

        /* Tenure card */
        .tenure-card {
            background: black;
            border-radius: 10px;
            padding: 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
            animation: riseIn 0.4s ease 0.1s both;
        }
        .tenure-card::after {
            content: '';
            position: absolute;
            right: -20px; bottom: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .tenure-label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.62rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            margin-bottom: 10px;
        }
        .tenure-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            letter-spacing: -2px;
        }
        .tenure-unit {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
            font-weight: 300;
            margin-top: 4px;
        }
        .tenure-bar-wrap { margin-top: 18px; }
        .tenure-bar-label { display: flex; justify-content: space-between; font-size: 0.68rem; color: rgba(255,255,255,0.4); margin-bottom: 6px; }
        .tenure-bar-bg { background: rgba(255,255,255,0.1); border-radius: 2px; height: 4px; }
        .tenure-bar-fill {
            height: 4px;
            border-radius: 2px;
            background: var(--gold);
            transition: width 1s ease;
        }
        .tenure-hire-date {
            margin-top: 16px;
            display: flex; align-items: center; gap: 8px;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.55);
        }
        .tenure-hire-date svg { width: 13px; height: 13px; }

        /* Quick actions */
        .actions-card { animation: riseIn 0.4s ease 0.18s both; }
        .action-list { display: flex; flex-direction: column; gap: 0; }
        .action-row {
            display: flex; align-items: center; gap: 12px;
            padding: 13px 0;
            border-bottom: 1px solid var(--rule);
            text-decoration: none;
            color: var(--label);
            font-size: 0.82rem;
            font-weight: 500;
            transition: color 0.12s;
            cursor: pointer;
        }
        .action-row:last-child { border-bottom: none; }
        .action-row:hover { color: var(--ink); }
        .action-row.danger:hover { color: var(--danger); }
        .action-icon {
            width: 30px; height: 30px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg);
            flex-shrink: 0;
        }
        .action-icon svg { width: 13px; height: 13px; }
        .action-row:hover .action-icon { background: var(--rule); }
        .action-row.danger:hover .action-icon { background: #fff0f0; color: var(--danger); }
        .action-chevron { margin-left: auto; color: var(--rule); }
        .action-chevron svg { width: 13px; height: 13px; }

        /* ID card */
        .id-card {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--rule);
            animation: riseIn 0.4s ease 0.25s both;
        }
        .id-card-top {
            background: var(--gold);
            padding: 16px 20px 12px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .id-card-top span {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
        }
        .id-card-body {
            background: var(--paper);
            padding: 16px 20px;
        }
        .id-field { margin-bottom: 10px; }
        .id-field:last-child { margin-bottom: 0; }
        .id-field-label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 2px;
        }
        .id-field-value {
            font-size: 0.82rem;
            color: var(--ink);
            font-weight: 500;
        }
        .id-field-value.mono { font-family: 'IBM Plex Mono', monospace; font-size: 0.75rem; }

        /* ── DELETE MODAL ────────────────────────────── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(14,12,10,0.6);
            display: flex; align-items: center; justify-content: center;
            z-index: 999;
            opacity: 0; pointer-events: none;
            transition: opacity 0.2s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }
        .modal {
            background: var(--paper);
            border-radius: 12px;
            padding: 32px;
            max-width: 380px; width: 90%;
            border: 1px solid var(--rule);
            box-shadow: 0 24px 80px rgba(14,12,10,0.25);
            transform: translateY(12px);
            transition: transform 0.2s;
        }
        .modal-overlay.open .modal { transform: translateY(0); }
        .modal-icon {
            width: 44px; height: 44px;
            background: #fff0f0;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
            color: var(--danger);
        }
        .modal-icon svg { width: 20px; height: 20px; }
        .modal-title { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 700; margin-bottom: 8px; }
        .modal-desc { font-size: 0.84rem; color: var(--muted); line-height: 1.6; margin-bottom: 24px; }
        .modal-actions { display: flex; gap: 10px; }
        .modal-actions .btn { flex: 1; justify-content: center; padding: 10px; }
        .btn-delete-confirm { background: var(--danger); color: #fff; border-color: var(--danger); }
        .btn-delete-confirm:hover { background: #6b1818; }

        @media (max-width: 900px) {
            .content { grid-template-columns: 1fr; }
            .hero-name { font-size: 2.2rem; }
        }
        @media (max-width: 680px) {
            .sidebar { display: none; }
            .main { margin-left: 0; }
            .content { padding: 24px; }
            .hero { padding: 32px 24px 0; }
            .topbar { padding: 0 24px; }
            .detail-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- ══ SIDEBAR ══ --}}
<aside class="sidebar">
    <div class="sidebar-logo"><span>staff<em>flow</em></span></div>
    <nav class="sidebar-nav">
        <div class="nav-sec">Main</div>
       
        <a href="#" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Employees
        </a>
        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Attendance
        </a>
        <div class="nav-sec" style="margin-top:12px">Finance</div>
        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            Payroll
        </a>
        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Reports
        </a>
        <div class="nav-sec" style="margin-top:12px">System</div>
        <a href="#" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0112 2"/></svg>
            Settings
        </a>
    </nav>





    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="u-avatar">AD</div>
            <div class="u-name">Admin · HR Manager</div>
        </div>
    </div>
</aside>





{{-- ══ MAIN ══ --}}
<main class="main">

    {{-- TOPBAR --}}
    <header class="topbar">
        <nav class="breadcrumb">
            <span class="breadcrumb-sep">›</span>
            <a href="#">Employees</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">{{ $employee->first_name }} {{ $employee->last_name }}</span>
        </nav>



        <div class="topbar-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
                Back
            </a>
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4z"/></svg>
                Edit Profile
            </a>
        </div>
    </header>

    {{-- ══ HERO BAND ══ --}}
    <div class="hero">
        <div class="hero-inner">

            {{-- Photo --}}
            <div class="hero-photo-wrap">
                @if($employee->image)
                    <img class="hero-photo"
                         src="{{ asset('storage/' . $employee->image) }}"
                         alt="{{ $employee->first_name }} {{ $employee->last_name }}">
                @else
                    <div class="hero-photo-initials">
                        {{ strtoupper(substr($employee->first_name,0,1)) }}{{ strtoupper(substr($employee->last_name,0,1)) }}
                    </div>
                @endif
                <div class="hero-photo-badge">Active</div>
            </div>

            {{-- Info --}}
            <div class="hero-info">
                <div class="hero-dept">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:11px;height:11px"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    {{ $employee->department }}
                </div>
                <h1 class="hero-name">{{ $employee->first_name }} {{ $employee->last_name }}</h1>
                <p class="hero-position">{{ $employee->position }}</p>
                <div class="hero-chips">
                    <div class="hero-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        {{ $employee->email }}
                    </div>
                    <div class="hero-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .99h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        {{ $employee->phone_number }}
                    </div>
                    <div class="hero-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Hired {{ \Carbon\Carbon::parse($employee->hire_date)->format('M d, Y') }}
                    </div>
                </div>
            </div>

        </div>
    </div>




    {{-- ══ CONTENT ══ --}}
    <div class="content">

        {{-- LEFT: Detail cards --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Personal Details --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        Personal Details
                    </div>
                    <span class="status-badge status-active">Active</span>
                </div>
                <div class="card-body">
                    <div class="detail-grid">

                        <div class="detail-item">
                            <span class="detail-label">First Name</span>
                            <span class="detail-value">{{ $employee->first_name }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Last Name</span>
                            <span class="detail-value">{{ $employee->last_name }}</span>
                        </div>

                        <div class="detail-item full">
                            <span class="detail-label">Email Address</span>
                            <span class="detail-value">
                                <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Phone Number</span>
                            <span class="detail-value mono">{{ $employee->phone_number }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Employee ID</span>
                            <span class="detail-value mono">#{{ str_pad($employee->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                    </div>
                </div>
            </div>






            {{-- Role & Compensation --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-4 0v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                        Role &amp; Compensation
                    </div>
                </div>
                <div class="card-body">
                    <div class="detail-grid">

                        <div class="detail-item full">
                            <span class="detail-label">Position / Job Title</span>
                            <span class="detail-value">{{ $employee->position }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Department</span>
                            <span class="detail-value">
                                <span class="dept-chip">{{ $employee->department }}</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Hire Date</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($employee->hire_date)->format('F j, Y') }}</span>
                        </div>

                        <div class="detail-item full" style="border-bottom:none">
                            <span class="detail-label">Annual Salary</span>
                            <span class="detail-value salary">${{ number_format($employee->salary, 2) }}</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: Sidebar cards --}}
        <div class="right-col">

            {{-- Tenure card --}}
            <div class="tenure-card">
                <div class="tenure-label">Years with Company</div>
                @php
                    $hire    = \Carbon\Carbon::parse($employee->hire_date);
                    $years   = $hire->diffInYears(now());
                    $months  = $hire->diffInMonths(now()) % 12;
                    $pct     = min(100, ($hire->diffInMonths(now()) / 60) * 100);
                @endphp
                <div class="tenure-value">{{ $years }}<span style="font-size:1.5rem;opacity:0.6">.{{ str_pad($months,2,'0',STR_PAD_LEFT) }}</span></div>
                <div class="tenure-unit">years  ·  {{ $months }} month{{ $months !== 1 ? 's' : '' }} this year</div>
                <div class="tenure-bar-wrap">
                    <div class="tenure-bar-label">
                        <span>Hired</span>
                        <span>5 yr milestone</span>
                    </div>
                    <div class="tenure-bar-bg">
                        <div class="tenure-bar-fill" id="tenureBar" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                <div class="tenure-hire-date">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Since {{ \Carbon\Carbon::parse($employee->hire_date)->format('M d, Y') }}
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card actions-card">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                        Quick Actions
                    </div>
                </div>
                <div class="card-body" style="padding:0 24px">
                    <div class="action-list">

                        <a href="{{ route('employees.edit', $employee->id) }}" class="action-row">
                            <div class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4z"/></svg>
                            </div>
                            Edit Profile
                            <span class="action-chevron"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg></span>
                        </a>

                        <a href="mailto:{{ $employee->email }}" class="action-row">
                            <div class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            Send Email
                            <span class="action-chevron"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg></span>
                        </a>

                        <a href="#" class="action-row">
                            <div class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                            </div>
                            Download Contract
                            <span class="action-chevron"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg></span>
                        </a>

                        <a href="#" class="action-row">
                            <div class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                            </div>
                            View Payroll
                            <span class="action-chevron"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg></span>
                        </a>

                        <span class="action-row danger" onclick="openDeleteModal()">
                            <div class="action-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3,6 5,6 21,6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </div>
                            Delete Employee
                            <span class="action-chevron"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg></span>
                        </span>

                    </div>
                </div>
            </div>

            {{-- ID Mini Card --}}
            <div class="id-card">
                <div class="id-card-top">
                    <span>StaffFlow · Employee ID</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" style="width:18px;height:18px"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-4 0v2"/></svg>
                </div>
                <div class="id-card-body">
                    <div class="id-field">
                        <div class="id-field-label">Full Name</div>
                        <div class="id-field-value">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                    </div>
                    <div class="id-field">
                        <div class="id-field-label">Employee No.</div>
                        <div class="id-field-value mono">#{{ str_pad($employee->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="id-field">
                        <div class="id-field-label">Department</div>
                        <div class="id-field-value">{{ $employee->department }}</div>
                    </div>
                    <div class="id-field">
                        <div class="id-field-label">Since</div>
                        <div class="id-field-value">{{ \Carbon\Carbon::parse($employee->hire_date)->format('Y') }}</div>
                    </div>
                </div>
            </div>

        </div>{{-- /right-col --}}

    </div>{{-- /content --}}
</main>

{{-- ══ DELETE MODAL ══ --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3,6 5,6 21,6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
        </div>
        <div class="modal-title">Delete Employee</div>
        <div class="modal-desc">
            Are you sure you want to permanently delete <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>'s profile? This action cannot be undone and will remove all associated records.
        </div>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeDeleteModal()">Cancel</button>
            <form method="POST" action="{{ route('employees.destroy', $employee->id) }}" style="flex:1;display:flex">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete-confirm" style="flex:1;justify-content:center">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><polyline points="3,6 5,6 21,6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal()  { document.getElementById('deleteModal').classList.add('open'); }
    function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); }
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
</script>
</body>
</html>