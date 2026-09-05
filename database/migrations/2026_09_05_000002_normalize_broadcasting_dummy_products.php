<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $broadcasting = DB::table('jurusans')->where('slug', 'mm')->first();
        $legacyBroadcasting = DB::table('jurusans')->where('slug', 'bp')->first();

        if (! $broadcasting && $legacyBroadcasting) {
            DB::table('jurusans')->where('id', $legacyBroadcasting->id)->update(['slug' => 'mm']);
        }

        foreach ([
            'Teknik Elektronika Industri' => 'Teknik Elektronika',
            'Teknik Kendaraan Ringan' => 'Otomotif',
        ] as $oldName => $newName) {
            $jurusan = DB::table('jurusans')->where('nama', $newName)->first();

            if (! $jurusan) {
                continue;
            }

            DB::table('produks')
                ->where('jurusan_id', $jurusan->id)
                ->where('nama', 'like', '% - ' . $oldName)
                ->delete();
        }
    }

    public function down(): void
    {
        DB::table('jurusans')->where('slug', 'mm')->update(['slug' => 'bp']);
    }
};