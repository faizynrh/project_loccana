////////// APPROVE //////////
function confirmApprove(id) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Pastikan ini data yang akan disetujui",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Setujui",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("approveForm").submit();
        }
    });
}

////////// Reject //////////
function confirmReject(id) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Pastikan ini data yang akan ditolak",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Tolak",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("approve" + id).submit();
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
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete" + id).submit();
        }
    });
}

function disableButton(event) {
    let form = event.target;
    if (form.checkValidity()) {
        // Pastikan form valid
        let button = document.getElementById("submitButton");
        button.disabled = true;
        button.innerText = "Processing...";
    }
}
