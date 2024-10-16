function validasiForm() {
  // Ambil nilai dari input
  var nama = document.getElementById("nama").value;
  var email = document.getElementById("email").value;
  var alamat = document.getElementById("alamat").value;

  // Cek apakah semua input diisi
  if (nama === "" || email === "" || alamat === "") {
    alert("Semua data harus diisi.");
  } else {
    alert("Pendaftaran berhasil!");
  }
}
