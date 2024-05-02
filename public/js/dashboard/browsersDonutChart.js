const browsersDonutChart = document.getElementById('browsersDonutChart');
const browsers = [];
const browsersNumbers = [];
fetch("public/json/browsersDonutChart.json").then(response => response.json())
                                            .then(data =>{
                                              for (const key in data){
                                                browsers.push(key);
                                                browsersNumbers.push(data[key]);
                                              }
                                              new Chart(browsersDonutChart, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: browsers,
                                                      datasets: [{
                                                        label: 'Visitors',
                                                        data: browsersNumbers,
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
