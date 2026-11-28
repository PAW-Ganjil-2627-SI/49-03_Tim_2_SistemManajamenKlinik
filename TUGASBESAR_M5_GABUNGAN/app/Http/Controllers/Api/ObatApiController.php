<?php

// Simpan di: app/Http/Controllers/Api/ObatApiController.php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObatApiController extends Controller
{
    /**
     * GET /api/obat
     * Daftar obat. Opsional: ?search=para&per_page=20
     */
    public function index(Request $request): JsonResponse
    {
        $query = Obat::query();

        if ($request->filled('search')) {
            $query->where('nama_obat', 'like', '%' . $request->search . '%');
        }

        $obat = $query->orderByDesc('id')->paginate($request->integer('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Daftar obat berhasil diambil',
            'data'    => $obat,
        ]);
    }

    /**
     * POST /api/obat
     * Tambah obat baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $obat = Obat::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data'    => $obat,
        ], 201);
    }

    /**
     * GET /api/obat/{id}
     * Detail satu obat.
     */
    public function show(string $id): JsonResponse
    {
        $obat = Obat::find($id);

        if (!$obat) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail obat berhasil diambil',
            'data'    => $obat,
        ]);
    }

    /**
     * PUT/PATCH /api/obat/{id}
     * Ubah data obat.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $obat = Obat::find($id);

        if (!$obat) {
            return $this->notFound();
        }

        $validator = Validator::make($request->all(), $this->rules(true));

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $obat->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil diperbarui',
            'data'    => $obat,
        ]);
    }

    /**
     * DELETE /api/obat/{id}
     * Hapus obat.
     */
    public function destroy(string $id): JsonResponse
    {
        $obat = Obat::find($id);

        if (!$obat) {
            return $this->notFound();
        }

        $obat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil dihapus',
        ]);
    }

    /**
     * ATURAN VALIDASI
     * Sesuaikan nama kolom dengan file migration create_obat_table kamu.
     */
    private function rules(bool $isUpdate = false): array
    {
        $wajib = $isUpdate ? 'sometimes' : 'required';

        return [
            'nama_obat' => [$wajib, 'string', 'max:255'],
            'kategori'  => [$wajib, 'string', 'max:100'],
            'sediaan'   => [$wajib, 'string', 'max:100'],
            'pabrikan'  => [$wajib, 'string', 'max:255'],
        ];
    }

    private function validationError($validator): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid',
            'errors'  => $validator->errors(),
        ], 422);
    }

    private function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Obat tidak ditemukan',
        ], 404);
    }
}
