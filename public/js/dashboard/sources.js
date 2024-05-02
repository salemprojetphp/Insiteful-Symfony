//this file reads the sources and numbers and appends div elements to the div with the 'sources' class
const sourcesParent = document.querySelector(".sources");
const sources = [];
const sourcesNumbers = []
let sourcesSum = 0;
//reading the json file and putting the dates(key) in time array and numbers(value) in numbers
//array 
fetch("public/json/sources.json").then(response => response.json())
                                    .then(data => {
                                    for (const key in data){
                                        sources.push(key);
                                        sourcesNumbers.push(data[key]);
                                        sourcesSum += Number(data[key]); 
                                    }
                                    for(let i =0; i<sources.length; i++){
                                        let sourcesItem = document.createElement("div");
                                        sourcesItem.className = "source-country-item";
                                        let sourceName = document.createElement("div");
                                        sourceName.textContent = sources[i];
                                        sourceName.className = "name";
                                        let sourceNumber = document.createElement("div");
                                        sourceNumber.textContent = sourcesNumbers[i];
                                        sourceNumber.className = "number";
                                        let sourcePercent = document.createElement("div");
                                        sourcePercent.textContent = Math.floor(((Number(sourcesNumbers[i])/sourcesSum)*100)).toString()+"%";
                                        sourcePercent.className = "percentage";
                                        sourcesParent.appendChild(sourcesItem);
                                        sourcesItem.appendChild(sourceName);
                                        sourcesItem.appendChild(sourceNumber);
                                        sourcesItem.appendChild(sourcePercent);
                                    }
                                })
                                .catch(error => console.log("Error : ", error));