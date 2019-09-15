<?php


namespace App\Service;


use App\Entity\Session;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FinqwareService
{
    const CLIENT_ID = 'baf5a8bd-d99a-4800-ac17-fc96cfcb3f43';
    const CLIENT_SECRET = 'f8e3319f-e8da-4b61-9707-c3218393adc3';
    const CLIENT_APP_KEY = 'MDAxNmxvY2F0aW9uIGZpbnF3YXJlCjAwMWNpZGVudGlmaWVyIHRlbnRhbnQtdGVzdAowMDE2Y2lkIHNjb3BlPXNlc3Npb24KMDAzN2NpZCBjbGllbnRfaWQ9YmFmNWE4YmQtZDk5YS00ODAwLWFjMTctZmM5NmNmY2IzZjQzCjAwMmZzaWduYXR1cmUg7B3APdsfqewY1pJGT20k97OyQxXYWxVxWUgTgWNZQNcK';

    const SESSION_ENDPOINT = 'https://api.finqware.com/v1/sessions';
    const SESSION_AUTH = 'https://api.finqware.com/v1/sessions/%s/steps';

    const ERSTE_RO_ENHANCED = 'erste_ro_aisp_sbx_#2.0';

    private $sessionRequestBody;
    private $nounce;
    private $sessionId;

    public function __construct()
    {
        $this->sessionRequestBody = (new Session())->setClientId(self::CLIENT_ID)->setClientAppKey(self::CLIENT_APP_KEY);
    }

    /**
     * @param $requestUri
     * @param $options
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getRequestClient($requestUri, $options)
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', $requestUri, $options);

        return $response;
    }


    /**
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getErsteEnhancedAuthSession()
    {
        $ersteSession = $this->sessionRequestBody;
        $ersteSession->setSkill(self::ERSTE_RO_ENHANCED);
        $ersteSessionResponse = $this->getRequestClient(self::SESSION_ENDPOINT, ['body' => $ersteSession]);
        return $ersteSessionResponse->getContent();
        if ($ersteSessionResponse->getStatusCode() == Response::HTTP_OK) {
            return $ersteSessionResponse->getContent();
        } else {

        }

    }

    //Start a session
    //This is an onboarding session that allows you to get user's consent to access their bank account/s data.
    //
    //API endpoint:
    //
    //POST
    //
    //Request body:
    //
    //Use your tenant app secrets client_id and client_app_key.
    //
    //
    //Response:
    //
    //{
    //  "nonce": "MDAxNmxvY2F0a...z0sBtsOyVdJ04kK",
    //  "session_id": "58f92378-...-20a052aca460",
    //  "status": "SESSION_CREATED"
    //}
    //Steps
    //Each session has a number of steps, depending on each skill. AISP skills in particular are very simple, requiring only one step.
    //
    //Step #1: sca (strong customer authentication)
    //API endpoint:
    //
    //POST https://api.finqware.com/v1/sessions/{{session_id}}/steps
    //
    //Request body:
    //
    //{
    //  "client_id": "{{client_id}}",
    //  "nonce": "{{nonce}}",
    //  "skill": "erste_ro_aisp_sbx_#2.0",
    //  "step": "sca",
    //  "data": {
    //    "psu_redirect_link": "myapp://your_redirect_uri"
    //  }
    //}
    //Response:
    //
    //{
    //  "data": {
    //    "headers": {
    //      "Content-Type": "application/x-www-form-urlencoded"
    //    },
    //    "method": "GET",
    //    "url": "https://webapi.developers.erstegroup..."
    //  },
    //  "status": "SESSION_IN_PROGRESS"
    //}
    //Open the provided url in a webview/webpage. The content is served directly by the bank, for the user to give their consent for data access.
    //
    //Ending the session
    //
    //Once the end-user submits the consent, Finqware will provide a temp_token by redirecting the webview/webpage to your endpoint:
    //
    //myapp://your_redirect_uri?temp_token=MDAx...vN1wo
    //
    //You have to intercept that call (eg: catching a URL change event) and extract the temp_token. Send this token to your backend app in order to do the token exchange.
    //
    //Token exchange
    //This call should be done server-side only (in production environments).
    //
    //API endpoint:
    //
    //POST https://api.finqware.com/v1/tokens
    //
    //Request body:
    //
    //{
    //  "client_id": "{{client_id}}",
    //  "client_secret": "{{client_secret}}",
    //  "temp_token": "MDAx...vN1wo"
    //}
    //Response:
    //
    //{
    //  "access_token": "MDAxNm...kyyPCg",
    //  "credentials_id": "527...a07"
    //}
    //Finally, use these values to call the /accounts and /transactions endpoints.
}