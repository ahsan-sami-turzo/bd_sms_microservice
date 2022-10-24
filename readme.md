SMS gateway package for sending text message to Bangladeshi mobile numbers

# Installation

## Step 1:

```
composer require radon/laravelbdsms
```

## Step 2:

```
php artisan vendor:publish --provider=Radon\LaravelBDSms\LaravelBDSmsServiceProvider
```

## Step 3:

```
php artisan config:cache && php artisan migrate
```


# Sample Code
## SSLCommerz
<pre>
use Radon\LaravelBDSms\Provider\Ssl;
use Radon\LaravelBDSms\Sender;

$sender = Sender::getInstance();
$sender->setProvider(Ssl::class); 
$sender->setMobile('017XXYYZZAA');
$sender->setMessage('helloooooooo boss!');
$sender->setQueue(true); //if you want to sent sms from queue
$sender->setConfig(
   [
       'api_token' => 'api token goes here',
       'sid' => 'text',
       'csms_id' => 'sender_id'
   ]
);
$status = $sender->send();
</pre>

### Demo Response Using SSL

<pre>
array:6 [▼
  "status" => "response"
  "response" => "{"status":"FAILED","status_code":4003,"error_message":"IP Blacklisted"}"
  "provider" => "Radon\LaravelBDSms\Provider\Ssl"
  "send_time" => "2021-07-06 08:03:23"
  "mobile" => "017XXYYZZAA"
  "message" => "helloooooooo boss!"
]
</pre>

## MimSMS

<pre>
use Radon\LaravelBDSms\Provider\MimSms;
use Radon\LaravelBDSms\Sender;

$sender = Sender::getInstance();
$sender->setProvider(MimSms::class);
$sender->setMobile('017XXYYZZAA');
$sender->setMessage('This is test message');
$sender->setQueue(true); //if you want to sent sms from queue
$sender->setConfig(
   [
       'api_key' => 'api_key_goes_here',
       'type' => 'text',
       'senderid' => 'approved_send_id',
   ]
);

$status = $sender->send();
</pre>


# Currently Supported SMS Gateways

| Provider        | Credentials  Required <br>    For Sending SMS                     | Status | Comment                | Contact                                                     |
|-----------------|-------------------------------------------------------------------|--------|------------------------|-------------------------------------------------------------|
| AjuraTech       | apikey, secretkey , callerID                                      | Done   | -                      | -                                                           |
| Adn             | api_key, type, senderid                                           | Done   | -                      | -                                                           |
| Banglalink      | userID, passwd , sender                                           | Done   | -                      | -                                                           |
| BDBulkSMS       | token                                                             | Done   | -                      | -                                                           |
| BoomCast        | masking  , userName ,   password                                  | Done   | -                      | -                                                           |
| BulksmsBD       | username, password                                                | Done   | -                      | -                                                           |
| DianaHost       | api_key, type, senderid                                           | Done   | -                      | -                                                           |
| DianaSMS        | ApiKey, ClientId, SenderId                                        | Done   | -                      | -                                                           |
| Esms            | api_token, sender_id                                              | Done   | -                      | -                                                           |
| ElitBuzz        | api_key, type, senderid                                           | Done   | not tested yet in live | -                                                           |
| Infobip         | user, password                                                    | Done   | not tested yet in live | -                                                           |
| MDL             | api_key, type, senderid                                           | Done   | not tested yet in live | -                                                           |
| Metronet        | api_key, mask                                                     | Done   | -                      | -                                                           |
| MimSms          | api_key, type, senderid                                           | Done   | -                      | -                                                           |
| Mobireach       | Username,Password, From                                           | Done   | -                      | -                                                           |
| NovocomBD       | ApiKey , ClientId   , SenderId                                    | Done   | -                      | -                                                           |
| OnnoRokomSMS    | userName, userPassword, type, maskName, campaignName              | Done   | not tested yet in live | -                                                           |
| SmartLabSMS     | user, password, sender                                            | Done   | -                      | -                                                           |
| SMSNet24        | user_id, user_password, route_id(optional), sms_type_id(optional) | Done   | -                      | admin2@digitallabbd.com, +880 1705 691269, +880 1733393 712 |
| Sslsms          | api_token, sid, csms_id                                           | Done   | -                      | -                                                           |
| Tense           | user, password, campaign, masking                                 | Done   | -                      | -                                                           |
| TwentyFourSmsBD | apiKey, sender_id                                                 | Done   | -                      | -                                                           |
| Viatech         | api_key, mask                                                     | Done   | -                      | -                                                           |

