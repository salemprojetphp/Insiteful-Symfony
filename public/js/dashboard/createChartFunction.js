
export async function createChart(chartElement, keys, values, chartName, chartType, label, role){
    fetch(`/json${role}/${chartName}.json`).then(response => response.json())
    .then(data =>{
      for (const key in data){
        keys.push(key);
        values.push(data[key]);
      }
      if(chartType == "line"){
        new Chart(chartElement, {
          type: chartType,
          data: {
            labels: keys,
            datasets: [{
              label: `# of ${label}`,
              data: values,
              borderWidth: 5,
              fill: false,
            }]
          },
          options: {
            responsive: true,
          }
      });
      }else{
        new Chart(chartElement, {
          type: 'doughnut',
          data: {
              labels: keys,
                datasets: [{
                  label: label,
                  data: values,
                  backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(0, 128, 0)',
                    'rgb(255, 165, 0)',
                    'rgb(128, 0, 128)',
                    'rgb(128, 200, 28)',
                    'rgb(18, 150, 128)',
                  ],
                  hoverOffset: 4
                }]
          },
          options: {
            responsive: true,
          }
      });
      }
    })
    .catch(error => console.log("Error : ", error));
  }
  