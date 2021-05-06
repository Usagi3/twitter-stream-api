<?php

use RWC\Phirehose\Phirehose;

require __DIR__ . '/../vendor/autoload.php';
/**
 * Example of using Phirehose to display the 'sample' twitter stream.
 */
class SampleConsumer extends Phirehose
{
    /**
     * Enqueue each status.
     *
     * @param string $status
     */
    public function enqueueStatus($status)
    {
        /*
         * In this simple example, we will just display to STDOUT rather than enqueue.
         * NOTE: You should NOT be processing tweets at this point in a real application, instead they should be being
         *       enqueued and processed asyncronously from the collection process.
         */
        $data = json_decode($status, true, 512, JSON_THROW_ON_ERROR);
        if (is_array($data) && isset($data['user']['screen_name'])) {
            echo $data['lang'] . ': ' . $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
        }
    }
}

// Start streaming
$sc = new SampleConsumer('username', 'password', Phirehose::METHOD_SAMPLE);
//$sc = new SampleConsumer('username', 'password', Phirehose::METHOD_SAMPLE, Phirehose::FORMAT_JSON, 'en');
$sc->setLang('es');
$sc->consume();
