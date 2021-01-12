<?php
require '../vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;

$subdomain = "testtaskzendrelokia";
$username = "dedblood94@gmail.com";
$token = "i7TxfFLN7ks68H2eWFdKIdv3oJc1HtObw3zYPy54";

$client = New ZendeskAPI($subdomain);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);

$tickets = $client->tickets()->findAll();

$users = $client->users()->findAll();

$groups = $client->groups()->findAll();

$organizations = $client->organizations()->findAll();

$contacts = $client->supportAddresses()->findAll();

$fp = fopen('../export/file.csv', 'w');

foreach ($tickets->tickets as $ticket) {

    $arrayForTickets = [
        'Ticket ID' => $ticket->id,
        'Description' => $ticket->description,
        'Status' => $ticket->status,
        'Priority'=> $ticket->priority,
];
    fputcsv($fp , $arrayForTickets);
}
foreach ($users->users as $user) {
    $arrayForUsers = [
        'Agent ID' => $user->id,
        'Agent Name' => $user->name,
        'Agent Email' => $user->email,
    ];
    fputcsv($fp, $arrayForUsers);
}
foreach ($contacts->recipient_addresses as $contact) {
    $arrayForContacts = [
        'Contact ID' => $contact->id,
        'Contact Name' => $contact->name,
        'Contact Email' => $contact->email,
    ];
    fputcsv($fp, $arrayForContacts);
}
foreach ($groups->groups as $group) {
    $arrayForGroups = [
        'Group ID' => $group->id,
        'Group Name' => $group->name,
    ];
    fputcsv($fp, $arrayForGroups);
}
foreach ($organizations->organizations as $organization) {
    $arrayForOrganizations = [
        'Company ID' => $organization->id,
        'Company Name' => $organization->name,
    ];
    fputcsv($fp, $arrayForOrganizations);
}
fclose($fp);
