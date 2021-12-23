<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;
use Xendit\Xendit;
Xendit::setApiKey('xnd_production_bFCXKxdow7fRIccoLP4kptLTSdsJMwMOVxIFzCR04x8KZzNr583Kgzvf3NtMnSRD');

class ChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chennel = \Xendit\PaymentChannels::list();
        
        foreach ($chennel as $key => $value) {
            $data = new Channel;
            $data->name = $value['name'];
            $data->code = $value['channel_code'];
            $data->img = $value['channel_code'].'.png';
            $data->img = $value['channel_code'].'.png';
            $data->active = true;
            $data->save();
        }

    }
}
