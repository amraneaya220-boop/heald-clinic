@extends('doctor.layouts.doctor')

@section('title', 'Weekly Schedule')

@section('content')
<div class="card-white">
    <h3><i class="fas fa-calendar-alt"></i> 📅 Weekly Work Schedule</h3>
    <div style="overflow-x: auto;">
        <table class="schedule-table" id="weeklyScheduleTable">
            <thead id="scheduleHeader"></thead>
            <tbody id="scheduleBody"></tbody>
        </table>
    </div>
    <div style="margin-top: 20px;">
        <button id="addTimeSlotBtn" class="btn-sm"><i class="fas fa-plus"></i> Add Time Slot</button>
        <button id="resetDefaultBtn" class="btn-sm" style="background:#6C8DA3;"><i class="fas fa-undo"></i> Reset to Default</button>
    </div>
</div>

@push('scripts')
<script>
    let workSchedule = @json($schedule);
    let timeSlots = @json($timeSlots);
    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const dayNames = { en: days, fr: ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"], ar: ["الأحد","الإثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"] };
    const typeNames = { en: { surgery: "Surgery", exam: "Examination", holiday: "Holiday" }, fr: { surgery: "Chirurgie", exam: "Examen", holiday: "Congé" }, ar: { surgery: "جراحة", exam: "فحص", holiday: "عطلة" } };

    function renderSchedule() {
        const lang = currentLang;
        const headerRow = document.getElementById('scheduleHeader');
        const body = document.getElementById('scheduleBody');
        headerRow.innerHTML = '';
        body.innerHTML = '';
        let headerHtml = '<tr><th>⏰ Time / Day</th>';
        for (let i = 0; i < days.length; i++) headerHtml += `<th>${dayNames[lang][i]}</th>`;
        headerHtml += '</tr>';
        headerRow.innerHTML = headerHtml;

        let allTimes = [...new Set(Object.values(workSchedule).map(v => v.timeLabel))].sort();
        if (allTimes.length === 0) allTimes = timeSlots;
        for (let t of allTimes) {
            let row = body.insertRow();
            let timeCell = row.insertCell(0);
            timeCell.className = 'time-slot';
            timeCell.innerHTML = `${t} <button class="btn-edit-time" onclick="deleteTimeSlot('${t}')">🗑️</button>`;
            for (let d = 0; d < 7; d++) {
                let key = `${d}_${t}`;
                let cell = row.insertCell();
                if (workSchedule[key]) {
                    let type = workSchedule[key].type;
                    let typeText = typeNames[lang][type] || type;
                    let typeClass = type === 'surgery' ? 'surgery' : (type === 'exam' ? 'exam' : 'holiday');
                    cell.innerHTML = `<div class="work-type ${typeClass}" onclick="changeWorkType(${d}, '${t}')">${typeText}</div>
                                    <button class="btn-edit-time" onclick="enableTimeEdit(${d}, '${t}', this.parentElement)">⏱️</button>`;
                } else {
                    cell.innerHTML = '<span class="work-type holiday">—</span>';
                }
            }
        }
    }

    function changeWorkType(dayIndex, time) {
        let key = `${dayIndex}_${time}`;
        let types = ["surgery","exam","holiday"];
        let current = workSchedule[key].type;
        let next = types[(types.indexOf(current)+1)%3];
        workSchedule[key].type = next;
        saveSchedule();
        renderSchedule();
    }

    function deleteTimeSlot(time) {
        if (confirm(`Delete time slot ${time} from all days?`)) {
            for (let d=0; d<7; d++) delete workSchedule[`${d}_${time}`];
            timeSlots = timeSlots.filter(t => t !== time);
            saveSchedule();
            renderSchedule();
        }
    }

    function enableTimeEdit(dayIndex, oldTime, cell) {
        cell.innerHTML = '';
        const input = document.createElement('input');
        input.type = 'text';
        input.value = oldTime;
        input.className = 'inline-input';
        const saveBtn = document.createElement('button');
        saveBtn.innerText = '💾';
        saveBtn.className = 'btn-save-time';
        saveBtn.onclick = () => {
            let newTime = input.value.trim();
            if (newTime && !timeSlots.includes(newTime) && /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/.test(newTime)) {
                const key = `${dayIndex}_${oldTime}`;
                const newKey = `${dayIndex}_${newTime}`;
                workSchedule[newKey] = { ...workSchedule[key], timeLabel: newTime };
                delete workSchedule[key];
                timeSlots.push(newTime);
                timeSlots.sort();
                saveSchedule();
                renderSchedule();
            } else alert('Invalid time');
        };
        cell.appendChild(input);
        cell.appendChild(saveBtn);
    }

    function saveSchedule() {
        fetch('{{ route("doctor.schedule.update") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ workSchedule, timeSlots })
        }).then(res => res.json()).then(data => { if (!data.success) alert('Error saving'); });
    }

    function resetDefault() {
        if (confirm('Reset to default schedule?')) {
            fetch('{{ route("doctor.schedule.reset") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(res => res.json()).then(data => { if (data.success) location.reload(); });
        }
    }

    document.getElementById('addTimeSlotBtn').addEventListener('click', () => {
        let newTime = prompt('Enter new time (HH:MM)');
        if (newTime && !timeSlots.includes(newTime) && /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/.test(newTime)) {
            timeSlots.push(newTime);
            timeSlots.sort();
            for (let d=0; d<7; d++) workSchedule[`${d}_${newTime}`] = { type: 'exam', timeLabel: newTime };
            saveSchedule();
            renderSchedule();
        } else alert('Invalid time');
    });
    document.getElementById('resetDefaultBtn').addEventListener('click', resetDefault);
    renderSchedule();
</script>
@endpush
@endsection