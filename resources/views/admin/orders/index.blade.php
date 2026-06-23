@extends('layouts.app')

@section('title', 'Orders')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alerts --}}
            @include('common.alert')

            <div class="card">
                <div class="card-header">
                    <h5>Order Listing</h5>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-10">
                            <form method="GET" action="{{ route('orders.index') }}" class="d-flex">
                                <input type="text" class="form-control me-2" name="search" value="{{ request('search') }}"
                                       placeholder="Order Type / Rent Type / Ref Name / Ref Mobile / Location">

                                <select class="form-select me-2" name="rent_type">
                                    <option value="">-- Rent Type --</option>
                                    <option value="daily" {{ request('rent_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="monthly" {{ request('rent_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>

                                <select class="form-select me-2" name="isReceive">
                                    <option value="">-- Tanker Status --</option>
                                    <option value="1" {{ request('isReceive') == '1' ? 'selected' : '' }}>Not Received</option>
                                    <option value="0" {{ request('isReceive') == '0' ? 'selected' : '' }}>Received</option>
                                </select>

                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                <a href="{{ route('orders.index') }}" class="btn btn-light">Reset</a>
                            </form>
                        </div>

                        <div class="col-md-2 text-end">
                            <a href="{{ route('orders.create') }}" class="btn btn-sm btn-primary">
                                <i class="far fa-plus"></i> Add New
                            </a>
                        </div>
                    </div>

                    {{-- Top bar --}}
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <button id="btnBulkDelete" class="btn btn-sm btn-danger">
                                <i class="far fa-trash-alt"></i> Bulk Delete
                            </button>

                            <a href="{{ route('orders.monthly-pdf', request()->query()) }}" class="btn btn-sm btn-danger ms-1">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </div>

                        <div class="col-md-2">
                            <div class="text-end mt-2">
                                <span class="badge bg-success me-2" style="font-size: small;">
                                    Total Paid: {{ $totalPaid }}
                                </span>
                                <span class="badge bg-info me-2" style="font-size: small;">
                                    Total Discount: {{ $totalDiscount }}
                                </span>
                                <span class="badge bg-danger me-2" style="font-size: small;">
                                    Total Unpaid (Needed Amount): {{ $totalUnpaid }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-striped">
                            <thead>
                                <tr>
                                    <th style="width:40px;"><input type="checkbox" id="checkAll"></th>
                                    <th>Rent Start</th>
                                    <th>Rent Type</th>
                                    <th>Customer (Total)</th>
                                    <th>Tanker No</th>
                                    <th>Tanker Name</th>
                                    <th>Tanker Location</th>
                                    <th>Rent</th>
                                    <th>M/D</th>
                                    <th>Total</th>
                                    <th>Tanker Paid</th>
                                    <th>Tanker Unpaid</th>
                                    <th>Tanker Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($orders as $o)
                                    @php
                                        $snap = $o->display_snapshot ?? $o->dueSnapshot();

                                        $durationText = $snap['rent_basis'] === 'daily'
                                            ? "{$snap['days_used']} day" . ($snap['days_used'] > 1 ? 's' : '')
                                            : "{$snap['months']} month" . ($snap['months'] > 1 ? 's' : '');

                                        $durationDays = $snap['rent_basis'] === 'daily' ? (int) $snap['days_used'] : '';

                                        $cSummary = $customerPaymentSummary[$o->customer_id] ?? [
                                            'paid' => 0,
                                            'unpaid' => 0
                                        ];
                                    @endphp

                                    <tr data-id="{{ $o->order_id }}">
                                        <td>
                                            <input type="checkbox" class="row-check" value="{{ $o->order_id }}">
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($o->rent_start_date)->format('d-m-Y') }}</td>

                                        <td>{{ $o->rentPrice->rent_type }}</td>

                                        <td>
                                            <a href="javascript:void(0)"
                                               class="text-decoration-underline"
                                               data-bs-toggle="modal"
                                               data-bs-target="#customerOrdersModal"
                                               data-customer-id="{{ $o->customer_id }}"
                                               data-customer-name="{{ $o->customer->customer_name ?? $o->customer_id }}">
                                                {{ $o->customer->customer_name ?? $o->customer_id }}
                                            </a>

                                            <div class="small text-muted mt-1">
                                                <span class="text-success">
                                                    Paid: ₹{{ number_format($cSummary['paid']) }}
                                                </span>
                                                <br>
                                                <span class="text-info">
                                                    Discount: ₹{{ number_format($cSummary['discount'] ?? 0) }}
                                                </span>
                                                <br>
                                                <span class="{{ $cSummary['unpaid'] > 0 ? 'text-danger fw-bold' : '' }}">
                                                    Unpaid (Needed) : ₹{{ number_format($cSummary['unpaid']) }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>{{ $o->tanker->tanker_code ?? '-' }}</td>
                                        <td>{{ $o->tanker->tanker_name ?? '-' }}</td>
                                        <td>{{ $o->tanker_location }}</td>

                                        <td>₹{{ number_format($snap['base']) }}</td>

                                        <td>
                                            <div class="small text-muted">
                                                @if($snap['rent_basis'] === 'daily')
                                                    ({{ $snap['days_used'] }} day{{ $snap['days_used'] > 1 ? 's' : '' }})
                                                @else
                                                    ({{ $snap['months'] }} month{{ $snap['months'] > 1 ? 's' : '' }})
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <strong>₹{{ number_format($snap['total_due']) }}</strong>
                                        </td>

                                        <td>₹{{ number_format($snap['paid_sum']) }}</td>

                                        <td class="{{ $snap['unpaid'] > 0 ? 'text-danger fw-bold' : '' }}">
                                            ₹{{ number_format($snap['unpaid']) }}
                                        </td>

                                        <td>
                                            @if($o->isReceive == 1)
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#receivedModal"
                                                    data-order-id="{{ $o->order_id }}"
                                                    data-extra-amount="{{ number_format($snap['total_due']) }}"
                                                    data-extra-day="{{ $durationDays }}"
                                                    data-rent-basis="{{ $snap['rent_basis'] }}"
                                                    data-duration-text="{{ $durationText }}"
                                                    title="Mark as Received">
                                                    Not Received
                                                </button>
                                            @else
                                                <a href="{{ route('orders.toggle-receive', $o->order_id) }}"
                                                   class="btn btn-sm btn-success"
                                                   onclick="return confirm('Are you sure you want to mark as NOT RECEIVED?')">
                                                    Received
                                                </a>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('orders.edit', $o->order_id) }}"
                                               class="btn btn-sm btn-primary text-white"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="javascript:void(0)"
                                               class="btn btn-sm btn-light text-white btnDelete"
                                               title="Delete"
                                               data-id="{{ $o->order_id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                            @if(($o->rentPrice->rent_type ?? '') === 'Monthly')
                                                <a href="{{ route('orders.monthly-pdf', array_merge(request()->query(), ['customer_id' => $o->customer_id])) }}"
                                                   class="btn btn-sm btn-danger"
                                                   title="Customer PDF"
                                                   target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endif

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#tankerDetailsModal"
                                                data-order-id="{{ $o->order_id }}"
                                                title="Tanker Details">
                                                <i class="fas fa-truck"></i>
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#paymentModal"
                                                data-order-id="{{ $o->order_id }}"
                                                data-customer-id="{{ $o->customer_id }}"
                                                data-unpaid="{{ $customerPaymentSummary[$o->customer_id]['unpaid'] ?? $snap['unpaid'] }}"
                                                data-customer-name="{{ $o->customer->customer_name ?? $o->customer_id }}"
                                                data-rent-basis="{{ $snap['rent_basis'] }}"
                                                title="Add Payment">
                                                <i class="fa fa-inr"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- Customer Orders & Payments Modal --}}
<div class="modal fade" id="customerOrdersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="customerOrdersTitle">Customer Orders & Payments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="customerOrdersBody">
                <div class="text-center py-5">Loading customer orders…</div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

{{-- Tanker Details Modal --}}
<div class="modal fade" id="tankerDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tanker Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="tankerDetailsBody">
                <div class="text-center py-4">Loading details…</div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

{{-- Mark as Received Modal --}}
<div class="modal fade" id="receivedModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content" id="receivedForm">
            @csrf

            <input type="hidden" name="extra_amount" id="rcv_extra_amount">
            <input type="hidden" name="extra_day" id="rcv_extra_day">
            <input type="hidden" name="rent_basis" id="rcv_rent_basis">
            <input type="hidden" name="duration_text" id="rcv_duration_text">

            <div class="modal-header">
                <h5 class="modal-title">Mark as Received</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">
                        Received Date <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="received_at" id="received_at" class="form-control"
                           value="{{ old('received_at', date('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Select Godown <span class="text-danger">*</span>
                    </label>

                    <select name="godown_id" class="form-select" required>
                        <option value="">-- Choose --</option>
                        @foreach($godowns as $g)
                            <option value="{{ $g->godown_id }}">{{ $g->Name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Save</button>
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Payment Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalTitle">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                {{-- Payment History --}}
                <div id="pm_history">
                    <div class="text-center py-4" id="pm_history_loader" style="display:none;">
                        Loading history...
                    </div>
                </div>

                <hr class="my-3">

                {{-- Add Payment Form --}}
                <form method="POST" action="{{ route('payments.store') }}" id="paymentForm">
                    @csrf

                    <input type="hidden" name="order_id" id="pm_order_id">
                    <input type="hidden" name="customer_id" id="pm_customer_id">

                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="form-label">
                                Payment Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="payment_date" id="payment_date" class="form-control"
                                   value="{{ old('payment_date', date('Y-m-d')) }}">
                        </div>

                        <div class="col-6 mb-2">
                                <label class="form-label">Is Discount Amount?</label>
                            <select name="is_discount_amount" id="pm_is_discount_amount" class="form-select">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <div class="col-6 mb-2 pm-received-by-wrap">

                            <label class="form-label">
                                Select Received BY <span class="text-danger">*</span>
                            </label>

                            <select name="payment_received_by" class="form-select" required>
                                <option value="">-- Choose --</option>
                                @foreach($paymentUser as $p)
                                    <option value="{{ $p->received_id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 mb-2 pm-due-wrap">
                            <label class="form-label">Due Amount</label>
                            <input type="text" id="pm_unpaid" class="form-control" readonly>
                        </div>

                        <div class="col-6 mb-2 pm-paid-wrap">
                            <label class="form-label">
                                Paid Amount <span class="text-danger">*</span>
                            </label>
                            <input type="number" min="1" step="1" name="paid_amount" class="form-control" required>
                            <small class="text-muted">Cannot exceed current unpaid.</small>
                        </div>
                        <div class="col-6 mb-2 pm-discount-wrap" style="display:none;">
                            <label class="form-label">
                                Discount Amount <span class="text-danger">*</span>
                            </label>
                            <input type="number" min="1" step="1" name="discount_amount" class="form-control">
                            <small class="text-muted">Discount reduces the customer's due amount.</small>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button class="btn btn-primary" type="submit">Save Payment</button>
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let currentPaymentModalRentBasis = '';

document.addEventListener('DOMContentLoaded', function () {

    // Mark as received modal
    const receivedModal = document.getElementById('receivedModal');

    if (receivedModal) {
        receivedModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            if (!btn) return;

            const id = btn.dataset.orderId;

            const form = document.getElementById('receivedForm');
            let url = "{{ route('orders.mark-received', ':id') }}";
            form.action = url.replace(':id', id);

            document.getElementById('rcv_extra_amount').value = btn.dataset.extraAmount || '0';
            document.getElementById('rcv_extra_day').value = btn.dataset.extraDay || '';
            document.getElementById('rcv_rent_basis').value = btn.dataset.rentBasis || '';
            document.getElementById('rcv_duration_text').value = btn.dataset.durationText || '';
        });
    }

    // Confirm before toggling
    document.querySelectorAll('.toggle-receive-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const isNotReceived = this.dataset.current === '1';
            const orderId = this.dataset.orderId;
            const nextState = isNotReceived ? 'Received' : 'Not Received';
            const msg = `Are you sure you want to mark Order #${orderId} as ${nextState}?`;

            if (confirm(msg)) {
                this.submit();
            }
        });
    });

    // Payment form validation
    const paymentModal = document.getElementById('paymentModal');

    if (paymentModal) 
    {
         const toggleDiscountFields = function () {
            const isDiscount = document.getElementById('pm_is_discount_amount')?.value === '1';
            const receivedWrap = paymentModal.querySelector('.pm-received-by-wrap');
            const dueWrap = paymentModal.querySelector('.pm-due-wrap');
            const paidWrap = paymentModal.querySelector('.pm-paid-wrap');
            const discountWrap = paymentModal.querySelector('.pm-discount-wrap');
            const receivedSelect = paymentModal.querySelector('select[name="payment_received_by"]');
            const paidInput = paymentModal.querySelector('input[name="paid_amount"]');
            const discountInput = paymentModal.querySelector('input[name="discount_amount"]');

            if (receivedWrap) receivedWrap.style.display = isDiscount ? 'none' : '';
            if (dueWrap) dueWrap.style.display = '';
            if (paidWrap) paidWrap.style.display = isDiscount ? 'none' : '';
            if (discountWrap) discountWrap.style.display = isDiscount ? '' : 'none';
            if (receivedSelect) receivedSelect.required = !isDiscount;
            if (paidInput) paidInput.required = !isDiscount;
            if (discountInput) discountInput.required = isDiscount;
        };

        document.getElementById('pm_is_discount_amount')?.addEventListener('change', toggleDiscountFields);

        paymentModal.addEventListener('submit', function (event) {
            const form = event.target;

            if (!form.matches('#paymentForm')) {
                return;
            }

            const dueText = document.getElementById('pm_unpaid')?.value || '0';
            const due = Number(String(dueText).replace(/[^0-9.]/g, '')) || 0;
            const isDiscount = form.querySelector('[name="is_discount_amount"]')?.value === '1';
            const amount = Number(form.querySelector(isDiscount ? 'input[name="discount_amount"]' : 'input[name="paid_amount"]')?.value || 0);

            if (amount > due) {
                event.preventDefault();
                alert((isDiscount ? 'Discount amount' : 'Paid amount') + ' cannot exceed current unpaid.');
            }
        });

        paymentModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            if (!btn) return;

            const orderId = btn.getAttribute('data-order-id');
            const customerId = btn.getAttribute('data-customer-id');
            const unpaid = Number(btn.getAttribute('data-unpaid') || 0);
            const customerName = btn.getAttribute('data-customer-name') || 'Customer';

            currentPaymentModalRentBasis = (btn.getAttribute('data-rent-basis') || '').toLowerCase();

            document.getElementById('pm_order_id').value = orderId || 0;
            document.getElementById('pm_customer_id').value = customerId || '';
            document.getElementById('pm_unpaid').value = '₹' + unpaid.toLocaleString('en-IN');

            const paidInput = document.querySelector('#paymentModal input[name="paid_amount"]');

            if (paidInput) {
                paidInput.max = unpaid > 0 ? String(unpaid) : '';
                paidInput.value = '';
            }

            const discountInput = document.querySelector('#paymentModal input[name="discount_amount"]');
            if (discountInput) {
                discountInput.max = unpaid > 0 ? String(unpaid) : '';
                discountInput.value = '';
            }

            const discountSelect = document.getElementById('pm_is_discount_amount');
            if (discountSelect) {
                discountSelect.value = '0';
            }
            toggleDiscountFields();

            const payTitle = document.getElementById('paymentModalTitle');

            if (payTitle) {
                payTitle.textContent = `Add Payment - ${customerName} (Order #${orderId})`;
            }

            loadPaymentHistory(orderId, customerId, currentPaymentModalRentBasis);
        });
    }

    // Tanker details modal
    const tankerDetailsModal = document.getElementById('tankerDetailsModal');

    if (tankerDetailsModal) {
        tankerDetailsModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            if (!btn) return;

            const id = btn.getAttribute('data-order-id');
            const body = document.getElementById('tankerDetailsBody');

            body.innerHTML = '<div class="text-center py-4">Loading details…</div>';

            let url = "{{ route('orders.tanker-details', ':id') }}";
            url = url.replace(':id', id);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.text())
            .then(html => {
                body.innerHTML = html;
            })
            .catch(() => {
                body.innerHTML = '<div class="alert alert-danger">Unable to load tanker details.</div>';
            });
        });
    }

    // Customer orders modal
    const customerOrdersModal = document.getElementById('customerOrdersModal');

    if (customerOrdersModal) {
        customerOrdersModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            if (!btn) return;

            const customerId = btn.getAttribute('data-customer-id');
            const customerName = btn.getAttribute('data-customer-name') || 'Customer';
            const body = document.getElementById('customerOrdersBody');
            const title = document.getElementById('customerOrdersTitle');

            if (title) {
                title.textContent = `Customer Orders & Payments - ${customerName}`;
            }

            body.innerHTML = '<div class="text-center py-5">Loading customer orders…</div>';

            let url = "{{ route('orders.orders-summary', ':id') }}";
            url = url.replace(':id', customerId);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.text())
            .then(html => {
                body.innerHTML = html;
            })
            .catch(() => {
                body.innerHTML = '<div class="alert alert-danger">Unable to load customer orders.</div>';
            });
        });
    }

});

$(function () {
    const CSRF = '{{ csrf_token() }}';

    // Check all
    $('#checkAll').on('change', function () {
        $('.row-check').prop('checked', $(this).is(':checked'));
    });

    // Bulk delete
    $('#btnBulkDelete').on('click', function () {
        let ids = $('.row-check:checked').map(function () {
            return $(this).val();
        }).get();

        if (!ids.length) {
            return alert('Please select at least one row.');
        }

        if (!confirm('Are you sure you want to delete selected records?')) {
            return;
        }

        $.ajax({
            url: "{{ route('orders.bulk-delete') }}",
            type: 'POST',
            data: {
                ids: ids,
                _token: CSRF
            },
            success: function (r) {
                if (r.status) {
                    location.reload();
                } else {
                    alert(r.message || 'Failed to delete.');
                }
            },
            error: function () {
                alert('Something went wrong.');
            }
        });
    });

    // Single order delete
    $('.btnDelete').on('click', function () {
        let id = $(this).data('id');

        if (!confirm('Do you really want to delete this record?')) {
            return;
        }

        $.ajax({
            url: "{{ route('orders.destroy', ':id') }}".replace(':id', id),
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: CSRF
            },
            success: function (r) {
                if (r.status) {
                    location.reload();
                } else {
                    alert('Failed to delete.');
                }
            },
            error: function () {
                alert('Something went wrong.');
            }
        });
    });

    // Toggle status
    $('.toggle-status').on('click', function () {
        let id = $(this).data('id');
        let el = $(this);

        $.ajax({
            url: "{{ route('orders.change-status', ':id') }}".replace(':id', id),
            type: 'POST',
            data: {
                _token: CSRF
            },
            success: function (r) {
                if (r.status) {
                    if (r.new_status == 1) {
                        el.removeClass('bg-secondary').addClass('bg-success').text('Active');
                    } else {
                        el.removeClass('bg-success').addClass('bg-secondary').text('Inactive');
                    }
                }
            }
        });
    });

    // Payment history delete button
    $(document).on('click', '.js-delete-payment-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let btn = $(this);
        let action = btn.data('action');
        let token = btn.data('token');

        if (!confirm('Delete this payment record?')) {
            return false;
        }

        btn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: action,
            type: 'POST',
            data: {
                _token: token
            },
            success: function (res) {
                let orderId = $('#pm_order_id').val();
                let customerId = $('#pm_customer_id').val();

                loadPaymentHistory(orderId, customerId, currentPaymentModalRentBasis);
            },
            error: function () {
                alert('Unable to delete payment. Please try again.');
                btn.prop('disabled', false).text('Delete');
            }
        });

        return false;
    });
});

function loadPaymentHistory(orderId, customerId, rentBasis) {
    const historyWrap = document.getElementById('pm_history');

    if (!historyWrap) {
        return;
    }

    historyWrap.innerHTML = '<div class="text-center py-4">Loading history...</div>';

    let url = "{{ route('payments.history', ':id') }}";
    url = url.replace(':id', orderId);

    if (customerId) {
        url += (url.includes('?') ? '&' : '?') + 'customer_id=' + encodeURIComponent(customerId);
    }

    if (rentBasis) {
        url += (url.includes('?') ? '&' : '?') + 'rent_basis=' + encodeURIComponent(rentBasis);
    }

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.text())
    .then(html => {
        historyWrap.innerHTML = html;
          const parser = document.createElement('div');
        parser.innerHTML = html;
        const unpaidValue = Number(parser.querySelector('#pm_current_unpaid')?.getAttribute('data-value') || 0);

        const unpaidInput = document.getElementById('pm_unpaid');
        if (unpaidInput) {
            unpaidInput.value = '₹' + unpaidValue.toLocaleString('en-IN');
        }

        const paidInput = document.getElementById('pm_paid_amount');
        if (paidInput) {
            paidInput.max = unpaidValue > 0 ? String(unpaidValue) : '';
            if (Number(paidInput.value || 0) > unpaidValue) {
                paidInput.value = unpaidValue > 0 ? String(unpaidValue) : '';
            }
        }
    })
    .catch(() => {
        historyWrap.innerHTML = '<div class="alert alert-danger">Unable to load payment history.</div>';
    });
}
</script>
@endsection