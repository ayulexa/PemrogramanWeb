let display = document.getElementById("display");

function appendToDisplay(value) {
  display.value += value;
}

function clearAll() {
  display.value = "";
}

function deleteLast() {
  display.value = display.value.slice(0, -1); // Remove the last character
}

function calculate() {
  let input = display.value;

  // Handle percentage calculations
  const percentPattern = /(\d+(?:\.\d+)?)\s*%/g;
  let match;
  while ((match = percentPattern.exec(input)) !== null) {
    const percentValue = parseFloat(match[1]);
    const precedingValue = input.substring(0, match.index).trim();
    // Check if there is a preceding number to use as the base for the percentage
    const baseValue = precedingValue ? parseFloat(precedingValue) : 0;
    const calculatedPercentage = baseValue * (percentValue / 100);
    // Replace the matched percentage expression with the calculated value
    input = input.replace(match[0], calculatedPercentage);
  }

  // Replace '^' with '**' for exponentiation
  input = input.replace("^", "**");

  try {
    // Use Function constructor to safely evaluate the expression
    let result = Function("return " + input)();
    display.value = result;
  } catch (error) {
    display.value = "Error";
  }
}
