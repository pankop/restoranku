@extends('customer.layouts.master')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Checkout</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item active text-primary">Silakan isi detail pemesanan Anda</li>
        </ol>
    </div>
    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Detail Pembayaran</h1>
            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">                           <div class="form-item w-100">
                                    <label class="form-label my-3">Nama Lengkap<sup>*</sup></label>
                                    <input type="text" name="fullname" class="form-control" placeholder="Masukka nama Anda" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Nomor WhatsApp<sup>*</sup></label>
                                    <input type="text" name="phone" class="form-control" placeholder="Masukkan Nomor WhatsApp Anda" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Nomor Meja<sup>*</sup></label>
                                    <input type="text" class="form-control" value="{{ $tableNumber ?? 'Tidak ada nomor meja' }}" disabled required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="form-item">
                                    <textarea name="note" class="form-control" spellcheck="false" cols="30" rows="5" placeholder="Catatan pesanan (Opsional)"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <br><br>
                                <h4 class="mb-4">Detail Pesanan</h4>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $subTotal = 0;
                                    @endphp
                                    @foreach (session('cart') as $item)
                                        @php
                                            $itemTotal = $item['price'] * $item['qty'];
                                            $subTotal += $itemTotal;
                                        @endphp
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="{{ asset('img_item_upload/'. $item['image']) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="" onerror="this.onerror=null;this.src='{{  $item['image'] }}';">
                                                </div>
                                            </th>
                                            <td class="py-5">{{ $item['name'] }}</td>
                                            <td class="py-5">{{ 'Rp'. number_format($item['price'], 0, ',','.') }}</td>
                                            <td class="py-5">{{ $item['qty'] }}</td>
                                            <td class="py-5">{{ 'Rp'. number_format($item['price'] * $item['qty'], 0, ',','.') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @php
                        $tax = $subTotal * 0.1;
                        $total = $subTotal + $tax;
                    @endphp
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <div class="row g-4 align-items-center py-3">
                            <div class="col-lg-12">
                                <div class="bg-light rounded">
                                    <div class="p-4">
                                        <h3 class="display-6 mb-4">Total <span class="fw-normal">Pesanan</span></h3>
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="mb-0 me-4">Subtotal</h5>
                                            <p class="mb-0">Rp{{ number_format($subTotal, 0, ',','.') }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="mb-0 me-4">Pajak (10%)</p>
                                            <div class="">
                                                <p class="mb-0">Rp{{ number_format($tax, 0, ',','.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                        <h4 class="mb-0 ps-4 me-4">Total</h4>
                                        <h5 class="mb-0 pe-4">Rp{{ number_format($total, 0, ',','.') }}</h5>
                                    </div>

                                    <div class="py-4 mb-4 d-flex justify-content-between">
                                        <h5 class="mb-0 ps-4 me-4">Metode Pembayaran</h5>
                                        <div class="mb-0 pe-4 mb-3 pe-5">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input bg-primary border-0" id="qris" name="payment_method" value="qris">
                                                <label class="form-check-label" for="qris">QRIS</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input bg-primary border-0" id="cash" name="payment_method" value="tunai">
                                                <label class="form-check-label" for="cash">Tunai</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="pay-button" class="btn border-secondary py-3 text-uppercase text-primary">Konfirmasi Pesanan</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Checkout Page End -->
    <script  src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const payButton = document.getElementById("pay-button");
            const form = document.querySelector("form");

            payButton.addEventListener("click", function () {
                let paymentMethod = document.querySelector('input[name="payment_method"]:checked');

                if(!paymentMethod) {
                    alert("Pilih Metode Pembayaran Terlebih Dahulu!");
                    return;
                }

                paymentMethod = paymentMethod.value;
                let formData = new FormData(form);

                if(paymentMethod === "tunai") {
                    form.submit();
                } else {
                    fetch("{{ route('checkout.store') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if(data.snap_token) {
                                snap.pay(data.snap_token, {
                                    onSuccess: function(result) {
                                        window.location.href = "/checkout/success/" + data.order_code;
                                    },
                                    onPending: function(result) {
                                        alert("Menunggu Pembayaran");
                                    },
                                    onError: function(result) {
                                        alert("Pembayaran Gagal");
                                    }
                                });
                            } else {
                                alert("Terjadi kesalahan, silakan coba lagi.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Terjadi kesalahan, silakan coba lagi ya.");
                        });
                }
            })
        })
        {{--const Toast = Swal.mixin({--}}
        {{--    toast: true,--}}
        {{--    position: 'top-end',--}}
        {{--    showConfirmButton: false,--}}
        {{--    timer: 3000,--}}
        {{--    timerProgressBar: true,--}}
        {{--    didOpen: (toast) => {--}}
        {{--        toast.addEventListener('mouseenter', Swal.stopTimer)--}}
        {{--        toast.addEventListener('mouseleave', Swal.resumeTimer)--}}
        {{--    }--}}
        {{--});--}}

        {{--function showToast(icon, message) {--}}
        {{--    Toast.fire({--}}
        {{--        icon: icon,--}}
        {{--        title: message--}}
        {{--    });--}}
        {{--}--}}

        {{--document.addEventListener("DOMContentLoaded", function () {--}}
        {{--    const payButton = document.getElementById("pay-button");--}}
        {{--    const form = document.querySelector("form");--}}

        {{--    payButton.addEventListener("click", function (e) {--}}
        {{--        let paymentMethod = document.querySelector('input[name="payment_method"]:checked');--}}

        {{--        if(!paymentMethod) {--}}
        {{--            // Ganti alert() Validasi Pilihan--}}
        {{--            Swal.fire({--}}
        {{--                icon: 'warning',--}}
        {{--                title: 'Pilihan Dibutuhkan!',--}}
        {{--                text: 'Pilih Metode Pembayaran Terlebih Dahulu!',--}}
        {{--                confirmButtonColor: '#3085d6',--}}
        {{--            });--}}
        {{--            return;--}}
        {{--        }--}}

        {{--        paymentMethod = paymentMethod.value;--}}
        {{--        let formData = new FormData(form);--}}

        {{--        if(paymentMethod === "tunai") {--}}
        {{--            // Tampilkan konfirmasi SweetAlert sebelum submit tunai--}}
        {{--            Swal.fire({--}}
        {{--                title: 'Bayar Tunai?',--}}
        {{--                text: "Pesanan akan dibuat dan pembayaran dilakukan di tempat.",--}}
        {{--                icon: 'question',--}}
        {{--                showCancelButton: true,--}}
        {{--                confirmButtonColor: '#28a745', // Hijau untuk Tunai/OK--}}
        {{--                cancelButtonColor: '#d33',--}}
        {{--                confirmButtonText: 'Ya, Bayar Tunai!',--}}
        {{--                cancelButtonText: 'Batal'--}}
        {{--            }).then((result) => {--}}
        {{--                if (result.isConfirmed) {--}}
        {{--                    form.submit();--}}
        {{--                }--}}
        {{--            });--}}
        {{--            // Kita tambahkan return di sini agar kode selanjutnya tidak tereksekusi--}}
        {{--            return;--}}
        {{--        } else {--}}
        {{--            // Proses Midtrans--}}
        {{--            fetch("{{ route('checkout.store') }}", {--}}
        {{--                method: "POST",--}}
        {{--                body: formData,--}}
        {{--                headers: {--}}
        {{--                    "X-CSRF-TOKEN": "{{ csrf_token() }}"--}}
        {{--                }--}}
        {{--            })--}}
        {{--                .then(response => response.json())--}}
        {{--                .then(data => {--}}
        {{--                    if(data.snap_token) {--}}
        {{--                        snap.pay(data.snap_token, {--}}
        {{--                            onSuccess: function(result) {--}}
        {{--                                // Notifikasi sukses (optional, karena akan redirect)--}}
        {{--                                showToast('success', 'Pembayaran berhasil!');--}}
        {{--                                window.location.href = "/checkout/success/" + data.order_code;--}}
        {{--                            },--}}
        {{--                            onPending: function(result) {--}}
        {{--                                // Ganti alert() Pending--}}
        {{--                                Swal.fire({--}}
        {{--                                    icon: 'info',--}}
        {{--                                    title: 'Menunggu Pembayaran',--}}
        {{--                                    text: 'Pembayaran Anda sedang menunggu konfirmasi.',--}}
        {{--                                    confirmButtonColor: '#17a2b8', // Biru untuk Info--}}
        {{--                                });--}}
        {{--                            },--}}
        {{--                            onError: function(result) {--}}
        {{--                                // Ganti alert() Gagal--}}
        {{--                                Swal.fire({--}}
        {{--                                    icon: 'error',--}}
        {{--                                    title: 'Pembayaran Gagal!',--}}
        {{--                                    text: 'Terjadi kesalahan saat memproses pembayaran online.',--}}
        {{--                                    confirmButtonColor: '#d33',--}}
        {{--                                });--}}
        {{--                            }--}}
        {{--                        });--}}
        {{--                    } else {--}}
        {{--                        // Ganti alert() Error Server--}}
        {{--                        Swal.fire({--}}
        {{--                            icon: 'error',--}}
        {{--                            title: 'Kesalahan Server',--}}
        {{--                            text: 'Terjadi kesalahan saat menyiapkan pembayaran, silakan coba lagi.',--}}
        {{--                            confirmButtonColor: '#d33',--}}
        {{--                        });--}}
        {{--                    }--}}
        {{--                })--}}
        {{--                .catch(error => {--}}
        {{--                    console.error("Error:", error);--}}
        {{--                    // Ganti alert() Error Jaringan--}}
        {{--                    Swal.fire({--}}
        {{--                        icon: 'error',--}}
        {{--                        title: 'Kesalahan Jaringan',--}}
        {{--                        text: 'Gagal terhubung ke server, silakan cek koneksi Anda.',--}}
        {{--                        confirmButtonColor: '#d33',--}}
        {{--                    });--}}
        {{--                });--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
    </script>
@endsection
