@extends('default')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Page</title>

    <style>
        .square-card {
            width: 150px; /* Đặt độ rộng của hình vuông */
            height: 150px; /* Đặt chiều cao của hình vuông */
            padding: 20px; /* Đặt padding của hình vuông */
        }
    </style>
</head>
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="row ">
                        <div class="row ">
                            <div class="col-lg-2 col-xs-5">
                                <div class="card h-10 border-info square-card p-2 d-flex flex-column align-items-center justify-content-center" style="background-color: #56c6e2;">
                                    <p class="text-center" >Tổng loại hàng</p>
                                    <i class="fa-regular fa-bag-shopping"></i>
                                    <h3 class="text-center text-black mb-2">{{ $so_luong_loai_hang ?? 0 }}</h3>
                                    <a href="{{ route('loai-hang.index') }}" class="box-footer text-center opacity-40">
                                        Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-5">
                                <div class="card h-10 border-info square-card p-2" style="background-color: #56c6e2;">
                                    <p class="text-center" >Số lượng hàng </p>

                                    <h3 class="text-center text-black mb-2">{{ $so_luong_hang_hoa ?? 0 }}</h3>
                                    <a href="{{ route('hang-hoa.index') }}" class="box-footer text-center opacity-40">
                                        Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-5">
                                <div class="card h-10 border-info square-card p-2" style="background-color: #56c6e2;">
                                    <p class="text-center" >Số hàng hết</p>
                                    <h3 class="text-center text-black mb-2">{{ $so_luong_het_hang ?? 0 }}</h3>
                                    <a href="{{ route('hang-hoa.index') }}" class="box-footer text-center opacity-40" >
                                        Xem chi tiết <i class="fa fa-arrow-circle-right" ></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-5 mb-4 ">
                                <div class="card h-10 border-info square-card p-2" style="background-color: #56c6e2;">
                                    <p class="text-center" >Số nhà cung cấp</p>
                                    <h4 class="text-center text-black mb-2">{{ $so_luong_nha_cung_cap ?? 0 }}</h4>
                                    <a href="{{ route('nha-cung-cap.index') }}" class="box-footer text-center opacity-40">
                                        Xem chi tiết <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-5 mb-4">
                                <div class="card h-10 border-info square-card p-2 bg-info">
                                    <div class="card-header text-center text-center-black">Nhập kho trong ngày</div>
                                    <h4 class="text-center text-black mb-2">{{ number_format ($tien_nhap_kho ?? 0 )}} VNĐ</h4>
                                    <a href="" class="box-footer text-center opacity-40">
                                         </i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-5 mb-4">
                                <div class="card h-10 border-info square-card p-2 bg-info">
                                    <div class="card-header text-center text-center-black"> Xuất kho trong ngày
                                    </div>
                                    <h4 class="text-center text-black mb-2">{{ number_format ($tien_xuat_kho ?? 0 )}} VNĐ</h4>
                                    <a href="" class="box-footer text-center opacity-40">


                                    </a>
                                </div>
                            </div>



                            <div class="col-xxl-6">
                                <div class="card h-90">
                                    <div class="row g-0 col-sep col-sep-md">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="card-title-group mb-4">
                                                    <div class="card-title">
                                                        <h4 class="title">Tiền nhập hàng theo tháng</h4>
                                                    </div>
                                                </div>
                                                <div>
                                                    <canvas id="chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6">
                                <div class="card h-90">
                                    <div class="card-body flex-grow-0 py-2">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h4 class="title">Top hàng hóa theo doanh thu</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-middle mb-0">
                                            <thead class="table-light table-head-sm">
                                                <tr>
                                                    <th class="tb-col"><span class="overline-title">Hàng hóa</span></th>
                                                    <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Xuất kho</span></th>
                                                    <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Doanh thu</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($doanh_thu as $dt)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md flex-shrink-0 media-middle">
                                                                <img src="{{ asset('uploads') }}/{{ $dt->img }}"></div>
                                                            <div class="media-text">
                                                                <a href="{{ route('hang-hoa.show', $dt->ma_hang_hoa) }}"
                                                                    class="title">{{ strlen($dt->ten_hang_hoa) > 20 ? substr($dt->ten_hang_hoa, 0, 20) . '...' : substr($dt->ten_hang_hoa, 0, 20) }}</a>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col tb-col-end tb-col-sm"><span class="small">{{ $dt->so_luong }}</span></td>
                                                    <td class="tb-col tb-col-end tb-col-sm"><span class="small">{{ number_format($dt->doanh_thu, 0, '', '.') }} VNĐ</span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '{{ route('api.tong_chi') }}',
                method: 'GET',
                success: function(response) {
                    let ctx = document.getElementById('chart').getContext('2d');
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Tổng chi theo tháng',
                                data: response.values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        })
    </script>
@endsection
