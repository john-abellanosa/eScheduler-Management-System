/* Admin Dashboard JS - corporate grade */
(function(){
  const $ = (sel, el=document) => el.querySelector(sel);
  const $$ = (sel, el=document) => Array.from(el.querySelectorAll(sel));

  // Real-time clock
  function pad(n){ return String(n).padStart(2,'0'); }
  function updateClock(){
    const now = new Date();
    const date = now.toLocaleDateString(undefined, { weekday:'long', year:'numeric', month:'short', day:'numeric' });
    const time = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
    const dateEl = $('#currentDate');
    const timeEl = $('#currentTime');
    if(dateEl) dateEl.textContent = date;
    if(timeEl) timeEl.textContent = time;
  }
  setInterval(updateClock, 1000); updateClock();

  // Segmented controls
  $$('.segmented .seg-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const group = e.currentTarget.closest('.segmented');
      group.querySelectorAll('.seg-btn').forEach(b=>{
        b.classList.remove('active'); b.setAttribute('aria-selected','false');
      });
      e.currentTarget.classList.add('active'); e.currentTarget.setAttribute('aria-selected','true');
      // Trigger filter handling
      applyFilters();
    });
  });

  // Sidebar toggle
  const sidebar = $('#sidebar');
  const sidebarToggle = $('#sidebarToggle');
  if(sidebar && sidebarToggle){
    sidebarToggle.addEventListener('click', ()=>{
      sidebar.classList.toggle('collapsed');
    });
  }

  // Export handlers (CSV + PDF)
  $('#exportCsv')?.addEventListener('click', () => {
    const csv = generateCsv();
    const blob = new Blob([csv], { type:'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = `workforce-dashboard-${Date.now()}.csv`;
    document.body.appendChild(a); a.click(); a.remove();
    URL.revokeObjectURL(url);
  });

  $('#exportPdf')?.addEventListener('click', () => {
    // Simple print to PDF using browser's dialog; for full fidelity integrate jsPDF if needed
    window.print();
  });

  function generateCsv(){
    // Placeholder data snapshot; replace with backend data
    const headers = ['Metric','Value'];
    const rows = [
      ['Pending Requests', $('#kpiPending')?.textContent || ''],
      ['Total Crew', $('#kpiTotalCrew')?.textContent || ''],
      ['Total Managers', $('#kpiTotalManagers')?.textContent || ''],
      ['Crew This Week', $('#kpiCrewWeek')?.textContent || ''],
      ['Managers This Week', $('#kpiManagersWeek')?.textContent || ''],
      ['Crew Plotted Today', $('#kpiCrewToday')?.textContent || '']
    ];
    return [headers.join(','), ...rows.map(r=>r.join(','))].join('\n');
  }

  // Chart.js setup
  const gridColor = 'rgba(15, 41, 103, 0.08)';
  const axisColor = '#6b778c';
  const blue = '#1b3c88';
  const blueLight = '#a6b7e6';
  const gray = '#a3acbd';

  const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

  // Placeholder datasets; replace with backend data
  let state = {
    range: 'today',
    role: 'all',
    crew: {
      count: [30, 42, 38, 45, 50, 48, 36],
      hours: [180, 260, 240, 290, 320, 310, 220]
    },
    manager: {
      count: [6, 8, 7, 9, 10, 9, 7],
      hours: [48, 64, 56, 72, 80, 76, 56]
    },
    shifts: {
      labels: ['Graveyard','Morning','Afternoon','Evening'],
      values: [18, 42, 26, 14]
    }
  };

  function applyFilters(){
    const rangeBtn = $$('.segmented [data-range].active')[0];
    const roleBtn = $$('.segmented [data-role].active')[0];
    state.range = rangeBtn?.dataset.range || 'today';
    state.role = roleBtn?.dataset.role || 'all';

    // For demo: slightly vary data by range to simulate filter effect
    const factor = state.range === 'today' ? 0.9 : state.range === 'week' ? 1.0 : 1.1;
    const scale = (arr) => arr.map(v => Math.round(v * factor));

    crewChart.data.datasets[0].data = scale(state.crew.count);
    crewChart.data.datasets[1].data = scale(state.crew.hours);
    crewChart.update();

    managerChart.data.datasets[0].data = scale(state.manager.count);
    managerChart.data.datasets[1].data = scale(state.manager.hours);
    managerChart.update();

    donutChart.data.datasets[0].data = state.shifts.values.map(v => Math.round(v * (factor)));
    donutChart.update();
  }

  const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: { position: 'top', labels: { usePointStyle:true, color: axisColor } },
      tooltip: { enabled: true },
      title: { display: false }
    },
    scales: {
      x: { grid: { color: gridColor }, ticks: { color: axisColor } },
      y: { grid: { color: gridColor }, ticks: { color: axisColor } }
    }
  };

  const crewCtx = document.getElementById('crewWorkloadChart');
  const managerCtx = document.getElementById('managerWorkloadChart');
  const donutCtx = document.getElementById('shiftDonutChart');

  const crewChart = new Chart(crewCtx, {
    type: 'bar',
    data: {
      labels: days,
      datasets: [
        { label: 'Crew', data: state.crew.count, backgroundColor: blue, borderRadius: 6, maxBarThickness: 22 },
        { label: 'Hours', data: state.crew.hours, type: 'line', borderColor: gray, backgroundColor: 'transparent', tension: 0.35, pointRadius: 3 }
      ]
    },
    options: { ...commonOptions }
  });

  const donutChart = new Chart(donutCtx, {
    type: 'doughnut',
    data: {
      labels: state.shifts.labels,
      datasets: [{
        data: state.shifts.values,
        backgroundColor: ['#0F2967', '#4E6BB3', '#8EA3D0', '#CBD6F0'],
        borderColor: '#ffffff',
        borderWidth: 2,
        cutout: '62%'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom', labels: { color: axisColor } },
        tooltip: { enabled: true }
      }
    }
  });

  const managerChart = new Chart(managerCtx, {
    type: 'bar',
    data: {
      labels: days,
      datasets: [
        { label: 'Managers', data: state.manager.count, backgroundColor: blue, borderRadius: 6, maxBarThickness: 22 },
        { label: 'Hours', data: state.manager.hours, type: 'line', borderColor: blueLight, backgroundColor: 'transparent', tension: 0.35, pointRadius: 3 }
      ]
    },
    options: { ...commonOptions }
  });

  // Initial apply for any default states
  applyFilters();
})();
