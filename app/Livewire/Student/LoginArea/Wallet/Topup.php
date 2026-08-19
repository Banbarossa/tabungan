<?php

namespace App\Livewire\Student\LoginArea\Wallet;

use App\Models\MetaSetting;
use App\Models\TopupRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use finfo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Topup extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $steps = [
        [
            "step"  => "1",
            "title" => "Transfer ke Rekening Pesantren",
            "desc"  => "Transfer ke rek yang tertera dibagian bawah ini"
        ],
        [
            "step"  => "2",
            "title" => "Gunakan Kode Unik Santri",
            "desc"  => "Masukkan NIS santri di berita transfer"
        ],
        [
            "step"  => "3",
            "title" => "Konfirmasi ke Admin",
            "desc"  => "Hubungi admin pesantren di Nomor"
        ],
        [
            "step"  => "4",
            "title" => "Saldo Diperbarui",
            "desc"  => "Saldo akan masuk dalam 1×24 jam kerja"
        ],
    ];

    public $bank = [];

    public $resi_upload;
    public $keterangan_resi = "";
    public $jumlah_topup = '';
    public $tanggal_topup = '';


    #[Layout('components.wallet.layout')]

    public function mount()
    {
        $this->dataAccount();
        $this->tanggal_topup = Carbon::now()->toDateString();;
    }
    public function render()
    {
        return view('livewire.student.login-area.wallet.topup');
    }

    #[Computed()]
    public function dataTopupRequests()
    {
        return TopupRequest::where('student_id', auth('student')->user()->id)
            ->where('type', 'wallet')
            ->where('status', 'pending')
            ->paginate(10)->through(function($item){
                return (object) [
                    'jumlah'=>format_rupiah($item->jumlah),
                    'tanggal'=>Carbon::parse($item->tanggal_topup)->locale('id')->translatedFormat('d M Y'),
                    'file_path'=>$item->file_path,
                    'keterangan'=>$item->keterangan,
                    'status'=>$item->status,
                ];
            });
    }

    public function uploadResi()
    {
        $jumlah = sanitizeRupiah($this->jumlah_topup);

        if ($jumlah < 10000) {
            $this->addError('jumlah_topup', 'Jumlah top up minimal Rp 10.000');
            return;
        }

        $this->validate();

        $file = $this->resi_upload;
        $folder = 'resi-jajan';
        $source_image = @imagecreatefromstring(file_get_contents($file->getRealPath()));

        if ($source_image !== false) {
            $filePath = $folder . '/' . $file->hashName();

            ob_start();
            imagejpeg($source_image, null, 85);
            $cleanImageData = ob_get_clean();
            imagedestroy($source_image);

            Storage::disk('public')->put($filePath, $cleanImageData);
        } else {
            $filePath = $file->store($folder, 'public');
        }

        $referenceNumber = 'wlt-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        TopupRequest::create([
            'reference_number' => $referenceNumber,
            'type'             => 'wallet',
            'student_id'       => auth('student')->user()->id,
            'jumlah'           => $jumlah,
            'file_path'        => $filePath,
            'keterangan'       => $this->keterangan_resi,
            'tanggal_topup'    => $this->tanggal_topup,
            'status'           => 'pending',
        ]);

        $this->reset(['resi_upload', 'jumlah_topup', 'keterangan_resi', 'tanggal_topup']);

        $this->dispatch('close-modal', name: 'modal-topup');
        session()->flash('success', 'Pengajuan top up berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function rules()
    {
        return [
            'resi_upload'     => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'keterangan_resi' => ['nullable', 'string', 'max:255'],
            'jumlah_topup'    => ['required', 'string', 'max:255'],
            'tanggal_topup'   => ['required', 'date'],
        ];
    }
    public function messages()
    {
        return [
            'resi_upload.required'  => 'Silakan pilih file bukti transfer terlebih dahulu.',
            'resi_upload.image'     => 'File harus berupa gambar.',
            'resi_upload.mimes'     => 'Format file yang diperbolehkan hanya PNG, JPG, dan JPEG.',
            'resi_upload.max'       => 'Ukuran file maksimal adalah 2 MB.',
            'jumlah_topup.required' => 'Jumlah top up wajib diisi.',
            'tanggal_topup.required' => 'Tanggal wajib diisi.',
            'tanggal_topup.date'     => 'Format tanggal tidak sesuai.',
        ];
    }

    #[Computed]
    public function riwayat()
    {
        return Transaction::where('student_id', auth()->user()->id)->where('type', 'setor')->latest('date')->paginate(15)->through(function ($item) {
            return (object) [
                'tanggal' => Carbon::parse($item->date)->format('d/m/Y'),
                'type' => $item->type,
                'petugas' => $item->handledbyUser?->name ?? '-',
                'jumlah' => number_format($item->amount, 0, ',', '.'),
            ];
        });
    }

    public function dataAccount()
    {

        $keys = ['nomor_rekening_jajan', 'nama_rekening_jajan', 'nama_bank_jajan', 'hp_konfirmasi_jajan'];
        $setting = MetaSetting::whereIn('name', $keys)->pluck('value', 'name');
        $this->bank = [
            'bank' => $setting->get('nama_bank_jajan', '-'),
            'rek' => $setting->get('nomor_rekening_jajan'),
            'logo' => asset('logo/bsi.png'),
            'nama' => $setting->get('nama_rekening_jajan'),
            'hp_konfirmasi' => $setting->get('hp_konfirmasi_jajan'),

        ];
    }
}
