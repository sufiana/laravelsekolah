<?php

namespace App\Http\Controllers;

use App\models\VerifikatorSekolah;
use Illuminate\Http\Request;
use App\models\EvaluasiKuesioner;
use App\models\HasilKuesioner;
use App\models\Sekolah;
use App\models\User;
use App\models\IconGrid;
use App\models\Parameter;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kabupatenkota;
use App\Models\Cabdis;
use App\Models\EvaluasiPengawas;
use App\Models\ValidasiSekolahBersih;
use App\Models\ValidasiSekolahBersihChild;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Symfony\Component\Process\Process; //untuk Ghostscript
use Symfony\Component\Process\InputStream; //untuk Ghostscript
use Symfony\Component\HttpFoundation\StreamedResponse; //untuk Ghostscript


class SekolahBersihController extends Controller
{
    //

    public function index()
    {
        $model = EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/index', [
            'model' => $model
        ]);
    }

    public function indexsekolah()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sekolah = Sekolah::where('id', $user->id_sekolah)->first();
            $periode = DB::table('evaluasi_kuesioner')
                ->select('periode_awal_kuesioner', 'periode_akhir_kuesioner')
                ->where('sekolah', $user->id_sekolah)
                ->distinct()
                ->get();
            $ids = array_filter(explode(',', $sekolah->instrumen));
            $ruang = IconGrid::whereIn('id', $ids)->get();

        } else {
            $sekolah = '';
        }

        $model = EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexsekolah', [
            'model' => $model,
            'sekolah' => $sekolah,
            'periode' => $periode,
            'ruang' => $ruang
        ]);
    }

    public function indexpengawas()
    {
        $model = EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexpengawas', [
            'model' => $model,
            'sekolah' => Sekolah::orderBy('nama')->get(),
        ]);
    }

    public function indexdinas()
    {
        $model = EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexdinas', [
            'model' => $model
        ]);
    }

    //rekap
    public function rekappengawas()
    {
        $model = EvaluasiPengawas::all()->sortBy("id");
        return view('sekolahbersih/rekappengawas', [
            'model' => $model,
            'sekolah' => Sekolah::orderBy('nama')->get(),
        ]);
    }


    public function getDataRekapPengawas(Request $request)
    {
        $periodeAwal = null;
        $periodeAkhir = null;
        $bindings = [];

        if ($request->filled('periode')) {
            [$periodeAwal, $periodeAkhir] = explode(' - ', $request->periode);
            $periodeAwal = trim($periodeAwal);
            $periodeAkhir = trim($periodeAkhir);
        }

        $statusFilter = $request->status;
        $sekolahFilter = $request->id_sekolah; // ambil dari dropdown
        $statusKebersihan = $request->status_kebersihan; // 1-4
        $tindakLanjut = $request->hasil_rekomendasi;    // 1-4
        // Bangun query dinamis
        $query = 'SELECT * FROM validasi_sekolahbersih WHERE 1=1 and status=1';

        if ($periodeAwal && $periodeAkhir) {
            $query .= " AND periode_awal = ? AND periode_akhir = ?";
            $bindings[] = $periodeAwal;
            $bindings[] = $periodeAkhir;
        }

        if (!empty($statusFilter)) {
            $query .= " AND status = ?";
            $bindings[] = $statusFilter;
        }

        if (!empty($sekolahFilter)) {
            $query .= " AND id_sekolah = ?";
            $bindings[] = $sekolahFilter;
        }
        // filter status kebersihan (1-4)
        if (!empty($statusKebersihan)) {
            $query .= " AND rekap_nilai_kebersihan = ?";
            $bindings[] = $statusKebersihan;
        }

        // filter tindak lanjut (1-4)
        if (!empty($tindakLanjut)) {
            $query .= " AND hasil_rekomendasi = ?";
            $bindings[] = $tindakLanjut;
        }

        $model = DB::select($query, $bindings);

        return Datatables::of($model)
            ->editColumn('periode_awal', function ($data) {
                if ($data->periode_awal <> null && $data->periode_akhir) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal));
                }
                return $periode;
            })
            ->editColumn('id_sekolah', function ($data) {
                $a = Sekolah::find($data->id_sekolah);
                if ($a) {
                    $kab = Kabupatenkota::where('kode_kabupaten', $a->kabupaten_kota)->first();
                    if ($kab) {
                        $nama = $a->nama . ' - ' . $kab->nama_kabupaten;
                    } else {
                        $nama = $a->nama;
                    }
                } else {
                    $nama = "-";
                }
                return $nama;
            })
            ->editColumn('tanggal_supervisi_pengawas', function ($data) {
                return !$data->tanggal_supervisi_pengawas ? ' - ' : Date('d-M-Y', strtotime($data->tanggal_supervisi_pengawas));
            })
            ->editColumn('hasil_rekomendasi', function ($data) {
                if ($data->hasil_rekomendasi == 1) {
                    $a = 'Pembinaan';
                } elseif ($data->hasil_rekomendasi == 2) {
                    $a = 'Penguatan';
                } elseif ($data->hasil_rekomendasi == 3) {
                    $a = 'Penghargaan';
                } elseif ($data->hasil_rekomendasi == 4) {
                    $a = 'Monitoring Lanjutan';
                } else {
                    $a = '-';
                }
                return $a;
            })
            ->addColumn('deskripsi', function ($data) {

                $child = DB::table('validasi_sekolahbersih_child')
                    ->where('id_validasi', $data->id)
                    ->get();

                $modalId = 'modalDeskripsi_' . $data->id;

                // Tombol buka modal
                $html = '
<a class="btn btn-primary btn-sm"
   href="javascript:void(0)"
   data-bs-toggle="modal"
   data-bs-target="#' . $modalId . '"
   title="Lihat Detail Validasi">
    <i class="fa fa-search-plus"></i>
</a>

';

                // Modal
                $html .= '
    <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detail Validasi Sekolah Bersih</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center" style="font-size:11px">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2" style="vertical-align:middle; width:30%">
                                        Instrumen
                                    </th>
                                    <th colspan="2">
                                        Penilaian Validasi Kepsek
                                    </th>
                                    <th colspan="2">
                                        Penilaian Verifikator Sekolah
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:10%">Nilai Kebersihan</th>
                                    <th style="width:20%">Keterangan Kebersihan</th>
                                    <th style="width:10%">Nilai Kebersihan</th>
                                    <th style="width:20%">Keterangan Kebersihan</th>
                                </tr>
                            </thead>
                            <tbody>';

                if ($child->count() > 0) {
                    foreach ($child as $row) {
                        $instrumen = IconGrid::find($row->id_ruang);

                        $html .= '
                <tr>
                    <td class="text-start">
                        ' . ($instrumen->nama ?? '-') . '
                    </td>
                    <td>' . ($row->nilai_kebersihan ?? '-') . '</td>
                    <td>' . ($row->keterangan_kebersihan ?? '-') . '</td>
                    <td>' . ($row->nilai_kebersihan_pengawas ?? '-') . '</td>
                    <td>' . ($row->keterangan_kebersihan_pengawas ?? '-') . '</td>
                </tr>';
                    }
                } else {
                    $html .= '
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Data tidak tersedia
                </td>
            </tr>';
                }

                $html .= '
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>';

                return $html;
            })


            ->addColumn('action', function ($model) {
                $button = '
                    <a class="btn btn-primary btn-sm" href="' . route("sekolahbersih.printPengawas", $model->id) . '" id="editbtn">
                        <i class="fa fa-file-pdf-o">
                        </i>
                    </a>
                ';

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['deskripsi', 'action'])
            ->make(true);
    }

    public function rekapsekolah()
    {
        $model = EvaluasiPengawas::all()->sortBy("id");
        return view('sekolahbersih/rekapsekolah', [
            'model' => $model
        ]);
    }


    public function getDataRekapSekolah()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if (!in_array($user->role, [2, 8])) {
            abort(403, 'Unauthorized'); // atau return response()->json(['error' => 'Unauthorized'], 403);
        }

        $model = DB::select("
                    SELECT *
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER (
                                PARTITION BY sekolah, periode_awal_kuesioner, periode_akhir_kuesioner
                                ORDER BY time_created DESC
                            ) AS rn
                        FROM evaluasi_kuesioner
                    ) t
                    WHERE rn = 1 and sekolah = $user->id_sekolah
        ");

        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner', function ($data) {
                if ($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })
            ->editColumn('sekolah', function ($data) {
                $a = Sekolah::find($data->sekolah);
                return !$a || !$data->sekolah ? ' - ' : $a["nama"];

            })
            ->editColumn('tanggal_supervisi', function ($data) {
                return !$data->tanggal_supervisi ? ' - ' : Date('d-M-Y', strtotime($data->tanggal_supervisi));
            })
            ->editColumn('catatan_pengawas', function ($data) {
                $existing = DB::table('evaluasi_pengawas')
                    ->where('sekolah', $data->sekolah)
                    ->where('periode_awal_kuesioner', $data->periode_awal_kuesioner)
                    ->where('periode_akhir_kuesioner', $data->periode_akhir_kuesioner)
                    ->first();

                // Mapping tindak lanjut
                $jenisTindakLanjut = [
                    '1' => 'Pembinaan',
                    '2' => 'Penguatan',
                    '3' => 'Penghargaan',
                    '4' => 'Monitoring Lanjutan',
                ];

                if ($existing) {
                    $statusKepatuhan = 'Status Kepatuhan = ' . $existing->status_kepatuhan;
                    $statusKebersihan = 'Status Kebersihan = ' . $existing->status_kebersihan;
                    $tindakLanjut = 'Tindak Lanjut = ' . ($jenisTindakLanjut[$existing->hasil_rekomendasi] ?? 'Tidak diketahui');

                    $hasil = $statusKepatuhan . '<br>' . $statusKebersihan . '<br>' . $tindakLanjut;
                } else {
                    $hasil = '-';
                }

                return $hasil;
            })

            ->editColumn('id_ruang', function ($data) {
                $sekolahId = $data->sekolah;
                $periodeAwal = $data->periode_awal_kuesioner;
                $periodeAkhir = $data->periode_akhir_kuesioner;

                $hasilKuesioner = DB::table('ruang_sekolah as rs')
                    ->leftJoin('evaluasi_kuesioner as ek', function ($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                        $join->on('ek.id_ruang', '=', 'rs.id')
                            ->where('ek.sekolah', '=', $sekolahId)
                            ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                            ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
                    })
                    ->select(
                        'rs.nama',
                        DB::raw('COALESCE(SUM(ek.score), 0) as score'),
                        DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter')

                    )
                    ->groupBy('rs.id', 'rs.nama')
                    ->orderBy('rs.id')
                    ->get();

                $html = '<div style="font-size: 10px; line-height: 12px">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
                    <div style="flex: 1;">Parameter</div>
                    <div style="width: 80px; text-align:center;">Score</div>
                    <div style="width: 80px; text-align:center;">Penilaian</div>

                    </div>';

                foreach ($hasilKuesioner as $row) {
                    $hasil = $row->score / $row->jumlah_parameter;
                    $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
                        <div style="flex: 1;">' . $row->nama . ' (' . $row->jumlah_parameter . ')' . '</div>
                        <div style="width: 80px; text-align:center;">' . $row->score . '</div>
                        <div style="width: 80px; text-align:center;">' . $hasil . '</div>

                    </div>';
                }

                $html .= '</div>';
                return $html;
            })

            ->addColumn('action', function ($model) {
                $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link sumut' href='" . route("sekolahbersih.print", $model->id) . "' id='printbtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-file-pdf-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                    ";

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['action', 'id_ruang', 'catatan_pengawas'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData()
    {
        $model = EvaluasiKuesioner::orderBy('id', 'ASC')->get();
        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner', function ($data) {
                if ($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })
            ->editColumn('id_ruang', function ($data) {
                return !$data->ruanglist || !$data->id_ruang ? ' - ' : $data->ruanglist["nama"];
            })
            ->editColumn('id_ruang', function ($data) {
                return !$data->ruanglist || !$data->id_ruang ? ' - ' : $data->ruanglist["nama"];
            })
            ->editColumn('id_kuesioner', function ($data) {
                $stringIds = $data->id_kuesioner;  // contoh: "{319,320,321}"
                $arrayIds = explode(',', trim($stringIds, '{}'));

                $hasilKuesioner = DB::table('hasil_kuesioner')
                    ->select('p.parameter', 'hasil_kuesioner.jawaban')
                    ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
                    ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
                    ->whereIn('hasil_kuesioner.id', $arrayIds)
                    ->get();

                $html = '<div style="font-size: 13px;">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
             <div style="flex: 1;">Parameter</div>
             <div style="width: 100px; text-align:center;">Status</div>
             </div>';

                foreach ($hasilKuesioner as $row) {
                    // Status label
                    if ($row->jawaban == 3) {
                        $status = '<span style="color:green;">Bersih</span>';
                    } elseif ($row->jawaban == 2) {
                        $status = '<span style="color:orange;">Cukup Bersih</span>';
                    } elseif ($row->jawaban == 4) {
                        $status = '<span style="color:green;">Sangat Bersih</span>';
                    } else {
                        $status = '<span style="color:red;">Tidak Bersih</span>';
                    }

                    $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
                 <div style="flex: 1;">' . $row->parameter . '</div>
                 <div style="width: 100px; text-align:center;">' . $status . '</div>
              </div>';
                }
                return $html;
            })
            ->addColumn('action', function ($model) {
                if ($model->status_verifikasi_sekolah == 1) {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.print", $model->id) . "' id='printbtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-file-pdf-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                } else {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.verifikasi", $model->id) . "' id='verifikasibtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-check-square fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a href='#' class='table-link danger' data-id='" . $model->id . "' data-nama='" . $model->nama . "' id='deletebtn' data-toggle='modal' data-target='#delModal'>
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span>
                    </a>
                ";
                }

                $button = $button . "</div>";
                return $button;
            })
            ->editColumn('status_verifikasi_sekolah', function ($data) {
                if ($data->status_verifikasi_sekolah == 1) {
                    $statusverifikasisekolah = '<span class="badge text-bg-success">Terverifikasi</span>';
                } else {
                    $statusverifikasisekolah = '<span class="badge rounded-pill text-bg-warning">Belum Verifikasi</span>';
                }
                $html = '<div class="btn-group-horizontal">' . $statusverifikasisekolah . '</div>';
                return $html;

            })
            ->rawColumns(['id_kuesioner', 'action', 'status_verifikasi_sekolah'])
            ->make(true);
    }


    public function getDataSekolah(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $query = EvaluasiKuesioner::where('sekolah', $user->id_sekolah);

            // Filter periode
            if ($request->filled('periode')) {
                [$awal, $akhir] = explode(' - ', $request->periode);
                $query->whereDate('periode_awal_kuesioner', $awal)
                    ->whereDate('periode_akhir_kuesioner', $akhir);
            }

            // Filter ruang
            if ($request->filled('ruang')) {
                $query->where('id_ruang', $request->ruang);
            }

            // Filter status verifikasi
            if ($request->filled('status')) {
                $query->where('status_verifikasi_sekolah', $request->status);
            }

            $model = $query->orderBy('periode_awal_kuesioner', 'DESC')
                ->orderBy('id_ruang', 'ASC')
                ->get();
        } else {
            $model = collect(); // kosongkan koleksi
        }
        //$model=EvaluasiKuesioner::orderBy('id', 'ASC')->get();
        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner', function ($data) {
                if ($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })

            ->editColumn('id_ruang', function ($data) {
                return !$data->ruanglist || !$data->id_ruang ? ' - ' : $data->ruanglist["nama"];
            })
            ->editColumn('id_kuesioner', function ($data) {
                $stringIds = $data->id_kuesioner;  // contoh: "{319,320,321}"
                $arrayIds = explode(',', trim($stringIds, '{}'));

                $hasilKuesioner = DB::table('hasil_kuesioner')
                    ->select('p.parameter', 'hasil_kuesioner.jawaban')
                    ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
                    ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
                    ->whereIn('hasil_kuesioner.id', $arrayIds)
                    ->orderBy('p.id')
                    ->get();

                $html = '<div style="font-size: 10px; line-height: 12px">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
             <div style="flex: 1;">Parameter</div>
             <div style="width: 100px; text-align:center;">Status</div>
             </div>';

                foreach ($hasilKuesioner as $row) {
                    // Status label
                    if ($row->jawaban == 3) {
                        $status = '<span style="color:green;">Bersih</span>';
                    } elseif ($row->jawaban == 2) {
                        $status = '<span style="color:orange;">Cukup Bersih</span>';
                    } elseif ($row->jawaban == 4) {
                        $status = '<span style="color:green;">Sangat Bersih</span>';
                    } else {
                        $status = '<span style="color:red;">Tidak Bersih</span>';
                    }

                    $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
                 <div style="flex: 1;">' . $row->parameter . '</div>
                 <div style="width: 100px; text-align:center;">' . $status . '</div>
              </div>';
                }
                return $html;
            })
            ->addColumn('action', function ($model) {
                if ($model->status_verifikasi_sekolah == 1) {
                    $button = '
                            <a class="btn btn-primary btn-sm" href="' . route("sekolahbersih.edit", $model->id) . '" id="editbtn" >
                              <i class="fa fa-edit">
                              </i>
                            </a>
                            <a class="btn btn-success btn-sm" href="' . route("sekolahbersih.print", $model->id) . '" id="printbtn" >
                                <i class="fa fa-file-pdf-o">
                                </i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-id="' . $model->id . '" data-nama="' . $model->nama . '" id="deletebtn" data-toggle="modal" data-target="#delModal">
                                <i class="fa fa-trash">
                                </i>
                            </a>
                ';
                } else {
                    $button = '
                            <a class="btn btn-primary btn-sm" href="' . route("sekolahbersih.edit", $model->id) . '" id="editbtn">
                              <i class="fa fa-edit">
                              </i>
                            </a>
                            <a class="btn btn-success btn-sm" href="' . route("sekolahbersih.verifikasi", $model->id) . '" id="verifikasibtn" >
                                <i class="fa fa-check-square">
                                </i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#">
                                <i class="fa fa-trash">
                                </i>
                            </a>
                ';
                }

                $button = $button . "</div>";
                return $button;
            })
            ->editColumn('status_verifikasi_sekolah', function ($data) {
                if ($data->status_verifikasi_sekolah == 1) {
                    $statusverifikasisekolah = '<span class="badge text-bg-success">Terverifikasi</span>';
                } else {
                    $statusverifikasisekolah = '<span class="badge rounded-pill text-bg-warning">Belum Verifikasi</span>';
                }
                $html = '<div class="btn-group-horizontal">' . $statusverifikasisekolah . '</div>';
                return $html;

            })
            ->rawColumns(['id_kuesioner', 'action', 'status_verifikasi_sekolah'])
            ->make(true);
    }

    public function getDataPengawas(Request $request)
    {
        $periodeAwal = null;
        $periodeAkhir = null;
        $bindings = [];

        if ($request->filled('periode')) {
            [$periodeAwal, $periodeAkhir] = explode(' - ', $request->periode);
            $periodeAwal = trim($periodeAwal);
            $periodeAkhir = trim($periodeAkhir);
        }

        $statusFilter = $request->status;
        $sekolahFilter = $request->id_sekolah; // ambil dari dropdown
        $statusKebersihan = $request->status_kebersihan; // 1-4
        $tindakLanjut = $request->hasil_rekomendasi;    // 1-4
        // Bangun query dinamis
        $query = 'SELECT * FROM validasi_sekolahbersih WHERE 1=1';

        if ($periodeAwal && $periodeAkhir) {
            $query .= " AND periode_awal = ? AND periode_akhir = ?";
            $bindings[] = $periodeAwal;
            $bindings[] = $periodeAkhir;
        }

        if (!empty($statusFilter)) {
            $query .= " AND status = ?";
            $bindings[] = $statusFilter;
        }

        if (!empty($sekolahFilter)) {
            $query .= " AND id_sekolah = ?";
            $bindings[] = $sekolahFilter;
        }
        // filter status kebersihan (1-4)
        if (!empty($statusKebersihan)) {
            $query .= " AND rekap_nilai_kebersihan = ?";
            $bindings[] = $statusKebersihan;
        }

        // filter tindak lanjut (1-4)
        if (!empty($tindakLanjut)) {
            $query .= " AND hasil_rekomendasi = ?";
            $bindings[] = $tindakLanjut;
        }

        $model = DB::select($query, $bindings);

        return Datatables::of($model)
            ->editColumn('periode_awal', function ($data) {
                if ($data->periode_awal <> null && $data->periode_akhir) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal));
                }
                return $periode;
            })
            ->editColumn('id_sekolah', function ($data) {
                $a = Sekolah::find($data->id_sekolah);
                if ($a) {
                    $kab = Kabupatenkota::where('kode_kabupaten', $a->kabupaten_kota)->first();
                    if ($kab) {
                        $nama = $a->nama . ' - ' . $kab->nama_kabupaten;
                    } else {
                        $nama = $a->nama;
                    }
                } else {
                    $nama = "-";
                }
                return $nama;
            })
            ->editColumn('tanggal_supervisi_pengawas', function ($data) {
                return !$data->tanggal_supervisi_pengawas ? ' - ' : Date('d-M-Y', strtotime($data->tanggal_supervisi_pengawas));
            })
            ->editColumn('hasil_rekomendasi', function ($data) {
                if ($data->hasil_rekomendasi == 1) {
                    $a = 'Pembinaan';
                } elseif ($data->hasil_rekomendasi == 2) {
                    $a = 'Penguatan';
                } elseif ($data->hasil_rekomendasi == 3) {
                    $a = 'Penghargaan';
                } elseif ($data->hasil_rekomendasi == 4) {
                    $a = 'Monitoring Lanjutan';
                } else {
                    $a = '-';
                }
                return $a;
            })
            ->addColumn('deskripsi', function ($data) {

                $child = DB::table('validasi_sekolahbersih_child')
                    ->where('id_validasi', $data->id)
                    ->get();

                $modalId = 'modalDeskripsi_' . $data->id;

                // Tombol buka modal
                $html = '
<a class="btn btn-primary btn-sm"
   href="javascript:void(0)"
   data-bs-toggle="modal"
   data-bs-target="#' . $modalId . '"
   title="Lihat Detail Validasi">
    <i class="fa fa-search-plus"></i>
</a>

';

                // Modal
                $html .= '
    <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detail Validasi Sekolah Bersih</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm text-center" style="font-size:11px">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2" style="vertical-align:middle; width:30%">
                                        Instrumen
                                    </th>
                                    <th colspan="2">
                                        Penilaian Validasi Kepsek
                                    </th>
                                    <th colspan="2">
                                        Penilaian Verifikator Sekolah
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:10%">Nilai Kebersihan</th>
                                    <th style="width:20%">Keterangan Kebersihan</th>
                                    <th style="width:10%">Nilai Kebersihan</th>
                                    <th style="width:20%">Keterangan Kebersihan</th>
                                </tr>
                            </thead>
                            <tbody>';

                if ($child->count() > 0) {
                    foreach ($child as $row) {
                        $instrumen = IconGrid::find($row->id_ruang);

                        $html .= '
                <tr>
                    <td class="text-start">
                        ' . ($instrumen->nama ?? '-') . '
                    </td>
                    <td>' . ($row->nilai_kebersihan ?? '-') . '</td>
                    <td>' . ($row->keterangan_kebersihan ?? '-') . '</td>
                    <td>' . ($row->nilai_kebersihan_pengawas ?? '-') . '</td>
                    <td>' . ($row->keterangan_kebersihan_pengawas ?? '-') . '</td>
                </tr>';
                    }
                } else {
                    $html .= '
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Data tidak tersedia
                </td>
            </tr>';
                }

                $html .= '
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>';

                return $html;
            })


            ->addColumn('action', function ($model) {
                $button = '
                    <a class="btn btn-primary btn-sm" href="' . route("sekolahbersih.verifikasiPengawas", $model->id) . '" id="editbtn">
                        <i class="fa fa-edit">
                        </i>
                    </a>
                ';

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['deskripsi', 'action'])
            ->make(true);
    }


    public function getDataDinas()
    {
        $model = DB::select("
                    SELECT *
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER (
                                PARTITION BY sekolah, periode_awal_kuesioner, periode_akhir_kuesioner
                                ORDER BY time_created DESC
                            ) AS rn
                        FROM evaluasi_kuesioner
                    ) t
                    WHERE rn = 1
        ");
        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner', function ($data) {
                if ($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })
            ->editColumn('sekolah', function ($data) {
                $a = Sekolah::find($data->sekolah);
                return !$a || !$data->sekolah ? ' - ' : $a["nama"];

            })
            // ->editColumn('id_ruang',function ($data){
            //     $a= IconGrid::find($data->id_ruang);
            //     return !$a || !$data->id_ruang ?  ' - ' : $a["nama"]  ;
            // })

            ->editColumn('id_ruang', function ($data) {
                $sekolahId = $data->sekolah;
                $periodeAwal = $data->periode_awal_kuesioner;
                $periodeAkhir = $data->periode_akhir_kuesioner;

                $hasilKuesioner = DB::table('ruang_sekolah as rs')
                    ->leftJoin('evaluasi_kuesioner as ek', function ($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                        $join->on('ek.id_ruang', '=', 'rs.id')
                            ->where('ek.sekolah', '=', $sekolahId)
                            ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                            ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
                    })
                    ->select(
                        'rs.nama',
                        DB::raw('COALESCE(SUM(ek.score), 0) as score'),
                        DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter')

                    )
                    ->groupBy('rs.id', 'rs.nama')
                    ->orderBy('rs.id')
                    ->get();

                $html = '<div style="font-size: 10px; line-height: 12px">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
         <div style="flex: 1;">Parameter</div>
         <div style="width: 80px; text-align:center;">Status</div>
         </div>';

                foreach ($hasilKuesioner as $row) {
                    $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
             <div style="flex: 1;">' . $row->nama . '</div>
             <div style="width: 80px; text-align:center;">' . $row->score . '</div>
            <div style="width: 80px; text-align:center;">' . $row->jumlah_parameter . '</div>

          </div>';
                }

                $html .= '</div>';
                return $html;
            })
            ->addColumn('action', function ($model) {
                if ($model->status_verifikasi_sekolah == 1) {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.print", $model->id) . "' id='printbtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-file-pdf-o fa-stack-1x fa-inverse'></i></span>
                    </a>

                ";
                } else {
                    $button = "
                    <div class='btn-group-horizontal'>
                    <a class='table-link success' href='" . route("sekolahbersih.edit", $model->id) . "' id='editbtn' >
                        <span class='fa-stack'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span>
                    </a>
                    <a class='table-link sumut' href='" . route("sekolahbersih.verifikasi", $model->id) . "' id='verifikasibtn' >
                        <span class='fa-stack' ><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-check-square fa-stack-1x fa-inverse'></i></span>
                    </a>

                ";
                }

                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['id_ruang', 'action'])
            ->make(true);
    }

    public function indexValidasi()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sekolah = Sekolah::where('id', $user->id_sekolah)->first();
            $periode = DB::table('evaluasi_kuesioner')
                ->select('periode_awal_kuesioner', 'periode_akhir_kuesioner')
                ->where('sekolah', $user->id_sekolah)
                ->distinct()
                ->get();
            $ids = array_filter(explode(',', $sekolah->instrumen));
            $ruang = IconGrid::whereIn('id', $ids)->get();
        } else {
            $sekolah = '';
        }

        $model = EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexvalidasi', [
            'model' => $model,
            'sekolah' => $sekolah,
            'periode' => $periode,
            'ruang' => $ruang
        ]);
    }

    public function indexSubmitValidasi()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sekolah = Sekolah::where('id', $user->id_sekolah)->first();
            $periode = DB::table('evaluasi_kuesioner')
                ->select('periode_awal_kuesioner', 'periode_akhir_kuesioner')
                ->where('sekolah', $user->id_sekolah)
                ->distinct()
                ->get();
            $ids = array_filter(explode(',', $sekolah->instrumen));
            $ruang = IconGrid::whereIn('id', $ids)->get();
        } else {
            $sekolah = '';
        }

        $model = EvaluasiKuesioner::all()->sortBy("id");
        return view('sekolahbersih/indexsubmitvalidasi', [
            'model' => $model,
            'sekolah' => $sekolah,
            'periode' => $periode,
            'ruang' => $ruang
        ]);
    }

    public function getDataValidasi(Request $request)
    {
        $user = Auth::user();
        $id_sekolah = $user->id_sekolah;

        // Ambil filter dari request
        $periodeAwal = null;
        $periodeAkhir = null;
        if ($request->filled('periode')) {
            [$periodeAwal, $periodeAkhir] = explode(' - ', $request->periode);
            $periodeAwal = trim($periodeAwal);
            $periodeAkhir = trim($periodeAkhir);
        }

        $statusFilter = $request->status;

        // Bangun query dinamis
        $query = "
        SELECT *
        FROM (
            SELECT *,
                ROW_NUMBER() OVER (
                    PARTITION BY sekolah, periode_awal_kuesioner, periode_akhir_kuesioner
                    ORDER BY time_created DESC
                ) AS rn
            FROM evaluasi_kuesioner
            WHERE sekolah = ?
    ";

        $bindings = [$id_sekolah];

        if ($periodeAwal && $periodeAkhir) {
            $query .= " AND periode_awal_kuesioner = ? AND periode_akhir_kuesioner = ?";
            $bindings[] = $periodeAwal;
            $bindings[] = $periodeAkhir;
        }

        if ($statusFilter !== null && $statusFilter !== '') {
            $query .= " AND status_verifikasi_sekolah = ?";
            $bindings[] = $statusFilter;
        }

        $query .= ") t WHERE rn = 1";

        $model = DB::select($query, $bindings);

        return Datatables::of($model)
            ->editColumn('periode_awal_kuesioner', function ($data) {
                if ($data->periode_awal_kuesioner <> null && $data->periode_akhir_kuesioner) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir_kuesioner));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal_kuesioner));
                }
                return $periode;
            })
            ->editColumn('sekolah', function ($data) {
                $a = Sekolah::find($data->sekolah);
                return !$a || !$data->sekolah ? ' - ' : $a["nama"];

            })
            ->editColumn('tanggal_supervisi', function ($data) {
                return !$data->tanggal_supervisi ? ' - ' : Date('d-M-Y', strtotime($data->tanggal_supervisi));
            })
            ->editColumn('id_ruang', function ($data) {
                $sekolahId = $data->sekolah;
                $periodeAwal = $data->periode_awal_kuesioner;
                $periodeAkhir = $data->periode_akhir_kuesioner;
                $sekolah = Sekolah::find($sekolahId);
                $ids = array_filter(explode(',', $sekolah->instrumen));

                $hasilKuesioner = DB::table('ruang_sekolah as rs')
                    ->whereIn('rs.id', $ids) // ✅ filter berdasarkan instrumen
                    ->leftJoin('evaluasi_kuesioner as ek', function ($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                        $join->on('ek.id_ruang', '=', 'rs.id')
                            ->where('ek.sekolah', '=', $sekolahId)
                            ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                            ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
                    })
                    ->select(
                        'ek.id as evaluasi_id',
                        'rs.id as id_ruang',
                        'rs.nama',
                        DB::raw('COALESCE(SUM(ek.score), 0) as score'),
                        DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter'),
                        DB::raw("
                            CASE 
                                WHEN MAX(ek.status_verifikasi_sekolah) = 1 
                                THEN 'Terverifikasi'
                                ELSE 'Belum verifikasi'
                            END as status_verifikasi
                        ")
                    )
                    ->groupBy('rs.id', 'rs.nama', 'evaluasi_id')
                    ->orderBy('rs.id')
                    ->get();

                $html = '<div style="font-size: 10px; line-height: 12px">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
                        <div style="flex: 1;">Parameter</div>
                        <div style="width: 80px; text-align:center;">Score</div>
                        <div style="width: 80px; text-align:center;">Status Verifikasi</div>
                        <div style="width: 80px; text-align:center;">Penilaian</div>
                        </div>';

                foreach ($hasilKuesioner as $row) {
                    $urlcreate = route("sekolahbersih.create", $row->id_ruang);
                    $urlverify = $row->evaluasi_id ? route("sekolahbersih.verifikasi", $row->evaluasi_id) : '#';
                    $hasil = $row->score / $row->jumlah_parameter;
                    if ($row->score > 0 && $row->status_verifikasi == 'Belum verifikasi' && $row->evaluasi_id) {
                        $hasila = '<a href="' . $urlverify . '">Verifikasi</a>';
                    } elseif ($row->score == 0 && $row->status_verifikasi == 'Belum verifikasi') {
                        $hasila = '<a href="' . $urlcreate . '">Silahkan isi</a>';
                    } else {
                        $hasila = '<div style="width: 80px; text-align:center;">' . $row->status_verifikasi . '</div>';
                    }
                    $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
                                <div style="flex: 1;">' . $row->nama . ' (' . $row->jumlah_parameter . ')' . '</div>
                                <div style="width: 80px; text-align:center;">' . ($row->score == 0 ? 'Belum Isi' : $row->score) . '</div>
                                <div style="width: 80px; text-align:center;">' . $hasila . '</div>
                                <div style="width: 80px; text-align:center;">' . $hasil . '</div>
                            </div>';
                }

                $html .= '</div>';
                return $html;
            })

            ->addColumn('action', function ($model) {
                $button = '
                    <a class="btn btn-primary btn-sm" href="' . route("sekolahbersih.validasi", $model->id) . '" id="editbtn">
                        <i class="fa fa-edit">
                        </i>
                    </a>';
                // $button = '
                //     <a class="btn btn-success btn-sm" href="' . route("sekolahbersih.printCabdis", $model->id) . '" id="printbtn" >
                //         <i class="fa fa-file-pdf-o">
                //         </i>
                //     </a>
                //     <a class="btn btn-info btn-sm" href="' . route("sekolahbersih.printRekapCabdisSekolah", $model->id) . '" id="printbtn1" style="background-color: #17a2b8; border-color: #17a2b8; color: #fff;" >
                //         <i class="fa fa-file-pdf-o">
                //         </i>
                //     </a>
                // ';
                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['catatan_pengawas', 'id_ruang', 'action'])
            ->make(true);
    }

    public function getDataSubmitValidasi(Request $request)
    {
        $user = Auth::user();
        $id_sekolah = $user->id_sekolah;
        // Ambil filter dari request
        $periodeAwal = null;
        $periodeAkhir = null;
        if ($request->filled('periode')) {
            [$periodeAwal, $periodeAkhir] = explode(' - ', $request->periode);
            $periodeAwal = trim($periodeAwal);
            $periodeAkhir = trim($periodeAkhir);
        }

        $statusFilter = $request->status;

        // Bangun query dinamis
        $query = "
        SELECT *       
            FROM validasi_sekolahbersih
            WHERE id_sekolah = ? ";

        $bindings = [$id_sekolah];

        if ($periodeAwal && $periodeAkhir) {
            $query .= " AND periode_awal = ? AND periode_akhir = ?";
            $bindings[] = $periodeAwal;
            $bindings[] = $periodeAkhir;
        }

        $model = DB::select($query, $bindings);

        return Datatables::of($model)
            ->editColumn('periode_awal', function ($data) {
                if ($data->periode_awal <> null && $data->periode_akhir) {
                    $periode = date('d-M-Y', strtotime($data->periode_awal)) . ' s/d ' . date('d-M-Y', strtotime($data->periode_akhir));
                } else {
                    $periode = date('d-M-Y', strtotime($data->periode_awal));
                }
                return $periode;
            })
            ->editColumn('id_sekolah', function ($data) {
                $a = Sekolah::find($data->id_sekolah);
                return !$a || !$data->id_sekolah ? ' - ' : $a["nama"];

            })
            ->editColumn('tanggal_supervisi_verifikasi', function ($data) {
                return !$data->tanggal_supervisi_verifikasi ? ' - ' : Date('d-M-Y', strtotime($data->tanggal_supervisi_verifikasi));
            })
            ->editColumn('disusun_oleh', function ($data) {
                $verifikator = VerifikatorSekolah::findOrFail($data->disusun_oleh);
                if ($data->disusun_oleh == null || !$verifikator) {
                    return ' - ';
                } else {
                    return $verifikator["verifikator"];
                }
            })
            ->editColumn('mengetahui', function ($data) {
                $verifikator = VerifikatorSekolah::where('id', $data->mengetahui)->first();
                if ($data->mengetahui == null || !$verifikator) {
                    return ' - ';
                } else {
                    return $verifikator["verifikator"];
                }
            })
            ->addColumn('deskripsi', function ($data) {
                $child = DB::table('validasi_sekolahbersih_child')
                    ->where('id_validasi', $data->id)
                    ->get();
                $html = '<div style="font-size: 9px; line-height: 12px">';
                $html .= '<div style="display: flex; font-weight:bold; border-bottom: 1px solid #ddd;">
                        <div style="flex: 1;">Instrumen</div>
                        <div style="width: 10%; text-align:center;">Score</div>
                        <div style="width: 14%; text-align:center;">Penilaian</div>
                        </div>';
                foreach ($child as $row) {
                    $instrumen = IconGrid::find($row->id_ruang);
                    $html .= '<div style="display: flex; border-bottom: 1px solid #eee; padding: 2px 0;">
                                <div style="flex: 1;">' . $instrumen->nama . '</div>
                                <div style="width: 10%; text-align:center;">' . $row->nilai_kebersihan . '</div>
                                <div style="width: 14%; text-align:center;">' . $row->keterangan_kebersihan . '</div>
                            </div>';
                }
                $html .= '</div>';
                return $html;
            })

            ->addColumn('action', function ($model) {
                $button = '
                    <a class="btn btn-primary btn-sm" href="' . route("sekolahbersih.showValidasi", $model->id) . '" id="showbtn">
                        <i class="fa fa-search-plus">
                        </i>
                    </a>
                    <a class="btn btn-success btn-sm" href="' . route("sekolahbersih.printCabdisSekolah", $model->id) . '" id="printbtn" >
                        <i class="fa fa-file-pdf-o">
                        </i>
                    </a>
                    <a class="btn btn-info btn-sm" href="' . route("sekolahbersih.printRekapCabdisSekolah", $model->id) . '" id="printbtn1" style="background-color: #17a2b8; border-color: #17a2b8; color: #fff;" >
                        <i class="fa fa-file-pdf-o">
                        </i>
                    </a>
                ';
                $button = $button . "</div>";
                return $button;
            })
            ->rawColumns(['deskripsi', 'action'])
            ->make(true);
    }


    public function create($id_ruang, Request $request)
    {
        // Ambil model & parameter
        $model = IconGrid::find($id_ruang);
        $parameter = Parameter::where('id_ruang', $id_ruang)->get();

        // Default periode
        $periode_awal = null;
        $periode_akhir = null;

        // ========================================================================
        // 1) 📌 PRIORITAS PERTAMA → Periode langsung dari parameter URL
        //    contoh: ?periode_awal=2025-12-01&periode_akhir=2025-12-02
        // ========================================================================
        if ($request->filled('periode_awal') && $request->filled('periode_akhir')) {
            $periode_awal = $request->periode_awal;
            $periode_akhir = $request->periode_akhir;
        }

        // ========================================================================
        // 2) 📌 PRIORITAS KEDUA → Periode dari halaman validasi (via back=...)
        // ========================================================================
        elseif ($request->filled('back')) {

            $url = $request->back;

            // cek back=.../validasi/{id}
            if (preg_match('/validasi\/(\d+)/', $url, $match)) {

                $idValidasi = $match[1];

                $validasi = DB::table('evaluasi_kuesioner')
                    ->where('id', $idValidasi)
                    ->first();

                if ($validasi) {
                    $periode_awal = $validasi->periode_awal_kuesioner;
                    $periode_akhir = $validasi->periode_akhir_kuesioner;
                }
            }
        }

        // ========================================================================
        // Return ke view
        // ========================================================================
        return view('sekolahbersih.create', [
            'model' => $model,
            'parameter' => $parameter,
            'id_ruang' => $id_ruang,
            'periode_awal' => $periode_awal,
            'periode_akhir' => $periode_akhir,
            'back' => $request->back
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input dasar
        $validator = Validator::make($request->all(), [
            'id_ruang' => 'required|integer|exists:ruang_sekolah,id', // Pastikan tabel sesuai
            'periode' => 'required|string',
            'jawaban' => 'required|array',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data user dan sekolah
        $id_user = Auth::check() ? Auth::id() : 3;
        $user = Auth::user();

        $id_sekolah = null;
        if ($user) {
            $id_sekolah = $user->id_sekolah ?? null;
            $sekolah = Sekolah::where('id', $id_sekolah)->first();

        }

        // Fallback untuk Dinas Pendidikan
        if (!$id_sekolah) {
            $id_sekolah = 103; // ID sekolah default untuk dinas
            $sekolah = Sekolah::where('id', $id_sekolah)->first();

        }

        if (!$id_sekolah) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Tidak dapat menentukan sekolah.'], 422)
                : redirect()->back()->withErrors(['Sekolah tidak ditemukan.']);
        }

        // Parse periode
        $parts = explode(' - ', $request->periode);
        $periode_awal = $parts[0] ?? now()->format('Y-m-d');
        $periode_akhir = $parts[1] ?? now()->format('Y-m-d');

        // Cek duplikasi: tidak boleh isi ulang untuk ruang + periode + sekolah yang sama
        $existing = EvaluasiKuesioner::where('id_ruang', $request->id_ruang)
            ->where('sekolah', $id_sekolah)
            ->whereDate('periode_awal_kuesioner', $periode_awal)
            ->whereDate('periode_akhir_kuesioner', $periode_akhir)
            ->exists();

        if ($existing) {
            $msg = 'Data untuk Instrumen dan periode ini sudah pernah diisi.';
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => $msg], 422)
                : redirect()->back()->withErrors([$msg]);
        }

        DB::beginTransaction();
        try {
            $totalScore = 0;
            $hasilKuesionerIds = [];

            // Simpan setiap jawaban ke HasilKuesioner
            foreach ($request->jawaban as $id_parameter => $jawaban) {
                $hasil = HasilKuesioner::create([
                    'id_sekolah' => $id_sekolah,
                    'id_user' => $id_user,
                    'id_parameter' => $id_parameter,
                    'id_ruang' => $request->id_ruang,
                    'jawaban' => $jawaban,
                    'deskripsi_jawaban' => $request->alasan[$id_parameter] ?? null,
                    'tahun_ajaran' => env('TAHUN_AJARAN', 1),
                    'periode' => 1,
                    'periode_awal_kuesioner' => $periode_awal,
                    'periode_akhir_kuesioner' => $periode_akhir,
                ]);
                $hasilKuesionerIds[] = $hasil->id;
                $totalScore += (int) $jawaban;
            }

            // Simpan ke EvaluasiKuesioner
            $evaluasi = EvaluasiKuesioner::create([
                'id_kuesioner' => '{' . implode(',', $hasilKuesionerIds) . '}',
                'sekolah' => $id_sekolah,
                'periode_awal_kuesioner' => $periode_awal,
                'periode_akhir_kuesioner' => $periode_akhir,
                'status_verifikasi_sekolah' => 0,
                'status_evaluasi_pengawas' => 0,
                'status_evaluasi_cabdis' => 0,
                'id_ruang' => $request->id_ruang,
                'score' => $totalScore,
                'hasil_score' => count($request->jawaban) > 0 ? $totalScore / count($request->jawaban) : 0,
            ]);

            //update kolom Hasil_kuesioner isi id dari evaluasi_kuesioner nya
            HasilKuesioner::whereIn('id', $hasilKuesionerIds)->update(['id_evaluasi_kuesioner' => $evaluasi->id]);

            // Ambil ruang berdasarkan instrumen sekolah
            if (isset($sekolah->instrumen) && trim($sekolah->instrumen) !== '') {
                $instrumenIds = array_filter(explode(',', $sekolah->instrumen));
                $allRuang = IconGrid::whereIn('id', $instrumenIds)->select('id', 'nama')->orderByRaw("array_position(ARRAY[" . implode(',', $instrumenIds) . "], id)")->get();
            } else {
                $allRuang = IconGrid::select('id', 'nama')->orderBy('id')->get();
            }

            // Ruang yang sudah diisi untuk periode ini
            $ruangTerisi = EvaluasiKuesioner::where('sekolah', $id_sekolah)
                ->whereDate('periode_awal_kuesioner', $periode_awal)
                ->whereDate('periode_akhir_kuesioner', $periode_akhir)
                ->pluck('id_ruang')
                ->toArray();

            // Ruang yang belum diisi
            $ruangBelumIsi = $allRuang->whereNotIn('id', $ruangTerisi);

            // Format data untuk frontend (pastikan array)
            $dataRuangBelumIsi = $ruangBelumIsi->map(function ($r) {
                return [
                    'id' => $r->id,
                    'nama' => $r->nama,
                    'url' => route('sekolahbersih.create', $r->id)
                ];
            })->values()->toArray(); // 👉 toArray() wajib!

            $nextRuang = $ruangBelumIsi->first();
            $nextUrl = $nextRuang ? route('sekolahbersih.create', $nextRuang->id) : route('sekolahbersih.index');
            $indexUrl = route('sekolahbersih.indexsekolah');

            DB::commit();

            // 🔥 Hanya kirim JSON jika AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kuesioner berhasil disimpan.',
                    'ruang_belum_isi' => $dataRuangBelumIsi,
                    'next_url' => $nextUrl,
                    'index_url' => $indexUrl,
                    'periode_awal' => $periode_awal,
                    'periode_akhir' => $periode_akhir
                ]);
            }

            // Jika bukan AJAX (form biasa), redirect
            return redirect()->to($nextUrl)->with('berhasil', 'Berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving kuesioner: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withErrors(['Gagal menyimpan: ' . $e->getMessage()]);
        }
    }


    public function saveVerifikasi(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute Wajib diisi',
        ];

        $validator = Validator::make($request->all(), [
            'user_verifikasi' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        try {
            $post = EvaluasiKuesioner::where('id', $request->id)->first();

            $post->user_verifikasi = $request->user_verifikasi;
            $post->user_verifikasi_guru_piket = $request->user_verifikasi_guru_piket ?? null;
            $post->tanggal_verifikasi = date('Y-m-d');
            $post->status_verifikasi_sekolah = 1;

            $post->save();

            Session::flash('berhasil', 'Verifikasi Berhasil');

            // 🔥 Kalau ada parameter ?back=xxxxx → kembali ke halaman itu
            if ($request->filled('back')) {
                return redirect($request->back);
            }

            // default redirect
            return redirect()->route('sekolahbersih.indexsekolah');

        } catch (\Exception $e) {

            if ($request->filled('back')) {
                return redirect($request->back)->withErrors(['Gagal' => [$e->getMessage()]]);
            }

            return back()->withErrors(['Gagal' => [$e->getMessage()]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = EvaluasiKuesioner::findOrFail($id);
        $ruang = IconGrid::find($model->id_ruang);
        $sekolah = Sekolah::find($model->sekolah);
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));
        $user = Auth::user();
        $instrumen = Parameter::where('id_ruang', $model->id_ruang)->get();
        $maxinstrumen = $instrumen->count() * 4;

        $hasilKuesioner = DB::table('hasil_kuesioner')
            ->select('p.parameter', 'hasil_kuesioner.jawaban', 'hasil_kuesioner.deskripsi_jawaban')
            ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
            ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
            ->whereIn('hasil_kuesioner.id', $arrayIds)
            ->get();

        $verifikator = DB::table('verifikator_sekolah')
            ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
            ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
            ->where('verifikator_sekolah.id', $model->user_verifikasi)
            ->first();

        return view('sekolahbersih.detail', compact('model', 'ruang', 'hasilKuesioner', 'sekolah', 'kabupaten', 'verifikator', 'user', 'instrumen', 'maxinstrumen'));
    }

    public function verifikasi($id)
    {
        $model = EvaluasiKuesioner::findOrFail($id);
        $ruang = IconGrid::find($model->id_ruang);
        $sekolah = Sekolah::find($model->sekolah);
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));
        $verifikator = DB::table('verifikator_sekolah')
            ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
            ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
            ->where('verifikator_sekolah.id_sekolah', $model->sekolah)
            ->get();

        $hasilKuesioner = DB::table('hasil_kuesioner')
            ->select('p.parameter', 'hasil_kuesioner.jawaban', 'hasil_kuesioner.deskripsi_jawaban')
            ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
            ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
            ->whereIn('hasil_kuesioner.id', $arrayIds)
            ->get();
        $instrumen = Parameter::where('id_ruang', $model->id_ruang)->get();
        $maxinstrumen = $instrumen->count() * 4;
        return view('sekolahbersih.verifikasi', compact('model', 'ruang', 'hasilKuesioner', 'sekolah', 'kabupaten', 'verifikator', 'instrumen', 'maxinstrumen'));
    }

    public function validasi($id)
    {
        $model = EvaluasiKuesioner::findOrFail($id);
        $sekolah = Sekolah::find($model->sekolah);
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
        $sekolahId = $model->sekolah;
        $periodeAwal = $model->periode_awal_kuesioner;
        $periodeAkhir = $model->periode_akhir_kuesioner;

        $instrumen = !empty($sekolah->instrumen) ? explode(',', $sekolah->instrumen) : null;

        $hasilKuesioner = DB::table('ruang_sekolah as rs')
            ->when(!empty($instrumen), function ($query) use ($instrumen) {
                $query->whereIn('rs.id', $instrumen);
            })
            ->leftJoin('evaluasi_kuesioner as ek', function ($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                $join->on('ek.id_ruang', '=', 'rs.id')
                    ->where('ek.sekolah', '=', $sekolahId)
                    ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                    ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
            })
            ->select(
                DB::raw('COALESCE(max(ek.id), 0) as idnya'),
                'rs.nama',
                'rs.id as id_ruang',
                DB::raw('COALESCE(SUM(ek.score), 0) as score'),
                DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter'),
            )
            ->groupBy('rs.id', 'rs.nama')
            ->orderBy('rs.id')
            ->get();


        $verifikator = DB::table('verifikator_sekolah')
            ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
            ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
            ->where('verifikator_sekolah.id_sekolah', $model->sekolah)
            ->get();

        $hasil = DB::table('ruang_sekolah as rs')
            ->join('sekolah as s', function ($join) use ($sekolah) {
                $join->on(DB::raw('rs.id::text'), '=', DB::raw("ANY(string_to_array('$sekolah->instrumen', ','))"))
                    ->orWhereNull('s.instrumen'); // jika instrumen = null → ambil semua
            })
            ->leftJoin('evaluasi_kuesioner as ek', function ($join) use ($model) {
                $join->on('ek.sekolah', '=', 's.id')
                    ->on('ek.id_ruang', '=', 'rs.id')
                    ->where('ek.periode_awal_kuesioner', '=', $model->periode_awal_kuesioner)
                    ->where('ek.periode_akhir_kuesioner', '=', $model->periode_akhir_kuesioner);
            })
            ->where('s.id', $model->sekolah)
            ->where(function ($q) {
                $q->whereNull('ek.id_ruang')               // Belum isi
                    ->orWhere('ek.status_verifikasi_sekolah', '!=', 1); // Belum verifikasi
            })
            ->orderBy('rs.id')
            ->select(
                'ek.id',
                'rs.id as id_ruang',
                'rs.nama',
                DB::raw("CASE WHEN ek.id_ruang IS NOT NULL THEN 'Sudah isi' ELSE 'Belum isi' END AS status"),
                DB::raw("CASE WHEN ek.status_verifikasi_sekolah = 1 THEN 'Terverifikasi' ELSE 'Belum Verifikasi' END AS verifikasi")
            )
            ->get();
        if ($hasil->count() >= 1) {
            return view('sekolahbersih.validasinotvalid', compact('model', 'sekolah', 'kabupaten', 'sekolahId', 'periodeAwal', 'periodeAkhir', 'hasilKuesioner', 'verifikator', 'hasil'));
        } else {
            return view('sekolahbersih.validasi', compact('model', 'sekolah', 'kabupaten', 'sekolahId', 'periodeAwal', 'periodeAkhir', 'hasilKuesioner', 'verifikator'));
        }

    }

    public function showValidasi($id)
    {
        $model = ValidasiSekolahBersih::findOrFail($id);
        //$child = ValidasiSekolahBersihChild::where('id_validasi', $model->id)->orderBy('id_ruang')->get();
        $child = DB::table('validasi_sekolahbersih_child')
            ->leftJoin('ruang_sekolah', 'ruang_sekolah.id', '=', 'validasi_sekolahbersih_child.id_ruang')
            ->where('id_validasi', $model->id)
            ->orderBy('id_ruang')
            ->get();
        $sekolah = Sekolah::find($model->id_sekolah);
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
        $periodeAwal = $model->periode_awal;
        $periodeAkhir = $model->periode_akhir;
        if ($model->disusun_oleh != null) {
            $disusunoleh = VerifikatorSekolah::find($model->disusun_oleh)->verifikator;
        } else {
            $disusunoleh = null;
        }
        if ($model->mengetahui != null) {
            $mengetahui = VerifikatorSekolah::find($model->mengetahui)->verifikator;
        } else {
            $mengetahui = null;
        }
        if ($model->user_supervisi_pengawas != null) {
            $verifikatorpengawas = VerifikatorSekolah::find($model->user_supervisi_pengawas)->verifikator;
        } else {
            $verifikatorpengawas = null;
        }
        // $verifikatorcabdis = VerifikatorSekolah::findOrFail($model->user_supervisi_validasi);
        return view('sekolahbersih.validasishow', compact('model', 'child', 'sekolah', 'kabupaten', 'periodeAwal', 'periodeAkhir', 'disusunoleh', 'mengetahui', 'verifikatorpengawas'));
    }


    /*    public function validasi($id)
        {
            $model=EvaluasiKuesioner::findOrFail($id);
            $sekolah=Sekolah::find($model->sekolah);
            $kabupaten=Kabupatenkota::where('kode_kabupaten',$sekolah->kabupaten_kota)->first();

            $data = DB::table('ruang_sekolah as rs')
                ->select(
                    'rs.id',
                    'rs.nama',
                    DB::raw("CASE
                                WHEN ek.id IS NULL THEN 'Belum diisi'
                                ELSE 'Belum diverifikasi'
                            END AS status")
                )
                ->leftJoin('evaluasi_kuesioner as ek', function($join) {
                    $join->on('ek.id_ruang', '=', 'rs.id')
                        ->where('ek.sekolah', 101)
                        ->where('ek.periode_awal_kuesioner', '2025-09-01');
                })
                ->where(function($query) {
                    $query->whereNull('ek.id')
                        ->orWhere('ek.status_verifikasi_sekolah', '<>', 1);
                })
                ->orderBy('rs.id')
                ->get();

            $sekolahId= $model->sekolah;
            $periodeAwal= $model->periode_awal_kuesioner;
            $periodeAkhir= $model->periode_akhir_kuesioner;
            $hasilKuesioner = DB::table('ruang_sekolah as rs')
                ->leftJoin('evaluasi_kuesioner as ek', function($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                    $join->on('ek.id_ruang', '=', 'rs.id')
                        ->where('ek.sekolah', '=', $sekolahId)
                        ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                        ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
                })
                ->select(
                    DB::raw('COALESCE(max(ek.id), 0) as idnya'),
                    'rs.nama',
                    DB::raw('COALESCE(SUM(ek.score), 0) as score'),
                    DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter')

                )
                ->groupBy('rs.id', 'rs.nama')
                ->orderBy('rs.id')
                ->get();

            $verifikator= DB::table('verifikator_sekolah')
                ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
                ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
                ->where('verifikator_sekolah.id_sekolah', $model->sekolah)
                ->get();

            return view('sekolahbersih.validasi',compact('model','sekolah','data','kabupaten','sekolahId','periodeAwal','periodeAkhir', 'hasilKuesioner','verifikator'));
        }
    */
    //simpan validasi
    public function storeValidasi(Request $request)
    {
        $validated = $request->validate([
            'sekolah' => 'required|integer',
            'periode_awal_kuesioner' => 'required|date',
            'periode_akhir_kuesioner' => 'required|date',
            'total_score' => 'nullable|numeric',
            'total_rata' => 'nullable|numeric',
            'nilai_kebersihan' => 'nullable|integer',
            'persen_kebersihan' => 'nullable|numeric',
            'keterangan_kebersihan' => 'nullable|string|max:100',
            'nilai_kepatuhan' => 'nullable|integer',
            'persen_kepatuhan' => 'nullable|numeric',
            'keterangan_kepatuhan' => 'nullable|string|max:100',
            'tanggal_supervisi_verifikasi' => 'required|date_format:d-M-Y',
            'user_validator' => 'nullable|integer',
            'user_validator_kepsek' => 'nullable|integer',
            'dokumentasi' => 'nullable|array',
            'kendala' => 'nullable|string',
            'hasil_rekomendasi_pengawas' => 'nullable|string',
            'disusun_oleh' => 'nullable|string',
            'mengetahui' => 'nullable|string',
            // child arrays
            'id_ruang' => 'required|array',
            'id_evaluasi' => 'required|array',
            'id_kuesioner' => 'required|array',
            'score' => 'required|array',
            'rata' => 'required|array',
            'nilai_kebersihan_child' => 'nullable|array',
            'ket_kebersihan_child' => 'nullable|array',
            'catatan_sekolah' => 'nullable|string',
            'user_verifikasi_guru_piket_child' => 'nullable|array',
            'user_verifikasi_child' => 'nullable|array',
            'tanggal_verifikasi_sekolah_child' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // cek apakah sudah ada data validasi
            $existing = DB::table('validasi_sekolahbersih')
                ->where('id_sekolah', $validated['sekolah'])
                ->where('periode_awal', $validated['periode_awal_kuesioner'])
                ->where('periode_akhir', $validated['periode_akhir_kuesioner'])
                ->first();

            $headerData = [
                'id_sekolah' => $validated['sekolah'],
                'periode_awal' => $validated['periode_awal_kuesioner'],
                'periode_akhir' => $validated['periode_akhir_kuesioner'],
                'total_score' => $validated['total_score'] ?? null,
                'total_rata' => $validated['total_rata'] ?? null,
                'nilai_kebersihan' => $validated['nilai_kebersihan'] ?? null,
                'persen_kebersihan' => $validated['persen_kebersihan'] ?? null,
                'keterangan_kebersihan' => $validated['keterangan_kebersihan'] ?? null,
                'nilai_kepatuhan' => $validated['nilai_kepatuhan'] ?? null,
                'persen_kepatuhan' => $validated['persen_kepatuhan'] ?? null,
                'keterangan_kepatuhan' => $validated['keterangan_kepatuhan'] ?? null,
                'tanggal_supervisi_verifikasi' => Carbon::createFromFormat('d-M-Y', $validated['tanggal_supervisi_verifikasi'])->format('Y-m-d'),
                'user_supervisi_verifikasi' => $validated['user_validator'] ?? null,
                'disusun_oleh' => $validated['user_validator'] ?? null,
                'mengetahui' => $validated['user_validator_kepsek'] ?? null,
                'dokumentasi' => json_encode($validated['dokumentasi'] ?? []),
                'kendala' => $validated['kendala'] ?? null,
                'hasil_rekomendasi_pengawas' => $validated['hasil_rekomendasi_pengawas'] ?? null,
                'user_update' => auth()->user()->name ?? null,
                'time_update' => now(),
                'catatan_sekolah' => $validated['catatan_sekolah'] ?? null,
            ];

            if ($existing) {
                DB::table('validasi_sekolahbersih')
                    ->where('id', $existing->id)
                    ->update($headerData);
                $idValidasi = $existing->id;

                DB::table('validasi_sekolahbersih_child')->where('id_validasi', $idValidasi)->delete();
            } else {
                $headerData['user_create'] = auth()->user()->name ?? null;
                $headerData['time_create'] = now();
                $idValidasi = DB::table('validasi_sekolahbersih')->insertGetId($headerData);
            }

            // insert child
            foreach ($validated['id_ruang'] as $key => $idRuang) {
                DB::table('validasi_sekolahbersih_child')->insert([
                    'id_validasi' => $idValidasi,
                    'id_ruang' => $idRuang,
                    'id_evaluasi' => $validated['id_evaluasi'][$key] ?? null,
                    'id_kuesioner' => $validated['id_kuesioner'][$key] ?? null,
                    'score' => $validated['score'][$key] ?? null,
                    'rata' => $validated['rata'][$key] ?? null,
                    'nilai_kebersihan' => $validated['nilai_kebersihan_child'][$key] ?? null,
                    'keterangan_kebersihan' => $validated['ket_kebersihan_child'][$key] ?? null,
                    // kalau tiap child punya kepatuhan sendiri, tambahkan array di request
                    'nilai_kepatuhan' => $validated['nilai_kepatuhan'] ?? null,
                    'keterangan_kepatuhan' => $validated['keterangan_kepatuhan'] ?? null,
                    'dokumentasi' => isset($validated['dokumentasi'][$key]) ? 1 : 0,
                    'user_create' => auth()->user()->name ?? null,
                    'time_create' => now(),
                    'user_update' => auth()->user()->name ?? null,
                    'time_update' => now(),
                    'user_verifikasi' => $validated['user_verifikasi_child'][$key] ?? null,
                    'user_verifikasi_guru_piket' => $validated['user_verifikasi_guru_piket_child'][$key] ?? null,
                    'tanggal_verifikasi_sekolah' => $validated['tanggal_verifikasi_sekolah_child'][$key] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('sekolahbersih.indexValidasi')
                ->with('success', 'Data validasi berhasil disimpan/diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan validasi: ' . $e->getMessage());
        }
    }


    public function verifikasiPengawas($id)
    {
        $model = ValidasiSekolahBersih::findOrFail($id);
        //$child = ValidasiSekolahBersihChild::where('id_validasi', $model->id)->orderBy('id_ruang')->get();
        $child = DB::table('validasi_sekolahbersih_child')
            ->select('validasi_sekolahbersih_child.*', 'ruang_sekolah.nama')
            ->leftJoin('ruang_sekolah', 'ruang_sekolah.id', '=', 'validasi_sekolahbersih_child.id_ruang')
            ->where('id_validasi', $model->id)
            ->orderBy('id_ruang')
            ->get();
        $sekolah = Sekolah::find($model->id_sekolah);
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
        $periodeAwal = $model->periode_awal;
        $periodeAkhir = $model->periode_akhir;
        if ($model->disusun_oleh != null) {
            $disusunoleh = VerifikatorSekolah::find($model->disusun_oleh)->verifikator;
        } else {
            $disusunoleh = null;
        }
        if ($model->mengetahui != null) {
            $mengetahui = VerifikatorSekolah::find($model->mengetahui)->verifikator;
        } else {
            $mengetahui = null;
        }
        if ($model->user_supervisi_pengawas != null) {
            $verifikatorpengawas = VerifikatorSekolah::find($model->user_supervisi_pengawas)->verifikator;
        } else {
            $verifikatorpengawas = null;
        }
        // $verifikatorcabdis = VerifikatorSekolah::findOrFail($model->user_supervisi_validasi);
        return view('sekolahbersih.verifikasipengawas', compact('model', 'child', 'sekolah', 'kabupaten', 'periodeAwal', 'periodeAkhir', 'disusunoleh', 'mengetahui', 'verifikatorpengawas'));
    }


    // public function verifikasiPengawas($id)
    // {
    //     $model = EvaluasiKuesioner::findOrFail($id);
    //     $sekolah = Sekolah::find($model->sekolah);
    //     $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         $cabdis = Cabdis::find($user->cabdis);
    //         if ($cabdis) {
    //             $wilayah = DB::select("
    //                 SELECT
    //                     cab.id,
    //                     cab.nama,
    //                     cab.kabupatenkota,
    //                     string_agg(kab.nama_kabupaten, ', ' ORDER BY kab.nama_kabupaten) AS nama_kabupaten
    //                 FROM
    //                     cabdis cab
    //                 JOIN
    //                     LATERAL unnest(string_to_array(cab.kabupatenkota, ', ')) AS kab_id ON TRUE
    //                 JOIN
    //                     kabupaten kab ON kab.kode_kabupaten::text = kab_id
    //                 WHERE
    //                     cab.id = ?
    //                 GROUP BY
    //                     cab.id, cab.nama, cab.kabupatenkota
    //             ", [$user->cabdis]);

    //         } else {
    //             $wilayah = [];
    //         }

    //     } else {
    //         $user = null;
    //         $cabdis = null;
    //         $wilayah = [];
    //     }

    //     $sekolahId = $model->sekolah;
    //     $periodeAwal = $model->periode_awal_kuesioner;
    //     $periodeAkhir = $model->periode_akhir_kuesioner;
    //     $hasilKuesioner = DB::table('ruang_sekolah as rs')
    //         ->leftJoin('evaluasi_kuesioner as ek', function ($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
    //             $join->on('ek.id_ruang', '=', 'rs.id')
    //                 ->where('ek.sekolah', '=', $sekolahId)
    //                 ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
    //                 ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
    //         })
    //         ->select(
    //             DB::raw('COALESCE(max(ek.id), 0) as idnya'),
    //             'rs.nama',
    //             DB::raw('COALESCE(SUM(ek.score), 0) as score'),
    //             DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter')

    //         )
    //         ->groupBy('rs.id', 'rs.nama')
    //         ->orderBy('rs.id')
    //         ->get();
    //     return view('sekolahbersih.verifikasipengawas', compact('model', 'sekolah', 'kabupaten', 'sekolahId', 'periodeAwal', 'periodeAkhir', 'hasilKuesioner', 'user', 'cabdis', 'wilayah'));
    // }

    public function print($id)
    {
        $model = EvaluasiKuesioner::findOrFail($id);
        $ruang = IconGrid::findOrFail($model->id_ruang);
        $sekolah = Sekolah::find($model->sekolah);
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));

        $hasilKuesioner = DB::table('hasil_kuesioner')
            ->select('p.parameter', 'hasil_kuesioner.jawaban', 'hasil_kuesioner.deskripsi_jawaban')
            ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
            ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
            ->whereIn('hasil_kuesioner.id', $arrayIds)
            ->get();

        $verifikator = DB::table('verifikator_sekolah')
            ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
            ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
            ->where('verifikator_sekolah.id', $model->user_verifikasi)
            ->first();

        $verifikatorpiket = DB::table('verifikator_sekolah')
            ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
            ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
            ->where('verifikator_sekolah.id', $model->user_verifikasi_guru_piket)
            ->first();

        $pdf = PDF::loadView('sekolahbersih.cetak', compact('model', 'ruang', 'hasilKuesioner', 'sekolah', 'verifikator', 'verifikatorpiket'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    // public function printRekapCabdisSekolah($id)
    // {
    //     $model = EvaluasiKuesioner::findOrFail($id);
    //     $ruang = IconGrid::findOrFail($model->id_ruang);
    //     $sekolah = Sekolah::find($model->sekolah);
    //     $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
    //     $arrayIds = explode(',', trim($stringIds, '{}'));

    //     $hasilKuesioner = DB::table('hasil_kuesioner')
    //         ->select('p.parameter', 'hasil_kuesioner.jawaban', 'hasil_kuesioner.deskripsi_jawaban')
    //         ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
    //         ->join('ruang_sekolah as r', 'r.id', '=', 'hasil_kuesioner.id_ruang')
    //         ->whereIn('hasil_kuesioner.id', $arrayIds)
    //         ->get();



    //     $loop = DB::table('evaluasi_kuesioner as ek')
    //         ->join('ruang_sekolah as rs', 'ek.id_ruang', '=', 'rs.id')
    //         ->select('ek.*', 'rs.nama as nama_ruang')
    //         ->where('ek.sekolah', $model->sekolah)
    //         ->where('ek.periode_awal_kuesioner', $model->periode_awal_kuesioner)
    //         ->where('ek.periode_akhir_kuesioner', $model->periode_akhir_kuesioner)
    //         ->orderBy('ek.id_ruang')
    //         ->get();

    //     $pdf = PDF::loadView('sekolahbersih.cetakrekapcabdis', compact('model', 'ruang', 'hasilKuesioner', 'sekolah', 'loop'))->setPaper('a4', 'portrait');
    //     return $pdf->stream();
    // }

    public function printRekapCabdisSekolah($id)
    {
        $model = ValidasiSekolahBersih::findOrFail($id);
        $loop = DB::table('validasi_sekolahbersih_child as vsc')
            ->join('ruang_sekolah as rs', 'vsc.id_ruang', '=', 'rs.id')
            ->select('vsc.*', 'rs.nama as nama_ruang')
            ->where('vsc.id_validasi', $model->id)
            ->orderBy('vsc.id_ruang')
            ->get();
        $sekolah = Sekolah::where('id', $model->id_sekolah)->first();
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();

        $pdf = PDF::loadView('sekolahbersih.cetakrekapcabdis', compact('model', 'sekolah', 'kabupaten', 'loop'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function printPengawas($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role != 6) {
                abort(403, 'Anda tidak memiliki akses untuk mencetak laporan ini.');
            } else {
                $model = ValidasiSekolahBersih::findOrFail($id);
                $child = DB::table('validasi_sekolahbersih_child')
                    ->select('validasi_sekolahbersih_child.*', 'ruang_sekolah.nama')
                    ->leftJoin('ruang_sekolah', 'ruang_sekolah.id', '=', 'validasi_sekolahbersih_child.id_ruang')
                    ->where('id_validasi', $model->id)
                    ->orderBy('id_ruang')
                    ->get();
                $sekolah = Sekolah::where('id', $model->id_sekolah)->first();
                $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
                $cabdis = Cabdis::where('id', $user->cabdis)->first();
                $binaan = Kabupatenkota::where('kode_kabupaten', $user->binaan_kabkota)->first();
                $pdf = PDF::loadView('sekolahbersih.cetakpengawas', compact('model', 'child', 'sekolah', 'kabupaten', 'cabdis', 'binaan','user'))->setPaper([0, 0, 595, 935], 'portrait');
                return $pdf->stream();
            }
        } else {
            return redirect()->back()->with('error', 'Silahkan Login');
        }
    }

    public function printCabdis($id)
    {
        $model = EvaluasiKuesioner::findOrFail($id);
        $ruang = IconGrid::find($model->id_ruang);
        $sekolah = Sekolah::find($model->sekolah);
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();
        $stringIds = $model->id_kuesioner;  // contoh: "{319,320,321}"
        $arrayIds = explode(',', trim($stringIds, '{}'));

        $sekolahId = $model->sekolah;
        $periodeAwal = $model->periode_awal_kuesioner;
        $periodeAkhir = $model->periode_akhir_kuesioner;
        $hasilKuesioner = DB::table('ruang_sekolah as rs')
            ->leftJoin('evaluasi_kuesioner as ek', function ($join) use ($sekolahId, $periodeAwal, $periodeAkhir) {
                $join->on('ek.id_ruang', '=', 'rs.id')
                    ->where('ek.sekolah', '=', $sekolahId)
                    ->where('ek.periode_awal_kuesioner', '=', $periodeAwal)
                    ->where('ek.periode_akhir_kuesioner', '=', $periodeAkhir);
            })
            ->select(
                DB::raw('COALESCE(max(ek.id), 0) as idnya'),
                'rs.nama',
                DB::raw('COALESCE(SUM(ek.kesimpulan_pengawas), 0) as kesimpulan_pengawas'),
                DB::raw('(SELECT COUNT(*) FROM parameter_kebersihan p WHERE p.id_ruang = rs.id) as jumlah_parameter'),
                DB::raw('MAX(ek.catatan_pengawas) as catatan_pengawas'),
                DB::raw('COALESCE(MAX(CASE WHEN ek.dokumentasi_pengawas THEN 1 ELSE 0 END), 0) as dokumentasi_pengawas'),
                DB::raw('MAX(ek.catatan_dokumentasi_pengawas) as catatan_dokumentasi_pengawas')
            )
            ->groupBy('rs.id', 'rs.nama')
            ->orderBy('rs.id')
            ->get();

        $evaluasipengawas = DB::table('evaluasi_pengawas')
            ->where('sekolah', $sekolahId)
            ->where('periode_awal_kuesioner', $periodeAwal)
            ->where('periode_akhir_kuesioner', $periodeAkhir)
            ->first();

        if (Auth::check()) {
            $user = Auth::user();
            $cabdis = Cabdis::find($user->cabdis);
            if ($cabdis) {
                $wilayah = DB::select("
                    SELECT
                        cab.id,
                        cab.nama,
                        cab.kabupatenkota,
                        string_agg(kab.nama_kabupaten, ', ' ORDER BY kab.nama_kabupaten) AS nama_kabupaten
                    FROM
                        cabdis cab
                    JOIN
                        LATERAL unnest(string_to_array(cab.kabupatenkota, ', ')) AS kab_id ON TRUE
                    JOIN
                        kabupaten kab ON kab.kode_kabupaten::text = kab_id
                    WHERE
                        cab.id = ?
                    GROUP BY
                        cab.id, cab.nama, cab.kabupatenkota
                ", [$user->cabdis]);

            } else {
                $wilayah = [];
            }

        } else {
            $user = null;
            $cabdis = null;
            $wilayah = [];
        }

        $pdf = PDF::loadView('sekolahbersih.cetakcabdis', compact('model', 'ruang', 'hasilKuesioner', 'sekolah', 'kabupaten', 'evaluasipengawas', 'user', 'cabdis', 'wilayah'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }


    public function printCabdisSekolah($id)
    {
        $model = ValidasiSekolahBersih::findOrFail($id);
        $child = DB::table('validasi_sekolahbersih_child')
            ->select('validasi_sekolahbersih_child.*', 'ruang_sekolah.nama')
            ->leftJoin('ruang_sekolah', 'ruang_sekolah.id', '=', 'validasi_sekolahbersih_child.id_ruang')
            ->where('id_validasi', $model->id)
            ->orderBy('id_ruang')
            ->get();
        $sekolah = Sekolah::where('id', $model->id_sekolah)->first();
        $kabupaten = Kabupatenkota::where('kode_kabupaten', $sekolah->kabupaten_kota)->first();

        $pdf = PDF::loadView('sekolahbersih.cetakcabdissekolah', compact('model', 'child', 'sekolah', 'kabupaten'))->setPaper([0, 0, 595, 935], 'portrait');
        return $pdf->stream();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = EvaluasiKuesioner::find($id);
        $daterange = date('d-m-Y', strtotime($model->periode_awal_kuesioner)) . ' - ' . date('d-m-Y', strtotime($model->periode_akhir_kuesioner));
        //$rincian                = HasilKuesioner::where('id',$model->id_evaluasi_kuesioner)->get();
        $rincian = DB::table('parameter_kebersihan as p')
            ->leftJoin('hasil_kuesioner as h', function ($join) {
                $join->on('p.id', '=', 'h.id_parameter')
                    ->on('p.id_ruang', '=', 'h.id_ruang');
            })
            ->where('p.id_ruang', $model->id_ruang)
            ->where('h.id_evaluasi_kuesioner', $id)
            //            ->where(function($q) use ($model) {
//                $q->where('h.id_evaluasi_kuesioner', $model->id)
//                  ->orWhereNull('h.id_evaluasi_kuesioner');
//            })
            ->select(
                'p.id as id_parameter',
                'p.parameter',
                'h.jawaban',
                'h.deskripsi_jawaban',
                'h.id'
            )
            ->orderBy('p.id')
            ->get();
        //dd($rincian);
        $ruang = IconGrid::findOrFail($model->id_ruang);
        $parameter = Parameter::where('id_ruang', $model->id_ruang)->get();

        return view('sekolahbersih.edit', compact(
            'model',
            'rincian',
            'ruang',
            'parameter',
            'daterange'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute Wajib diisi',
        ];
        $validator = Validator::make($request->all(), [
            'jabatan' => 'required',
            'jenis_biaya' => 'required',
            //'deskripsi'                 =>'required',
            'status_wilayah_biaya' => 'required',
            'nominal' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        } else {
            $post = ManajemenBiaya::where('id', $request->id)->first();
            $post->jabatan = $request->jabatan;
            $post->jenis_biaya = $request->jenis_biaya;
            $post->deskripsi = $request->deskripsi;
            $post->status_wilayah_biaya = $request->status_wilayah_biaya;
            $badChars = array(".");
            $nominal = str_ireplace($badChars, "", $request->nominal);
            $post->nominal = $nominal;
            $post->user_created = NULL;
            $simpan = $post->save();
            if ($simpan) {
                Session::flash('berhasil', 'Data Manajemen Biaya Berhasil di tambah');
                return redirect()->route('biaya.index');
            } else
                return back()->withErrors(['Gagal' => ['Data Manajemen Biaya Gagal di tambah']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = EvaluasiKuesioner::firstWhere('id', $id);
        if ($check) {
            EvaluasiKuesioner::destroy($id);
            return response([
                'status' => 'OK',
                'message' => 'Data Deleted',
            ], 200);
        } else {
            return response([
                'status' => 'Gagal',
                'message' => 'Data Not Found',
            ], 404);
        }
    }

    public function storeVerifikasi(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'rekap_total_score' => 'nullable|integer',
            'rekap_nilai_kebersihan' => 'nullable|numeric',
            'rekap_ket_kebersihan' => 'nullable|string',
            'rekap_nilai_kepatuhan' => 'nullable|numeric',
            'rekap_ket_kepatuhan' => 'nullable|string',
            'tanggal_supervisi' => 'required|string',
            'jenis_tindak_lanjut' => 'required|string',
            'id_parameter_pengawas' => 'required|array',
            'id_parameter_pengawas.*' => 'required|integer',
            'jawaban_pengawas' => 'required|array',
            'jawaban_pengawas.*' => 'required|integer|min:1|max:4',
            'id_child' => 'required|array',
            'id_child.*' => 'required|integer',
            'scorepengawas' => 'nullable|array',
            'scorepengawas.*' => 'nullable|integer',
            'ratapengawas' => 'nullable|array',
            'ratapengawas.*' => 'nullable|numeric',
            'nilaikebersihanpengawas' => 'nullable|array',
            'nilaikebersihanpengawas.*' => 'nullable|numeric',
            'ketkebersihanpengawas' => 'nullable|array',
            'ketkebersihanpengawas.*' => 'nullable|string',
            'catatan_temuan' => 'nullable|array',
            'catatan_temuan.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update validasi_sekolahbersih table
            $updateData = [
                'total_score_pengawas' => $validated['rekap_total_score'] ?? null,
                'total_rata_pengawas' => $validated['rekap_nilai_kebersihan'] ?? null,
                'rekap_nilai_kebersihan' => $validated['rekap_nilai_kebersihan'] ?? null,
                'rekap_keterangan_kebersihan' => $validated['rekap_ket_kebersihan'] ?? null,
                'nilai_kepatuhan' => $validated['rekap_nilai_kepatuhan'] ?? null,
                'keterangan_kepatuhan' => $validated['rekap_ket_kepatuhan'] ?? null,
                'status' => 1,
                'user_supervisi_pengawas' => auth()->user()->name ?? null,
                'tanggal_supervisi_pengawas' => Carbon::createFromFormat('d-M-Y', $validated['tanggal_supervisi'])->format('Y-m-d'),
                'hasil_rekomendasi_pengawas' => $validated['jenis_tindak_lanjut'],
                'hasil_rekomendasi' => $validated['jenis_tindak_lanjut'],
                'user_update' => auth()->user()->name ?? null,
                'time_update' => now(),
            ];

            $affected = DB::table('validasi_sekolahbersih')
                ->where('id', $validated['id'])
                ->update($updateData);

            if ($affected === 0) {
                throw new \Exception("Data validasi dengan ID {$validated['id']} tidak ditemukan.");
            }

            // Update hasil_kuesioner table for each parameter
            foreach ($validated['id_parameter_pengawas'] as $index => $parameterId) {
                if (!isset($validated['jawaban_pengawas'][$index])) {
                    continue; // Skip if no corresponding jawaban_pengawas value
                }

                $jawabanPengawas = $validated['jawaban_pengawas'][$index];

                $hasilKuesionerUpdate = [
                    'jawaban_pengawas' => $jawabanPengawas,
                    'status_approval_disdik' => '1',
                    'tanggal_approval_disdik' => Carbon::createFromFormat('d-M-Y', $validated['tanggal_supervisi'])->format('Y-m-d H:i:s'),
                    'user_updated' => auth()->user()->name ?? null,
                    'time_update' => now(),
                ];

                $affectedHasil = DB::table('hasil_kuesioner')
                    ->where('id', $parameterId)
                    ->update($hasilKuesionerUpdate);

                if ($affectedHasil === 0) {
                    throw new \Exception("Data hasil_kuesioner dengan ID {$parameterId} tidak ditemukan.");
                }
            }

            // Update validasi_sekolahbersih_child table for each child
            foreach ($validated['id_child'] as $childId => $childValue) {
                $updateChildData = [
                    'score_pengawas' => $request->scorepengawas[$childId] ?? null,
                    'rata_pengawas' => $request->ratapengawas[$childId] ?? null,
                    'nilai_kebersihan_pengawas' => $request->nilaikebersihanpengawas[$childId] ?? null,
                    'keterangan_kebersihan_pengawas' => $request->ketkebersihanpengawas[$childId] ?? null,
                    'catatan' => $request->catatan_temuan[$childId] ?? null,
                    'user_update' => auth()->user()->name ?? null,
                    'time_update' => now(),
                ];

                $affectedChild = DB::table('validasi_sekolahbersih_child')
                    ->where('id', $childId)
                    ->update($updateChildData);

                if ($affectedChild === 0) {
                    throw new \Exception("Data validasi_sekolahbersih_child dengan ID {$childId} tidak ditemukan.");
                }
            }

            DB::commit();

            return redirect()->route('sekolahbersih.rekappengawas')
                ->with('success', 'Data verifikasi pengawas berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menyimpan verifikasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    //download PDF
    public function CetakRekapPengawas(Request $request)
    {
        try {
            Log::info('📥 Request diterima', [
                'startDate_raw' => $request->input('startDate'),
                'endDate_raw' => $request->input('endDate')
            ]);

            $startDate = Carbon::parse($request->input('startDate'))->startOfDay();
            $endDate = Carbon::parse($request->input('endDate'))->endOfDay();

            Log::info('📅 Parsed tanggal', [
                'startDate' => $startDate->toDateTimeString(),
                'endDate' => $endDate->toDateTimeString()
            ]);

            if ($endDate->lt($startDate)) {
                Log::warning('⚠️ Tanggal akhir lebih kecil dari tanggal awal');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tanggal akhir tidak boleh lebih kecil dari awal.'
                ], 400);
            }

            $data = EvaluasiPengawas::whereDate('periode_awal_kuesioner', $startDate->toDateString())
                ->whereDate('periode_akhir_kuesioner', $endDate->toDateString())
                ->get();

            $sekolahMap = \App\Models\Sekolah::all()->keyBy('id');

            $user = Auth::check() ? Auth::user() : null;
            $wilayah = [];

            if ($user && $user->role == 6) {
                $wilayah = DB::select("
                    SELECT
                        cab.id,
                        cab.nama,
                        cab.kabupatenkota,
                        string_agg(kab.nama_kabupaten, ', ' ORDER BY kab.nama_kabupaten) AS nama_kabupaten
                    FROM
                        cabdis cab
                    JOIN LATERAL unnest(string_to_array(cab.kabupatenkota, ', ')) AS kab_id ON TRUE
                    JOIN kabupaten kab ON kab.kode_kabupaten::text = kab_id
                    WHERE cab.id = ?
                    GROUP BY cab.id, cab.nama, cab.kabupatenkota
                ", [$user->cabdis]);
            }

            Log::info('📊 Jumlah data ditemukan:', ['count' => $data->count()]);

            if ($data->isEmpty()) {
                Log::warning('📭 Tidak ada data untuk periode', [
                    'startDate' => $startDate->toDateString(),
                    'endDate' => $endDate->toDateString()
                ]);
                return response()->json([
                    'status' => 'nodata',
                    'message' => 'Data tidak ditemukan untuk periode tersebut.'
                ], 404);
            }

            $fileName = "Laporan Supervisi {$startDate->format('d-m-Y')} s.d {$endDate->format('d-m-Y')}.pdf";

            // ✅ 1. Generate PDF dari view
            $pdfContent = PDF::loadView('sekolahbersih.cetakan_rekappengawas', [
                'data' => $data,
                'startDate' => $startDate->toDateString(),
                'endDate' => $endDate->toDateString(),
                'wilayah' => $wilayah,
                'user' => $user,
                'sekolahMap' => $sekolahMap
            ])->output(); // <-- output() mengembalikan binary PDF, tidak disimpan

            Log::info('🖨 PDF berhasil dibuat, ukuran asli: ' . number_format(strlen($pdfContent) / 1024, 2) . ' KB');

            // ✅ 2. Jalankan Ghostscript untuk kompresi (tanpa simpan file)
            $process = new Process([
                'gs',
                '-sDEVICE=pdfwrite',
                '-dCompatibilityLevel=1.4',
                '-dPDFSETTINGS=/default',     // Kualitas baik, kompresi sedang
                '-dNOPAUSE',
                '-dQUIET',
                '-dBATCH',
                '-sOutputFile=-',              // Output ke stdout
                '-'                            // Input dari stdin
            ]);

            $input = new InputStream();
            $process->setInput($input);
            $process->start();

            // Kirim PDF ke Ghostscript
            $input->write($pdfContent);
            $input->close();

            // Tunggu proses selesai
            $process->wait();

            if (!$process->isSuccessful()) {
                Log::error('❌ Ghostscript gagal: ' . $process->getErrorOutput());
                // Jika gagal, kembalikan PDF asli
                return response($pdfContent)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
            }

            $compressedPdf = $process->getOutput();

            Log::info('✅ PDF berhasil dikompresi, ukuran baru: ' . number_format(strlen($compressedPdf) / 1024, 2) . ' KB');

            // ✅ 3. Langsung kirim ke user sebagai download
            return response($compressedPdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=\"$fileName\"");

        } catch (\Exception $e) {
            Log::error('❌ CetakRekapPengawas gagal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat PDF.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //print rekap sekolah
    public function CetakRekapSekolah(Request $request)
    {
        try {
            Log::info('📥 Request diterima', [
                'startDate_raw' => $request->input('startDate'),
                'endDate_raw' => $request->input('endDate')
            ]);

            $startDate = Carbon::parse($request->input('startDate'))->startOfDay();
            $endDate = Carbon::parse($request->input('endDate'))->endOfDay();

            Log::info('📅 Parsed tanggal', [
                'startDate' => $startDate->toDateTimeString(),
                'endDate' => $endDate->toDateTimeString()
            ]);

            if ($endDate->lt($startDate)) {
                Log::warning('⚠️ Tanggal akhir lebih kecil dari tanggal awal');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tanggal akhir tidak boleh lebih kecil dari awal.'
                ], 400);
            }

            $data = EvaluasiPengawas::whereDate('periode_awal_kuesioner', $startDate->toDateString())
                ->whereDate('periode_akhir_kuesioner', $endDate->toDateString())
                ->get();

            $sekolahMap = \App\Models\Sekolah::all()->keyBy('id');

            $user = Auth::check() ? Auth::user() : null;
            $wilayah = [];

            if ($user && $user->role == 6) {
                $wilayah = DB::select("
                    SELECT
                        cab.id,
                        cab.nama,
                        cab.kabupatenkota,
                        string_agg(kab.nama_kabupaten, ', ' ORDER BY kab.nama_kabupaten) AS nama_kabupaten
                    FROM
                        cabdis cab
                    JOIN LATERAL unnest(string_to_array(cab.kabupatenkota, ', ')) AS kab_id ON TRUE
                    JOIN kabupaten kab ON kab.kode_kabupaten::text = kab_id
                    WHERE cab.id = ?
                    GROUP BY cab.id, cab.nama, cab.kabupatenkota
                ", [$user->cabdis]);
            }

            Log::info('📊 Jumlah data ditemukan:', ['count' => $data->count()]);

            if ($data->isEmpty()) {
                Log::warning('📭 Tidak ada data untuk periode', [
                    'startDate' => $startDate->toDateString(),
                    'endDate' => $endDate->toDateString()
                ]);
                return response()->json([
                    'status' => 'nodata',
                    'message' => 'Data tidak ditemukan untuk periode tersebut.'
                ], 404);
            }

            $fileName = "Laporan Supervisi {$startDate->format('d-m-Y')} s.d {$endDate->format('d-m-Y')}.pdf";

            // ✅ 1. Generate PDF dari view
            $pdfContent = PDF::loadView('sekolahbersih.cetakan_rekappengawas', [
                'data' => $data,
                'startDate' => $startDate->toDateString(),
                'endDate' => $endDate->toDateString(),
                'wilayah' => $wilayah,
                'user' => $user,
                'sekolahMap' => $sekolahMap
            ])->output(); // <-- output() mengembalikan binary PDF, tidak disimpan

            Log::info('🖨 PDF berhasil dibuat, ukuran asli: ' . number_format(strlen($pdfContent) / 1024, 2) . ' KB');

            // ✅ 2. Jalankan Ghostscript untuk kompresi (tanpa simpan file)
            $process = new Process([
                'gs',
                '-sDEVICE=pdfwrite',
                '-dCompatibilityLevel=1.4',
                '-dPDFSETTINGS=/default',     // Kualitas baik, kompresi sedang
                '-dNOPAUSE',
                '-dQUIET',
                '-dBATCH',
                '-sOutputFile=-',              // Output ke stdout
                '-'                            // Input dari stdin
            ]);

            $input = new InputStream();
            $process->setInput($input);
            $process->start();

            // Kirim PDF ke Ghostscript
            $input->write($pdfContent);
            $input->close();

            // Tunggu proses selesai
            $process->wait();

            if (!$process->isSuccessful()) {
                Log::error('❌ Ghostscript gagal: ' . $process->getErrorOutput());
                // Jika gagal, kembalikan PDF asli
                return response($pdfContent)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
            }

            $compressedPdf = $process->getOutput();

            Log::info('✅ PDF berhasil dikompresi, ukuran baru: ' . number_format(strlen($compressedPdf) / 1024, 2) . ' KB');

            // ✅ 3. Langsung kirim ke user sebagai download
            return response($compressedPdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=\"$fileName\"");

        } catch (\Exception $e) {
            Log::error('❌ CetakRekapPengawas gagal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat PDF.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function CetakRekapCabdisDanPengawas(Request $request)
    {
        try {
            Log::info('📥 Permintaan cetak rekap cabdis/pengawas diterima', [
                'user_id' => Auth::id(),
                'role' => Auth::check() ? Auth::user()->role : null,
                'input' => $request->all()
            ]);

            // Validasi input
            $request->validate([
                'startDate' => 'required|date',
                'endDate' => 'required|date',
            ]);

            $startDate = Carbon::parse($request->startDate)->startOfDay();
            $endDate = Carbon::parse($request->endDate)->endOfDay();

            if ($endDate->lt($startDate)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tanggal akhir tidak boleh lebih kecil dari tanggal awal.'
                ], 400);
            }

            $user = Auth::user();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
            }

            // 🔍 Ambil daftar sekolah berdasarkan role user
            $sekolahIds = [];

            if ($user->role == 5) { // Pengawas
                $sekolahIds = DB::table('sekolah')
                    ->where('pengawas_id', $user->id)
                    ->pluck('id');
            } elseif ($user->role == 6) { // Cabang Dinas
                $wilayahKabupaten = DB::table('cabdis')
                    ->where('id', $user->cabdis)
                    ->value('kabupatenkota'); // string: "01, 02, 03"

                if ($wilayahKabupaten) {
                    $kabArray = array_map('trim', explode(',', $wilayahKabupaten));
                    $sekolahIds = DB::table('sekolah')
                        ->whereIn('kode_kabupaten', $kabArray)
                        ->pluck('id');
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses untuk mencetak rekap ini.'
                ], 403);
            }

            if ($sekolahIds->isEmpty()) {
                Log::warning('📭 Tidak ada sekolah ditemukan untuk user', ['user_id' => $user->id]);
                return response()->json([
                    'status' => 'nodata',
                    'message' => 'Tidak ada sekolah dalam wilayah Anda.'
                ], 404);
            }

            // 🔍 Ambil semua evaluasi kuesioner per sekolah dalam periode
            $evaluasiList = EvaluasiKuesioner::whereIn('sekolah', $sekolahIds)
                ->whereDate('periode_awal_kuesioner', $startDate->toDateString())
                ->whereDate('periode_akhir_kuesioner', $endDate->toDateString())
                ->with(['sekolahModel', 'ruangModel']) // relasi jika ada
                ->get();

            if ($evaluasiList->isEmpty()) {
                return response()->json([
                    'status' => 'nodata',
                    'message' => 'Tidak ada data evaluasi untuk periode ini.'
                ], 404);
            }

            // 🔧 Siapkan data untuk view
            $dataPerSekolah = [];

            foreach ($evaluasiList as $model) {
                $sekolah = $model->sekolahModel;
                $ruang = $model->ruangModel;

                // Ambil hasil kuesioner
                $stringIds = $model->id_kuesioner; // "{1,2,3}"
                $arrayIds = explode(',', trim($stringIds, '{}'));
                $hasilKuesioner = DB::table('hasil_kuesioner')
                    ->select('p.parameter', 'hasil_kuesioner.jawaban', 'hasil_kuesioner.deskripsi_jawaban')
                    ->join('parameter_kebersihan as p', 'p.id', '=', 'hasil_kuesioner.id_parameter')
                    ->whereIn('hasil_kuesioner.id', $arrayIds)
                    ->get();

                // Ambil verifikator
                $verifikator = DB::table('verifikator_sekolah')
                    ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
                    ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
                    ->where('verifikator_sekolah.id', $model->user_verifikasi)
                    ->first();

                $verifikatorpiket = DB::table('verifikator_sekolah')
                    ->select('verifikator_sekolah.*', 'rjv.nama as jabatan')
                    ->join('ref_jabatan_verifikator as rjv', 'rjv.id', '=', 'verifikator_sekolah.jabatan_verifikator')
                    ->where('verifikator_sekolah.id', $model->user_verifikasi_guru_piket)
                    ->first();

                // Ambil semua ruang di sekolah ini dalam periode yang sama
                $loop = DB::table('evaluasi_kuesioner as ek')
                    ->join('ruang_sekolah as rs', 'ek.id_ruang', '=', 'rs.id')
                    ->select('ek.*', 'rs.nama as nama_ruang')
                    ->where('ek.sekolah', $model->sekolah)
                    ->where('ek.periode_awal_kuesioner', $model->periode_awal_kuesioner)
                    ->where('ek.periode_akhir_kuesioner', $model->periode_akhir_kuesioner)
                    ->orderBy('rs.nama')
                    ->get();

                $dataPerSekolah[] = [
                    'model' => $model,
                    'sekolah' => $sekolah,
                    'ruang' => $ruang,
                    'hasilKuesioner' => $hasilKuesioner,
                    'verifikator' => $verifikator,
                    'verifikatorpiket' => $verifikatorpiket,
                    'loop' => $loop,
                ];
            }

            // 🖨️ Generate PDF dari view
            $fileName = "Rekap_Kebesihan_{$startDate->format('d-m-Y')}_sd_{$endDate->format('d-m-Y')}.pdf";

            $pdfContent = PDF::loadView('sekolahbersih.cetakrekapcabdis_all', [
                'dataPerSekolah' => $dataPerSekolah,
                'startDate' => $startDate->toDateString(),
                'endDate' => $endDate->toDateString(),
                'user' => $user,
            ])->output();

            Log::info('🖨 PDF asli berhasil dibuat', ['size_kb' => strlen($pdfContent) / 1024]);

            // 🧩 Kompresi dengan Ghostscript (opsional)
            $process = new Process([
                'gs',
                '-sDEVICE=pdfwrite',
                '-dCompatibilityLevel=1.4',
                '-dPDFSETTINGS=/default',
                '-dNOPAUSE',
                '-dQUIET',
                '-dBATCH',
                '-sOutputFile=-',
                '-'
            ]);

            $input = new InputStream();
            $process->setInput($input);
            $process->start();

            $input->write($pdfContent);
            $input->close();

            $process->wait();

            if (!$process->isSuccessful()) {
                Log::warning('⚠️ Ghostscript gagal, gunakan PDF asli', ['error' => $process->getErrorOutput()]);
                $finalPdf = $pdfContent;
            } else {
                $finalPdf = $process->getOutput();
                Log::info('✅ PDF berhasil dikompresi', ['size_kb' => strlen($finalPdf) / 1024]);
            }

            // 📥 Download langsung
            return response($finalPdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=\"$fileName\"");

        } catch (\Exception $e) {
            Log::error('❌ Gagal cetak rekap cabdis/pengawas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat laporan.',
                'debug' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }


}
