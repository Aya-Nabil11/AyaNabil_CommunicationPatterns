<?php

use App\Models\Announcement;

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

while (true) {
    // Fetch last announcement
    $announcement = Announcement::latest()->first();

    if ($announcement) {
        echo "data: " . json_encode($announcement) . "\n\n";
        ob_flush();
        flush();
    }

    sleep(10); // check every 10s
}
