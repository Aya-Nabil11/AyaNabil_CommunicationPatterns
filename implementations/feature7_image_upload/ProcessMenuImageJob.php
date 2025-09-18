<?php

namespace App\Jobs;

use App\Models\MenuImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;

class ProcessMenuImageJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $menuImage;

    public function __construct(MenuImage $menuImage)
    {
        $this->menuImage = $menuImage;
    }

    public function handle()
    {
        $this->menuImage->update(['status' => 'processing']);

        try {
            $path = storage_path('app/public/' . $this->menuImage->path);
            $img = Image::make($path)->resize(800, null, function ($c) {
                $c->aspectRatio();
            });
            $img->save($path);

            $this->menuImage->update(['status' => 'completed']);
        } catch (\Exception $e) {
            $this->menuImage->update(['status' => 'failed']);
        }
    }
}
