const toggleSidebar = document.getElementById("toggleSidebar");
const sidebar = document.getElementById("sidebar");
const logo = document.getElementById("sidebar-logo");
const dashboardLink = document.getElementById("dashboard");

document
    .querySelectorAll('.nav-link[data-bs-toggle="collapse"]')
    .forEach((link) => {
        link.addEventListener("click", function (event) {
            document
                .querySelectorAll(".collapse.show")
                .forEach((openCollapse) => {
                    if (!openCollapse.contains(event.target)) {
                        openCollapse.classList.remove("show");
                    }
                });
        });
    });

toggleSidebar.addEventListener("click", () => {
    if (sidebar.style.width === "220px" || sidebar.style.width === "") {
        sidebar.style.width = "90px";
        logo.src = '/assets/images/logo.png';
        logo.style.width = "55px";

        const headersToHide = sidebar.querySelectorAll(
            'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"], a[href="#CashBankCollapse"], a[href="#AccountingCollapse"]'
        );
        headersToHide.forEach((header) => {
            header.innerHTML = header.innerHTML.replace(
                /Master Data|Procurement|Inventory|Penjualan|Cash Bank|Accounting/g,
                ""
            );
        });

        const collapseElements = sidebar.querySelectorAll(
            "#masterDataCollapse, #procurementCollapse, #inventoryCollapse, #PenjualanCollapse, #CashBankCollapse, #AccountingCollapse"
        );
        collapseElements.forEach((collapse) => {
            collapse.classList.remove("show");
        });

        dashboardLink.classList.add("small-text");
        dashboardLink.innerHTML = "Dashboard";
    } else {
        sidebar.style.width = "220px";
        logo.src = '/assets/images/name.png';

        logo.style.width = "165px";

        const headersToRestore = sidebar.querySelectorAll(
            'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"], a[href="#CashBankCollapse"], a[href="#AccountingCollapse"]'
        );
        headersToRestore.forEach((header) => {
            if (header.getAttribute("href") === "#masterDataCollapse") {
                header.innerHTML = header.innerHTML.includes("Master Data")
                    ? header.innerHTML
                    : header.innerHTML + " Master Data";
            } else if (header.getAttribute("href") === "#procurementCollapse") {
                header.innerHTML = header.innerHTML.includes("Procurement")
                    ? header.innerHTML
                    : header.innerHTML + " Procurement";
            } else if (header.getAttribute("href") === "#inventoryCollapse") {
                header.innerHTML = header.innerHTML.includes("Inventory")
                    ? header.innerHTML
                    : header.innerHTML + " Inventory";
            } else if (header.getAttribute("href") === "#PenjualanCollapse") {
                header.innerHTML = header.innerHTML.includes("Penjualan")
                    ? header.innerHTML
                    : header.innerHTML + " Penjualan";
            } else if (header.getAttribute("href") === "#CashBankCollapse") {
                header.innerHTML = header.innerHTML.includes("Cash Bank")
                    ? header.innerHTML
                    : header.innerHTML + " Cash Bank";
            } else if (header.getAttribute("href") === "#AccountingCollapse") {
                header.innerHTML = header.innerHTML.includes("Accounting")
                    ? header.innerHTML
                    : header.innerHTML + " Accounting";
            }
        });

        dashboardLink.classList.remove("small-text");
        dashboardLink.innerHTML = "Dashboard";
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const toggleSidebar = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");
    const logo = document.getElementById("sidebar-logo");
    const dashboardLink = document.getElementById("dashboard");
    let isCollapsed = false;

    // Function to handle submenu positioning
    function positionSubmenu(collapseElement, trigger) {
        if (!isCollapsed) return;

        const triggerRect = trigger.getBoundingClientRect();
        collapseElement.style.top = `${triggerRect.top}px`;
    }

    // Add event listeners for all collapse triggers
    document
        .querySelectorAll('.nav-link[data-bs-toggle="collapse"]')
        .forEach((link) => {
            const collapseId = link.getAttribute("href");
            const collapseElement = document.querySelector(collapseId);

            // Create a new Bootstrap collapse instance
            const collapse = new bootstrap.Collapse(collapseElement, {
                toggle: false,
            });

            link.addEventListener("click", function (event) {
                if (isCollapsed) {
                    event.preventDefault();
                    event.stopPropagation();

                    // Close other open submenus
                    document
                        .querySelectorAll(".collapse.show")
                        .forEach((openCollapse) => {
                            if (openCollapse !== collapseElement) {
                                bootstrap.Collapse.getInstance(
                                    openCollapse
                                )?.hide();
                            }
                        });

                    // Toggle current submenu
                    collapse.toggle();
                    positionSubmenu(collapseElement, this);
                }
            });
        });

    // Close submenus when clicking outside
    document.addEventListener("click", function (event) {
        if (isCollapsed && !sidebar.contains(event.target)) {
            document.querySelectorAll(".collapse.show").forEach((collapse) => {
                bootstrap.Collapse.getInstance(collapse)?.hide();
            });
        }
    });

    toggleSidebar.addEventListener("click", () => {
        isCollapsed = !isCollapsed;
        sidebar.classList.toggle("sidebar-collapsed");
        sidebar.classList.toggle("sidebar-expanded");

        if (isCollapsed) {
            // Collapse sidebar
            sidebar.style.width = "90px";
            // logo.src = '{{ asset('assets/images/logo.png') }}';
            logo.style.width = "55px";

            const headersToHide = sidebar.querySelectorAll(
                'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"], a[href="#CashBankCollapse"], a[href="#AccountingCollapse"]'
            );
            headersToHide.forEach((header) => {
                header.innerHTML = header.innerHTML.replace(
                    /Master Data|Procurement|Inventory|Penjualan|Cash Bank|Accounting/g,
                    ""
                );
            });

            // Close all open submenus
            document.querySelectorAll(".collapse.show").forEach((collapse) => {
                bootstrap.Collapse.getInstance(collapse)?.hide();
            });

            dashboardLink.classList.add("small-text");
            dashboardLink.innerHTML = "Dashboard";
        } else {
            // Expand sidebar
            sidebar.style.width = "220px";
            // logo.src = '{{ asset('assets/images/name.png') }}';
            logo.style.width = "165px";

            const headersToRestore = sidebar.querySelectorAll(
                'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"], a[href="#CashBankCollapse"], a[href="#AccountingCollapse"]'
            );
            headersToRestore.forEach((header) => {
                const href = header.getAttribute("href");
                const menuTexts = {
                    "#masterDataCollapse": "Master Data",
                    "#procurementCollapse": "Procurement",
                    "#inventoryCollapse": "Inventory",
                    "#PenjualanCollapse": "Penjualan",
                    "#CashBankCollapse": "Cash Bank",
                    "#AccountingCollapse": "Accounting",
                };

                if (
                    menuTexts[href] &&
                    !header.innerHTML.includes(menuTexts[href])
                ) {
                    header.innerHTML = header.innerHTML + " " + menuTexts[href];
                }
            });

            dashboardLink.classList.remove("small-text");
            dashboardLink.innerHTML = "Dashboard";
        }
    });

    // Initialize sidebar state
    sidebar.classList.add("sidebar-expanded");
});

// Add this JavaScript after your existing script
document.addEventListener("DOMContentLoaded", function () {
    let activePopup = null;
    let activeLink = null;

    // Create popup container
    const popupContainer = document.createElement("div");
    popupContainer.id = "submenu-popup";
    popupContainer.className = "submenu-popup";
    document.body.appendChild(popupContainer);

    // Handle submenu triggers
    const submenuTriggers = document.querySelectorAll(
        '.nav-link[data-bs-toggle="collapse"]'
    );

    submenuTriggers.forEach((trigger) => {
        const chevron = trigger.querySelector(".bi-chevron-down");
        const targetId = trigger.getAttribute("href").substring(1);
        const targetContent = document.getElementById(targetId);

        trigger.addEventListener("click", function (e) {
            if (sidebar.style.width === "90px") {
                e.preventDefault();
                e.stopPropagation();

                // Toggle chevron direction
                this.classList.toggle("collapsed");

                if (activePopup === targetId) {
                    // Hide popup if clicking the same trigger
                    popupContainer.classList.remove("show");
                    activePopup = null;
                    activeLink = null;
                } else {
                    // Show popup with new content
                    const rect = this.getBoundingClientRect();
                    popupContainer.style.top = `${rect.top}px`;

                    // Clone the collapse content
                    const content = targetContent
                        .querySelector(".nav")
                        .cloneNode(true);
                    popupContainer.innerHTML = "";
                    popupContainer.appendChild(content);

                    // Show popup
                    popupContainer.classList.add("show");
                    activePopup = targetId;
                    activeLink = this;

                    // Update links in popup to maintain functionality
                    popupContainer.querySelectorAll("a").forEach((link) => {
                        link.addEventListener("click", () => {
                            popupContainer.classList.remove("show");
                            activePopup = null;
                        });
                    });
                }
            } else {
                // Normal dropdown behavior when sidebar is expanded
                const isExpanded =
                    this.getAttribute("aria-expanded") === "true";
                this.classList.toggle("collapsed", !isExpanded);
            }
        });
    });

    // Close popup when clicking outside
    document.addEventListener("click", function (e) {
        if (
            activePopup &&
            !e.target.closest(".submenu-popup") &&
            !e.target.closest(".nav-link")
        ) {
            popupContainer.classList.remove("show");
            if (activeLink) {
                activeLink.classList.remove("collapsed");
            }
            activePopup = null;
            activeLink = null;
        }
    });

    // Update existing toggleSidebar event listener
    // Cek apakah elemen toggleSidebar ada
    if (toggleSidebar) {
        // Simpan fungsi onclick yang ada
        const existingToggleSidebar = toggleSidebar.onclick;

        // Tambahkan fungsionalitas baru saat klik
        toggleSidebar.onclick = function () {
            // Panggil fungsi toggle yang sudah ada
            if (existingToggleSidebar) {
                existingToggleSidebar.call(this);
            }

            // Sembunyikan popup jika muncul
            if (activePopup) {
                popupContainer.classList.remove("show");
                if (activeLink) {
                    activeLink.classList.remove("collapsed");
                }
                activePopup = null;
                activeLink = null;
            }

            // Reset semua chevrons (submenu)
            submenuTriggers.forEach((trigger) => {
                trigger.classList.remove("collapsed");
            });
        };
    } else {
        console.error("Element #toggleSidebar tidak ditemukan.");
    }
});

// Handle window resize
let resizeTimer;
window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
        if (activePopup) {
            const trigger = document.querySelector(`[href="#${activePopup}"]`);
            if (trigger) {
                const rect = trigger.getBoundingClientRect();
                popupContainer.style.top = `${rect.top}px`;
            }
        }
    }, 250);
});

document.addEventListener("DOMContentLoaded", function () {
    let activePopup = null;
    let activeLink = null;

    // Create popup container
    const popupContainer = document.createElement("div");
    popupContainer.id = "submenu-popup";
    popupContainer.className = "submenu-popup";
    document.body.appendChild(popupContainer);

    // Handle submenu triggers
    const submenuTriggers = document.querySelectorAll(
        '.nav-link[data-bs-toggle="collapse"]'
    );

    submenuTriggers.forEach((trigger) => {
        const chevron = trigger.querySelector(".bi-chevron-down");
        const targetId = trigger.getAttribute("href").substring(1);
        const targetContent = document.getElementById(targetId);

        trigger.addEventListener("click", function (e) {
            if (sidebar.style.width === "90px") {
                e.preventDefault();
                e.stopPropagation();

                // Remove Bootstrap's collapse handling when sidebar is collapsed
                const collapseInstance =
                    bootstrap.Collapse.getInstance(targetContent);
                if (collapseInstance) {
                    collapseInstance.dispose();
                }

                // Toggle chevron direction
                this.classList.toggle("collapsed");

                if (activePopup === targetId) {
                    // Hide popup if clicking the same trigger
                    popupContainer.classList.remove("show");
                    activePopup = null;
                    activeLink = null;
                } else {
                    // Hide previous popup if exists
                    if (activePopup) {
                        popupContainer.classList.remove("show");
                        if (activeLink) {
                            activeLink.classList.remove("collapsed");
                        }
                    }
                    // Show popup with new content
                    const rect = this.getBoundingClientRect();
                    popupContainer.style.top = `${rect.top}px`;

                    // Clone the collapse content
                    const content = targetContent
                        .querySelector(".nav")
                        .cloneNode(true);
                    popupContainer.innerHTML = "";
                    popupContainer.appendChild(content);

                    // Show popup
                    popupContainer.classList.add("show");
                    activePopup = targetId;
                    activeLink = this;

                    // Update links in popup to maintain functionality
                    popupContainer.querySelectorAll("a").forEach((link) => {
                        link.addEventListener("click", () => {
                            popupContainer.classList.remove("show");
                            activePopup = null;
                        });
                    });
                }
            } else {
                // Normal dropdown behavior when sidebar is expanded
                const isExpanded =
                    this.getAttribute("aria-expanded") === "true";
                this.classList.toggle("collapsed", !isExpanded);
            }
        });
    });

    // Close popup when clicking outside
    document.addEventListener("click", function (e) {
        if (
            activePopup &&
            !e.target.closest(".submenu-popup") &&
            !e.target.closest(".nav-link")
        ) {
            popupContainer.classList.remove("show");
            if (activeLink) {
                activeLink.classList.remove("collapsed");
            }
            activePopup = null;
            activeLink = null;
        }
    });

    // Handle sidebar toggle
    const existingToggleSidebar = toggleSidebar.onclick;
    toggleSidebar.onclick = function () {
        const wasCollapsed = sidebar.style.width === "90px";

        // Call existing toggle function
        existingToggleSidebar.call(this);

        // Hide popup if visible
        if (activePopup) {
            popupContainer.classList.remove("show");
            if (activeLink) {
                activeLink.classList.remove("collapsed");
            }
            activePopup = null;
            activeLink = null;
        }

        // Reset all chevrons when toggling sidebar
        submenuTriggers.forEach((trigger) => {
            trigger.classList.remove("collapsed");

            // Reinitialize Bootstrap collapse when expanding sidebar
            if (wasCollapsed) {
                const targetId = trigger.getAttribute("href").substring(1);
                const targetContent = document.getElementById(targetId);
                new bootstrap.Collapse(targetContent, {
                    toggle: false,
                });
            }
        });
    };

    // Handle window resize
    let resizeTimer;
    window.addEventListener("resize", function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (activePopup) {
                const trigger = document.querySelector(
                    `[href="#${activePopup}"]`
                );
                if (trigger) {
                    const rect = trigger.getBoundingClientRect();
                    popupContainer.style.top = `${rect.top}px`;
                }
            }
        }, 250);
    });
});
