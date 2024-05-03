<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\HangHoa;
use App\Models\LoaiHang;
use App\Models\ChiTietHangHoa;
use Illuminate\Http\Request;
use App\Http\Requests\HangHoaStoreRequest;
use App\Http\Requests\HangHoaUpdateRequest;
use Storage;

class HangHoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hang_hoa = [];

        HangHoa::orderBy('id')->chunkById(100, function ($chunk) use (&$hang_hoa) {
            foreach ($chunk as $hang) {
                if ($hang->getLoaiHang->id_trang_thai != 1) {
                    $hang_hoa[] = $hang;
                }
            }
        });

        return view('hanghoa.index', compact('hang_hoa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loai_hang = LoaiHang::where('id_trang_thai', 3)->get();

        return view('hanghoa.create', compact('loai_hang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HangHoaStoreRequest $request)
    {
        $data = $request->validated();
        $storagePath = public_path('uploads');
        echo $storagePath;
        if ($request->hasFile('change_img')) {
            $avatar = $request->file('change_img');
            $file_name = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads'), $file_name);
        } else {
            $file_name = null; // Đảm bảo biến $fileName được định nghĩa dù có tải lên tệp ảnh hay không
        }

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $hang_hoa = HangHoa::create([
            'ma_hang_hoa' => $data['ma_hang_hoa'],
            'ten_hang_hoa' => $data['ten_hang_hoa'],
            'id_loai_hang' => $data['id_loai_hang'],
            'don_vi_tinh' => $data['don_vi_tinh'],
            'barcode' => $data['barcode'] <= 0 ? null : $data['barcode'],
            'img' => $file_name,
            'mo_ta' => strlen($mo_ta) == 0 ? 'Không có mô tả cụ thể!' : $mo_ta
        ]);

        if ($hang_hoa) {
            Alert::success('Thành công', 'Thêm mới hàng hóa thành công!');
            return redirect()->route('hang-hoa.index');
        } else {
            if ($request->hasFile('change_img') && $file_name != $request->change_img && $file_name != 'hanghoa.jpg') {
    $imagePath = public_path('uploads') . '/hanghoa' . $file_name;
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}
            Alert::error('Thất bại', 'Thêm mới thất bại do đã tồn tại hàng hóa từ trước hoặc do lỗi!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();

        if ($hang_hoa) {
            $chi_tiet_hang_hoa = ChiTietHangHoa::where('ma_hang_hoa', $code)->where('id_trang_thai', 3)->paginate(10);
            $tong = $chi_tiet_hang_hoa->sum(function($h) {
                return $h->gia_nhap * $h->so_luong;
            });
            $hang_hoa->tong = $tong;

            return view('hanghoa.show', compact('hang_hoa', 'chi_tiet_hang_hoa'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy hàng hóa, xin vui lòng thử lại sau!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $loai_hang = LoaiHang::where('id_trang_thai', 3)->get();
        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->first();

        if ($hang_hoa) {
            return view('hanghoa.edit', compact('hang_hoa', 'loai_hang'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy hàng hóa, xin vui lòng thử lại sau!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HangHoaUpdateRequest $request, $code)
    {
        $data = $request->validated();

        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();
        $storagePath = public_path('uploads');
        echo $storagePath;
        if ($request->hasFile('new_image')) {
            $avatar = $request->file('new_image');
            $file_name = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads'), $file_name);
        }

        $ma_hang_hoa = $hang_hoa->ma_hang_hoa;

        if ($request->mo_ta !== null) {
            $mo_ta = json_decode($request->mo_ta);
            if ($mo_ta !== null && is_array($mo_ta->ops) && count($mo_ta->ops) > 0) {
                $mo_ta = $mo_ta->ops[0]->insert;
            } else {
                $mo_ta = ''; // Giá trị mặc định nếu không tồn tại thuộc tính 'ops' hoặc 'ops' trống
            }
        } else {
            $mo_ta = ''; // Giá trị mặc định nếu trường 'mo_ta' là null
        }

        $status = $hang_hoa->update([
            'ma_hang_hoa' => $data['ma_hang_hoa'],
            'ten_hang_hoa' => $data['ten_hang_hoa'],
            'id_loai_hang' => $data['id_loai_hang'],
            'don_vi_tinh' => $data['don_vi_tinh'],
            'barcode' => $data['barcode'] <= 0 ? null : $data['barcode'],
            'img' => $file_name,
            'mo_ta' => strlen($mo_ta) == 0 ? 'Không có mô tả cụ thể!' : $mo_ta
        ]);

        ChiTietHangHoa::where('ma_hang_hoa', $ma_hang_hoa)->update(['ma_hang_hoa' => $data['ma_hang_hoa']]);

        if ($status) {
            if ($request->hasFile('change_img') && $file_name != $request->change_img && $file_name != 'hanghoa.jpg') {
                $imagePath = public_path('uploads') . '/hanghoa' . $file_name;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            Alert::success('Thành công', 'Sửa thông tin hàng hóa thành công!');
            return redirect()->route('hang-hoa.index');
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = HangHoa::destroy($id);
        if ($status) {
            Alert::success('Thành công', 'Xóa thông tin hàng hóa thành công!');
            return redirect()->route('hang-hoa.index');
        } else{
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }
}
