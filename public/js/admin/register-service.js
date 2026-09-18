document.addEventListener('DOMContentLoaded', function () {
    /* ================================================================ */
    /* 1. GLOBAL DATA FALLBACKS                                         */
    /* ================================================================ */
    const VEHICLE_MODELS = window.VEHICLE_MODELS || {};
    const SPEEDLANE_PRICES = window.SPEEDLANE_PRICES || {};

    /* ================================================================ */
    /* 2. ELEMENT SELECTORS                                             */
    /* ================================================================ */
    const displayCostInput = document.getElementById('displayCost');
    const rawCostInput = document.getElementById('total_cost');
    const generateCodeBtn = document.getElementById('generateCodeBtn');
    const trackingCodeInput = document.getElementById('tracking_code') || document.getElementById('trackingCodeInput');
    const addVehicleBtn = document.getElementById('addVehicleBtn');
    const vehiclesContainer = document.getElementById('vehiclesContainer');

    /* ================================================================ */
    /* UTILITY FUNCTIONS                                                */
    /* ================================================================ */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.innerText = text;
        return div.innerHTML;
    }

    /* ================================================================ */
    /* 3. CURRENCY FORMATTER                                            */
    /* ================================================================ */
    function formatCurrency(num) {
        return '₱' + Number(num || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    /* ================================================================ */
    /* 4. UPDATE PRICES FOR VEHICLE                                     */
    /* ================================================================ */
    function updatePricesForVehicleCard(vCard) {
        const typeSelect = vCard.querySelector('.type-select');
        const selectedType = typeSelect ? typeSelect.value : null;
        const banner = vCard.querySelector('.type-warning-banner');

        if (!selectedType) {
            if (banner) banner.classList.remove('d-none');
            vCard.querySelectorAll('.option-price, .flat-price-display').forEach(function (el) {
                el.textContent = '₱ --.--';
            });
            vCard.querySelectorAll('.service-card-item, .service-option-checkbox, .service-option-radio').forEach(function (el) {
                delete el.dataset.price;
            });
            vCard.querySelectorAll('input.service-price-input, input.option-price-input').forEach(function (el) {
                el.value = '';
            });
            recalculateVehicleTotal(vCard);
            return;
        }

        if (banner) banner.classList.add('d-none');

        vCard.querySelectorAll('.service-card-item').forEach(function (sItem) {
            const serviceKey = sItem.dataset.serviceKey;
            const isFlat = sItem.dataset.isFlat === "true";

            if (!SPEEDLANE_PRICES[serviceKey] || !SPEEDLANE_PRICES[serviceKey][selectedType]) return;

            const categoryData = SPEEDLANE_PRICES[serviceKey][selectedType];

            if (isFlat) {
                const price = categoryData;
                sItem.dataset.price = price;
                const display = sItem.querySelector('.flat-price-display');
                if (display) display.textContent = formatCurrency(price);

                const hiddenPrice = sItem.querySelector('input.service-price-input, input[name*="[price]"]');
                if (hiddenPrice) hiddenPrice.value = price;
            } else {
                sItem.querySelectorAll('.service-option-checkbox, .service-option-radio').forEach(function (optInput) {
                    const optionKey = optInput.dataset.optKey;
                    if (categoryData[optionKey] !== undefined) {
                        const price = categoryData[optionKey];
                        optInput.dataset.price = price;

                        const hiddenPrice = optInput.closest('label')?.querySelector('input.option-price-input, input[type="hidden"]');
                        if (hiddenPrice && hiddenPrice !== optInput) hiddenPrice.value = price;

                        const priceSpan = optInput.closest('label')?.querySelector('.option-price');
                        if (priceSpan) priceSpan.textContent = formatCurrency(price);
                    }
                });
            }
        });

        recalculateVehicleTotal(vCard);
    }

    /* ================================================================ */
    /* 5. CALCULATE VEHICLE TOTAL                                       */
    /* ================================================================ */
    function recalculateVehicleTotal(vCard) {
        let total = 0;

        vCard.querySelectorAll('.service-card-item').forEach(function (sItem) {
            const checkbox = sItem.querySelector('.service-checkbox');
            const optionsPanel = sItem.querySelector('.service-options-panel');

            if (checkbox && checkbox.checked) {
                sItem.classList.add('selected');
                if (optionsPanel) optionsPanel.classList.remove('d-none');

                if (sItem.dataset.isFlat === "true") {
                    total += parseFloat(sItem.dataset.price || 0);
                } else {
                    const checkedOptions = sItem.querySelectorAll('.service-option-checkbox:checked, .service-option-radio:checked');
                    checkedOptions.forEach(function (opt) {
                        total += parseFloat(opt.dataset.price || 0);
                    });
                }
            } else {
                sItem.classList.remove('selected');
                if (optionsPanel) optionsPanel.classList.add('d-none');
            }
        });

        const totalDisplay = vCard.querySelector('.vehicle-total-display');
        if (totalDisplay) totalDisplay.textContent = 'Total: ' + formatCurrency(total);

        updateGrandTotal();
    }

    /* ================================================================ */
    /* 6. CALCULATE GRAND TOTAL & UPDATE LIVE RECEIPT                   */
    /* ================================================================ */
    function updateGrandTotal() {
        let grandTotal = 0;
        let vehicleCount = 0;

        const customerName = document.getElementById('customer_name')?.value.trim() || '---';
        const customerPhone = document.getElementById('customer_phone')?.value.trim() || '---';
        const trackingCode = trackingCodeInput?.value.trim() || 'SPD-DRAFT';

        const previewCustomer = document.getElementById('previewCustomer');
        const previewPhone = document.getElementById('previewPhone');
        const previewCode = document.getElementById('previewCode');
        const previewVehiclesContainer = document.getElementById('previewVehiclesContainer');
        const previewTotal = document.getElementById('previewTotal');

        if (previewCustomer) previewCustomer.textContent = customerName;
        if (previewPhone) previewPhone.textContent = customerPhone;
        if (previewCode) previewCode.textContent = trackingCode;

        let vehiclesMarkup = '';

        document.querySelectorAll('.vehicle-card').forEach(function (vCard, index) {
            vehicleCount++;

            let vehicleTotal = 0;

            const plate = vCard.querySelector('.plate-input')?.value.trim() || '---';
            const brand = vCard.querySelector('.brand-select')?.value || '';
            const model = vCard.querySelector('.model-select')?.value || '';
            const type = vCard.querySelector('.type-select')?.value || '';
            const year = vCard.querySelector('.year-select')?.value || '';

            const mechanicSelect = vCard.querySelector('.mechanic-select');
            let mechanic = '---';
            if (mechanicSelect && mechanicSelect.selectedIndex >= 0) {
                const selectedText = mechanicSelect.options[mechanicSelect.selectedIndex].text;
                mechanic = (selectedText && !selectedText.toLowerCase().includes('select')) ? selectedText : (mechanicSelect.value || '---');
            }

            const noteInput = vCard.querySelector('input[name*="[price_adjustment_note]"], textarea[name*="[price_adjustment_note]"]');
            const noteText = noteInput ? noteInput.value.trim() : '';

            let vehicleSpecs = [];
            if (brand || model) vehicleSpecs.push(`${brand} ${model}`.trim());
            if (type) vehicleSpecs.push(type);
            if (year) vehicleSpecs.push(year);
            const specsFormatted = vehicleSpecs.length > 0 ? `(${vehicleSpecs.join(', ')})` : '(Brand Model, Vehicle Type, Year)';

            let selectedServices = [];

            vCard.querySelectorAll('.service-checkbox:checked').forEach(function (checkbox) {
                const serviceItem = checkbox.closest('.service-card-item');

                if (serviceItem.dataset.isFlat === "true") {
                    const price = parseFloat(serviceItem.dataset.price || 0);
                    const name = serviceItem.dataset.serviceName || 'Flat Service';
                    selectedServices.push({ name, price });
                    vehicleTotal += price;
                    grandTotal += price;
                } else {
                    const checkedOptions = serviceItem.querySelectorAll('.service-option-checkbox:checked, .service-option-radio:checked');
                    checkedOptions.forEach(function (opt) {
                        const price = parseFloat(opt.dataset.price || 0);
                        const name = opt.dataset.optLabel || opt.value;
                        selectedServices.push({ name, price });
                        vehicleTotal += price;
                        grandTotal += price;
                    });
                }
            });

            const noteMarkup = noteText !== '' ? `
                <div class="mt-2 pt-2 border-top">
                    <span class="text-secondary extra-small fw-bold text-uppercase d-block mb-1">
                        <i class="bi bi-info-circle me-1"></i> Price Adjustment Note:
                    </span>
                    <div class="p-2 rounded-2 bg-white border extra-small text-dark">
                        ${escapeHtml(noteText)}
                    </div>
                </div>
            ` : '';

            vehiclesMarkup += `
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                        <div>
                            <span class="badge bg-primary me-1">Vehicle ${index + 1}</span>
                            <span class="fw-bold text-dark me-2">${plate.toUpperCase()}</span>
                            <span class="text-muted small">${specsFormatted}</span>
                        </div>
                        <div class="small">
                            <span class="text-muted">Mechanic:</span> <strong class="text-dark">${mechanic}</strong>
                        </div>
                    </div>
                    <div>
                        <span class="text-secondary extra-small fw-bold text-uppercase d-block mb-1">Selected Services:</span>
                        ${selectedServices.length > 0 ? `
                            <ul class="list-group list-group-flush small bg-transparent mb-2">
                                ${selectedServices.map(srv => `
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-1 border-0">
                                        <span class="text-dark">${srv.name}</span>
                                        <span class="fw-semibold text-primary">${formatCurrency(srv.price)}</span>
                                    </li>
                                `).join('')}
                            </ul>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <span class="fw-bold text-dark small">Vehicle Total:</span>
                                <span class="fw-bold text-primary">${formatCurrency(vehicleTotal)}</span>
                            </div>
                        ` : `<span class="text-muted small italic">No services selected for this vehicle.</span>`}
                    </div>
                    ${noteMarkup}
                </div>
            `;
        });

        if (previewVehiclesContainer) {
            previewVehiclesContainer.innerHTML = vehiclesMarkup || `<p class="text-muted small mb-0">No vehicle details or services selected yet.</p>`;
        }

        if (previewTotal) {
            previewTotal.textContent = formatCurrency(grandTotal);
        }

        const summary = document.getElementById('vehiclesHeaderSummary');
        if (summary) {
            summary.textContent = `(${vehicleCount} ${vehicleCount === 1 ? 'vehicle' : 'vehicles'} · Grand Total: ${formatCurrency(grandTotal)})`;
        }

        if (displayCostInput) displayCostInput.value = grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        if (rawCostInput) rawCostInput.value = grandTotal.toFixed(2);
    }

    /* ================================================================ */
    /* 7. GLOBAL SERVICE & INPUT CHANGE HANDLER                         */
    /* ================================================================ */
    document.addEventListener('input', function (event) {
        if (
            event.target.id === 'customer_name' || 
            event.target.id === 'customer_phone' || 
            event.target.classList.contains('plate-input') ||
            (event.target.name && event.target.name.includes('[price_adjustment_note]'))
        ) {
            updateGrandTotal();
        }
    });

    document.addEventListener('change', function (event) {
        if (event.target.classList.contains('brand-select') || 
            event.target.classList.contains('model-select') || 
            event.target.classList.contains('year-select') || 
            event.target.classList.contains('mechanic-select')) {
            updateGrandTotal();
        }

        const vehicleCard = event.target.closest('.vehicle-card');
        if (!vehicleCard) return;

        /* Brand changed -> Dynamically populate Model dropdown */
        if (event.target.classList.contains('brand-select')) {
            const selectedBrand = event.target.value;
            const modelSelect = vehicleCard.querySelector('.model-select');
            if (!modelSelect) return;

            modelSelect.innerHTML = '';

            if (selectedBrand && VEHICLE_MODELS[selectedBrand]) {
                modelSelect.removeAttribute('disabled');
                const defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.disabled = true;
                defaultOpt.selected = true;
                defaultOpt.textContent = 'Select Model';
                modelSelect.appendChild(defaultOpt);

                VEHICLE_MODELS[selectedBrand].forEach(function (model) {
                    const opt = document.createElement('option');
                    opt.value = model;
                    opt.textContent = model;
                    modelSelect.appendChild(opt);
                });
            } else {
                modelSelect.setAttribute('disabled', 'disabled');
                const defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.disabled = true;
                defaultOpt.selected = true;
                defaultOpt.textContent = 'Select Brand First';
                modelSelect.appendChild(defaultOpt);
            }
            updateGrandTotal();
            return;
        }

        /* Vehicle type changed */
        if (event.target.classList.contains('type-select')) {
            updatePricesForVehicleCard(vehicleCard);
            return;
        }

        /* Service checkbox changed */
        if (event.target.classList.contains('service-checkbox')) {
            recalculateVehicleTotal(vehicleCard);
            return;
        }

        /* Service option changed (Support both checkbox and radio) */
        if (event.target.classList.contains('service-option-checkbox') || event.target.classList.contains('service-option-radio')) {
            recalculateVehicleTotal(vehicleCard);
        }
    });

    /* ================================================================ */
    /* 8. HELPER TO RE-INDEX VEHICLE INPUT NAMES AND IDS                */
    /* ================================================================ */
    function reindexVehicleCards() {
        if (!vehiclesContainer) return;
        const cards = vehiclesContainer.querySelectorAll('.vehicle-card');

        cards.forEach((card, idx) => {
            card.setAttribute('data-vehicle-index', idx);

            const badge = card.querySelector('.vehicle-number-badge');
            if (badge) badge.textContent = idx + 1;

            const removeBtn = card.querySelector('.remove-vehicle-btn');
            if (removeBtn) {
                if (cards.length > 1) {
                    removeBtn.classList.remove('d-none');
                } else {
                    removeBtn.classList.add('d-none');
                }
            }

            card.querySelectorAll('[name], [id], label[for], [for]').forEach(el => {
                if (el.name) {
                    el.name = el.name.replace(/vehicles\[\d+\]/g, `vehicles[${idx}]`)
                                     .replace(/vehicles_\d+_/g, `vehicles_${idx}_`)
                                     .replace(/v\d+_/g, `v${idx}_`);
                }
                if (el.id) {
                    el.id = el.id.replace(/v\d+_/g, `v${idx}_`)
                                 .replace(/vehicles_\d+_/g, `vehicles_${idx}_`);
                }
                if (el.tagName === 'LABEL' && el.htmlFor) {
                    el.htmlFor = el.htmlFor.replace(/v\d+_/g, `v${idx}_`)
                                           .replace(/vehicles_\d+_/g, `vehicles_${idx}_`);
                } else if (el.hasAttribute('for')) {
                    const forVal = el.getAttribute('for');
                    el.setAttribute('for', forVal.replace(/v\d+_/g, `v${idx}_`)
                                                 .replace(/vehicles_\d+_/g, `vehicles_${idx}_`));
                }
            });
        });
    }

    /* ================================================================ */
    /* 9. ADD & REMOVE VEHICLE CARD LOGIC                               */
    /* ================================================================ */
    if (addVehicleBtn && vehiclesContainer) {
        addVehicleBtn.addEventListener('click', function () {
            const vehicleCards = vehiclesContainer.querySelectorAll('.vehicle-card');
            const templateCard = vehicleCards[0];
            const newCard = templateCard.cloneNode(true);

            // Clear all input values in the cloned card
            newCard.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(input => input.value = '');
            newCard.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(cb => cb.checked = false);
            newCard.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
                if (select.classList.contains('model-select')) {
                    select.setAttribute('disabled', 'disabled');
                    select.innerHTML = '<option value="" disabled selected>Select Brand First</option>';
                }
            });

            // Reset panel states and pricing data
            newCard.querySelectorAll('.service-options-panel').forEach(panel => panel.classList.add('d-none'));
            newCard.querySelectorAll('.service-card-item').forEach(item => {
                item.classList.remove('selected');
                delete item.dataset.price;
            });
            newCard.querySelectorAll('.service-option-checkbox, .service-option-radio').forEach(opt => {
                delete opt.dataset.price;
            });
            newCard.querySelectorAll('.option-price, .flat-price-display').forEach(el => {
                el.textContent = '₱ --.--';
            });

            vehiclesContainer.appendChild(newCard);
            reindexVehicleCards();
            updatePricesForVehicleCard(newCard);
            updateGrandTotal();
        });

        vehiclesContainer.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-vehicle-btn');
            if (!removeBtn) return;

            const card = removeBtn.closest('.vehicle-card');
            if (card && vehiclesContainer.querySelectorAll('.vehicle-card').length > 1) {
                card.remove();
                reindexVehicleCards();
                updateGrandTotal();
            }
        });
    }

    /* ================================================================ */
    /* 10. TRACKING CODE GENERATOR                                      */
    /* ================================================================ */
    function generateTrackingCode() {
        if (!trackingCodeInput) return;
        const year = new Date().getFullYear().toString().slice(-2);
        const characters = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';
        let randomString = '';

        for (let i = 0; i < 6; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            randomString += characters.charAt(randomIndex);
        }

        trackingCodeInput.value = `SPD${year}-${randomString}`;
        updateGrandTotal();
    }

    if (generateCodeBtn) {
        generateCodeBtn.addEventListener('click', generateTrackingCode);
    }

    if (trackingCodeInput && !trackingCodeInput.value) {
        generateTrackingCode();
    }

    // Initial Re-indexing & Receipt Render
    reindexVehicleCards();
    updateGrandTotal();
});