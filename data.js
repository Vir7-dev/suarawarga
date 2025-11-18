let page = 1;
const limit = 10;
const tbody = document.getElementById("t-body");
const pageNumber = document.getElementById("page-number");
const totalPages = Math.ceil(pengguna.length / limit);

function renderTable() {
  tbody.innerHTML = "";

  const start = (page - 1) * limit;
  const end = start + limit;
  const paginatedUsers = pengguna.slice(start, end);

  paginatedUsers.forEach((p) => {
    const row = `
      <tr class="text-kecil">
          <td>${p.nik}</td>
          <td>${p.nama}</td>
          <td>${p.tempat_tanggal_lahir}</td>
          <td>${p.jenis_kelamin}</td>
          <td>${p.alamat}</td>
          <td>${p.agama}</td>
          <td>${p.pendidikan}</td>
          <td>${p.pekerjaan}</td>
          <td>${p.status_pemilihan}</td>
          <td>${p.role}</td>
          <td class="d-flex justify-content-center gap-2">
              <button class="btn-hitam" data-bs-toggle="modal" data-bs-target="#modal-ubah">UBAH</button>
              <button class="btn-merah" data-bs-toggle="modal" data-bs-target="#modal-hapus">HAPUS</button>
          </td>
      </tr>`;
    tbody.insertAdjacentHTML("beforeend", row);
  });

  pageNumber.textContent = `Halaman ${page} dari ${totalPages}`;

  document.getElementById("prev").disabled = page === 1;
  document.getElementById("next").disabled = page === totalPages;
}

document.getElementById("next").addEventListener("click", () => {
  if (page < totalPages) {
    page++;
    renderTable();
  }
});

document.getElementById("prev").addEventListener("click", () => {
  if (page > 1) {
    page--;
    renderTable();
  }
});

renderTable();
