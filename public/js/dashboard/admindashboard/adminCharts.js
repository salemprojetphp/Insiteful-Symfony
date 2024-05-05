import {createChart} from "../createChartFunction.js";

const websitesLineChart = document.getElementById('websitesLineChart');
const websites = [];
const websitesNumbers = [];


const likesDonutChart = document.getElementById('likesDonutChart');
const likes = [];
const likesNumbers = [];


const commentsDonutChart = document.getElementById('commentsDonutChart');
const comments = [];
const commentsNumbers = [];

createChart(likesDonutChart, likes, likesNumbers, "likesDonutChart", "doughnut", "likes", "/adminjson");

createChart(websitesLineChart, websites, websitesNumbers, "websitesLineChart", "line", "tracks", "/adminjson");

createChart(commentsDonutChart, comments, commentsNumbers, "commentsDonutChart", "doughnut", "comments", "/adminjson");