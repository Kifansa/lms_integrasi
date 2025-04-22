<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    // Menampilkan daftar pendaftaran mahasiswa
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return response()->json($enrollments);
    }

    // Menampilkan pendaftaran berdasarkan ID
    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->find($id);

        if ($enrollment) {
            return response()->json($enrollment);
        }

        return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
    }

    // Menambahkan pendaftaran baru
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment = Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
        ]);

        return response()->json(['message' => 'Pendaftaran berhasil dibuat', 'enrollment' => $enrollment], 201);
    }

    // Mengupdate data pendaftaran berdasarkan ID
    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment->student_id = $request->student_id;
        $enrollment->course_id = $request->course_id;
        $enrollment->save();

        return response()->json(['message' => 'Pendaftaran berhasil diperbarui', 'enrollment' => $enrollment]);
    }

    // Menghapus pendaftaran berdasarkan ID
    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
        }

        $enrollment->delete();

        return response()->json(['message' => 'Pendaftaran berhasil dihapus']);
    }
}
