const currentUrl = window.location.pathname;

const toggleDropdown = (urls, menuId, toggleId) => {
    if (urls.some((url) => currentUrl.includes(url))) {
        const menuEl = document.getElementById(menuId);
        const toggleEl = document.getElementById(toggleId);

        if (menuEl) {
            menuEl.classList.add("show");
        }
        if (toggleEl) {
            toggleEl.setAttribute("aria-expanded", "true");
        }
    }
};

toggleDropdown(
    [
        "/barang/manajemen-barang",
        "/barang/masuk-keluar",
        "/barang/satuan",
        "/bahan/manajemen-bahan",
        "/bahan/data-bahan",
        "/bahan/satuan",
    ],
    "stokDropdownMenu",
    "stokMasterDropdown"
);
toggleDropdown(["/data-bahan"], "dataDropdownMenu", "dataMasterDropdown");
toggleDropdown(
    ["/daftar-menu", "/transaksi"],
    "menuTransaksiDropdownMenu",
    "menuTransaksiDropdown"
);
toggleDropdown(
    ["/protected/user-data"],
    "lainnyaDropdownMenu",
    "lainnyaDropdown"
);

/////////////////////////////////////////////////////////

const inputIds = ["txtminimum", "minimum", "txtjumlah", "jumlah"];

function handleNumericInput(e) {
    let value = e.target.value;
    let cleaned = value.replace(/[^0-9.]/g, "");
    let [intPart, decimalPart] = cleaned.split(".");

    intPart = intPart.slice(0, 11);

    if (decimalPart) {
        decimalPart = decimalPart.slice(0, 3);
        cleaned = intPart + "." + decimalPart;
    } else {
        cleaned = intPart;
    }
    if (e.target.value !== cleaned) {
        e.target.value = cleaned;
    }
}

inputIds.forEach(function (id) {
    const input = document.getElementById(id);
    if (input) {
        input.addEventListener("input", handleNumericInput);
    }
});


//////////////////////////////////////////

document
    .querySelectorAll("#jumlah, #txtjumlah, #txtminimum, #minimum")
    .forEach(function (input) {
        input.addEventListener("keydown", function (e) {
            if (e.key === "ArrowUp") {
                e.preventDefault();
                this.value = (parseFloat(this.value) || 0) + 1;
            } else if (e.key === "ArrowDown") {
                e.preventDefault();
                this.value = (parseFloat(this.value) || 0) - 1;
            }
        });
    });

//////////////////////////////////////////

$(document).on("click", ".btn_editbarang", function (e) {
    var id = $(this).data("id");
    var name = $(this).data("name");
    var description = $(this).data("description");
    var minimum = $(this).data("minimum");
    var stok_awal = $(this).data("stok_awal");

    var satuan_id = $(this).data("satuan_id");
    var image = $(this).data("image");

    console.log(id, name, description, minimum, stok_awal, satuan_id, image);

    $("#txtid").val(id);
    $("#txtname").val(name);
    $("#txtdescription").val(description);
    $("#txtminimum").val(minimum);
    $("#txtstok_awal").val(stok_awal);
    $("#txtsatuan_id").val(satuan_id);

    if (image && image !== 'NULL') {
        $("#previewGambar")
            .show();
        $("#previewImage")
            .attr("src", "/" + image) // pastikan path benar, misal "upload/barang/xxx.jpg"
            .show();
    } else {
        $("#previewGambar")
            .hide();
        $("#previewImage").hide();
    }

    $("#editBarangModal").modal("show");
});

///////////////////////////////////////////////

$(document).on("click", "#barangModal2", function (e) {
    $("#barangModal2").modal("show");
});



//////////////////////////////////////////////

$(document).on("click", ".btn_editsatuanbarang", function (e) {
    var id = $(this).data("id");
    var name = $(this).data("name");

    console.log(id, name);

    $("#txtid").val(id);
    $("#txtname").val(name);

    $("#editBarangModal").modal("toggle");
});

/////////////////////////////////////////////

///////////////////////////////////////////////

$(document).on("click", ".btn_editsatuanbahan", function (e) {
    var id = $(this).data("id");
    var name = $(this).data("name");

    console.log(id, name);

    $("#txtid").val(id);
    $("#txtname").val(name);

    $("#editBarangModal").modal("toggle");
});

/////////////////////////////////////////////

$(document).on("click", ".btnTambahStok", function () {
    var id = $(this).data("id");
    var name = $(this).data("name");
    var satuan = $(this).data("satuan");

    console.log(id, name, satuan);

    $("#stokBarangIdM").val(id);
    $("#stokBarangNameM").val(name);
    $("#stokBarangSatuanM").val(satuan);
});

$(document).on("click", ".btnKurangStok", function () {
    var id = $(this).data("id");
    var name = $(this).data("name");
    var satuan = $(this).data("satuan");

    console.log(id, name, satuan);

    $("#stokBarangIdK").val(id);
    $("#stokBarangNameK").val(name);
    $("#stokBarangSatuanK").val(satuan);
});

///////////////////////////////////////////////

$(document).on("click", ".btn_editbahan", function (e) {
    var id = $(this).data("id");
    var name = $(this).data("name");
    var description = $(this).data("description");
    var minimum = $(this).data("minimum");
    var satuan_id = $(this).data("satuan_id");
    var image = $(this).data("image");

    if (!description || description.trim() === "") {
        description = "-";
    }

    console.log(id, name, description, minimum, satuan_id, image);

    var formattedMinimum = minimum % 1 === 0 ? parseInt(minimum) : minimum;

    $("#txtid").val(id);
    $("#txtname").val(name);
    $("#txtdescription").val(description);
    $("#txtminimum").val(formattedMinimum);
    $("#txtsatuan_id").val(satuan_id);

    if (image && image !== 'NULL') {
        $("#previewGambar")
            .show();
        $("#previewImage")
            .attr("src", "/" + image) // pastikan path benar, misal "upload/bahan/xxx.jpg"
            .show();
    } else {
        $("#previewGambar")
            .hide();
        $("#previewImage").hide();
    }

    $("#editBarangModal").modal("toggle");
});

/////////////////////////////////////////

$(document).on("click", ".btn_editbahan2", function (e) {
    var id2 = $(this).data("id");
    var name2 = $(this).data("name");
    var description2 = $(this).data("description");
    var minimum2 = $(this).data("minimum");
    var satuan_id2 = $(this).data("satuan_id");
    var image2 = $(this).data("image");

    if (!description2 || description2.trim() === "") {
        description2 = "-";
    }

    console.log(id2, name2, description2, minimum2, satuan_id2, image2);

    var formattedMinimum2 = minimum2 % 1 === 0 ? parseInt(minimum2) : minimum2;

    $("#txtid2").val(id2);
    $("#txtname2").val(name2);
    $("#txtdescription2").val(description2);
    $("#txtminimum2").val(formattedMinimum2);
    $("#txtsatuan_id2").val(satuan_id2);

    if (image2 && image2 !== 'NULL') {
        $("#previewGambar2")
            .show();
        $("#previewImage2")
            .attr("src", "/" + image2) // pastikan path benar, misal "upload/bahan/xxx.jpg"
            .show();
    } else {
        $("#previewGambar2")
            .hide();
        $("#previewImage2").hide();
    }

    $("#editBarangModal2").modal("toggle");
});

///////////////////////////////////////////////////

document
    .querySelectorAll('input[type="number"].number0')
    .forEach(function (input) {
        input.addEventListener("focusout", function () {
            if (this.value.trim() === "") {
                this.value = "0";
            }
        });
    });

document.querySelectorAll(".number0").forEach(function (inputField) {
    inputField.addEventListener("focus", function () {
        this.select();
    });
});

///////////////////////////////////////////////

$(document).ready(function () {
    const bahanOptionsHtml = $("#bahanOptions select").html();

    function renderBahanRow(
        index,
        selectedBahanId = "",
        jumlah = "",
        satuan = ""
    ) {
        const bahanOptionsTemplate = document.querySelector(
            "#bahanOptions select"
        );
        const bahanSelect = bahanOptionsTemplate.cloneNode(true);
        bahanSelect.name = `bahan[${index}][id]`;
        bahanSelect.classList.add("bahan-dropdown");

        if (selectedBahanId) {
            Array.from(bahanSelect.options).forEach((option) => {
                if (option.value == selectedBahanId) {
                    option.selected = true;
                }
            });
        }

        function formatJumlah(jumlah) {
            if (!jumlah) return "";
            const num = parseFloat(jumlah);
            return Number.isInteger(num)
                ? num.toString()
                : num.toFixed(3).replace(/\.?0+$/, "");
        }

        const jumlahInput = document.createElement("input");
        jumlahInput.type = "number";
        jumlahInput.name = `bahan[${index}][jumlah]`;
        jumlahInput.placeholder = "Jumlah";
        jumlahInput.required = true;
        jumlahInput.step = "0.001";
        jumlahInput.className = "form-control";
        jumlahInput.value = formatJumlah(jumlah);

        const satuanInput = document.createElement("input");
        satuanInput.type = "text";
        satuanInput.name = `bahan[${index}][satuan]`;
        satuanInput.placeholder = "Satuan";
        satuanInput.className = "form-control satuan-input";
        satuanInput.required = true;
        satuanInput.disabled = true;
        satuanInput.value = satuan;

        const removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.className = "btn btn-danger removeBahan";
        removeBtn.textContent = "-";

        const row = document.createElement("div");
        row.className = "input-group mb-2 bahan-item";
        row.appendChild(bahanSelect);
        row.appendChild(jumlahInput);
        row.appendChild(satuanInput);
        row.appendChild(removeBtn);

        return row;
    }

    function refreshSatuan($container) {
        $container.on("change", ".bahan-dropdown", function () {
            const satuan = $(this).find("option:selected").data("satuan") || "";
            $(this).closest(".bahan-item").find(".satuan-input").val(satuan);
        });

        $container.on("click", ".removeBahan", function () {
            $(this).closest(".bahan-item").remove();
        });
    }

    $(".btn_editmenu").on("click", function () {
        const id = $(this).data("id");
        const name = $(this).data("name");
        const description = $(this).data("description");
        const image = $(this).data("image");
        let komposisi = $(this).data("komposisi");

        if (typeof komposisi === "string") komposisi = JSON.parse(komposisi);

        $("#editMenuForm").attr("action", "/daftar-menu/" + id);
        $("#editMenuId").val(id);
        $("#editMenuName").val(name);
        $("#editMenuDescription").val(description);

        if (image && image !== 'NULL') {
            $("#previewGambar")
                .show();
            $("#previewImage")
                .attr("src", "/" + image) // pastikan path benar, misal "upload/bahan/xxx.jpg"
                .show();
        } else {
            $("#previewGambar")
                .hide();
            $("#previewImage").hide();
        }

        const container = $("#editBahanContainer");
        container.empty();

        komposisi.forEach((item, index) => {
            const selectedBahanId = item.bahan_id;
            const jumlah = item.jumlah;
            const satuan = item.bahan?.satuan?.name || "";

            const row = renderBahanRow(index, selectedBahanId, jumlah, satuan);
            container.append(row);

            $(row)
                .find("select")
                .select2({
                    placeholder: "Cari bahan...",
                    allowClear: true,
                    dropdownParent: $("#editBarangModal"),
                });
        });

        $("#editBarangModal").modal("show");
    });

    function appendBahanRowWithSelect2(container, index, dropdownParent) {
        const row = renderBahanRow(index);
        container.append(row);
        $(row).find("select").select2({
            placeholder: "Cari bahan...",
            allowClear: true,
            dropdownParent: dropdownParent,
        });
    }

    $("#addBahan").on("click", function () {
        const container = $("#bahanContainer");
        const index = container.find(".bahan-item").length;
        appendBahanRowWithSelect2(container, index, $("#bahanContainer"));
    });

    $("#addEditBahan").on("click", function () {
        const container = $("#editBahanContainer");
        const index = container.find(".bahan-item").length;
        appendBahanRowWithSelect2(container, index, $("#editBarangModal"));
    });

    refreshSatuan($("#bahanContainer"));
    refreshSatuan($("#editBahanContainer"));
});

////////////////////////////////////////////////////////

$(document).on("click", ".btn_edittransaksi", function () {
    var id = $(this).data("id");
    var date = $(this).data("date");
    var jumlah = $(this).data("jumlah");
    var menuName = $(this).data("menu-name");
    var menu_id = $(this).data("menu-id");

    // Debugging: Cek nilai dari menu_id
    console.log("menu_id:", menu_id);

    $("#txtid").val(id);
    $("#txtdate").val(date);
    $("#txtname").val(menuName);
    $("#txtjumlahMenu").val(jumlah);
    $("#txtmenuId").val(menu_id);

    // Debugging: Pastikan nilai sudah di-set di input
    console.log("Hidden menu_id input value:", $("#txtmenuId").val());

    // Set action URL for the form
    $("#editBarangForm").attr("action", "/transaksi/updateTransaksi/" + id);

    // Show modal
    $("#editBarangModal").modal("show");
});

/////////////////////////////////////////////////////////

$(document).ready(function () {
    const bahanOptionsTemplate = document.querySelector("#bahanOptions select");

    function renderBahanAwalRow(index) {
        const bahanSelect = bahanOptionsTemplate.cloneNode(true);
        bahanSelect.name = `bahan_awal[${index}][bahan_id]`;
        bahanSelect.classList.add("form-select", "bahan-dropdown");

        const jumlahInput = document.createElement("input");
        jumlahInput.type = "number";
        jumlahInput.name = `bahan_awal[${index}][jumlah]`;
        jumlahInput.placeholder = "Jumlah";
        jumlahInput.required = true;
        jumlahInput.step = "0.001";
        jumlahInput.min = "0";
        jumlahInput.max = "99999999999.999";
        jumlahInput.className = "form-control mx-2";
        jumlahInput.style.maxWidth = "120px";

        const satuanInput = document.createElement("input");
        satuanInput.type = "text";
        satuanInput.placeholder = "Satuan";
        satuanInput.className = "form-control satuan-input";
        satuanInput.disabled = true;

        const removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.className = "btn btn-danger removeBahanAwal";
        removeBtn.textContent = "-";

        const row = document.createElement("div");
        row.className = "input-group mb-2 bahan-item";
        row.appendChild(bahanSelect);
        row.appendChild(jumlahInput);
        row.appendChild(satuanInput);
        row.appendChild(removeBtn);

        return row;
    }

    function refreshEventListeners($container) {
        $container.on("change", ".bahan-dropdown", function () {
            const satuan = $(this).find("option:selected").data("satuan") || "";
            $(this).closest(".bahan-item").find(".satuan-input").val(satuan);
        });

        $container.on("click", ".removeBahanAwal", function () {
            $(this).closest(".bahan-item").remove();
        });
    }

    $("#addBahanAwal").on("click", function () {
        const container = $("#bahanAwalContainer");
        const index = container.find(".bahan-item").length;
        container.append(renderBahanAwalRow(index));
    });

    refreshEventListeners($("#bahanAwalContainer"));
});

////////////////////////////////////////////////////////////

$("#barangModal").on("shown.bs.modal", function () {
    const menuSelect = document.getElementById("menu_id");
    const jumlahInput = document.getElementById("jumlahMenu");
    const komposisiPreview = document.getElementById("komposisiPreview");

    function formatJumlah(jumlah) {
        return jumlah % 1 === 0 ? jumlah : parseFloat(jumlah.toFixed(3));
    }

    function updateKomposisi() {
        const selectedOption = menuSelect.options[menuSelect.selectedIndex];
        const komposisiData = selectedOption.getAttribute("data-komposisi");
        const jumlahPesanan = parseInt(jumlahInput.value) || 0;

        komposisiPreview.innerHTML = "";

        if (komposisiData) {
            try {
                const komposisi = JSON.parse(komposisiData);
                komposisi.forEach((item) => {
                    const totalJumlah = item.jumlah * jumlahPesanan;
                    const li = document.createElement("li");
                    li.textContent = `${item.bahan.name} - ${formatJumlah(
                        totalJumlah
                    )} ${item.bahan.satuan.name}`;
                    komposisiPreview.appendChild(li);
                });
            } catch (error) {
                console.error("Gagal parse komposisi:", error);
            }
        }
    }

    $(menuSelect).on("change", updateKomposisi);
    jumlahInput.addEventListener("input", updateKomposisi);

    updateKomposisi();
});
