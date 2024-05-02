const websitesLineChart = document.getElementById('websitesLineChart');
const websites = [];
const websitesNumbers = [];
fetch("public/json/adminjson/websitesLineChart.json").then(response => response.json())
                                            .then(data =>{
                                              for (const key in data){
                                                websites.push(key);
                                                websitesNumbers.push(data[key]);
                                              }
                                              new Chart(websitesLineChart, {
                                                type: 'line',
                                                data: {
                                                  labels: websites,
                                                  datasets: [{
                                                    label: '# of Tracks',
                                                    data: websitesNumbers,
                                                    borderWidth: 5,
                                                    fill: false,
                                                  }]
                                                },
                                                options: {
                                                  responsive: true,
                                                }
                                            });
                                            })
                                            .catch(error => console.log("Error : ", error));
