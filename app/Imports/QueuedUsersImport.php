<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Events\ImportFailed;
use App\Notifications\ImportCompletedNotification;
use App\Notifications\ImportFailedNotification;

class QueuedUsersImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue, WithEvents
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function model(array $row)
    {
        return new User([
            'full_name' => $row['full_name'] ?? null,
            'password' => Hash::make($row['password'] ?? 'defaultpassword'), 
        ]);
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'full_name.required' => 'The full_name column is missing from the Excel file',
            'password.required' => 'The password column is missing from the Excel file',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        return [
            'full_name' => $data['full_name'] ?? null,
            'password' => $data['password'] ?? null,
        ];
    }

       public function chunkSize(): int
    {
        return 500; 
    }

    public function queue(): string
    {
        return 'imports'; 
    }

    public function timeout(): int
    {
        return 120; 
    }

   
    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {
                if ($this->user) {
                    $this->user->notify(new ImportFailedNotification());
                }
            },
        ];
    }
}