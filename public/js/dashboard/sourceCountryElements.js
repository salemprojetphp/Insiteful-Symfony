import { createSourceCountryElements } from "./createElementsFunction.js";
const sourcesParent = document.querySelector(".sources");
const sources = [];
const sourcesNumbers = []
let sourcesSum = 0;

const countriesParent = document.querySelector(".countries");
const countries = [];
const countriesNumbers = []
let countriesSum = 0;

createSourceCountryElements(sourcesParent, sources, sourcesNumbers, sourcesSum, "sources");

createSourceCountryElements(countriesParent, countries, countriesNumbers, countriesSum, "countries");