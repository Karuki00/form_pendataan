<?php

namespace Tests\Feature;

use App\Models\Citizen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitizenManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_citizen_can_be_registered_with_household_information(): void
    {
        $response = $this->post(route('citizens.store'), [
            'nik' => '3273010101010001',
            'name' => 'Budi Santoso',
            'wife_name' => 'Siti Santoso',
            'house_number' => '12A',
            'marital_status' => 'married',
            'children_count' => 2,
            'income_range' => '4_8jt',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('citizens.index'));
        $this->assertDatabaseHas('citizens', [
            'nik' => '3273010101010001',
            'wife_name' => 'Siti Santoso',
            'house_number' => '12A',
            'children_count' => 2,
            'status' => 'active',
        ]);
    }

    public function test_a_citizen_can_be_updated_without_changing_their_nik(): void
    {
        $citizen = Citizen::factory()->create();

        $response = $this->put(route('citizens.update', $citizen), [
            'nik' => $citizen->nik,
            'name' => 'Updated Name',
            'wife_name' => null,
            'house_number' => '99',
            'marital_status' => 'single',
            'children_count' => 0,
            'income_range' => '0_3jt',
            'status' => 'moved',
        ]);

        $response->assertRedirect(route('citizens.index'));
        $this->assertDatabaseHas('citizens', [
            'id' => $citizen->id,
            'name' => 'Updated Name',
            'status' => 'moved',
            'house_number' => '99',
        ]);
    }

    public function test_citizen_data_can_be_downloaded_as_an_excel_compatible_file(): void
    {
        Citizen::factory()->create(['name' => 'Budi Santoso']);

        $response = $this->get(route('citizens.export.excel'));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->assertHeader('Content-Disposition', 'attachment; filename="data-penduduk.xls"')
            ->assertSee('Budi Santoso');
    }

    public function test_citizen_data_has_a_printable_pdf_view(): void
    {
        Citizen::factory()->create(['name' => 'Siti Santoso']);

        $response = $this->get(route('citizens.export.pdf'));

        $response->assertOk()
            ->assertHeader('Content-Type', 'text/html; charset=UTF-8')
            ->assertSee('Cetak / Simpan sebagai PDF')
            ->assertSee('Siti Santoso');
    }
}
