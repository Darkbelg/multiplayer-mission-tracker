<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Showallmissions extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'missions';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Show all the missions in the spreadsheet';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
// Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new \Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '11p1lvunqTOmaPmLmNHzLFVKUX-pGN21mzSJFxF-w3p4';
        $range = 'No.3 SOG Missions!E10:E25';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            print "No data found.\n";
        } else {
            //dd($values);
            $mask = "%s \n";
            foreach ($values as $row) {
                // Print columns A and E, which correspond to indices 0 and 4.
                echo  sprintf($mask,$row[0]);
            }
        }

        $search = "SOG co@ 45 We was out walking like always v02";
        $filename = 'storage/ZA3_No3VN_7216.log';
        echo "executing: ";
        //  $handle = file($filename,"r");
        $contents = file($filename);
        //    fclose($handle);
//        var_dump($contents);
        foreach ($contents as $key => $line){
            if (str_contains($line, "Game finished.")){
                echo explode("\"",$contents[$key +3])[1];
            }
        }

//        $range = "congress!E2:F2";
//        $values = [
//            ["Stijn", "Sagaert"],
//        ];
//        $body = new \Google_Service_Sheets_ValueRange([
//           'values' => $values
//        ]);
//
//        $params = [
//            'valueInputOption' => 'RAW'
//        ];
//
//        $result = $service->spreadsheets_values->update(
//            $spreadsheetId,
//            $range,
//            $body,
//            $params
//        );
    }

    /**
     * Define the command's schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    private function getClient()
    {

        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets and PHP');
        $client->setScopes(\Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
//        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
//        $tokenPath = 'token.json';
//        if (file_exists($tokenPath)) {
//            $accessToken = json_decode(file_get_contents($tokenPath), true);
//            $client->setAccessToken($accessToken);
//        }
//
//// If there is no previous token or it's expired.
//        if ($client->isAccessTokenExpired()) {
//            // Refresh the token if possible, else fetch a new one.
//            if ($client->getRefreshToken()) {
//                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
//            } else {
//                // Request authorization from the user.
//                $authUrl = $client->createAuthUrl();
//                printf("Open the following link in your browser:\n%s\n", $authUrl);
//                print 'Enter verification code: ';
//                $authCode = trim(fgets(STDIN));
//
//                // Exchange authorization code for an access token.
//                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
//                $client->setAccessToken($accessToken);
//
//                // Check to see if there was an error.
//                if (array_key_exists('error', $accessToken)) {
//                    throw new Exception(join(', ', $accessToken));
//                }
//            }
//            // Save the token to a file.
//            if (!file_exists(dirname($tokenPath))) {
//                mkdir(dirname($tokenPath), 0700, true);
//            }
//            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
//        }
        return $client;
    }
}
