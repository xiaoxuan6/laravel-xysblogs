<?php

namespace App\Console\Commands;

use App\Model\Oauth;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAvatar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:avatar {image}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('image');

        $name = Str::after(Str::before($url, '?'), "u/");
        $filename = 'github/'.$name.'.png';

        $client = new Client(['verify' => false]);
        $response = $client->get($url, ['save_to' => public_path($filename)]);
        if ($response->getStatusCode() == 200) {
            Storage::disk('cosv5')->put($filename, file_get_contents(public_path($filename)));
            Oauth::where('github_id', $name)->update(['image' => $filename]);
        }

        $this->info('ok');
    }
}
