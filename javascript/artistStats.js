function formatDate(date) {
  return date.toISOString().split('T')[0];
}

function getRangeDates(options) {
  const today = new Date();
  let startDate;

  switch (options) {
    case 'week':
      startDate = new Date(today);
      startDate.setDate(today.getDate() - 7);
      break;
    case 'month':
      startDate = new Date(today.getFullYear(), today.getMonth(), 1);
      break;
    case 'year':
      startDate = new Date(today.getFullYear(), 0, 1);
      break;
    case 'all':
      startDate = new Date('2000-01-01');
      break;
    default:
      return null;
  }

  return {
    start: formatDate(startDate),
    end: formatDate(today),
  };
}

document.querySelectorAll('.quick-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const options = btn.dataset.range;
    const { start, end } = getRangeDates(options);
    document.getElementById('start-date').value = start;
    document.getElementById('end-date').value = end;

    fetchStats(start, end);
  });
});

document.getElementById('apply-filter').addEventListener('click', () => {
  const start = document.getElementById('start-date').value;
  const end = document.getElementById('end-date').value;

  if (!start || !end) {
    alert('Please select both dates.');
    return;
  }

  fetchStats(start, end);
});

async function fetchStats(start, end) {
  const response = await fetch(`../api/api_get_artist_stats.php?start=${start}&end=${end}`);
  const data = await response.json();

  document.getElementById('total-requests').textContent = data.totalRequests ?? '0';
  document.getElementById('avg-rating').textContent = data.avgRating?.toFixed(1) ?? '0.0';
  document.getElementById('estimated-earnings').textContent = `${data.profit?.toFixed(0) ?? '0'} €`;
}