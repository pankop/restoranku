@extends('customer.layouts.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Menu Kami</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item active text-primary">Silakan pilih menu favorit anda</li>
        </ol>
    </div>
    <!-- Single Page Header End -->
    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-3">
                        <div class="col-lg">
                            <div class="row g-4 justify-content-center">
                                @foreach($items as $item)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="{{ asset('img_item_upload/'. $item->img) }}" class="img-fluid w-100 rounded-top" alt="" onerror="this.onerror=null;this.src='{{  $item->img }}';">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute
                                                @if ($item->category->cat_name == 'Makanan')
                                                    bg-warning
                                                @elseif ($item->category->cat_name == 'Minuman')
                                                    bg-info
                                                @else
                                                    bg-primary
                                                @endif" style="top: 10px; left: 10px;">
                                                        {{ $item->category->cat_name }}
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $item->name }}</h4>
                                                <p class="text-limited">{{ $item->description }}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ 'Rp'. number_format($item->price, 0, ',','.') }}</p>
                                                    <a href="#" onclick="addToCart({{ $item->id }})" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah Keranjang</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Pagination -->
                                <!-- <div class="col-12">
                                    <div class="pagination d-flex justify-content-center mt-5">
                                        <a href="#" class="rounded">&laquo;</a>
                                        <a href="#" class="active rounded">1</a>
                                        <a href="#" class="rounded">2</a>
                                        <a href="#" class="rounded">3</a>
                                        <a href="#" class="rounded">4</a>
                                        <a href="#" class="rounded">5</a>
                                        <a href="#" class="rounded">6</a>
                                        <a href="#" class="rounded">&raquo;</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection

@section('script')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end', // Letakkan di kanan atas
            showConfirmButton: false,
            timer: 750, // Hilang dalam 3 detik
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function showToast(icon, message) {
            Toast.fire({
                icon: icon, // 'success', 'error', 'warning', 'info', 'question'
                title: message
            });
        }


        function addToCart(menuId) {
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: menuId })
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message)
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function addToCart(menuId) {
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: menuId })
            })
                .then(response => response.json())
                .then(data => {
                    // Cek status response dari Controller
                    if (data.status === 'success') {
                        // Ganti alert() dengan Toast SweetAlert
                        showToast('success', data.message);
                    } else {
                        // Tampilkan error menggunakan SweetAlert standar jika statusnya 'error'
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    // Tangani error koneksi
                    Swal.fire('Error!', 'Terjadi kesalahan jaringan saat menambahkan ke keranjang.', 'error');
                });
        }
    </script>
@endsection
