<?php

namespace App\Http\Controllers;
use App\Models\XuatKho;
use App\Models\HangHoa;
use App\Models\ChiTietXuatKho;
use App\Models\ChiTietHangHoa;
use App\Exports\XuatKhoExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class XuatKhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ma_phieu_xuat = XuatKho::latest()->first()->ma_phieu_xuat ?? "PX000000";

        $lastNumber = (int) substr($ma_phieu_xuat, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_xuat, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_xuat = 'PX' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        $phieu_xuat = [];

        XuatKho::orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$phieu_xuat) {
            foreach ($chunk as $phieu) {
                $phieu_xuat[] = $phieu;
            }
        });

        return view('xuatkho.index', compact('phieu_xuat', 'ma_phieu_xuat'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $ma_phieu_xuat = XuatKho::latest()->first()->ma_phieu_xuat ?? "PX000000";

        $lastNumber = (int) substr($ma_phieu_xuat, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_xuat, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_xuat = 'PX' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        return view('xuatkho.create', compact('ma_phieu_xuat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $phieu_xuat = XuatKho::where('ma_phieu_xuat', $code)->firstOrFail();

        $chi_tiet_phieu_xuat = ChiTietXuatKho::where('ma_phieu_xuat', $code)->orderBy('id', 'DESC')->paginate(10);

        return view('xuatkho.show', compact('phieu_xuat', 'chi_tiet_phieu_xuat'));
    }



    public function exportpdf($code)
    {
        $phieu_xuat = XuatKho::where('ma_phieu_xuat', $code)->firstOrFail();

        $chi_tiet_phieu_xuat = ChiTietXuatKho::where('ma_phieu_xuat', $code)->orderBy('id', 'DESC')->paginate(10);

        $data = [
            
            'phieu_xuat'=>$phieu_xuat,
            'chi_tiet_phieu_xuat' => $chi_tiet_phieu_xuat,
        ];

        $pdf = PDF::loadView('xuatkho.xuatkho-pdf', $data);
        return $pdf->download('xuatkho.pdf');
    }
}
