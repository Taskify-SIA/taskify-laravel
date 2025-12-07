<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\TeamMember;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Main User
        $user = User::create([
            'name' => 'Alif Bima Pradana',
            'email' => 'alif@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create 3 Team Members
        $teamMember1 = TeamMember::create([
            'user_id' => $user->id,
            'name' => 'Fadhila Naholo',
            'email' => 'fadhila@gmail.com',
            'role' => 'Project Manager',
            'phone' => '081234567890',
        ]);

        $teamMember2 = TeamMember::create([
            'user_id' => $user->id,
            'name' => 'Regita Cahyani Majid',
            'email' => 'regita@gmail.com',
            'role' => 'UI/UX Designer',
            'phone' => '081234567891',
        ]);

        $teamMember3 = TeamMember::create([
            'user_id' => $user->id,
            'name' => 'Aura Iftita',
            'email' => 'aura@gmail.com',
            'role' => 'UI/UX Designer',
            'phone' => '081234567892',
        ]);
        $teamMember4 = TeamMember::create([
            'user_id' => $user->id,
            'name' => 'Zulkarnain Hunto',
            'email' => 'zulkarnain@gmail.com',
            'role' => 'Documentation System',
            'phone' => '081234567893',
        ]);

        // Create Tasks
        $task1 = Task::create([
            'user_id' => $user->id,
            'title' => 'Siapkan Presentasi Q4',
            'description' => 'Mengumpulkan data dari tim sales dan marketing untuk presentasi kuartal 4.',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => Carbon::tomorrow(),
            'due_time' => '14:00:00',
        ]);
        $task1->teamMembers()->attach([$teamMember1->id, $teamMember2->id]);

        $task2 = Task::create([
            'user_id' => $user->id,
            'title' => 'Update Server',
            'description' => 'Maintenance rutin bulanan dan patch security untuk server production.',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => Carbon::today(),
            'due_time' => '23:00:00',
        ]);
        $task2->teamMembers()->attach([$teamMember3->id]);

        $task3 = Task::create([
            'user_id' => $user->id,
            'title' => 'Redesain Homepage',
            'description' => 'Membuat mockup dan prototype baru untuk homepage website perusahaan.',
            'status' => 'in_progress',
            'priority' => 'medium',
            'due_date' => Carbon::today(),
            'due_time' => '17:00:00',
        ]);
        $task3->teamMembers()->attach([$teamMember1->id]);

        $task4 = Task::create([
            'user_id' => $user->id,
            'title' => 'Laporan Bulanan',
            'description' => 'Menyusun laporan progress project dan budget untuk manajemen.',
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => Carbon::tomorrow(),
            'due_time' => '09:00:00',
        ]);
        $task4->teamMembers()->attach([$teamMember1->id, $teamMember4->id]);

        $task5 = Task::create([
            'user_id' => $user->id,
            'title' => 'Code Review Sprint 12',
            'description' => 'Review code dari sprint 12 dan memberikan feedback ke tim developer.',
            'status' => 'completed',
            'priority' => 'low',
            'due_date' => Carbon::yesterday(),
            'due_time' => '15:00:00',
            'is_completed' => true,
        ]);
        $task5->teamMembers()->attach([$teamMember2->id, $teamMember3->id]);

        $task6 = Task::create([
            'user_id' => $user->id,
            'title' => 'Meeting dengan Client',
            'description' => 'Diskusi requirement project baru dengan client PT. Sejahtera Makmur.',
            'status' => 'completed',
            'priority' => 'high',
            'due_date' => Carbon::yesterday(),
            'due_time' => '10:00:00',
            'is_completed' => true,
        ]);

        $task7 = Task::create([
            'user_id' => $user->id,
            'title' => 'Testing Fitur Pembayaran',
            'description' => 'Melakukan testing menyeluruh untuk fitur payment gateway yang baru.',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => Carbon::now()->addDays(2),
            'due_time' => '16:00:00',
        ]);
        $task7->teamMembers()->attach([$teamMember2->id, $teamMember3->id]);

        $task8 = Task::create([
            'user_id' => $user->id,
            'title' => 'Update Dokumentasi API',
            'description' => 'Memperbarui dokumentasi API untuk endpoint yang baru ditambahkan.',
            'status' => 'pending',
            'priority' => 'low',
            'due_date' => Carbon::now()->addDays(3),
            'due_time' => '12:00:00',
        ]);
        $task8->teamMembers()->attach([$teamMember3->id]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Email: alif@gmail.com');
        $this->command->info('🔑 Password: password');
    }
}