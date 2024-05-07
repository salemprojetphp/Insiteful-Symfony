import { createChart } from "./createChartFunction.js";

const lineChart = document.getElementById('lineChart');
const time = [];
const numbers = []

const browsersDonutChart = document.getElementById('browsersDonutChart');
const browsers = [];
const browsersNumbers = [];

const devicesDonutChart = document.getElementById('devicesDonutChart');
const devices = [];
const devicesNumbers = [];

createChart(lineChart, time, numbers, "lineChart", "line", "visits", "")

createChart(browsersDonutChart, browsers, browsersNumbers, "browsersDonutChart", "doughnut", "browsers", "")

createChart(devicesDonutChart, devices, devicesNumbers, "devicesDonutChart", "doughnut", "devices", "")