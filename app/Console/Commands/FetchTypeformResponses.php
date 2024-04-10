<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchTypeformResponses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeformresponses {formtype : type du typeform} {since? : Depuis la date en format yyyy-mm-dd}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Télécharger les données reponses du typeform";

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * answers file
     *
     * @var object
     */
    protected $answers;

    /**
     * token typeform
     *
     * @var string
     */
    protected $typeformToken;

    /**
     * Typeform response url
     *
     * @var string
     */

    protected $url;

    /**
     * questionNameID is the typeform question ID where the name of the place is defined
     *
     * @var array
     */
    protected $questionNameID = [
        'general_information' => '2fr8a983Wpaq',
        'environmental' => 'pEuQLVD5J2q7',
        'social_impact' => '7HmN9RJkBcMe'
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logger = Log::channel('import');

        $token = getenv('TYPEFORM_TOKEN');
        if ($token === false) {
            throw new \LogicException('Token typeform non défini. Est-il renseigné dans le fichier .env ?');
        }

        $this->typeformToken = $token;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $formType = $this->argument('formtype');
        switch ($formType) {
            case 'general_information':
                $typeformID = getenv('TYPEFORM_GENERAL_INFORMATION');
                break;

            case 'environmental':
                $typeformID = getenv('TYPEFORM_ENVIRONMENTAL');
                break;

            default:
                $typeformID = getenv('TYPEFORM_SOCIAL_IMPACT');
                break;
        }

        if ($typeformID === false) {
            throw new \LogicException("Typeform $formType ID. Est-il renseigné dans le fichier .env ?");
        }

        $since = $this->argument('since');
        if ($since == '') {
            $yesterday = Carbon::yesterday();
            $formattedDate = $yesterday->toIso8601String();
            $since = substr($formattedDate, 0, -6);

        } else {
            $since = $since."T00:00:00";
        }

        $this->url = "https://api.typeform.com/forms/$typeformID/responses?since=$since";

        // Create a Guzzle client instance
        $client = new Client(['verify' => false]);

        try {
            // Make a GET request to retrieve responses
            $response = $client->request('GET', $this->url, [
                'headers' => [
                    'Authorization' => "Bearer $this->typeformToken",
                ]
            ]);

            $this->logger->info("Getting $this->url responses");

            // Get the response body as a string
            $responseData = $response->getBody()->getContents();

            // Decode the JSON response
            $responseDataArray = json_decode($responseData, true);

            // Check if there are responses
            if (isset($responseDataArray['items']) && !empty($responseDataArray['items'])) {
                // Loop through each response
                foreach ($responseDataArray['items'] as $item) {
                    if (isset($item['answers'])) {
                        $placeName = '';
                        foreach($item['answers'] as $answer) {
                            if (isset($answer['field']) && isset($answer['field']['id']) && $answer['field']['id'] === $this->questionNameID[$formType]) {
                                $placeName =  Str::slug($answer['text']);
                                $this->logger->info("Fetching $placeName");
                                $itemJson = json_encode($item, JSON_PRETTY_PRINT);
                                Storage::disk('import')->put("{$formType}/{$placeName}.json", $itemJson);
                                break;
                            }
                        }
                    }
                }
            } else {
                echo "No responses found for the form.\n";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
