<?php

namespace App\Filament\Resources\EncounterResource\Pages;

use App\Models\Invoice;
use App\Models\Service;
use App\Models\InvoiceItem;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Filament\Resources\InvoiceResource;
use App\Filament\Resources\EncounterResource;
use Filament\Resources\Pages\ViewRecord; // <-- Corrected

class ViewEncounter extends ViewRecord // <-- Corrected
{
    protected static string $resource = EncounterResource::class;
    protected function getHeaderActions(): array
{
    return [
        Action::make('Generate Invoice')
            ->action(function () {
                // 1. Find the standard consultation service
                $consultation = Service::where('name', 'Doctor Consultation')->first();

                // 2. Create the main Invoice record
                $invoice = Invoice::create([
                    'patient_id' => $this->record->patient_id,
                    'encounter_id' => $this->record->id,
                    'total_amount' => 0, // We'll calculate this next
                    'status' => 'Unpaid',
                ]);

                $total = 0;

                // 3. Add the consultation fee as the first item
                if ($consultation) {
                    $invoice->items()->create([
                        'description' => $consultation->name,
                        'quantity' => 1,
                        'unit_price' => $consultation->price,
                        'total_price' => $consultation->price,
                    ]);
                    $total += $consultation->price;
                }

                // 4. Add each prescribed medication as an item
                foreach ($this->record->prescriptions as $prescription) {
                    $price = $prescription->medication?->price ?? 0;
                    $invoice->items()->create([
                        'description' => $prescription->medication->name,
                        'quantity' => 1, // Assuming quantity of 1 for simplicity
                        'unit_price' => $price,
                        'total_price' => $price,
                    ]);
                    $total += $price;
                }

                // 5. Update the invoice with the final calculated total
                $invoice->update(['total_amount' => $total]);

                Notification::make()
                    ->title('Invoice Generated Successfully')
                    ->success()
                    ->send();

                // Optional: Redirect to the new invoice
                return redirect(InvoiceResource::getUrl('edit', ['record' => $invoice]));
            })
            ->requiresConfirmation()
            ->color('success')
            ->icon('heroicon-o-document-plus')
            // Only show button if an invoice doesn't exist for this encounter
            ->visible(fn (): bool => is_null($this->record->invoice)),
    ];
}
}
