import mask from '@alpinejs/mask'

Alpine.plugin(mask)

import Chart from 'chart.js/auto';
import Swal from 'sweetalert2'
import { renderPerkembanganChart } from './charts/perkembangan-halaqah';
import { statistikDompet } from './charts/statistik-dompet';

window.Swal = Swal
window.Chart = Chart;

window.renderPerkembanganChart = renderPerkembanganChart;
window.statistikDompet = statistikDompet;
