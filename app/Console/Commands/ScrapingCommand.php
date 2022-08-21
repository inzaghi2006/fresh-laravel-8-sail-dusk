<?php

namespace App\Console\Commands;

use App\Browser;
use Illuminate\Console\Command;
use Laravel\Dusk\Browser as DuskBrowser;

class ScrapingCommand extends Command
{
    protected $browser;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:amazon';

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
    public function __construct(Browser $browser)
    {
        parent::__construct();

        $this->browser = $browser;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->browser->startBrowser(function (DuskBrowser $browser) {
            $browser->visit('https://www.amazon.com/b?node=17938598011');
            //$browser->screenshot(storage_path('screenshot/' . uniqid()));
            $browser->pause(1000);

            $browser->press('.glow-toaster-button-dismiss');

            // $browser->screenshot(storage_path('screenshot/' . uniqid()));


            $browser->refresh();

            $browser->pause(1000);

            //$browser->screenshot(storage_path('screenshot/' . uniqid()));



            $browser->with('#s-refinements', function (DuskBrowser $departmentsBlock) use ($browser) {

                $allLinks = $departmentsBlock->elements('.a-color-base.a-link-normal');
                // Gets a little interesting here...

                \Log::info($allLinks[0]->getText());
            });
        });
    }

    protected function driver()
    {
        // $options = (new ChromeOptions)->addArguments(collect([
        //     $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
        // ])->unless($this->hasHeadlessDisabled(), function ($items) {
        //     return $items->merge([
        //         '--disable-gpu',
        //         '--headless',
        //     ]);
        // })->all());

        // return RemoteWebDriver::create(
        //     $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
        //     DesiredCapabilities::chrome()->setCapability(
        //         ChromeOptions::CAPABILITY,
        //         $options
        //     )
        // );
    }
}
