//this file reads the countries and numbers and appends div elements to the div with the 'countries' class
const countriesParent = document.querySelector(".countries");
const countries = [];
const countriesNumbers = []
let countriesSum = 0;
//reading the json file and putting the dates(key) in time array and numbers(value) in numbers
//array 
fetch("public/json/countries.json").then(response => response.json())
                                    .then(data => {
                                    for (const key in data){
                                        countries.push(key);
                                        countriesNumbers.push(data[key]);
                                        countriesSum += Number(data[key]); 
                                    }
                                    for(let i =0; i<countries.length; i++){
                                        let countriesItem = document.createElement("div");
                                        countriesItem.className = "source-country-item";
                                        let countriesName = document.createElement("div");
                                        countriesName.textContent = countries[i];
                                        countriesName.className = "name";
                                        let countriesNumber = document.createElement("div");
                                        countriesNumber.textContent = countriesNumbers[i];
                                        countriesNumber.className = "number";
                                        let countriesPercent = document.createElement("div");
                                        countriesPercent.textContent = Math.floor(((Number(countriesNumbers[i])/countriesSum)*100)).toString()+"%";
                                        countriesPercent.className = "percentage";
                                        countriesParent.appendChild(countriesItem);
                                        countriesItem.appendChild(countriesName);
                                        countriesItem.appendChild(countriesNumber);
                                        countriesItem.appendChild(countriesPercent);
                                    }
                                })
                                .catch(error => console.log("Error : ", error));