
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>Phiếu xuất kho</title>
<style>
  body{
    font-family: DejaVu Sans, sans-serif, font-size: 10px;
  }
</style>
</head>

<body >
<div>
<table>
  <thead>
    <tr>
      <th width="200px">
        KHO HÀNG <br> ĐỖ GIA
      <br>

      </th>
      <th width="300px">
        <center>PHIẾU XUẤT KHO</center>
        <center>Ngày xuất: </center>
      </th>
      <th width="50px">
        <center>Mã Xuất: </center>
      </th>
    </tr>
  </thead>

</table>
</div>
<hr>
<center><h2>PHIẾU XUẤT KHO</h2></center>
<table>
  <tr>
    <td width="120px"><strong>Nhân viên lập phiếu:</strong></td> <td></td>
    <td><strong></td>
  </tr>
</table><br><br>
   <table cellpadding="3px" style="border:thin solid;" >
  <thead>
    <tr>


      <td style="border:thin solid;" width="50px"><strong>STT</strong></td>
      <td style="border:thin solid;" width="70px"><strong>Mã hàng hóa</strong></td>
      <td style="border:thin solid;" width="100px"><strong>Tên hàng hóa</strong></td>
      <td style="border:thin solid;" width="50px"><strong>NSX</strong></td>
      <td style="border:thin solid;" width="15px"><strong>Bảo quản(tháng)</strong></td>
      <td style="border:thin solid;" width="20px"><strong>Số lượng</strong></td>
      <td style="border:thin solid;" width="70px"><strong>Giá xuất</strong></td>
      <td style="border:thin solid;" width="70px"><strong>Thành tiền</strong></td>
    </tr>
  </thead>
  <tbody>
    @php
         $result = 0;
           @endphp

        @foreach ($chi_tiet_phieu_xuat as $key => $chi_tiet)
        @php
                  $price = $chi_tiet->so_luong * $chi_tiet->gia_xuat;
                 $result += $price;
             @endphp

        <tr >
          <td style="border:thin blue solid;border-style:dashed;">{{ $key + 1 }}</td>
          <td style="border:thin blue solid;border-style:dashed;">

              {{ $chi_tiet->getChiTiet->getHangHoa->ma_hang_hoa }}

          </td>
          <td style="border:thin blue solid;border-style:dashed;"> {{ $chi_tiet->getChiTiet->getHangHoa->ten_hang_hoa }}</td>
          <td style="border:thin blue solid;border-style:dashed;">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $chi_tiet->getChiTiet->ngay_san_xuat)->format('m/d/Y') }}

          </td>

          <td style="border:thin blue solid;border-style:dashed;" >{{ $chi_tiet->getChiTiet->tg_bao_quan }}

          </td>
          <td style="border:thin blue solid;border-style:dashed;"> {{ $chi_tiet->so_luong }}

          </td>
          <td style="border:thin blue solid;border-style:dashed;">{{ number_format($chi_tiet->gia_xuat, 0, '', '.') }} VNĐ

          </td>
          <td style="border:thin blue solid;border-style:dashed;">{{ number_format($price, 0, '', '.') }} VNĐ

          </td>
          <td style="border:thin blue solid;border-style:dashed;">

          </td>
          <tr>
    <td width="70px">Tổng giá trị xuất: </td>
    
    <td width="70px">{{ number_format($price, 0, '', '.') }} VNĐ</td>
  </tr>
      </tr>
        @endforeach

  </tbody>
</table>
<table class="sumary-table">

</table><br>
<table style="margin-bottom:-300px;">
  <tr>
    <td width="200px"></td>
    <td width="200px"></td>

  </tr>
  <tr>
    <td width="250px" class="customer-title">   <strong>Người lập phiếu</strong></td>
    <td width="250px" class="writer-title"><strong>Người phụ trách vật tư</strong></td>
    <td width="250px" class="writer-title"><strong>Thủ kho</strong></td>
  </tr>
  <tr>
    <td>(Ký và ghi rõ họ tên)</td>
    <td>(Ký và ghi rõ họ tên)</td>
    <td class="writer-name"><span>(Ký và ghi rõ họ tên)</span></td>
  </tr>
</table>
</body>
</html>

