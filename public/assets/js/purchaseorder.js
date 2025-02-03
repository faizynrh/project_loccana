document.addEventListener("DOMContentLoaded", function () {
    // Toggle Term Pembayaran Lainnya
    const paymentSelect = document.getElementById("pembayaran");
    const termLainContainer = document.getElementById("term-lainnya-container");

    paymentSelect.addEventListener("change", function () {
        termLainContainer.classList.toggle("hidden", this.value !== "lainnya");
    });

    // Function to check if all required inputs are filled
    function areInputsFilled(row) {
        const qty = parseFloat(
            row.querySelector("td:nth-child(3) input").value
        );
        const price = parseFloat(
            row.querySelector("td:nth-child(4) input").value
        );
        const discount = parseFloat(
            row.querySelector("td:nth-child(5) input").value
        );

        return !isNaN(qty) && !isNaN(price) && !isNaN(discount);
    }

    // Function to calculate row total
    function calculateRowTotal(row) {
        const totalInput = row.querySelector("td:nth-child(6) input");

        if (!areInputsFilled(row)) {
            totalInput.value = "0.00";
            totalInput.setAttribute("readonly", "true");
            return;
        }

        const qty = parseFloat(
            row.querySelector("td:nth-child(3) input").value
        );
        const price = parseFloat(
            row.querySelector("td:nth-child(4) input").value
        );
        const discount = parseFloat(
            row.querySelector("td:nth-child(5) input").value
        );

        const total = qty * price * (1 - discount / 100);
        totalInput.value = total.toFixed(2);
        totalInput.removeAttribute("readonly");

        calculateGrandTotal();
    }

    // Function to calculate grand total
    function calculateGrandTotal() {
        const rows = document.querySelectorAll(
            "#tableBody tr:not(:last-child)"
        );
        let subTotal = 0;

        rows.forEach((row) => {
            const total =
                parseFloat(row.querySelector("td:nth-child(6) input").value) ||
                0;
            subTotal += total;
        });

        // Update summary rows
        document.querySelector("tr.fw-bold td:nth-child(6)").style.textAlign =
            "right";
        document.querySelector("tr.fw-bold td:nth-child(6)").textContent =
            subTotal.toFixed(2);
    }

    function findItemPrice(itemCode) {
        const item = window.itemsData?.find(
            (item) => item.item_code === itemCode
        );
        return item ? item.price : 0;
    }

    function createNewRow(item = null) {
        const newRow = document.createElement("tr");
        newRow.style.borderBottom = "2px solid #000";

        const itemOptions = window.itemsData
            .map(
                (item) =>
                    `@foreach ($items as $item)
                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                    @endforeach`
            )
            .join("");

        newRow.innerHTML = `
            <td>
                <select class="form-select item-select">
                    <option value="" disabled selected>--Pilih Item--</option>
                    ${itemOptions}
                </select>
            </td>
            <td>
            </td>
            <td><input type="text" class="form-control qty-input" value="0"></td>
            <td><input type="text" class="form-control price-input" value="0"></td>
            <td><input type="text" class="form-control discount-input" value="0"></td>
            <td><input type="text" class="form-control bg-body-secondary total-input" value="0"></td>
            <td class="text-center">
                <button class="btn btn-danger fw-bold remove-row">-</button>
            </td>
        `;

        // Add event listeners to the new row
        const select = newRow.querySelector(".item-select");
        const qtyInput = newRow.querySelector(".qty-input");
        const priceInput = newRow.querySelector(".price-input");
        const discountInput = newRow.querySelector(".discount-input");
        const totalInput = newRow.querySelector(".total-input");

        // Handle item selection
        select.addEventListener("change", function () {
            const selectedOption = this.value;
            const price = findItemPrice(selectedOption);
            priceInput.value = price;
            calculateRowTotal(newRow);
        });

        // Handle quantity changes
        qtyInput.addEventListener("input", function () {
            calculateRowTotal(newRow);
        });

        // Handle price changes
        priceInput.addEventListener("input", function () {
            calculateRowTotal(newRow);
        });

        // Handle discount changes
        discountInput.addEventListener("input", function () {
            calculateRowTotal(newRow);
        });

        // Handle total input
        totalInput.addEventListener("input", function () {
            if (areInputsFilled(newRow)) {
                calculateGrandTotal();
            }
        });

        return newRow;
    }

    // Add click handler for the table
    document
        .getElementById("tableBody")
        .addEventListener("click", function (e) {
            const tableBody = this;

            if (
                e.target.classList.contains("btn-primary") &&
                e.target.innerText === "+"
            ) {
                e.preventDefault();

                // Only create new row if we have API data
                if (window.itemsData && window.itemsData.length > 0) {
                    const newRow = createNewRow();
                    const buttonRow = e.target.closest("tr");
                    tableBody.insertBefore(newRow, buttonRow);
                    updateRemoveButtons();
                } else {
                    Swal.fire(
                        "Error",
                        "No item data available. Please select a partner first.",
                        "error"
                    );
                }
            }

            if (e.target.classList.contains("remove-row")) {
                e.target.closest("tr").remove();
                updateRemoveButtons();
                calculateGrandTotal();
            }
        });

    // Function to update remove buttons visibility
    function updateRemoveButtons() {
        const tableBody = document.getElementById("tableBody");
        const dataRows = Array.from(
            tableBody.getElementsByTagName("tr")
        ).filter((row) => !row.querySelector("button.btn-primary"));

        dataRows.forEach((row, index) => {
            const removeButton = row.querySelector(".remove-row");
            if (removeButton) {
                removeButton.style.display =
                    dataRows.length === 1 ? "none" : "block";
            }
        });
    }

    // AJAX handler for partner selection
    $("#partner_id").on("change", function () {
        const poId = $(this).val();
        if (poId) {
            $.ajax({
                url: "/purchase_order/detailspurchase/" + poId,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.error) {
                        Swal.fire("Error", response.error, "error");
                        return;
                    }

                    // Store items data globally
                    window.itemsData = response.items || [];

                    // Fill header data
                    $("#po_code").val(response.code);
                    $("#order_date").val(response.order_date);
                    $("#address").val(response.address);
                    $("#description").val(response.description);
                    $("#ppn").val(response.ppn);
                    $("#fax").val(response.fax);
                    $("#phone").val(response.phone);

                    const tableBody = $("#tableBody");
                    tableBody.empty();

                    // Create item options HTML
                    const itemOptions = window.itemsData
                        .map(
                            (item) =>
                                `@foreach ($items as $item)
                                    <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                @endforeach`
                        )
                        .join("");

                    // Create first row with all available items
                    const firstRow = `
                        <tr style="border-bottom: 2px solid #000;">
                            <td>
                                <select class="form-select item-select">
                                    <option value="" disabled selected>--Pilih Item--</option>
                                    ${itemOptions}
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm">Lainnya</button>
                            </td>
                            <td><input type="text" class="form-control qty-input" value="0"></td>
                            <td><input type="text" class="form-control price-input" value="0"></td>
                            <td><input type="text" class="form-control discount-input" value="0"></td>
                            <td><input type="text" class="form-control bg-body-secondary total-input" value="0"></td>
                            <td></td>
                        </tr>
                    `;

                    // Add the first row
                    tableBody.append(firstRow);

                    // Add the button row
                    const buttonRow = `
                        <tr style="border-bottom: 2px solid #000;">
                            <td colspan="6"></td>
                            <td class="text-center">
                                <button class="btn btn-primary fw-bold">+</button>
                            </td>
                        </tr>`;
                    tableBody.append(buttonRow);

                    // Add event listeners to the first row
                    const firstRowElement = tableBody.find("tr:first");
                    const select = firstRowElement.find(".item-select");
                    const qtyInput = firstRowElement.find(".qty-input");
                    const priceInput = firstRowElement.find(".price-input");
                    const discountInput =
                        firstRowElement.find(".discount-input");
                    const totalInput = firstRowElement.find(".total-input");

                    select.on("change", function () {
                        const selectedOption = this.value;
                        const price = findItemPrice(selectedOption);
                        priceInput.val(price);
                        calculateRowTotal(firstRowElement[0]);
                    });

                    qtyInput.on("input", function () {
                        calculateRowTotal(firstRowElement[0]);
                    });

                    priceInput.on("input", function () {
                        calculateRowTotal(firstRowElement[0]);
                    });

                    discountInput.on("input", function () {
                        calculateRowTotal(firstRowElement[0]);
                    });

                    totalInput.on("input", function () {
                        if (areInputsFilled(firstRowElement[0])) {
                            calculateGrandTotal();
                        }
                    });

                    updateRemoveButtons();
                    $("#rejectButton").show();
                },
                error: function () {
                    Swal.fire("Error", "Gagal mengambil data PO", "error");
                    $("#tableBody").empty();
                    $("#rejectButton").hide();
                },
            });
        }
    });
});
