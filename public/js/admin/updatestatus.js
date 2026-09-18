document.addEventListener('DOMContentLoaded', function () {
    const tableRows = document.querySelectorAll('.clickable-row');
    const receiptModalEl = document.getElementById('receiptModal');

    if (!receiptModalEl) return;

    const receiptModal = new bootstrap.Modal(receiptModalEl);
    const modalReceiptBody = document.getElementById('modalReceiptBody');

    tableRows.forEach(row => {
        row.addEventListener('click', function (e) {

            // Do not open receipt when clicking buttons, links, or action cells
            if (
                e.target.closest('.action-cell') ||
                e.target.closest('button') ||
                e.target.closest('a')
            ) {
                return;
            }

            const rawJson = this.getAttribute('data-order-json');

            if (!rawJson) {
                console.warn('No service order JSON found.');
                return;
            }

            try {
                const data = JSON.parse(rawJson);

                renderReceiptModal(data);

                receiptModal.show();

            } catch (err) {
                console.error('Error parsing service JSON data:', err);
            }
        });
    });


    // ============================================================
    // JSON PARSER
    // ============================================================

    function parseJsonData(value) {
        if (value === null || value === undefined || value === '') {
            return [];
        }

        if (typeof value === 'string') {
            try {
                let parsed = JSON.parse(value);

                // Handles JSON stored as a JSON string
                if (typeof parsed === 'string') {
                    try {
                        parsed = JSON.parse(parsed);
                    } catch (e) {
                        // Keep original parsed string
                    }
                }

                return parsed;

            } catch (e) {
                return value;
            }
        }

        return value;
    }


    // ============================================================
    // MONEY FORMATTER
    // ============================================================

    function formatPrice(price) {
        const amount = parseFloat(price);

        if (isNaN(amount)) {
            return '₱0.00';
        }

        return '₱' + amount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }


    // ============================================================
    // HTML ESCAPE
    // Prevents stored customer/service text from becoming HTML
    // ============================================================

    function escapeHtml(value) {
        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    // ============================================================
    // RENDER RECEIPT
    // ============================================================

    function renderReceiptModal(data) {

        // --------------------------------------------------------
        // CUSTOMER INFORMATION
        // --------------------------------------------------------

        const customerName =
            data.customer_name ||
            data.customer ||
            'N/A';

        const contactPhone =
            data.contact_number ||
            data.customer_phone ||
            data.phone_number ||
            data.phone ||
            'N/A';

        const trackingCode =
            data.tracking_code ||
            data.trackingCode ||
            'N/A';


        // --------------------------------------------------------
        // NORMALIZE VEHICLES
        // --------------------------------------------------------

        let vehicles = [];

        const parsedVehicles = parseJsonData(data.vehicles);

        if (Array.isArray(parsedVehicles) && parsedVehicles.length > 0) {

            vehicles = parsedVehicles;

        } else {

            // Fallback for single-vehicle records
            vehicles = [{
                plate_number:
                    data.plate_number ||
                    'N/A',

                vehicle_make:
                    data.vehicle_make ||
                    data.brand ||
                    '',

                vehicle_model:
                    data.vehicle_model ||
                    data.model ||
                    '',

                vehicle_type:
                    data.vehicle_type ||
                    data.type ||
                    '',

                vehicle_year:
                    data.vehicle_year ||
                    data.year ||
                    '',

                mechanic_assigned:
                    data.mechanic_assigned ||
                    'Unassigned',

                services:
                    data.services ||
                    data.selected_services ||
                    [],

                selected_services:
                    data.selected_services ||
                    [],

                selected_services_prices:
                    data.selected_services_prices ||
                    data.prices ||
                    {},

                price_adjustment_note:
                    data.price_adjustment_note ||
                    '',

                total_cost:
                    parseFloat(
                        data.total_cost ||
                        data.total_price ||
                        0
                    )
            }];
        }


        // --------------------------------------------------------
        // BUILD VEHICLE CARDS
        // --------------------------------------------------------

        let grandTotal = 0;
        let vehicleCardsHtml = '';


        vehicles.forEach((vehicle, index) => {

            const vehicleNumber = index + 1;

            const plate =
                vehicle.plate_number ||
                vehicle.plate ||
                'N/A';

            const brand =
                vehicle.vehicle_make ||
                vehicle.brand ||
                '';

            const model =
                vehicle.vehicle_model ||
                vehicle.model ||
                '';

            const vehicleType =
                vehicle.vehicle_type ||
                vehicle.type ||
                '';

            const vehicleYear =
                vehicle.vehicle_year ||
                vehicle.year ||
                '';

            const brandModel =
                `${brand} ${model}`.trim();

            const specs = [
                brandModel,
                vehicleType,
                vehicleYear
            ].filter(Boolean);

            const vehicleDetails =
                specs.length > 0
                    ? `(${specs.join(', ')})`
                    : '';

            const mechanic =
                vehicle.mechanic_assigned ||
                data.mechanic_assigned ||
                'Unassigned';

            const note =
                vehicle.price_adjustment_note ||
                data.price_adjustment_note ||
                '';


            // ----------------------------------------------------
            // SERVICE DATA
            // ----------------------------------------------------

            let serviceRowsHtml = '';
            let calculatedVehicleTotal = 0;

            /*
             * FIRST:
             * Try the NEW nested structure used by
             * register-service.blade.php
             *
             * vehicles[0][services][service_key]
             */

            let servicesData = parseJsonData(
                vehicle.services
            );


            // ----------------------------------------------------
            // NEW NESTED SERVICE STRUCTURE
            // ----------------------------------------------------

            if (
                servicesData &&
                typeof servicesData === 'object' &&
                !Array.isArray(servicesData)
            ) {

                Object.entries(servicesData).forEach(
                    ([serviceKey, serviceData]) => {

                        if (
                            !serviceData ||
                            typeof serviceData !== 'object'
                        ) {
                            return;
                        }


                        // Only display selected services
                        const isSelected =
                            serviceData.selected === true ||
                            serviceData.selected === 1 ||
                            serviceData.selected === '1';


                        if (!isSelected) {
                            return;
                        }


                        const serviceName =
                            serviceData.service_name ||
                            serviceData.name ||
                            formatServiceName(serviceKey);


                        // ------------------------------------------------
                        // SERVICE OPTIONS
                        // ------------------------------------------------

                        let options =
                            parseJsonData(
                                serviceData.options
                            );

                        if (!Array.isArray(options)) {
                            options = options ? [options] : [];
                        }


                        let serviceTotal = 0;


                        // ------------------------------------------------
                        // OPTIONS EXIST
                        // ------------------------------------------------

                        if (options.length > 0) {

                            options.forEach(option => {

                                let optionKey = '';
                                let optionName = '';
                                let optionPrice = 0;


                                if (
                                    typeof option === 'object' &&
                                    option !== null
                                ) {

                                    optionKey =
                                        option.key ||
                                        option.option_key ||
                                        option.value ||
                                        '';

                                    optionName =
                                        option.label ||
                                        option.name ||
                                        option.option_name ||
                                        optionKey;

                                    optionPrice =
                                        parseFloat(
                                            option.price ||
                                            option.cost ||
                                            0
                                        );

                                } else {

                                    optionKey = String(option);

                                    optionName =
                                        formatServiceName(
                                            optionKey
                                        );
                                }


                                /*
                                 * If option price wasn't stored directly,
                                 * try the service price structure.
                                 */
                                if (
                                    optionPrice === 0 &&
                                    serviceData.option_prices
                                ) {

                                    const optionPrices =
                                        parseJsonData(
                                            serviceData.option_prices
                                        );

                                    if (
                                        optionPrices &&
                                        typeof optionPrices === 'object'
                                    ) {

                                        const matchingKey =
                                            Object.keys(optionPrices)
                                                .find(key =>
                                                    key.trim().toLowerCase() ===
                                                    optionKey.trim().toLowerCase()
                                                );

                                        if (matchingKey !== undefined) {
                                            optionPrice =
                                                parseFloat(
                                                    optionPrices[matchingKey]
                                                ) || 0;
                                        }
                                    }
                                }


                                serviceTotal += optionPrice;


                                serviceRowsHtml += `
                                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom-subtle">
                                        <span class="text-secondary small">
                                            ${escapeHtml(optionName)}
                                        </span>

                                        <span class="fw-semibold text-primary small">
                                            ${formatPrice(optionPrice)}
                                        </span>
                                    </div>
                                `;
                            });


                            // ------------------------------------------------
                            // ADD SERVICE TOTAL
                            // ------------------------------------------------

                            calculatedVehicleTotal += serviceTotal;


                        } else {

                            // ------------------------------------------------
                            // FLAT SERVICE WITHOUT OPTIONS
                            // ------------------------------------------------

                            const servicePrice =
                                parseFloat(
                                    serviceData.price ||
                                    serviceData.cost ||
                                    0
                                ) || 0;

                            calculatedVehicleTotal += servicePrice;


                            serviceRowsHtml += `
                                <div class="d-flex justify-content-between align-items-center py-1 border-bottom-subtle">
                                    <span class="text-secondary small">
                                        ${escapeHtml(serviceName)}
                                    </span>

                                    <span class="fw-semibold text-primary small">
                                        ${formatPrice(servicePrice)}
                                    </span>
                                </div>
                            `;
                        }
                    }
                );
            }


            // ----------------------------------------------------
            // OLD / FLAT SERVICE STRUCTURE
            // ----------------------------------------------------

            else {

                let servicesArr = parseJsonData(
                    vehicle.selected_services ||
                    vehicle.services ||
                    data.selected_services ||
                    []
                );

                let pricesObj = parseJsonData(
                    vehicle.selected_services_prices ||
                    vehicle.prices ||
                    data.selected_services_prices ||
                    {}
                );


                if (!Array.isArray(servicesArr)) {
                    servicesArr = servicesArr
                        ? [servicesArr]
                        : [];
                }


                servicesArr.forEach((service, serviceIndex) => {

                    let serviceName = '';
                    let servicePrice = 0;


                    if (
                        typeof service === 'object' &&
                        service !== null
                    ) {

                        serviceName =
                            service.name ||
                            service.service_name ||
                            'Service Item';

                        servicePrice =
                            parseFloat(
                                service.price ||
                                service.cost ||
                                0
                            );

                    } else {

                        serviceName =
                            String(service).trim();


                        if (
                            pricesObj &&
                            typeof pricesObj === 'object'
                        ) {

                            // Exact case-insensitive match
                            const foundKey =
                                Object.keys(pricesObj)
                                    .find(key =>
                                        key.trim().toLowerCase() ===
                                        serviceName.toLowerCase()
                                    );


                            if (foundKey !== undefined) {

                                servicePrice =
                                    parseFloat(
                                        pricesObj[foundKey]
                                    ) || 0;

                            } else if (
                                Array.isArray(pricesObj) &&
                                pricesObj[serviceIndex] !== undefined
                            ) {

                                servicePrice =
                                    parseFloat(
                                        pricesObj[serviceIndex]
                                    ) || 0;

                            } else {

                                const priceValues =
                                    Object.values(pricesObj);

                                if (
                                    priceValues[serviceIndex] !== undefined
                                ) {
                                    servicePrice =
                                        parseFloat(
                                            priceValues[serviceIndex]
                                        ) || 0;
                                }
                            }
                        }
                    }


                    calculatedVehicleTotal += servicePrice;


                    serviceRowsHtml += `
                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom-subtle">
                            <span class="text-secondary small">
                                ${escapeHtml(serviceName)}
                            </span>

                            <span class="fw-semibold text-primary small">
                                ${formatPrice(servicePrice)}
                            </span>
                        </div>
                    `;
                });
            }


            // ----------------------------------------------------
            // NO SERVICES
            // ----------------------------------------------------

            if (!serviceRowsHtml) {

                serviceRowsHtml = `
                    <div class="text-muted small py-1">
                        No services registered
                    </div>
                `;
            }


            // ----------------------------------------------------
            // VEHICLE TOTAL
            // ----------------------------------------------------

            let vehicleTotal =
                parseFloat(
                    vehicle.total_cost ||
                    vehicle.total_price ||
                    0
                );


            if (
                isNaN(vehicleTotal) ||
                vehicleTotal === 0
            ) {

                vehicleTotal =
                    calculatedVehicleTotal;
            }


            grandTotal += vehicleTotal;


            // ----------------------------------------------------
            // VEHICLE CARD HTML
            // ----------------------------------------------------

            vehicleCardsHtml += `
                <div class="card border rounded-3 p-3 mb-3 bg-light-subtle shadow-sm">

                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">

                        <div class="d-flex align-items-center gap-2">

                            <span class="badge bg-primary text-white">
                                Vehicle ${vehicleNumber}
                            </span>

                            <span class="fw-bold text-dark font-monospace">
                                ${escapeHtml(plate)}
                            </span>

                            <span class="text-muted small">
                                ${escapeHtml(vehicleDetails)}
                            </span>

                        </div>

                        <div class="small">

                            <span class="text-muted">
                                Mechanic:
                            </span>

                            <span class="fw-bold text-dark">
                                ${escapeHtml(mechanic)}
                            </span>

                        </div>

                    </div>


                    <!-- SERVICES -->

                    <div class="mb-2">

                        <div class="extra-small fw-bold text-uppercase text-secondary mb-1">
                            SELECTED SERVICES:
                        </div>

                        ${serviceRowsHtml}

                    </div>


                    <!-- VEHICLE TOTAL -->

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">

                        <span class="fw-bold text-dark small">
                            Vehicle Total:
                        </span>

                        <span class="fw-bold text-primary fs-6">
                            ${formatPrice(vehicleTotal)}
                        </span>

                    </div>


                    <!-- PRICE ADJUSTMENT NOTE -->

                    ${
                        note
                            ? `
                                <div class="mt-2 pt-2 border-top">

                                    <div class="extra-small fw-bold text-uppercase text-secondary mb-1">

                                        <i class="bi bi-info-circle me-1"></i>

                                        PRICE ADJUSTMENT NOTE:

                                    </div>

                                    <div class="p-2 bg-white rounded border extra-small text-dark">

                                        ${escapeHtml(note)}

                                    </div>

                                </div>
                            `
                            : ''
                    }

                </div>
            `;
        });


        // --------------------------------------------------------
        // GRAND TOTAL FALLBACK
        // --------------------------------------------------------

        if (grandTotal === 0) {

            grandTotal =
                parseFloat(
                    data.total_cost ||
                    data.total_price ||
                    0
                );
        }


        // --------------------------------------------------------
        // FINAL RECEIPT
        // --------------------------------------------------------

        modalReceiptBody.innerHTML = `

            <!-- CUSTOMER INFORMATION -->

            <div class="mb-3 pb-2 border-bottom">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div class="extra-small fw-bold text-uppercase text-secondary">
                            CUSTOMER INFO
                        </div>

                        <h5 class="fw-bold text-dark mb-0">
                            ${escapeHtml(customerName)}
                        </h5>

                        <div class="text-secondary small font-monospace">
                            ${escapeHtml(contactPhone)}
                        </div>

                    </div>


                    <div>

                        <span class="badge bg-light text-dark border font-monospace fs-6 px-3 py-1">
                            ${escapeHtml(trackingCode)}
                        </span>

                    </div>

                </div>

            </div>


            <!-- VEHICLES -->

            <div>
                ${vehicleCardsHtml}
            </div>


            <!-- GRAND TOTAL -->

            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-3">

                <h5 class="fw-bold text-dark mb-0">
                    Grand Total Estimated Cost:
                </h5>

                <h3 class="fw-bold text-primary mb-0">
                    ${formatPrice(grandTotal)}
                </h3>

            </div>
        `;
    }


    // ============================================================
    // SERVICE NAME FORMATTER
    // ============================================================

    function formatServiceName(key) {

        if (!key) {
            return 'Service Item';
        }

        const serviceNames = {

            ceramic_coating:
                'Ceramic Coating',

            graphene_coating:
                'Graphene Coating',

            ppf:
                'Paint Protection Film (PPF)',

            interior_detailing:
                'Interior Detailing',

            exterior_detailing:
                'Exterior Detailing',

            washover:
                'Washover / Repaint',

            undercoat:
                'Undercoat'
        };


        if (serviceNames[key]) {
            return serviceNames[key];
        }


        return String(key)
            .replace(/_/g, ' ')
            .replace(/\b\w/g, letter =>
                letter.toUpperCase()
            );
    }

});