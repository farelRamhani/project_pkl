@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h4 class="mb-4">📩 Pesan Masuk</h4>

    @forelse($messages as $msg)
        <div class="card mb-3 p-3">
            <strong>{{ $msg->title }}</strong>
            <p class="mb-0">{{ $msg->content }}</p>

            @if(!$msg->is_read)
                <span class="badge bg-danger">Belum dibaca</span>
            @else
                <span class="badge bg-success">Sudah dibaca</span>
            @endif
        </div>
    @empty
        <div class="alert alert-info">
            Tidak ada pesan
        </div>
    @endforelse

</div>
@endsection