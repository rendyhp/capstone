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
        "/barang/master",
        "/barang/masuk-keluar",
        "/barang/data-barang",
        "/barang/satuan",
        "/barang/history",
        "/bahan/master",
        "/bahan/masuk-keluar",
        "/bahan/data-bahan",
        "/bahan/bahan-awal",
        "/bahan/satuan",
        "/bahan/history",

        "/stock-opname",
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
    ["/admin-only/log", "/admin-only/user-data"],
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

///////////////////////////////////////////

$(document).ready(function () {
    $(".select2").select2({
        placeholder: "Cari atau pilih satuan",
        allowClear: true,
    });
    $(document).on("click", ".btn_editbahan", function () {
        var satuan_id = $(this).data("satuan_id");
        $("#satuan_id").val(satuan_id).trigger("change");
    });
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
    var jumlah = $(this).data("jumlah");
    var satuan_id = $(this).data("satuan_id");
    var image = $(this).data("image");

    console.log(id, name, description, jumlah, satuan_id, image);

    var formattedJumlah = jumlah % 1 === 0 ? parseInt(jumlah) : jumlah;

    $("#txtid").val(id);
    $("#txtname").val(name);
    $("#txtdescription").val(description);
    $("#txtjumlah").val(formattedJumlah);
    $("#txtsatuan_id").val(satuan_id);

    if (image) {
        $("#previewImage")
            .attr("src", "/storage/" + image)
            .show();
    } else {
        $("#previewImage").hide();
    }

    $("#editBarangModal").modal("toggle");
});

///////////////////////////////////////////////

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

    console.log(id, name);

    $("#stokBarangIdM").val(id);
    $("#stokBarangNameM").val(name);
    $("#editBarangModal").modal("toggle");
});

$(document).on("click", ".btnKurangStok", function () {
    var id = $(this).data("id");
    var name = $(this).data("name");

    console.log(id, name);

    $("#stokBarangIdK").val(id);
    $("#stokBarangNameK").val(name);

    $("#editBarangModal").modal("toggle");
});

///////////////////////////////////////////////

$(document).on("click", ".btn_editbahan", function (e) {
    var id = $(this).data("id");
    var name = $(this).data("name");
    var description = $(this).data("description");
    var minimum = $(this).data("minimum");
    var satuan_id = $(this).data("satuan_id");

    if (!description || description.trim() === "") {
        description = "-";
    }

    console.log(id, name, description, minimum, satuan_id);

    var formattedMinimum = minimum % 1 === 0 ? parseInt(minimum) : minimum;

    $("#txtid").val(id);
    $("#txtname").val(name);
    $("#txtdescription").val(description);
    $("#txtminimum").val(formattedMinimum);
    $("#txtsatuan_id").val(satuan_id);

    $("#editBarangModal").modal("toggle");
});

////////////////////////////////////////////////

$(document).on("click", ".btn_editstokbahan", function (e) {
    var id = $(this).data("id");
    var date = $(this).data("date");
    var jumlah = $(this).data("jumlah");
    var satuan_name = $(this).data("satuan_name");

    console.log(id, date, jumlah, satuan_name);

    var formattedJumlah = jumlah % 1 === 0 ? parseInt(jumlah) : jumlah;

    $("#txtid").val(id);
    $("#txtdate").val(date);
    $("#txtjumlah").val(formattedJumlah);

    $("#txtsatuan_name").val(satuan_name);

    $("#editBarangModal").modal("toggle");
});

////////////////////////////////////////////////////

$(document).on("click", ".btn_editbahan_akhir", function (e) {
    var id = $(this).data("id");
    var date = $(this).data("date");
    var bahan_id = $(this).data("bahan_id");
    var jumlah = $(this).data("jumlah");

    console.log(id, name, description, minimum, satuan_id);
    var formattedJumlah = jumlah % 1 === 0 ? parseInt(jumlah) : jumlah;

    $("#txtid").val(id);
    $("#txtdate").val(date);
    $("#txtbahan_id").val(bahan_id);
    $("#txtjumlah").val(formattedJumlah);

    $("#editBarangModal").modal("toggle");
});

///////////////////////////////////////////////////

function toggleInput(inputId, buttonId) {
    let inputField = document.getElementById(inputId);
    let button = document.getElementById(buttonId);

    if (inputField.readOnly) {
        inputField.readOnly = false;

        button.style.display = "none";
        inputField.focus();
        inputField.select();

        inputField.addEventListener("focusout", function lockInput() {
            inputField.readOnly = true;
            button.style.display = "inline";
            inputField.removeEventListener("focusout", lockInput);
        });
    }
}

document.getElementById("toggleMinimum").addEventListener("click", function () {
    toggleInput("minimum", "toggleMinimum");
});

document
    .getElementById("toggleMinimum2")
    .addEventListener("click", function () {
        toggleInput("txtminimum", "toggleMinimum2");
    });

////////////////////////////////////////////////

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

    $("#addBahan").on("click", function () {
        const container = $("#bahanContainer");
        const index = container.find(".bahan-item").length;
        container.append(renderBahanRow(index));
    });

    $(".btn_editmenu").on("click", function () {
        const id = $(this).data("id");
        const name = $(this).data("name");
        const description = $(this).data("description");
        let komposisi = $(this).data("komposisi");

        if (typeof komposisi === "string") komposisi = JSON.parse(komposisi);
        $("#editMenuForm").attr("action", "/daftar-menu/" + id);
        $("#editMenuId").val(id);
        $("#editMenuName").val(name);
        $("#editMenuDescription").val(description);

        const container = $("#editBahanContainer");
        container.empty();

        komposisi.forEach((item, index) => {
            const selectedBahanId = item.bahan_id;
            const jumlah = item.jumlah;
            const satuan = item.bahan?.satuan?.name || "";

            const row = renderBahanRow(index, selectedBahanId, jumlah, satuan);
            container.append(row);
        });

        $("#editBarangModal").modal("show");
    });

    $("#addEditBahan").on("click", function () {
        const container = $("#editBahanContainer");
        const index = container.find(".bahan-item").length;
        container.append(renderBahanRow(index));
    });

    refreshSatuan($("#bahanContainer"));
    refreshSatuan($("#editBahanContainer"));
});

////////////////////////////////////////////////////////

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

$(document).ready(function () {
    const bahanOptionsTemplate = document.querySelector("#bahanOptions select");

    function renderBahanAkhirRow(index) {
        const bahanSelect = bahanOptionsTemplate.cloneNode(true);
        bahanSelect.name = `bahan_akhir[${index}][bahan_id]`;
        bahanSelect.classList.add("form-select", "bahan-dropdown");

        const jumlahInput = document.createElement("input");
        jumlahInput.type = "number";
        jumlahInput.name = `bahan_akhir[${index}][jumlah]`;
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
        removeBtn.className = "btn btn-danger removeBahanAkhir";
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

        $container.on("click", ".removeBahanAkhir", function () {
            $(this).closest(".bahan-item").remove();
        });
    }

    $("#addBahanAkhir").on("click", function () {
        const container = $("#bahanAkhirContainer");
        const index = container.find(".bahan-item").length;
        container.append(renderBahanAkhirRow(index));
    });

    refreshEventListeners($("#bahanAkhirContainer"));
});

////////////////////////////////////////////

$(document).on("click", ".btn_editbahan_akhir", function () {
    var bahanId = $(this).data("id");
    var modal = $("#editBarangModal");

    $("#editBahanAkhirId").val(bahanId);

    $.ajax({
        url: "/your-endpoint/" + bahanId,
        method: "GET",
        success: function (data) {
            $("#editDate").val(data.date);
            $("#editBahanAkhirContainer").empty();

            data.bahans.forEach(function (bahan) {
                var bahanHtml = `
                    <div class="bahan-row">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Bahan</label>
                            <select class="form-select bahan-select" data-id="${bahan.id}" name="bahans[]">
                                <option value="${bahan.id}" selected>${bahan.name}</option>
                            </select>
                            <label class="form-label text-dark fw-bold">Jumlah</label>
                            <input type="number" class="form-control bahan-quantity" name="quantities[]" value="${bahan.quantity}" required>
                            <input type="hidden" name="bahanIds[]" value="${bahan.id}">
                        </div>
                    </div>
                `;
                $("#editBahanAkhirContainer").append(bahanHtml);
            });
        },
        error: function () {
            alert("Error loading bahan data.");
        },
    });

    modal.modal("show");
});

$("#addEditBahanAkhir").click(function () {
    var newRow = `
        <div class="bahan-row">
            <div class="mb-3">
                <label class="form-label text-dark fw-bold">Bahan</label>
                <select class="form-select bahan-select" name="bahans[]">
                    
                </select>
                <label class="form-label text-dark fw-bold">Jumlah</label>
                <input type="number" class="form-control bahan-quantity" name="quantities[]" required>
            </div>
        </div>
    `;
    $("#editBahanAkhirContainer").append(newRow);
});

$("#editBahanAkhir").submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        url: "/your-endpoint/" + $("#editBahanAkhirId").val(),
        method: "PUT",
        data: formData,
        success: function () {
            alert("Bahan Akhir successfully updated.");
            $("#editBarangModal").modal("hide");
        },
        error: function () {
            alert("Error saving Bahan Akhir.");
        },
    });
});

//////////////////////////////////////////////////

document.querySelectorAll(".toggle-jumlah").forEach(function (button) {
    button.addEventListener("click", function () {
        let inputField = this.parentElement.querySelector(".jumlah-input");
        let editButton = this.parentElement.querySelector(".toggle-jumlah");

        if (inputField.readOnly) {
            inputField.readOnly = false;
            editButton.style.display = "none";
            inputField.focus();
            inputField.select();

            inputField.addEventListener("focusout", function lockInput() {
                inputField.readOnly = true;
                editButton.style.display = "inline";
                inputField.removeEventListener("focusout", lockInput);
            });
        }
    });
});

//////////////////////////////////////////////////

function updateSubmitButton() {
    const submitBtn = document.getElementById("submitBtn");
    const allConfirmed = [
        ...document.querySelectorAll(".btn-konfirmasi"),
    ].every((button) => button.classList.contains("btn-success"));

    if (allConfirmed) {
        submitBtn.disabled = false;
        submitBtn.classList.remove("btn-danger");
        submitBtn.classList.add("btn-primary");
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove("btn-primary");
        submitBtn.classList.add("btn-danger");
    }
}

document.querySelectorAll(".btn-konfirmasi").forEach(function (button) {
    button.addEventListener("click", function () {
        let row = this.closest("tr");
        let editButton = row.querySelector(".toggle-jumlah");

        if (this.classList.contains("btn-primary")) {
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            this.disabled = true;

            setTimeout(() => {
                this.innerHTML = '<i class="fa fa-check"></i>';
                this.classList.remove("btn-primary");
                this.classList.add("btn-success");
                this.disabled = false;
                if (editButton) editButton.style.display = "none";
                updateSubmitButton();
            }, 500);
        } else {
            this.innerHTML = "Konfirmasi";
            this.classList.remove("btn-success");
            this.classList.add("btn-primary");
            if (editButton) editButton.style.display = "inline-block";
            updateSubmitButton();
        }
    });
});

document.querySelectorAll(".toggle-jumlah").forEach(function (editButton) {
    editButton.addEventListener("click", function () {
        let inputField = this.previousElementSibling;

        if (inputField.readOnly) {
            inputField.readOnly = false;
            inputField.focus();
            inputField.select();

            inputField.addEventListener("focusout", function lockInput() {
                inputField.readOnly = true;
                inputField.removeEventListener("focusout", lockInput);
            });
        }
    });
});

updateSubmitButton();

////////////////////////////////////////////////////

const menuSelect = document.getElementById("menu_id");
const jumlahInput = document.getElementById("jumlah");
const komposisiPreview = document.getElementById("komposisiPreview");

function formatJumlah(jumlah) {
    return jumlah % 1 === 0 ? jumlah : parseFloat(jumlah.toFixed(3));
}

function updateKomposisi() {
    const selectedOption = menuSelect.options[menuSelect.selectedIndex];
    const komposisiData = selectedOption.getAttribute("data-komposisi");
    const jumlahPesanan = parseInt(jumlahInput.value) || 1;

    komposisiPreview.innerHTML = "";

    if (komposisiData) {
        const komposisi = JSON.parse(komposisiData);
        komposisi.forEach((item) => {
            const totalJumlah = item.jumlah * jumlahPesanan;
            const li = document.createElement("li");
            li.textContent = `${item.bahan.name} - ${formatJumlah(
                totalJumlah
            )} ${item.bahan.satuan.name}`;
            komposisiPreview.appendChild(li);
        });
    }
}

menuSelect.addEventListener("change", updateKomposisi);
jumlahInput.addEventListener("input", updateKomposisi);

//////////////////////////////////////////////////////////


    


/////////////////////////////////////////////////
