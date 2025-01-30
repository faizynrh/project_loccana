////////// APPROVE //////////
function confirmApprove(id) {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Pastikan ini data yang akan disetujui",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Setujui",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((willApprove) => {
        if (willApprove) {
            document.getElementById("approve" + id).submit();
        }
    });
}

//////////// ADD //////////
function confirmSubmit(buttonId, formId) {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Data yang dimasukkan akan disimpan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(formId);
            if (form) {
                form.submit();
            } else {
                Swal.fire("Error", "Form tidak ditemukan", "error");
            }
        }
    });
}

//////////// EDIT //////////
function confirmEdit(buttonId, formId) {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Perubahan yang anda buat akan disimpan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(formId);
            if (form) {
                form.submit();
            } else {
                Swal.fire("Error", "Form tidak ditemukan", "error");
            }
        }
    });
}

//////////// DELETE //////////
function confirmDelete(id) {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Data ini akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete" + id).submit();
        }
    });
}
