
export async function createSourceCountryElements(parent, keys, values, sum, jsonName){
    fetch(`/json/${jsonName}.json`).then(response => response.json())
                                .then(data => {
                                for (const key in data){
                                    keys.push(key);
                                    values.push(data[key]);
                                    sum += Number(data[key]); 
                                }
                                for(let i =0; i<keys.length; i++){
                                    let item = document.createElement("div");
                                    item.className = "source-country-item";
                                    let name = document.createElement("div");
                                    name.textContent = keys[i];
                                    name.className = "name";
                                    let number = document.createElement("div");
                                    number.textContent = values[i];
                                    number.className = "number";
                                    let percent = document.createElement("div");
                                    percent.textContent = Math.floor(((Number(values[i])/sum)*100)).toString()+"%";
                                    percent.className = "percentage";
                                    let pernumContainer = document.createElement("div");
                                    pernumContainer.className = "pernumContainer";
                                    pernumContainer.appendChild(number);
                                    pernumContainer.appendChild(percent);
                                    parent.appendChild(item);
                                    item.appendChild(name);
                                    item.appendChild(pernumContainer);
                                }
                                })
                                .catch(error => console.log("Error : ", error));

}