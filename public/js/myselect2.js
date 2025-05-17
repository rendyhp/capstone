$(document).on("select2:open", () => {
    setTimeout(() => {
        const field = document.querySelector(".select2-container--open .select2-search__field");
        if (field) field.focus();
    }, 100);
});

function initSelect2(id, parentSelector) {
    const $select = $(id);
    if ($select.hasClass("select2-hidden-accessible")) {
        $select.select2("destroy");
    }
    $select.select2({
        placeholder: "Cari atau pilih...",
        allowClear: true,
        dropdownParent: $(parentSelector),
        dropdownAutoWidth: true,
        width: "100%",
    });
}

// Modal Tambah Barang
$("#barangModal").on("shown.bs.modal", function () {
    initSelect2("#satuan_id", "#barangModal .modal-content");
    initSelect2("#menu_id", "#barangModal .modal-content");
});

// Modal Edit Barang
$("#editBarangModal").on("shown.bs.modal", function () {
    initSelect2("#id_bahan", "#editBarangModal .modal-content");
    initSelect2("#txtsatuan_id", "#editBarangModal .modal-content");
});

// Modal Edit Bahan
$("#editEditModal").on("shown.bs.modal", function () {
    initSelect2("#id_bahan", "#editBahanModal .modal-content");
    initSelect2("#txtsatuan_id", "#editBahanModal .modal-content");
});

// Modal Tambah Barang (Bar)
$("#barangModal1").on("shown.bs.modal", function () {
    initSelect2("#satuan_id_bar", "#barangModal1 .modal-content");
});

// Modal Tambah Barang (Kitchen)
$("#barangModal2").on("shown.bs.modal", function () {
    initSelect2("#satuan_id_kitchen", "#barangModal2 .modal-content");
});
