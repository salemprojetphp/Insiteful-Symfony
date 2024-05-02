const likesDonutChart = document.getElementById('likesDonutChart');
const likes = [];
const likesNumbers = [];
fetch("public/json/adminjson/likesDonutChart.json").then(response => response.json())
                                            .then(data =>{
                                              for (const key in data){
                                                likes.push(key);
                                                likesNumbers.push(data[key]);
                                              }
                                              new Chart(likesDonutChart, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: likes,
                                                      datasets: [{
                                                        label: 'Likes',
                                                        data: likesNumbers,
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
