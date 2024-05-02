const lineChart = document.getElementById('lineChart');
const time = [];
const numbers = []
//reading the json file and putting the dates(key) in time array and numbers(value) in numbers
//array 
fetch("public/json/lineChart.json").then(response => response.json())
                                    .then(data => {
                                      for (const key in data){
                                        time.push(key);
                                        numbers.push(data[key]);
                                      }
                                      new Chart(lineChart, {
                                        type: 'line',
                                        data: {
                                          labels: time,
                                          datasets: [{
                                            label: '# of Visitors',
                                            data: numbers,
                                            borderWidth: 5,
                                            fill: false,
                                          }]
                                        },
                                        options: {
                                          responsive: true,
                                        }
                                    });
                                    })
                                    .catch(error => console.error('Error:', error));




