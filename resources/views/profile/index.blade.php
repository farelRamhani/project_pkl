@extends('layouts.app')

@section('content')
<div style="
    position:fixed;
    inset:0;
    background: radial-gradient(circle at top left, #1e293b, #020617);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
">

    <!-- DECORATION -->
    <div style="position:absolute; width:300px; height:300px; background:#6366f1; filter:blur(120px); top:-80px; left:-80px; opacity:.3;"></div>
    <div style="position:absolute; width:250px; height:250px; background:#22c55e; filter:blur(120px); bottom:-80px; right:-80px; opacity:.3;"></div>

    <div style="width:100%; max-width:430px; position:relative; z-index:2;">

        <!-- CARD -->
        <div style="
            backdrop-filter: blur(18px);
            background: rgba(255,255,255,0.92);
            border-radius:24px;
            padding:35px;
            box-shadow:0 30px 80px rgba(0,0,0,0.5);
            border:1px solid rgba(255,255,255,0.3);
            transition:.4s;
        " onmouseover="this.style.transform='translateY(-5px) scale(1.01)'" 
           onmouseout="this.style.transform='none'">

            <!-- HEADER -->
            <div class="text-center mb-4">

                <div style="
                    width:95px;
                    height:95px;
                    border-radius:50%;
                    background: linear-gradient(135deg,#6366f1,#22c55e);
                    color:#fff;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin:auto;
                    font-size:34px;
                    font-weight:bold;
                    border:5px solid #fff;
                    box-shadow:0 15px 40px rgba(0,0,0,0.4);
                ">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>

                <h4 class="mt-3 fw-bold">{{ auth()->user()->name }}</h4>

                <span style="
                    background:linear-gradient(135deg,#111827,#374151);
                    color:#fff;
                    padding:5px 14px;
                    border-radius:999px;
                    font-size:12px;
                    letter-spacing:1px;
                ">
                    👤 USER ACCOUNT
                </span>

            </div>

            <!-- SUCCESS -->
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- DIVIDER -->
            <div style="height:1px; background:#e5e7eb; margin:20px 0;"></div>

            <small style="color:#6b7280; letter-spacing:1px;">INFORMASI AKUN</small>

            <!-- INFO -->
            <div class="mt-3">

                <div style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    padding:15px;
                    border-radius:14px;
                    background:linear-gradient(135deg,#f8fafc,#f1f5f9);
                    margin-bottom:10px;
                    transition:.3s;
                " onmouseover="this.style.transform='scale(1.02)'" 
                   onmouseout="this.style.transform='scale(1)'">

                    <div>
                        <small class="text-muted">Nama</small>
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    </div>
                    <span style="font-size:18px;">👤</span>
                </div>

                <div style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    padding:15px;
                    border-radius:14px;
                    background:linear-gradient(135deg,#f8fafc,#f1f5f9);
                    transition:.3s;
                " onmouseover="this.style.transform='scale(1.02)'" 
                   onmouseout="this.style.transform='scale(1)'">

                    <div>
                        <small class="text-muted">Email</small>
                        <div class="fw-semibold">{{ auth()->user()->email }}</div>
                    </div>
                    <span style="font-size:18px;">📧</span>
                </div>

            </div>

            <!-- BUTTONS -->
            <div class="mt-4 d-grid gap-2">

                <a href="{{ route('profile.edit') }}" 
                   class="btn"
                   style="
                        background: linear-gradient(135deg,#6366f1,#4f46e5);
                        color:white;
                        border-radius:14px;
                        padding:12px;
                        font-weight:500;
                        box-shadow:0 15px 30px rgba(99,102,241,0.4);
                        transition:.3s;
                   "
                   onmouseover="this.style.transform='scale(1.03)'"
                   onmouseout="this.style.transform='scale(1)'">
                    ✏️ Edit Profile
                </a>

                <a href="{{ route('home') }}" 
                   class="btn"
                   style="
                        background:#020617;
                        color:white;
                        border-radius:14px;
                        padding:12px;
                        font-weight:500;
                        box-shadow:0 15px 30px rgba(0,0,0,0.5);
                        transition:.3s;
                   "
                   onmouseover="this.style.transform='scale(1.03)'"
                   onmouseout="this.style.transform='scale(1)'">
                    ⬅️ Kembali ke Dashboard
                </a>

            </div>

        </div>

    </div>

</div>
@endsection