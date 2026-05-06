@extends('doctor.layouts.doctor')

@section('title', 'Settings')

@section('content')
<div class="card-white">
    <h3><i class="fas fa-sliders-h"></i> ⚙️ Account Settings</h3>
    <form id="settingsForm">
        @csrf
        <div class="form-group"><label>📝 Full name</label><input type="text" id="fullname" value="{{ $doctor->name }}"></div>
        <div class="form-group"><label>🩺 Specialty</label><input type="text" id="specialty" value="{{ $doctor->specialty }}"></div>
        <div class="row-2">
            <div><label>📞 Phone</label><input type="text" id="phone" value="{{ $doctor->phone }}"></div>
            <div><label>✉️ Email</label><input type="email" id="email" value="{{ $doctor->email }}"></div>
        </div>
        <div class="form-group"><label>🏥 Clinic</label><input type="text" id="clinic" value="{{ $doctor->clinic->name ?? '' }}"></div>
        <div class="form-group"><label>📷 Change profile picture</label><input type="file" id="profilePic"></div>
        <div class="form-group"><label>⏱️ Appointment settings</label>
            <div class="row-2">
                <div><label>Default duration</label><select id="duration"><option>20 min</option><option>30 min</option></select></div>
                <div><label>Break time</label><input type="text" id="breakTime" value="{{ $doctor->break_time ?? '13:00 - 14:00' }}"></div>
            </div>
        </div>
        <div class="form-group"><label>📅 Working days</label>
            <div class="days-checkboxes">
                @foreach(['Sat','Sun','Mon','Tue','Wed','Thu'] as $day)
                <label><input type="checkbox" class="working-day" value="{{ $day }}" {{ in_array($day, $workingDays) ? 'checked' : '' }}> {{ $day }}</label>
                @endforeach
            </div>
        </div>
        <div>
            <button type="button" class="btn-sm" id="saveBtn">💾 Save changes</button>
            <button type="button" class="btn-outline" id="changePwdBtn">🔑 Change password</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('saveBtn').addEventListener('click', function() {
        const workingDays = Array.from(document.querySelectorAll('.working-day:checked')).map(cb => cb.value);
        const data = {
            name: document.getElementById('fullname').value,
            specialty: document.getElementById('specialty').value,
            phone: document.getElementById('phone').value,
            email: document.getElementById('email').value,
            clinic_name: document.getElementById('clinic').value,
            break_time: document.getElementById('breakTime').value,
            working_days: workingDays
        };
        fetch('{{ route("doctor.settings.update") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        }).then(res => res.json()).then(data => {
            if (data.success) alert('Settings saved');
            else alert('Error');
        });
    });

    document.getElementById('changePwdBtn').addEventListener('click', () => {
        let newPwd = prompt('Enter new password');
        if (newPwd && newPwd.trim() !== '') {
            fetch('{{ route("doctor.settings.update") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ password: newPwd })
            }).then(res => res.json()).then(data => {
                if (data.success) alert('Password changed');
                else alert('Error');
            });
        }
    });
</script>
@endpush
@endsection