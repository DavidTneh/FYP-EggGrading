<?php

namespace App\Models;

use BaconQrCode\Writer;
use Illuminate\Support\Facades\Log;
use BaconQrCode\Renderer\ImageRenderer;
use Illuminate\Database\Eloquent\Model;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class Chicken extends Model
{
    protected $table = 'chicken';
    protected $primaryKey = 'chickenID';
    protected $fillable = ['breedID', 'dob', 'cageID'];

    public function breed()
    {
        return $this->belongsTo(ChickenBreeds::class, 'breedID');
    }

    public function cage()
    {
        return $this->belongsTo(Cage::class, 'cageID');
    }

    public function vaccinationRecords()
    {
        return $this->hasMany(VaccinationRecords::class, 'chickenID', 'chickenID');
    }



    public function getQrCodeAttribute()
    {
        $qrCodeData = json_encode([
            'chickenID' => $this->chickenID,
            'dob' => $this->dob,
            'cageID' => $this->cageID,
            'breedID' => $this->breedID,
        ]);

        try {
            $renderer = new ImageRenderer(
                new RendererStyle(300), // 300x300 px QR code
                new SvgImageBackEnd()   // Fallback to SVG rendering
            );
            $writer = new Writer($renderer);

            // Generate QR code and encode it in base64
            $qrCodeImage = $writer->writeString($qrCodeData);
            return 'data:image/svg+xml;base64,' . base64_encode($qrCodeImage);
        } catch (\Exception $e) {
            Log::error('QR Code Generation Error: ' . $e->getMessage());
            return null; // Graceful fallback
        }
    }
}
