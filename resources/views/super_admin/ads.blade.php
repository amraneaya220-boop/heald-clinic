@extends('layouts.admin')

@section('title', 'Ads')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <h3><i class="fas fa-ad"></i> Manage Advertisements</h3>
        <button class="btn-sm" id="openAddAdModal" style="padding: 10px 20px;"><i class="fas fa-plus"></i> Add Ad</button>
    </div>
    <div id="adsList">
        @foreach($ads as $ad)
        <div style="background: #1e3a5f; border-radius: 20px; padding: 15px; margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between;">
            <div>
                @if($ad->type == 'image')
                    <img src="{{ $ad->url }}" style="max-width: 150px; max-height: 80px; border-radius: 12px;" alt="ad">
                @else
                    <video width="150" style="max-height: 80px; border-radius: 12px;">
                        <source src="{{ $ad->url }}">
                    </video>
                @endif
            </div>
            <div style="flex: 2;">
                <strong>{{ $ad->title }}</strong><br>
                <small>{{ ucfirst($ad->type) }} | Expires: {{ $ad->expiry_date }}</small>
            </div>
            <div>
                <button class="btn-sm btn-danger" onclick="deleteAd({{ $ad->id }})">Delete</button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div id="addAdModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>New Advertisement</h3>
        <div class="form-group">
            <label>Title</label>
            <input type="text" id="adTitle">
        </div>
        <div class="form-group">
            <label>Type</label>
            <select id="adType">
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>
        </div>
        <div class="form-group">
            <label>File URL</label>
            <input type="url" id="adUrl" placeholder="https://example.com/ad.jpg">
        </div>
        <div class="form-group">
            <label>Target Link (optional)</label>
            <input type="url" id="adLink" placeholder="https://...">
        </div>
        <div class="form-group">
            <label>Duration (days)</label>
            <input type="number" id="adDuration" value="30">
        </div>
        <button class="btn-sm" id="saveAdBtn">Publish</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const addModal = document.getElementById('addAdModal');
    document.getElementById('openAddAdModal').onclick = () => addModal.style.display = 'flex';
    document.querySelector('#addAdModal .close').onclick = () => addModal.style.display = 'none';

    document.getElementById('saveAdBtn').onclick = () => {
        const title = document.getElementById('adTitle').value;
        const type = document.getElementById('adType').value;
        const url = document.getElementById('adUrl').value;
        const link = document.getElementById('adLink').value;
        const duration = document.getElementById('adDuration').value;

        if (title && url) {
            fetch('{{ route("admin.ads.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ title, type, url, link, duration })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
            });
        }
    };

    function deleteAd(id) {
        if (confirm('Delete this ad?')) {
            fetch(`{{ url('admin/ads') }}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
            });
        }
    }

    window.onclick = (e) => { if (e.target === addModal) addModal.style.display = 'none'; };
</script>
@endsection