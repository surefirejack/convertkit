# Convertkit SDK

This is the (unofficial) ConvertKit SDK for working with the ConvertKit API

We created this for the API integration with our software, Deadline Funnel (https://deadlinefunnel.com).

## Install 

Either download and include, or install via Composer:

```
composer require surefirejack/convertkit
```

## Make a simple request

Create a new ConvertKit object with 

1. Your user's API Key
2. Your user's API Secret Key

```php
require_once __DIR__.'/vendor/autoload.php';

use ConvertKit\ConvertKit;

$apiKey = 'api-key-here';
$apiSecretKey = 'api-secret-key-here';

$ck = new ConvertKit($apiKey, $apiSecretKey);

```

List all sequences:

```php
$sequences = $ck->sequence();
$response = $sequences->showall();
print_r($response);
```

List all subscribers:

```php
$subscriber = $ck->subscriber();
$response = $subscriber->showall();
print_r($response);

// Show the details of the first subscriber returned
$firstName = $response->subscribers[0]->first_name;
$email = $response->subscribers[0]->email_address;
$fieldsObject = $response->subscribers[0]->fields;
```

View details of a specific subscriber

```php
$subscriberId = 123456;
$response = $ck->subscriber($subscriberId)->view();
print_r($response);
```

Update a subscriber's custom fields

```php

$subscriberId = 123456;
$customFields = array(
  'fields' => array(
      'deadlinetext' => 'Jan 22 2018'
  )
);

$response = $ck->subscriber($subscriberId)->update($customFields);


print_r($response);
```

View all forms

```php
$response = $ck->form()->showall();
print_r($response);
```

View all custom fields

```php
$response = $ck->customfield()->showall();
print_r($response);

```

Delete a custom field

```php
$customFieldId = 567;

$customfield = $ck->customfield();
$response = $customfield->delete($customFieldId);

print_r($response);
```

Add webhook

```php
// Register a webhook to be pinged when a subscriber recieves a tag
$tagId = 789;
$webhookUrl = "http://example.com/incoming";

$params = array(
    "target_url" => $webhookUrl,
    "event" => array(
        'name' => 'subscriber.tag_add',
        'tag_id'=> $tagId
    )

);

$webhook = $ck->webhook();
$response = $webhook->add($params);
print_r($response);

```


