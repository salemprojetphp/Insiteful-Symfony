const devicesDonutChart = document.getElementById('devicesDonutChart');
const devices = [];
const devicesNumbers = [];
fetch("public/json/devicesDonutChart.json").then(response => response.json())
                                            .then(data =>{
                                              for (const key in data){
                                                devices.push(key);
                                                devicesNumbers.push(data[key]);
                                              }
                                              new Chart(devicesDonutChart, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: devices,
                                                      datasets: [{
                                                        label: 'Visitors',
                                                        data: devicesNumbers,
                                                        backgroundColor: [
                                                          'rgb(255, 99, 132)',
                                                          'rgb(54, 162, 235)',
                                                          'rgb(255, 205, 86)',
                                                          'rgb(0, 128, 0)',
                                                          'rgb(255, 165, 0)',
                                                          'rgb(128, 0, 128)',
                                                        ],
                                                        hoverOffset: 4
                                                      }]
                                                },
                                                options: {
                                                  responsive: true,
                                                }
                                            });
                                            })
                                            .catch(error => console.log("Error : ", error));
