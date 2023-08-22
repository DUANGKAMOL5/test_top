<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Catalog;
use App\Models\CatalogImage;

class ImageCatalogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_catalog_and_upload_images()
    {
        Storage::fake('local'); // เปิดใช้งานการจำลอง Storage

        $this->post('/catalogs', ['name' => 'Test Catalog']); // สร้าง catalog

        $catalog = Catalog::first();

        $image1 = UploadedFile::fake()->image('image1.jpg');
        $image2 = UploadedFile::fake()->image('image2.jpg');

        $this->post("/catalogs/{$catalog->id}/images", ['images' => [$image1, $image2]]);

        $this->assertCount(2, CatalogImage::all()); // ตรวจสอบว่ามีรูปภาพใน catalog
        Storage::disk('local')->assertExists(CatalogImage::first()->image_path); // ตรวจสอบว่ารูปถูกบันทึกใน storage
    }

    /** @test */
    public function a_user_can_view_images_in_catalog()
    {
        $catalog = Catalog::factory()->create();
        $image = CatalogImage::factory()->create(['catalog_id' => $catalog->id]);

        $response = $this->get("/catalogs/{$catalog->id}/images");

        $response->assertStatus(200);
        $response->assertSee($image->image_path); // ตรวจสอบว่ามีรูปภาพแสดงในหน้า View
    }
}
