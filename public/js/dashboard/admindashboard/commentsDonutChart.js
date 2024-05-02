const commentsDonutChart = document.getElementById('commentsDonutChart');
const comments = [];
const commentsNumbers = [];
fetch("public/json/adminjson/commentsDonutChart.json").then(response => response.json())
                                            .then(data =>{
                                              for (const key in data){
                                                comments.push(key);
                                                commentsNumbers.push(data[key]);
                                              }
                                              new Chart(commentsDonutChart, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: comments,
                                                      datasets: [{
                                                        label: 'comments',
                                                        data: commentsNumbers,
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
