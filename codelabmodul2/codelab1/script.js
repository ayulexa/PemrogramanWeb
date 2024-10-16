function hitung() {
  // Ambil nilai input
  var num1 = parseFloat(document.getElementById("num1").value);
  var num2 = parseFloat(document.getElementById("num2").value);

  // Hitung penjumlahan
  var hasil = num1 + num2;

  // Tampilkan hasil
  document.getElementById("hasil").textContent = hasil;
}

function reset() {
  // Reset input dan hasil
  document.getElementById("num1").value = "";
  document.getElementById("num2").value = "";
  document.getElementById("hasil").textContent = "0";
}
